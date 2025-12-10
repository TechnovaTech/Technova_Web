<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Function to check material requirements and update material_status
function updateMaterialStatus($pdo, $po_id) {
    // Get purchase order details
    $sql = "SELECT po.*, p.id as product_id FROM purchase_orders po 
            JOIN products p ON po.product_id = p.id 
            WHERE po.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$po_id]);
    $po = $stmt->fetch();
    
    if (!$po) {
        return false;
    }
    
    // Get materials required for this product
    $sql = "SELECT m.name, m.stock_qty as current_stock, b.quantity_per_unit, m.unit
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
    $stmt->execute([$status, $po_id]);
    
    return $allSufficient;
}

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: purchase_orders.php');
    exit;
}

$id = (int)$_GET['id'];

// Update material status before displaying
updateMaterialStatus($pdo, $id);

// Get purchase order details
$sql = "SELECT po.*, c.name as customer_name, p.name as product_name, p.description as product_description, p.price
        FROM purchase_orders po 
        JOIN customers c ON po.customer_id = c.id 
        JOIN products p ON po.product_id = p.id 
        WHERE po.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$po = $stmt->fetch();

if (!$po) {
    header('Location: purchase_orders.php');
    exit;
}

// Get materials required for this product
$sql = "SELECT m.name, m.stock_qty as current_stock, b.quantity_per_unit, m.unit
        FROM bom_items b
        JOIN materials m ON b.material_id = m.id
        WHERE b.product_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po['product_id']]);
$materials = $stmt->fetchAll();

// Get specific cores and sleeves for this purchase order
$sql = "SELECT pm.*, m.name as material_name, m.unit 
        FROM po_materials pm
        JOIN materials m ON pm.material_id = m.id
        WHERE pm.po_id = ? AND pm.material_type IN ('core', 'sleeve')
        ORDER BY pm.material_type, m.name";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$poMaterials = $stmt->fetchAll();

// Separate cores and sleeves
$cores = array_filter($poMaterials, function($item) {
    return $item['material_type'] === 'core';
});

$sleeves = array_filter($poMaterials, function($item) {
    return $item['material_type'] === 'sleeve';
});

// Get all products for this purchase order
$sql = "SELECT pop.*, p.name AS product_name FROM purchase_order_products pop JOIN products p ON pop.product_id = p.id WHERE pop.purchase_order_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$order_products = $stmt->fetchAll();

// Fetch all products for price lookup
$sql = "SELECT id, name, price FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate material requirements for all products in the order
$materialRequirementsMap = [];
if (!empty($order_products)) {
    foreach ($order_products as $prod) {
        $product_id = $prod['product_id'];
        $quantity = $prod['quantity'];
        // Fetch BOM items for this product
        $sql = "SELECT b.material_id, m.name, m.type as material_type, m.stock_qty as current_stock, b.quantity_per_unit, m.unit FROM bom_items b JOIN materials m ON b.material_id = m.id WHERE b.product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id]);
        $bom_items = $stmt->fetchAll();
        foreach ($bom_items as $item) {
            $mat_id = $item['material_id'];
            $required = $item['quantity_per_unit'] * $quantity;
            if (!isset($materialRequirementsMap[$mat_id])) {
                $materialRequirementsMap[$mat_id] = [
                    'name' => $item['name'],
                    'type' => $item['material_type'],
                    'required' => 0,
                    'available' => $item['current_stock'],
                    'unit' => $item['unit']
                ];
            }
            $materialRequirementsMap[$mat_id]['required'] += $required;
        }
    }
    // After summing, calculate shortage for each material
    $materialRequirements = [];
    foreach ($materialRequirementsMap as $mat_id => $mat) {
        $shortage = max(0, $mat['required'] - $mat['available']);
        $materialRequirements[] = [
            'name' => $mat['name'],
            'type' => $mat['type'],
            'required' => $mat['required'],
            'available' => $mat['available'],
            'shortage' => $shortage,
            'unit' => $mat['unit']
        ];
    }
} else {
    // fallback to single product logic for backward compatibility
    $materialRequirements = [];
    foreach ($materials as $material) {
        $requiredAmount = $material['quantity_per_unit'] * $po['quantity'];
        $shortage = max(0, $requiredAmount - $material['current_stock']);
        $materialRequirements[] = [
            'name' => $material['name'],
            'type' => isset($material['type']) ? $material['type'] : '',
            'required' => $requiredAmount,
            'available' => $material['current_stock'],
            'shortage' => $shortage,
            'unit' => $material['unit']
        ];
    }
}

// Fetch heat box details for this product
$hit_box = null;
$boxes_needed = 0;
$current_stock = 0;
if (!empty($po['product_id'])) {
    $sql = "SELECT hit_box_id, products_per_box FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$po['product_id']]);
    $product_box = $stmt->fetch();
    if (!empty($product_box['hit_box_id'])) {
        $sql = "SELECT * FROM hit_boxes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_box['hit_box_id']]);
        $hit_box = $stmt->fetch();
        $products_per_box = (int)$product_box['products_per_box'];
        $boxes_needed = ($products_per_box > 0) ? ceil($po['quantity'] / $products_per_box) : 0;
        $current_stock = isset($hit_box['stock']) ? (float)$hit_box['stock'] : 0;
    }
}

// Production stages functionality has been removed or not yet implemented
// Commented out to prevent SQL errors with non-existent table
/*
$sql = "SELECT * FROM production_stages WHERE po_id = ? ORDER BY stage_order";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$stages = $stmt->fetchAll();
*/
$stages = [];
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h2">Purchase Order: <?php echo htmlspecialchars($po['po_number']); ?></h1>
        <div>
            <a href="purchase_orders.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Orders
            </a>
            <?php if ($po['status'] === 'processing'): ?>
                <form method="POST" action="purchase_orders.php" style="display:inline;">
                    <input type="hidden" name="action" value="mark_completed">
                    <input type="hidden" name="po_id" value="<?php echo $po['id']; ?>">
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="fas fa-check me-2"></i> Mark as Completed
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($order_products)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Parts in this Order</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Part Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_products as $prod): ?>
                    <tr>
                        <td><?= htmlspecialchars($prod['product_name']) ?></td>
                        <td><?= number_format($prod['quantity'], 0) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Order Details -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="35%">PO Number:</th>
                                <td><?php echo htmlspecialchars($po['po_number']); ?></td>
                            </tr>
                            <tr>
                                <th>Customer:</th>
                                <td><?php echo htmlspecialchars($po['customer_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Parts:</th>
                                <td>
                                    <?php
                                    if (!empty($order_products)) {
                                        foreach ($order_products as $prod) {
                                            echo htmlspecialchars($prod['product_name']) . ' - ' . number_format($prod['quantity'], 0) . ' piece<br>';
                                        }
                                    } else {
                                        echo htmlspecialchars($po['product_name']) . ' - ' . number_format($po['quantity'], 0) . ' piece';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <?php
                                    $badge_class = '';
                                    switch ($po['status']) {
                                        case 'completed': $badge_class = 'success'; break;
                                        case 'processing': $badge_class = 'primary'; break;
                                        case 'pending': $badge_class = 'warning'; break;
                                        default: $badge_class = 'secondary';
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $badge_class; ?>"><?php echo ucfirst($po['status']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td><?php echo date('Y-m-d H:i', strtotime($po['created_at'])); ?></td>
                            </tr>
                            <?php if (!empty($po['notes'])): ?>
                            <tr>
                                <th>Notes:</th>
                                <td><?php echo nl2br(htmlspecialchars($po['notes'])); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Part Details</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($order_products)): ?>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Part Name</th>
                                    <th>Per Piece Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_products as $prod): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($prod['product_name']) ?></td>
                                        <td>
                                            <?php
                                            // Fetch price for this product
                                            $price = null;
                                            foreach ($products as $p) {
                                                if ($p['id'] == $prod['product_id']) {
                                                    $price = $p['price'] ?? null;
                                                    break;
                                                }
                                            }
                                            echo $price !== null ? '₹ ' . number_format($price, 2) : '-';
                                            ?>
                                        </td>
                                        <td><?= number_format($prod['quantity'], 0) ?></td>
                                        <td>
                                            <?php
                                            echo ($price !== null) ? '₹ ' . number_format($price * $prod['quantity'], 2) : '-';
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h5><?php echo htmlspecialchars($po['product_name']); ?></h5>
                        <?php if (!empty($po['product_description'])): ?>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($po['product_description'])); ?></p>
                        <?php endif; ?>
                        <table class="table table-borderless">
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
        </div>
    </div>

    <!-- Material Requirements -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Material Requirements</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Material Type</th>
                            <th>Required</th>
                            <th>Available</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materialRequirements as $material): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($material['name']); ?></td>
                            <td><?php echo htmlspecialchars($material['type']); ?></td>
                            <td><?php echo $material['required']; ?> <?php echo $material['unit']; ?></td>
                            <td><?php echo $material['available']; ?> <?php echo $material['unit']; ?></td>
                            <td>
                                <?php if ($material['shortage'] > 0): ?>
                                    <span class="text-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Shortage: <?php echo $material['shortage']; ?> <?php echo $material['unit']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Sufficient
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Heat Box Requirement -->
    <?php if ($hit_box): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Heat Box Requirement</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Heat Box Name</th>
                                <th>Products per Box</th>
                                <th>Boxes Needed</th>
                                <th>Current Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo htmlspecialchars($hit_box['name']); ?></td>
                                <td><?php echo $products_per_box; ?></td>
                                <td><?php echo $boxes_needed; ?></td>
                                <td><?php echo number_format($current_stock, 2); ?></td>
                                <td>
                                    <?php if ($current_stock >= $boxes_needed): ?>
                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>In Stock</span>
                                    <?php else: ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Shortage: <?php echo $boxes_needed - $current_stock; ?> Heat boxes</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Heat Box Requirement</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0">No heat box is associated with this product.</div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Production Stages -->
    <?php if (!empty($stages)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Production Stages</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Stage</th>
                            <th>Status</th>
                            <th>Started</th>
                            <th>Completed</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stages as $stage): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($stage['stage_name']); ?></td>
                            <td>
                                <?php
                                $badge_class = '';
                                switch ($stage['status']) {
                                    case 'completed': $badge_class = 'success'; break;
                                    case 'in_progress': $badge_class = 'primary'; break;
                                    case 'pending': $badge_class = 'warning'; break;
                                    default: $badge_class = 'secondary';
                                }
                                ?>
                                <span class="badge bg-<?php echo $badge_class; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $stage['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo $stage['started_at'] ? date('Y-m-d H:i', strtotime($stage['started_at'])) : '-'; ?></td>
                            <td><?php echo $stage['completed_at'] ? date('Y-m-d H:i', strtotime($stage['completed_at'])) : '-'; ?></td>
                            <td><?php echo !empty($stage['notes']) ? nl2br(htmlspecialchars($stage['notes'])) : '-'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
