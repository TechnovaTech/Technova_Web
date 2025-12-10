<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
if (!$po_id || !$product_id) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid PO or Product ID']);
    exit;
}

// Fetch all required materials for this part in this PO (from BOM and overrides)
$sql = "
    SELECT m.id, m.name, m.type,
        (COALESCE(o.per_unit, b.quantity_per_unit) * pop.quantity) AS total_required
    FROM bom_items b
    JOIN materials m ON b.material_id = m.id
    LEFT JOIN production_plan_bom_overrides o
        ON o.purchase_order_id = ? AND o.product_id = ? AND o.material_id = b.material_id
    JOIN purchase_order_products pop ON pop.purchase_order_id = ? AND pop.product_id = b.product_id
    WHERE b.product_id = ?
    UNION
    SELECT m.id, m.name, m.type,
        (o.per_unit * pop.quantity) AS total_required
    FROM production_plan_bom_overrides o
    JOIN materials m ON o.material_id = m.id
    LEFT JOIN bom_items b ON b.product_id = o.product_id AND b.material_id = o.material_id
    JOIN purchase_order_products pop ON pop.purchase_order_id = ? AND pop.product_id = o.product_id
    WHERE o.purchase_order_id = ? AND o.product_id = ? AND b.material_id IS NULL
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po_id, $product_id, $po_id, $product_id, $po_id, $po_id, $product_id]);
$materials = $stmt->fetchAll();

$results = [];
foreach ($materials as $mat) {
    // Sum melted_metal_kg for this PO, part, and material (case-insensitive match)
    $meltedStmt = $pdo->prepare("SELECT SUM(melted_metal_kg) FROM melting_batches WHERE po_id = ? AND product_id = ? AND TRIM(LOWER(metal_type)) = TRIM(LOWER(?))");
    $meltedStmt->execute([$po_id, $product_id, $mat['name']]);
    $already_melted = (float)($meltedStmt->fetchColumn() ?: 0);
    $remainder = (float)$mat['total_required'] - $already_melted;
    $results[] = [
        'id' => $mat['id'],
        'name' => $mat['name'],
        'type' => $mat['type'],
        'total_required' => $mat['total_required'],
        'already_melted' => $already_melted,
        'remainder' => $remainder
    ];
}

echo json_encode(['success' => true, 'materials' => $results]); 