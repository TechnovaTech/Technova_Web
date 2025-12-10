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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $name = sanitizeInput($_POST['name'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $role = isset($_POST['role']) ? $_POST['role'] : [];
    if (!is_array($role)) {
        $role = [$role];
    }
    $role_string = implode(',', $role);
    
    // Validate form data
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    
    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters';
    } elseif ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    // No phone required validation
    
    if (empty($role) || count(array_intersect($role, array_keys($roles))) !== count($role)) {
        $errors[] = 'Please select at least one valid role';
    }
    
    // Check if username already exists
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Username already exists';
        }
    } catch (PDOException $e) {
        $errors[] = 'Database error: ' . $e->getMessage();
    }
    
    // If no errors, add user to database
    if (empty($errors)) {
        try {
            // Get the password column name
            $columns = [];
            $columnsResult = $pdo->query("SHOW COLUMNS FROM users");
            while ($column = $columnsResult->fetch(PDO::FETCH_ASSOC)) {
                $columns[] = $column['Field'];
            }
            $passwordColumn = in_array('password', $columns) ? 'password' : 'password_hash';
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user
            $sql = "INSERT INTO users (username, $passwordColumn, name, phone, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $hashedPassword, $name, $phone, $role_string]);
            
            setAlert('User added successfully', 'success');
            $success = true;
            
            // Clear form data
            $username = $name = $phone = $role = '';
        } catch (PDOException $e) {
            $errors[] = 'Error adding user: ' . $e->getMessage();
        }
    }
}

// Include header
require_once 'includes/header.php';
?>

<style>
.choices__list--dropdown {
    z-index: 9999 !important;
    max-height: 250px !important;
    overflow-y: auto !important;
}
select[name="role[]"] {
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

<div class="container-fluid px-4">
    <h1 class="mt-4">Add New User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Add User</li>
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
            User added successfully! <a href="add_user.php">Add another user</a>
        </div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-1"></i>
            User Information
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" placeholder="Username" value="<?= htmlspecialchars($username ?? '') ?>" required />
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" name="name" type="text" placeholder="Full Name" value="<?= htmlspecialchars($name ?? '') ?>" required />
                            <label for="name">Full Name</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="phone" name="phone" type="text" placeholder="Phone Number" value="<?= htmlspecialchars($phone ?? '') ?>" />
                    <label for="phone">Phone Number</label>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 position-relative">
                            <input class="form-control" id="password" name="password" type="password" placeholder="Password" required />
                            <label for="password">Password</label>
                            <button type="button" class="password-eye-btn" onclick="togglePassword('password', this)" tabindex="-1">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3 position-relative">
                            <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" required />
                            <label for="confirm_password">Confirm Password</label>
                            <button type="button" class="password-eye-btn" onclick="togglePassword('confirm_password', this)" tabindex="-1">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="role" name="role[]" multiple required>
                        <option value="" disabled>Select role(s)</option>
                        <?php foreach ($roles as $key => $roleName): ?>
                            <option value="<?= $key ?>" <?= (isset($role) && in_array($key, $role)) ? 'selected' : '' ?>>
                                <?= $roleName ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-block">Create User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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

<?php
// Include footer
require_once 'includes/footer.php';
?> 