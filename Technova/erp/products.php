<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: products.php');
        exit;
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_product') {
        // Sanitize input
        $product_id_manual = sanitizeInput($_POST['product_id_manual']);
        $name = sanitizeInput($_POST['name']);
        $description = sanitizeInput($_POST['description']);
        $unit = sanitizeInput($_POST['unit']);
        $price = (float)$_POST['price'];
        $per_piece_weight = (float)$_POST['per_piece_weight'];
        $hit_box_id = !empty($_POST['hit_box_id']) ? (int)$_POST['hit_box_id'] : null;
        $products_per_box = !empty($_POST['products_per_box']) ? (int)$_POST['products_per_box'] : null;
        
        // Check for duplicate Product ID
        $sql = "SELECT COUNT(*) FROM products WHERE product_id_manual = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id_manual]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            setAlert("Product ID is not available.", 'danger');
            header('Location: products.php');
            exit;
        }
        
        // Insert product into database
        $sql = "INSERT INTO products (product_id_manual, name, description, unit, price, per_piece_weight, hit_box_id, products_per_box, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$product_id_manual, $name, $description, $unit, $price, $per_piece_weight, $hit_box_id, $products_per_box]);
        
        if ($result) {
            $product_id = $pdo->lastInsertId();
            
            // Add BOM items if provided
            if (isset($_POST['material_id']) && is_array($_POST['material_id'])) {
                $material_ids = $_POST['material_id'];
                $quantities = $_POST['quantity'];
                
                for ($i = 0; $i < count($material_ids); $i++) {
                    if (!empty($material_ids[$i]) && !empty($quantities[$i])) {
                        $material_id = (int)$material_ids[$i];
                        $quantity = (float)$quantities[$i];
                        
                        $sql = "INSERT INTO bom_items (product_id, material_id, quantity_per_unit, created_at) VALUES (?, ?, ?, NOW())";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$product_id, $material_id, $quantity]);
                    }
                }
            }
            
            setAlert("Product added successfully.", 'success');
        } else {
            setAlert("Error adding product.", 'danger');
        }
        
        header('Location: products.php');
        exit;
    }
    elseif ($action === 'update_product') {
        $id = (int)$_POST['id'];
        
        // Sanitize input
        $product_id_manual = sanitizeInput($_POST['product_id_manual']);
        $name = sanitizeInput($_POST['name']);
        $description = sanitizeInput($_POST['description']);
        $unit = sanitizeInput($_POST['unit']);
        $price = (float)$_POST['price'];
        $per_piece_weight = (float)$_POST['per_piece_weight'];
        $hit_box_id = !empty($_POST['hit_box_id']) ? (int)$_POST['hit_box_id'] : null;
        $products_per_box = !empty($_POST['products_per_box']) ? (int)$_POST['products_per_box'] : null;
        
        // Check for duplicate Product ID (excluding current product)
        $sql = "SELECT COUNT(*) FROM products WHERE product_id_manual = ? AND id != ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id_manual, $id]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            setAlert("Product ID is not available.", 'danger');
            header('Location: products.php');
            exit;
        }
        
        // Update product in database
        $sql = "UPDATE products SET 
                product_id_manual = ?,
                name = ?, 
                description = ?, 
                unit = ?, 
                price = ?, 
                per_piece_weight = ?,
                hit_box_id = ?,
                products_per_box = ?,
                updated_at = NOW() 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$product_id_manual, $name, $description, $unit, $price, $per_piece_weight, $hit_box_id, $products_per_box, $id]);
        
        if ($result) {
            setAlert("Product updated successfully.", 'success');
        } else {
            setAlert("Error updating product.", 'danger');
        }
        
        header('Location: products.php');
        exit;
    }
    elseif ($action === 'delete_product') {
        $id = (int)$_POST['id'];
        
        // Check if product is used in any purchase orders
        $sql = "SELECT COUNT(*) as count FROM purchase_orders WHERE product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            setAlert("Cannot delete product as it is used in Purchase Orders.", 'danger');
            header('Location: products.php');
            exit;
        }
        
        // Delete BOM entries for this product
        $sql = "DELETE FROM bom_items WHERE product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        // Delete product from database
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result) {
            setAlert("Product deleted successfully.", 'success');
        } else {
            setAlert("Error deleting product.", 'danger');
        }
        
        header('Location: products.php');
        exit;
    }
    elseif ($action === 'add_bom_item') {
        $product_id = (int)$_POST['product_id'];
        $material_id = (int)$_POST['material_id'];
        $quantity = (float)$_POST['quantity'];
        
        // Check if BOM item already exists
        $sql = "SELECT COUNT(*) as count FROM bom_items WHERE product_id = ? AND material_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id, $material_id]);
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            // Update existing BOM item
            $sql = "UPDATE bom_items SET quantity_per_unit = ?, updated_at = NOW() WHERE product_id = ? AND material_id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$quantity, $product_id, $material_id]);
        } else {
            // Insert new BOM item
            $sql = "INSERT INTO bom_items (product_id, material_id, quantity_per_unit, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$product_id, $material_id, $quantity]);
        }
        
        if ($result) {
            setAlert("BOM item added successfully.", 'success');
        } else {
            setAlert("Error adding BOM item.", 'danger');
        }
        
        header('Location: product_details.php?id=' . $product_id);
        exit;
    }
    elseif ($action === 'delete_bom_item') {
        $product_id = (int)$_POST['product_id'];
        $material_id = (int)$_POST['material_id'];
        
        // Delete BOM item
        $sql = "DELETE FROM bom_items WHERE product_id = ? AND material_id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$product_id, $material_id]);
        
        if ($result) {
            setAlert("BOM item deleted successfully.", 'success');
        } else {
            setAlert("Error deleting BOM item.", 'danger');
        }
        
        header('Location: product_details.php?id=' . $product_id);
        exit;
    }
}

// Get all products
$sql = "SELECT * FROM products ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

// Get all materials for BOM selection
$sql = "SELECT * FROM materials ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$materials = $stmt->fetchAll();

// Get all available hit boxes
$sql = "SELECT * FROM hit_boxes WHERE stock > 0 ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$hit_boxes = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Product Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus me-1"></i> Add New Part
        </button>
    </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Product List</h5>
            <div class="input-group" style="max-width: 300px;">
                <input type="text" class="form-control" id="productSearchInput" placeholder="Search products...">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="productTable">
                    <thead>
                        <tr>
                            <th>Part ID</th>
                            <th>Part Name</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Per Piece Weight</th>
                            <th>BOM Items</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($products) > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <?php
                                // Get BOM count for this product
                                $sql = "SELECT COUNT(*) as count FROM bom_items WHERE product_id = ?";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$product['id']]);
                                $bom_count = $stmt->fetch()['count'];
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['product_id_manual'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td><?php echo htmlspecialchars($product['unit']); ?></td>
                                    <td><?php echo formatCurrency($product['price']); ?></td>
                                    <td><?php echo isset($product['per_piece_weight']) ? number_format($product['per_piece_weight'], 3) : ''; ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo $bom_count; ?> materials</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" 
                                                    data-product-id="<?php echo $product['id']; ?>"
                                                    data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                                    data-product-description="<?php echo htmlspecialchars($product['description']); ?>"
                                                    data-product-unit="<?php echo htmlspecialchars($product['unit']); ?>"
                                                    data-product-price="<?php echo $product['price']; ?>"
                                                    data-product-id-manual="<?php echo htmlspecialchars($product['product_id_manual'] ?? ''); ?>"
                                                    data-per-piece-weight="<?php echo isset($product['per_piece_weight']) ? number_format($product['per_piece_weight'], 3) : ''; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal" 
                                                    data-product-id="<?php echo $product['id']; ?>"
                                                    data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No products found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="products.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_product">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="product_id_manual" class="form-label">Part ID</label>
                            <input type="text" class="form-control" id="product_id_manual" name="product_id_manual" required>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Part Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit</label>
                            <select class="form-select" id="unit" name="unit" required>
                                <option value="piece">Piece</option>
                                <option value="kg">Kg</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="per_piece_weight" class="form-label" id="weight_label">Per Piece Weight (Kg)</label>
                            <input type="number" class="form-control" id="per_piece_weight" name="per_piece_weight" step="0.001" min="0" required placeholder="Per Piece Weight in Kg" value="<?php echo isset($product['per_piece_weight']) ? number_format($product['per_piece_weight'], 3) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="mt-4 mb-3">Bill of Materials (Optional)</h6>
                    <div id="bom-items">
                        <div class="row mb-2 bom-item">
                            <div class="col-md-6">
                                <select class="form-select" name="material_id[]">
                                    <option value="">Select Material</option>
                                    <?php foreach ($materials as $material): ?>
                                        <option value="<?php echo $material['id']; ?>" data-unit="<?php echo htmlspecialchars($material['unit']); ?>">
                                            <?php echo htmlspecialchars($material['name']); ?> (<?php echo htmlspecialchars($material['type']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="quantity[]" step="0.001" min="0" placeholder="Quantity">
                                    <span class="input-group-text material-unit"></span>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-bom-item">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-secondary" id="add-bom-item">
                            <i class="fas fa-plus me-1"></i> Add Material
                        </button>
                    </div>

                    <!-- Heat Box association row -->
                    <div class="row mt-4 mb-3 align-items-end">
                        <div class="col-md-6">
                            <label for="hit_box_id" class="form-label">Heat Box (Available)</label>
                            <select class="form-select" id="hit_box_id" name="hit_box_id">
                                <option value="">Select Heat Box</option>
                                <?php foreach ($hit_boxes as $box): ?>
                                    <option value="<?php echo $box['id']; ?>">
                                        <?php echo htmlspecialchars($box['name']); ?> (Stock: <?php echo $box['stock']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="products_per_box" class="form-label">Cavity per Box</label>
                            <input type="number" class="form-control" id="products_per_box" name="products_per_box" min="1" placeholder="How many products in one box?">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Part</button>
                </div>
            </form>
        </div>  
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="products.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_product">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_product_id_manual" class="form-label">Part ID</label>
                            <input type="text" class="form-control" id="edit_product_id_manual" name="product_id_manual" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label">Part Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_unit" class="form-label">Unit</label>
                            <select class="form-select" id="edit_unit" name="unit" required>
                                <option value="piece">Piece</option>
                                <option value="kg">Kg</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_per_piece_weight" class="form-label" id="edit_weight_label">Per Piece Weight (Kg)</label>
                            <input type="number" class="form-control" id="edit_per_piece_weight" name="per_piece_weight" step="0.001" min="0" required placeholder="Per Piece Weight in Kg" value="<?php echo isset($product['per_piece_weight']) ? number_format($product['per_piece_weight'], 3) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="edit_price" name="price" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <small>To manage Bill of Materials, please use the Part Details view after saving.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Part</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Delete Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="products.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_product">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="delete_id">
                    
                    <p>Are you sure you want to delete part: <strong id="delete_name"></strong>?</p>
                    <p class="text-danger"><strong>Warning:</strong> This will also delete all Bill of Materials items for this part.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Product Modal
    const editProductModal = document.getElementById('editProductModal');
    if (editProductModal) {
        editProductModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('edit_id').value = button.getAttribute('data-product-id');
            document.getElementById('edit_product_id_manual').value = button.getAttribute('data-product-id-manual');
            document.getElementById('edit_name').value = button.getAttribute('data-product-name');
            document.getElementById('edit_description').value = button.getAttribute('data-product-description');
            
            const unitSelect = document.getElementById('edit_unit');
            const productUnit = button.getAttribute('data-product-unit');
            for (let i = 0; i < unitSelect.options.length; i++) {
                if (unitSelect.options[i].value === productUnit) {
                    unitSelect.options[i].selected = true;
                    break;
                }
            }
            
            document.getElementById('edit_price').value = button.getAttribute('data-product-price');
            document.getElementById('edit_per_piece_weight').value = button.getAttribute('data-per-piece-weight');
        });
    }
    
    // Delete Product Modal
    const deleteProductModal = document.getElementById('deleteProductModal');
    if (deleteProductModal) {
        deleteProductModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('delete_id').value = button.getAttribute('data-product-id');
            document.getElementById('delete_name').textContent = button.getAttribute('data-product-name');
        });
    }
    
    // Add BOM Item
    const addBomItemButton = document.getElementById('add-bom-item');
    if (addBomItemButton) {
        addBomItemButton.addEventListener('click', function() {
            const bomItems = document.getElementById('bom-items');
            const bomItem = document.querySelector('.bom-item');
            const newBomItem = bomItem.cloneNode(true);
            
            // Clear values in the cloned item
            const selects = newBomItem.querySelectorAll('select');
            const inputs = newBomItem.querySelectorAll('input');
            
            selects.forEach(select => {
                select.selectedIndex = 0;
            });
            
            inputs.forEach(input => {
                input.value = '';
            });
            
            // Add event listener to remove button
            const removeButton = newBomItem.querySelector('.remove-bom-item');
            removeButton.addEventListener('click', function() {
                newBomItem.remove();
            });
            
            bomItems.appendChild(newBomItem);
            
            // Add event listeners to new material select
            const materialSelect = newBomItem.querySelector('select[name="material_id[]"]');
            materialSelect.addEventListener('change', updateMaterialUnit);
        });
        
        // Add event listeners to initial material selects
        const materialSelects = document.querySelectorAll('select[name="material_id[]"]');
        materialSelects.forEach(select => {
            select.addEventListener('change', updateMaterialUnit);
        });
        
        // Add event listeners to initial remove buttons
        const removeButtons = document.querySelectorAll('.remove-bom-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (document.querySelectorAll('.bom-item').length > 1) {
                    button.closest('.bom-item').remove();
                }
            });
        });
    }
    
    // Function to update material unit
    function updateMaterialUnit() {
        const materialId = this.value;
        const bomItem = this.closest('.bom-item');
        const unitSpan = bomItem.querySelector('.material-unit');
        const selectedOption = this.options[this.selectedIndex];
        if (materialId && selectedOption) {
            unitSpan.textContent = selectedOption.getAttribute('data-unit') || '';
        } else {
            unitSpan.textContent = '';
        }
    }

    // Dynamic label for Add Product Modal
    const unitSelect = document.getElementById('unit');
    const weightLabel = document.getElementById('weight_label');
    const weightInput = document.getElementById('per_piece_weight');
    if (unitSelect && weightLabel && weightInput) {
        unitSelect.addEventListener('change', function() {
            if (unitSelect.value === 'kg') {
                weightLabel.textContent = 'Per Kg Weight';
                weightInput.placeholder = 'Per Kg Weight';
            } else {
                weightLabel.textContent = 'Per Piece Weight';
                weightInput.placeholder = 'Per Piece Weight';
            }
        });
        // Trigger on load
        unitSelect.dispatchEvent(new Event('change'));
    }

    // Dynamic label for Edit Product Modal
    const editUnitSelect = document.getElementById('edit_unit');
    const editWeightLabel = document.getElementById('edit_weight_label');
    const editWeightInput = document.getElementById('edit_per_piece_weight');
    if (editUnitSelect && editWeightLabel && editWeightInput) {
        editUnitSelect.addEventListener('change', function() {
            if (editUnitSelect.value === 'kg') {
                editWeightLabel.textContent = 'Per Kg Weight';
                editWeightInput.placeholder = 'Per Kg Weight';
            } else {
                editWeightLabel.textContent = 'Per Piece Weight';
                editWeightInput.placeholder = 'Per Piece Weight';
            }
        });
        // Trigger on load
        editUnitSelect.dispatchEvent(new Event('change'));
    }

    // Real-time search for products
    const searchInput = document.getElementById('productSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            const table = document.getElementById('productTable');
            if (!table) return;
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
