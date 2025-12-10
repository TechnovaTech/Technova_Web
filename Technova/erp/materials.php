<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: materials.php');
        exit;
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_material') {
        // Sanitize input
        $name = sanitizeInput($_POST['name']);
        $type = sanitizeInput($_POST['type']);
        $unit = sanitizeInput($_POST['unit']);
        $current_stock = (float)$_POST['current_stock'];
        $price = (float)$_POST['price'];
        
        // Check if material with same name and type already exists
        $sql = "SELECT id, stock_qty, cost_per_unit FROM materials WHERE name = ? AND type = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $type]);
        $existing_material = $stmt->fetch();
        
        if ($existing_material) {
            // Material exists, update stock and price
            $new_stock = $existing_material['stock_qty'] + $current_stock;
            $new_price = $price; // Use the new price (or you could average it)
            
            $sql = "UPDATE materials SET 
                    stock_qty = ?, 
                    cost_per_unit = ?, 
                    unit = ?,
                    updated_at = NOW() 
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$new_stock, $new_price, $unit, $existing_material['id']]);
            
            if ($result) {
                setAlert("Material stock updated successfully. Added {$current_stock} to existing stock.", 'success');
            } else {
                setAlert("Error updating material stock.", 'danger');
            }
        } else {
            // Material doesn't exist, insert new material
            $sql = "INSERT INTO materials (name, type, unit, stock_qty, cost_per_unit, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$name, $type, $unit, $current_stock, $price]);
            
            if ($result) {
                setAlert("Material added successfully.", 'success');
            } else {
                setAlert("Error adding material.", 'danger');
            }
        }
        
        header('Location: materials.php');
        exit;
    }
    elseif ($action === 'update_material') {
        $id = (int)$_POST['id'];
        
        // Sanitize input
        $name = sanitizeInput($_POST['name']);
        $type = sanitizeInput($_POST['type']);
        $unit = sanitizeInput($_POST['unit']);
        $current_stock = (float)$_POST['current_stock'];
        $price = (float)$_POST['price'];
        
        // Update material in database
        $sql = "UPDATE materials SET 
                name = ?, 
                type = ?, 
                unit = ?, 
                stock_qty = ?, 
                cost_per_unit = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$name, $type, $unit, $current_stock, $price, $id]);
        
        if ($result) {
            setAlert("Material updated successfully.", 'success');
        } else {
            setAlert("Error updating material.", 'danger');
        }
        
        header('Location: materials.php');
        exit;
    }
    elseif ($action === 'delete_material') {
        $id = (int)$_POST['id'];
        
        // Check if material is used in any BOM
        $sql = "SELECT COUNT(*) as count FROM bom_items WHERE material_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            setAlert("Cannot delete material as it is used in Bill of Materials.", 'danger');
            header('Location: materials.php');
            exit;
        }
        
        // Delete material from database
        $sql = "DELETE FROM materials WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result) {
            setAlert("Material deleted successfully.", 'success');
        } else {
            setAlert("Error deleting material.", 'danger');
        }
        
        header('Location: materials.php');
        exit;
    }
    elseif ($action === 'adjust_stock') {
        $id = (int)$_POST['id'];
        $adjustment = (float)$_POST['adjustment'];
        $notes = sanitizeInput($_POST['notes']);
        
        // Get current material stock
        $sql = "SELECT stock_qty FROM materials WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $material = $stmt->fetch();
        
        if (!$material) {
            setAlert("Material not found.", 'danger');
            header('Location: materials.php');
            exit;
        }
        
        // Calculate new stock level
        $new_stock = $material['stock_qty'] + $adjustment;
        
        // Update material stock
        $sql = "UPDATE materials SET stock_qty = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$new_stock, $id]);
        
        if ($result) {
            // Log stock adjustment
            $sql = "INSERT INTO stock_adjustments (material_id, adjustment_quantity, notes, created_at) 
                    VALUES (?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $adjustment, $notes]);
            
            setAlert("Stock adjusted successfully.", 'success');
        } else {
            setAlert("Error adjusting stock.", 'danger');
        }
        
        header('Location: materials.php');
        exit;
    }
    elseif ($action === 'add_hit_box') {
        // Sanitize input
        $name = sanitizeInput($_POST['name']);
        $stock = (float)$_POST['stock'];
        
        // Insert hit box into database
        $sql = "INSERT INTO hit_boxes (name, stock, created_at) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$name, $stock]);
        
        if ($result) {
            setAlert("Heat Box added successfully.", 'success');
        } else {
            setAlert("Error adding heat box.", 'danger');
        }
        
        header('Location: materials.php');
        exit;
    }
    elseif ($action === 'update_hit_box') {
        $id = (int)$_POST['id'];
        
        // Sanitize input
        $name = sanitizeInput($_POST['name']);
        $stock = (float)$_POST['stock'];
        
        // Update hit box in database
        $sql = "UPDATE hit_boxes SET name = ?, stock = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$name, $stock, $id]);
        
        if ($result) {
            setAlert("Heat Box updated successfully.", 'success');
        } else {
            setAlert("Error updating heat box.", 'danger');
        }
        
        header('Location: materials.php');
        exit;
    }
    elseif ($action === 'delete_hit_box') {
        $id = (int)$_POST['id'];
        
        // Delete hit box from database
        $sql = "DELETE FROM hit_boxes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result) {
            setAlert("Heat Box deleted successfully.", 'success');
        } else {
            setAlert("Error deleting heat box.", 'danger');
        }
        
        header('Location: materials.php');
        exit;
    }
    elseif ($action === 'adjust_hit_box_stock') {
        $id = (int)$_POST['id'];
        $adjustment = (float)$_POST['adjustment'];
        $notes = sanitizeInput($_POST['notes']);
        
        // Get current hit box stock
        $sql = "SELECT stock FROM hit_boxes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $hit_box = $stmt->fetch();
        
        if (!$hit_box) {
            setAlert("Heat Box not found.", 'danger');
            header('Location: materials.php');
            exit;
        }
        
        // Calculate new stock level
        $new_stock = $hit_box['stock'] + $adjustment;
        
        // Update hit box stock
        $sql = "UPDATE hit_boxes SET stock = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$new_stock, $id]);
        
        if ($result) {
            // Log stock adjustment
            $sql = "INSERT INTO hit_box_stock_adjustments (hit_box_id, adjustment_quantity, notes, created_at) 
                    VALUES (?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $adjustment, $notes]);
            
            setAlert("Stock adjusted successfully.", 'success');
        } else {
            setAlert("Error adjusting stock.", 'danger');
        }
        
        header('Location: materials.php');
        exit;
    }
}

// Get all materials
$sql = "SELECT 
    id, 
    name, 
    type, 
    unit, 
    stock_qty as current_stock, 
    cost_per_unit as price 
    FROM materials 
    ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$materials = $stmt->fetchAll();

// Fetch material types from the new table
$types = $pdo->query("SELECT name FROM material_types ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Material Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
            <i class="fas fa-plus me-1"></i> Add New Material
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
        <div class="card-header">
            <h5 class="mb-0">Material List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($materials) > 0): ?>
                            <?php foreach ($materials as $material): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($material['name']); ?></td>
                                    <td><?php echo htmlspecialchars($material['type']); ?></td>
                                    <td><?php echo htmlspecialchars($material['unit']); ?></td>
                                    <td><?php echo number_format($material['current_stock'], 3); ?></td>
                                    <td><?php echo formatCurrency($material['price']); ?></td>
                                    <td>
                                        <?php if ($material['current_stock'] <= 0): ?>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">In Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#adjustStockModal" 
                                                    data-material-id="<?php echo $material['id']; ?>"
                                                    data-material-name="<?php echo htmlspecialchars($material['name']); ?>"
                                                    data-material-unit="<?php echo htmlspecialchars($material['unit']); ?>"
                                                    data-material-stock="<?php echo $material['current_stock']; ?>">
                                                <i class="fas fa-balance-scale"></i>
                                            </button> -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editMaterialModal" 
                                                    data-material-id="<?php echo $material['id']; ?>"
                                                    data-material-name="<?php echo htmlspecialchars($material['name']); ?>"
                                                    data-material-type="<?php echo htmlspecialchars($material['type']); ?>"
                                                    data-material-unit="<?php echo htmlspecialchars($material['unit']); ?>"
                                                    data-material-stock="<?php echo $material['current_stock']; ?>"
                                                    data-material-price="<?php echo $material['price']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMaterialModal" 
                                                    data-material-id="<?php echo $material['id']; ?>"
                                                    data-material-name="<?php echo htmlspecialchars($material['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No materials found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Material Modal -->
<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMaterialModalLabel">Add New Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_material">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Material Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <div class="input-group">
                            <select class="form-select" id="type" name="type" required>
                                <?php foreach ($types as $type): ?>
                                    <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars(ucfirst($type)) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-outline-secondary" id="addTypeBtn" tabindex="-1">Add Type</button>
                            <button type="button" class="btn btn-outline-danger" id="deleteTypeBtn" tabindex="-1">Delete Type</button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <select class="form-select" id="unit" name="unit" required>
                            <option value="kg">kg</option>
                            <option value="piece">piece</option>
                        </select>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="current_stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="current_stock" name="current_stock" step="0.001" min="0" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (per unit)</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Material</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Material Modal -->
<div class="modal fade" id="editMaterialModal" tabindex="-1" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialModalLabel">Edit Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_material">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Material Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Type</label>
                        <select class="form-select" id="edit_type" name="type" required>
                            <option value="none">None</option>
                            <option value="core">Core</option>
                            <option value="sleeve">Sleeve</option>
                            <option value="metal">Metal</option>
                            <option value="send">Send</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_unit" class="form-label">Unit</label>
                        <select class="form-select" id="edit_unit" name="unit" required>
                            <option value="kg">kg</option>
                            <option value="piece">piece</option>
                        </select>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_current_stock" class="form-label">Current Stock</label>
                            <input type="number" class="form-control" id="edit_current_stock" name="current_stock" step="0.001" min="0" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price (per unit)</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="edit_price" name="price" step="0.01" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Material</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Adjust Stock Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1" aria-labelledby="adjustStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustStockModalLabel">Adjust Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="adjust_stock">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="adjust_id">
                    
                    <div class="mb-3">
                        <p><strong>Material:</strong> <span id="adjust_name"></span></p>
                        <p><strong>Current Stock:</strong> <span id="adjust_current_stock"></span> <span id="adjust_unit"></span></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="adjustment" class="form-label">Adjustment Amount</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                            <input type="number" class="form-control" id="adjustment" name="adjustment" step="0.01" required>
                            <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                            <span class="input-group-text" id="adjustment_unit"></span>
                        </div>
                        <div class="form-text">Use positive values to add stock, negative values to remove stock.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <p><strong>New Stock Level:</strong> <span id="new_stock_level"></span> <span id="new_stock_unit"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Adjustment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Material Modal -->
<div class="modal fade" id="deleteMaterialModal" tabindex="-1" aria-labelledby="deleteMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMaterialModalLabel">Delete Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_material">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="delete_id">
                    
                    <p>Are you sure you want to delete material: <strong id="delete_name"></strong>?</p>
                    <p class="text-danger"><strong>Warning:</strong> This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Heat Boxes Management Section -->
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Heat Boxes Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHitBoxModal">
            <i class="fas fa-plus me-1"></i> Add New Heat Box
        </button>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Heat Boxes List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Get all hit boxes
                        $sql = "SELECT * FROM hit_boxes ORDER BY name";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $hit_boxes = $stmt->fetchAll();
                        
                        if (count($hit_boxes) > 0): 
                            foreach ($hit_boxes as $box): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($box['name']); ?></td>
                                    <td><?php echo number_format($box['stock'], 2); ?></td>
                                    <td>
                                        <?php if ($box['stock'] <= 0): ?>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">In Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editHitBoxModal" 
                                                    data-box-id="<?php echo $box['id']; ?>"
                                                    data-box-name="<?php echo htmlspecialchars($box['name']); ?>"
                                                    data-box-stock="<?php echo $box['stock']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteHitBoxModal" 
                                                    data-box-id="<?php echo $box['id']; ?>"
                                                    data-box-name="<?php echo htmlspecialchars($box['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No heat boxes found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Heat Box Modal -->
<div class="modal fade" id="addHitBoxModal" tabindex="-1" aria-labelledby="addHitBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHitBoxModalLabel">Add New Heat Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_hit_box">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="mb-3">
                        <label for="hit_box_name" class="form-label">Heat Box Name</label>
                        <input type="text" class="form-control" id="hit_box_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="hit_box_stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="hit_box_stock" name="stock" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Heat Box</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Heat Box Modal -->
<div class="modal fade" id="editHitBoxModal" tabindex="-1" aria-labelledby="editHitBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHitBoxModalLabel">Edit Heat Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_hit_box">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="edit_hit_box_id">
                    
                    <div class="mb-3">
                        <label for="edit_hit_box_name" class="form-label">Heat Box Name</label>
                        <input type="text" class="form-control" id="edit_hit_box_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_hit_box_stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="edit_hit_box_stock" name="stock" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Heat Box</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Adjust Heat Box Stock Modal -->
<div class="modal fade" id="adjustHitBoxStockModal" tabindex="-1" aria-labelledby="adjustHitBoxStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustHitBoxStockModalLabel">Adjust Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="adjust_hit_box_stock">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="adjust_hit_box_id">
                    
                    <div class="mb-3">
                        <p><strong>Heat Box:</strong> <span id="adjust_hit_box_name"></span></p>
                        <p><strong>Current Stock:</strong> <span id="adjust_hit_box_current_stock"></span></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="hit_box_adjustment" class="form-label">Adjustment Amount</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" id="decrease_hit_box">-</button>
                            <input type="number" class="form-control" id="hit_box_adjustment" name="adjustment" step="0.01" required>
                            <button type="button" class="btn btn-outline-secondary" id="increase_hit_box">+</button>
                        </div>
                        <div class="form-text">Use positive values to add stock, negative values to remove stock.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="hit_box_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="hit_box_notes" name="notes" rows="2" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <p><strong>New Stock Level:</strong> <span id="new_hit_box_stock_level"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Adjustment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Heat Box Modal -->
<div class="modal fade" id="deleteHitBoxModal" tabindex="-1" aria-labelledby="deleteHitBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteHitBoxModalLabel">Delete Heat Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="materials.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_hit_box">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="delete_hit_box_id">
                    
                    <p>Are you sure you want to delete heat box: <strong id="delete_hit_box_name"></strong>?</p>
                    <p class="text-danger"><strong>Warning:</strong> This action cannot be undone.</p>
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
    // Edit Material Modal
    const editMaterialModal = document.getElementById('editMaterialModal');
    if (editMaterialModal) {
        editMaterialModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('edit_id').value = button.getAttribute('data-material-id');
            document.getElementById('edit_name').value = button.getAttribute('data-material-name');
            
            const typeSelect = document.getElementById('edit_type');
            const materialType = button.getAttribute('data-material-type');
            for (let i = 0; i < typeSelect.options.length; i++) {
                if (typeSelect.options[i].value === materialType) {
                    typeSelect.options[i].selected = true;
                    break;
                }
            }
            
            const unitSelect = document.getElementById('edit_unit');
            const materialUnit = button.getAttribute('data-material-unit');
            for (let i = 0; i < unitSelect.options.length; i++) {
                if (unitSelect.options[i].value === materialUnit) {
                    unitSelect.options[i].selected = true;
                    break;
                }
            }
            
            document.getElementById('edit_current_stock').value = button.getAttribute('data-material-stock');
            document.getElementById('edit_price').value = button.getAttribute('data-material-price');
        });
    }
    
    // Adjust Stock Modal
    const adjustStockModal = document.getElementById('adjustStockModal');
    if (adjustStockModal) {
        adjustStockModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const materialId = button.getAttribute('data-material-id');
            const materialName = button.getAttribute('data-material-name');
            const materialUnit = button.getAttribute('data-material-unit');
            const currentStock = parseFloat(button.getAttribute('data-material-stock'));
            
            document.getElementById('adjust_id').value = materialId;
            document.getElementById('adjust_name').textContent = materialName;
            document.getElementById('adjust_current_stock').textContent = currentStock.toFixed(3);
            document.getElementById('adjust_unit').textContent = materialUnit;
            document.getElementById('adjustment_unit').textContent = materialUnit;
            document.getElementById('new_stock_unit').textContent = materialUnit;
            
            // Reset adjustment input
            const adjustmentInput = document.getElementById('adjustment');
            adjustmentInput.value = '0';
            
            // Update new stock level
            updateNewStockLevel(currentStock, 0);
            
            // Add event listeners for adjustment buttons and input
            document.getElementById('decrease').addEventListener('click', function() {
                adjustmentInput.value = (parseFloat(adjustmentInput.value || 0) - 1).toFixed(3);
                updateNewStockLevel(currentStock, parseFloat(adjustmentInput.value));
            });
            
            document.getElementById('increase').addEventListener('click', function() {
                adjustmentInput.value = (parseFloat(adjustmentInput.value || 0) + 1).toFixed(3);
                updateNewStockLevel(currentStock, parseFloat(adjustmentInput.value));
            });
            
            adjustmentInput.addEventListener('input', function() {
                updateNewStockLevel(currentStock, parseFloat(this.value || 0));
            });
        });
    }
    
    // Delete Material Modal
    const deleteMaterialModal = document.getElementById('deleteMaterialModal');
    if (deleteMaterialModal) {
        deleteMaterialModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('delete_id').value = button.getAttribute('data-material-id');
            document.getElementById('delete_name').textContent = button.getAttribute('data-material-name');
        });
    }
    
    // Hit Box Modals
    const editHitBoxModal = document.getElementById('editHitBoxModal');
    if (editHitBoxModal) {
        editHitBoxModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('edit_hit_box_id').value = button.getAttribute('data-box-id');
            document.getElementById('edit_hit_box_name').value = button.getAttribute('data-box-name');
            document.getElementById('edit_hit_box_stock').value = button.getAttribute('data-box-stock');
        });
    }
    
    const adjustHitBoxStockModal = document.getElementById('adjustHitBoxStockModal');
    if (adjustHitBoxStockModal) {
        adjustHitBoxStockModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const boxId = button.getAttribute('data-box-id');
            const boxName = button.getAttribute('data-box-name');
            const currentStock = parseFloat(button.getAttribute('data-box-stock'));
            
            document.getElementById('adjust_hit_box_id').value = boxId;
            document.getElementById('adjust_hit_box_name').textContent = boxName;
            document.getElementById('adjust_hit_box_current_stock').textContent = currentStock.toFixed(3);
            
            // Reset adjustment input
            const adjustmentInput = document.getElementById('hit_box_adjustment');
            adjustmentInput.value = '0';
            
            // Update new stock level
            updateNewHitBoxStockLevel(currentStock, 0);
            
            // Add event listeners for adjustment buttons and input
            document.getElementById('decrease_hit_box').addEventListener('click', function() {
                adjustmentInput.value = (parseFloat(adjustmentInput.value || 0) - 1).toFixed(3);
                updateNewHitBoxStockLevel(currentStock, parseFloat(adjustmentInput.value));
            });
            
            document.getElementById('increase_hit_box').addEventListener('click', function() {
                adjustmentInput.value = (parseFloat(adjustmentInput.value || 0) + 1).toFixed(3);
                updateNewHitBoxStockLevel(currentStock, parseFloat(adjustmentInput.value));
            });
            
            adjustmentInput.addEventListener('input', function() {
                updateNewHitBoxStockLevel(currentStock, parseFloat(this.value || 0));
            });
        });
    }
    
    const deleteHitBoxModal = document.getElementById('deleteHitBoxModal');
    if (deleteHitBoxModal) {
        deleteHitBoxModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('delete_hit_box_id').value = button.getAttribute('data-box-id');
            document.getElementById('delete_hit_box_name').textContent = button.getAttribute('data-box-name');
        });
    }
    
    // Helper function to update new stock level
    function updateNewStockLevel(currentStock, adjustment) {
        const newStockLevel = currentStock + adjustment;
        document.getElementById('new_stock_level').textContent = newStockLevel.toFixed(3);
        
        // Change color based on stock level
        const newStockElement = document.getElementById('new_stock_level');
        if (newStockLevel < 0) {
            newStockElement.className = 'text-danger';
        } else {
            newStockElement.className = 'text-success';
        }
    }
    
    // Helper function to update new hit box stock level
    function updateNewHitBoxStockLevel(currentStock, adjustment) {
        const newStockLevel = currentStock + adjustment;
        document.getElementById('new_hit_box_stock_level').textContent = newStockLevel.toFixed(3);
        
        // Change color based on stock level
        const newStockElement = document.getElementById('new_hit_box_stock_level');
        if (newStockLevel < 0) {
            newStockElement.className = 'text-danger';
        } else {
            newStockElement.className = 'text-success';
        }
    }

    document.getElementById('addTypeBtn').addEventListener('click', function() {
        var newType = prompt('Enter new material type:');
        if (newType && newType.trim() !== '') {
            // AJAX to add type to DB
            fetch('ajax_add_material_type.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'name=' + encodeURIComponent(newType)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var select = document.getElementById('type');
                    var option = document.createElement('option');
                    option.value = newType;
                    option.text = newType.charAt(0).toUpperCase() + newType.slice(1);
                    select.appendChild(option);
                    select.value = newType;
                    alert('Type added!');
                } else {
                    alert(data.message || 'Failed to add type.');
                }
            });
        }
    });

    document.getElementById('deleteTypeBtn').addEventListener('click', function() {
        var select = document.getElementById('type');
        var typeToDelete = select.value;
        if (!typeToDelete) return alert('Select a type to delete.');
        if (!confirm('Are you sure you want to delete the type "' + typeToDelete + '"? This cannot be undone.')) return;
        fetch('ajax_delete_material_type.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'name=' + encodeURIComponent(typeToDelete)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove from dropdown
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value === typeToDelete) {
                        select.remove(i);
                        break;
                    }
                }
                alert('Type deleted!');
            } else {
                alert(data.message || 'Failed to delete type.');
            }
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
