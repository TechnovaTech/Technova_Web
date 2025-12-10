<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
header('Content-Type: application/json');

$po_id = isset($_GET['po_id']) ? (int)$_GET['po_id'] : 0;
if (!$po_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid PO ID']);
    exit;
}

// Get all parts for this PO
$sql = "SELECT pop.product_id, p.name, p.unit, pop.quantity as po_quantity
        FROM purchase_order_products pop
        JOIN products p ON pop.product_id = p.id
        WHERE pop.purchase_order_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po_id]);
$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dispatchable_parts = [];
foreach ($parts as $part) {
    $product_id = $part['product_id'];
    // Get total fettling output for this PO and part
    $sql = "SELECT COALESCE(SUM(output_quantity), 0) as fettling_output FROM fettling WHERE po_id = ? AND product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$po_id, $product_id]);
    $fettling_output = (float)($stmt->fetchColumn() ?: 0);

    // Get total already dispatched for this PO and part
    $sql = "SELECT COALESCE(SUM(quantity), 0) as dispatched_qty FROM dispatch_items WHERE po_id = ? AND product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$po_id, $product_id]);
    $dispatched_qty = (float)($stmt->fetchColumn() ?: 0);

    $remaining = $fettling_output - $dispatched_qty;
    if ($remaining > 0.001) {
        $dispatchable_parts[] = [
            'id' => $product_id,
            'name' => $part['name'],
            'unit' => $part['unit'],
            'remaining' => $remaining,
            'fettling_output' => $fettling_output,
            'dispatched_qty' => $dispatched_qty,
            'po_quantity' => $part['po_quantity']
        ];
    }
}

echo json_encode(['success' => true, 'parts' => $dispatchable_parts]); 