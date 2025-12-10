<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';
require_once 'includes/header.php';

// Function to check material requirements for all pending purchase orders
function checkMaterialRequirementsForPendingOrders($pdo) {
    // Get all pending purchase orders
    $sql = "SELECT po.id, po.po_number, po.product_id, po.quantity, p.name as product_name 
            FROM purchase_orders po
            JOIN products p ON po.product_id = p.id
            WHERE po.status = 'pending'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $pendingOrders = $stmt->fetchAll();
    
    $insufficientMaterials = [];
    
    // For each pending order, check material requirements
    foreach ($pendingOrders as $order) {
        // Get materials for this order from po_materials table
        $sql = "SELECT pm.*, m.name as material_name, m.stock_qty, m.type 
                FROM po_materials pm
                JOIN materials m ON pm.material_id = m.id
                WHERE pm.po_id = ? AND pm.is_alternative = 0
                AND m.type IN ('core', 'sleeve')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$order['id']]);
        $materials = $stmt->fetchAll();
        
        foreach ($materials as $material) {
            $shortage = max(0, $material['quantity_required'] - $material['stock_qty']);
            
            if ($shortage > 0) {
                $insufficientMaterials[] = [
                    'po_id' => $order['id'],
                    'po_number' => $order['po_number'],
                    'product_id' => $order['product_id'],
                    'product_name' => $order['product_name'],
                    'material_id' => $material['material_id'],
                    'material_name' => $material['material_name'],
                    'material_type' => $material['type'],
                    'quantity_required' => $material['quantity_required'],
                    'stock_qty' => $material['stock_qty'],
                    'shortage' => $shortage
                ];
            }
        }
    }
    
    return $insufficientMaterials;
}

// Function to create tasks for insufficient materials
function createTasksForInsufficientMaterials($pdo, $insufficientMaterials) {
    $createdTasks = [];
    
    // Check if related_to column exists in to_do_tasks table
    $checkColumnQuery = "SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                        WHERE TABLE_SCHEMA = 'casting_erp' 
                        AND TABLE_NAME = 'to_do_tasks' 
                        AND COLUMN_NAME = 'related_to'";
    $stmt = $pdo->prepare($checkColumnQuery);
    $stmt->execute();
    $relatedToExists = $stmt->fetch()['count'] > 0;
    
    // Check if title column exists
    $checkTitleQuery = "SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                       WHERE TABLE_SCHEMA = 'casting_erp' 
                       AND TABLE_NAME = 'to_do_tasks' 
                       AND COLUMN_NAME = 'title'";
    $stmt = $pdo->prepare($checkTitleQuery);
    $stmt->execute();
    $titleExists = $stmt->fetch()['count'] > 0;
    
    // Get the column structure of to_do_tasks table to determine what fields we can use
    $columnsQuery = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_SCHEMA = 'casting_erp' 
                    AND TABLE_NAME = 'to_do_tasks'";
    $stmt = $pdo->prepare($columnsQuery);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($insufficientMaterials as $material) {
        // Check if a task already exists for this material and PO
        $existingTask = false;
        
        if ($relatedToExists) {
            $sql = "SELECT id FROM to_do_tasks 
                    WHERE related_to = 'material' 
                    AND related_id = ? 
                    AND status != 'completed'
                    AND description LIKE ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $material['material_id'],
                "%for purchase order #{$material['po_number']}%"
            ]);
            $existingTask = $stmt->fetch();
        } else {
            // Alternative check if related_to column doesn't exist
            $sql = "SELECT id FROM to_do_tasks 
                    WHERE status != 'completed'
                    AND description LIKE ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "%{$material['material_name']}%for purchase order #{$material['po_number']}%"
            ]);
            $existingTask = $stmt->fetch();
        }
        
        if (!$existingTask) {
            // Create a new task
            $materialInfo = "Insufficient {$material['material_type']}: {$material['material_name']}";
            $description = "Need to create {$material['shortage']} units of {$material['material_name']} ({$material['material_type']}) " .
                           "for product {$material['product_name']} in purchase order #{$material['po_number']}. " .
                           "Current stock: {$material['stock_qty']}, Required: {$material['quantity_required']}";
            
            $taskData = [
                'description' => $description,
                'due_date' => date('Y-m-d', strtotime('+3 days')),
                'priority' => 'high',
                'status' => 'pending',
                'assigned_to' => 'production_manager'
            ];
            
            // Add title field if it exists
            if ($titleExists) {
                $taskData['title'] = $materialInfo;
            } else {
                // If no title field, prepend the material info to the description
                $taskData['description'] = $materialInfo . " - " . $description;
            }
            
            // Add related_to and related_id fields only if the columns exist
            if ($relatedToExists) {
                $taskData['related_to'] = 'material';
                $taskData['related_id'] = $material['material_id'];
            }
            
            $taskId = createTask($pdo, $taskData);
            
            if ($taskId) {
                $createdTasks[] = [
                    'task_id' => $taskId,
                    'material_name' => $material['material_name'],
                    'material_type' => $material['material_type'],
                    'shortage' => $material['shortage'],
                    'po_number' => $material['po_number']
                ];
            }
        }
    }
    
    return $createdTasks;
}

// Handle form submission
$message = '';
$messageType = '';
$createdTasks = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'check_materials') {
        // Check material requirements and create tasks
        $insufficientMaterials = checkMaterialRequirementsForPendingOrders($pdo);
        
        if (count($insufficientMaterials) > 0) {
            $createdTasks = createTasksForInsufficientMaterials($pdo, $insufficientMaterials);
            
            if (count($createdTasks) > 0) {
                $message = count($createdTasks) . " notification tasks created for insufficient materials.";
                $messageType = 'success';
            } else {
                $message = "Insufficient materials found, but tasks already exist for them.";
                $messageType = 'info';
            }
        } else {
            $message = "All required materials have sufficient stock.";
            $messageType = 'success';
        }
    }
}

// Get all insufficient materials for display
$insufficientMaterials = checkMaterialRequirementsForPendingOrders($pdo);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Stock Alerts - Core & Sleeve Materials</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="check_materials">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sync-alt me-1"></i> Check Material Requirements
            </button>
        </form>
    </div>
    
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (count($createdTasks) > 0): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Created Tasks</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Task ID</th>
                                <th>Material</th>
                                <th>Type</th>
                                <th>Shortage</th>
                                <th>Purchase Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($createdTasks as $task): ?>
                                <tr>
                                    <td><?php echo $task['task_id']; ?></td>
                                    <td><?php echo htmlspecialchars($task['material_name']); ?></td>
                                    <td><?php echo ucfirst(htmlspecialchars($task['material_type'])); ?></td>
                                    <td><?php echo $task['shortage']; ?></td>
                                    <td><?php echo htmlspecialchars($task['po_number']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Insufficient Materials</h5>
        </div>
        <div class="card-body">
            <?php if (count($insufficientMaterials) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Type</th>
                                <th>Current Stock</th>
                                <th>Required</th>
                                <th>Shortage</th>
                                <th>Purchase Order</th>
                                <th>Product</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($insufficientMaterials as $material): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($material['material_name']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $material['material_type'] === 'core' ? 'primary' : 'secondary'; ?>">
                                            <?php echo ucfirst(htmlspecialchars($material['material_type'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo number_format($material['stock_qty'], 2); ?></td>
                                    <td><?php echo number_format($material['quantity_required'], 2); ?></td>
                                    <td class="text-danger"><?php echo number_format($material['shortage'], 2); ?></td>
                                    <td>
                                        <a href="purchase_order_details.php?id=<?php echo $material['po_id']; ?>">
                                            <?php echo htmlspecialchars($material['po_number']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($material['product_name']); ?></td>
                                    <td>
                                        <a href="materials.php" class="btn btn-sm btn-info">
                                            <i class="fas fa-boxes"></i> View Materials
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> All core and sleeve materials have sufficient stock for current orders.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 