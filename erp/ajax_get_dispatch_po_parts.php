<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
if (!$po_id) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid PO ID']);
    exit;
}

// Get all parts and their required quantity for this PO
$sql = "SELECT p.id, p.name, pop.quantity 
        FROM purchase_order_products pop
        JOIN products p ON pop.product_id = p.id
        WHERE pop.purchase_order_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po_id]);
$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'parts' => $parts]); 