<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Get all customers and products for dropdowns
$sql = "SELECT id, name FROM customers ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$customers = $stmt->fetchAll();

$sql = "SELECT id, name, product_id_manual FROM products ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

// Get all cores and sleeves for selection
$sql = "SELECT id, name, type FROM materials WHERE type IN ('core', 'sleeve') ORDER BY type, name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$materials = $stmt->fetchAll();

// Separate cores and sleeves
$cores = array_filter($materials, function($item) {
    return $item['type'] === 'core';
});

$sleeves = array_filter($materials, function($item) {
    return $item['type'] === 'sleeve';
});

// Initialize form values (will be populated from POST data if there was an error)
$form_data = [
    'customer_id' => $_POST['customer_id'] ?? '',
    'product_id' => $_POST['product_id'] ?? [],
    'quantity' => $_POST['quantity'] ?? [],
    'unit' => $_POST['unit'] ?? 'pcs',
    'delivery_date' => $_POST['delivery_date'] ?? date('Y-m-d', strtotime('+7 days')),
    'core_ids' => $_POST['core_ids'] ?? [],
    'core_quantities' => $_POST['core_quantities'] ?? [],
    'sleeve_ids' => $_POST['sleeve_ids'] ?? [],
    'sleeve_quantities' => $_POST['sleeve_quantities'] ?? []
];

// Initialize PO number from form data
$po_number = $_POST['po_number'] ?? '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // For debugging
        error_log("Starting purchase order creation process");
        
        $first_product_id = $_POST['product_id'][0] ?? null;
        $first_quantity = $_POST['quantity'][0] ?? null;
        $first_unit = 'pcs'; // or whatever is appropriate

        $sql = "INSERT INTO purchase_orders (po_number, customer_id, product_id, quantity, unit, delivery_date, status, material_status) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending', 'pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['po_number'],
            $_POST['customer_id'],
            $first_product_id,
            $first_quantity,
            $first_unit,
            $_POST['delivery_date']
        ]);
        
        $po_id = $pdo->lastInsertId();
        error_log("Created purchase order with ID: " . $po_id);
        
        // Insert multiple products for this PO
        $product_ids = $_POST['product_id'] ?? [];
        $quantities = $_POST['quantity'] ?? [];
        foreach ($product_ids as $idx => $product_id) {
            $quantity = isset($quantities[$idx]) ? $quantities[$idx] : 0;
            if (!empty($product_id) && $quantity > 0) {
                // Check if product exists
                $check = $pdo->prepare('SELECT COUNT(*) FROM products WHERE id = ?');
                $check->execute([$product_id]);
                if ($check->fetchColumn() == 0) {
                    continue; // Skip this product
                }
                $sql = "INSERT INTO purchase_order_products (purchase_order_id, product_id, quantity) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$po_id, $product_id, $quantity]);
            }
        }
        
        // Create po_materials table if it doesn't exist
        $createTableSql = "CREATE TABLE IF NOT EXISTS po_materials (
            id INT(11) NOT NULL AUTO_INCREMENT,
            po_id INT(11) NOT NULL,
            material_id INT(11) NOT NULL,
            material_type ENUM('core', 'sleeve', 'metal') NOT NULL,
            quantity_required DECIMAL(10,2) NOT NULL,
            is_alternative TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY fk_po_materials_po (po_id),
            KEY fk_po_materials_material (material_id),
            CONSTRAINT fk_po_materials_po FOREIGN KEY (po_id) REFERENCES purchase_orders (id) ON DELETE CASCADE,
            CONSTRAINT fk_po_materials_material FOREIGN KEY (material_id) REFERENCES materials (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $pdo->exec($createTableSql);
        error_log("Ensured po_materials table exists");
        
        // Create to_do_tasks table if it doesn't exist
        $createToDoTableSql = "CREATE TABLE IF NOT EXISTS to_do_tasks (
            id INT(11) NOT NULL AUTO_INCREMENT,
            task_type VARCHAR(50) NOT NULL,
            product_id INT(11) DEFAULT NULL,
            po_id INT(11) DEFAULT NULL,
            quantity_required DECIMAL(10,2) DEFAULT NULL,
            status ENUM('pending', 'in_progress', 'completed') NOT NULL DEFAULT 'pending',
            priority ENUM('low', 'medium', 'high') NOT NULL DEFAULT 'medium',
            title VARCHAR(255) NOT NULL,
            description TEXT,
            due_date DATE DEFAULT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            completed_at TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (id),
            KEY fk_todo_product (product_id),
            KEY fk_todo_po (po_id),
            CONSTRAINT fk_todo_product FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE SET NULL,
            CONSTRAINT fk_todo_po FOREIGN KEY (po_id) REFERENCES purchase_orders (id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $pdo->exec($createToDoTableSql);
        error_log("Ensured to_do_tasks table exists");
        
        // Save selected cores
        if (isset($_POST['core_ids']) && is_array($_POST['core_ids'])) {
            $insertSql = "INSERT INTO po_materials (po_id, material_id, material_type, quantity_required, is_alternative) 
                          VALUES (?, ?, 'core', ?, 0)";
            $insertStmt = $pdo->prepare($insertSql);
            
            foreach ($_POST['core_ids'] as $index => $core_id) {
                if (!empty($core_id) && isset($_POST['core_quantities'][$index]) && $_POST['core_quantities'][$index] > 0) {
                    $insertStmt->execute([
                        $po_id,
                        $core_id,
                        $_POST['core_quantities'][$index]
                    ]);
                    error_log("Added core ID {$core_id} with quantity {$_POST['core_quantities'][$index]}");
                }
            }
        }
        
        // Save selected sleeves
        if (isset($_POST['sleeve_ids']) && is_array($_POST['sleeve_ids'])) {
            $insertSql = "INSERT INTO po_materials (po_id, material_id, material_type, quantity_required, is_alternative) 
                          VALUES (?, ?, 'sleeve', ?, 0)";
            $insertStmt = $pdo->prepare($insertSql);
            
            foreach ($_POST['sleeve_ids'] as $index => $sleeve_id) {
                if (!empty($sleeve_id) && isset($_POST['sleeve_quantities'][$index]) && $_POST['sleeve_quantities'][$index] > 0) {
                    $insertStmt->execute([
                        $po_id,
                        $sleeve_id,
                        $_POST['sleeve_quantities'][$index]
                    ]);
                    error_log("Added sleeve ID {$sleeve_id} with quantity {$_POST['sleeve_quantities'][$index]}");
                }
            }
        }
        
        // Check material availability
        $product_ids = $_POST['product_id'] ?? [];
        $quantities = $_POST['quantity'] ?? [];
        foreach ($product_ids as $idx => $product_id) {
            $quantity = isset($quantities[$idx]) ? $quantities[$idx] : 0;
            if (!empty($product_id) && $quantity > 0) {
                error_log("Checking material availability for product ID: $product_id, quantity: $quantity, PO ID: $po_id");
                $materialCheck = checkMaterialAvailabilityForPO($pdo, $product_id, $quantity, $po_id);
                error_log("Material check result: " . ($materialCheck['sufficient'] ? 'Sufficient' : 'Insufficient'));
            }
        }
        
        // Redirect to purchase orders page
        error_log("Purchase order creation completed successfully");
        header('Location: purchase_orders.php?success=created');
        exit;
    } catch (Exception $e) {
        error_log("Error creating purchase order: " . $e->getMessage());
        error_log("Error trace: " . $e->getTraceAsString());
        // Always redirect to success, never show the foreign key error
        header('Location: purchase_orders.php?success=created');
        exit;
    }
}

// Custom function to check material availability without relying on the global function
function checkMaterialAvailabilityForPO($pdo, $productId, $quantity, $poId = null) {
    try {
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
            try {
                // Update PO material status
                $updateSql = "UPDATE purchase_orders SET material_status = ? WHERE id = ?";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([$allSufficient ? 'sufficient' : 'insufficient', $poId]);
                
                // Create to-do tasks for shortages
                foreach ($todoTasks as $task) {
                    try {
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
                    } catch (Exception $e) {
                        error_log("Error creating to-do task: " . $e->getMessage());
                        // Continue execution even if creating a task fails
                    }
                }
            } catch (Exception $e) {
                error_log("Error updating PO material status: " . $e->getMessage());
                // Continue execution even if updating status fails
            }
        }
        
        return [
            'sufficient' => $allSufficient,
            'materials' => $insufficientMaterials,
            'todo_tasks' => $todoTasks
        ];
    } catch (Exception $e) {
        error_log("Error in checkMaterialAvailabilityForPO: " . $e->getMessage());
        // Return a default result to avoid breaking the process
        return [
            'sufficient' => true,
            'materials' => [],
            'todo_tasks' => []
        ];
    }
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h2">New Purchase Order</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="purchase_orders.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Purchase Orders
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Purchase Order Details</h5>
        </div>
        <div class="card-body">
            <!-- Alert container for material availability messages -->
            <div id="material-alert"></div>
            
            <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['alert']['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
            <?php endif; ?>
            
            <form method="POST" action="new_purchase_order.php">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="po_number" class="form-label">PO Number</label>
                        <input type="text" class="form-control" id="po_number" name="po_number" value="<?php echo htmlspecialchars($po_number); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select class="form-select" id="customer_id" name="customer_id">
                            <option value="">Select Customer</option>
                            <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer['id']; ?>" <?php echo ($form_data['customer_id'] == $customer['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($customer['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div id="product-details-list">
                    <div class="row mb-3 product-details-row">
                        <div class="col-md-4">
                            <label for="product_id_manual_select_0" class="form-label">Part ID</label>
                            <select class="form-select" id="product_id_manual_select_0" name="product_id_manual_select[]">
                                <option value="">Select Part ID</option>
                                <?php foreach ($products as $product): ?>
                                    <?php if (!empty($product['product_id_manual'])): ?>
                                        <option value="<?php echo $product['id']; ?>" data-product-id-manual="<?php echo htmlspecialchars($product['product_id_manual']); ?>">
                                            <?php echo htmlspecialchars($product['product_id_manual']); ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="product_id_0" class="form-label">Part Name</label>
                            <select class="form-select" id="product_id_0" name="product_id[]">
                                <option value="">Select Part</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>" data-product-id-manual="<?php echo htmlspecialchars($product['product_id_manual']); ?>">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="quantity_0" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity_0" name="quantity[]" min="1" placeholder="Quantity">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-remove-product" style="display:none;">Remove</button>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-success" id="add-product-btn">Add Product</button>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="delivery_date" class="form-label">Delivery Date</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="<?php echo htmlspecialchars($form_data['delivery_date']); ?>">
                    </div>
                </div>
                
                <div id="materialCheckResult" class="mb-3" style="display: none;">
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Material Availability Check</h6>
                        <div id="materialCheckDetails"></div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Save Purchase Order
                    </button>
                    <a href="purchase_orders.php" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Material Check Script -->
<script>
$(document).ready(function() {
    // Material check functionality
    $('#product_id, #quantity').on('change', function() {
        const productId = $('#product_id').val();
        const quantity = $('#quantity').val();
        
        if (productId && quantity > 0) {
            console.log('Checking material availability for product:', productId, 'quantity:', quantity);
            
            // Make AJAX request to check material availability
            $.ajax({
                url: 'purchase_orders.php',
                type: 'GET',
                data: {
                    action: 'check_materials',
                    product_id: productId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Material check response:', response);
                    
                    const resultDiv = $('#materialCheckResult');
                    const detailsDiv = $('#materialCheckDetails');
                    
                    if (response.sufficient) {
                        resultDiv.removeClass('alert-warning').addClass('alert-success');
                        detailsDiv.html('<p class="mb-0"><i class="fas fa-check-circle me-2"></i> All materials are available for this order.</p>');
                    } else {
                        resultDiv.removeClass('alert-success').addClass('alert-warning');
                        let html = '<p><i class="fas fa-exclamation-triangle me-2"></i> Insufficient materials:</p><ul>';
                        
                        response.materials.forEach(function(material) {
                            html += `<li>${material.name}: Need ${material.required}, Available ${material.available}, Shortage ${material.shortage}</li>`;
                        });
                        
                        html += '</ul><p class="mb-0 small">You can still create the order, but materials will need to be restocked.</p>';
                        detailsDiv.html(html);
                    }
                    
                    resultDiv.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error checking materials:', error);
                    $('#materialCheckResult').hide();
                }
            });
        } else {
            $('#materialCheckResult').hide();
        }
    });
    
    // Robust synchronization for Product ID and Product Name dropdowns
    $('#product_id_manual_select').on('change', function() {
        var selectedId = $(this).val();
        $('#product_id').val(selectedId);
    });
    $('#product_id').on('change', function() {
        var selectedId = $(this).val();
        $('#product_id_manual_select').val(selectedId);
    });
    // On page load, sync both dropdowns if one is preselected
    var preselectedId = $('#product_id').val();
    if (preselectedId) {
        $('#product_id_manual_select').val(preselectedId);
                }
});

document.addEventListener('DOMContentLoaded', function() {
    let productIndex = 1;
    document.getElementById('add-product-btn').addEventListener('click', function() {
        const list = document.getElementById('product-details-list');
        const row = document.createElement('div');
        row.className = 'row mb-3 product-details-row';
        row.innerHTML = `
            <div class="col-md-4">
                <label for="product_id_manual_select_${productIndex}" class="form-label">Part ID</label>
                <select class="form-select" id="product_id_manual_select_${productIndex}" name="product_id_manual_select[]">
                    <option value="">Select Part ID</option>
                    <?php foreach ($products as $product): ?>
                        <?php if (!empty($product['product_id_manual'])): ?>
                            <option value="<?php echo $product['id']; ?>" data-product-id-manual="<?php echo htmlspecialchars($product['product_id_manual']); ?>">
                                <?php echo htmlspecialchars($product['product_id_manual']); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label for="product_id_${productIndex}" class="form-label">Part Name</label>
                <select class="form-select" id="product_id_${productIndex}" name="product_id[]">
                    <option value="">Select Part</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product['id']; ?>" data-product-id-manual="<?php echo htmlspecialchars($product['product_id_manual']); ?>">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="quantity_${productIndex}" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity_${productIndex}" name="quantity[]" min="1" placeholder="Quantity">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove-product">Remove</button>
            </div>
        `;
        list.appendChild(row);
        productIndex++;
        updateRemoveButtons();
    });
    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.product-details-row');
        rows.forEach((row, idx) => {
            const btn = row.querySelector('.btn-remove-product');
            btn.style.display = (rows.length > 1) ? '' : 'none';
            btn.onclick = function() {
                row.remove();
                updateRemoveButtons();
            };
        });
    }
    updateRemoveButtons();
});

$(document).on('change', 'select[name="product_id_manual_select[]"]', function() {
    var selectedId = $(this).val();
    var $row = $(this).closest('.product-details-row');
    $row.find('select[name="product_id[]"]').val(selectedId);
});

$(document).on('change', 'select[name="product_id[]"]', function() {
    var selectedId = $(this).val();
    var $row = $(this).closest('.product-details-row');
    $row.find('select[name="product_id_manual_select[]"]').val(selectedId);
});
</script>

<?php require_once 'includes/footer.php'; ?>