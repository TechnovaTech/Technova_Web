<?php
/**
 * Role-based access control for ERP system
 * This file provides functions to check if a user has access to specific pages
 */

// Ensure this file is not accessed directly
if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/erp/');
}

// Include functions file for getUserRole()
require_once __DIR__ . '/functions.php';

/**
 * Check if the current user has access to a specific page
 * @param string $page The page name (without .php extension)
 * @return bool True if user has access, false otherwise
 */
function hasPageAccess($page) {
    $userRoles = getUserRoles();
    
    // Admin and manager have access to everything
    if (array_intersect($userRoles, ['admin', 'manager', 'Administrator'])) {
        return true;
    }
    
    // Define page access by role
    $pageAccess = [
        // Dashboard and general pages
        'index' => ['admin', 'manager', 'Administrator'],
        'to_do_tasks' => ['admin', 'manager', 'Administrator'],
        
        // Sales & Orders pages
        'purchase_orders' => ['admin', 'manager', 'Administrator', 'store_manager'],
        'customers' => ['admin', 'manager', 'Administrator', 'store_manager'],
        'products' => ['admin', 'manager', 'Administrator', 'store_manager', 'production'],
        
        // Inventory pages
        'materials' => ['admin', 'manager', 'Administrator', 'store_manager', 'production'],
        'packaging' => ['admin', 'manager', 'Administrator', 'store_manager', 'production'],
        
        // Production pages
        'melting' => ['admin', 'manager', 'Administrator', 'production', 'melting operator'],
        'melting_dashboard' => ['admin', 'manager', 'Administrator', 'production', 'melting operator'],
        'moulding' => ['admin', 'manager', 'Administrator', 'production', 'moulding operator'],
        'knockout' => ['admin', 'manager', 'Administrator', 'production', 'knockout operator'],
        'pouring' => ['admin', 'manager', 'Administrator', 'production', 'pouring operator'],
        'shot_blasting' => ['admin', 'manager', 'Administrator', 'production', 'shot_blasting'],
        'fettling' => ['admin', 'manager', 'Administrator', 'production', 'fettling'],
        'rejection' => ['admin', 'manager', 'Administrator', 'production', 'qc'],
        
        // Logistics pages
        'dispatch' => ['admin', 'manager', 'Administrator', 'dispatch'],
        
        // Administration pages
        'manage_users' => ['admin', 'manager', 'Administrator'],
        'add_user' => ['admin', 'manager', 'Administrator'],
        'edit_user' => ['admin', 'manager', 'Administrator'],
    ];
    
    // Check if the page exists in the access list and if the user role has access
    if (isset($pageAccess[$page])) {
        return count(array_intersect($userRoles, $pageAccess[$page])) > 0;
    }
    
    // Default to no access for undefined pages
    return false;
}

/**
 * Enforce access control for the current page
 * Redirects to dashboard with error message if access is denied
 */
function enforcePageAccess() {
    $currentPage = basename($_SERVER['PHP_SELF'], '.php');
    
    if (!hasPageAccess($currentPage)) {
        setAlert('You do not have permission to access this page', 'danger');
        header('Location: ' . BASE_PATH);
        exit;
    }
}
?> 