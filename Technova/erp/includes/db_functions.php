<?php
// Database functions for the ERP system
// This file contains all the database functions previously in the models

// Purchase Order Functions
function getAllPurchaseOrders($pdo) {
    $sql = "SELECT po.*, c.name as customer_name, p.name as product_name 
            FROM purchase_orders po
            LEFT JOIN customers c ON po.customer_id = c.id
            LEFT JOIN products p ON po.product_id = p.id
            ORDER BY po.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getPurchaseOrderById($pdo, $id) {
    $sql = "SELECT po.*, c.name as customer_name, p.name as product_name 
            FROM purchase_orders po
            LEFT JOIN customers c ON po.customer_id = c.id
            LEFT JOIN products p ON po.product_id = p.id
            WHERE po.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getPurchaseOrdersByStatus($pdo, $status) {
    $sql = "SELECT po.*, c.name as customer_name, p.name as product_name 
            FROM purchase_orders po
            LEFT JOIN customers c ON po.customer_id = c.id
            LEFT JOIN products p ON po.product_id = p.id
            WHERE po.status = ?
            ORDER BY po.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status]);
    return $stmt->fetchAll();
}

function createPurchaseOrder($pdo, $data) {
    $sql = "INSERT INTO purchase_orders (po_number, customer_id, product_id, quantity, unit, 
            delivery_date, status, material_status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $data['po_number'], 
        $data['customer_id'], 
        $data['product_id'], 
        $data['quantity'], 
        $data['unit'], 
        $data['delivery_date'],
        $data['status'], 
        $data['material_status']
    ]);
    
    if ($result) {
        return $pdo->lastInsertId();
    }
    return false;
}

function updatePurchaseOrder($pdo, $id, $data) {
    $sql = "UPDATE purchase_orders SET 
            customer_id = ?, 
            product_id = ?, 
            quantity = ?, 
            unit = ?, 
            delivery_date = ?, 
            status = ?, 
            material_status = ?, 
            updated_at = NOW() 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['customer_id'], 
        $data['product_id'], 
        $data['quantity'], 
        $data['unit'], 
        $data['delivery_date'],
        $data['status'], 
        $data['material_status'],
        $id
    ]);
}

function deletePurchaseOrder($pdo, $id) {
    $sql = "DELETE FROM purchase_orders WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

// Customer Functions
function getAllCustomers($pdo) {
    $sql = "SELECT * FROM customers ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getCustomerById($pdo, $id) {
    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createCustomer($pdo, $data) {
    $sql = "INSERT INTO customers (name, contact_person, email, phone, address, city, state, pincode, gst_number, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $data['name'],
        $data['contact_person'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['city'],
        $data['state'],
        $data['pincode'],
        $data['gst_number']
    ]);
    
    if ($result) {
        return $pdo->lastInsertId();
    }
    return false;
}

function updateCustomer($pdo, $id, $data) {
    $sql = "UPDATE customers SET 
            name = ?, 
            contact_person = ?, 
            email = ?, 
            phone = ?, 
            address = ?, 
            city = ?, 
            state = ?, 
            pincode = ?, 
            gst_number = ?, 
            updated_at = NOW() 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['name'],
        $data['contact_person'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $data['city'],
        $data['state'],
        $data['pincode'],
        $data['gst_number'],
        $id
    ]);
}

function deleteCustomer($pdo, $id) {
    // First check if there are any purchase orders linked to this customer
    $checkSql = "SELECT COUNT(*) FROM purchase_orders WHERE customer_id = ?";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([$id]);
    $count = $checkStmt->fetchColumn();
    
    if ($count > 0) {
        // Customer has related purchase orders
        throw new Exception("Cannot delete customer because they have $count purchase orders. You must delete the purchase orders first.");
    }
    
    // If no related purchase orders, proceed with deletion
    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

// Product Functions
function getAllProducts($pdo) {
    $sql = "SELECT * FROM products ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getProductById($pdo, $id) {
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getMaterialRequirements($pdo, $product_id, $quantity) {
    $sql = "SELECT m.id, m.name, m.unit, m.current_stock, b.quantity as required_per_unit, 
            (b.quantity * ?) as total_required,
            CASE 
                WHEN (m.current_stock < (b.quantity * ?)) 
                THEN ((b.quantity * ?) - m.current_stock) 
                ELSE 0 
            END as deficit
            FROM bom b
            JOIN materials m ON b.material_id = m.id
            WHERE b.product_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$quantity, $quantity, $quantity, $product_id]);
    return $stmt->fetchAll();
}

// Material Functions
function getAllMaterials($pdo) {
    $sql = "SELECT * FROM materials ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getMaterialById($pdo, $id) {
    $sql = "SELECT * FROM materials WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function adjustMaterialStock($pdo, $id, $quantity) {
    $sql = "UPDATE materials SET current_stock = current_stock + ?, updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$quantity, $id]);
}

// Task Functions
function createTask($pdo, $data) {
    // Get all column names from the to_do_tasks table
    $columnsQuery = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_SCHEMA = 'casting_erp' 
                    AND TABLE_NAME = 'to_do_tasks'";
    $stmt = $pdo->prepare($columnsQuery);
    $stmt->execute();
    $availableColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Build the SQL query dynamically based on available columns
    $fields = [];
    $placeholders = [];
    $values = [];
    
    // Map data fields to database columns, only including those that exist
    foreach ($data as $field => $value) {
        if (in_array($field, $availableColumns)) {
            $fields[] = $field;
            $placeholders[] = '?';
            $values[] = $value;
        }
    }
    
    // Make sure we have created_at field if it exists
    if (in_array('created_at', $availableColumns) && !in_array('created_at', $fields)) {
        $fields[] = 'created_at';
        $placeholders[] = 'NOW()';
    }
    
    // Make sure we have at least one field to insert
    if (empty($fields)) {
        error_log("Error creating task: No valid fields to insert");
        return false;
    }
    
    $sql = "INSERT INTO to_do_tasks (" . implode(", ", $fields) . ") 
            VALUES (" . implode(", ", $placeholders) . ")";
    
    try {
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($values);
        
        if ($result) {
            return $pdo->lastInsertId();
        }
        
        error_log("Error creating task: Execute returned false");
        return false;
    } catch (PDOException $e) {
        // Log the error
        error_log("Error creating task: " . $e->getMessage());
        return false;
    }
}

function getAllTasks($pdo) {
    $sql = "SELECT * FROM to_do_tasks ORDER BY priority, created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getTasksByStatus($pdo, $status) {
    $sql = "SELECT * FROM to_do_tasks WHERE status = ? ORDER BY priority, created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status]);
    return $stmt->fetchAll();
}

// Helper Functions for Purchase Orders
function createMaterialTasks($pdo, $po_id, $requirements) {
    $po = getPurchaseOrderById($pdo, $po_id);
    
    foreach ($requirements as $item) {
        if ($item['deficit'] > 0) {
            $title = "Purchase {$item['deficit']} {$item['unit']} of {$item['name']}";
            $description = "Material required for PO #{$po['po_number']} - {$po['product_name']} (Quantity: {$po['quantity']})";
            $due_date = date('Y-m-d', strtotime('+3 days'));
            
            $task_data = [
                'title' => $title,
                'description' => $description,
                'due_date' => $due_date,
                'priority' => 'high',
                'status' => 'pending',
                'assigned_to' => 'inventory_manager',
                'related_to' => 'purchase_order',
                'related_id' => $po_id
            ];
            
            createTask($pdo, $task_data);
        }
    }
}

function deductMaterialsFromStock($pdo, $requirements) {
    foreach ($requirements as $item) {
        if ($item['total_required'] > 0) {
            // Deduct the required quantity from stock
            adjustMaterialStock($pdo, $item['id'], -$item['total_required']);
        }
    }
}

// CSRF Token Functions have been moved to functions.php

// Input Sanitization functions have been moved to functions.php
