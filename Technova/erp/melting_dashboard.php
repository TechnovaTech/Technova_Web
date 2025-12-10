<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php';

// Enforce login
requireLogin();

// Ensure user has melting role
if (getUserRole() !== 'melting operator' && !hasPermission('manager')) {
    setAlert('You do not have permission to access this page', 'danger');
    header('Location: ' . BASE_PATH);
    exit;
}

require_once 'includes/header.php';

// Get active purchase orders that need melting
$poStmt = $pdo->query("
    SELECT po.id, po.po_number, po.product_id, p.name as product_name, po.quantity, po.delivery_date, c.name as customer_name
    FROM purchase_orders po
    JOIN products p ON po.product_id = p.id
    JOIN customers c ON po.customer_id = c.id
    LEFT JOIN melting_batches mb ON po.id = mb.po_id
    WHERE po.status IN ('pending', 'processing') 
    AND mb.id IS NULL
    ORDER BY po.delivery_date ASC
");
$pendingOrders = $poStmt->fetchAll();

// Get recent melting batches by this operator
$userRole = getUserRole();
$userId = $_SESSION['user_id'];

$batchStmt = $pdo->prepare("
    SELECT mb.*, po.po_number, p.name as product_name
    FROM melting_batches mb
    JOIN purchase_orders po ON mb.po_id = po.id
    JOIN products p ON po.product_id = p.id
    WHERE mb.operator_id = ?
    ORDER BY mb.date DESC, mb.id DESC
    LIMIT 10
");
$batchStmt->execute([$userId]);
$recentBatches = $batchStmt->fetchAll();

// Get material inventory for melting
$materialStmt = $pdo->query("
    SELECT id, name, type, stock_qty, unit
    FROM materials
    WHERE type IN ('raw_material', 'metal', 'ingot')
    ORDER BY stock_qty DESC
");
$materials = $materialStmt->fetchAll();
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Melting Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Melting Operations</li>
    </ol>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-fire me-1"></i>
                    Pending Orders for Melting
                </div>
                <div class="card-body">
                    <?php if (empty($pendingOrders)): ?>
                        <div class="alert alert-info">No pending orders require melting at this time.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>PO Number</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Customer</th>
                                        <th>Delivery Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendingOrders as $order): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($order['po_number']) ?></td>
                                            <td><?= htmlspecialchars($order['product_name']) ?></td>
                                            <td><?= $order['quantity'] ?></td>
                                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                            <td><?= formatDate($order['delivery_date']) ?></td>
                                            <td>
                                                <a href="melting.php?po_id=<?= $order['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus me-1"></i> Create Batch
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i>
                    Your Recent Melting Batches
                </div>
                <div class="card-body">
                    <?php if (empty($recentBatches)): ?>
                        <div class="alert alert-info">You haven't created any melting batches yet.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Batch #</th>
                                        <th>PO #</th>
                                        <th>Product</th>
                                        <th>Metal Type</th>
                                        <th>Quantity (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentBatches as $batch): ?>
                                        <tr>
                                            <td><?= formatDate($batch['date']) ?></td>
                                            <td><?= htmlspecialchars($batch['batch_number']) ?></td>
                                            <td><?= htmlspecialchars($batch['po_number']) ?></td>
                                            <td><?= htmlspecialchars($batch['product_name']) ?></td>
                                            <td><?= htmlspecialchars($batch['metal_type']) ?></td>
                                            <td><?= $batch['melted_metal_kg'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-boxes me-1"></i>
                    Available Materials for Melting
                </div>
                <div class="card-body">
                    <?php if (empty($materials)): ?>
                        <div class="alert alert-warning">No materials found in inventory.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Material Name</th>
                                        <th>Type</th>
                                        <th>Available Quantity</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materials as $material): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($material['name']) ?></td>
                                            <td><?= htmlspecialchars($material['type']) ?></td>
                                            <td><?= $material['stock_qty'] ?></td>
                                            <td><?= htmlspecialchars($material['unit']) ?></td>
                                            <td>
                                                <?php if ($material['stock_qty'] <= 0): ?>
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                <?php elseif ($material['stock_qty'] < 100): ?>
                                                    <span class="badge bg-warning">Low Stock</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">In Stock</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mb-4">
        <a href="melting.php" class="btn btn-primary btn-lg">
            <i class="fas fa-fire me-1"></i> Go to Melting Operations
        </a>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?> 