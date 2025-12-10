<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

// Fetch all pending POs and their parts
$sql = "SELECT po.id as po_id, po.po_number, p.id as product_id, p.name as part_name, pop.quantity as part_qty
        FROM purchase_orders po
        JOIN purchase_order_products pop ON pop.purchase_order_id = po.id
        JOIN products p ON pop.product_id = p.id
        WHERE po.status = 'pending' ORDER BY po.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pending_parts = $stmt->fetchAll();

$rows = [];
foreach ($pending_parts as $row) {
    // Get all core BOM items and overrides for this part and PO
    $sql = "
        SELECT m.id as core_id, m.name as core_name, b.quantity_per_unit, o.per_unit as override_per_unit
        FROM bom_items b
        JOIN materials m ON b.material_id = m.id
        LEFT JOIN production_plan_bom_overrides o
            ON o.purchase_order_id = ? AND o.product_id = ? AND o.material_id = b.material_id
        WHERE b.product_id = ? AND b.material_type = 'core' AND m.type = 'core'
        UNION
        SELECT m.id as core_id, m.name as core_name, NULL as quantity_per_unit, o.per_unit as override_per_unit
        FROM production_plan_bom_overrides o
        JOIN materials m ON o.material_id = m.id
        LEFT JOIN bom_items b ON b.product_id = o.product_id AND b.material_id = o.material_id
        WHERE o.purchase_order_id = ? AND o.product_id = ? AND b.material_id IS NULL AND m.type = 'core'
    ";
    $stmt2 = $pdo->prepare($sql);
    $stmt2->execute([
        $row['po_id'], $row['product_id'], $row['product_id'],
        $row['po_id'], $row['product_id']
    ]);
    $cores = $stmt2->fetchAll();
    foreach ($cores as $core) {
        $per_unit = isset($core['override_per_unit']) && $core['override_per_unit'] !== null ? $core['override_per_unit'] : $core['quantity_per_unit'];
        if ($per_unit === null) continue; // skip if no per_unit value
        $required = $per_unit * $row['part_qty'];
        $stockStmt = $pdo->prepare("SELECT stock_qty FROM materials WHERE id = ?");
        $stockStmt->execute([$core['core_id']]);
        $available = (float)($stockStmt->fetchColumn() ?: 0);
        $shortage = max(0, $required - $available);
        $rows[] = [
            'po_number' => $row['po_number'],
            'part_name' => $row['part_name'],
            'core_name' => $core['core_name'],
            'required' => $required,
            'available' => $available,
            'shortage' => $shortage
        ];
    }
}
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Core Shop</h2>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Core Requirements by Purchase Order & Part</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>Part Name</th>
                            <th>Core Name</th>
                            <th>Required for Order</th>
                            <th>Available</th>
                            <th>Shortage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($rows) > 0): ?>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['po_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['part_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['core_name']); ?></td>
                                    <td><?php echo number_format($row['required'], 3); ?></td>
                                    <td><?php echo number_format($row['available'], 3); ?></td>
                                    <td class="<?php echo $row['shortage'] > 0 ? 'text-danger fw-bold' : 'text-success'; ?>">
                                        <?php echo $row['shortage'] > 0 ? number_format($row['shortage'], 3) : '0.000'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No pending core requirements found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>

<?php if (isset($_GET['debug']) && $_GET['debug'] == '1'): ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <strong>Debug Output</strong>
        </div>
        <div class="card-body">
            <h6>$pending_parts</h6>
            <pre><?php print_r($pending_parts); ?></pre>
            <h6>Per-PO $cores (first PO only)</h6>
            <pre><?php 
            if (!empty($pending_parts)) {
                $sql = "SELECT m.id as core_id, m.name as core_name, b.quantity_per_unit FROM bom_items b JOIN materials m ON b.material_id = m.id WHERE b.product_id = ? AND b.material_type = 'core'";
                $stmt2 = $pdo->prepare($sql);
                $stmt2->execute([$pending_parts[0]['product_id']]);
                $cores = $stmt2->fetchAll();
                print_r($cores);
            } else {
                echo 'No pending POs.';
            }
            ?></pre>
            <h6>$rows</h6>
            <pre><?php print_r($rows); ?></pre>
        </div>
    </div>
</div>
<?php endif; ?> 