<?php
require_once 'includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['sequence']) || !is_array($input['sequence'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid sequence data']);
    exit;
}

try {
    // Check if sequence_order column exists, if not create it
    $checkColumn = $pdo->query("SHOW COLUMNS FROM purchase_order_products LIKE 'sequence_order'");
    if ($checkColumn->rowCount() == 0) {
        $pdo->exec("ALTER TABLE purchase_order_products ADD COLUMN sequence_order INT DEFAULT 0");
    }
    
    $pdo->beginTransaction();
    
    foreach ($input['sequence'] as $item) {
        $sql = "UPDATE purchase_order_products SET sequence_order = ? WHERE purchase_order_id = ? AND product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item['sequence'], $item['po_id'], $item['product_id']]);
    }
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Sequence saved successfully']);
    
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>