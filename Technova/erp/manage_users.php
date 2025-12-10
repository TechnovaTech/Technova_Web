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

// Handle user deletion
if (isset($_POST['delete_user']) && isset($_POST['user_id'])) {
    // Debug all POST data
    error_log("DELETE REQUEST - POST data: " . print_r($_POST, true));
    
    $userId = (int)$_POST['user_id'];
    
    // Debug information
    error_log("User deletion requested for ID: " . $userId);
    
    // Don't allow deleting your own account
    if ($userId == $_SESSION['user_id']) {
        setAlert('You cannot delete your own account', 'danger');
        error_log("Deletion prevented: User tried to delete their own account");
    } else if ($userId <= 0) {
        // Check for invalid user ID
        setAlert('Invalid user ID provided', 'danger');
        error_log("Deletion failed: Invalid user ID provided: " . $userId);
    } else {
        try {
            // Check if user exists before deletion
            $checkStmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
            $checkStmt->execute([$userId]);
            $userToDelete = $checkStmt->fetch();
            
            if ($userToDelete) {
                error_log("Found user to delete: " . $userToDelete['username'] . " (ID: " . $userToDelete['id'] . ")");
                
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                
                if ($stmt->rowCount() > 0) {
                    setAlert('User deleted successfully', 'success');
                    error_log("User deletion successful");
                } else {
                    setAlert('Error: User found but deletion failed', 'danger');
                    error_log("User deletion failed despite user being found");
                }
            } else {
                setAlert('User not found with ID: ' . $userId, 'danger');
                error_log("User deletion failed: User ID " . $userId . " not found in database");
            }
        } catch (PDOException $e) {
            setAlert('Error deleting user: ' . $e->getMessage(), 'danger');
            error_log("Exception during user deletion: " . $e->getMessage());
        }
    }
    
    // Redirect to prevent form resubmission
    header('Location: manage_users.php');
    exit;
}

// Get all users
try {
    $stmt = $pdo->query("SELECT id, username, name, phone, role, active, last_login FROM users ORDER BY id");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $users = [];
    setAlert('Error retrieving users: ' . $e->getMessage(), 'danger');
}

// Include header
require_once 'includes/header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Manage Users</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users me-1"></i>
                User Management
            </div>
            <a href="add_user.php" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus me-1"></i> Add New User
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                                <td>
                                    <span class="badge bg-<?= getRoleBadgeClass($user['role']) ?>">
                                        <?= htmlspecialchars(formatRoleName($user['role'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['active']): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $user['last_login'] ? formatDateTime($user['last_login']) : 'Never' ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-primary" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <button type="button" class="btn btn-danger" title="Delete User" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                    data-user-id="<?= $user['id'] ?>" 
                                                    data-user-name="<?= htmlspecialchars($user['name'] ?? '') ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <!-- Direct delete link for testing -->
                                            <a href="direct_delete_user.php?id=<?= $user['id'] ?>" class="btn btn-warning" title="Direct Delete (Test)" onclick="return confirm('Are you sure you want to delete this user?');">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the user <strong id="userName"></strong>?</p>
                <p class="text-danger">This action cannot be undone!</p>
                <p id="debug-user-id"></p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="manage_users.php" id="deleteUserForm">
                    <input type="hidden" name="user_id" id="userId" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_user" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        $('#usersTable').DataTable();
        
        // Handle delete modal
        var deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var userId = button.getAttribute('data-user-id');
                var userName = button.getAttribute('data-user-name');
                
                var userIdInput = deleteModal.querySelector('#userId');
                var userNameElement = deleteModal.querySelector('#userName');
                var debugUserIdElement = deleteModal.querySelector('#debug-user-id');
                
                userIdInput.value = userId;
                userNameElement.textContent = userName;
                debugUserIdElement.textContent = 'User ID: ' + userId;
                
                console.log('Modal opened for user: ' + userName + ' (ID: ' + userId + ')');
            });
            
            // Add form submission handler
            var deleteForm = document.getElementById('deleteUserForm');
            if (deleteForm) {
                deleteForm.addEventListener('submit', function(event) {
                    var userId = document.getElementById('userId').value;
                    console.log('Form submitted with user ID: ' + userId);
                });
            }
        }
    });
</script>

<?php
// Include footer
require_once 'includes/footer.php';

// Helper functions
function getRoleBadgeClass($role) {
    $classes = [
        'admin' => 'danger',
        'manager' => 'warning',
        'store_manager' => 'info',
        'production' => 'primary',
        'qc' => 'success',
        'dispatch' => 'secondary',
        'melting operator' => 'dark',
        'moulding operator' => 'dark',
        'knockout operator' => 'dark',
        'pouring operator' => 'dark',
        'shot_blasting' => 'dark',
        'fettling' => 'dark',
        'operator' => 'light'
    ];
    
    return $classes[$role] ?? 'secondary';
}

function formatRoleName($role) {
    $names = [
        'admin' => 'Administrator',
        'manager' => 'Manager',
        'store_manager' => 'Store Manager',
        'production' => 'Production Lead',
        'qc' => 'QC Inspector',
        'dispatch' => 'Dispatch Manager',
        'melting operator' => 'Melting Operator',
        'moulding operator' => 'Moulding Operator',
        'knockout operator' => 'Knockout Operator',
        'pouring operator' => 'Pouring Operator',
        'shot_blasting' => 'Shot Blasting Operator',
        'fettling' => 'Fettling Operator',
        'operator' => 'General Operator'
    ];
    
    return $names[$role] ?? ucfirst($role);
}
?> 