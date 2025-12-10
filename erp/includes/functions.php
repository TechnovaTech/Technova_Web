<?php
// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        setAlert('Please login to access this page', 'warning');
        header('Location: ' . BASE_PATH . 'auth/login.php');
        exit;
    }
}

function getUserRoles() {
    if (isset($_SESSION['user_roles']) && is_array($_SESSION['user_roles'])) {
        return $_SESSION['user_roles'];
    }
    if (isset($_SESSION['user_role'])) {
        return array_map('trim', explode(',', $_SESSION['user_role']));
    }
    return ['user'];
}

// Update getUserRole to return the first role for backward compatibility
function getUserRole() {
    $roles = getUserRoles();
    return $roles[0] ?? 'user';
}

function hasPermission($required_role) {
    $user_roles = getUserRoles();
    // Define role hierarchy with all possible roles
    $roles = [
        'user' => 1, 
        'operator' => 1,
        'melting operator' => 2,
        'moulding operator' => 2,
        'knockout operator' => 2,
        'pouring operator' => 2,
        'shot_blasting' => 2,
        'fettling' => 2,
        'qc' => 2,
        'dispatch' => 2, 
        'production' => 3,
        'store_manager' => 3,
        'manager' => 4, 
        'admin' => 5,
        'Administrator' => 5
    ];
    $roleAliases = [
        'melting' => ['melting operator'],
        'moulding' => ['moulding operator'],
        'knockout' => ['knockout operator'],
        'pouring' => ['pouring operator']
    ];
    // Check all user roles
    foreach ($user_roles as $user_role) {
        $user_role = trim($user_role);
        if (!isset($roles[$user_role])) {
            continue;
        }
        if (isset($roleAliases[$required_role])) {
            foreach ($roleAliases[$required_role] as $aliasRole) {
                if ($user_role === $aliasRole) {
                    return true;
                }
            }
        }
        if (!isset($roles[$required_role])) {
            continue;
        }
        if ($roles[$user_role] >= $roles[$required_role]) {
            return true;
        }
    }
    return false;
}

// CSRF protection
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Utility functions
function sanitizeInput($input) {
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            $input[$key] = sanitizeInput($value);
        }
    } else {
        $input = trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }
    return $input;
}

// Only define these functions if they don't already exist
if (!function_exists('formatDate')) {
    function formatDate($date) {
        return date('d-m-Y', strtotime($date));
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount) {
        return '₹' . number_format($amount, 2);
    }
}

// Alert functions
if (!function_exists('setAlert')) {
    function setAlert($message, $type = 'info') {
        $_SESSION['alert'] = [
            'message' => $message,
            'type' => $type
        ];
    }
}

function getAlert() {
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
        return $alert;
    }
    return null;
}

// Database helper functions
function executeQuery($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch(PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

function getLastInsertId($pdo) {
    return $pdo->lastInsertId();
}

// BOM calculation functions
function calculateMaterialRequirements($pdo, $product_id, $quantity) {
    $sql = "SELECT material_type, material_name, quantity_per_unit 
            FROM bom_items 
            WHERE product_id = ?";
    $stmt = executeQuery($pdo, $sql, [$product_id]);
    
    $requirements = [];
    while ($row = $stmt->fetch()) {
        $requirements[] = [
            'material_type' => $row['material_type'],
            'material_name' => $row['material_name'],
            'required' => $row['quantity_per_unit'] * $quantity
        ];
    }
    
    return $requirements;
}

function checkMaterialAvailability($pdo, $requirements) {
    $availability = [];
    
    foreach ($requirements as $req) {
        $sql = "SELECT stock_qty FROM materials WHERE name = ?";
        $stmt = executeQuery($pdo, $sql, [$req['material_name']]);
        $material = $stmt->fetch();
        
        $available = $material ? $material['stock_qty'] : 0;
        $deficit = max(0, $req['required'] - $available);
        
        $availability[] = [
            'material_name' => $req['material_name'],
            'material_type' => $req['material_type'],
            'required' => $req['required'],
            'available' => $available,
            'deficit' => $deficit
        ];
    }
    
    return $availability;
}

function createProductionTasks($pdo, $po_id, $deficits) {
    foreach ($deficits as $deficit) {
        if ($deficit['deficit'] > 0) {
            $task_type = 'Create ' . ucfirst($deficit['material_type']);
            
            $sql = "INSERT INTO production_tasks (po_id, task_type, material_name, quantity_required, status, created_at) 
                    VALUES (?, ?, ?, ?, 'pending', NOW())";
            executeQuery($pdo, $sql, [$po_id, $task_type, $deficit['material_name'], $deficit['deficit']]);
        }
    }
}

// Stock management functions
function updateMaterialStock($pdo, $material_id, $quantity, $type, $reference) {
    // Add transaction record
    $sql = "INSERT INTO stock_transactions (material_id, transaction_type, quantity, reference, created_at) 
            VALUES (?, ?, ?, ?, NOW())";
    executeQuery($pdo, $sql, [$material_id, $type, $quantity, $reference]);
    
    // Update material stock
    $operator = ($type === 'add') ? '+' : '-';
    $sql = "UPDATE materials SET stock_qty = stock_qty $operator ? WHERE id = ?";
    executeQuery($pdo, $sql, [$quantity, $material_id]);
}

function getLowStockItems($pdo) {
    $sql = "SELECT * FROM materials WHERE stock_qty <= min_level ORDER BY stock_qty ASC";
    $stmt = executeQuery($pdo, $sql);
    return $stmt->fetchAll();
}

// Purchase Order Material Check
function checkPOMaterialAvailability($pdo, $productId, $quantity, $poId = null) {
    // Get product BOM with material details
    $sql = "SELECT m.id, m.name, m.type, m.stock_qty, b.quantity_per_unit, b.material_type 
            FROM bom_items b
            JOIN materials m ON b.material_id = m.id
            WHERE b.product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productId]);
    $materials = $stmt->fetchAll();
    
    $allSufficient = true;
    $insufficientMaterials = [];
    $todoTasks = [];
    
    foreach ($materials as $material) {
        $requiredAmount = $material['quantity_per_unit'] * $quantity;
        $currentStock = $material['stock_qty'];
        $shortage = max(0, $requiredAmount - $currentStock);
        
        $materialInfo = [
            'id' => $material['id'],
            'name' => $material['name'],
            'type' => $material['type'],
            'material_type' => $material['material_type'],
            'required' => $requiredAmount,
            'available' => $currentStock,
            'shortage' => $shortage,
            'sufficient' => ($currentStock >= $requiredAmount)
        ];
        
        if ($currentStock < $requiredAmount) {
            $allSufficient = false;
            $insufficientMaterials[] = $materialInfo;
            
            // Create to-do tasks for core and sleeve shortages
            if ($material['type'] == 'core' || $material['type'] == 'sleeve') {
                $todoTasks[] = [
                    'task_type' => 'create_' . $material['type'],
                    'product_id' => $productId,
                    'po_id' => $poId,
                    'quantity_required' => $shortage,
                    'material_id' => $material['id'],
                    'material_name' => $material['name']
                ];
            }
        }
    }
    
    // If PO ID is provided, update PO material status and create to-do tasks
    if ($poId) {
        // Update PO material status
        $updateSql = "UPDATE purchase_orders SET material_status = ? WHERE id = ?";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$allSufficient ? 'sufficient' : 'insufficient', $poId]);
        
        // Create to-do tasks for shortages
        foreach ($todoTasks as $task) {
            $taskSql = "INSERT INTO to_do_tasks (task_type, product_id, po_id, quantity_required, status, priority, title, description, due_date) 
                        VALUES (?, ?, ?, ?, 'pending', 'high', ?, ?, DATE_ADD(NOW(), INTERVAL 3 DAY))";
            
            $title = "Create {$task['quantity_required']} {$task['material_name']} for PO #$poId";
            $description = "Need to create {$task['quantity_required']} {$task['material_name']} ({$task['task_type']}) for product ID $productId in purchase order #$poId. Current stock is insufficient.";
            
            $taskStmt = $pdo->prepare($taskSql);
            $taskStmt->execute([
                $task['task_type'],
                $task['product_id'],
                $task['po_id'],
                $task['quantity_required'],
                $title,
                $description
            ]);
        }
    }
    
    return [
        'sufficient' => $allSufficient,
        'materials' => $insufficientMaterials,
        'todo_tasks' => $todoTasks
    ];
}

// Function to render rejection action buttons
function renderRejectionActions($rejectionId) {
    $html = '<div class="btn-group btn-group-sm">';
    $html .= '<a href="edit_rejection.php?id=' . $rejectionId . '" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>';
    $html .= '<a href="delete_rejection.php?id=' . $rejectionId . '" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>';
    $html .= '</div>';
    return $html;
}
?>
