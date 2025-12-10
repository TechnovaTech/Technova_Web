<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Handle form submissions (previously in controller)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create') {
        // Generate PO number
        $poNumber = 'PO-' . date('Ymd') . '-' . rand(1000, 9999);
        
        // Begin transaction
        $pdo->beginTransaction();
        
        try {
            // Insert new purchase order
            $sql = "INSERT INTO purchase_orders (po_number, customer_id, product_id, quantity, unit, status, notes, material_status) 
                    VALUES (?, ?, ?, ?, ?, 'pending', ?, 'pending')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $poNumber,
                $_POST['customer_id'],
                $_POST['product_id'],
                $_POST['quantity'],
                $_POST['unit'] ?? 'pcs',
                $_POST['notes'] ?? null
            ]);
            
            // Get the new PO ID
            $poId = $pdo->lastInsertId();
            
            // Process selected materials
            $selectedMaterials = $_POST['selected_materials'] ?? [];
            $materialQuantities = $_POST['material_quantities'] ?? [];
            $materialTypes = $_POST['material_types'] ?? [];
            
            // Process alternative materials
            $altMaterials = $_POST['alt_materials'] ?? [];
            $altMaterialQuantities = $_POST['alt_material_quantities'] ?? [];
            $altMaterialTypes = $_POST['alt_material_types'] ?? [];
            
            // Create a record of materials used for this PO
            if (!empty($selectedMaterials) || !empty($altMaterials)) {
                // Create PO materials table if it doesn't exist
                $createTableSql = "CREATE TABLE IF NOT EXISTS po_materials (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    po_id INT(11) NOT NULL,
                    material_id INT(11) NOT NULL,
                    material_type ENUM('core', 'sleeve', 'metal') NOT NULL,
                    quantity_required DECIMAL(10,2) NOT NULL,
                    is_alternative TINYINT(1) NOT NULL DEFAULT 0,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    KEY fk_po_materials_po (po_id),
                    KEY fk_po_materials_material (material_id),
                    CONSTRAINT fk_po_materials_po FOREIGN KEY (po_id) REFERENCES purchase_orders (id) ON DELETE CASCADE,
                    CONSTRAINT fk_po_materials_material FOREIGN KEY (material_id) REFERENCES materials (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                $pdo->exec($createTableSql);
                
                // Insert selected materials
                $insertSql = "INSERT INTO po_materials (po_id, material_id, material_type, quantity_required, is_alternative) 
                              VALUES (?, ?, ?, ?, ?)";
                $insertStmt = $pdo->prepare($insertSql);
                
                foreach ($selectedMaterials as $materialId) {
                    $quantity = $materialQuantities[$materialId] ?? 0;
                    $type = $materialTypes[$materialId] ?? 'metal';
                    
                    if ($quantity > 0) {
                        $insertStmt->execute([
                            $poId,
                            $materialId,
                            $type,
                            $quantity,
                            0 // Not alternative
                        ]);
                    }
                }
                
                // Insert alternative materials
                foreach ($altMaterials as $materialId) {
                    $quantity = $altMaterialQuantities[$materialId] ?? 0;
                    $type = $altMaterialTypes[$materialId] ?? 'metal';
                    
                    if ($quantity > 0) {
                        $insertStmt->execute([
                            $poId,
                            $materialId,
                            $type,
                            $quantity,
                            1 // Is alternative
                        ]);
                    }
                }
            }
            
            // Check material availability and create to-do tasks for shortages
            // We'll use a modified approach that only checks the selected materials
            $materialCheck = [];
            $todoTasks = [];
            $insufficientMaterials = [];
            $allSufficient = true;
            
            // Check selected materials
            foreach ($selectedMaterials as $materialId) {
                $quantity = $materialQuantities[$materialId] ?? 0;
                $type = $materialTypes[$materialId] ?? 'metal';
                
                // Get material details
                $sql = "SELECT id, name, type, stock_qty, unit FROM materials WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$materialId]);
                $material = $stmt->fetch();
                
                if ($material && $quantity > 0) {
                    $shortage = max(0, $quantity - $material['stock_qty']);
                    
                    if ($shortage > 0) {
                        $allSufficient = false;
                        $insufficientMaterials[] = [
                            'id' => $material['id'],
                            'name' => $material['name'],
                            'type' => $material['type'],
                            'required' => $quantity,
                            'available' => $material['stock_qty'],
                            'shortage' => $shortage
                        ];
                        
                        // Create to-do tasks for core and sleeve shortages
                        if ($type == 'core' || $type == 'sleeve') {
                            $todoSql = "INSERT INTO to_do_tasks (task_type, product_id, po_id, quantity_required, status, priority, title, description, due_date) 
                                        VALUES (?, ?, ?, ?, 'pending', 'high', ?, ?, DATE_ADD(NOW(), INTERVAL 3 DAY))";
                            
                            $title = "Create {$shortage} {$material['name']} for PO #$poId";
                            $description = "Need to create {$shortage} {$material['name']} ({$type}) for product ID {$_POST['product_id']} in purchase order #$poId. Current stock is insufficient.";
                            
                            $todoStmt = $pdo->prepare($todoSql);
                            $todoStmt->execute([
                                'create_' . $type,
                                $_POST['product_id'],
                                $poId,
                                $shortage,
                                $title,
                                $description
                            ]);
                            
                            $todoTasks[] = [
                                'task_type' => 'create_' . $type,
                                'product_id' => $_POST['product_id'],
                                'po_id' => $poId,
                                'quantity_required' => $shortage,
                                'material_id' => $material['id'],
                                'material_name' => $material['name']
                            ];
                        }
                    }
                }
            }
            
            // Update PO material status
            $updateSql = "UPDATE purchase_orders SET material_status = ? WHERE id = ?";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([$allSufficient ? 'sufficient' : 'insufficient', $poId]);
            
            // Commit transaction
            $pdo->commit();
            
            // Set session message with material check results
            if (!$allSufficient) {
                $todoCount = count($todoTasks);
                if ($todoCount > 0) {
                    $_SESSION['material_alert'] = [
                        'type' => 'warning',
                        'message' => "Purchase order created with your selected materials. $todoCount to-do tasks were added for material shortages.",
                        'details' => [
                            'sufficient' => $allSufficient,
                            'materials' => $insufficientMaterials,
                            'todo_tasks' => $todoTasks
                        ]
                    ];
                }
            } else {
                $_SESSION['material_alert'] = [
                    'type' => 'success',
                    'message' => "Purchase order created with your selected materials. All materials are available.",
                    'details' => [
                        'sufficient' => true,
                        'materials' => [],
                        'todo_tasks' => []
                    ]
                ];
            }
            
            // Redirect to prevent form resubmission
            header('Location: purchase_orders.php?success=created');
            exit;
        } catch (Exception $e) {
            // Rollback on error
            $pdo->rollBack();
            header('Location: purchase_orders.php?error=create_failed&message=' . urlencode($e->getMessage()));
            exit;
        }
    }
    
    if ($action === 'process_po') {
        $poId = $_POST['po_id'] ?? 0;
        
        // Update PO status
        $sql = "UPDATE purchase_orders SET status = 'processing' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poId]);
        
        header('Location: purchase_orders.php?success=processing');
        exit;
    }
    
    if ($action === 'mark_completed') {
        $poId = $_POST['po_id'] ?? 0;
        
        // Update PO status
        $sql = "UPDATE purchase_orders SET status = 'completed' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$poId]);
        
        header('Location: purchase_orders.php?success=completed');
        exit;
    }
    
    if ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        $deleteRelated = isset($_POST['delete_related']) && $_POST['delete_related'] === '1';
        
        // Find all tables with foreign keys to purchase_orders
        $tableColumns = [
            'dispatch' => 'po_id',
            'rejections' => 'po_id',
            'shot_blasting' => 'po_id',
            'fettling' => 'po_id',
            'pouring_batches' => 'po_id',
            'knockout_batches' => 'po_id',
            'po_materials' => 'po_id',
            'dispatches' => 'purchase_order_id',
            'dispatch_items' => 'po_id',
            'melting_batches' => 'po_id',
            'moulding_batches' => 'po_id'
        ];
        
        // Try to find any other tables that might have foreign keys to purchase_orders
        try {
            $sql = "SELECT TABLE_NAME, COLUMN_NAME 
                    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                    WHERE REFERENCED_TABLE_NAME = 'purchase_orders' 
                    AND REFERENCED_COLUMN_NAME = 'id' 
                    AND TABLE_SCHEMA = DATABASE()";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            
            while ($row = $stmt->fetch()) {
                $tableName = $row['TABLE_NAME'];
                $columnName = $row['COLUMN_NAME'];
                
                // Add to our tableColumns array if not already there
                if (!isset($tableColumns[$tableName])) {
                    $tableColumns[$tableName] = $columnName;
                }
            }
        } catch (Exception $e) {
            // If this fails, we'll just use our predefined list
        }
        
        // Check if there are related records in any tables
        $hasRelatedRecords = false;
        $relatedTablesFound = [];
        
        foreach ($tableColumns as $table => $column) {
            // Check if the table exists first
            $checkTableSql = "SHOW TABLES LIKE '$table'";
            $checkTableStmt = $pdo->prepare($checkTableSql);
            $checkTableStmt->execute();
            
            if ($checkTableStmt->rowCount() > 0) {
                $checkSql = "SELECT COUNT(*) FROM $table WHERE $column = ?";
                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->execute([$id]);
                $count = $checkStmt->fetchColumn();
                
                if ($count > 0) {
                    $hasRelatedRecords = true;
                    $relatedTablesFound[] = $table . ' (' . $count . ' records)';
                }
            }
        }
        
        if ($hasRelatedRecords && !$deleteRelated) {
            // Redirect to confirmation page for deleting with related records
            $message = "This purchase order has related records in: " . implode(", ", $relatedTablesFound) . ". Do you want to delete these related records as well?";
            header('Location: purchase_orders.php?error=confirm_delete&id=' . $id . '&message=' . urlencode($message));
            exit;
        }
        
        // If confirmed to delete related records, delete them in the correct order
        if ($deleteRelated) {
            // Begin transaction for safety
            $pdo->beginTransaction();
            
            try {
                // Find all tables with foreign keys to purchase_orders if not already done
                if (!isset($tableColumns)) {
                    $tableColumns = [
                        'dispatch_items' => 'po_id',
                        'dispatch' => 'po_id',
                        'rejections' => 'po_id',
                        'shot_blasting' => 'po_id',
                        'fettling' => 'po_id',
                        'pouring_batches' => 'po_id',
                        'knockout_batches' => 'po_id',
                        'po_materials' => 'po_id',
                        'dispatches' => 'purchase_order_id',
                        'melting_batches' => 'po_id',
                        'moulding_batches' => 'po_id'
                    ];
                    
                    // Try to find any other tables that might have foreign keys to purchase_orders
                    try {
                        $sql = "SELECT TABLE_NAME, COLUMN_NAME 
                                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                                WHERE REFERENCED_TABLE_NAME = 'purchase_orders' 
                                AND REFERENCED_COLUMN_NAME = 'id' 
                                AND TABLE_SCHEMA = DATABASE()";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        
                        while ($row = $stmt->fetch()) {
                            $tableName = $row['TABLE_NAME'];
                            $columnName = $row['COLUMN_NAME'];
                            
                            // Add to our tableColumns array if not already there
                            if (!isset($tableColumns[$tableName])) {
                                $tableColumns[$tableName] = $columnName;
                            }
                        }
                    } catch (Exception $e) {
                        // If this fails, we'll just use our predefined list
                    }
                }
                
                // Delete in reverse order of dependency (child tables first)
                // to_do_tasks has ON DELETE SET NULL so we don't need to delete those records
                
                // Define tables and their foreign key columns
                
                // Delete from tables in order
                foreach ($tableColumns as $table => $column) {
                    // Check if the table exists first
                    $checkTableSql = "SHOW TABLES LIKE '$table'";
                    $checkTableStmt = $pdo->prepare($checkTableSql);
                    $checkTableStmt->execute();
                    
                    if ($checkTableStmt->rowCount() > 0) {
                        $sql = "DELETE FROM $table WHERE $column = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$id]);
                    }
                }
                
                // Delete purchase order
                $sql = "DELETE FROM purchase_orders WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                
                // Commit if all deletes were successful
                $pdo->commit();
            } catch (Exception $e) {
                // Rollback on error
                $pdo->rollBack();
                
                // Get more detailed error information
                $errorInfo = '';
                if ($e instanceof PDOException) {
                    $errorInfo = $e->getMessage();
                    
                    // Check if it's a foreign key constraint error
                    if (strpos($errorInfo, 'foreign key constraint fails') !== false) {
                        // Extract table name from error message
                        preg_match('/`([^`]+)`\.`([^`]+)`/', $errorInfo, $matches);
                        if (count($matches) >= 3) {
                            $dbName = $matches[1];
                            $tableName = $matches[2];
                            
                            // Get count of related records
                            try {
                                $checkSql = "SELECT COUNT(*) FROM $tableName WHERE po_id = ? OR purchase_order_id = ?";
                                $checkStmt = $pdo->prepare($checkSql);
                                $checkStmt->execute([$id, $id]);
                                $count = $checkStmt->fetchColumn();
                                
                                $errorInfo = "Cannot delete purchase order because it has $count related records in the $tableName table. Please use the 'Delete All Related Records' option.";
                            } catch (Exception $innerEx) {
                                // If this fails, just use the original error message
                            }
                        }
                    }
                }
                
                header('Location: purchase_orders.php?error=delete_failed&message=' . urlencode($errorInfo));
                exit;
            }
        }
        else {
            // If no related records or not confirmed to delete related records
            // Delete purchase order directly
            $sql = "DELETE FROM purchase_orders WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
        }
        
        header('Location: purchase_orders.php?success=deleted');
        exit;
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action === 'check_materials') {
        $productId = $_GET['product_id'] ?? 0;
        $quantity = $_GET['quantity'] ?? 0;
        
        // Use the enhanced material check function (without creating to-do tasks)
        $materialCheck = checkPOMaterialAvailability($pdo, $productId, $quantity);
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($materialCheck);
        exit;
    }
    elseif ($action === 'get_product_materials') {
        // Get product-specific core and sleeve requirements
        $product_id = (int)$_GET['product_id'];
        
        // Get cores for this product
        $sql = "SELECT bi.material_id, bi.quantity_per_unit, m.name, m.type 
                FROM bom_items bi 
                JOIN materials m ON bi.material_id = m.id 
                WHERE bi.product_id = ? AND m.type = 'core'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id]);
        $cores = $stmt->fetchAll();
        
        // Get sleeves for this product
        $sql = "SELECT bi.material_id, bi.quantity_per_unit, m.name, m.type 
                FROM bom_items bi 
                JOIN materials m ON bi.material_id = m.id 
                WHERE bi.product_id = ? AND m.type = 'sleeve'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id]);
        $sleeves = $stmt->fetchAll();
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'cores' => $cores,
            'sleeves' => $sleeves
        ]);
        exit;
    }
}

// Get customers for form
$sql = "SELECT id, name FROM customers ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$customers = $stmt->fetchAll();

// Get products for form
$sql = "SELECT id, name FROM products ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

// Get purchase orders with all parts for each order
$sql = "SELECT po.*, c.name as customer_name, pop.product_id, pop.quantity as part_quantity, p.name as product_name
        FROM purchase_orders po 
        JOIN customers c ON po.customer_id = c.id 
        JOIN purchase_order_products pop ON pop.purchase_order_id = po.id
        JOIN products p ON pop.product_id = p.id
        ORDER BY po.created_at DESC, po.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$purchase_orders = $stmt->fetchAll();

// Group rows by PO ID for rowspan calculation
$grouped_orders = [];
foreach ($purchase_orders as $row) {
    $grouped_orders[$row['id']][] = $row;
}

// Function to update material status for all purchase orders
function updateAllMaterialStatus($pdo) {
    // Get all purchase orders
    $sql = "SELECT po.id, po.quantity, p.id as product_id 
            FROM purchase_orders po 
            JOIN products p ON po.product_id = p.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $all_pos = $stmt->fetchAll();
    
    foreach ($all_pos as $po) {
        // Get materials required for this product
        $sql = "SELECT m.stock_qty as current_stock, b.quantity_per_unit
                FROM bom_items b
                JOIN materials m ON b.material_id = m.id
                WHERE b.product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$po['product_id']]);
        $materials = $stmt->fetchAll();
        
        // Check if all materials are sufficient
        $allSufficient = true;
        foreach ($materials as $material) {
            $requiredAmount = $material['quantity_per_unit'] * $po['quantity'];
            if ($requiredAmount > $material['current_stock']) {
                $allSufficient = false;
                break;
            }
        }
        
        // Update material_status in database
        $status = $allSufficient ? 'sufficient' : 'insufficient';
        $sql = "UPDATE purchase_orders SET material_status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$status, $po['id']]);
    }
}

// Update material status for all purchase orders
updateAllMaterialStatus($pdo);

// Re-fetch purchase orders with updated material status
$sql = "SELECT po.*, c.name as customer_name, p.name as product_name 
        FROM purchase_orders po 
        JOIN customers c ON po.customer_id = c.id 
        JOIN products p ON po.product_id = p.id 
        ORDER BY po.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$purchase_orders = $stmt->fetchAll();

// Helper function to check material availability
// Removed duplicate function that's now in functions.php
?>

<style>
.po-separator {
    border-bottom: 3px solid rgb(97, 97, 97) !important;
}
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h2">Purchase Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="production_chart.php" class="btn btn-info me-2">
                <i class="fas fa-chart-line me-2"></i> Production status
            </a>
            <a href="new_purchase_order.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> New Purchase Order
            </a>
        </div>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php 
        $message = 'Operation completed successfully.';
        if ($_GET['success'] === 'created') {
            $message = 'Purchase order created successfully.';
        } elseif ($_GET['success'] === 'processing') {
            $message = 'Purchase order marked as processing.';
        } elseif ($_GET['success'] === 'completed') {
            $message = 'Purchase order marked as completed.';
        } elseif ($_GET['success'] === 'deleted') {
            $message = 'Purchase order deleted successfully.';
        }
        echo $message;
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['material_alert'])): ?>
    <div class="alert alert-<?php echo $_SESSION['material_alert']['type']; ?> alert-dismissible fade show" role="alert">
        <h5 class="alert-heading">Material Requirements</h5>
        <p><?php echo $_SESSION['material_alert']['message']; ?></p>
        
        <?php if (!empty($_SESSION['material_alert']['details']['todo_tasks'])): ?>
        <hr>
        <h6>To-Do Tasks Created:</h6>
        <ul>
            <?php foreach ($_SESSION['material_alert']['details']['todo_tasks'] as $task): ?>
            <li>
                <strong><?php echo ucfirst(str_replace('_', ' ', $task['task_type'])); ?>:</strong> 
                <?php echo $task['quantity_required']; ?> <?php echo $task['material_name']; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <p class="mb-0"><small>These tasks have been added to the To-Do list with high priority.</small></p>
        <?php endif; ?>
        
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
    // Clear the alert after displaying
    unset($_SESSION['material_alert']);
    endif; 
    ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_GET['message'] ?? 'An error occurred.'); ?>
        <?php if ($_GET['error'] === 'confirm_delete' && isset($_GET['id'])): ?>
            <div class="mt-3">
                <h6>Related Records:</h6>
                <ul>
                    <?php 
                    $relatedTables = explode(', ', $_GET['message'] ?? '');
                    foreach($relatedTables as $table):
                        if (strpos($table, '(') !== false):
                    ?>
                        <li><?php echo htmlspecialchars($table); ?></li>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </ul>
                <form method="POST" action="purchase_orders.php" class="d-inline">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo (int)$_GET['id']; ?>">
                    <input type="hidden" name="delete_related" value="1">
                    <button type="submit" class="btn btn-danger btn-sm">Yes, Delete All Related Records and Purchase Order</button>
                </form>
                <a href="purchase_orders.php" class="btn btn-secondary btn-sm ms-2">Cancel</a>
            </div>
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Purchase Orders Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">All Purchase Orders</h5>
            <div class="input-group" style="max-width: 300px;">
                <input type="text" class="form-control" id="poSearchInput" placeholder="Search orders...">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>Customer</th>
                            <th>Part Name</th>
                            <th>Quantity</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Materials</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                                <?php
                        foreach ($grouped_orders as $po_id => $rows) {
                            $rowspan = count($rows);
                            foreach ($rows as $i => $row) {
                                $last_row_class = ($i === $rowspan - 1) ? 'po-separator' : '';
                                echo '<tr class="' . $last_row_class . '">';
                                if ($i === 0) {
                                    echo '<td rowspan="'.$rowspan.'"><strong>'.htmlspecialchars($row['po_number']).'</strong></td>';
                                    echo '<td rowspan="'.$rowspan.'">'.htmlspecialchars($row['customer_name']).'</td>';
                                }
                                echo '<td>'.htmlspecialchars($row['product_name']).'</td>';
                                $part_quantity = isset($row['part_quantity']) ? $row['part_quantity'] : (isset($row['quantity']) ? $row['quantity'] : '');
                                echo '<td>'.number_format($part_quantity, 0).' piece</td>';
                                if ($i === 0) {
                                    echo '<td rowspan="'.$rowspan.'">'.date('d-m-Y', strtotime($row['created_at'])).'</td>';
                                    echo '<td rowspan="'.$rowspan.'">'.(!empty($row['delivery_date']) ? date('d-m-Y', strtotime($row['delivery_date'])) : '-').'</td>';
                                $badge_class = '';
                                    switch ($row['status']) {
                                    case 'completed': $badge_class = 'success'; break;
                                    case 'processing': $badge_class = 'primary'; break;
                                    case 'pending': $badge_class = 'warning'; break;
                                    default: $badge_class = 'secondary';
                                }
                                    echo '<td rowspan="'.$rowspan.'"><span class="badge bg-'.$badge_class.'">'.ucfirst($row['status']).'</span></td>';
                                    if ($row['material_status'] == 'sufficient') {
                                        echo '<td rowspan="'.$rowspan.'"><i class="fas fa-check-circle text-success me-1"></i><span class="text-success">Sufficient</span></td>';
                                    } else {
                                        echo '<td rowspan="'.$rowspan.'"><i class="fas fa-exclamation-triangle text-warning me-1"></i><span class="text-warning">Insufficient</span></td>';
                                    }
                                    // Actions
                                    echo '<td rowspan="'.$rowspan.'"><div class="btn-group">';
                                    echo '<a href="purchase_order_details.php?id='.$row['id'].'" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>';
                                    if ($row['status'] === 'processing') {
                                        echo '<form method="POST" action="purchase_orders.php" style="display:inline;"><input type="hidden" name="action" value="mark_completed"><input type="hidden" name="po_id" value="'.$row['id'].'"><button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as Completed"><i class="fas fa-check"></i></button></form>';
                                    }
                                    echo '<form method="POST" action="purchase_orders.php" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this purchase order?\');"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="'.$row['id'].'"><button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Order"><i class="fas fa-trash"></i></button></form>';
                                    echo '</div></td>';
                                }
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- New Purchase Order Modal -->
<!-- Modal removed in favor of dedicated new_purchase_order.php page
<div class="modal fade" id="newPurchaseOrderModal" tabindex="-1" aria-labelledby="newPurchaseOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPurchaseOrderModalLabel">Create New Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newPOForm" method="POST" action="purchase_orders.php">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $customer): ?>
                                <option value="<?php echo $customer['id']; ?>"><?php echo htmlspecialchars($customer['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="product_id" class="form-label">Part</label>
                            <select class="form-select" id="product_id" name="product_id" required>
                                <option value="">Select Part</option>
                                <?php foreach ($products as $product): ?>
                                <option value="<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit</label>
                            <select class="form-select" id="unit" name="unit">
                                <option value="pcs">Pieces</option>
                                <option value="kg">Kilograms</option>
                                <option value="sets">Sets</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    
                    <!-- Materials Selection Section -->
                    <div id="materialsSelectionSection" class="mb-3" style="display: none;">
                        <h5 class="border-bottom pb-2 mb-3">Materials Selection</h5>
                        <p class="text-muted small">Select which materials to use for this order. Default materials are pre-selected based on the product's bill of materials.</p>
                        
                        <div id="defaultMaterialsList">
                            <!-- Default materials will be loaded here -->
                        </div>
                        
                        <div class="mt-3">
                            <h6>Alternative Materials</h6>
                            <p class="text-muted small">You can select alternative materials if needed.</p>
                            <div id="alternativeMaterialsList">
                                <!-- Alternative materials will be loaded here -->
                            </div>
                        </div>
                    </div>
                    
                    <div id="materialCheckResult" class="mb-3" style="display: none;">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">Material Availability Check</h6>
                            <div id="materialCheckDetails"></div>
                        </div>
                    </div>
                 
                </form>
            </div>
        </div>
    </div>
</div>
-->

<script>
$(document).ready(function() {
    // Material check functionality - now handled in new_purchase_order.php
    /*
    // Load materials when product is selected
    $('#product_id').on('change', function() {
        const productId = $('#product_id').val();
        const quantity = $('#quantity').val() || 1;
        
        if (productId) {
            // Clear previous materials
            $('#defaultMaterialsList').empty();
            $('#alternativeMaterialsList').empty();
            
            // Make AJAX request to get materials for this product
            $.ajax({
                url: 'purchase_orders.php',
                type: 'GET',
                data: {
                    action: 'get_materials_for_product',
                    product_id: productId
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Materials for product:', response);
                    
                    // Display default materials
                    if (response.default_materials && response.default_materials.length > 0) {
                        let defaultHtml = '<div class="row">';
                        
                        response.default_materials.forEach(function(material, index) {
                            const requiredQty = material.quantity_per_unit * quantity;
                            const materialTypeLabel = material.material_type.charAt(0).toUpperCase() + material.material_type.slice(1);
                            
                            defaultHtml += `
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selected_materials[]" 
                                                id="material_${material.material_id}" value="${material.material_id}" checked>
                                            <label class="form-check-label" for="material_${material.material_id}">
                                                <strong>${material.name}</strong> (${materialTypeLabel})
                                            </label>
                                        </div>
                                        <div class="mt-2 small">
                                            <p class="mb-1">Required: ${requiredQty} ${material.unit}</p>
                                            <p class="mb-1">Available: ${material.stock_qty} ${material.unit}</p>
                                            <p class="mb-0 ${material.stock_qty < requiredQty ? 'text-danger' : 'text-success'}">
                                                ${material.stock_qty < requiredQty ? 'Shortage: ' + (requiredQty - material.stock_qty) : 'Sufficient'}
                                            </p>
                                        </div>
                                        <input type="hidden" name="material_quantities[${material.material_id}]" value="${requiredQty}">
                                        <input type="hidden" name="material_types[${material.material_id}]" value="${material.material_type}">
                                    </div>
                                </div>
                            </div>`;
                        });
                        
                        defaultHtml += '</div>';
                        $('#defaultMaterialsList').html(defaultHtml);
                    } else {
                        $('#defaultMaterialsList').html('<p>No materials defined for this product.</p>');
                    }
                    
                    // Display alternative materials
                    if (response.alternative_materials && response.alternative_materials.length > 0) {
                        let altHtml = '<div class="row">';
                        
                        response.alternative_materials.forEach(function(material) {
                            const materialTypeLabel = material.type.charAt(0).toUpperCase() + material.type.slice(1);
                            
                            altHtml += `
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alt_materials[]" 
                                                id="alt_material_${material.id}" value="${material.id}">
                                            <label class="form-check-label" for="alt_material_${material.id}">
                                                <strong>${material.name}</strong> (${materialTypeLabel})
                                            </label>
                                        </div>
                                        <div class="mt-2 small">
                                            <p class="mb-1">Available: ${material.stock_qty} ${material.unit}</p>
                                            <div class="mt-2">
                                                <label class="form-label small">Quantity to use:</label>
                                                <input type="number" class="form-control form-control-sm" 
                                                    name="alt_material_quantities[${material.id}]" value="0" min="0" max="${material.stock_qty}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="alt_material_types[${material.id}]" value="${material.type}">
                                    </div>
                                </div>
                            </div>`;
                        });
                        
                        altHtml += '</div>';
                        $('#alternativeMaterialsList').html(altHtml);
                    } else {
                        $('#alternativeMaterialsList').html('<p>No alternative materials available.</p>');
                    }
                    
                    // Show the materials selection section
                    $('#materialsSelectionSection').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading materials:', error);
                    $('#materialsSelectionSection').hide();
                }
            });
        } else {
            $('#materialsSelectionSection').hide();
        }
    });
    
    // Material check functionality
    $('#product_id, #quantity').on('change', function() {
        const productId = $('#product_id').val();
        const quantity = $('#quantity').val();
        
        if (productId && quantity > 0) {
            console.log('Checking material availability for product:', productId, 'quantity:', quantity);
            
            // Make AJAX request to check material availability
            $.ajax({
                url: 'purchase_orders.php',
                type: 'GET',
                data: {
                    action: 'check_materials',
                    product_id: productId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Material check response:', response);
                    
                    const resultDiv = $('#materialCheckResult');
                    const detailsDiv = $('#materialCheckDetails');
                    
                    if (response.sufficient) {
                        resultDiv.removeClass('alert-warning').addClass('alert-success');
                        detailsDiv.html('<p class="mb-0"><i class="fas fa-check-circle me-2"></i> All materials are available for this order.</p>');
                    } else {
                        resultDiv.removeClass('alert-success').addClass('alert-warning');
                        let html = '<p><i class="fas fa-exclamation-triangle me-2"></i> Insufficient materials:</p><ul>';
                        
                        response.materials.forEach(function(material) {
                            html += `<li>${material.name}: Need ${material.required}, Available ${material.available}, Shortage ${material.shortage}</li>`;
                        });
                        
                        html += '</ul><p class="mb-0 small">You can still create the order, but materials will need to be restocked.</p>';
                        detailsDiv.html(html);
                    }
                    
                    resultDiv.show();
                    
                    // Update quantities in the materials selection section
                    if ($('#materialsSelectionSection').is(':visible')) {
                        const quantity = $('#quantity').val() || 1;
                        
                        // Update default materials quantities
                        response.materials.forEach(function(material) {
                            $(`input[name="material_quantities[${material.id}]"]`).val(material.required);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking materials:', error);
                    $('#materialCheckResult').hide();
                }
            });
        } else {
            $('#materialCheckResult').hide();
        }
    });
    */
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('poSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('.table.table-striped.table-hover');
            if (!table) return;
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>


