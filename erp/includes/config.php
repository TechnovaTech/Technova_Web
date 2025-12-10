<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$db_host = 'localhost';
$db_name = 'u801822335_casting_erp';
$db_user = 'u801822335_casting_erp';
$db_pass = 'Erp@139415';

// Application settings
define('APP_NAME', 'Investment Casting ERP');
define('APP_VERSION', '1.0.0');
define('BASE_PATH', '/erp/');
define('DEBUG_MODE', true);

// Timezone settings
date_default_timezone_set('Asia/Kolkata');

// Error reporting
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Helper functions
function setAlert($message, $type = 'success') {
    $_SESSION['alert'] = [
        'message' => $message,
        'type' => $type
    ];
}

function formatDate($date) {
    return date('d M Y', strtotime($date));
}

function formatDateTime($datetime) {
    return date('d M Y, h:i A', strtotime($datetime));
}

function formatCurrency($amount) {
    return '₹ ' . number_format($amount, 2);
}

// Sanitize input
function sanitize($input) {
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            $input[$key] = sanitize($value);
        }
    } else {
        $input = trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }
    return $input;
}

// Database connection - simple version
try {
    // Connect directly to the database
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    if (DEBUG_MODE) {
        die("Database connection failed: " . $e->getMessage());
    } else {
        die("Database connection failed. Please contact administrator.");
    }
}

// Initialize database with required tables
function initializeDatabase($pdo) {
    // Users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `password` varchar(255) NOT NULL,
        `name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `role` enum('Administrator','Manager','Operator') NOT NULL DEFAULT 'Operator',
        `active` tinyint(1) NOT NULL DEFAULT 1,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `last_login` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `username` (`username`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Create default admin user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`) 
                    VALUES ('admin', '$password', 'Administrator', 'admin@example.com', 'Administrator')");
        
        // Add demo users
        $managerPass = password_hash('manager123', PASSWORD_DEFAULT);
        $operatorPass = password_hash('operator123', PASSWORD_DEFAULT);
        
        $pdo->exec("INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`) 
                    VALUES ('manager', '$managerPass', 'Manager', 'manager@example.com', 'Manager')");
        
        $pdo->exec("INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`) 
                    VALUES ('operator', '$operatorPass', 'Operator', 'operator@example.com', 'Operator')");
    }
    
    // Add other required tables
    // Materials table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `materials` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `code` varchar(50) NOT NULL,
        `category` varchar(50) NOT NULL,
        `quantity` decimal(10,2) NOT NULL DEFAULT 0.00,
        `unit` varchar(20) NOT NULL,
        `min_stock` decimal(10,2) NOT NULL DEFAULT 0.00,
        `cost_per_unit` decimal(10,2) NOT NULL DEFAULT 0.00,
        `description` text DEFAULT NULL,
        `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `code` (`code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Purchase Orders table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `purchase_orders` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `po_number` varchar(50) NOT NULL,
        `customer_name` varchar(100) NOT NULL,
        `order_date` date NOT NULL,
        `delivery_date` date NOT NULL,
        `status` enum('pending','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
        `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
        `notes` text DEFAULT NULL,
        `created_by` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `po_number` (`po_number`),
        KEY `created_by` (`created_by`),
        CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Todo Tasks table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `todo` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text DEFAULT NULL,
        `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
        `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
        `due_date` date DEFAULT NULL,
        `assigned_to` int(11) DEFAULT NULL,
        `created_by` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `assigned_to` (`assigned_to`),
        KEY `created_by` (`created_by`),
        CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
        CONSTRAINT `todo_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Packaging Boxes table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `packaging_boxes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `box_type` varchar(50) NOT NULL,
        `dimensions` varchar(50) NOT NULL,
        `quantity` int(11) NOT NULL DEFAULT 0,
        `min_stock` int(11) NOT NULL DEFAULT 0,
        `cost_per_unit` decimal(10,2) NOT NULL DEFAULT 0.00,
        `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Rejections table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `rejections` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `po_id` int(11) NOT NULL,
        `quantity` int(11) NOT NULL,
        `reason` text NOT NULL,
        `rejection_date` date NOT NULL,
        `reported_by` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `po_id` (`po_id`),
        KEY `reported_by` (`reported_by`),
        CONSTRAINT `rejections_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
        CONSTRAINT `rejections_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Dispatch table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `dispatch` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `dispatch_number` varchar(50) NOT NULL,
        `po_id` int(11) NOT NULL,
        `customer_name` varchar(100) NOT NULL,
        `date` date NOT NULL,
        `quantity` int(11) NOT NULL,
        `status` enum('prepared','dispatched','delivered') NOT NULL DEFAULT 'prepared',
        `created_by` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `dispatch_number` (`dispatch_number`),
        KEY `po_id` (`po_id`),
        KEY `created_by` (`created_by`),
        CONSTRAINT `dispatch_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
        CONSTRAINT `dispatch_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    
    // Add sample data
    addSampleData($pdo);
}

// Add sample data for demo purposes
function addSampleData($pdo) {
    // Sample materials
    $materials = [
        ['name' => 'Aluminum Alloy A356', 'code' => 'ALU-A356', 'category' => 'Metal', 'quantity' => 500, 'unit' => 'kg', 'min_stock' => 100, 'cost_per_unit' => 250],
        ['name' => 'Stainless Steel 304', 'code' => 'SS-304', 'category' => 'Metal', 'quantity' => 300, 'unit' => 'kg', 'min_stock' => 50, 'cost_per_unit' => 350],
        ['name' => 'Ceramic Shell', 'code' => 'CER-SHL', 'category' => 'Ceramic', 'quantity' => 200, 'unit' => 'kg', 'min_stock' => 50, 'cost_per_unit' => 180],
        ['name' => 'Wax Pattern', 'code' => 'WAX-PAT', 'category' => 'Wax', 'quantity' => 50, 'unit' => 'kg', 'min_stock' => 20, 'cost_per_unit' => 400],
        ['name' => 'Brass Alloy', 'code' => 'BRS-ALY', 'category' => 'Metal', 'quantity' => 150, 'unit' => 'kg', 'min_stock' => 30, 'cost_per_unit' => 300]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO materials (name, code, category, quantity, unit, min_stock, cost_per_unit) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($materials as $material) {
        $stmt->execute([$material['name'], $material['code'], $material['category'], $material['quantity'], $material['unit'], $material['min_stock'], $material['cost_per_unit']]);
    }
    
    // Sample packaging boxes
    $boxes = [
        ['box_type' => 'Small Cardboard', 'dimensions' => '10x10x5', 'quantity' => 100, 'min_stock' => 20, 'cost_per_unit' => 15],
        ['box_type' => 'Medium Cardboard', 'dimensions' => '20x15x10', 'quantity' => 80, 'min_stock' => 15, 'cost_per_unit' => 25],
        ['box_type' => 'Large Cardboard', 'dimensions' => '30x20x15', 'quantity' => 50, 'min_stock' => 10, 'cost_per_unit' => 40],
        ['box_type' => 'Small Wooden', 'dimensions' => '12x12x8', 'quantity' => 30, 'min_stock' => 5, 'cost_per_unit' => 100],
        ['box_type' => 'Plastic Container', 'dimensions' => '25x25x20', 'quantity' => 40, 'min_stock' => 10, 'cost_per_unit' => 75]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO packaging_boxes (box_type, dimensions, quantity, min_stock, cost_per_unit) VALUES (?, ?, ?, ?, ?)");
    foreach ($boxes as $box) {
        $stmt->execute([$box['box_type'], $box['dimensions'], $box['quantity'], $box['min_stock'], $box['cost_per_unit']]);
    }
    
    // Sample purchase orders
    $orders = [
        ['po_number' => 'PO-2023-001', 'customer_name' => 'ABC Industries', 'order_date' => '2023-05-15', 'delivery_date' => '2023-06-15', 'status' => 'completed', 'total_amount' => 25000],
        ['po_number' => 'PO-2023-002', 'customer_name' => 'XYZ Manufacturing', 'order_date' => '2023-06-01', 'delivery_date' => '2023-07-01', 'status' => 'in_progress', 'total_amount' => 18500],
        ['po_number' => 'PO-2023-003', 'customer_name' => 'Global Parts Ltd', 'order_date' => '2023-06-10', 'delivery_date' => '2023-07-10', 'status' => 'pending', 'total_amount' => 32000],
        ['po_number' => 'PO-2023-004', 'customer_name' => 'Tech Components', 'order_date' => '2023-06-15', 'delivery_date' => '2023-07-15', 'status' => 'pending', 'total_amount' => 15000],
        ['po_number' => 'PO-2023-005', 'customer_name' => 'Precision Engineering', 'order_date' => '2023-06-20', 'delivery_date' => '2023-07-20', 'status' => 'pending', 'total_amount' => 27500]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO purchase_orders (po_number, customer_name, order_date, delivery_date, status, total_amount, created_by) VALUES (?, ?, ?, ?, ?, ?, 1)");
    foreach ($orders as $order) {
        $stmt->execute([$order['po_number'], $order['customer_name'], $order['order_date'], $order['delivery_date'], $order['status'], $order['total_amount']]);
    }
    
    // Sample todo tasks
    $tasks = [
        ['title' => 'Review casting design', 'description' => 'Review the new casting design for PO-2023-003', 'status' => 'pending', 'priority' => 'high', 'due_date' => '2023-06-25'],
        ['title' => 'Order more aluminum', 'description' => 'Place order for 200kg of aluminum alloy', 'status' => 'completed', 'priority' => 'medium', 'due_date' => '2023-06-20'],
        ['title' => 'Maintenance for furnace', 'description' => 'Schedule maintenance for the main furnace', 'status' => 'in_progress', 'priority' => 'high', 'due_date' => '2023-06-30'],
        ['title' => 'Quality check for PO-2023-002', 'description' => 'Perform final quality checks before dispatch', 'status' => 'pending', 'priority' => 'high', 'due_date' => '2023-06-28'],
        ['title' => 'Update inventory records', 'description' => 'Update the inventory records with recent material usage', 'status' => 'pending', 'priority' => 'low', 'due_date' => '2023-07-05']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO todo (title, description, status, priority, due_date, assigned_to, created_by) VALUES (?, ?, ?, ?, ?, 1, 1)");
    foreach ($tasks as $task) {
        $stmt->execute([$task['title'], $task['description'], $task['status'], $task['priority'], $task['due_date']]);
    }
    
    // Sample dispatches
    $dispatches = [
        ['dispatch_number' => 'DSP-2023-001', 'po_id' => 1, 'customer_name' => 'ABC Industries', 'date' => '2023-06-15', 'quantity' => 500, 'status' => 'delivered'],
        ['dispatch_number' => 'DSP-2023-002', 'po_id' => 2, 'customer_name' => 'XYZ Manufacturing', 'date' => '2023-06-20', 'quantity' => 300, 'status' => 'dispatched'],
        ['dispatch_number' => 'DSP-2023-003', 'po_id' => 2, 'customer_name' => 'XYZ Manufacturing', 'date' => '2023-06-25', 'quantity' => 200, 'status' => 'prepared']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO dispatch (dispatch_number, po_id, customer_name, date, quantity, status, created_by) VALUES (?, ?, ?, ?, ?, ?, 1)");
    foreach ($dispatches as $dispatch) {
        $stmt->execute([$dispatch['dispatch_number'], $dispatch['po_id'], $dispatch['customer_name'], $dispatch['date'], $dispatch['quantity'], $dispatch['status']]);
    }
}
?>
