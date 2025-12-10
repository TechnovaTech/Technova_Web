<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Check if PO ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: bom.php');
    exit();
}

$po_id = $_GET['id'];

// Fetch purchase order details
$query = "SELECT po.*, po.po_number, c.name as customer_name, c.email as customer_email, c.phone as customer_phone,
          p.name as product_name, p.description as product_description, p.price
          FROM purchase_orders po
          JOIN customers c ON po.customer_id = c.id
          JOIN products p ON po.product_id = p.id
          WHERE po.id = ?";

$stmt = $pdo->prepare($query);
$stmt->execute([$po_id]);
$po = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$po) {
    $_SESSION['error'] = "Purchase order not found";
    header('Location: bom.php');
    exit();
}

// Fetch all products for this purchase order
$sql = "SELECT pop.*, p.name AS product_name FROM purchase_order_products pop JOIN products p ON pop.product_id = p.id WHERE pop.purchase_order_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po_id]);
$order_products = $stmt->fetchAll();

// Fetch total rejected quantity for this PO
$rejectionQuery = "SELECT SUM(quantity) as total_rejected FROM rejections WHERE po_id = ?";
$rejectionStmt = $pdo->prepare($rejectionQuery);
$rejectionStmt->execute([$po_id]);
$totalRejectedQty = (int)($rejectionStmt->fetchColumn() ?: 0);

// Calculate material requirements for all products in the order
$materialRequirementsMap = [];
if (!empty($order_products)) {
    foreach ($order_products as $prod) {
        $product_id = $prod['product_id'];
        $quantity = $prod['quantity'];
        // Fetch BOM items and overrides for this product and PO
        $sql = "
            SELECT m.id as material_id, m.name, m.stock_qty as current_stock, m.unit, m.type as material_type, b.quantity_per_unit, o.per_unit as override_per_unit
            FROM bom_items b
            JOIN materials m ON b.material_id = m.id
            LEFT JOIN production_plan_bom_overrides o
                ON o.purchase_order_id = ? AND o.product_id = ? AND o.material_id = b.material_id
            WHERE b.product_id = ?
            UNION
            SELECT m.id as material_id, m.name, m.stock_qty as current_stock, m.unit, m.type as material_type, NULL as quantity_per_unit, o.per_unit as override_per_unit
            FROM production_plan_bom_overrides o
            JOIN materials m ON o.material_id = m.id
            LEFT JOIN bom_items b ON b.product_id = o.product_id AND b.material_id = o.material_id
            WHERE o.purchase_order_id = ? AND o.product_id = ? AND b.material_id IS NULL
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$po_id, $product_id, $product_id, $po_id, $product_id]);
        $bom_items = $stmt->fetchAll();
        foreach ($bom_items as $item) {
            $mat_id = $item['material_id'];
            $per_unit = isset($item['override_per_unit']) && $item['override_per_unit'] !== null ? $item['override_per_unit'] : $item['quantity_per_unit'];
            $required = $per_unit * $quantity;
            $rejected = $per_unit * $totalRejectedQty;
            if (!isset($materialRequirementsMap[$mat_id])) {
                $materialRequirementsMap[$mat_id] = [
                    'name' => $item['name'],
                    'material_type' => $item['material_type'],
                    'required' => 0,
                    'rejected' => 0,
                    'available' => $item['current_stock'],
                    'unit' => $item['unit'],
                    'quantity_per_unit' => $per_unit
                ];
            }
            $materialRequirementsMap[$mat_id]['required'] += $required;
            $materialRequirementsMap[$mat_id]['rejected'] += $rejected;
        }
    }
    // After summing, calculate shortage for each material
    $materialRequirements = [];
    foreach ($materialRequirementsMap as $mat_id => $mat) {
        $shortage = max(0, $mat['required'] - $mat['available']);
        $materialRequirements[] = [
            'name' => $mat['name'],
            'material_type' => $mat['material_type'],
            'required' => $mat['required'],
            'rejected' => $mat['rejected'],
            'available' => $mat['available'],
            'shortage' => $shortage,
            'unit' => $mat['unit'],
            'quantity_per_unit' => $mat['quantity_per_unit']
        ];
    }
} else {
    // fallback to single product logic for backward compatibility
    $materialReqQuery = "SELECT m.name, m.stock_qty as current_stock, b.quantity_per_unit, m.unit, m.type as material_type
        FROM bom_items b
        JOIN materials m ON b.material_id = m.id
        WHERE b.product_id = ?";
    $materialReqStmt = $pdo->prepare($materialReqQuery);
    $materialReqStmt->execute([$po['product_id']]);
    $materials = $materialReqStmt->fetchAll(PDO::FETCH_ASSOC);
    $materialRequirements = [];
    foreach ($materials as $material) {
        $requiredAmount = $material['quantity_per_unit'] * $po['quantity'];
        $rejectedAmount = $material['quantity_per_unit'] * $totalRejectedQty;
        $shortage = max(0, $requiredAmount - $material['current_stock']);
        $materialRequirements[] = [
            'name' => $material['name'],
            'material_type' => $material['material_type'],
            'required' => $requiredAmount,
            'rejected' => $rejectedAmount,
            'available' => $material['current_stock'],
            'shortage' => $shortage,
            'unit' => $material['unit'],
            'quantity_per_unit' => $material['quantity_per_unit']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Purchase Order - ERP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            
            <main class="">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Bill of Materials Details</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="bom.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Order Information</h5>
                                <table class="table">
                                    <tr>
                                        <th>PO Number:</th>
                                        <td><?php echo htmlspecialchars($po['po_number']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Order Date:</th>
                                        <td><?php echo htmlspecialchars($po['created_at']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge bg-<?php echo $po['status'] == 'completed' ? 'success' : 'warning'; ?>">
                                                <?php echo htmlspecialchars($po['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title">Customer Information</h5>
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td><?php echo htmlspecialchars($po['customer_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?php echo htmlspecialchars($po['customer_email']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td><?php echo htmlspecialchars($po['customer_phone']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="card-title">Product Information</h5>
                                <?php if (!empty($order_products)): ?>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Part Name</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Per Piece Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($order_products as $prod): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($prod['product_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($prod['description'] ?? ''); ?></td>
                                                    <td><?php echo number_format($prod['quantity'], 0); ?></td>
                                                    <td>
                                                        <?php
                                                        // Fetch price for this product
                                                        $sql = "SELECT price FROM products WHERE id = ?";
                                                        $stmt = $pdo->prepare($sql);
                                                        $stmt->execute([$prod['product_id']]);
                                                        $price = $stmt->fetchColumn();
                                                        echo $price !== false ? '₹ ' . number_format($price, 2) : '-';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo ($price !== false) ? '₹ ' . number_format($price * $prod['quantity'], 2) : '-';
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <table class="table">
                                        <tr>
                                            <th>Part Name:</th>
                                            <td><?php echo htmlspecialchars($po['product_name']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Description:</th>
                                            <td><?php echo htmlspecialchars($po['product_description']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Per Piece Price:</th>
                                            <td><?php echo isset($po['price']) ? '₹ ' . number_format($po['price'], 2) : '-'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Price:</th>
                                            <td><?php echo (isset($po['price']) && isset($po['quantity'])) ? '₹ ' . number_format($po['price'] * $po['quantity'], 2) : '-'; ?></td>
                                        </tr>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Materials Used Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="card-title">Material Requirements</h5>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Material Name</th>
                                            <th>Material Type</th>
                                            <th>Quantity Used</th>
                                            <th>Rejected Quantity</th>
                                            <th>Total Quantity Used</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($materialRequirements as $material): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($material['name']); ?></td>
                                            <td><?php echo htmlspecialchars(ucfirst($material['material_type'])); ?></td>
                                            <td><?php echo number_format($material['required'], 3); ?> <?php echo $material['unit']; ?></td>
                                            <td><?php echo number_format($material['rejected'], 3); ?> <?php echo $material['unit']; ?></td>
                                            <td><?php echo number_format($material['required'] + $material['rejected'], 3); ?> <?php echo $material['unit']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Rejected Materials Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="card-title">Rejected Materials</h5>
                                <?php
                                // Fetch rejection data for this PO
                                $rejectionQuery = "SELECT r.process_stage, r.quantity as rejected_qty, r.reason_code, r.created_at
                                    FROM rejections r
                                    WHERE r.po_id = ?
                                    ORDER BY r.created_at DESC";
                                $rejectionStmt = $pdo->prepare($rejectionQuery);
                                $rejectionStmt->execute([$po_id]);
                                $rejections = $rejectionStmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if (!empty($rejections)):
                                    $totalRejectedQty = 0;
                                    foreach ($rejections as $rejection) {
                                        $totalRejectedQty += $rejection['rejected_qty'];
                                    }
                                ?>
                                <div class="alert alert-warning">
                                    <strong>Total Rejected Quantity:</strong> <?php echo $totalRejectedQty; ?> pieces
                                </div>
                                
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Process Stage</th>
                                            <th>Rejected Quantity</th>
                                            <th>Reason</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rejections as $rejection): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars(ucfirst($rejection['process_stage'])); ?></td>
                                            <td><?php echo $rejection['rejected_qty']; ?> pieces</td>
                                            <td><?php echo htmlspecialchars($rejection['reason_code']); ?></td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($rejection['created_at'])); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                
                                <h6 class="mt-3">Materials Used for Rejected Items</h6>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Material Name</th>
                                            <th>Material Type</th>
                                            <th>Quantity Used for Rejected Items</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($materialRequirements as $material): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($material['name']); ?></td>
                                            <td><?php echo htmlspecialchars(ucfirst($material['material_type'])); ?></td>
                                            <td><?php echo number_format($material['quantity_per_unit'] * $totalRejectedQty, 3); ?> <?php echo $material['unit']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php else: ?>
                                <div class="alert alert-info">
                                    No rejections recorded for this purchase order.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html> 