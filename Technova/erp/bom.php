<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $po_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM purchase_orders WHERE id = ?");
    $stmt->bindParam(1, $po_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Purchase order deleted successfully";
    } else {
        $_SESSION['error'] = "Error deleting purchase order";
    }
    header('Location: bom.php');
    exit();
}

// Fetch all purchase orders with all parts for each order
$query = "SELECT po.id as po_id, po.po_number, po.created_at as order_date, c.name as customer_name, 
          pop.product_id, p.product_id_manual, p.name as product_name, pop.quantity as part_quantity, po.status
          FROM purchase_orders po
          JOIN customers c ON po.customer_id = c.id
          JOIN purchase_order_products pop ON pop.purchase_order_id = po.id
          JOIN products p ON pop.product_id = p.id
          ORDER BY po.created_at DESC, po.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group rows by PO ID for rowspan calculation
$grouped_orders = [];
foreach ($result as $row) {
    $grouped_orders[$row['po_id']][] = $row;
}

// Fetch production dates for all POs
$production_dates = [];
if ($result && count($result) > 0) {
    $po_ids = array_column($result, 'po_id');
    $in = str_repeat('?,', count($po_ids) - 1) . '?';
    $sql = "SELECT purchase_order_id, production_date FROM production_plan_dates WHERE purchase_order_id IN ($in)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($po_ids);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $production_dates[$row['purchase_order_id']] = $row['production_date'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill of Materials - ERP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .table thead th { vertical-align: middle; }
        .table td, .table th { vertical-align: middle; }
        .card-custom {
            border-radius: 1rem;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            border: none;
        }
        .status-badge {
            font-size: 0.95em;
            padding: 0.35em 0.8em;
            border-radius: 0.5em;
        }
        .action-btns .btn {
            margin-right: 0.25rem;
        }
        .action-btns .btn:last-child {
            margin-right: 0;
        }
        /* Add a thick border between different purchase orders */
        .po-separator {
            border-bottom: 3px solid rgb(97, 97, 97) !important;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container-fluid bg-light" style="min-height:100vh;">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            
            <main class="">
                <div class="mb-4">
                    <h2 class="fw-bold mb-3">Bill of Materials</h2>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bill of Materials</h5>
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" id="bomSearchInput" placeholder="Search...">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="bomTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>PO Number</th>
                                        <th>Order Date</th>
                                        <th>Production Date</th>
                                        <th>Customer</th>
                                        <th>Part ID</th>
                                        <th>Part Name</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && count($result) > 0): ?>
                                        <?php foreach ($grouped_orders as $po_id => $rows): ?>
                                            <?php $rowspan = count($rows); ?>
                                            <?php foreach ($rows as $i => $row): ?>
                                                <?php
                                                // Add a class to the last row of each PO for a thick border
                                                $last_row_class = ($i === $rowspan - 1) ? 'po-separator' : '';
                                                ?>
                                                <tr class="<?= $last_row_class ?>">
                                                    <?php if ($i === 0): ?>
                                                        <td class="fw-bold" rowspan="<?= $rowspan ?>"><?php echo htmlspecialchars($row['po_number']); ?></td>
                                                        <td rowspan="<?= $rowspan ?>"><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['order_date']))); ?></td>
                                                        <td rowspan="<?= $rowspan ?>"><?php echo isset($production_dates[$row['po_id']]) && $production_dates[$row['po_id']] ? htmlspecialchars(date('d-m-Y', strtotime($production_dates[$row['po_id']]))) : '-'; ?></td>
                                                        <td rowspan="<?= $rowspan ?>"><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                                    <?php endif; ?>
                                                    <td><?php echo htmlspecialchars($row['product_id_manual'] ?? $row['product_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                                    <td><?php echo number_format($row['part_quantity'], 0); ?></td>
                                                    <?php if ($i === 0): ?>
                                                        <td rowspan="<?= $rowspan ?>">
                                                            <?php if ($row['status'] == 'completed'): ?>
                                                                <span class="badge bg-success status-badge">Completed</span>
                                                            <?php elseif ($row['status'] == 'pending'): ?>
                                                                <span class="badge bg-warning text-dark status-badge">Pending</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary status-badge"><?php echo htmlspecialchars(ucfirst($row['status'])); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center action-btns" rowspan="<?= $rowspan ?>">
                                                            <a href="view_bom.php?id=<?php echo $row['po_id']; ?>" class="btn btn-sm btn-info" title="View Details">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="bom.php?delete=<?php echo $row['po_id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this purchase order?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No purchase orders found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Real-time search for BOM table
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('bomSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const filter = searchInput.value.toLowerCase();
                    const table = document.getElementById('bomTable');
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
</body>
</html> 