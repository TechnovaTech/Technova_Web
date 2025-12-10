<?php
require_once 'includes/config.php';
header('Content-Type: application/json');
$po_id = isset($_GET['po_id']) ? intval($_GET['po_id']) : 0;
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if ($po_id && $product_id) {
    // Get total moulded quantity
    $stmt = $pdo->prepare('SELECT COALESCE(SUM(mould_quantity), 0) FROM moulding_batches WHERE po_id = ? AND product_id = ?');
    $stmt->execute([$po_id, $product_id]);
    $moulded = (float)($stmt->fetchColumn() ?: 0);
    // Get total poured quantity
    $stmt2 = $pdo->prepare('SELECT COALESCE(SUM(quantity), 0) FROM pouring_batches WHERE po_id = ? AND product_id = ?');
    $stmt2->execute([$po_id, $product_id]);
    $poured = (float)($stmt2->fetchColumn() ?: 0);
    echo json_encode(['success' => true, 'moulded' => $moulded, 'poured' => $poured]);
} else {
    echo json_encode(['success' => false, 'moulded' => 0, 'poured' => 0]);
} 