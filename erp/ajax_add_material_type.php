<?php
require_once 'includes/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    if ($name === '') {
        echo json_encode(['success' => false, 'message' => 'Type name cannot be empty.']);
        exit;
    }
    // Check if type already exists
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM material_types WHERE name = ?');
    $stmt->execute([$name]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Type already exists.']);
        exit;
    }
    // Insert new type
    $stmt = $pdo->prepare('INSERT INTO material_types (name) VALUES (?)');
    if ($stmt->execute([$name])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']); 