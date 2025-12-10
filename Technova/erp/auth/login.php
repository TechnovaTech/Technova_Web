<?php
session_start();
require_once '../includes/config.php';

// Ensure users table exists
function ensureUsersTableExists($pdo) {
    try {
        $pdo->query("SELECT 1 FROM users LIMIT 1");
    } catch (PDOException $e) {
        // Table doesn't exist, create it
        $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `password` varchar(255) NOT NULL,
            `name` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `role` enum('Administrator','Manager','Operator') NOT NULL DEFAULT 'Operator',
            `active` tinyint(1) NOT NULL DEFAULT 1,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `last_login` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`),
            UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        
        // Create default admin user
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`) 
                    VALUES ('admin', '$password', 'Administrator', 'admin@example.com', 'Administrator')");
        
        // Add demo users
        $managerPass = password_hash('manager123', PASSWORD_DEFAULT);
        $operatorPass = password_hash('operator123', PASSWORD_DEFAULT);
        
        $pdo->exec("INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`) 
                    VALUES ('manager', '$managerPass', 'Manager', 'manager@example.com', 'Manager')");
        
        $pdo->exec("INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`) 
                    VALUES ('operator', '$operatorPass', 'Operator', 'operator@example.com', 'Operator')");
    }
}

// Ensure the users table exists
ensureUsersTableExists($pdo);

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_PATH);
    exit;
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        setAlert('Please enter both username and password', 'danger');
    } else {
        try {
            // Check if users table exists
            $tableExists = false;
            try {
                $tableCheck = $pdo->query("SHOW TABLES LIKE 'users'");
                $tableExists = ($tableCheck->rowCount() > 0);
            } catch (PDOException $e) {
                // Table doesn't exist
                $tableExists = false;
            }
            
            if ($tableExists) {
                // Get the column names from the users table
                $columns = [];
                $columnsResult = $pdo->query("SHOW COLUMNS FROM users");
                while ($column = $columnsResult->fetch(PDO::FETCH_ASSOC)) {
                    $columns[] = $column['Field'];
                }
                
                // Determine which columns to use for login and password
                $usernameColumn = in_array('username', $columns) ? 'username' : 'name';
                $passwordColumn = in_array('password', $columns) ? 'password' : 'password_hash';
                
                // Prepare the query based on available columns
                $stmt = $pdo->prepare("SELECT * FROM users WHERE {$usernameColumn} = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user[$passwordColumn])) {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user[$usernameColumn];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_roles'] = explode(',', $user['role']);
                    
                    // Update last login time if column exists
                    if (in_array('last_login', $columns)) {
                        $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                        $updateStmt->execute([$user['id']]);
                    }
                    
                    setAlert('Login successful. Welcome back!', 'success');
                    header('Location: ' . BASE_PATH);
                    exit;
                } else {
                    // Login failed
                    setAlert('Invalid username or password', 'danger');
                }
            } else {
                setAlert('User database not found. Please contact administrator.', 'danger');
            }
        } catch (PDOException $e) {
            setAlert('Database error: ' . $e->getMessage(), 'danger');
        }
    }
}

// For demo purposes only - REMOVE IN PRODUCTION
$demoUsers = [
    ['username' => 'admin', 'password' => 'password', 'role' => 'admin'],
    ['username' => 'store', 'password' => 'password', 'role' => 'store_manager'],
    ['username' => 'production', 'password' => 'password', 'role' => 'production'],
    ['username' => 'qc', 'password' => 'password', 'role' => 'qc'],
    ['username' => 'dispatch', 'password' => 'password', 'role' => 'dispatch']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Investment Casting ERP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 450px;
            margin: 100px auto;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            font-weight: 700;
            color: #2c3e50;
        }
        
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .login-card .card-header {
            background-color: #2c3e50;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 20px;
            text-align: center;
            font-weight: 600;
        }
        
        .login-card .card-body {
            padding: 30px;
        }
        
        .btn-login {
            background-color: #3498db;
            border-color: #3498db;
            padding: 10px;
            font-weight: 600;
        }
        
        .btn-login:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .demo-users {
            margin-top: 30px;
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }
        
        .demo-users h5 {
            color: #2c3e50;
            margin-bottom: 15px;
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
</head>
<body>
    <div class="container login-container">
        <div class="login-header">
            <h1><i class="fas fa-industry me-2"></i> Investment Casting ERP</h1>
            <p class="text-muted">Enter your credentials to access the system</p>
        </div>
        
        <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['alert']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['alert']); endif; ?>
        
        <div class="card login-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i> Login</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                        </div>
                    </div>
                    <div class="form-floating mb-3 position-relative">
                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" required />
                        <label for="password">Password</label>
                        <button type="button" class="password-eye-btn" onclick="togglePassword('password', this)" tabindex="-1">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login w-100">Login</button>
                </form>
                
                <!-- Demo Users Section - REMOVE IN PRODUCTION -->
                <!-- <div class="demo-users">
                    <h5><i class="fas fa-info-circle me-2"></i> Demo Users</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($demoUsers as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['password']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div> -->
            </div>
        </div>
        
        <div class="text-center mt-3">
            <p class="text-muted">&copy; <?= date('Y') ?> Investment Casting ERP. All rights reserved.</p>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
