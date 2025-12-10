<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php';

// Define base path constant only if not already defined
if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/erp/');
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Buffer the output to prevent "headers already sent" errors
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Casting ERP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-bg: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .list-group-item.active {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .card {
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
        }
        
        .btn-outline-primary {
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .sidebar {
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            height: calc(100vh - 56px);
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px; /* Approximate width of the sidebar */
            z-index: 1000;
            padding-top: 20px;
            overflow-y: auto; /* Add scroll if content is too long */
        }
        
        .sidebar .list-group-item {
            border: none;
            border-radius: 0;
            padding: 12px 20px;
        }
        
        .sidebar .list-group-item:hover {
            background-color: #f8f9fa;
        }
        
        .sidebar .list-group-item.active {
            background-color: #e9ecef;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .sidebar .list-group-item.active i {
            color: var(--secondary-color);
        }
        
        .main-content {
            padding: 20px;
            padding-top: 30px;
            margin-left: 250px; /* Add left margin to compensate for fixed sidebar width */
            /* Adjust height and overflow to make content area scrollable */
            height: calc(100vh - 56px); /* Full viewport height minus navbar height */
            overflow-y: auto;
        }
        
        .page-title {
            margin-bottom: 25px;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .dashboard-stat {
            padding: 20px;
            border-radius: 8px;
            color: white;
            height: 100%;
        }
        
        .dashboard-stat h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .dashboard-stat p {
            margin-bottom: 0;
            opacity: 0.8;
        }
        
        .table th {
            font-weight: 600;
            background-color: rgba(0,0,0,0.02);
        }
        
        /* Adjustments for smaller screens if sidebar becomes non-fixed */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                top: 0;
                width: 100%;
                height: auto;
                overflow-y: visible;
            }
            .main-content {
                margin-left: 0; /* Remove margin when sidebar is not fixed */
                height: auto;
                overflow-y: visible;
            }
        }
        
        html, body {
            height: 100%;
            overflow: hidden !important;
        }
        .main-content {
            height: calc(100vh - 56px);
            overflow-y: auto;
        }
        .sidebar {
            height: calc(100vh - 56px);
            overflow-y: auto;
            position: fixed;
            top: 56px;
            left: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASE_PATH ?>">
                <i class="fas fa-industry me-2"></i>
                Investment Casting ERP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($isLoggedIn): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?= $_SESSION['username'] ?? 'User' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= BASE_PATH ?>profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_PATH ?>settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= BASE_PATH ?>auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_PATH ?>auth/login.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Include Sidebar -->
            <?php include_once __DIR__ . '/sidebar.php'; ?>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <?php if (isset($_SESSION['alert'])): ?>
                <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show mt-3" role="alert">
                    <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['alert']); endif; ?>
