<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$process_name = 'Moulding';

if (!$po_id || !$product_id) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid PO or Product ID']);
    exit;
}

try {
    $sql = "
        SELECT m.id, m.name, m.type
        FROM process_materials pm
        JOIN materials m ON pm.material_id = m.id
        WHERE pm.purchase_order_id = ? AND pm.product_id = ? AND pm.process_name = ?
        ORDER BY m.name
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$po_id, $product_id, $process_name]);
    $materials = $stmt->fetchAll();
    echo json_encode(['success' => true, 'materials' => $materials]);
} catch(Exception $e) {
    error_log('Error fetching moulding materials: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error.']);
} 