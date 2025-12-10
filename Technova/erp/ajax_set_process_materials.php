<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

// Get the raw POST data
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$po_id = $data['purchase_order_id'] ?? 0;
$part_id = $data['part_id'] ?? 0;
$process = $data['process'] ?? '';
$materials = $data['materials'] ?? [];

if (!$po_id || !$part_id || empty($process) || empty($materials)) {
    echo json_encode(['success' => false, 'error' => 'Missing required data.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // First, delete existing entries for this part and process to prevent duplicates
    $sql_delete = "DELETE FROM process_materials WHERE purchase_order_id = ? AND product_id = ? AND process_name = ?";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([$po_id, $part_id, $process]);

    // Now, insert the new materials
    $sql_insert = "INSERT INTO process_materials (purchase_order_id, product_id, process_name, material_id) VALUES (?, ?, ?, ?)";
    $stmt_insert = $pdo->prepare($sql_insert);

    foreach ($materials as $material_id) {
        $stmt_insert->execute([$po_id, $part_id, $process, (int)$material_id]);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Process materials saved successfully.']);

} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Error saving process materials: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error. Check server logs.']);
} 