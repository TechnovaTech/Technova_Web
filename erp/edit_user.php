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

$roles = [
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
$success = false;
$errors = [];
$user = null;

// Check if user ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setAlert('Invalid user ID', 'danger');
    header('Location: manage_users.php');
    exit;
}

$userId = (int)$_GET['id'];

// Get user details
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    
    if (!$user) {
        setAlert('User not found', 'danger');
        header('Location: manage_users.php');
        exit;
    }
} catch (PDOException $e) {
    setAlert('Error retrieving user: ' . $e->getMessage(), 'danger');
    header('Location: manage_users.php');
    exit;
}

// Get password column name
$columns = [];
$columnsResult = $pdo->query("SHOW COLUMNS FROM users");
while ($column = $columnsResult->fetch(PDO::FETCH_ASSOC)) {
    $columns[] = $column['Field'];
}
$passwordColumn = in_array('password', $columns) ? 'password' : 'password_hash';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = sanitizeInput($_POST['username'] ?? '');
    $name = sanitizeInput($_POST['name'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $role = isset($_POST['role']) ? $_POST['role'] : [];
    if (!is_array($role)) {
        $role = [$role];
    }
    $role_string = implode(',', $role);
    $active = isset($_POST['active']) ? 1 : 0;
    $changePassword = isset($_POST['change_password']) && $_POST['change_password'] === '1';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validate form data
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($role) || count(array_intersect($role, array_keys($roles))) !== count($role)) {
        $errors[] = 'Please select at least one valid role';
    }
    
    // Check if username already exists (excluding current user)
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
        $stmt->execute([$username, $userId]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Username already exists';
        }
    } catch (PDOException $e) {
        $errors[] = 'Database error: ' . $e->getMessage();
    }
    
    // Validate password if changing
    if ($changePassword) {
        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        } elseif ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }
    }
    
    // If no errors, update user
    if (empty($errors)) {
        try {
            if ($changePassword) {
                // Hash new password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Update user with new password
                $sql = "UPDATE users SET username = ?, name = ?, phone = ?, role = ?, active = ?, $passwordColumn = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username, $name, $phone, $role_string, $active, $hashedPassword, $userId]);
            } else {
                // Update user without changing password
                $sql = "UPDATE users SET username = ?, name = ?, phone = ?, role = ?, active = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username, $name, $phone, $role_string, $active, $userId]);
            }
            
            setAlert('User updated successfully', 'success');
            $success = true;
            
            // Refresh user data
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
        } catch (PDOException $e) {
            $errors[] = 'Error updating user: ' . $e->getMessage();
        }
    }
}

// Include header
require_once 'includes/header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="manage_users.php">Manage Users</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    </ol>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success">
            User updated successfully!
        </div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-edit me-1"></i>
            Edit User: <?= htmlspecialchars($user['name']) ?>
        </div>
        <div class="card-body">
            <?php $user_roles = isset($user['role']) ? explode(',', $user['role']) : []; ?>
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" 
                                   value="<?= htmlspecialchars($user['username']) ?>" required />
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" name="name" type="text" 
                                   value="<?= htmlspecialchars($user['name']) ?>" required />
                            <label for="name">Full Name</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-floating mb-3">
                    <input class="form-control" id="phone" name="phone" type="text" 
                           value="<?= htmlspecialchars($user['phone']) ?>" />
                    <label for="phone">Phone Number</label>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="role" name="role[]" multiple required>
                                <option value="" disabled>Select role(s)</option>
                                <?php foreach ($roles as $key => $roleName): ?>
                                    <option value="<?= $key ?>" <?= (isset($user_roles) && in_array($key, $user_roles)) ? 'selected' : '' ?>>
                                        <?= $roleName ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" id="active" name="active" 
                                   <?= $user['active'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="active">Active Account</label>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="change_password" name="change_password" value="1">
                            <label class="form-check-label" for="change_password">Change Password</label>
                        </div>
                    </div>
                    <div class="card-body password-fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 position-relative">
                                    <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                                    <label for="password">New Password</label>
                                    <button type="button" class="password-eye-btn" onclick="togglePassword('password', this)" tabindex="-1">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 position-relative">
                                    <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password">
                                    <label for="confirm_password">Confirm Password</label>
                                    <button type="button" class="password-eye-btn" onclick="togglePassword('confirm_password', this)" tabindex="-1">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 mb-0">
                    <div class="d-flex justify-content-between">
                        <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password fields visibility
        const changePasswordCheckbox = document.getElementById('change_password');
        const passwordFields = document.querySelector('.password-fields');
        
        changePasswordCheckbox.addEventListener('change', function() {
            passwordFields.style.display = this.checked ? 'block' : 'none';
            
            // Toggle required attribute on password fields
            const passwordInputs = passwordFields.querySelectorAll('input[type="password"]');
            passwordInputs.forEach(function(input) {
                input.required = changePasswordCheckbox.checked;
            });
        });
    });

    function togglePassword(id, btn) {
        var input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.querySelector('i').classList.remove('fa-eye');
            btn.querySelector('i').classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            btn.querySelector('i').classList.remove('fa-eye-slash');
            btn.querySelector('i').classList.add('fa-eye');
        }
    }
</script>

<!-- Choices.js CSS/JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    if (roleSelect) {
        new Choices(roleSelect, {
            removeItemButton: true,
            searchEnabled: true,
            placeholderValue: 'Select role(s)',
            shouldSort: false,
            maxItemCount: -1,
            duplicateItemsAllowed: false,
        });
    }
});
</script>

<style>
.choices__list--dropdown {
    z-index: 9999 !important;
    max-height: 250px !important;
    overflow-y: auto !important;
}
select#role.form-select {
    display: none !important;
}
html, body, .container, .container-fluid, .card, .row, .col-md-6, .card-body {
    overflow-y: visible !important;
    height: auto !important;
    max-height: none !important;
}
.password-eye-btn {
    border: none;
    background: transparent;
    position: absolute;
    top: 50%;
    right: 0.75rem;
    transform: translateY(-50%);
    padding: 0;
    margin: 0;
    height: 2rem;
    width: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    color: #888;
    cursor: pointer;
}
.password-eye-btn:focus {
    outline: none;
    box-shadow: none;
}
</style>

<?php
// Include footer
require_once 'includes/footer.php';
?> 