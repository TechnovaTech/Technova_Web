<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

require_once 'includes/header.php';

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

// Helper function to check if a PO has any parts with remaining shot blasting required
function is_po_shotblastable($pdo, $po_id) {
    // Get all products for the PO
    $sql_parts = "SELECT product_id, quantity FROM purchase_order_products WHERE purchase_order_id = ?";
    $stmt_parts = $pdo->prepare($sql_parts);
    $stmt_parts->execute([$po_id]);
    $products = $stmt_parts->fetchAll(PDO::FETCH_ASSOC);
    if (empty($products)) return false;
    foreach ($products as $prod) {
        $product_id = $prod['product_id'];
        $product_qty = $prod['quantity'];
        // Get total processed in shot_blasting_batches
        $stmt_shot = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM shot_blasting_batches WHERE po_id = ? AND product_id = ?");
        $stmt_shot->execute([$po_id, $product_id]);
        $processed = (float)($stmt_shot->fetchColumn() ?: 0);
        if (($product_qty - $processed) > 0.001) {
            return true; // This part still needs shot blasting
        }
    }
    return false; // All parts fully processed
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();
    try {
        $po_id = $_POST['po_id'];
        $part_id = $_POST['part_id'][0];
        $date = $_POST['date'];
        $shift = $_POST['shift'];
        $operator_id = $_POST['operator_id'];
        $heat_code = $_POST['heat_code'][0] ?? null;

        // --- BACKEND VALIDATION: Prevent over-shot-blasting ---
        $stmt_knockout = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?");
        $stmt_knockout->execute([$po_id, $part_id]);
        $knockout_qty = (float)($stmt_knockout->fetchColumn() ?: 0);
        $stmt_shot = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM shot_blasting_batches WHERE po_id = ? AND product_id = ?");
        $stmt_shot->execute([$po_id, $part_id]);
        $already_shot_qty = (float)($stmt_shot->fetchColumn() ?: 0);
        $new_shot_qty = 0;
        if (isset($_POST['pieces_processed'][0]) && is_array($_POST['pieces_processed'][0])) {
            foreach ($_POST['pieces_processed'][0] as $q) {
                $new_shot_qty += (float)$q;
            }
        }
        if (($already_shot_qty + $new_shot_qty) > $knockout_qty + 0.001) {
            $pdo->rollBack();
            $form_error = 'Cannot shot blast more than the knocked out quantity! (Knocked out: ' . $knockout_qty . ', Already shot blasted: ' . $already_shot_qty . ', Attempted: ' . $new_shot_qty . ')';
        } else {
            if (isset($_POST['part_id']) && is_array($_POST['part_id'])) {
                foreach ($_POST['part_id'] as $idx => $partId) {
                    $heatCode = isset($_POST['heat_code'][$idx]) ? $_POST['heat_code'][$idx] : null;
                    // Now loop over all shot rows for this part
                    if (isset($_POST['pieces_processed'][$idx]) && is_array($_POST['pieces_processed'][$idx])) {
                        foreach ($_POST['pieces_processed'][$idx] as $rowIdx => $piecesProcessed) {
                            $mediaType = $_POST['media_type'][$idx][$rowIdx] ?? null;
                            $duration = $_POST['duration_minutes'][$idx][$rowIdx] ?? null;
                            $notes = $_POST['notes'][$idx][$rowIdx] ?? null;
    $batchNumber = 'SB-' . date('Ymd') . '-' . rand(1000, 9999);
                            $sql = "INSERT INTO shot_blasting_batches (batch_number, po_id, product_id, date, shift, operator_id, pieces_processed, media_type, duration_minutes, notes, heat_code) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
                        $batchNumber, $po_id, $partId, $date, $shift, $operator_id, $piecesProcessed, $mediaType, $duration, $notes, $heatCode
    ]);
                        }
                    }
                }
            }
            
            // TODO: Update material stock or inventory if necessary
            
            // Process Rejection Details (multi-row)
            if (isset($_POST['rejection_part_id']) && is_array($_POST['rejection_part_id'])) {
                $rejectionSql = "INSERT INTO rejections (po_id, product_id, process_stage, quantity, reason_code, inspector_id, remarks) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";
                $rejectionStmt = $pdo->prepare($rejectionSql);
                foreach ($_POST['rejection_part_id'] as $idx => $rejection_part_id) {
                    $rejection_quantity = $_POST['rejection_quantity'][$idx] ?? 0;
                    $rejection_reason = $_POST['rejection_reason'][$idx] ?? 'N/A';
                    $process_stage = 'shot_blasting';
                    if (!empty($rejection_part_id) && $rejection_quantity > 0) {
        $rejectionStmt->execute([
                    $po_id,
                    $rejection_part_id,
                    $process_stage,
                    $rejection_quantity,
                    $rejection_reason,
                    $operator_id, // Inspector is the operator
                    '' // Remarks can be added later if needed
                ]);
                    }
                }
            }
            
            $pdo->commit();
            header('Location: shot_blasting.php?success=1');
            exit;
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $form_error = 'An error occurred while adding the batch.';
        error_log("Error adding shot blasting batch: " . $e->getMessage() . "\n" . print_r($_POST, true));
    }
}

// Get all active parts for shot blasting dropdown (with sequence, manual id, and only those with some knockout done and not fully shot blasted)
$poStmt = $pdo->query("SELECT DISTINCT p.id as part_id, p.product_id_manual as part_id_manual, p.name as part_name, po.id as po_id, po.po_number, COALESCE(pop.sequence_order, 999) as sequence_order, pop.quantity as required_qty
                       FROM purchase_order_products pop
                       JOIN products p ON pop.product_id = p.id
                       JOIN purchase_orders po ON pop.purchase_order_id = po.id
                       WHERE po.status IN ('pending', 'processing')
                       ORDER BY COALESCE(pop.sequence_order, 999), po.created_at DESC, p.name");
$allParts = $poStmt->fetchAll();

// Only include parts that have some knockout done and are not fully shot blasted
$availableParts = array_filter($allParts, function($part) use ($pdo) {
    $part_id = $part['part_id'];
    $po_id = $part['po_id'];
    // Check if ANY knockout has been done
    $stmt_knockout = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?");
    $stmt_knockout->execute([$po_id, $part_id]);
    $knockout_qty = (float)($stmt_knockout->fetchColumn() ?: 0);
    if ($knockout_qty < 0.001) return false; // No knockout done
    // Check if fully shot blasted
    $stmt_req = $pdo->prepare("SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?");
    $stmt_req->execute([$po_id, $part_id]);
    $required_qty = (float)($stmt_req->fetchColumn() ?: 0);
    $stmt_shot = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM shot_blasting_batches WHERE po_id = ? AND product_id = ?");
    $stmt_shot->execute([$po_id, $part_id]);
    $shot_qty = (float)($stmt_shot->fetchColumn() ?: 0);
    // Only show if remaining > 0
    if (($knockout_qty - $shot_qty) <= 0.001) return false;
    return true;
});

// Get the logged-in user's ID and name
$loggedInUserId = $_SESSION['user_id'];
$userNameStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$userNameStmt->execute([$loggedInUserId]);
$loggedInUserName = $userNameStmt->fetchColumn();

// Get all machines for dropdown (assuming a 'machines' table exists with 'id' and 'name')
$machineStmt = $pdo->query("SELECT id, name FROM machines ORDER BY name");
$machines = $machineStmt->fetchAll();

// Get all batches for display
$stmt = $pdo->query("SELECT sbb.*, u.name as operator_name, m.name as machine_name, po.po_number, p.name as part_name 
    FROM shot_blasting_batches sbb 
    LEFT JOIN users u ON sbb.operator_id = u.id
    LEFT JOIN machines m ON sbb.machine_id = m.id
    LEFT JOIN purchase_orders po ON sbb.po_id = po.id
    LEFT JOIN products p ON sbb.product_id = p.id
    ORDER BY sbb.date DESC, sbb.id DESC");
$batches = $stmt->fetchAll();

// Get rejection history for each PO
$rejectionHistoryStmt = $pdo->query("SELECT 
    r.*, 
    u.name as inspector_name,
    po.po_number,
    p.name as part_name,
    CASE 
        WHEN r.process_stage = 'melting' THEN 'Melting'
        WHEN r.process_stage = 'moulding' THEN 'Moulding'
        WHEN r.process_stage = 'knockout' THEN 'Knockout'
        WHEN r.process_stage = 'shot_blasting' THEN 'Shot Blasting'
        WHEN r.process_stage = 'fettling' THEN 'Fettling'
        WHEN r.process_stage = 'pouring' THEN 'Pouring'
        ELSE r.process_stage
    END as process_name
FROM rejections r
LEFT JOIN users u ON r.inspector_id = u.id
LEFT JOIN purchase_orders po ON r.po_id = po.id
LEFT JOIN products p ON r.product_id = p.id
ORDER BY r.created_at DESC");
$rejectionHistory = $rejectionHistoryStmt->fetchAll();

?>

<div class="container mt-4">
    <h2 class="p-3">Shot Blasting Operations</h2>
    
    <?php if (!empty($form_error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($form_error) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Operation added successfully!</div>
    <?php endif; ?>
    
    <form method="POST" action="shot_blasting.php" class="row g-3 mb-4" id="shotBlastingForm" style="background-color: #d1e0e0;">        
        <div class="row">
            <div class="col-md-3">
                <label for="part_id" class="form-label">Part</label>
                <select name="part_id[0]" id="part_id" class="form-select" required>
                    <option value="">Select Part</option>
                    <?php foreach ($availableParts as $part): ?>
                    <option value="<?= $part['part_id'] ?>" data-po-id="<?= $part['po_id'] ?>" data-required="<?= $part['required_qty'] ?>">#<?= $part['sequence_order'] ?> - Part ID: <?= htmlspecialchars($part['part_id_manual']) ?> - <?= htmlspecialchars($part['part_name']) ?> (PO: <?= htmlspecialchars($part['po_number']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="po_id" id="po_id">
            </div>
            <div class="col-md-2">
                <label for="date" class="form-label">Date</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-2">
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
        
        <!-- New section for Rejection Details -->
        <div class="col-12 mt-4 pt-3" style="background-color: #c1d1d1;">
            <h4 class="mb-3">Rejection Details</h4>
            <div id="rejectionSection" style="display: none;">
                <div id="rejectionRows"></div>
                <button type="button" class="btn btn-success btn-sm mt-2" id="addRejectionBtn"><i class="fas fa-plus-circle"></i> Add Rejection</button>
        </div>
        </div>
 
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-info">Add Batch</button>
        </div>
    </form>
    
    <div class="table-responsive">
    <?php
    // Group batches by PO and Part Name for rowspan rendering
    $grouped_batches = [];
    foreach ($batches as $batch) {
        $po = $batch['po_number'] ?? 'N/A';
        $part = $batch['part_name'] ?? 'N/A';
        $grouped_batches[$po][$part][] = $batch;
    }
    if (count($grouped_batches) > 0):
    ?>
    <div class="accordion" id="shotBlastingHistoryAccordion">
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
                 aria-labelledby="heading<?= $poIndex ?>" data-bs-parent="#shotBlastingHistoryAccordion">
                <div class="accordion-body">
                    <table class="table table-bordered table-striped table-nowrap mb-0">
        <thead>
            <tr style="background-color: #d1e0e0;">
                <th>PO #</th>
                <th>Part Name</th>
                <th>Heat Code</th>
                <th>Date</th>
                <th>Shift</th>
                <th>Operator</th>
                <th>Pieces Processed</th>
                <th>Media Type</th>
                <th>Duration (minutes)</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
        <?php
                        $po_rowspan = 0;
                        foreach ($parts as $rows) { $po_rowspan += count($rows); }
                $po_printed = false;
                        foreach ($parts as $part_name => $rows) {
                    // Group rows by consecutive heat_code for this part
                    $heat_code_groups = [];
                    $last_heat_code = null;
                    foreach ($rows as $row) {
                        $current_heat_code = isset($row['heat_code']) && $row['heat_code'] !== null && $row['heat_code'] !== '' ? $row['heat_code'] : '-';
                        if ($last_heat_code === null || $current_heat_code !== $last_heat_code) {
                            $heat_code_groups[] = [ 'heat_code' => $current_heat_code, 'rows' => [] ];
                        }
                        $heat_code_groups[count($heat_code_groups)-1]['rows'][] = $row;
                        $last_heat_code = $current_heat_code;
                    }
                    $part_rowspan = count($rows);
                    $part_printed = false;
                    foreach ($heat_code_groups as $group) {
                        $heat_code = $group['heat_code'];
                        $group_rows = $group['rows'];
                        $heat_code_rowspan = count($group_rows);
                        $heat_code_printed = false;
                        foreach ($group_rows as $row) {
                            // Fetch total knocked out for this PO/part
                            $stmt_knockout = $pdo->prepare('SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?');
                            $stmt_knockout->execute([$row['po_id'], $row['product_id']]);
                            $knocked_out = (float)($stmt_knockout->fetchColumn() ?: 0);
?>
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
                                <td rowspan="<?= $heat_code_rowspan ?>" style="vertical-align: middle; background: #f8fafb; border-bottom: 2px solid #b0bfc6;">
                                    <?= htmlspecialchars($heat_code) ?>
                                </td>
                                <?php $heat_code_printed = true; ?>
                            <?php endif; ?>
                            <td><?= $row['date'] ?></td>
                            <td><?= ucfirst($row['shift']) ?></td>
                            <td><?= htmlspecialchars($row['operator_name']) ?></td>
                            <?php
                            // Fetch total required for this PO/part
                            $required_qty = 0;
                            if (!empty($row['po_id']) && !empty($row['product_id'])) {
                                $stmt_req = $pdo->prepare('SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?');
                                $stmt_req->execute([$row['po_id'], $row['product_id']]);
                                $required_qty = (float)($stmt_req->fetchColumn() ?: 0);
                            }
                            ?>
                            <td><?= number_format((int)$row['pieces_processed']) ?> / <?= number_format((int)$required_qty) ?></td>
                            <td><?= htmlspecialchars($row['media_type'] ?? '-') ?></td>
                            <td><?= $row['duration_minutes'] ?? '-' ?></td>
                            <td><?= htmlspecialchars($row['notes'] ?? '-') ?></td>
                        </tr>
<?php } } } ?>
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
                <th>Heat Code</th>
                <th>Date</th>
                <th>Shift</th>
                <th>Operator</th>
                <th>Pieces Processed</th>
                <th>Media Type</th>
                <th>Duration (minutes)</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="10" class="text-center">No shot blasting batches found.</td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
    </div>
    
    <!-- Rejection History Section -->
    <div class="mt-5">
        <h3 class="mb-4">Rejection History (Shot Blasting Stage Only)</h3>
        <div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background-color: #d1e0e0;">
                                    <th>Purchase Order</th>
                        <th>Part Name</th>
                                    <th>Process Stage</th>
                                    <th>Quantity</th>
                                    <th>Reason</th>
                                    <th>Inspector</th>
                                    <th>Remarks</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                <?php
                // Group rejection history by PO and Part Name for rowspan rendering
                $rejGrouped = [];
                foreach ($rejectionHistory as $rejection) {
                    if ($rejection['process_stage'] !== 'shot_blasting') continue;
                    $po = $rejection['po_number'] ?? 'N/A';
                    $part = $rejection['part_name'] ?? 'N/A';
                    $rejGrouped[$po][$part][] = $rejection;
                }
                if (count($rejGrouped) > 0):
                    foreach ($rejGrouped as $po_number => $parts):
                        $po_rowspan = 0; foreach ($parts as $rows) { $po_rowspan += count($rows); }
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
                                    <td><?= $reasonCodes[$row['reason_code']] ?? htmlspecialchars($row['reason_code']) ?></td>
                                    <td><?= htmlspecialchars($row['inspector_name']) ?></td>
                                    <td><?= htmlspecialchars($row['remarks'] ?? '-') ?></td>
                                    <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No rejections found for the shot blasting stage.</td>
                    </tr>
                <?php endif; ?>
                            </tbody>
                        </table>
        </div>
    </div>
    
    <!-- Efficiency Charts -->
    <!-- <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Shot Blasting Efficiency</h5>
                </div>
                <div class="card-body">
                    <canvas id="shotBlastingEfficiencyChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Rejection Rate by Shift</h5>
                </div>
                <div class="card-body">
                    <canvas id="rejectionRateChart"></canvas>
                </div>
            </div>
        </div>
    </div> -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const partSelect = document.getElementById('part_id');
    const partsRowsContainer = document.createElement('div');
    partsRowsContainer.className = 'row';
    partsRowsContainer.id = 'partsRowsContainer';
    // Insert after the operator row
    const operatorRow = document.querySelector('#operator_id').closest('.row');
    operatorRow.parentNode.insertBefore(partsRowsContainer, operatorRow.nextSibling);

    const rejectionSection = document.getElementById('rejectionSection');
    const rejectionRows = document.getElementById('rejectionRows');
    const addRejectionBtn = document.getElementById('addRejectionBtn');

    partSelect.addEventListener('change', function() {
        const selectedPart = this.value;
        const selectedPOId = this.options[this.selectedIndex].dataset.poId;
        document.getElementById('po_id').value = selectedPOId;
        const requiredQty = this.options[this.selectedIndex].dataset.required;
        partsRowsContainer.innerHTML = '';
        rejectionSection.style.display = 'none';
        rejectionRows.innerHTML = '';
        if (selectedPart) {
            // Create a container for the dynamic section
            const dynamicSection = document.createElement('div');
            dynamicSection.className = 'dynamic-section mb-4 p-3 border rounded';
            // Add Heat Code input
            const heatCodeRow = document.createElement('div');
            heatCodeRow.className = 'row mb-2';
            heatCodeRow.innerHTML = `
                <div class='col-md-3'>
                    <label class='form-label'>Heat Code</label>
                    <input type='text' class='form-control' name='heat_code[0]'>
                </div>
            `;
            dynamicSection.appendChild(heatCodeRow);
            // Add shot blasting rows
            const shotRowsContainer = document.createElement('div');
            shotRowsContainer.className = 'shot-rows';
            shotRowsContainer.style.display = '';
            dynamicSection.appendChild(shotRowsContainer);
            partsRowsContainer.appendChild(dynamicSection);
            // Add at least one shot row
            addShotRow(shotRowsContainer, 0, selectedPart, selectedPOId, requiredQty);
            // Show and populate rejection section for this part
            let rejectionOptions = `<option value='${selectedPart}'>${partSelect.options[this.selectedIndex].text}</option>`;
            addRejectionRow(rejectionOptions);
            rejectionSection.style.display = 'block';
        }
    });

    function addPartSection(partIdx, allParts) {
        const partSection = document.createElement('div');
        partSection.className = 'part-section mb-4 p-3 border rounded';
        const partRow = document.createElement('div');
        partRow.className = 'row';
        // Build the part dropdown
        let partOptions = '<option value="">Select Part</option>';
        allParts.forEach(part => {
            partOptions += `<option value='${part.id}'>${part.name}</option>`;
        });
        partRow.innerHTML = `
            <div class='col-md-3'>
                <label class='form-label'>Part Name</label>
                <select name='part_id[${partIdx}]' class='form-select part-select' required>${partOptions}</select>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Heat Code</label>
                <input type='text' class='form-control' name='heat_code[${partIdx}]'>
            </div>
            <div class='col-md-6 d-flex align-items-end justify-content-end'>
                <button type='button' class='btn btn-success btn-sm add-shot-row' title='Add Row' style='display:none;'><i class='fas fa-plus-circle'></i> Add Row</button>
            </div>
        `;
        partSection.appendChild(partRow);
        // Container for shot blasting rows
        const shotRowsContainer = document.createElement('div');
        shotRowsContainer.className = 'shot-rows';
        shotRowsContainer.style.display = 'none';
        partSection.appendChild(shotRowsContainer);
        partsRowsContainer.appendChild(partSection);
        // Add at least one shot row
        addShotRow(shotRowsContainer, partIdx);
        // Show/hide fields and Add Row button when part is selected
        const partSelect = partRow.querySelector('.part-select');
        const addRowBtn = partRow.querySelector('.add-shot-row');
        partSelect.addEventListener('change', function() {
            if (this.value) {
                shotRowsContainer.style.display = '';
                addRowBtn.style.display = '';
            } else {
                shotRowsContainer.style.display = 'none';
                addRowBtn.style.display = 'none';
            }
        });
        // Always attach the add row event
        addRowBtn.addEventListener('click', function() {
            addShotRow(shotRowsContainer, partIdx);
        });
    }

    function addShotRow(container, partIdx, selectedPartId, selectedPOId, requiredQty) {
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-end shot-row-item';
        row.innerHTML = `
            <div class='col-md-2'>
                <label class='form-label'>Pieces Processed</label>
                <div class='shot-qty-info form-text mb-1'></div>
                <input type='number' name='pieces_processed[${partIdx}][]' class='form-control' required>
                <div class='text-danger shot-qty-warning' style='display:none;'></div>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Media Type</label>
                <input type='text' name='media_type[${partIdx}][]' class='form-control'>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Duration (minutes)</label>
                <input type='number' name='duration_minutes[${partIdx}][]' class='form-control'>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Notes</label>
                <textarea name='notes[${partIdx}][]' class='form-control'></textarea>
            </div>
            <div class='col-md-1 d-flex align-items-end'>
                <button type='button' class='btn btn-orange btn-sm remove-shot-row' title='Remove Row'><i class='fas fa-times'></i></button>
            </div>
        `;
        container.appendChild(row);
        row.querySelector('.remove-shot-row').addEventListener('click', function() {
            if (container.querySelectorAll('.shot-row-item').length > 1) {
                row.remove();
            }
            updateShotRemoveButtons(container);
        });
        updateShotRemoveButtons(container);

        // Live info for Pieces Processed
        const qtyInput = row.querySelector('input[name^="pieces_processed"]');
        const infoDiv = row.querySelector('.shot-qty-info');
        const warningDiv = row.querySelector('.shot-qty-warning');
        let required = parseFloat(requiredQty) || 0;
        let completed = 0;
        let maxAvailable = 0;
        function updateInfo() {
            const inputVal = parseFloat(qtyInput.value) || 0;
            const remaining = maxAvailable - inputVal;
            infoDiv.innerHTML = `Knocked out: ${maxAvailable + completed}, Already shot blasted: ${completed}, Remaining: ${maxAvailable}`;
            if (inputVal > maxAvailable) {
                qtyInput.value = maxAvailable;
                warningDiv.textContent = `Cannot process more than ${maxAvailable} pieces!`;
                warningDiv.style.display = '';
            } else {
                warningDiv.style.display = 'none';
            }
        }
        function fetchShotBlastingQty() {
            completed = 0; // Reset completed for this part
            if (selectedPartId && selectedPOId) {
                fetch(`ajax_get_shot_blasting_qty.php?po_id=${selectedPOId}&product_id=${selectedPartId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // required = parseFloat(data.required) || 0; // Not used for max
                            completed = parseFloat(data.completed) || 0;
                            maxAvailable = Math.max(0, (parseFloat(data.knocked_out) || 0) - completed);
                        } else {
                            completed = 0;
                            maxAvailable = 0;
                        }
                        qtyInput.setAttribute('max', maxAvailable);
                        updateInfo();
                    });
            } else {
                infoDiv.innerHTML = '';
                warningDiv.style.display = 'none';
            }
        }
        qtyInput.addEventListener('input', updateInfo);
        fetchShotBlastingQty();
    }

    function updateShotRemoveButtons(container) {
        const rows = container.querySelectorAll('.shot-row-item');
        const buttons = container.querySelectorAll('.remove-shot-row');
        buttons.forEach(btn => {
            btn.style.display = rows.length === 1 ? 'none' : '';
        });
    }

    function addRejectionRow(rejectionOptions) {
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-end mb-2 rejection-row';
        row.innerHTML = `
            <div class="col-md-3">
                <select name="rejection_part_id[]" class="form-select" required>${rejectionOptions}</select>
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
        rejectionRows.appendChild(row);
        row.querySelector('.remove-rejection-row').onclick = function() {
            row.remove();
        };
    }
    if (addRejectionBtn) {
        addRejectionBtn.onclick = function() {
            // Only allow adding if a part is selected
            const selectedPart = partSelect.value;
            if (!selectedPart) return;
            let rejectionOptions = `<option value='${selectedPart}'>${partSelect.options[partSelect.selectedIndex].text}</option>`;
            addRejectionRow(rejectionOptions);
        };
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>