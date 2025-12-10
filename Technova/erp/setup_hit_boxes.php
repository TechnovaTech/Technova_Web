<?php
echo "Starting hit boxes setup script...\n";

// Include configuration file
require_once 'includes/config.php';
echo "Configuration loaded.\n";

// SQL to create hit_boxes table
$sql = "CREATE TABLE IF NOT EXISTS hit_boxes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    stock DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

try {
    echo "Attempting to create hit_boxes table...\n";
    
    // Execute the SQL
    $pdo->exec($sql);
    
    echo "hit_boxes table created successfully!\n";
    
    // Check if table exists
    $checkSql = "SHOW TABLES LIKE 'hit_boxes'";
    $result = $pdo->query($checkSql);
    
    if ($result->rowCount() > 0) {
        echo "Verified: hit_boxes table exists in the database.\n";
    } else {
        echo "Warning: Could not verify hit_boxes table existence.\n";
    }
} catch (PDOException $e) {
    echo "Error creating hit_boxes table: " . $e->getMessage() . "\n";
}

// SQL to create hit_box_stock_adjustments table
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

try {
    echo "Attempting to create hit_box_stock_adjustments table...\n";
    
    // Execute the SQL
    $pdo->exec($sql);
    
    echo "hit_box_stock_adjustments table created successfully!\n";
    
    // Check if table exists
    $checkSql = "SHOW TABLES LIKE 'hit_box_stock_adjustments'";
    $result = $pdo->query($checkSql);
    
    if ($result->rowCount() > 0) {
        echo "Verified: hit_box_stock_adjustments table exists in the database.\n";
    } else {
        echo "Warning: Could not verify hit_box_stock_adjustments table existence.\n";
    }
} catch (PDOException $e) {
    echo "Error creating hit_box_stock_adjustments table: " . $e->getMessage() . "\n";
}

echo "Setup complete.\n";
?> 