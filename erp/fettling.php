<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

require_once 'includes/header.php';

// Define process types
$processTypes = [
    'cutting' => 'Cutting',
    'grinding' => 'Grinding',
    'finishing' => 'Finishing'
];

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
    $po_id = $_POST['po_id'];
    $date = $_POST['date'];
    $shift = $_POST['shift'];
    $operator_id = $_POST['operator_id'];
    // Save all process rows for all parts
    if (isset($_POST['part_id']) && is_array($_POST['part_id'])) {
        foreach ($_POST['part_id'] as $partIdx => $partId) {
            $heatCode = isset($_POST['heat_code'][$partIdx]) ? $_POST['heat_code'][$partIdx] : null;
            if (isset($_POST['process_type'][$partIdx]) && is_array($_POST['process_type'][$partIdx])) {
                foreach ($_POST['process_type'][$partIdx] as $rowIdx => $processType) {
                    $inputQty = $_POST['input_quantity'][$partIdx][$rowIdx] ?? null;
                    $outputQty = $_POST['output_quantity'][$partIdx][$rowIdx] ?? null;
                    $timeTaken = $_POST['time_taken_hours'][$partIdx][$rowIdx] ?? null;
                    $status = $_POST['status'][$partIdx][$rowIdx] ?? null;
                    $notes = $_POST['notes'][$partIdx][$rowIdx] ?? '';
                    $sql = "INSERT INTO fettling (po_id, product_id, heat_code, date, shift, operator_id, process_type, input_quantity, output_quantity, time_taken_hours, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
                        $po_id, $partId, $heatCode, $date, $shift, $operator_id, $processType, $inputQty, $outputQty, $timeTaken, $status, $notes
                    ]);
                }
            }
        }
    }
    // Process all rejection rows
    if (isset($_POST['rejection_part_id']) && is_array($_POST['rejection_part_id'])) {
        $rejectionSql = "INSERT INTO rejections (po_id, product_id, process_stage, quantity, reason_code, inspector_id, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $rejectionStmt = $pdo->prepare($rejectionSql);
        foreach ($_POST['rejection_part_id'] as $idx => $rejection_part_id) {
            $rejection_quantity = $_POST['rejection_quantity'][$idx] ?? 0;
            $rejection_reason = $_POST['rejection_reason'][$idx] ?? 'N/A';
            $rejection_inspector = $operator_id; // Always use logged-in user
            if (!empty($rejection_part_id) && $rejection_quantity > 0) {
        $rejectionStmt->execute([
                    $po_id,
                    $rejection_part_id,
                    'fettling',
                    $rejection_quantity,
                    $rejection_reason,
                    $rejection_inspector,
                    ''
                ]);
            }
        }
    }
    // Redirect after processing the form
    header('Location: fettling.php?success=1'); 
    exit;
}

// Get all active parts for fettling dropdown (with sequence, manual id, and only those with some shot blasting done and not fully fettled)
$poStmt = $pdo->query("SELECT DISTINCT p.id as part_id, p.product_id_manual as part_id_manual, p.name as part_name, po.id as po_id, po.po_number, COALESCE(pop.sequence_order, 999) as sequence_order, pop.quantity as required_qty
                       FROM purchase_order_products pop
                       JOIN products p ON pop.product_id = p.id
                       JOIN purchase_orders po ON pop.purchase_order_id = po.id
                       WHERE po.status IN ('pending', 'processing')
                       ORDER BY COALESCE(pop.sequence_order, 999), po.created_at DESC, p.name");
$allParts = $poStmt->fetchAll();

// Only include parts that have some shot blasting done and are not fully fettled
$availableParts = array_filter($allParts, function($part) use ($pdo) {
    $part_id = $part['part_id'];
    $po_id = $part['po_id'];
    // Check if ANY shot blasting has been done
    $stmt_shot = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM shot_blasting_batches WHERE po_id = ? AND product_id = ?");
    $stmt_shot->execute([$po_id, $part_id]);
    $shot_qty = (float)($stmt_shot->fetchColumn() ?: 0);
    if ($shot_qty < 0.001) return false; // No shot blasting done
    // Check if fully fettled
    $stmt_req = $pdo->prepare("SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?");
    $stmt_req->execute([$po_id, $part_id]);
    $required_qty = (float)($stmt_req->fetchColumn() ?: 0);
    $stmt_fettled = $pdo->prepare("SELECT COALESCE(SUM(output_quantity), 0) FROM fettling WHERE po_id = ? AND product_id = ?");
    $stmt_fettled->execute([$po_id, $part_id]);
    $fettled_qty = (float)($stmt_fettled->fetchColumn() ?: 0);
    if (($shot_qty - $fettled_qty) <= 0.001) return false;
    return true;
});

// Get all operators/users for dropdown
$userStmt = $pdo->query("SELECT id, name FROM users ORDER BY name");
$operators = $userStmt->fetchAll();

// Get all fettling operations for display
$stmt = $pdo->query("SELECT f.*, po.po_number, u.name as operator_name, p.name as part_name
    FROM fettling f 
    LEFT JOIN purchase_orders po ON f.po_id = po.id
    LEFT JOIN users u ON f.operator_id = u.id
    LEFT JOIN products p ON f.product_id = p.id
    ORDER BY f.date DESC, f.id DESC");
$operations = $stmt->fetchAll();

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

// Get the logged-in user's ID and name
$loggedInUserId = $_SESSION['user_id'];
$userNameStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$userNameStmt->execute([$loggedInUserId]);
$loggedInUserName = $userNameStmt->fetchColumn();
?>

<div class="container mt-4">
    <h2 class="p-3">Fettling Operations</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Operation added successfully!</div>
    <?php endif; ?>
    
    <form method="POST" action="fettling.php" class="row g-3 mb-4" id="fettlingForm" style="background-color: #d1e0e0;">        
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
    
        
        <!-- New section for Rejection Details -->
    <div class="col-12 mt-4 pt-3" style="background-color: #c1d1d1;">
        <h4 class="mb-3">Rejection Details</h4>
        <div id="rejectionSection" style="display: none;">
            <div id="rejectionRows"></div>
            <button type="button" class="btn btn-success btn-sm mt-2" id="addRejectionBtn"><i class="fas fa-plus-circle"></i> Add Rejection</button>
        </div>
        </div>
      
          <div class="col-12 mt-3">
              <button type="submit" class="btn btn-info">Add Operation</button>
          </div>
    </form>
    
    <div>
    <?php
    // Group operations by PO and Part Name for accordion rendering
    $grouped_ops = [];
    foreach ($operations as $op) {
        $po = $op['po_number'] ?? 'N/A';
        $part = $op['part_name'] ?? 'N/A';
        $grouped_ops[$po][$part][] = $op;
    }
    ?>
    <?php if (count($grouped_ops) > 0): ?>
    <div class="accordion" id="fettlingHistoryAccordion">
        <?php $poIndex = 0; foreach ($grouped_ops as $po_number => $parts): ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?= $poIndex ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $poIndex ?>" aria-expanded="false"
                        aria-controls="collapse<?= $poIndex ?>">
                    PO: <?= htmlspecialchars($po_number) ?>
                </button>
            </h2>
            <div id="collapse<?= $poIndex ?>" class="accordion-collapse collapse"
                 aria-labelledby="heading<?= $poIndex ?>" data-bs-parent="#fettlingHistoryAccordion">
                <div class="accordion-body">
                    <table class="table table-bordered table-striped table-nowrap mb-0">
                        <thead>
                            <tr style="background-color:     #d1e0e0 ;">
                                <th>PO #</th>
                                <th>Part Name</th>
                                <th>Heat Code</th>
                                <th>Date</th>
                                <th>Shift</th>
                                <th>Operator</th>
                                <th>Process</th>
                                <th>Input</th>
                                <th>Output</th>
                                <th>Hours</th>
                                <th>Status</th>
                                <th>Notes</th>
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
                        <?php foreach ($parts as $part_name => $rows): ?>
                            <?php
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
                                    <td><?= htmlspecialchars(ucfirst($row['shift'] ?? '')) ?></td>
                                    <td><?= htmlspecialchars($row['operator_name']) ?></td>
                                    <td><?= $processTypes[$row['process_type']] ?? ucfirst($row['process_type']) ?></td>
                                    <td><?= $row['input_quantity'] ?></td>
                                    <td><?= number_format((int)$row['output_quantity']) ?> / <?php
    $required_qty = 0;
    if (!empty($row['po_id']) && !empty($row['product_id'])) {
        $stmt_req = $pdo->prepare('SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?');
        $stmt_req->execute([$row['po_id'], $row['product_id']]);
        $required_qty = (float)($stmt_req->fetchColumn() ?: 0);
    }
    echo number_format((int)$required_qty);
?></td>
                                    <td><?= $row['time_taken_hours'] ? $row['time_taken_hours'] . ' hrs' : '-' ?></td>
                                    <td>
                                        <?php if ($row['status'] === 'pass'): ?>
                                <span class="badge bg-success">Pass</span>
                                        <?php elseif ($row['status'] === 'fail'): ?>
                                <span class="badge bg-danger">Fail</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Rework</span>
                            <?php endif; ?>
                        </td>
                                    <td><?= htmlspecialchars($row['notes'] ?? '-') ?></td>
                                </tr>
                                <?php
                                }
                            }
                        endforeach; ?>
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
            <tr style="background-color:     #d1e0e0 ;">
                <th>PO #</th>
                <th>Part Name</th>
                <th>Heat Code</th>
                <th>Date</th>
                <th>Shift</th>
                <th>Operator</th>
                <th>Process</th>
                <th>Input</th>
                <th>Output</th>
                <th>Hours</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="12" class="text-center">No fettling operations found.</td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
    </div>
    
    <!-- Rejection History Section -->
    <div class="mt-5">
        <h3 class="mb-4">Rejection History (Fettling Stage Only)</h3>
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
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php
                    // Group rejection history by PO and Part Name for rowspan rendering
                    $rejGrouped = [];
                    foreach ($rejectionHistory as $rejection) {
                        if ($rejection['process_stage'] !== 'fettling') continue;
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
                                        <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No rejections found for the fettling stage.</td>
                        </tr>
                    <?php endif; ?>
                            </tbody>
                        </table>
        </div>
    </div>
    
    <!-- Performance Charts -->
    <!-- <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Fettling Productivity</h5>
                </div>
                <div class="card-body">
                    <canvas id="fettlingProductivityChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Process Type Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="processTypeChart"></canvas>
                </div>
            </div>
        </div>
    </div> -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const partSelect = document.getElementById('part_id');
    const partsRowsContainer = document.getElementById('partsRowsContainer');
    const rejectionSection = document.getElementById('rejectionSection');
    const rejectionRows = document.getElementById('rejectionRows');
    const addRejectionBtn = document.getElementById('addRejectionBtn');

    partSelect.addEventListener('change', function() {
        const selectedPartId = this.value;
        const selectedPOId = this.options[this.selectedIndex].getAttribute('data-po-id');
        document.getElementById('po_id').value = selectedPOId;
        partsRowsContainer.innerHTML = '';
        rejectionSection.style.display = 'none';
        rejectionRows.innerHTML = '';
        if (selectedPartId) {
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
            // Add process rows
            const processRowsContainer = document.createElement('div');
            processRowsContainer.className = 'process-rows';
            processRowsContainer.style.display = '';
            dynamicSection.appendChild(processRowsContainer);
            partsRowsContainer.appendChild(dynamicSection);
            // Add at least one process row
            addProcessRow(processRowsContainer, 0, selectedPartId, selectedPOId);
            // Show and populate rejection section for this part
            let rejectionOptions = `<option value='${selectedPartId}'>${partSelect.options[this.selectedIndex].text}</option>`;
            addRejectionRow(rejectionOptions);
            rejectionSection.style.display = 'block';
        }
    });

    function addProcessRow(container, partIdx, selectedPartId, selectedPOId) {
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-end process-row-item';
        row.innerHTML = `
            <div class='col-md-2'>
                <label class='form-label'>Process Type</label>
                <select name='process_type[${partIdx}][]' class='form-select' required>
                    <option value=''>Select Process</option>
                    <option value='cutting'>Cutting</option>
                    <option value='grinding'>Grinding</option>
                    <option value='finishing'>Finishing</option>
                </select>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Input Qty</label>
                <input type='number' name='input_quantity[${partIdx}][]' class='form-control' placeholder='Input' required>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Output Qty</label>
                <div class='output-qty-info form-text mb-1'></div>
                <input type='number' name='output_quantity[${partIdx}][]' class='form-control' placeholder='Output' required>
                <div class='text-danger output-qty-warning' style='display:none;'></div>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Hours</label>
                <input type='number' step='0.1' name='time_taken_hours[${partIdx}][]' class='form-control' placeholder='Hours'>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Status</label>
                <select name='status[${partIdx}][]' class='form-select' required>
                    <option value='pass'>Pass</option>
                    <option value='fail'>Fail</option>
                    <option value='rework'>Rework</option>
                </select>
            </div>
            <div class='col-md-2'>
                <label class='form-label'>Notes</label>
                <textarea name='notes[${partIdx}][]' class='form-control'></textarea>
            </div>
            <div class='col-md-2 d-flex align-items-end'>
                <button type='button' class='btn btn-danger remove-process-row' title='Remove Row'><i class='fas fa-times'></i></button>
            </div>
        `;
        container.appendChild(row);
        row.querySelector('.remove-process-row').addEventListener('click', function() {
            if (container.querySelectorAll('.process-row-item').length > 1) {
                row.remove();
                updateRemoveButtons(container);
            }
        });
        updateRemoveButtons(container);
        // Live info for Output Qty
        const qtyInput = row.querySelector('input[name^="output_quantity"]');
        const infoDiv = row.querySelector('.output-qty-info');
        const warningDiv = row.querySelector('.output-qty-warning');
        let shotBlasted = 0;
        let alreadyFettled = 0;
        let maxAvailable = 0;
        function updateInfo() {
            const inputVal = parseFloat(qtyInput.value) || 0;
            const remaining = maxAvailable - inputVal;
            infoDiv.innerHTML = `Shot blasted: ${shotBlasted}, Already fettled: ${alreadyFettled}, Remaining: ${maxAvailable}`;
            if (inputVal > maxAvailable) {
                qtyInput.value = maxAvailable;
                warningDiv.textContent = `Cannot process more than ${maxAvailable} pieces!`;
                warningDiv.style.display = '';
            } else {
                warningDiv.style.display = 'none';
            }
        }
        function fetchFettlingQty() {
            if (selectedPartId && selectedPOId) {
                fetch(`ajax_get_fettling_qty.php?po_id=${selectedPOId}&product_id=${selectedPartId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            shotBlasted = parseFloat(data.shot_blasted) || 0;
                            alreadyFettled = parseFloat(data.completed) || 0;
                            maxAvailable = Math.max(0, shotBlasted - alreadyFettled);
                        } else {
                            shotBlasted = 0;
                            alreadyFettled = 0;
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
        fetchFettlingQty();
    }

    function updateRemovePartButtons() {
        const partSections = partsRowsContainer.querySelectorAll('.part-section');
        const partRemoveBtns = partsRowsContainer.querySelectorAll('.remove-part-section');
        partRemoveBtns.forEach(btn => {
            btn.style.display = partSections.length === 1 ? 'none' : '';
        });
    }
                        function updateRemoveButtons(container) {
                            // Remove process row buttons
                            const rows = container.querySelectorAll('.process-row-item');
                            const buttons = container.querySelectorAll('.remove-process-row');
                            buttons.forEach(btn => {
                                btn.style.display = rows.length === 1 ? 'none' : '';
                            });
        updateRemovePartButtons();
                    }

    function addRejectionRow(rejectionOptions) {
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-end mb-2 rejection-row';
        row.innerHTML = `
            <div class="col-md-3">
                <select name="rejection_part_id[]" class="form-select" required>${rejectionOptions}</select>
            </div>
            <div class="col-md-2">
                <input type="number" name="rejection_quantity[]" class="form-control" placeholder="Qty" required>
            </div>
            <div class="col-md-5">
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
            const selectedPartId = partSelect.value;
            if (!selectedPartId) return;
            let rejectionOptions = `<option value='${selectedPartId}'>${partSelect.options[partSelect.selectedIndex].text}</option>`;
            addRejectionRow(rejectionOptions);
        };
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>