<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

require_once 'includes/header.php';
require_once 'includes/db_functions.php';

// Temporary code to check packaging_boxes table structure
if (isset($_GET['check_table'])) {
    echo "<div class='container mt-4'>";
    echo "<h2>Packaging Boxes Table Structure</h2>";
    
    try {
        // Show table structure
        $sql = "DESCRIBE packaging_boxes";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $columns = $stmt->fetchAll();
        
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr></thead><tbody>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>{$column['Field']}</td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>{$column['Key']}</td>";
            echo "<td>{$column['Default']}</td>";
            echo "<td>{$column['Extra']}</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        
        // Show sample data
        $sql = "SELECT * FROM packaging_boxes LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            echo "<h3>Sample Data</h3>";
            echo "<table class='table table-bordered'>";
            echo "<thead><tr>";
            foreach (array_keys($row) as $key) {
                echo "<th>$key</th>";
            }
            echo "</tr></thead><tbody><tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr></tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No data found in packaging_boxes table.</div>";
        }
        
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
    
    echo "<a href='dispatch.php' class='btn btn-primary'>Back to Dispatch</a>";
    echo "</div>";
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: dispatch.php');
        exit;
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_dispatch') {
        // Sanitize input
        $po_id = (int)$_POST['po_number'];
        $customer_id = (int)$_POST['customer_id'];
        $dispatch_date = sanitizeInput($_POST['dispatch_date']);
        $transporter = sanitizeInput($_POST['transport_details'] ?? '');
        $vehicle_number = '';
        $invoice_number = sanitizeInput($_POST['invoice_number'] ?? '');
        $notes = sanitizeInput($_POST['notes'] ?? '');
        $status = 'prepared';
        $product_ids = $_POST['product_id'];
        $quantities = $_POST['quantity'];
        // Optionally, add weight/boxes fields if present
        $weights = $_POST['weight_kg'] ?? [];
        $boxes_used = $_POST['boxes_used'] ?? [];

        // Validate that each quantity does not exceed remaining dispatchable quantity
        foreach ($product_ids as $idx => $product_id) {
            $product_id = (int)$product_id;
            $quantity = (int)($quantities[$idx] ?? 0);
            // Get fettling output
            $sql = "SELECT COALESCE(SUM(output_quantity), 0) FROM fettling WHERE po_id = ? AND product_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$po_id, $product_id]);
            $fettling_output = (int)($stmt->fetchColumn() ?: 0);
            // Get already dispatched
            $sql = "SELECT COALESCE(SUM(quantity), 0) FROM dispatch_items WHERE po_id = ? AND product_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$po_id, $product_id]);
            $already_dispatched = (int)($stmt->fetchColumn() ?: 0);
            $remaining = $fettling_output - $already_dispatched;
            if ($quantity > $remaining) {
                setAlert("Cannot dispatch more than available quantity for product ID $product_id. Allowed: $remaining", 'danger');
                header('Location: dispatch.php');
                exit;
            }
        }

        // Calculate totals (simple sum, or set to 0 if not available)
        $total_boxes = is_array($boxes_used) && count($boxes_used) ? array_sum($boxes_used) : 0;
        $total_weight_kg = is_array($weights) && count($weights) ? array_sum($weights) : 0;

        // Begin transaction
        $pdo->beginTransaction();
        try {
            // Insert into dispatch table
            $sql = "INSERT INTO dispatch (dispatch_number, po_id, customer_id, date, transporter, vehicle_number, total_boxes, total_weight_kg, invoice_number, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $dispatch_number = 'D' . date('YmdHis');
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $dispatch_number, $po_id, $customer_id, $dispatch_date, $transporter, $vehicle_number, $total_boxes, $total_weight_kg, $invoice_number, $status
            ]);
            $dispatch_id = $pdo->lastInsertId();

            // Insert each product/quantity into dispatch_items
            foreach ($product_ids as $idx => $product_id) {
                $product_id = (int)$product_id;
                $quantity = (int)($quantities[$idx] ?? 0);
                $weight = isset($weights[$idx]) ? (float)$weights[$idx] : 0;
                $boxes = isset($boxes_used[$idx]) ? (int)$boxes_used[$idx] : 0;
                if ($product_id && $quantity) {
                    $sql = "INSERT INTO dispatch_items (dispatch_id, po_id, product_id, quantity, weight_kg, boxes_used) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$dispatch_id, $po_id, $product_id, $quantity, $weight, $boxes]);
                }
            }

            $pdo->commit();
            setAlert("Dispatch created successfully.", 'success');

            // After successful dispatch creation, check if all parts for this PO are fully dispatched
            $sql = "SELECT pop.product_id, pop.quantity
                    FROM purchase_order_products pop
                    WHERE pop.purchase_order_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$po_id]);
            $allDispatched = true;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $product_id = $row['product_id'];
                $required_qty = (float)$row['quantity'];
                // Get total dispatched for this part
                $stmt2 = $pdo->prepare("SELECT COALESCE(SUM(quantity), 0) FROM dispatch_items WHERE po_id = ? AND product_id = ?");
                $stmt2->execute([$po_id, $product_id]);
                $dispatched_qty = (float)($stmt2->fetchColumn() ?: 0);
                if ($dispatched_qty < $required_qty - 0.001) {
                    $allDispatched = false;
                    break;
                }
            }
            if ($allDispatched) {
                $stmt = $pdo->prepare("UPDATE purchase_orders SET status = 'completed' WHERE id = ?");
                $stmt->execute([$po_id]);
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            setAlert("Error: " . $e->getMessage(), 'danger');
        }
        header('Location: dispatch.php');
        exit;
    }
    elseif ($action === 'update_dispatch') {
        $id = (int)$_POST['id'];
        $transporter = sanitizeInput($_POST['transport_details']);
        $notes = sanitizeInput($_POST['notes']);
        
        // Update dispatch (removed updated_at)
        $sql = "UPDATE dispatch SET 
                transporter = ?, 
                notes = ? 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$transporter, $notes, $id]);
        
        if ($result) {
            setAlert("Dispatch updated successfully.", 'success');
        } else {
            setAlert("Error updating dispatch.", 'danger');
        }
        
        header('Location: dispatch.php');
        exit;
    }
    elseif ($action === 'delete_dispatch') {
        $id = (int)$_POST['id'];
        
        // Get dispatch details
        $sql = "SELECT * FROM dispatch WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $dispatch = $stmt->fetch();
        
        if (!$dispatch) {
            setAlert("Dispatch not found.", 'danger');
            header('Location: dispatch.php');
            exit;
        }
        
        // Begin transaction
        $pdo->beginTransaction();
        
        try {
            // Return packaging boxes to stock
            $sql = "UPDATE packaging_boxes 
                    SET current_stock = current_stock + ?, updated_at = NOW() 
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$dispatch['quantity'], $dispatch['packaging_box_id']]);
            
            if (!$result) {
                throw new Exception("Failed to update packaging box stock");
            }
            
            // Update purchase order status if needed
            $sql = "SELECT * FROM purchase_orders WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$dispatch['purchase_order_id']]);
            $po = $stmt->fetch();
            
            if ($po && $po['status'] === 'completed') {
                // Check if there are other dispatches for this PO
                $sql = "SELECT COUNT(*) as count FROM dispatch WHERE purchase_order_id = ? AND id != ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$dispatch['purchase_order_id'], $id]);
                $result = $stmt->fetch();
                
                if ($result['count'] === 0) {
                    // No other dispatches, set PO status back to in_progress
                    $sql = "UPDATE purchase_orders SET status = 'in_progress', updated_at = NOW() WHERE id = ?";
                    $stmt = $pdo->prepare($sql);
                    $result = $stmt->execute([$dispatch['purchase_order_id']]);
                    
                    if (!$result) {
                        throw new Exception("Failed to update purchase order status");
                    }
                }
            }
            
            // Delete dispatch
            $sql = "DELETE FROM dispatch WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$id]);
            
            if (!$result) {
                throw new Exception("Failed to delete dispatch");
            }
            
            // Commit transaction
            $pdo->commit();
            
            setAlert("Dispatch deleted successfully.", 'success');
        } catch (Exception $e) {
            // Rollback transaction on error
            $pdo->rollBack();
            setAlert("Error: " . $e->getMessage(), 'danger');
        }
        
        header('Location: dispatch.php');
        exit;
    }
}

// Fetch all dispatches
$sql = "SELECT d.*, po.po_number, c.name as customer_name FROM dispatch d JOIN purchase_orders po ON d.po_id = po.id JOIN customers c ON d.customer_id = c.id ORDER BY d.date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$dispatches = $stmt->fetchAll();

// Fetch all dispatch items for all dispatches
$dispatchIds = array_column($dispatches, 'id');
$itemsByDispatch = [];
if ($dispatchIds) {
    $in = str_repeat('?,', count($dispatchIds) - 1) . '?';
    $sql = "SELECT di.*, p.name as product_name FROM dispatch_items di JOIN products p ON di.product_id = p.id WHERE di.dispatch_id IN ($in) ORDER BY di.dispatch_id, di.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($dispatchIds);
    foreach ($stmt->fetchAll() as $item) {
        $itemsByDispatch[$item['dispatch_id']][] = $item;
    }
}

// Get pending purchase orders for dispatch
$sql = "SELECT po.*, 
        c.name as customer_name, 
        p.name as product_name,
        p.unit
        FROM purchase_orders po
        JOIN customers c ON po.customer_id = c.id
        JOIN products p ON po.product_id = p.id
        WHERE po.status IN ('in_progress', 'pending')
        ORDER BY po.delivery_date";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pending_orders = $stmt->fetchAll();

// Get packaging boxes with stock
$sql = "SELECT * FROM packaging_boxes WHERE current_stock > 0 ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$boxes = $stmt->fetchAll();

// Map the field names for compatibility
foreach ($boxes as &$box) {
    // No need to map fields since the table already has the correct field names
}
unset($box); // Break the reference

// Fetch all available purchase orders for the dropdown (with customer_id)
$poStmt = $pdo->query("SELECT id, po_number, customer_id FROM purchase_orders ORDER BY created_at DESC");
$availablePOs = $poStmt->fetchAll();

// Filter out POs where all parts are fully dispatched
$filteredPOs = [];
foreach ($availablePOs as $po) {
    $po_id = $po['id'];
    // Get all parts for this PO
    $sql = "SELECT pop.product_id FROM purchase_order_products pop WHERE pop.purchase_order_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$po_id]);
    $parts = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $has_dispatchable = false;
    foreach ($parts as $product_id) {
        // Get fettling output
        $sql = "SELECT COALESCE(SUM(output_quantity), 0) FROM fettling WHERE po_id = ? AND product_id = ?";
        $stmt2 = $pdo->prepare($sql);
        $stmt2->execute([$po_id, $product_id]);
        $fettling_output = (float)($stmt2->fetchColumn() ?: 0);
        // Get already dispatched
        $sql = "SELECT COALESCE(SUM(quantity), 0) FROM dispatch_items WHERE po_id = ? AND product_id = ?";
        $stmt2 = $pdo->prepare($sql);
        $stmt2->execute([$po_id, $product_id]);
        $already_dispatched = (float)($stmt2->fetchColumn() ?: 0);
        if ($fettling_output - $already_dispatched > 0.001) {
            $has_dispatchable = true;
            break;
        }
    }
    if ($has_dispatchable) {
        $filteredPOs[] = $po;
    }
}
$availablePOs = $filteredPOs;
?>

    <div class="container mt-4">
        <?php
        // Check if gate_pass_number column exists
        $sql = "SHOW COLUMNS FROM dispatch LIKE 'gate_pass_number'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $column_exists = $stmt->fetch();
        
        if (!$column_exists) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Database Update Required!</strong> Please <a href="add_gate_pass_column.php" class="alert-link">click here</a> to add the gate pass column to the database.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dispatch Management</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDispatchModal">
                <i class="fas fa-plus me-1"></i> Create Dispatch
            </button>
        </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Dispatch List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Dispatch Date</th>
                            <th>PO Number</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Packaging</th>
                            <th>Transport Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($dispatches) > 0): ?>
                            <?php foreach ($dispatches as $dispatch):
                                $items = $itemsByDispatch[$dispatch['id']] ?? [];
                                $rowspan = max(1, count($items));
                                $first = true;
                                foreach ($items as $item): ?>
                                    <tr>
                                        <?php if ($first): ?>
                                            <td rowspan="<?= $rowspan ?>"><?php echo formatDate($dispatch['date']); ?></td>
                                            <td rowspan="<?= $rowspan ?>"><?php echo htmlspecialchars($dispatch['po_number'] ?? ''); ?></td>
                                            <td rowspan="<?= $rowspan ?>"><?php echo htmlspecialchars($dispatch['customer_name'] ?? ''); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo htmlspecialchars($item['product_name'] ?? ''); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <?php if ($first): ?>
                                            <td rowspan="<?= $rowspan ?>"><?php echo htmlspecialchars($dispatch['total_boxes'] ?? ''); ?></td>
                                            <td rowspan="<?= $rowspan ?>"><?php echo htmlspecialchars($dispatch['transporter'] ?? ''); ?></td>
                                            <td rowspan="<?= $rowspan ?>">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewDispatchModal" 
                                                            data-dispatch-id="<?php echo $dispatch['id']; ?>"
                                                            data-dispatch-date="<?php echo formatDate($dispatch['date']); ?>"
                                                            data-po-number="<?php echo htmlspecialchars($dispatch['po_number'] ?? ''); ?>"
                                                            data-customer="<?php echo htmlspecialchars($dispatch['customer_name'] ?? ''); ?>"
                                                            data-product="<?php echo htmlspecialchars($item['product_name'] ?? ''); ?>"
                                                            data-quantity="<?php echo $item['quantity']; ?>"
                                                            data-box="<?php echo htmlspecialchars($dispatch['total_boxes'] ?? ''); ?>"
                                                            data-transport="<?php echo htmlspecialchars($dispatch['transporter'] ?? ''); ?>"
                                                            data-notes="<?php echo htmlspecialchars($dispatch['notes'] ?? ''); ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDispatchModal" 
                                                            data-dispatch-id="<?php echo $dispatch['id']; ?>"
                                                            data-transport="<?php echo htmlspecialchars($dispatch['transporter'] ?? ''); ?>"
                                                            data-notes="<?php echo htmlspecialchars($dispatch['notes'] ?? ''); ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="gate_pass.php?id=<?php echo $dispatch['id']; ?>" class="btn btn-success" title="Generate Gate Pass">
                                                        <i class="fas fa-qrcode"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDispatchModal" 
                                                            data-dispatch-id="<?php echo $dispatch['id']; ?>"
                                                            data-po-number="<?php echo htmlspecialchars($dispatch['po_number'] ?? ''); ?>"
                                                            data-customer="<?php echo htmlspecialchars($dispatch['customer_name'] ?? ''); ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        <?php endif; $first = false; ?>
                                    </tr>
                                <?php endforeach;
                                if (!$items): // No items, show empty row ?>
                                    <tr>
                                        <td><?php echo formatDate($dispatch['date']); ?></td>
                                        <td><?php echo htmlspecialchars($dispatch['po_number'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($dispatch['customer_name'] ?? ''); ?></td>
                                        <td colspan="5" class="text-center">No products</td>
                                    </tr>
                                <?php endif;
                            endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No dispatches found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Dispatch Modal -->
<div class="modal fade" id="createDispatchModal" tabindex="-1" aria-labelledby="createDispatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDispatchModalLabel">Create New Dispatch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="dispatch.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="create_dispatch">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="po_number" class="form-label">PO Number</label>
                            <select class="form-select" id="po_number" name="po_number">
                                <option value="">Select PO Number</option>
                                <?php foreach ($availablePOs as $po): ?>
                                    <option value="<?= $po['id'] ?>" data-customer-id="<?= $po['customer_id'] ?>"><?= htmlspecialchars($po['po_number']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                <?php 
                                $sql = "SELECT id, name FROM customers ORDER BY name";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $customers = $stmt->fetchAll();
                                foreach ($customers as $customer): ?>
                                    <option value="<?php echo $customer['id']; ?>">
                                        <?php echo htmlspecialchars($customer['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div id="productRows">
                        <div class="row mb-3 product-row">
                            <div class="col-md-8">
                                <label for="product_id_0" class="form-label">Product</label>
                                <select class="form-select product-select" id="product_id_0" name="product_id[]" required>
                                    <option value="">Select Product</option>
                                    <?php 
                                    $sql = "SELECT id, name, unit FROM products ORDER BY name";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    $products = $stmt->fetchAll();
                                    foreach ($products as $product): ?>
                                        <option value="<?php echo $product['id']; ?>" data-unit="<?php echo htmlspecialchars($product['unit']); ?>">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="quantity_0" class="form-label">Quantity</label>
                                <div class="input-group">
                                    <input type="number" class="form-control quantity-input" id="quantity_0" name="quantity[]" min="1" required>
                                    <span class="input-group-text quantity-unit"></span>
                                </div>
                                <div class="form-text quantity-info"></div>
                            </div>
                            <!-- Remove button, hidden for first row -->
                            <div class="col-12 text-end mt-1">
                                <button type="button" class="btn btn-danger btn-sm remove-product-row" style="display:none;"><i class="fas fa-trash"></i> Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mb-3" id="addProductRow"><i class="fas fa-plus-circle"></i> Add Product</button>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dispatch_date" class="form-label">Dispatch Date</label>
                            <input type="date" class="form-control" id="dispatch_date" name="dispatch_date" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="packaging_box_id" class="form-label">Packaging Box</label>
                        <select class="form-select" id="packaging_box_id" name="packaging_box_id" required>
                            <option value="">Select Packaging Box</option>
                            <?php foreach ($boxes as $box): ?>
                                <option value="<?php echo $box['id']; ?>" data-stock="<?php echo $box['current_stock']; ?>">
                                    <?php echo htmlspecialchars($box['name']); ?> 
                                    (<?php echo $box['length'] . '×' . $box['width'] . '×' . $box['height']; ?> cm) - 
                                    Stock: <?php echo $box['current_stock']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text" id="box-info"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="transport_details" class="form-label">Transport Details</label>
                        <input type="text" class="form-control" id="transport_details" name="transport_details" placeholder="Transporter name, vehicle number, etc." required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="create-dispatch-btn">Create Dispatch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Dispatch Modal -->
<div class="modal fade" id="viewDispatchModal" tabindex="-1" aria-labelledby="viewDispatchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDispatchModalLabel">Dispatch Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Dispatch Date:</th>
                        <td id="view-dispatch-date"></td>
                    </tr>
                    <tr>
                        <th>PO Number:</th>
                        <td id="view-po-number"></td>
                    </tr>
                    <tr>
                        <th>Customer:</th>
                        <td id="view-customer"></td>
                    </tr>
                    <tr>
                        <th>Product:</th>
                        <td id="view-product"></td>
                    </tr>
                    <tr>
                        <th>Quantity:</th>
                        <td id="view-quantity"></td>
                    </tr>
                    <tr>
                        <th>Packaging Box:</th>
                        <td id="view-box"></td>
                    </tr>
                    <tr>
                        <th>Transport Details:</th>
                        <td id="view-transport"></td>
                    </tr>
                    <tr>
                        <th>Notes:</th>
                        <td id="view-notes"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Dispatch Modal -->
<div class="modal fade" id="editDispatchModal" tabindex="-1" aria-labelledby="editDispatchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDispatchModalLabel">Edit Dispatch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="dispatch.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_dispatch">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="mb-3">
                        <label for="edit_transport_details" class="form-label">Transport Details</label>
                        <input type="text" class="form-control" id="edit_transport_details" name="transport_details" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="2"></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <small>Note: Only transport details and notes can be edited. To change other details, please delete this dispatch and create a new one.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Dispatch</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Dispatch Modal -->
<div class="modal fade" id="deleteDispatchModal" tabindex="-1" aria-labelledby="deleteDispatchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDispatchModalLabel">Delete Dispatch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="dispatch.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_dispatch">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="delete_id">
                    
                    <p>Are you sure you want to delete dispatch for PO: <strong id="delete_po"></strong> to customer: <strong id="delete_customer"></strong>?</p>
                    <p class="text-danger"><strong>Warning:</strong> This will return packaging boxes to stock and may change the purchase order status.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create Dispatch Modal
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const quantityUnit = document.getElementById('quantity-unit');
    const quantityInfo = document.getElementById('quantity-info');
    const packagingBoxSelect = document.getElementById('packaging_box_id');
    const boxInfo = document.getElementById('box-info');
    const createDispatchBtn = document.getElementById('create-dispatch-btn');
    
    if (productSelect) {
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const unit = selectedOption.getAttribute('data-unit');
                
                quantityUnit.textContent = unit;
                quantityInput.value = 1; // Default to 1
                quantityInfo.textContent = `Enter the quantity in ${unit}`;
            } else {
                quantityUnit.textContent = '';
                quantityInput.value = '';
                quantityInfo.textContent = '';
            }
        });
    }
    
    if (packagingBoxSelect) {
        packagingBoxSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const stock = parseInt(selectedOption.getAttribute('data-stock'));
                
                boxInfo.textContent = `Available stock: ${stock} boxes`;
                
                // Check if quantity is greater than stock
                if (quantityInput.value && parseInt(quantityInput.value) > stock) {
                    boxInfo.innerHTML = `<span class="text-danger">Warning: Dispatch quantity (${quantityInput.value}) exceeds available box stock (${stock})</span>`;
                    createDispatchBtn.disabled = true;
                } else {
                    createDispatchBtn.disabled = false;
                }
            } else {
                boxInfo.textContent = '';
            }
        });
    }
    
    if (quantityInput) {
        quantityInput.addEventListener('input', function() {
            if (packagingBoxSelect.value) {
                const selectedOption = packagingBoxSelect.options[packagingBoxSelect.selectedIndex];
                const stock = parseInt(selectedOption.getAttribute('data-stock'));
                
                // Check if quantity is greater than stock
                if (this.value && parseInt(this.value) > stock) {
                    boxInfo.innerHTML = `<span class="text-danger">Warning: Dispatch quantity (${this.value}) exceeds available box stock (${stock})</span>`;
                    createDispatchBtn.disabled = true;
                } else {
                    boxInfo.textContent = `Available stock: ${stock} boxes`;
                    createDispatchBtn.disabled = false;
                }
            }
        });
    }
    
    // Set today's date as default for dispatch date
    const dispatchDateInput = document.getElementById('dispatch_date');
    if (dispatchDateInput) {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        dispatchDateInput.value = `${year}-${month}-${day}`;
    }
    
    // View Dispatch Modal
    const viewDispatchModal = document.getElementById('viewDispatchModal');
    if (viewDispatchModal) {
        viewDispatchModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('view-dispatch-date').textContent = button.getAttribute('data-dispatch-date');
            document.getElementById('view-po-number').textContent = button.getAttribute('data-po-number');
            document.getElementById('view-customer').textContent = button.getAttribute('data-customer');
            document.getElementById('view-product').textContent = button.getAttribute('data-product');
            document.getElementById('view-quantity').textContent = button.getAttribute('data-quantity');
            document.getElementById('view-box').textContent = button.getAttribute('data-box');
            document.getElementById('view-transport').textContent = button.getAttribute('data-transport');
            document.getElementById('view-notes').textContent = button.getAttribute('data-notes');
        });
    }
    
    // Edit Dispatch Modal
    const editDispatchModal = document.getElementById('editDispatchModal');
    if (editDispatchModal) {
        editDispatchModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('edit_id').value = button.getAttribute('data-dispatch-id');
            document.getElementById('edit_transport_details').value = button.getAttribute('data-transport');
            document.getElementById('edit_notes').value = button.getAttribute('data-notes');
        });
    }
    
    // Delete Dispatch Modal
    const deleteDispatchModal = document.getElementById('deleteDispatchModal');
    if (deleteDispatchModal) {
        deleteDispatchModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('delete_id').value = button.getAttribute('data-dispatch-id');
            document.getElementById('delete_po').textContent = button.getAttribute('data-po-number');
            document.getElementById('delete_customer').textContent = button.getAttribute('data-customer');
        });
    }

    const productRows = document.getElementById('productRows');
    const addProductRowBtn = document.getElementById('addProductRow');
    let productRowIdx = 1;

    function updateRemoveButtons() {
        const rows = productRows.querySelectorAll('.product-row');
        rows.forEach((row, idx) => {
            const removeBtn = row.querySelector('.remove-product-row');
            removeBtn.style.display = rows.length > 1 ? '' : 'none';
        });
    }

    addProductRowBtn.addEventListener('click', function() {
        const poId = document.getElementById('po_number').value;
        fetch('ajax_get_dispatchable_po_parts.php?po_id=' + encodeURIComponent(poId))
            .then(res => res.json())
            .then(data => {
                const firstRow = productRows.querySelector('.product-row');
                const newRow = firstRow.cloneNode(true);
                // Clear values and update IDs/names
                const productSelect = newRow.querySelector('.product-select');
                const quantityInput = newRow.querySelector('.quantity-input');
                const quantityUnit = newRow.querySelector('.quantity-unit');
                const quantityInfo = newRow.querySelector('.quantity-info');
                productSelect.value = '';
                productSelect.id = 'product_id_' + productRowIdx;
                quantityInput.value = '';
                quantityInput.id = 'quantity_' + productRowIdx;
                quantityUnit.textContent = '';
                quantityInfo.textContent = '';
                newRow.querySelector('.remove-product-row').style.display = '';
                // Set product options for this row
                productSelect.innerHTML = buildProductOptions(data.success && Array.isArray(data.parts) ? data.parts : []);
                productRows.appendChild(newRow);
                productRowIdx++;
                updateRemoveButtons();
            });
    });

    productRows.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product-row')) {
            const row = e.target.closest('.product-row');
            row.remove();
            updateRemoveButtons();
        }
    });

    // Dynamic unit and info for each row
    function handleProductChange(e) {
        const row = e.target.closest('.product-row');
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const quantityUnit = row.querySelector('.quantity-unit');
        const quantityInfo = row.querySelector('.quantity-info');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption.value) {
            const unit = selectedOption.getAttribute('data-unit');
            quantityUnit.textContent = unit;
            quantityInput.value = 1;
            quantityInfo.textContent = `Enter the quantity in ${unit}`;
        } else {
            quantityUnit.textContent = '';
            quantityInput.value = '';
            quantityInfo.textContent = '';
        }
    }
    productRows.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            handleProductChange(e);
        }
    });
    // Initial setup for first row
    updateRemoveButtons();

    const poNumberSelect = document.getElementById('po_number');
    const customerSelect = document.getElementById('customer_id');
    if (poNumberSelect && customerSelect) {
        poNumberSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const customerId = selectedOption.getAttribute('data-customer-id');
            if (customerId) {
                customerSelect.value = customerId;
            } else {
                customerSelect.value = '';
            }
            fetchProductsForPO(this.value);
        });
    }

    // Helper to build product options with remaining qty
    function buildProductOptions(parts) {
        let options = '<option value="">Select Product</option>';
        if (Array.isArray(parts)) {
            parts.forEach(function(part) {
                options += `<option value="${part.id}" data-unit="${part.unit}" data-remaining="${part.remaining}">${part.name} (Remaining: ${part.remaining})</option>`;
            });
        }
        return options;
    }

    // Update all product dropdowns with new options
    function updateAllProductDropdowns(parts) {
        const selects = productRows.querySelectorAll('.product-select');
        selects.forEach(function(select) {
            const currentValue = select.value;
            select.innerHTML = buildProductOptions(parts);
            // Try to keep previous selection if still available
            if (currentValue && Array.isArray(parts) && parts.some(p => p.id == currentValue)) {
                select.value = currentValue;
            }
        });
    }

    // Fetch products for selected PO (dispatchable only)
    function fetchProductsForPO(poId) {
        if (!poId) {
            updateAllProductDropdowns([]);
            return;
        }
        fetch('ajax_get_dispatchable_po_parts.php?po_id=' + encodeURIComponent(poId))
            .then(res => res.json())
            .then(data => {
                if (data.success && Array.isArray(data.parts)) {
                    updateAllProductDropdowns(data.parts);
                } else {
                    updateAllProductDropdowns([]);
                }
            })
            .catch(() => {
                updateAllProductDropdowns([]);
            });
    }

    // On page load, if a PO is preselected, fetch its products for all dropdowns
    if (poNumberSelect.value) {
        fetchProductsForPO(poNumberSelect.value);
    }

    // When PO changes, update all product dropdowns
    if (poNumberSelect && customerSelect) {
        poNumberSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const customerId = selectedOption.getAttribute('data-customer-id');
            if (customerId) {
                customerSelect.value = customerId;
            } else {
                customerSelect.value = '';
            }
            fetchProductsForPO(this.value);
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
