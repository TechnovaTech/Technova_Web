<?php
require_once 'includes/config.php';
header('Content-Type: application/json');
$po_id = isset($_GET['po_id']) ? intval($_GET['po_id']) : 0;
$part_id = isset($_GET['part_id']) ? intval($_GET['part_id']) : 0;
if ($po_id && $part_id) {
    $stmt = $pdo->prepare('SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?');
    $stmt->execute([$po_id, $part_id]);
    $processed = (float)($stmt->fetchColumn() ?: 0);
    echo json_encode(['success' => true, 'processed' => $processed]);
} else {
    echo json_encode(['success' => false, 'processed' => 0]);
} 