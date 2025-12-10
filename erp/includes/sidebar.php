<?php
// Ensure this file is not accessed directly
if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/erp/');
}

// Include functions file for getUserRole()
require_once __DIR__ . '/functions.php';

// Get user roles for access control
$userRoles = getUserRoles();

// Define which roles can access which sections
$canAccessAll = count(array_intersect($userRoles, ['admin', 'manager', 'Administrator'])) > 0;
$canAccessInventory = $canAccessAll || count(array_intersect($userRoles, ['store_manager', 'production'])) > 0;
$canAccessSales = $canAccessAll || in_array('store_manager', $userRoles);
$canAccessProduction = $canAccessAll || in_array('production', $userRoles);

// Define specific production access
$canAccessMelting = $canAccessAll || $canAccessProduction || in_array('melting operator', $userRoles);
$canAccessMoulding = $canAccessAll || $canAccessProduction || in_array('moulding operator', $userRoles);
$canAccessKnockout = $canAccessAll || $canAccessProduction || in_array('knockout operator', $userRoles);
$canAccessPouring = $canAccessAll || $canAccessProduction || in_array('pouring operator', $userRoles);
$canAccessShotBlasting = $canAccessAll || $canAccessProduction || in_array('shot_blasting', $userRoles);
$canAccessFettling = $canAccessAll || $canAccessProduction || in_array('fettling', $userRoles);
$canAccessDispatch = $canAccessAll || in_array('dispatch', $userRoles);
$canAccessRejection = $canAccessAll || $canAccessProduction || in_array('qc', $userRoles);
?>
<!-- Sidebar -->
<div class="col-md-3 col-lg-2 px-0">
    <div class="sidebar bg-dark text-light">
        <div class="list-group bg-dark">
            <?php if ($canAccessAll): ?>
            <a href="<?= BASE_PATH ?>index.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'index' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="<?= BASE_PATH ?>to_do_tasks.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'to_do_tasks' ? 'active' : '' ?>">
                <i class="fas fa-tasks me-2"></i> To-Do Tasks
            </a>
            <a href="<?= BASE_PATH ?>production_plan.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'production_plan' ? 'active' : '' ?>">
                <i class="fas fa-project-diagram me-2"></i> Production Plan
            </a>
            <?php endif; ?>
          
            <?php if ($canAccessSales): ?>
            <div class="sidebar-heading px-3 py-2 mt-2 text-light">
                <small>SALES & ORDERS</small>
            </div>
            <a href="<?= BASE_PATH ?>purchase_orders.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'purchase_orders' ? 'active' : '' ?>">
                <i class="fas fa-file-invoice me-2"></i> Purchase Orders
            </a>
            <a href="<?= BASE_PATH ?>customers.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'customers' ? 'active' : '' ?>">
                <i class="fas fa-users me-2"></i> Customers
            </a>
           
            <a href="<?= BASE_PATH ?>products.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'products' ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list me-2"></i> Product Management
            </a>
            <a href="<?= BASE_PATH ?>bom.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'bom' ? 'active' : '' ?>">
                <i class="fas fa-list-alt me-2"></i> BOM
            </a>
           
            <?php endif; ?>
            
            <?php if ($canAccessInventory): ?>
            <div class="sidebar-heading px-3 py-2 mt-2 text-light">
                <small>INVENTORY</small>
            </div>
            
            <a href="<?= BASE_PATH ?>materials.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'materials' ? 'active' : '' ?>">
                <i class="fas fa-boxes me-2"></i> Store
            </a>
            <a href="<?= BASE_PATH ?>packaging.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'packaging' ? 'active' : '' ?>">
                <i class="fas fa-box me-2"></i> Packaging
            </a>
            <?php endif; ?>
            
            <?php if ($canAccessProduction || $canAccessMelting || $canAccessMoulding || $canAccessKnockout || 
                      $canAccessPouring || $canAccessShotBlasting || $canAccessFettling || $canAccessRejection): ?>
            <div class="sidebar-heading px-3 py-2 mt-2 text-light">
                <small>PRODUCTION</small>
            </div>
            <?php endif; ?>
            
            <?php if ($canAccessMelting): ?>
            <a href="<?= BASE_PATH ?>core_shop.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'core_shop' ? 'active' : '' ?>">
                <i class="fas fa-cogs me-2"></i> Core Shop
            </a>
            <a href="<?= BASE_PATH ?>melting.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'melting' ? 'active' : '' ?>">
                <i class="fas fa-fire me-2"></i> Melting
            </a>
            <?php endif; ?>
            
            <?php if ($canAccessMoulding): ?>
            <a href="<?= BASE_PATH ?>moulding.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'moulding' ? 'active' : '' ?>">
                <i class="fas fa-cube me-2"></i> Moulding
            </a>
            <?php endif; ?>

            <?php if ($canAccessPouring): ?>
            <a href="<?= BASE_PATH ?>pouring.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'pouring' ? 'active' : '' ?>">
                <i class="fas fa-fill-drip me-2"></i> Pouring
            </a>
            <?php endif; ?>
            
            <?php if ($canAccessKnockout): ?>
            <a href="<?= BASE_PATH ?>knockout.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'knockout' ? 'active' : '' ?>">
                <i class="fas fa-hammer me-2"></i> Knockout
            </a>
            <?php endif; ?>
            
          
            
            <?php if ($canAccessShotBlasting): ?>
            <a href="<?= BASE_PATH ?>shot_blasting.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'shot_blasting' ? 'active' : '' ?>">
                <i class="fas fa-wind me-2"></i> Shot Blasting
            </a>
            <?php endif; ?>
            
            <?php if ($canAccessFettling): ?>
            <a href="<?= BASE_PATH ?>fettling.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'fettling' ? 'active' : '' ?>">
                <i class="fas fa-cut me-2"></i> Fettling
            </a>
            <?php endif; ?>
            
            <?php if ($canAccessRejection): ?>
            <a href="<?= BASE_PATH ?>rejection.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'rejection' ? 'active' : '' ?>">
                <i class="fas fa-exclamation-triangle me-2"></i> Rejections
            </a>
            <?php endif; ?>
            
            <?php if ($canAccessDispatch): ?>
            <div class="sidebar-heading px-3 py-2 mt-2 text-light">
                <small>LOGISTICS</small>
            </div>
            
            <a href="<?= BASE_PATH ?>dispatch.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'dispatch' ? 'active' : '' ?>">
                <i class="fas fa-truck me-2"></i> Dispatch
            </a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id']) && function_exists('hasPermission') && hasPermission('manager')): ?>
            <div class="sidebar-heading px-3 py-2 mt-2 text-light">
                <small>ADMINISTRATION</small>
            </div>
            
            <a href="<?= BASE_PATH ?>manage_users.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'manage_users' ? 'active' : '' ?>">
                <i class="fas fa-users-cog me-2"></i> Manage Users
            </a>
            <a href="<?= BASE_PATH ?>add_user.php" class="list-group-item list-group-item-action bg-dark text-light <?= $current_page == 'add_user' ? 'active' : '' ?>">
                <i class="fas fa-user-plus me-2"></i> Add User
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        // Restore scroll position
        var scrollPos = localStorage.getItem('sidebar-scroll');
        if (scrollPos) sidebar.scrollTop = parseInt(scrollPos, 10);
        // Save scroll position on scroll
        sidebar.addEventListener('scroll', function() {
            localStorage.setItem('sidebar-scroll', sidebar.scrollTop);
        });
    }
});
</script>
