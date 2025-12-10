<?php
require_once 'includes/config.php';
header('Content-Type: application/json');
$po_id = isset($_GET['po_id']) ? intval($_GET['po_id']) : 0;
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if ($po_id && $product_id) {
    // Get required quantity
    $stmt = $pdo->prepare('SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?');
    $stmt->execute([$po_id, $product_id]);
    $required = (float)($stmt->fetchColumn() ?: 0);
    // Get completed quantity
    $stmt2 = $pdo->prepare('SELECT COALESCE(SUM(mould_quantity), 0) FROM moulding_batches WHERE po_id = ? AND product_id = ?');
    $stmt2->execute([$po_id, $product_id]);
    $completed = (float)($stmt2->fetchColumn() ?: 0);
    echo json_encode(['success' => true, 'required' => $required, 'completed' => $completed]);
} else {
    echo json_encode(['success' => false, 'required' => 0, 'completed' => 0]);
} 