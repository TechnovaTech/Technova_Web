<?php
/**
 * Production Access Control Template
 * 
 * This file can be included at the top of any production page to enforce access control.
 * Copy and paste the following code at the beginning of each production page:
 * 
 * <?php
 * require_once 'includes/config.php';
 * require_once 'includes/functions.php';
 * require_once 'includes/access_control.php';
 * 
 * // Enforce page access before processing anything else
 * enforcePageAccess();
 * 
 * require_once 'includes/header.php';
 * ?>
 */
?> 