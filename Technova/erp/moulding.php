<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

require_once 'includes/header.php';

// Check if product_id column exists in moulding_batches and add it if not
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM `moulding_batches` LIKE 'product_id'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE moulding_batches ADD COLUMN product_id INT(11) NULL AFTER po_id");
        try {
            $pdo->exec("ALTER TABLE moulding_batches ADD CONSTRAINT fk_moulding_batches_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL");
        } catch (PDOException $e) { /* ignore */ }
    }
} catch (PDOException $e) {
    error_log("Could not alter moulding_batches table: " . $e->getMessage());
}

// Check if mould_type column exists in moulding_batches and add it if not
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM `moulding_batches` LIKE 'mould_type'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE moulding_batches ADD COLUMN mould_type VARCHAR(255) NULL AFTER operator_id");
    }
    // Check if heat_code column exists and add it if not
    $stmt = $pdo->query("SHOW COLUMNS FROM `moulding_batches` LIKE 'heat_code'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE moulding_batches ADD COLUMN heat_code VARCHAR(255) NULL AFTER product_id");
    }
} catch (PDOException $e) {
    error_log("Could not alter moulding_batches table: " . $e->getMessage());
}

// Add product_id to rejections table if it doesn't exist
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM `rejections` LIKE 'product_id'");
    if ($stmt->rowCount() == 0) {
        // Add after po_id for logical grouping
        $pdo->exec("ALTER TABLE rejections ADD COLUMN product_id INT(11) NULL AFTER po_id");
        // Add foreign key constraint, ignoring errors if it fails
        try {
            $pdo->exec("ALTER TABLE rejections ADD CONSTRAINT fk_rejections_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL");
        } catch (PDOException $e) { /* ignore */ }
    }
} catch (PDOException $e) {
    error_log("Could not alter rejections table: " . $e->getMessage());
}

// Database connection would be established in config.php

// Define reason codes
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();

    try {
        // Common data from the form
        $part_id = $_POST['part_id'];
        $po_id = $_POST['po_id']; // This will be the PO ID associated with the part
        $date = $_POST['date'];
        $shift = $_POST['shift'];
        $operator_id = $_POST['operator_id'];

        // Get the PO ID for the selected part
        $poStmt = $pdo->prepare("SELECT pop.purchase_order_id FROM purchase_order_products pop WHERE pop.product_id = ?");
        $poStmt->execute([$part_id]);
        $po_id = $poStmt->fetchColumn();

        $sql = "INSERT INTO moulding_batches (batch_number, po_id, product_id, heat_code, date, shift, operator_id, mould_type, mould_quantity, sand_type, sand_used_kg) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
        
        $materialNameStmt = $pdo->prepare("SELECT name FROM materials WHERE id = ?");

        // Loop through moulding activities for this part
        if (isset($_POST['mould_quantity']) && is_array($_POST['mould_quantity'])) {
            foreach ($_POST['mould_quantity'] as $activity_index => $mould_quantity) {
                $heat_code = $_POST['heat_code'] ?? null;
                // Generate a unique batch number for each part's moulding batch
                $batchNumber = 'ML-' . date('Ymd') . '-' . rand(1000, 9999);
                
                $mould_type = $_POST['mould_type'][$activity_index] ?? '';
                
                $sand_material_id = $_POST['sand_type'][$activity_index] ?? null;
                $sand_type_name = 'N/A';
                if ($sand_material_id) {
                    $materialNameStmt->execute([$sand_material_id]);
                    $sand_type_name = $materialNameStmt->fetchColumn() ?: 'N/A';
                }
                
                $sand_used_kg = $_POST['sand_used_kg'][$activity_index] ?? 0;

                $stmt->execute([
                    $batchNumber,
                    $po_id,
                    $part_id,
                    $heat_code,
                    $date,
                    $shift,
                    $operator_id,
                    $mould_type,
                    $mould_quantity,
                    $sand_type_name,
                    $sand_used_kg
                ]);
            }
        }
        
        // Process Rejection Details from the separate form section (now supports multiple)
        if (isset($_POST['rejection_part_id']) && is_array($_POST['rejection_part_id'])) {
            $rejectionSql = "INSERT INTO rejections (po_id, product_id, process_stage, quantity, reason_code, inspector_id, remarks) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            $rejectionStmt = $pdo->prepare($rejectionSql);
            foreach ($_POST['rejection_part_id'] as $idx => $rejection_part_id) {
                $rejection_quantity = $_POST['rejection_quantity'][$idx] ?? 0;
                $rejection_reason = $_POST['rejection_reason'][$idx] ?? 'N/A';
                if (!empty($rejection_part_id) && $rejection_quantity > 0) {
                    $rejectionStmt->execute([
                        $po_id,
                        $rejection_part_id,
                        'moulding',
                        $rejection_quantity,
                        $rejection_reason,
                        $operator_id, // Inspector is the operator
                        '' // Remarks can be added later if needed
                    ]);
                }
            }
        }

        // Commit the transaction
        $pdo->commit();
    
    // Redirect after processing the form
    header('Location: moulding.php?success=1'); 
    exit;

    } catch (Exception $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        error_log("Error adding moulding batch: " . $e->getMessage() . "\n" . print_r($_POST, true));
        header('Location: moulding.php?error=1&message=' . urlencode('An error occurred while adding the batch.'));
        exit;
    }
}

// Get all active purchase orders for dropdown
$poStmt = $pdo->query("SELECT DISTINCT p.id as part_id, p.product_id_manual as part_id_manual, p.name as part_name, po.id as po_id, po.po_number, COALESCE(pop.sequence_order, 999) as sequence_order
                       FROM purchase_order_products pop
                       JOIN products p ON pop.product_id = p.id
                       JOIN purchase_orders po ON pop.purchase_order_id = po.id
                       WHERE po.status IN ('pending', 'processing')
                       ORDER BY COALESCE(pop.sequence_order, 999), po.created_at DESC, p.name");
$allParts = $poStmt->fetchAll();

// Only include parts that have some melting completed (not necessarily fully melted)
$availableParts = array_filter($allParts, function($part) use ($pdo) {
    $part_id = $part['part_id'];
    $po_id = $part['po_id'];
    
    // Get all materials for this part that are set for melting
    $sql_process_mats = "SELECT material_id FROM process_materials WHERE purchase_order_id = ? AND product_id = ? AND process_name = 'Melting'";
    $stmt_process_mats = $pdo->prepare($sql_process_mats);
    $stmt_process_mats->execute([$po_id, $part_id]);
    $material_ids = $stmt_process_mats->fetchAll(PDO::FETCH_COLUMN);

    if (empty($material_ids)) return false; // No melting materials for this part

    // Check if ANY material has been melted (even partially)
    $hasMelted = false;
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

            if ($already_melted > 0.001) {
                $hasMelted = true;
                break;
            }
        }
    }
    if (!$hasMelted) return false;

    // Check if fully moulded
    $stmt_req = $pdo->prepare("SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?");
    $stmt_req->execute([$po_id, $part_id]);
    $required_qty = (float)($stmt_req->fetchColumn() ?: 0);
    $stmt_moulded = $pdo->prepare("SELECT COALESCE(SUM(mould_quantity), 0) FROM moulding_batches WHERE po_id = ? AND product_id = ?");
    $stmt_moulded->execute([$po_id, $part_id]);
    $moulded_qty = (float)($stmt_moulded->fetchColumn() ?: 0);
    if ($moulded_qty >= $required_qty - 0.001) return false; // Fully moulded

    return true;
});

// Get the logged-in user's ID and name
$loggedInUserId = $_SESSION['user_id'];
$userNameStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$userNameStmt->execute([$loggedInUserId]);
$loggedInUserName = $userNameStmt->fetchColumn();

// Get all batches for display
$stmt = $pdo->query("SELECT mb.*, u.name as operator_name, po.po_number, p.name as product_name
    FROM moulding_batches mb 
    LEFT JOIN users u ON mb.operator_id = u.id
    LEFT JOIN purchase_orders po ON mb.po_id = po.id
    LEFT JOIN products p ON mb.product_id = p.id
    ORDER BY mb.date DESC, po.po_number, p.name");
$batches = $stmt->fetchAll();

// Get rejection history
$rejectionHistoryStmt = $pdo->query("SELECT 
    r.*, 
    u.name as inspector_name,
    po.po_number,
    p.name as product_name,
    'Moulding' as process_name
FROM rejections r
LEFT JOIN users u ON r.inspector_id = u.id
LEFT JOIN purchase_orders po ON r.po_id = po.id
LEFT JOIN products p ON r.product_id = p.id
WHERE r.process_stage = 'moulding'
ORDER BY r.created_at DESC");
$rejectionHistory = $rejectionHistoryStmt->fetchAll();

// Group rejection history by PO and Part Name for rowspan
$grouped_rejections = [];
foreach ($rejectionHistory as $rej) {
    $po = $rej['po_number'] ?? 'N/A';
    $part = $rej['product_name'] ?? 'N/A';
    $grouped_rejections[$po][$part][] = $rej;
}

// Group batches by PO, Part Name, and Heat Code for rowspan rendering
$grouped_batches = [];
if (is_array($batches)) {
    foreach ($batches as $batch) {
        $po = $batch['po_number'] ?? 'N/A';
        $part = $batch['product_name'] ?? 'N/A';
        $heat_code = $batch['heat_code'] ?? 'N/A';
        $grouped_batches[$po][$part][$heat_code][] = $batch;
    }
}

// Fetch required quantity for each PO and part
$required_qty_map = [];
$stmt = $pdo->query("SELECT pop.purchase_order_id, pop.product_id, pop.quantity FROM purchase_order_products pop");
foreach ($stmt->fetchAll() as $row) {
    $required_qty_map[$row['purchase_order_id']][$row['product_id']] = $row['quantity'];
}
// Fetch completed quantity for each PO and part
$completed_qty_map = [];
$stmt = $pdo->query("SELECT po_id, product_id, SUM(mould_quantity) as completed_qty FROM moulding_batches GROUP BY po_id, product_id");
foreach ($stmt->fetchAll() as $row) {
    $completed_qty_map[$row['po_id']][$row['product_id']] = $row['completed_qty'];
}

?>

<div class="container mt-4">
    <h2 class="p-3">Moulding Batches</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Batch added successfully!</div>
    <?php endif; ?>
    
    <form method="POST" action="moulding.php" class="g-3 mb-4" id="mouldingForm" style="background-color: #d1e0e0; padding: 1rem;">        
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
        
        <div class="mt-4" id="partsRowsContainer">
            <!-- Dynamic part rows will be inserted here -->
        </div>

        <div class="col-12 mt-4 pt-3" style="background-color: #c1d1d1;">
            <h4 class="mb-3">Rejection Details</h4>
            <div id="rejectionSection">
                <div id="rejectionRows">
                    <p class="text-muted">Please select a Purchase Order to add rejections.</p>
                </div>
                <button type="button" class="btn btn-success btn-sm mt-2" id="addRejectionBtn" style="display: none;"><i class="fas fa-plus-circle"></i> Add Rejection</button>
        </div>
        </div>
        </div>

         <div class="col-12 mt-3">
            <button type="submit" class="btn btn-info">Add Batch</button>
        </div>
    </form>
    
    <div class="table-responsive">
        <?php if (count($grouped_batches) > 0): ?>
        <div class="accordion" id="mouldingHistoryAccordion">
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
                     aria-labelledby="heading<?= $poIndex ?>" data-bs-parent="#mouldingHistoryAccordion">
                    <div class="accordion-body">
                        <table class="table table-bordered table-striped table-nowrap mb-0">
            <thead>
                <tr style="background-color: #d1e0e0;">
                    <th>PO</th>
                    <th>Part Name</th>
                    <th>Required Qty</th>
                    <th>Completed Qty</th>
                    <th>Heat Code</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>Mould Type</th>
                    <th>Quantity</th>
                    <th>Sand Type</th>
                    <th>Sand Used (kg)</th>
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
                                    $product_id = null;
                                    foreach ($heat_codes as $rows) {
                                        $part_rowspan += count($rows);
                                        if (!$product_id && isset($rows[0]['product_id'])) $product_id = $rows[0]['product_id'];
                                    }
                                    $required_qty = isset($required_qty_map[$rows[0]['po_id']][$product_id]) ? $required_qty_map[$rows[0]['po_id']][$product_id] : '-';
                                    $completed_qty = isset($completed_qty_map[$rows[0]['po_id']][$product_id]) ? $completed_qty_map[$rows[0]['po_id']][$product_id] : 0;
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
                                    <td rowspan="<?= $part_rowspan ?>" style="vertical-align: middle; background: #f8fafb;"> <?= (is_numeric($required_qty) ? (int)$required_qty : $required_qty) ?> </td>
                                    <td rowspan="<?= $part_rowspan ?>" style="vertical-align: middle; background: #f8fafb;"> <?= $completed_qty ?> </td>
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
                                <td><?= htmlspecialchars($row['mould_type']) ?></td>
                                <td><?= $row['mould_quantity'] ?></td>
                                <td><?= htmlspecialchars($row['sand_type']) ?></td>
                                <td><?= $row['sand_used_kg'] ?></td>
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
                    <th>PO #</th>
                    <th>Part Name</th>
                    <th>Required Qty</th>
                    <th>Completed Qty</th>
                    <th>Heat Code</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>Mould Type</th>
                    <th>Quantity</th>
                    <th>Sand Type</th>
                    <th>Sand Used (kg)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="12" class="text-center">No moulding batches found.</td></tr>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    
    <!-- Rejection History Section -->
    <div class="mt-5">
        <h3 class="mb-4">Rejection History (Moulding Stage)</h3>
        <div class="table-responsive">
            <?php if (count($grouped_rejections) > 0): ?>
            <div class="accordion" id="rejectionHistoryAccordion">
                <?php $rejPoIndex = 0; foreach ($grouped_rejections as $po_number => $parts): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="rejHeading<?= $rejPoIndex ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#rejCollapse<?= $rejPoIndex ?>" aria-expanded="false"
                                aria-controls="rejCollapse<?= $rejPoIndex ?>">
                            PO: <?= htmlspecialchars($po_number) ?>
                        </button>
                    </h2>
                    <div id="rejCollapse<?= $rejPoIndex ?>" class="accordion-collapse collapse"
                         aria-labelledby="rejHeading<?= $rejPoIndex ?>" data-bs-parent="#rejectionHistoryAccordion">
                        <div class="accordion-body">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr style="background-color: #f2f2f2;">
                                        <th>PO #</th>
                                        <th>Part Name</th>
                                        <th>Process Stage</th>
                                        <th>Quantity</th>
                                        <th>Reason</th>
                                        <th>Inspector</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $po_rowspan = 0;
                                    foreach ($parts as $rows) { $po_rowspan += count($rows); }
                                    $po_printed = false;
                                    foreach ($parts as $part_name => $rows):
                                        $part_rowspan = count($rows);
                                        $part_printed = false;
                                        foreach ($rows as $row): ?>
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
                                                <td><?= htmlspecialchars($row['process_name']) ?></td>
                                                <td><?= $row['quantity'] ?></td>
                                                <td><?= htmlspecialchars($row['reason_code']) ?></td>
                                                <td><?= htmlspecialchars($row['inspector_name']) ?></td>
                                                <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php $rejPoIndex++; endforeach; ?>
            </div>
            <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th>PO #</th>
                        <th>Part Name</th>
                        <th>Process Stage</th>
                        <th>Quantity</th>
                        <th>Reason</th>
                        <th>Inspector</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="text-center">No rejections found for the moulding stage.</td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

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
            // Fetch moulding materials for the selected part
            fetch('ajax_get_moulding_materials.php?po_id=' + encodeURIComponent(selectedPoId) + '&product_id=' + encodeURIComponent(selectedPartId))
                .then(res => res.json())
                .then(matData => {
                    if (matData.success && Array.isArray(matData.materials) && matData.materials.length > 0) {
                        partsRowsContainer.innerHTML = '';
                        // Show moulding rows for the selected part
                        addMouldingRows(matData.materials);
                        
                        // Setup rejection section for this part
                        setupRejectionSection(selectedPartId, selectedPoId);
                    } else {
                        partsRowsContainer.innerHTML = '<div class="col-12 text-danger">No moulding materials found for this part.</div>';
                        setupRejectionSection(selectedPartId, selectedPoId);
                    }
                })
                .catch(() => {
                    partsRowsContainer.innerHTML = '<div class="col-12 text-danger">Failed to load moulding material details.</div>';
                    setupRejectionSection(selectedPartId, selectedPoId);
                });
        } else {
            partsRowsContainer.innerHTML = '';
            document.getElementById('rejectionRows').innerHTML = '<p class="text-muted">Please select a Part to add rejections.</p>';
            document.getElementById('addRejectionBtn').style.display = 'none';
        }
    });

    // Function to add moulding rows for the selected part
    function addMouldingRows(materialsList) {
        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class='col-md-3'>
                <label class='form-label'>Heat Code</label>
                <input type='text' class='form-control' name='heat_code'>
            </div>
            <div class='col-md-7'>
                <div class='moulding-rows'></div>
            </div>
            <div class='col-md-2 d-flex align-items-end'>
                <button type='button' class='btn btn-success btn-sm add-moulding-row' title='Add Moulding Row'><i class='fas fa-plus-circle'></i> Add Row</button>
            </div>
        `;
        partsRowsContainer.appendChild(row);
        
        const mouldingRowsDiv = row.querySelector('.moulding-rows');
        let lastMatData = { success: true, materials: materialsList };
        
        // Add initial moulding row
        addMouldingRow(mouldingRowsDiv, lastMatData);
        
        // Add Moulding Row button logic
        const addMouldingBtn = row.querySelector('.add-moulding-row');
        addMouldingBtn.addEventListener('click', function() {
            addMouldingRow(mouldingRowsDiv, lastMatData);
        });
    }

    function addMouldingRow(container, matData) {
        let materialOptions = '';
        if (matData && matData.success && Array.isArray(matData.materials) && matData.materials.length > 0) {
            materialOptions = '<option value="">Select Sand Type</option>';
            matData.materials.forEach(mat => {
                materialOptions += `<option value='${mat.id}'>${mat.name} (${mat.type})</option>`;
            });
        } else {
            materialOptions = '<option value="">No sand materials set for this part</option>';
        }

        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-end moulding-row-item';
        row.innerHTML = `
            <div class='col-md-3'>
                <label class='form-label'>Mould Type</label>
                <input type='text' name='mould_type[]' class='form-control' required>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Quantity</label>
                <div class='mould-qty-info form-text mb-1'></div>
                <input type='number' name='mould_quantity[]' class='form-control quantity-input' required>
                
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Sand Type</label>
                <select name='sand_type[]' class='form-select' required>
                    ${materialOptions}
                </select>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Sand Used (kg)</label>
                <input type='number' step='0.001' name='sand_used_kg[]' class='form-control' required>
            </div>
            <div class='col-md-2 d-flex align-items-end' style='display:none;'>
                 <button type='button' class='btn btn-orange btn-sm remove-moulding-row' title='Remove Row'><i class='fas fa-times'></i></button>
            </div>
        `;
        container.appendChild(row);

        row.querySelector('.remove-moulding-row').addEventListener('click', function() {
            if (container.querySelectorAll('.moulding-row-item').length > 1) {
                row.remove();
            }
            updateRemoveButtons(container);
        });
        updateRemoveButtons(container);

        // Live info for Quantity
        const qtyInput = row.querySelector('.quantity-input');
        const infoDiv = row.querySelector('.mould-qty-info');
        let required = 0;
        let completed = 0;
        function updateInfo() {
            const inputVal = parseFloat(qtyInput.value) || 0;
            const remaining = required - (completed + inputVal);
            infoDiv.innerHTML = `Required: ${required}, Already moulded: ${completed}, Remaining: ${remaining}`;
        }
        function fetchMouldingQty() {
            required = 0;
            completed = 0;
            const selectedPartId = partSelect.value;
            const selectedPoId = partSelect.options[partSelect.selectedIndex].getAttribute('data-po-id');
            if (selectedPartId && selectedPoId) {
                fetch(`ajax_get_moulding_qty.php?po_id=${selectedPoId}&product_id=${selectedPartId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            required = parseFloat(data.required) || 0;
                            completed = parseFloat(data.completed) || 0;
                        } else {
                            required = 0;
                            completed = 0;
                        }
                        updateInfo();
                    });
            } else {
                infoDiv.innerHTML = '';
            }
        }
        qtyInput.addEventListener('input', updateInfo);
        fetchMouldingQty();
    }

    function updateRemoveButtons(container) {
        const rows = container.querySelectorAll('.moulding-row-item');
        const buttons = container.querySelectorAll('.remove-moulding-row');
        buttons.forEach(btn => {
            btn.style.display = rows.length === 1 ? 'none' : '';
        });
    }

    // Function to setup rejection section
    function setupRejectionSection(partId, poId) {
        const rejectionRows = document.getElementById('rejectionRows');
        const addRejectionBtn = document.getElementById('addRejectionBtn');
        
        // Create rejection options for this part
        const partOption = `<option value="${partId}">${partSelect.options[partSelect.selectedIndex].text}</option>`;
        
        rejectionRows.innerHTML = '';
        addRejectionRow(rejectionRows, partOption);
        addRejectionBtn.style.display = 'block';
        addRejectionBtn.onclick = function() {
            addRejectionRow(rejectionRows, partOption);
        };
    }

    // Function to add rejection row
    function addRejectionRow(container, partOption) {
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-end mb-2 rejection-row';
        row.innerHTML = `
            <div class="col-md-3">
                <select name="rejection_part_id[]" class="form-select" required>${partOption}</select>
            </div>
            <div class="col-md-3">
                <input type="number" name="rejection_quantity[]" class="form-control" placeholder="Qty" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="rejection_reason[]" class="form-control" placeholder="Enter reason" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-orange btn-sm remove-rejection-row" title="Remove"><i class="fas fa-times"></i></button>
            </div>
        `;
        container.appendChild(row);
        row.querySelector('.remove-rejection-row').onclick = function() {
            row.remove();
        };
    }
});
</script>

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
</style>

<?php require_once 'includes/footer.php'; ?> 