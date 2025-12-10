<?php
require_once 'includes/config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}
$po_id = isset($_POST['purchase_order_id']) ? (int)$_POST['purchase_order_id'] : 0;
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$material_id = isset($_POST['material_id']) ? (int)$_POST['material_id'] : 0;
if (!$po_id || !$product_id || !$material_id) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid data']);
    exit;
}
$sql = "DELETE FROM production_plan_bom_overrides WHERE purchase_order_id = ? AND product_id = ? AND material_id = ?";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([$po_id, $product_id, $material_id]);
echo json_encode(['success' => $result]); 