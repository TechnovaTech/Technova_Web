<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$process_name = 'Melting'; // Hardcoded for this endpoint

if (!$po_id || !$product_id) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid PO or Product ID']);
    exit;
}

try {
    // First, get the material IDs assigned to 'Melting' for this PO and product
    $sql_process_mats = "SELECT material_id FROM process_materials WHERE purchase_order_id = ? AND product_id = ? AND process_name = ?";
    $stmt_process_mats = $pdo->prepare($sql_process_mats);
    $stmt_process_mats->execute([$po_id, $product_id, $process_name]);
    $material_ids = $stmt_process_mats->fetchAll(PDO::FETCH_COLUMN);

    if (empty($material_ids)) {
        // If no materials are set for melting, return an empty array
        echo json_encode(['success' => true, 'materials' => []]);
        exit;
    }

    // Build the query to get full details for the assigned materials
    // This reuses the same calculation logic as the original materials script
    $placeholders = implode(',', array_fill(0, count($material_ids), '?'));
    $sql_details = "
        SELECT
            m.id,
            m.name,
            m.type,
            (COALESCE(o.per_unit, b.quantity_per_unit, 0) * pop.quantity) AS total_required
        FROM materials m
        JOIN purchase_order_products pop ON pop.purchase_order_id = ? AND pop.product_id = ?
        LEFT JOIN bom_items b ON m.id = b.material_id AND b.product_id = pop.product_id
        LEFT JOIN production_plan_bom_overrides o ON m.id = o.material_id AND o.product_id = pop.product_id AND o.purchase_order_id = pop.purchase_order_id
        WHERE m.id IN ($placeholders)
        GROUP BY m.id, m.name, m.type, pop.quantity
    ";

    $params = [$po_id, $product_id];
    $params = array_merge($params, $material_ids);

    $stmt_details = $pdo->prepare($sql_details);
    $stmt_details->execute($params);
    $materials_with_totals = $stmt_details->fetchAll();

    $results = [];
    foreach ($materials_with_totals as $mat) {
        // Calculate how much has already been melted for this material
        $meltedStmt = $pdo->prepare("SELECT SUM(melted_metal_kg) FROM melting_batches WHERE po_id = ? AND product_id = ? AND TRIM(LOWER(metal_type)) = TRIM(LOWER(?))");
        $meltedStmt->execute([$po_id, $product_id, $mat['name']]);
        $already_melted = (float)($meltedStmt->fetchColumn() ?: 0);
        $remainder = (float)$mat['total_required'] - $already_melted;

        // Only include materials that still have a remainder to be melted
        if ($remainder > 0.001) { // Using a small tolerance for floating point inaccuracies
            $results[] = [
                'id' => $mat['id'],
                'name' => $mat['name'],
                'type' => $mat['type'],
                'total_required' => $mat['total_required'],
                'already_melted' => $already_melted,
                'remainder' => $remainder
            ];
        }
    }

    echo json_encode(['success' => true, 'materials' => $results]);

} catch(Exception $e) {
    error_log("Error fetching melting materials: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
} 