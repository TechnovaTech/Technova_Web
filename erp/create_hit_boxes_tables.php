<?php
require_once 'includes/config.php';

try {
    // Create hit_boxes table
    $sql = "CREATE TABLE IF NOT EXISTS hit_boxes (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        stock DECIMAL(10,2) NOT NULL DEFAULT 0,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "hit_boxes table created successfully!<br>";
    
    // Create hit_box_stock_adjustments table
    $sql = "CREATE TABLE IF NOT EXISTS hit_box_stock_adjustments (
        id INT(11) NOT NULL AUTO_INCREMENT,
        hit_box_id INT(11) NOT NULL,
        adjustment_quantity DECIMAL(10,2) NOT NULL,
        notes TEXT,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY fk_hit_box_adjustments (hit_box_id),
        CONSTRAINT fk_hit_box_adjustments FOREIGN KEY (hit_box_id) REFERENCES hit_boxes (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "hit_box_stock_adjustments table created successfully!<br>";
    
    // Verify tables exist
    $tables = ['hit_boxes', 'hit_box_stock_adjustments'];
    foreach ($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($result->rowCount() > 0) {
            echo "Verified: $table table exists in the database.<br>";
        } else {
            echo "Warning: Could not verify $table table existence.<br>";
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?> 