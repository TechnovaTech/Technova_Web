<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Require login to access this page
requireLogin();

// Check if user has admin or manager role
if (!hasPermission('manager')) {
    setAlert('You do not have permission to access this page', 'danger');
    header('Location: ' . BASE_PATH);
    exit;
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    setAlert('No user ID provided', 'danger');
    header('Location: manage_users.php');
    exit;
}

$userId = (int)$_GET['id'];

// Log the attempt
error_log("Direct delete attempt for user ID: $userId");

// Don't allow deleting your own account
if ($userId == $_SESSION['user_id']) {
    setAlert('You cannot delete your own account', 'danger');
    header('Location: manage_users.php');
    exit;
}

try {
    // Check if user exists
    $checkStmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
    $checkStmt->execute([$userId]);
    $user = $checkStmt->fetch();
    
    if (!$user) {
        setAlert("User not found with ID: $userId", 'danger');
        error_log("Direct delete failed: User ID $userId not found");
        header('Location: manage_users.php');
        exit;
    }
    
    error_log("Found user to delete: {$user['username']} (ID: {$user['id']})");
    
    // Check for foreign key constraints
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $constraintViolations = [];
    
    foreach ($tables as $table) {
        if ($table == 'users') continue;
        
        $columns = $pdo->query("SHOW COLUMNS FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            if (in_array($column['Field'], ['user_id', 'created_by', 'updated_by', 'operator_id', 'inspector_id'])) {
                $checkSql = "SELECT COUNT(*) FROM `$table` WHERE `{$column['Field']}` = ?";
                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->execute([$userId]);
                $count = $checkStmt->fetchColumn();
                
                if ($count > 0) {
                    $constraintViolations[] = "Table '$table' has $count records with {$column['Field']} = $userId";
                }
            }
        }
    }
    
    if (!empty($constraintViolations)) {
        error_log("Foreign key constraint violations found: " . implode(", ", $constraintViolations));
        
        // Display constraint violations
        echo "<h1>Cannot Delete User</h1>";
        echo "<p>The following foreign key constraints prevent deletion:</p>";
        echo "<ul>";
        foreach ($constraintViolations as $violation) {
            echo "<li>$violation</li>";
        }
        echo "</ul>";
        echo "<p><a href='manage_users.php'>Back to Manage Users</a></p>";
        exit;
    }
    
    // Try to delete the user
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() > 0) {
        setAlert('User deleted successfully', 'success');
        error_log("Direct delete successful for user ID: $userId");
    } else {
        setAlert('Error: User found but deletion failed', 'danger');
        error_log("Direct delete failed despite user being found (ID: $userId)");
    }
} catch (PDOException $e) {
    setAlert('Error deleting user: ' . $e->getMessage(), 'danger');
    error_log("Exception during direct delete: " . $e->getMessage());
}

header('Location: manage_users.php');
exit; 