<?php
echo "Starting setup script...\n";

// Include configuration file
require_once 'includes/config.php';
echo "Configuration loaded.\n";

// SQL to create po_materials table
$sql = "CREATE TABLE IF NOT EXISTS po_materials (
    id INT(11) NOT NULL AUTO_INCREMENT,
    po_id INT(11) NOT NULL,
    material_id INT(11) NOT NULL,
    material_type ENUM('core', 'sleeve', 'metal') NOT NULL,
    quantity_required DECIMAL(10,2) NOT NULL,
    is_alternative TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY fk_po_materials_po (po_id),
    KEY fk_po_materials_material (material_id),
    CONSTRAINT fk_po_materials_po FOREIGN KEY (po_id) REFERENCES purchase_orders (id) ON DELETE CASCADE,
    CONSTRAINT fk_po_materials_material FOREIGN KEY (material_id) REFERENCES materials (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

try {
    echo "Attempting to create po_materials table...\n";
    
    // Execute the SQL
    $pdo->exec($sql);
    
    echo "po_materials table created successfully!\n";
    
    // Check if table exists
    $checkSql = "SHOW TABLES LIKE 'po_materials'";
    $result = $pdo->query($checkSql);
    
    if ($result->rowCount() > 0) {
        echo "Verified: po_materials table exists in the database.\n";
    } else {
        echo "Warning: Could not verify po_materials table existence.\n";
    }
} catch (PDOException $e) {
    echo "Error creating po_materials table: " . $e->getMessage() . "\n";
}

echo "Setup complete.\n";
?> 