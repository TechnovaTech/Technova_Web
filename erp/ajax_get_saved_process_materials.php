<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$process_name = isset($_GET['process_name']) ? trim($_GET['process_name']) : '';

if (!$po_id || !$product_id || empty($process_name)) {
    echo json_encode(['success' => false, 'error' => 'Missing required parameters.']);
    exit;
}

try {
    $sql = "SELECT pm.material_id, m.name, m.type FROM process_materials pm JOIN materials m ON pm.material_id = m.id WHERE pm.purchase_order_id = ? AND pm.product_id = ? AND pm.process_name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$po_id, $product_id, $process_name]);
    $saved_materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'saved_materials' => $saved_materials]);

} catch (Exception $e) {
    error_log('Error fetching saved process materials: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error.']);
} 