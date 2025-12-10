<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Check if product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setAlert("Product ID is required.", 'danger');
    header('Location: products.php');
    exit;
}

$product_id = (int)$_GET['id'];

// Get product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    setAlert("Product not found.", 'danger');
    header('Location: products.php');
    exit;
}

// Get BOM items for this product
$bom_items = [];
try {
    $sql = "SELECT b.material_id, 
            b.quantity_per_unit as quantity, 
            m.name as material_name, 
            m.unit as material_unit, 
            m.type as material_type,
            COALESCE(m.stock_qty, 0) as material_stock 
            FROM bom_items b 
            JOIN materials m ON b.material_id = m.id 
            WHERE b.product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $bom_items = $stmt->fetchAll();
} catch (Exception $e) {
    // If there's an error, just continue with an empty array
    $bomError = "<!-- Error getting BOM items: " . htmlspecialchars($e->getMessage()) . " -->";
}

// Get all materials for BOM selection
$materials = [];
try {
    $sql = "SELECT * FROM materials ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $materials = $stmt->fetchAll();
} catch (Exception $e) {
    $materialsError = "<!-- Error getting materials: " . htmlspecialchars($e->getMessage()) . " -->";
}

// Get purchase orders for this product
$purchase_orders = [];
try {
    $sql = "SELECT po.id, 
            po.po_number, 
            po.customer_id, 
            po.product_id, 
            COALESCE(po.quantity, 0) as quantity, 
            COALESCE(po.unit, 'nos') as unit, 
            COALESCE(po.status, 'pending') as status, 
            po.delivery_date, 
            c.name as customer_name 
            FROM purchase_orders po 
            JOIN customers c ON po.customer_id = c.id 
            WHERE po.product_id = ? 
            ORDER BY po.delivery_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $purchase_orders = $stmt->fetchAll();
} catch (Exception $e) {
    $poError = "<!-- Error getting purchase orders: " . htmlspecialchars($e->getMessage()) . " -->";
}

// Check database schema for purchase_orders table
try {
    $schemaQuery = "DESCRIBE purchase_orders";
    $schemaStmt = $pdo->prepare($schemaQuery);
    $schemaStmt->execute();
    $columns = $schemaStmt->fetchAll(PDO::FETCH_ASSOC);
    $columnInfo = [];
    foreach ($columns as $column) {
        $columnInfo[] = "{$column['Field']} ({$column['Type']})";
    }
    $schemaInfo = "<!-- purchase_orders table schema: " . implode(", ", $columnInfo) . " -->";
} catch (Exception $e) {
    $schemaInfo = "<!-- Error checking schema: " . htmlspecialchars($e->getMessage()) . " -->";
}

// Check database schema for bom_items table
try {
    $bomSchemaQuery = "DESCRIBE bom_items";
    $bomSchemaStmt = $pdo->prepare($bomSchemaQuery);
    $bomSchemaStmt->execute();
    $bomColumns = $bomSchemaStmt->fetchAll(PDO::FETCH_ASSOC);
    $bomColumnInfo = [];
    foreach ($bomColumns as $column) {
        $bomColumnInfo[] = "{$column['Field']} ({$column['Type']})";
    }
    $bomSchemaInfo = "<!-- bom_items table schema: " . implode(", ", $bomColumnInfo) . " -->";
} catch (Exception $e) {
    $bomSchemaInfo = "<!-- Error checking bom_items schema: " . htmlspecialchars($e->getMessage()) . " -->";
}

// Debug the first purchase order
if (!empty($purchase_orders)) {
    $firstPO = $purchase_orders[0];
    $poDebug = "<!-- First PO data: ";
    foreach ($firstPO as $key => $value) {
        $poDebug .= "$key: " . (is_null($value) ? "NULL" : htmlspecialchars($value)) . ", ";
    }
    $poDebug .= " -->";
} else {
    $poDebug = "<!-- No purchase orders found -->";
}

// Debug the first BOM item
if (!empty($bom_items)) {
    $firstBomItem = $bom_items[0];
    $bomDebug = "<!-- First BOM item data: ";
    foreach ($firstBomItem as $key => $value) {
        $bomDebug .= "$key: " . (is_null($value) ? "NULL" : htmlspecialchars($value)) . ", ";
    }
    $bomDebug .= " -->";
} else {
    $bomDebug = "<!-- No BOM items found -->";
}

// Fetch hit box details for this product
$hit_box = null;
if (!empty($product['hit_box_id'])) {
    $sql = "SELECT * FROM hit_boxes WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product['hit_box_id']]);
    $hit_box = $stmt->fetch();
}

// Output any errors
$errors = [];
if (isset($bomError)) $errors[] = $bomError;
if (isset($materialsError)) $errors[] = $materialsError;
if (isset($poError)) $errors[] = $poError;
?>

<div class="container mt-4">
    <?php echo $schemaInfo ?? ''; ?>
    <?php echo $bomSchemaInfo ?? ''; ?>
    <?php echo $poDebug ?? ''; ?>
    <?php echo $bomDebug ?? ''; ?>
    <?php 
    // Output any errors for debugging
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    }
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p class="text-muted">Part Details</p>
        </div>
        <div>
            <a href="products.php" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBomItemModal">
                <i class="fas fa-plus me-1"></i> Add Material to BOM
            </button>
        </div>
    </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Part Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                        </tr>
                        <tr>
                            <th>Unit:</th>
                            <td><?php echo htmlspecialchars($product['unit']); ?></td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td><?php echo formatCurrency($product['price']); ?></td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td><?php echo formatDateTime($product['created_at']); ?></td>
                        </tr>
                        <?php if ($product['updated_at']): ?>
                            <tr>
                                <th>Last Updated:</th>
                                <td><?php echo formatDateTime($product['updated_at']); ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal">
                            <i class="fas fa-edit me-1"></i> Edit Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Bill of Materials</h5>
                </div>
                <div class="card-body">
                    <?php if (count($bom_items) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Material Type</th>
                                        <th>Quantity</th>
                                        <th>Current Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bom_items as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['material_name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['material_type']); ?></td>
                                            <td>
                                                <?php 
                                                if (!isset($item['quantity'])) {
                                                    echo "<!-- Missing quantity for material {$item['material_name']} -->";
                                                    echo '0.000';
                                                } else {
                                                    echo number_format($item['quantity'], 3);
                                                }
                                                ?> 
                                                <?php echo htmlspecialchars($item['material_unit'] ?? ''); ?>
                                            </td>
                                            <td><?php echo isset($item['material_stock']) ? number_format($item['material_stock'], 3) : '0.000'; ?> <?php echo htmlspecialchars($item['material_unit'] ?? ''); ?></td>
                                            <td>
                                                <?php 
                                                $material_stock = $item['material_stock'] ?? 0;
                                                $quantity = $item['quantity'] ?? 0;
                                                
                                                if ($material_stock <= 0): ?>
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                <?php elseif ($material_stock < $quantity): ?>
                                                    <span class="badge bg-warning">Insufficient</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Available</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBomItemModal" 
                                                        data-material-id="<?php echo $item['material_id']; ?>"
                                                        data-material-name="<?php echo htmlspecialchars($item['material_name']); ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No materials added to the Bill of Materials yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($hit_box): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Heat Box Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Heat Box Name</th>
                                        <th>Current Stock</th>
                                        <th>Products per Box</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo htmlspecialchars($hit_box['name']); ?></td>
                                        <td><?php echo number_format($hit_box['stock'], 2); ?></td>
                                        <td><?php echo (int)$product['products_per_box']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Related Purchase Orders</h5>
                </div>
                <div class="card-body">
                    <?php if (count($purchase_orders) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>PO Number</th>
                                        <th>Customer</th>
                                        <th>Quantity</th>
                                        <th>Delivery Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($purchase_orders as $po): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($po['po_number']); ?></td>
                                            <td><?php echo htmlspecialchars($po['customer_name']); ?></td>
                                            <td>
                                                <?php 
                                                // Debug information
                                                if (!isset($po['quantity'])) {
                                                    echo "<!-- Missing quantity for PO #{$po['po_number']} -->";
                                                }
                                                if (!isset($po['unit'])) {
                                                    echo "<!-- Missing unit for PO #{$po['po_number']} -->";
                                                }
                                                echo isset($po['quantity']) ? number_format($po['quantity'], 2) : '0.00'; 
                                                ?> 
                                                <?php echo htmlspecialchars($po['unit'] ?? 'nos'); ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if (!isset($po['delivery_date'])) {
                                                    echo "<!-- Missing delivery_date for PO #{$po['po_number']} -->";
                                                    echo "N/A";
                                                } else {
                                                    echo formatDate($po['delivery_date']);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if (!isset($po['status'])) {
                                                    echo "<!-- Missing status for PO #{$po['po_number']} -->";
                                                    $status = 'pending'; // Default status
                                                } else {
                                                    $status = $po['status'];
                                                }
                                                
                                                $badge_class = '';
                                                switch ($status) {
                                                    case 'completed': $badge_class = 'success'; break;
                                                    case 'in_progress': $badge_class = 'primary'; break;
                                                    case 'cancelled': $badge_class = 'danger'; break;
                                                    default: $badge_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge bg-<?php echo $badge_class; ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($status))); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="purchase_order_details.php?id=<?php echo $po['id']; ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No purchase orders found for this product.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="products.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_product">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Part Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit</label>
                            <select class="form-select" id="unit" name="unit" required>
                                <option value="Kg" <?php echo $product['unit'] === 'Kg' ? 'selected' : ''; ?>>Kg</option>
                                <option value="Ltr" <?php echo $product['unit'] === 'Ltr' ? 'selected' : ''; ?>>Ltr</option>
                                <option value="Nos" <?php echo $product['unit'] === 'Nos' ? 'selected' : ''; ?>>Nos</option>
                                <option value="Mtr" <?php echo $product['unit'] === 'Mtr' ? 'selected' : ''; ?>>Mtr</option>
                                <option value="Set" <?php echo $product['unit'] === 'Set' ? 'selected' : ''; ?>>Set</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Part</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add BOM Item Modal -->
<div class="modal fade" id="addBomItemModal" tabindex="-1" aria-labelledby="addBomItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBomItemModalLabel">Add Material to BOM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="products.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_bom_item">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <div class="mb-3">
                        <label for="material_id" class="form-label">Material</label>
                        <select class="form-select" id="material_id" name="material_id" required>
                            <option value="">Select Material</option>
                            <?php foreach ($materials as $material): ?>
                                <option value="<?php echo $material['id']; ?>" data-unit="<?php echo htmlspecialchars($material['unit']); ?>">
                                    <?php echo htmlspecialchars($material['name']); ?> (<?php echo htmlspecialchars($material['unit']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="quantity" name="quantity" step="0.01" min="0.01" required>
                            <span class="input-group-text" id="material-unit"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Material</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete BOM Item Modal -->
<div class="modal fade" id="deleteBomItemModal" tabindex="-1" aria-labelledby="deleteBomItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBomItemModalLabel">Delete Material from BOM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="products.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_bom_item">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="material_id" id="delete_material_id">
                    
                    <p>Are you sure you want to remove <strong id="delete_material_name"></strong> from the Bill of Materials?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Remove Material</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add BOM Item Modal
    const materialSelect = document.getElementById('material_id');
    const materialUnit = document.getElementById('material-unit');
    
    if (materialSelect) {
        materialSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                materialUnit.textContent = selectedOption.getAttribute('data-unit');
            } else {
                materialUnit.textContent = '';
            }
        });
    }
    
    // Delete BOM Item Modal
    const deleteBomItemModal = document.getElementById('deleteBomItemModal');
    if (deleteBomItemModal) {
        deleteBomItemModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const materialId = button.getAttribute('data-material-id');
            const materialName = button.getAttribute('data-material-name');
            
            document.getElementById('delete_material_id').value = materialId;
            document.getElementById('delete_material_name').textContent = materialName;
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
