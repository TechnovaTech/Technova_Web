<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Get stock alerts for core and sleeve materials
// First check if 'related_to' column exists in the to_do_tasks table
$checkColumnQuery = "SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_SCHEMA = 'casting_erp' 
                    AND TABLE_NAME = 'to_do_tasks' 
                    AND COLUMN_NAME = 'related_to'";
$stmt = $pdo->prepare($checkColumnQuery);
$stmt->execute();
$columnExists = $stmt->fetch()['count'] > 0;

// Instead of trying to use complex queries with joins that might have column issues,
// let's get all the tasks and filter them in PHP
$sql = "SELECT * FROM to_do_tasks WHERE status = 'pending' ORDER BY priority DESC, created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$allTasks = $stmt->fetchAll();

// Get all materials of type core or sleeve
$sql = "SELECT * FROM materials WHERE type IN ('core', 'sleeve')";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$coreSleeveMaterials = $stmt->fetchAll();

// Filter tasks that might be related to core/sleeve materials
$stockAlerts = [];
foreach ($allTasks as $task) {
    foreach ($coreSleeveMaterials as $material) {
        // Check if this task is related to this material
        $isRelated = false;
        
        // If related_to column exists, use it
        if ($columnExists && isset($task['related_to']) && $task['related_to'] === 'material' && 
            isset($task['related_id']) && $task['related_id'] == $material['id']) {
            $isRelated = true;
        }
        // Otherwise check if the task description mentions the material name
        elseif (isset($task['description']) && 
                stripos($task['description'], $material['name']) !== false) {
            $isRelated = true;
        }
        
        if ($isRelated) {
            // Add material info to the task
            $task['material_name'] = $material['name'];
            $task['material_type'] = $material['type'];
            $task['stock_qty'] = $material['stock_qty'];
            $stockAlerts[] = $task;
            break; // Break the inner loop once we've found a match
        }
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: to_do_tasks.php');
        exit;
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_task') {
        // Sanitize input
        $title = sanitizeInput($_POST['title']);
        $description = sanitizeInput($_POST['description']);
        $due_date = sanitizeInput($_POST['due_date']);
        $priority = sanitizeInput($_POST['priority']);
        $assigned_to = sanitizeInput($_POST['assigned_to']);
        $related_to = sanitizeInput($_POST['related_to'] ?? '');
        $related_id = (int)($_POST['related_id'] ?? 0);
        
        // Create task data array
        $task_data = [
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'priority' => $priority,
            'status' => 'pending',
            'assigned_to' => $assigned_to
        ];
        
        // Add related_to and related_id fields only if the columns exist
        if ($columnExists) {
            $task_data['related_to'] = $related_to;
            $task_data['related_id'] = $related_id;
        }
        
        // Create task
        $task_id = createTask($pdo, $task_data);
        
        if ($task_id) {
            setAlert("Task created successfully.", 'success');
        } else {
            setAlert("Error creating task.", 'danger');
        }
        
        header('Location: to_do_tasks.php');
        exit;
    }
    elseif ($action === 'update_task') {
        $id = (int)$_POST['id'];
        $status = sanitizeInput($_POST['status']);
        
        // Update task status
        $sql = "UPDATE to_do_tasks SET status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$status, $id]);
        
        if ($result) {
            setAlert("Task status updated successfully.", 'success');
        } else {
            setAlert("Error updating task status.", 'danger');
        }
        
        header('Location: to_do_tasks.php');
        exit;
    }
    elseif ($action === 'delete_task') {
        $id = (int)$_POST['id'];
        
        // Delete task
        $sql = "DELETE FROM to_do_tasks WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        
        if ($result) {
            setAlert("Task deleted successfully.", 'success');
        } else {
            setAlert("Error deleting task.", 'danger');
        }
        
        header('Location: to_do_tasks.php');
        exit;
    }
}

// Get all tasks
$sql = "SELECT * FROM to_do_tasks ORDER BY 
        CASE 
            WHEN status = 'pending' THEN 1 
            WHEN status = 'in_progress' THEN 2 
            ELSE 3 
        END, 
        CASE 
            WHEN priority = 'high' THEN 1 
            WHEN priority = 'medium' THEN 2 
            ELSE 3 
        END,
        created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Task Management</h2>
        <div>
            <a href="stock_alerts.php" class="btn btn-warning me-2">
                <i class="fas fa-exclamation-triangle me-1"></i> Stock Alerts
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                <i class="fas fa-plus me-1"></i> Add New Task
            </button>
        </div>
    </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <?php if (count($stockAlerts) > 0): ?>
    <!-- Stock Alerts Section -->
    <div class="card mb-4 border-danger">
        <div class="card-header bg-danger text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Material Stock Alerts</h5>
                <span class="badge bg-light text-danger"><?php echo count($stockAlerts); ?> alerts</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Type</th>
                            <th>Current Stock</th>
                            <th>Priority</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stockAlerts as $alert): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($alert['material_name']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $alert['material_type'] === 'core' ? 'primary' : 'secondary'; ?>">
                                        <?php echo ucfirst(htmlspecialchars($alert['material_type'])); ?>
                                    </span>
                                </td>
                                <td><?php echo number_format($alert['stock_qty'], 2); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $alert['priority'] === 'high' ? 'danger' : 
                                            ($alert['priority'] === 'medium' ? 'warning' : 'info'); 
                                    ?>">
                                        <?php echo ucfirst(htmlspecialchars($alert['priority'])); ?>
                                    </span>
                                </td>
                                <td><?php echo formatDate($alert['created_at']); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $alert['status'] === 'completed' ? 'success' : 
                                            ($alert['status'] === 'in_progress' ? 'primary' : 'secondary'); 
                                    ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($alert['status']))); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateTaskModal" 
                                                data-task-id="<?php echo $alert['id']; ?>"
                                                data-task-title="<?php echo htmlspecialchars($alert['title']); ?>"
                                                data-task-status="<?php echo htmlspecialchars($alert['status']); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="materials.php" class="btn btn-info">
                                            <i class="fas fa-boxes"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Task List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Related To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($tasks) > 0): ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                                    <td><?php echo formatDate($task['due_date']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $task['priority'] === 'high' ? 'danger' : 
                                                ($task['priority'] === 'medium' ? 'warning' : 'info'); 
                                        ?>">
                                            <?php echo ucfirst(htmlspecialchars($task['priority'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $task['status'] === 'completed' ? 'success' : 
                                                ($task['status'] === 'in_progress' ? 'primary' : 'secondary'); 
                                        ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($task['status']))); ?>
                                        </span>
                                    </td>
                                    <td><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($task['assigned_to'] ?? ''))); ?></td>
                                    <td>
                                        <?php if ($task['related_to'] && $task['related_id']): ?>
                                            <?php 
                                                $related_link = '#';
                                                $related_name = ucfirst(str_replace('_', ' ', $task['related_to']));
                                                
                                                if ($task['related_to'] === 'purchase_order') {
                                                    $related_link = "purchase_order_details.php?id=" . $task['related_id'];
                                                } elseif ($task['related_to'] === 'material') {
                                                    $related_link = "materials.php";
                                                }
                                            ?>
                                            <a href="<?php echo $related_link; ?>" class="badge bg-info text-decoration-none">
                                                <?php echo $related_name; ?> #<?php echo $task['related_id']; ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">None</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateTaskModal" 
                                                    data-task-id="<?php echo $task['id']; ?>"
                                                    data-task-title="<?php echo htmlspecialchars($task['title']); ?>"
                                                    data-task-status="<?php echo htmlspecialchars($task['status']); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" 
                                                    data-task-id="<?php echo $task['id']; ?>"
                                                    data-task-title="<?php echo htmlspecialchars($task['title']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No tasks found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- New Task Modal -->
<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTaskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="to_do_tasks.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="create_task">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assigned To</label>
                        <select class="form-select" id="assigned_to" name="assigned_to" required>
                            <option value="production_manager">Production Manager</option>
                            <option value="inventory_manager">Inventory Manager</option>
                            <option value="quality_control">Quality Control</option>
                            <option value="dispatch_manager">Dispatch Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="related_to" class="form-label">Related To (Optional)</label>
                            <select class="form-select" id="related_to" name="related_to">
                                <option value="">None</option>
                                <option value="purchase_order">Purchase Order</option>
                                <option value="material">Material</option>
                                <option value="product">Product</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="related_id" class="form-label">Related ID (Optional)</label>
                            <input type="number" class="form-control" id="related_id" name="related_id" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Task Modal -->
<div class="modal fade" id="updateTaskModal" tabindex="-1" aria-labelledby="updateTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTaskModalLabel">Update Task Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="to_do_tasks.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_task">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="update_task_id">
                    
                    <p>Update status for task: <strong id="update_task_title"></strong></p>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Task Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTaskModalLabel">Delete Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="to_do_tasks.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_task">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="delete_task_id">
                    
                    <p>Are you sure you want to delete task: <strong id="delete_task_title"></strong>?</p>
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
    // Update Task Modal
    const updateTaskModal = document.getElementById('updateTaskModal');
    if (updateTaskModal) {
        updateTaskModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const taskId = button.getAttribute('data-task-id');
            const taskTitle = button.getAttribute('data-task-title');
            const taskStatus = button.getAttribute('data-task-status');
            
            document.getElementById('update_task_id').value = taskId;
            document.getElementById('update_task_title').textContent = taskTitle;
            
            const statusSelect = document.getElementById('status');
            for (let i = 0; i < statusSelect.options.length; i++) {
                if (statusSelect.options[i].value === taskStatus) {
                    statusSelect.options[i].selected = true;
                    break;
                }
            }
        });
    }
    
    // Delete Task Modal
    const deleteTaskModal = document.getElementById('deleteTaskModal');
    if (deleteTaskModal) {
        deleteTaskModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const taskId = button.getAttribute('data-task-id');
            const taskTitle = button.getAttribute('data-task-title');
            
            document.getElementById('delete_task_id').value = taskId;
            document.getElementById('delete_task_title').textContent = taskTitle;
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
