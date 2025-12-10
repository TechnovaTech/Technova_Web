<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

// Helper function to check if a PO has any parts with remaining melting materials.
function is_po_meltable($pdo, $po_id) {
    // Get all products for the PO
    $sql_parts = "SELECT product_id FROM purchase_order_products WHERE purchase_order_id = ?";
    $stmt_parts = $pdo->prepare($sql_parts);
    $stmt_parts->execute([$po_id]);
    $product_ids = $stmt_parts->fetchAll(PDO::FETCH_COLUMN);

    if (empty($product_ids)) return false;

    foreach ($product_ids as $product_id) {
        // Check if this part has remaining materials to be melted
        $sql_process_mats = "SELECT material_id FROM process_materials WHERE purchase_order_id = ? AND product_id = ? AND process_name = 'Melting'";
        $stmt_process_mats = $pdo->prepare($sql_process_mats);
        $stmt_process_mats->execute([$po_id, $product_id]);
        $material_ids = $stmt_process_mats->fetchAll(PDO::FETCH_COLUMN);

        if (empty($material_ids)) continue; // No melting materials for this part, so it's "done".

        foreach ($material_ids as $material_id) {
            $sql_total = "SELECT (COALESCE(o.per_unit, b.quantity_per_unit, 0) * pop.quantity) AS total_required, m.name as material_name FROM purchase_order_products pop JOIN materials m ON m.id = ? LEFT JOIN bom_items b ON m.id = b.material_id AND b.product_id = pop.product_id LEFT JOIN production_plan_bom_overrides o ON m.id = o.material_id AND o.product_id = pop.product_id AND o.purchase_order_id = pop.purchase_order_id WHERE pop.purchase_order_id = ? AND pop.product_id = ?";
            $stmt_total = $pdo->prepare($sql_total);
            $stmt_total->execute([$material_id, $po_id, $product_id]);
            $req_data = $stmt_total->fetch();
            $total_required = (float)($req_data['total_required'] ?? 0);
            $material_name = $req_data['material_name'] ?? '';

            $meltedStmt = $pdo->prepare("SELECT SUM(melted_metal_kg) FROM melting_batches WHERE po_id = ? AND product_id = ? AND TRIM(LOWER(metal_type)) = TRIM(LOWER(?))");
            $meltedStmt->execute([$po_id, $product_id, $material_name]);
            $already_melted = (float)($meltedStmt->fetchColumn() ?: 0);

            if (($total_required - $already_melted) > 0.001) {
                return true; // Found a material that is not fully melted, so this PO is meltable.
            }
        }
    }

    return false; // All parts and materials for this PO are fully melted.
}

require_once 'includes/header.php';

// Check if product_id column exists in melting_batches and add it if not
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM `melting_batches` LIKE 'product_id'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE melting_batches ADD COLUMN product_id INT(11) NULL AFTER po_id");
        // Add foreign key constraint, ignoring errors if it fails (e.g., already exists)
        try {
            $pdo->exec("ALTER TABLE melting_batches ADD CONSTRAINT fk_melting_batches_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL");
        } catch (PDOException $e) { /* ignore */ }
    }
    // Check if heat_code column exists and add it if not
    $stmt = $pdo->query("SHOW COLUMNS FROM `melting_batches` LIKE 'heat_code'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE melting_batches ADD COLUMN heat_code VARCHAR(255) NULL AFTER product_id");
    }
} catch (PDOException $e) {
    // Log error if altering table fails, but continue if it's not critical
    error_log("Could not alter melting_batches table: " . $e->getMessage());
}

// Database connection would be established in config.php

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Log form submission
    error_log("Form submitted: " . print_r($_POST, true));
    
    // Start a transaction
    $pdo->beginTransaction();

    try {
        // Common data from the form
        $part_id = $_POST['part_id'];
        $po_id = $_POST['po_id']; // Use the hidden field directly
        $date = $_POST['date'];
        $shift = $_POST['shift'];
        $operator_id = $_POST['operator_id'];
        $heat_code = $_POST['heat_code'] ?? null; // This is a single value for all rows
        // If you want heat_code per row, use heat_code[$material_index] and make the input an array

        // Prepare the insert statement once
        $sql = "INSERT INTO melting_batches (batch_number, po_id, product_id, heat_code, date, shift, operator_id, metal_type, raw_material_kg, melted_metal_kg, temperature) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        $materialNameStmt = $pdo->prepare("SELECT name FROM materials WHERE id = ?");
            
        // Loop through materials for this part
        if (isset($_POST['metal_name']) && is_array($_POST['metal_name'])) {
            foreach ($_POST['metal_name'] as $material_index => $material_id) {
                // Generate a unique batch number for each material row
                $batchNumber = 'MB-' . date('Ymd') . '-' . rand(1000, 9999);

                // Get the material name
                $materialNameStmt->execute([$material_id]);
                $metal_type = $materialNameStmt->fetchColumn();

                // Get other material-specific data
                $raw_material_kg = $_POST['raw_material_kg'][$material_index] ?? 0;
                $melted_metal_kg = $_POST['melted_metal_kg'][$material_index] ?? 0;
                $temperature = !empty($_POST['temperature'][$material_index]) ? $_POST['temperature'][$material_index] : null;

                // Debug log all values before insert
                error_log("Melting Insert: batchNumber=$batchNumber, po_id=$po_id, part_id=$part_id, heat_code=$heat_code, date=$date, shift=$shift, operator_id=$operator_id, metal_type=$metal_type, raw_material_kg=$raw_material_kg, melted_metal_kg=$melted_metal_kg, temperature=$temperature");

                if (!$metal_type) {
                    error_log("Material name not found for material_id $material_id, skipping row");
                    continue; // Skip this row if material name not found
                }

                // Execute the insert for this material
                $stmt->execute([
                    $batchNumber,
                    $po_id,
                    $part_id,
                    $heat_code,
                    $date,
                    $shift,
                    $operator_id,
                    $metal_type,
                    $raw_material_kg,
                    $melted_metal_kg,
                    $temperature
                ]);
            }
        }
            
        // Commit the transaction
        $pdo->commit();

        // Redirect after processing the form
        header('Location: melting.php?success=1'); 
        exit;

    } catch (Exception $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        // Log the error or display a user-friendly message
        error_log("Error adding melting batch: " . $e->getMessage() . "\n" . print_r($_POST, true));
        header('Location: melting.php?error=1&message=' . urlencode('An error occurred while adding the batch. Details: ' . $e->getMessage()));
        exit;
    }
}

// Test direct insertion into melting_batches
try {
    $testInsert = $pdo->prepare("INSERT INTO melting_batches 
                (batch_number, po_id, date, shift, operator_id, metal_type, raw_material_kg, melted_metal_kg, temperature) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $testResult = $testInsert->execute([
        'MB-TEST-' . date('Ymd') . '-' . rand(1000, 9999),
        1, // po_id
        date('Y-m-d'),
        'morning',
        1, // operator_id
        'Test Metal',
        100.00,
        95.00,
        1400.0
    ]);
    
    if ($testResult) {
        $testInsertId = $pdo->lastInsertId();
        $testMessage = "Test insertion successful. ID: $testInsertId";
    } else {
        $testMessage = "Test insertion failed.";
    }
} catch (Exception $e) {
    $testMessage = "Test insertion error: " . $e->getMessage();
}

// Define reason codes (needed for displaying rejection reasons if you add a table for rejections later)
$reasonCodes = [
    'porosity' => 'Porosity',
    'cracks' => 'Cracks',
    'shrinkage' => 'Shrinkage',
    'misrun' => 'Misrun',
    'inclusions' => 'Inclusions',
    'dimensional' => 'Dimensional Issues',
    'surface' => 'Surface Defects',
    'other' => 'Other'
];

// Define process stages for rejection
$processStages = [
    'melting' => 'Melting',
    'pouring' => 'Pouring',
    'molding' => 'Molding',
    'finishing' => 'Finishing',
    'inspection' => 'Inspection',
    'other' => 'Other'
];

// Get all active purchase orders for dropdown
$poStmt = $pdo->query("SELECT DISTINCT p.id as part_id, p.product_id_manual as part_id_manual, p.name as part_name, po.id as po_id, po.po_number, COALESCE(pop.sequence_order, 999) as sequence_order
                       FROM purchase_order_products pop
                       JOIN products p ON pop.product_id = p.id
                       JOIN purchase_orders po ON pop.purchase_order_id = po.id
                       WHERE po.status IN ('pending', 'processing') 
                       AND po.material_status = 'sufficient'
                       ORDER BY COALESCE(pop.sequence_order, 999), po.created_at DESC, p.name");
$allParts = $poStmt->fetchAll();

// Filter parts to only include those that still need melting
$availableParts = array_filter($allParts, function($part) use ($pdo) {
    $part_id = $part['part_id'];
    $po_id = $part['po_id'];
    
    // Get all materials for this part that are set for melting
    $sql_process_mats = "SELECT material_id FROM process_materials WHERE purchase_order_id = ? AND product_id = ? AND process_name = 'Melting'";
    $stmt_process_mats = $pdo->prepare($sql_process_mats);
    $stmt_process_mats->execute([$po_id, $part_id]);
    $material_ids = $stmt_process_mats->fetchAll(PDO::FETCH_COLUMN);

    if (empty($material_ids)) return false; // No melting materials for this part

    // Check each material to see if any still needs melting
    foreach ($material_ids as $material_id) {
        $sql_total = "SELECT (COALESCE(o.per_unit, b.quantity_per_unit, 0) * pop.quantity) AS total_required, m.name as material_name 
                      FROM purchase_order_products pop 
                      JOIN materials m ON m.id = ? 
                      LEFT JOIN bom_items b ON m.id = b.material_id AND b.product_id = pop.product_id 
                      LEFT JOIN production_plan_bom_overrides o ON m.id = o.material_id AND o.product_id = pop.product_id AND o.purchase_order_id = pop.purchase_order_id 
                      WHERE pop.purchase_order_id = ? AND pop.product_id = ?";
        $stmt_total = $pdo->prepare($sql_total);
        $stmt_total->execute([$material_id, $po_id, $part_id]);
        $req_data = $stmt_total->fetch();
        $total_required = (float)($req_data['total_required'] ?? 0);
        $material_name = $req_data['material_name'] ?? '';

        if ($total_required > 0) {
            $meltedStmt = $pdo->prepare("SELECT COALESCE(SUM(melted_metal_kg), 0) FROM melting_batches WHERE po_id = ? AND product_id = ? AND TRIM(LOWER(metal_type)) = TRIM(LOWER(?))");
            $meltedStmt->execute([$po_id, $part_id, $material_name]);
            $already_melted = (float)($meltedStmt->fetchColumn() ?: 0);

            if (($total_required - $already_melted) > 0.001) {
                return true; // Found a material that still needs melting
            }
        }
    }
    
    return false; // All materials for this part are fully melted
});

// If no parts found, add a debug message
if (empty($availableParts)) {
    error_log("No active parts found in database");
} else {
    error_log("Available parts: " . json_encode(array_map(function($part) {
        return ['part_id' => $part['part_id'], 'part_name' => $part['part_name'], 'po_id' => $part['po_id'], 'po_number' => $part['po_number']];
    }, $availableParts)));
}

// Get the logged-in user's ID
$loggedInUserId = $_SESSION['user_id'];
// Fetch the logged-in user's name
$userNameStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$userNameStmt->execute([$loggedInUserId]);
$loggedInUserName = $userNameStmt->fetchColumn();

// Get all batches for display
$stmt = $pdo->query("SELECT mb.*, u.name as operator_name, po.po_number, p.name as product_name
    FROM melting_batches mb 
    LEFT JOIN users u ON mb.operator_id = u.id
    LEFT JOIN purchase_orders po ON mb.po_id = po.id
    LEFT JOIN products p ON mb.product_id = p.id
    ORDER BY mb.date DESC, mb.id DESC");
$batches = $stmt->fetchAll();

// Get the latest rejection for each PO in the melting stage
$rejectionStmt = $pdo->query("SELECT
    r.po_id,
    r.quantity,
    r.reason_code,
    r.inspector_id,
    r.remarks,
    r.created_at,
    u.name as inspector_name
FROM
    rejections r
LEFT JOIN
    users u ON r.inspector_id = u.id
WHERE r.process_stage = 'melting'
ORDER BY r.po_id, r.created_at DESC");
$latestRejections = [];
$currentPoId = null;
foreach ($rejectionStmt->fetchAll() as $rejection) {
    if ($rejection['po_id'] !== $currentPoId) {
        $latestRejections[$rejection['po_id']] = $rejection;
        $currentPoId = $rejection['po_id'];
    }
}

// Get rejection history for each PO
$rejectionHistoryStmt = $pdo->query("SELECT 
    r.*, 
    u.name as inspector_name,
    po.po_number,
    CASE 
        WHEN r.process_stage = 'melting' THEN 'Melting'
        WHEN r.process_stage = 'moulding' THEN 'Moulding'
        WHEN r.process_stage = 'knockout' THEN 'Knockout'
        WHEN r.process_stage = 'shot_blasting' THEN 'Shot Blasting'
        WHEN r.process_stage = 'fettling' THEN 'Fettling'
        ELSE r.process_stage
    END as process_name
FROM rejections r
LEFT JOIN users u ON r.inspector_id = u.id
LEFT JOIN purchase_orders po ON r.po_id = po.id
ORDER BY r.created_at DESC");
$rejectionHistory = $rejectionHistoryStmt->fetchAll();

// Group rejections by PO
$rejectionsByPO = [];
foreach ($rejectionHistory as $rejection) {
    if (!isset($rejectionsByPO[$rejection['po_id']])) {
        $rejectionsByPO[$rejection['po_id']] = [];
    }
    $rejectionsByPO[$rejection['po_id']][] = $rejection;
}

// Group batches by PO, Part Name, and Heat Code for rowspan rendering
$grouped_batches = [];
foreach ($batches as $batch) {
    $po = $batch['po_number'] ?? 'N/A';
    $part = $batch['product_name'] ?? 'N/A';
    $heat_code = $batch['heat_code'] ?: 'N/A';
    $grouped_batches[$po][$part][$heat_code][] = $batch;
}

?>

<div class="container mt-4">
    <h2 class="p-3">Melting Batches</h2>
    
    <?php if (isset($testMessage)): ?>
        <div >
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Batch added successfully!</div>
    <?php endif; ?>
    
    <form method="POST" action="melting.php" class="row g-3 mb-4" id="meltingForm" style="background-color:     #d1e0e0 ;">        
        <div class="row">
            <div class="col-md-3">
                <label for="part_id" class="form-label">Part</label>
                <select name="part_id" id="part_id" class="form-select" required>
                    <option value="">Select Part</option>
                    <?php foreach ($availableParts as $part): ?>
                    <option value="<?= $part['part_id'] ?>" data-po-id="<?= $part['po_id'] ?>">#<?= $part['sequence_order'] ?> - Part ID: <?= htmlspecialchars($part['part_id_manual']) ?> - <?= htmlspecialchars($part['part_name']) ?> (PO: <?= htmlspecialchars($part['po_number']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="po_id" id="po_id">
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-3">
                <label for="shift" class="form-label">Shift</label>
                <select name="shift" id="shift" class="form-select" required>
                    <option value="morning">Morning</option>
                    <option value="evening">Evening</option>
                    <option value="night">Night</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="operator_id" class="form-label">Operator</label>
                <select name="operator_id" id="operator_id" class="form-select" required readonly>
                    <option value="<?= $loggedInUserId ?>" selected><?= htmlspecialchars($loggedInUserName) ?></option>
                </select>
            </div>
        </div>
        <div class="row" id="partsRowsContainer">
            <!-- Dynamic part rows will be inserted here -->
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-info">Add Batch</button>
        </div>
    </form>
    
    <div class="table-responsive">
        <?php if (isset($batches) && count($batches) > 0): ?>
        <div class="accordion" id="meltingHistoryAccordion">
            <?php $poIndex = 0; foreach ($grouped_batches as $po_number => $parts): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?= $poIndex ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse<?= $poIndex ?>" aria-expanded="false"
                            aria-controls="collapse<?= $poIndex ?>">
                        PO: <?= htmlspecialchars($po_number) ?>
                    </button>
                </h2>
                <div id="collapse<?= $poIndex ?>" class="accordion-collapse collapse"
                     aria-labelledby="heading<?= $poIndex ?>" data-bs-parent="#meltingHistoryAccordion">
                    <div class="accordion-body">
                        <table class="table table-bordered table-striped table-nowrap mb-0">
            <thead>
                <tr style="background-color: #d1e0e0;">
                    <th>PO</th>
                    <th>Part Name</th>
                                    <th>Heat Code</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>Metal Type</th>
                    <th>Raw Material (kg)</th>
                    <th>Melted Metal (kg)</th>
                    <th>Temperature</th>
                </tr>
            </thead>
            <tbody>
                                <?php
                                $po_rowspan = 0;
                                foreach ($parts as $heat_codes) {
                                    foreach ($heat_codes as $rows) {
                                        $po_rowspan += count($rows);
                                    }
                                }
                                ?>
                        <?php $po_printed = false; ?>
                                <?php foreach ($parts as $part_name => $heat_codes): ?>
                                    <?php
                                    $part_rowspan = 0;
                                    foreach ($heat_codes as $rows) {
                                        $part_rowspan += count($rows);
                                    }
                                    ?>
                            <?php $part_printed = false; ?>
                                    <?php foreach ($heat_codes as $heat_code => $rows): ?>
                                        <?php $heat_code_rowspan = count($rows); ?>
                                        <?php $heat_code_printed = false; ?>
                            <?php foreach ($rows as $row): ?>
                            <tr>
                                <?php if (!$po_printed): ?>
                                    <td rowspan="<?= $po_rowspan ?>" class="fw-bold" style="vertical-align: middle; background: #f3f6f6; border-bottom: 3px solid #b0bfc6;">
                                        <?= htmlspecialchars($po_number) ?>
                                    </td>
                                    <?php $po_printed = true; ?>
                                <?php endif; ?>
                                <?php if (!$part_printed): ?>
                                    <td rowspan="<?= $part_rowspan ?>" style="vertical-align: middle; background: #f8fafb; border-bottom: 2px solid #b0bfc6;">
                                        <?= htmlspecialchars($part_name) ?>
                                    </td>
                                    <?php $part_printed = true; ?>
                                <?php endif; ?>
                                            <?php if (!$heat_code_printed): ?>
                                                <td rowspan="<?= $heat_code_rowspan ?>" style="vertical-align: middle; background: #f8fafb;">
                                                    <?= htmlspecialchars($heat_code) ?>
                                                </td>
                                                <?php $heat_code_printed = true; ?>
                                            <?php endif; ?>
                                <td><?= $row['date'] ?></td>
                                <td><?= ucfirst($row['shift']) ?></td>
                                <td><?= htmlspecialchars($row['operator_name']) ?></td>
                                <td><?= htmlspecialchars($row['metal_type']) ?></td>
                                <td><?= $row['raw_material_kg'] ?></td>
                                <td><?= $row['melted_metal_kg'] ?></td>
                                <td><?= $row['temperature'] ? $row['temperature'] . ' °C' : '-' ?></td>
                    </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php $poIndex++; endforeach; ?>
        </div>
                <?php else: ?>
            <table class="table table-bordered table-striped table-nowrap">
                <thead>
                    <tr style="background-color: #d1e0e0;">
                        <th>PO</th>
                        <th>Part Name</th>
                        <th>Heat Code</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Operator</th>
                        <th>Metal Type</th>
                        <th>Raw Material (kg)</th>
                        <th>Melted Metal (kg)</th>
                        <th>Temperature</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10" class="text-center">No melting batches found</td>
                    </tr>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<style>
.btn-orange {
    background-color: #ff9800;
    color: #fff;
    border: none;
}
.btn-orange:hover, .btn-orange:focus {
    background-color: #e65100;
    color: #fff;
}
/* Accordion custom styles */
.accordion-item {
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    margin-bottom: 1rem;
    border: 1px solid #b0bfc6;
}
.accordion-button {
    background: linear-gradient(90deg, #d1e0e0 60%, #b0c4c6 100%);
    color: #222;
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    box-shadow: none;
    transition: background 0.2s;
}
.accordion-button:not(.collapsed) {
    background: linear-gradient(90deg, #b0c4c6 60%, #d1e0e0 100%);
    color: #0a3d62;
}
.accordion-button:hover {
    background: #b0c4c6;
    color: #0a3d62;
}
.accordion-body {
    background: #f8fafb;
    border-radius: 0 0 0.5rem 0.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const partSelect = document.getElementById('part_id');
    const partsRowsContainer = document.getElementById('partsRowsContainer');
    const poIdInput = document.getElementById('po_id');

    partSelect.addEventListener('change', function() {
        const selectedPartId = this.value;
        const selectedPoId = this.options[this.selectedIndex].getAttribute('data-po-id');
        poIdInput.value = selectedPoId; // Update hidden input

        if (selectedPartId) {
            fetch('ajax_get_melting_materials.php?po_id=' + encodeURIComponent(selectedPoId) + '&product_id=' + encodeURIComponent(selectedPartId))
                .then(res => res.json())
                .then(matData => {
                    if (matData.success && Array.isArray(matData.materials) && matData.materials.length > 0) {
                        partsRowsContainer.innerHTML = '';
                        // Show materials for the selected part
                        addMaterialRows(matData.materials);
                    } else {
                        partsRowsContainer.innerHTML = '<div class="col-12 text-danger">No materials found for this part.</div>';
                    }
                })
                .catch(() => {
                    partsRowsContainer.innerHTML = '<div class="col-12 text-danger">Failed to load material details.</div>';
                });
        } else {
            partsRowsContainer.innerHTML = '';
        }
    });

    // Function to add material rows for the selected part
    function addMaterialRows(materialsList) {
        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class='col-md-3'>
                <label class='form-label'>Heat Code</label>
                <input type='text' class='form-control' name='heat_code'>
            </div>
            <div class='col-md-7'>
                <div class='material-rows'></div>
            </div>
            <div class='col-md-2 d-flex align-items-end'>
                <button type='button' class='btn btn-success btn-sm add-material-row' title='Add Material'><i class='fas fa-plus-circle'></i> Add Material</button>
            </div>
        `;
        partsRowsContainer.appendChild(row);
        
        const materialRowsDiv = row.querySelector('.material-rows');
        let lastMatData = { success: true, materials: materialsList };
        
        // Add initial material row
        addMaterialRow(materialRowsDiv, lastMatData);
        
        // Add Material button logic
        const addMaterialBtn = row.querySelector('.add-material-row');
        addMaterialBtn.addEventListener('click', function() {
            addMaterialRow(materialRowsDiv, lastMatData);
        });
    }

    // Update addMaterialRow to accept matData as a parameter
    function addMaterialRow(materialRowsDiv, matData) {
        let materialOptions = '';
        let materialTotals = {};
        let materialMelted = {};
        let materialRemainder = {};
        if (matData && matData.success && Array.isArray(matData.materials) && matData.materials.length > 0) {
            matData.materials.forEach(mat => {
                materialOptions += `<option value='${mat.id}' data-total='${mat.total_required}' data-melted='${mat.already_melted}' data-remainder='${mat.remainder}'>${mat.name} (${mat.type})</option>`;
                materialTotals[mat.id] = mat.total_required;
                materialMelted[mat.id] = mat.already_melted;
                materialRemainder[mat.id] = mat.remainder;
            });
        } else {
            materialOptions = '<option value="">No materials set for Melting or all are complete</option>';
        }

        const matRow = document.createElement('div');
        matRow.className = 'row mb-2 align-items-end material-row';
        matRow.innerHTML = `
            <div class='col-md-3'>
                <label class='form-label'>Metal Name</label>
                <select class='form-select' name='metal_name[]' required>${materialOptions}</select>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Raw Material (kg)</label>
                <input type='number' step='0.001' class='form-control' name='raw_material_kg[]' required>
                <div class='form-text remainder-info'></div>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Melted Metal (kg)</label>
                <input type='number' step='0.001' class='form-control' name='melted_metal_kg[]' required>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Temperature (°C)</label>
                <input type='number' step='0.1' class='form-control' name='temperature[]'>
            </div>
            <div class='col-md-1 d-flex align-items-end'>
                <button type='button' class='btn btn-orange btn-sm remove-material-row' title='Remove Material'><i class='fas fa-times'></i></button>
            </div>
        `;
        materialRowsDiv.appendChild(matRow);

        // Remove Material button logic
        const removeBtn = matRow.querySelector('.remove-material-row');
        removeBtn.addEventListener('click', function() {
            matRow.remove();
            updateRemoveMaterialButtons(materialRowsDiv);
        });
        // Hide remove button if only one material row
        function updateRemoveMaterialButtons(container) {
            const allRemoveBtns = container.querySelectorAll('.remove-material-row');
            if (allRemoveBtns.length === 1) {
                allRemoveBtns[0].style.display = 'none';
            } else {
                allRemoveBtns.forEach(btn => btn.style.display = '');
            }
        }
        updateRemoveMaterialButtons(materialRowsDiv);

        // Auto-fill logic for raw material and show remainder
        const metalSelect = matRow.querySelector('.form-select');
        const rawInput = matRow.querySelector('input[name*="raw_material_kg"]');
        const meltedInput = matRow.querySelector('input[name*="melted_metal_kg"]');
        const remainderInfo = matRow.querySelector('.remainder-info');

        const setRawValueAndRemainder = () => {
            const selected = metalSelect.options[metalSelect.selectedIndex];
            if (selected) {
                const total = selected.getAttribute('data-total');
                const melted = selected.getAttribute('data-melted');
                const remainder = selected.getAttribute('data-remainder');
                rawInput.value = total ? Number(total).toFixed(3) : '';
                remainderInfo.textContent = `Remainder: ${remainder ? Number(remainder).toFixed(3) : '0.000'} kg (Already melted: ${melted ? Number(melted).toFixed(3) : '0.000'} kg)`;
            }
        };
        metalSelect.addEventListener('change', setRawValueAndRemainder);
        if (metalSelect.options.length > 0) {
            setRawValueAndRemainder(); // Set initial value and remainder
        }
        // Force 3 decimal places on input blur
        rawInput.addEventListener('blur', function() {
            if (rawInput.value) rawInput.value = Number(rawInput.value).toFixed(3);
        });
        meltedInput.addEventListener('blur', function() {
            if (meltedInput.value) meltedInput.value = Number(meltedInput.value).toFixed(3);
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?> 