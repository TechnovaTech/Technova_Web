<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

function has_remaining_melting_materials($pdo, $po_id, $product_id) {
    // 1. Get materials assigned to 'Melting' for this product from the plan
    $sql_process_mats = "SELECT material_id FROM process_materials WHERE purchase_order_id = ? AND product_id = ? AND process_name = 'Melting'";
    $stmt_process_mats = $pdo->prepare($sql_process_mats);
    $stmt_process_mats->execute([$po_id, $product_id]);
    $material_ids = $stmt_process_mats->fetchAll(PDO::FETCH_COLUMN);

    if (empty($material_ids)) {
        return false; // No materials assigned for melting, so part is "done"
    }

    // 2. For each assigned material, check if it's fully melted
    foreach ($material_ids as $material_id) {
        // Calculate total required for this material
        $sql_total = "
            SELECT
                (COALESCE(o.per_unit, b.quantity_per_unit, 0) * pop.quantity) AS total_required,
                m.name as material_name
            FROM purchase_order_products pop
            JOIN materials m ON m.id = ?
            LEFT JOIN bom_items b ON m.id = b.material_id AND b.product_id = pop.product_id
            LEFT JOIN production_plan_bom_overrides o ON m.id = o.material_id AND o.product_id = pop.product_id AND o.purchase_order_id = pop.purchase_order_id
            WHERE pop.purchase_order_id = ? AND pop.product_id = ?
        ";
        $stmt_total = $pdo->prepare($sql_total);
        $stmt_total->execute([$material_id, $po_id, $product_id]);
        $req_data = $stmt_total->fetch();

        $total_required = (float)($req_data['total_required'] ?? 0);
        $material_name = $req_data['material_name'] ?? '';

        // Calculate already melted quantity from melting_batches
        $meltedStmt = $pdo->prepare("SELECT SUM(melted_metal_kg) FROM melting_batches WHERE po_id = ? AND product_id = ? AND TRIM(LOWER(metal_type)) = TRIM(LOWER(?))");
        $meltedStmt->execute([$po_id, $product_id, $material_name]);
        $already_melted = (float)($meltedStmt->fetchColumn() ?: 0);

        // If even one material has a remainder, the part is not done yet.
        if (($total_required - $already_melted) > 0.001) {
            return true;
        }
    }

    // If the loop completes, all materials for this part are fully melted.
    return false;
}

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
if (!$po_id) {
    echo json_encode(['success' => false, 'parts' => []]);
    exit;
}

// Get all parts for the PO from purchase_order_products
$sql_parts = "SELECT p.id, p.name FROM purchase_order_products pop JOIN products p ON pop.product_id = p.id WHERE pop.purchase_order_id = ?";
$stmt_parts = $pdo->prepare($sql_parts);
$stmt_parts->execute([$po_id]);
$all_parts = $stmt_parts->fetchAll();

$meltable_parts = [];
foreach ($all_parts as $part) {
    if (has_remaining_melting_materials($pdo, $po_id, $part['id'])) {
        $meltable_parts[] = $part;
    }
}

echo json_encode(['success' => true, 'parts' => $meltable_parts]); 