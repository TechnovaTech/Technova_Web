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
$all_parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$parts = [];
foreach ($all_parts as $part) {
    $product_id = $part['id'];
    $required_qty = (float)$part['quantity'];
    // Get already processed quantity for this PO and part (sum of knockout_batches.pieces_processed)
    $stmt_proc = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?");
    $stmt_proc->execute([$po_id, $product_id]);
    $already_processed = (float)($stmt_proc->fetchColumn() ?: 0);
    if ($required_qty - $already_processed > 0.001) {
        $parts[] = $part;
    }
}

echo json_encode(['success' => true, 'parts' => $parts]); 