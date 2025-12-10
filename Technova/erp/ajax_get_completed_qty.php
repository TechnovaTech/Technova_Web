<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$table = isset($_GET['table']) ? $_GET['table'] : 'pouring_batches';

if (!$po_id || !$product_id) {
    echo json_encode(['completed_qty' => 0]);
    exit;
}

if ($table === 'moulding_batches') {
    $stmt = $pdo->prepare("SELECT SUM(mould_quantity) as completed_qty FROM moulding_batches WHERE po_id = ? AND product_id = ?");
} else {
    $stmt = $pdo->prepare("SELECT SUM(quantity) as completed_qty FROM pouring_batches WHERE po_id = ? AND product_id = ?");
}
$stmt->execute([$po_id, $product_id]);
$row = $stmt->fetch();
$completed_qty = $row && $row['completed_qty'] ? (float)$row['completed_qty'] : 0;

echo json_encode(['completed_qty' => $completed_qty]); 