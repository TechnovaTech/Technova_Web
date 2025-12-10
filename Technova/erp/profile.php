<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
requireLogin();

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch();
$userRoles = getUserRoles();

$success = false;
$errors = [];

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $passwordColumn = isset($user['password']) ? 'password' : 'password_hash';
    if (!password_verify($current, $user[$passwordColumn])) {
        $errors[] = 'Current password is incorrect.';
    } elseif (strlen($new) < 6) {
        $errors[] = 'New password must be at least 6 characters.';
    } elseif ($new !== $confirm) {
        $errors[] = 'Passwords do not match.';
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET $passwordColumn = ? WHERE id = ?");
        $stmt->execute([$hashed, $userId]);
        $success = true;
    }
}
require_once 'includes/header.php';
?>
<style>
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
<div class="container mt-4">
    <h2>My Profile</h2>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Roles:</strong> <?= implode(', ', array_map('ucwords', $userRoles)) ?></p>
        </div>
    </div>
    <h4>Change Password</h4>
    <?php if ($success): ?><div class="alert alert-success">Password changed successfully.</div><?php endif; ?>
    <?php if ($errors): ?><div class="alert alert-danger"><ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul></div><?php endif; ?>
    <form method="post">
        <div class="mb-3 position-relative">
            <label>Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
            <button type="button" class="password-eye-btn" onclick="togglePassword('current_password', this)" tabindex="-1">
                <i class="fa fa-eye"></i>
            </button>
        </div>
        <div class="mb-3 position-relative">
            <label>New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
            <button type="button" class="password-eye-btn" onclick="togglePassword('new_password', this)" tabindex="-1">
                <i class="fa fa-eye"></i>
            </button>
        </div>
        <div class="mb-3 position-relative">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            <button type="button" class="password-eye-btn" onclick="togglePassword('confirm_password', this)" tabindex="-1">
                <i class="fa fa-eye"></i>
            </button>
        </div>
        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
    </form>
</div>
<script>
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
<?php require_once 'includes/footer.php'; ?> 