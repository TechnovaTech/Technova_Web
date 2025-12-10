<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Require login
requireLogin();

// Redirect based on user role
$userRole = getUserRole();

// Redirect specific roles to their dedicated dashboards
switch ($userRole) {
    case 'melting operator':
        header('Location: melting.php');
        exit;
    case 'moulding operator':
        header('Location: moulding.php');
        exit;
    case 'knockout operator':
        header('Location: knockout.php');
        exit;
    case 'pouring operator':
        header('Location: pouring.php');
        exit;
    case 'shot_blasting':
        header('Location: shot_blasting.php');
        exit;
    case 'fettling':
        header('Location: fettling.php');
        exit;
    case 'dispatch':
        header('Location: dispatch.php');
        exit;
    case 'qc':
        header('Location: rejection.php');
        exit;
}

// For admin, manager, and other roles, show the main dashboard
require_once 'includes/header.php';
$current_page = 'index';

// Get counts for dashboard widgets
// Get pending purchase orders
$sql = "SELECT COUNT(*) as count FROM purchase_orders WHERE status = 'pending'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();
$pendingPOs = $result['count'];

// Get low stock materials
$sql = "SELECT COUNT(*) as count FROM materials WHERE stock_qty < 10";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();
$lowStockMaterials = $result['count'];

// Get pending tasks
$sql = "SELECT COUNT(*) as count FROM to_do_tasks WHERE status = 'pending'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();
$pendingTasks = $result['count'];

// Get low stock packaging boxes
$sql = "SELECT COUNT(*) as count FROM packaging_boxes WHERE current_stock < min_level";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();
$lowStockBoxes = $result['count'];

// Get count of insufficient core and sleeve materials
$sql = "SELECT COUNT(*) as count FROM materials m
        WHERE m.type IN ('core', 'sleeve') 
        AND m.stock_qty < (
            SELECT SUM(pm.quantity_required) 
            FROM po_materials pm 
            JOIN purchase_orders po ON pm.po_id = po.id 
            WHERE pm.material_id = m.id 
            AND po.status = 'pending'
        )";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();
$insufficientMaterials = $result['count'];

// Get recent dispatches
$sql = "SELECT d.*, c.name as customer_name, GROUP_CONCAT(p.name SEPARATOR ', ') as product_names
        FROM dispatch d
        LEFT JOIN customers c ON d.customer_id = c.id
        LEFT JOIN dispatch_items di ON di.dispatch_id = d.id
        LEFT JOIN products p ON di.product_id = p.id
        GROUP BY d.id
        ORDER BY d.date DESC LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$recentDispatches = $stmt->fetchAll();
?>

<h1 class="page-title">Dashboard</h1>

<!-- Status Widgets -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body dashboard-stat" style="background-color: #3498db;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><?= $pendingPOs ?></h2>
                        <p>Pending Orders</p>
                    </div>
                    <div>
                        <i class="fas fa-file-invoice fa-3x opacity-50"></i>
                    </div>
                </div>
                <a href="purchase_orders.php" class="btn btn-sm btn-light mt-3">View Orders</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body dashboard-stat" style="background-color: #f39c12;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><?= $lowStockMaterials ?></h2>
                        <p>Low Stock Materials</p>
                    </div>
                    <div>
                        <i class="fas fa-boxes fa-3x opacity-50"></i>
                    </div>
                </div>
                <a href="materials.php" class="btn btn-sm btn-light mt-3">View Materials</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body dashboard-stat" style="background-color: #e74c3c;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><?= $pendingTasks ?></h2>
                        <p>Pending Tasks</p>
                    </div>
                    <div>
                        <i class="fas fa-tasks fa-3x opacity-50"></i>
                    </div>
                </div>
                <a href="to_do_tasks.php" class="btn btn-sm btn-light mt-3">View Tasks</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body dashboard-stat" style="background-color: #e67e22;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><?= $insufficientMaterials ?></h2>
                        <p>Core/Sleeve Alerts</p>
                    </div>
                    <div>
                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                    </div>
                </div>
                <a href="stock_alerts.php" class="btn btn-sm btn-light mt-3">View Alerts</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity and Quick Links -->
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Dispatches</h5>
                <a href="dispatch.php" class="btn btn-sm btn-light mt-3">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Dispatch #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($recentDispatches) > 0): ?>
                                <?php foreach ($recentDispatches as $dispatch): ?>
                                <tr>
                                    <td><?= isset($dispatch['id']) ? $dispatch['id'] : 'N/A' ?></td>
                                    <td><?= isset($dispatch['customer_name']) ? htmlspecialchars($dispatch['customer_name']) : 'N/A' ?></td>
                                    <td><?= isset($dispatch['date']) ? formatDate($dispatch['date']) : 'N/A' ?></td>
                                    <td><?= isset($dispatch['product_names']) ? htmlspecialchars($dispatch['product_names']) : 'N/A' ?></td>
                                    <td><?= isset($dispatch['status']) ? htmlspecialchars($dispatch['status']) : 'N/A' ?></td>
                                    <td>
                                        <?php if(isset($dispatch['id'])): ?>
                                        <a href="gate_pass.php?id=<?php echo $dispatch['id']; ?>" class="btn btn-sm btn-success" title="Gate Pass">
                                            <i class="fas fa-qrcode"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No dispatches found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Production Summary Chart -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Production Summary</h5>
            </div>
            <div class="card-body">
                <canvas id="productionChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Quick Links -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Links</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="stock_alerts.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                            Stock Alerts
                            <?php if ($insufficientMaterials > 0): ?>
                            <span class="badge bg-danger ms-2"><?= $insufficientMaterials ?></span>
                            <?php endif; ?>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                    <a href="pouring.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-fill-drip me-2 text-primary"></i>
                            Pouring Operations
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                    <a href="shot_blasting.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-wind me-2 text-primary"></i>
                            Shot Blasting
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- System Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">System Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Database</span>
                        <span class="text-success">Connected</span>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Server Load</span>
                        <span>32%</span>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 32%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Storage</span>
                        <span>65%</span>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Production summary chart
    const ctx = document.getElementById('productionChart').getContext('2d');
    const productionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Production (units)',
                data: [65, 59, 80, 81, 56, 55],
                backgroundColor: '#3498db'
            }, {
                label: 'Dispatched (units)',
                data: [45, 50, 75, 60, 45, 40],
                backgroundColor: '#2ecc71'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>