<?php
require_once 'includes/config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}
$po_id = isset($_POST['purchase_order_id']) ? (int)$_POST['purchase_order_id'] : 0;
$production_date = isset($_POST['production_date']) ? $_POST['production_date'] : null;
if (!$po_id || !$production_date) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid data']);
    exit;
}
$sql = "INSERT INTO production_plan_dates (purchase_order_id, production_date)
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE production_date = VALUES(production_date)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([$po_id, $production_date]);
echo json_encode(['success' => $result]); 