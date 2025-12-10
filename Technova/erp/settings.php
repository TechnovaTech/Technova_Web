<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
requireLogin();
$userRoles = getUserRoles();
require_once 'includes/header.php';
?>
<div class="container mt-4">
    <h2>Settings</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5>General Settings</h5>
            <p>Notification preferences and other general settings can go here.</p>
        </div>
    </div>
    <?php if (in_array('store_manager', $userRoles)): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5>Store Manager Settings</h5>
            <p>Store-specific settings for Store Managers.</p>
        </div>
    </div>
    <?php endif; ?>
    <?php if (in_array('dispatch', $userRoles)): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5>Dispatch Settings</h5>
            <p>Dispatch-specific settings for Dispatch role.</p>
        </div>
    </div>
    <?php endif; ?>
    <!-- Add more role-based settings as needed -->
</div>
<?php require_once 'includes/footer.php'; ?> 