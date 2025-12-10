<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    if ($name === '') {
        echo json_encode(['success' => false, 'message' => 'Type name cannot be empty.']);
        exit;
    }
    // Check if any material uses this type
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM materials WHERE type = ?');
    $stmt->execute([$name]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Cannot delete: This type is used by one or more materials.']);
        exit;
    }
    // Delete type
    $stmt = $pdo->prepare('DELETE FROM material_types WHERE name = ?');
    if ($stmt->execute([$name])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']); 