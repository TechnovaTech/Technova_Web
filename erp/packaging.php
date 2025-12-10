<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: packaging.php');
        exit;
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_box') {
        // Sanitize input
        $name = sanitizeInput($_POST['box_type']);
        $size = sanitizeInput($_POST['size']);
        $current_stock = (int)$_POST['stock_quantity'];
        $min_level = (int)$_POST['min_level'];
        $max_level = (int)$_POST['max_level'];
        $cost_per_unit = (float)$_POST['cost_per_unit'];
        
        // Insert packaging box into database
        $sql = "INSERT INTO packaging_boxes (name, size, current_stock, min_level, max_level, cost_per_unit, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$name, $size, $current_stock, $min_level, $max_level, $cost_per_unit]);
        
        if ($result) {
            setAlert("Packaging box added successfully.", 'success');
        } else {
            setAlert("Error adding packaging box.", 'danger');
        }
        
        header('Location: packaging.php');
        exit;
    }
    elseif ($action === 'update_box') {
        $id = (int)$_POST['id'];
        
        // Sanitize input
        $name = sanitizeInput($_POST['box_type']);
        $size = sanitizeInput($_POST['size']);
        $current_stock = (int)$_POST['stock_quantity'];
        $min_level = (int)$_POST['min_level'];
        $max_level = (int)$_POST['max_level'];
        $cost_per_unit = (float)$_POST['cost_per_unit'];
        
        // Update packaging box in database
        $sql = "UPDATE packaging_boxes SET 
                name = ?, 
                size = ?, 
                current_stock = ?,
                min_level = ?,
                max_level = ?,
                cost_per_unit = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$name, $size, $current_stock, $min_level, $max_level, $cost_per_unit, $id]);
        
        if ($result) {
            setAlert("Packaging box updated successfully.", 'success');
        } else {
            setAlert("Error updating packaging box.", 'danger');
        }
        
        header('Location: packaging.php');
        exit;
    }
    elseif ($action === 'delete_box') {
        $id = (int)$_POST['id'];
        
        // Check if box is used in any dispatch
        $sql = "SELECT COUNT(*) as count FROM dispatches WHERE packaging_box_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            setAlert("Cannot delete packaging box as it is used in dispatches.", 'danger');
            header('Location: packaging.php');
            exit;
        }
        
        // Delete packaging box from database
        $sql = "DELETE FROM packaging_boxes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result) {
            setAlert("Packaging box deleted successfully.", 'success');
        } else {
            setAlert("Error deleting packaging box.", 'danger');
        }
        
        header('Location: packaging.php');
        exit;
    }
    elseif ($action === 'adjust_stock') {
        $id = (int)$_POST['id'];
        $adjustment = (int)$_POST['adjustment'];
        $notes = sanitizeInput($_POST['notes']);
        
        // Get current box stock
        $sql = "SELECT current_stock FROM packaging_boxes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $box = $stmt->fetch();
        
        if (!$box) {
            setAlert("Packaging box not found.", 'danger');
            header('Location: packaging.php');
            exit;
        }
        
        // Calculate new stock level
        $new_stock = $box['current_stock'] + $adjustment;
        
        // Update box stock
        $sql = "UPDATE packaging_boxes SET current_stock = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$new_stock, $id]);
        
        if ($result) {
            // Log stock adjustment
            $sql = "INSERT INTO packaging_stock_adjustments (packaging_box_id, adjustment_quantity, notes, created_at) 
                    VALUES (?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $adjustment, $notes]);
            
            setAlert("Stock adjusted successfully.", 'success');
        } else {
            setAlert("Error adjusting stock.", 'danger');
        }
        
        header('Location: packaging.php');
        exit;
    }
}

// Get all packaging boxes
$sql = "SELECT * FROM packaging_boxes ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$boxes = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Packaging Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBoxModal">
            <i class="fas fa-plus me-1"></i> Add New Box
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
            <h5 class="mb-0">Packaging Box List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Box Name</th>
                            <th>Size</th>
                            <th>Current Stock</th>
                            <th>Min Level</th>
                            <th>Max Level</th>
                            <th>Cost Per Unit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($boxes) > 0): ?>
                            <?php foreach ($boxes as $box): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($box['name']); ?></td>
                                    <td><?php echo htmlspecialchars($box['size']); ?></td>
                                    <td><?php echo $box['current_stock']; ?></td>
                                    <td><?php echo $box['min_level']; ?></td>
                                    <td><?php echo $box['max_level']; ?></td>
                                    <td><?php echo formatCurrency($box['cost_per_unit']); ?></td>
                                    <td>
                                        <?php if ($box['current_stock'] <= 0): ?>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        <?php elseif ($box['current_stock'] < $box['min_level']): ?>
                                            <span class="badge bg-warning">Low Stock</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">In Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#adjustStockModal" 
                                                    data-box-id="<?php echo $box['id']; ?>"
                                                    data-box-name="<?php echo htmlspecialchars($box['name']); ?>"
                                                    data-box-stock="<?php echo $box['current_stock']; ?>">
                                                <i class="fas fa-balance-scale"></i>
                                            </button> -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBoxModal" 
                                                    data-box-id="<?php echo $box['id']; ?>"
                                                    data-box-name="<?php echo htmlspecialchars($box['name']); ?>"
                                                    data-box-size="<?php echo htmlspecialchars($box['size']); ?>"
                                                    data-box-stock="<?php echo $box['current_stock']; ?>"
                                                    data-box-min-level="<?php echo $box['min_level']; ?>"
                                                    data-box-max-level="<?php echo $box['max_level']; ?>"
                                                    data-box-cost="<?php echo $box['cost_per_unit']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button> 
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBoxModal" 
                                                    data-box-id="<?php echo $box['id']; ?>"
                                                    data-box-name="<?php echo htmlspecialchars($box['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No packaging boxes found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Box Modal -->
<div class="modal fade" id="addBoxModal" tabindex="-1" aria-labelledby="addBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBoxModalLabel">Add New Packaging Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="packaging.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_box">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="mb-3">
                        <label for="box_type" class="form-label">Box Name</label>
                        <input type="text" class="form-control" id="box_type" name="box_type" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <input type="text" class="form-control" id="size" name="size" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="stock_quantity" class="form-label">Current Stock</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="min_level" class="form-label">Min Level</label>
                            <input type="number" class="form-control" id="min_level" name="min_level" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="max_level" class="form-label">Max Level</label>
                            <input type="number" class="form-control" id="max_level" name="max_level" min="0" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cost_per_unit" class="form-label">Cost Per Unit</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="cost_per_unit" name="cost_per_unit" step="0.01" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Box</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Box Modal -->
<div class="modal fade" id="editBoxModal" tabindex="-1" aria-labelledby="editBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBoxModalLabel">Edit Packaging Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="packaging.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_box">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="mb-3">
                        <label for="edit_box_type" class="form-label">Box Name</label>
                        <input type="text" class="form-control" id="edit_box_type" name="box_type" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_size" class="form-label">Size</label>
                        <input type="text" class="form-control" id="edit_size" name="size" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="edit_stock_quantity" class="form-label">Current Stock</label>
                            <input type="number" class="form-control" id="edit_stock_quantity" name="stock_quantity" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_min_level" class="form-label">Min Level</label>
                            <input type="number" class="form-control" id="edit_min_level" name="min_level" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_max_level" class="form-label">Max Level</label>
                            <input type="number" class="form-control" id="edit_max_level" name="max_level" min="0" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_cost_per_unit" class="form-label">Cost Per Unit</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="edit_cost_per_unit" name="cost_per_unit" step="0.01" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Box</button>
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
            <form method="POST" action="packaging.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="adjust_stock">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="adjust_id">
                    
                    <div class="mb-3">
                        <p><strong>Box:</strong> <span id="adjust_name"></span></p>
                        <p><strong>Current Stock:</strong> <span id="adjust_current_stock"></span> boxes</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="adjustment" class="form-label">Adjustment Amount</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                            <input type="number" class="form-control" id="adjustment" name="adjustment" required>
                            <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                            <span class="input-group-text">boxes</span>
                        </div>
                        <div class="form-text">Use positive values to add stock, negative values to remove stock.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <p><strong>New Stock Level:</strong> <span id="new_stock_level"></span> boxes</p>
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

<!-- Delete Box Modal -->
<div class="modal fade" id="deleteBoxModal" tabindex="-1" aria-labelledby="deleteBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBoxModalLabel">Delete Packaging Box</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="packaging.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_box">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="delete_id">
                    
                    <p>Are you sure you want to delete packaging box: <strong id="delete_name"></strong>?</p>
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
    // Edit Box Modal
    const editBoxModal = document.getElementById('editBoxModal');
    if (editBoxModal) {
        editBoxModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('edit_id').value = button.getAttribute('data-box-id');
            document.getElementById('edit_box_type').value = button.getAttribute('data-box-name');
            document.getElementById('edit_size').value = button.getAttribute('data-box-size');
            document.getElementById('edit_stock_quantity').value = button.getAttribute('data-box-stock');
            document.getElementById('edit_min_level').value = button.getAttribute('data-box-min-level');
            document.getElementById('edit_max_level').value = button.getAttribute('data-box-max-level');
            document.getElementById('edit_cost_per_unit').value = button.getAttribute('data-box-cost');
        });
    }
    
    // Adjust Stock Modal
    const adjustStockModal = document.getElementById('adjustStockModal');
    if (adjustStockModal) {
        adjustStockModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const boxId = button.getAttribute('data-box-id');
            const boxName = button.getAttribute('data-box-name');
            const currentStock = parseInt(button.getAttribute('data-box-stock'));
            
            document.getElementById('adjust_id').value = boxId;
            document.getElementById('adjust_name').textContent = boxName;
            document.getElementById('adjust_current_stock').textContent = currentStock;
            
            // Reset adjustment input
            const adjustmentInput = document.getElementById('adjustment');
            adjustmentInput.value = '0';
            
            // Update new stock level
            updateNewStockLevel(currentStock, 0);
            
            // Add event listeners for adjustment buttons and input
            document.getElementById('decrease').addEventListener('click', function() {
                adjustmentInput.value = parseInt(adjustmentInput.value || 0) - 1;
                updateNewStockLevel(currentStock, parseInt(adjustmentInput.value));
            });
            
            document.getElementById('increase').addEventListener('click', function() {
                adjustmentInput.value = parseInt(adjustmentInput.value || 0) + 1;
                updateNewStockLevel(currentStock, parseInt(adjustmentInput.value));
            });
            
            adjustmentInput.addEventListener('input', function() {
                updateNewStockLevel(currentStock, parseInt(this.value || 0));
            });
        });
    }
    
    // Delete Box Modal
    const deleteBoxModal = document.getElementById('deleteBoxModal');
    if (deleteBoxModal) {
        deleteBoxModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('delete_id').value = button.getAttribute('data-box-id');
            document.getElementById('delete_name').textContent = button.getAttribute('data-box-name');
        });
    }
    
    // Helper function to update new stock level
    function updateNewStockLevel(currentStock, adjustment) {
        const newStockLevel = currentStock + adjustment;
        document.getElementById('new_stock_level').textContent = newStockLevel;
        
        // Change color based on stock level
        const newStockElement = document.getElementById('new_stock_level');
        if (newStockLevel < 0) {
            newStockElement.className = 'text-danger';
        } else {
            newStockElement.className = 'text-success';
        }
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
