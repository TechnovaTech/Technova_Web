<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

require_once 'includes/header.php';

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

// Helper function to check if a PO has any parts with remaining knockout required
function is_po_knockouttable($pdo, $po_id) {
    // Get all products for the PO
    $sql_parts = "SELECT product_id, quantity FROM purchase_order_products WHERE purchase_order_id = ?";
    $stmt_parts = $pdo->prepare($sql_parts);
    $stmt_parts->execute([$po_id]);
    $products = $stmt_parts->fetchAll(PDO::FETCH_ASSOC);
    if (empty($products)) return false;
    foreach ($products as $prod) {
        $product_id = $prod['product_id'];
        $product_qty = $prod['quantity'];
        // Get total processed in knockout_batches
        $stmt_knockout = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?");
        $stmt_knockout->execute([$po_id, $product_id]);
        $processed = (float)($stmt_knockout->fetchColumn() ?: 0);
        if (($product_qty - $processed) > 0.001) {
            return true; // This part still needs knockout
        }
    }
    return false; // All parts fully processed
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Log POST data
    file_put_contents('debug_knockout_post.txt', print_r($_POST, true));

    $po_id = $_POST['po_id'];
    $date = $_POST['date'];
    $shift = $_POST['shift'];
    $operator_id = $_POST['operator_id'];

    try {
        // Loop through each part
        if (isset($_POST['part_id']) && is_array($_POST['part_id'])) {
            foreach ($_POST['part_id'] as $partIdx => $partId) {
                // For each knockout row for this part
                if (isset($_POST['mould_name'][$partIdx]) && is_array($_POST['mould_name'][$partIdx])) {
                    $heatCode = isset($_POST['heat_code'][$partIdx]) ? $_POST['heat_code'][$partIdx] : null;
                    foreach ($_POST['mould_name'][$partIdx] as $rowIdx => $mouldName) {
                        $coolingTime = $_POST['cooling_time_minutes'][$partIdx][$rowIdx] ?? null;
                        $piecesProcessed = $_POST['pieces_processed'][$partIdx][$rowIdx] ?? null;
                        // Insert into knockout_batches
                        $batchNumber = 'KO-' . date('Ymd') . '-' . rand(1000, 9999);
                        $sql = "INSERT INTO knockout_batches (batch_number, po_id, product_id, date, shift, operator_id, mould_name, cooling_time_minutes, pieces_processed, heat_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
                            $batchNumber, $po_id, $partId, $date, $shift, $operator_id, $mouldName, $coolingTime, $piecesProcessed, $heatCode
                        ]);
                    }
                }
            }
        }

        // Process all rejection rows
        if (!empty($_POST['rejection_part_id']) && is_array($_POST['rejection_part_id'])) {
            foreach ($_POST['rejection_part_id'] as $idx => $rejPartId) {
                $rejQty = $_POST['rejection_quantity'][$idx] ?? 0;
                $rejReason = $_POST['rejection_reason'][$idx] ?? '';
                // Insert into rejections table (add more fields as needed)
                if ($rejQty > 0 && $rejPartId) {
                    $rejectionSql = "INSERT INTO rejections (po_id, product_id, process_stage, quantity, reason_code, inspector_id, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $rejectionStmt = $pdo->prepare($rejectionSql);
        $rejectionStmt->execute([
                        $po_id, $rejPartId, 'knockout', $rejQty, $rejReason, $operator_id, ''
                    ]);
                }
            }
        }
    } catch (Exception $e) {
        file_put_contents('debug_knockout_error.txt', $e->getMessage());
        die('Database error: ' . $e->getMessage());
    }

    // Redirect after processing
    header('Location: knockout.php?success=1'); 
    exit;
}

// Get all active purchase orders for dropdown
$poStmt = $pdo->query("SELECT po.id, po.po_number, po.product_id 
    FROM purchase_orders po
    JOIN pouring_batches pb ON po.id = pb.po_id
    WHERE po.status IN ('pending', 'processing') 
    ORDER BY po.created_at DESC");
$allPurchaseOrders = $poStmt->fetchAll();
// Filter POs to only include those with at least one part that still needs knockout
$purchaseOrders = array_filter($allPurchaseOrders, function($po) use ($pdo) {
    // Get all parts for this PO
    $stmt = $pdo->prepare("SELECT product_id, quantity FROM purchase_order_products WHERE purchase_order_id = ?");
    $stmt->execute([$po['id']]);
    $parts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($parts as $part) {
        $required_qty = (float)$part['quantity'];
        $stmt_proc = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?");
        $stmt_proc->execute([$po['id'], $part['product_id']]);
        $already_processed = (float)($stmt_proc->fetchColumn() ?: 0);
        if ($required_qty - $already_processed > 0.001) {
            return true;
        }
    }
    return false;
});

// Get all active parts for knockout dropdown (with sequence, manual id, and only those with some pouring done and not fully knocked out)
$poStmt = $pdo->query("SELECT DISTINCT p.id as part_id, p.product_id_manual as part_id_manual, p.name as part_name, po.id as po_id, po.po_number, COALESCE(pop.sequence_order, 999) as sequence_order, pop.quantity as required_qty
                       FROM purchase_order_products pop
                       JOIN products p ON pop.product_id = p.id
                       JOIN purchase_orders po ON pop.purchase_order_id = po.id
                       WHERE po.status IN ('pending', 'processing')
                       ORDER BY COALESCE(pop.sequence_order, 999), po.created_at DESC, p.name");
$allParts = $poStmt->fetchAll();

// Only include parts that have some pouring done and are not fully knocked out
$availableParts = array_filter($allParts, function($part) use ($pdo) {
    $part_id = $part['part_id'];
    $po_id = $part['po_id'];
    // Check if ANY pouring has been done
    $stmt_poured = $pdo->prepare("SELECT COALESCE(SUM(quantity), 0) FROM pouring_batches WHERE po_id = ? AND product_id = ?");
    $stmt_poured->execute([$po_id, $part_id]);
    $poured_qty = (float)($stmt_poured->fetchColumn() ?: 0);
    if ($poured_qty < 0.001) return false; // No pouring done
    // Check if fully knocked out
    $stmt_req = $pdo->prepare("SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?");
    $stmt_req->execute([$po_id, $part_id]);
    $required_qty = (float)($stmt_req->fetchColumn() ?: 0);
    $stmt_knockout = $pdo->prepare("SELECT COALESCE(SUM(pieces_processed), 0) FROM knockout_batches WHERE po_id = ? AND product_id = ?");
    $stmt_knockout->execute([$po_id, $part_id]);
    $knockout_qty = (float)($stmt_knockout->fetchColumn() ?: 0);
    // Only show if remaining > 0
    if (($poured_qty - $knockout_qty) <= 0.001) return false;
    return true;
});

// Get current logged-in user's id and name
$loggedInUserId = $_SESSION['user_id'];
$userNameStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$userNameStmt->execute([$loggedInUserId]);
$currentUserName = $userNameStmt->fetchColumn();

// Get all batches for display
$stmt = $pdo->query("SELECT kb.*, u.name as operator_name, po.po_number, p.name as part_name 
    FROM knockout_batches kb 
    LEFT JOIN users u ON kb.operator_id = u.id
    LEFT JOIN purchase_orders po ON kb.po_id = po.id
    LEFT JOIN products p ON kb.product_id = p.id
    ORDER BY kb.date DESC, kb.id DESC");
$batches = $stmt->fetchAll();

// Get moulding batches for dropdown
$mouldingBatchesStmt = $pdo->query("SELECT id, batch_number, mould_number FROM moulding_batches ORDER BY batch_number DESC");
$mouldingBatches = $mouldingBatchesStmt->fetchAll();

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
        ELSE r.process_stage
    END as process_name
FROM rejections r
LEFT JOIN users u ON r.inspector_id = u.id
LEFT JOIN purchase_orders po ON r.po_id = po.id
LEFT JOIN products p ON r.product_id = p.id
ORDER BY r.created_at DESC");
$rejectionHistory = $rejectionHistoryStmt->fetchAll();

// Fetch required quantity for each PO and part
$required_qty_map = [];
$stmt = $pdo->query("SELECT purchase_order_id, product_id, quantity FROM purchase_order_products");
foreach ($stmt->fetchAll() as $row) {
    $required_qty_map[$row['purchase_order_id']][$row['product_id']] = $row['quantity'];
}

// Group batches by PO and Part Name
$grouped = [];
foreach ($batches as $batch) {
    $grouped[$batch['po_number']][$batch['part_name']][] = $batch;
}

?>

<div class="container mt-4">
    <h2 class="p-3">Knockout Process</h2>
    
    <?php if (!empty($form_error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($form_error) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Batch added successfully!</div>
    <?php endif; ?>
    
    <form method="POST" action="knockout.php" class="row g-3 mb-4" id="knockoutForm" style="background-color: #d1e0e0;">        
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
                    <option value="<?= $loggedInUserId ?>" selected><?= htmlspecialchars($currentUserName) ?></option>
            </select>
        </div>
        </div>
        <div class="row" id="partsRowsContainer">
            <!-- Dynamic part rows will be inserted here -->
        </div>
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
    <?php if (count($grouped) > 0): ?>
    <div class="accordion" id="knockoutHistoryAccordion">
        <?php $poIndex = 0; foreach ($grouped as $po_number => $parts): ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?= $poIndex ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $poIndex ?>" aria-expanded="false"
                        aria-controls="collapse<?= $poIndex ?>">
                    PO: <?= htmlspecialchars($po_number) ?>
                </button>
            </h2>
            <div id="collapse<?= $poIndex ?>" class="accordion-collapse collapse"
                 aria-labelledby="heading<?= $poIndex ?>" data-bs-parent="#knockoutHistoryAccordion">
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
                <th>Mould Name</th>
                <th>Cooling Time</th>
                <th>Pieces Processed</th>
            </tr>
        </thead>
        <tbody>
        <?php
                        $po_rowspan = 0;
            foreach ($parts as $rowsForPart) {
                            $po_rowspan += count($rowsForPart);
            }
                        $po_printed = false;
            foreach ($parts as $partName => $rowsForPart) {
                // Group rows by consecutive heat_code for this part
                $heat_code_groups = [];
                $last_heat_code = null;
                foreach ($rowsForPart as $row) {
                    $current_heat_code = isset($row['heat_code']) && $row['heat_code'] !== null && $row['heat_code'] !== '' ? $row['heat_code'] : '-';
                    if ($last_heat_code === null || $current_heat_code !== $last_heat_code) {
                        $heat_code_groups[] = [ 'heat_code' => $current_heat_code, 'rows' => [] ];
                    }
                    $heat_code_groups[count($heat_code_groups)-1]['rows'][] = $row;
                    $last_heat_code = $current_heat_code;
                }
                            $part_rowspan = count($rowsForPart);
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
                                    <?= htmlspecialchars($partName) ?>
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
                            <td><?= htmlspecialchars($row['mould_name']) ?></td>
                            <td><?= htmlspecialchars($row['cooling_time_minutes']) ?> min</td>
                            <td><?= htmlspecialchars($row['pieces_processed']);
                                $product_id = $row['product_id'];
                                $po_id = $row['po_id'];
                                if (isset($required_qty_map[$po_id][$product_id])) {
                                    echo ' / ' . htmlspecialchars($required_qty_map[$po_id][$product_id]);
                    }
                            ?></td>
                        </tr>
                        <?php
                }
            }
        }
        ?>
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
                <th>Mould Name</th>
                <th>Cooling Time</th>
                <th>Pieces Processed</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="9" class="text-center">No knockout batches found.</td></tr>
        </tbody>
    </table>
    <?php endif; ?>
    </div>
    
    <!-- Rejection History Section -->
    <div class="mt-5">
        <h3 class="mb-4">Rejection History (Knockout Stage Only)</h3>
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
                // Group rejection history by PO and Part Name
                $rejGrouped = [];
                foreach ($rejectionHistory as $rejection) {
                    if ($rejection['process_stage'] !== 'knockout') continue;
                    $rejGrouped[$rejection['po_number']][$rejection['part_name']][] = $rejection;
                }
                foreach ($rejGrouped as $po => $parts) {
                    $poRowspan = 0;
                    foreach ($parts as $rowsForPart) {
                        $poRowspan += count($rowsForPart);
                    }
                    $firstPo = true;
                    foreach ($parts as $partName => $rowsForPart) {
                        $partRowspan = count($rowsForPart);
                        $firstPart = true;
                        foreach ($rowsForPart as $rejection) {
                            echo '<tr>';
                            if ($firstPo) {
                                echo '<td rowspan="'.$poRowspan.'">'.htmlspecialchars($po).'</td>';
                                $firstPo = false;
                            }
                            if ($firstPart) {
                                echo '<td rowspan="'.$partRowspan.'">'.htmlspecialchars($partName).'</td>';
                                $firstPart = false;
                            }
                            echo '<td>'.htmlspecialchars($rejection['process_name']).'</td>';
                            echo '<td>'.$rejection['quantity'].'</td>';
                            echo '<td>'.($reasonCodes[$rejection['reason_code']] ?? htmlspecialchars($rejection['reason_code'])).'</td>';
                            echo '<td>'.htmlspecialchars($rejection['inspector_name']).'</td>';
                            echo '<td>'.date('Y-m-d H:i', strtotime($rejection['created_at'])).'</td>';
                            echo '</tr>';
                        }
                    }
                }
                ?>
                            </tbody>
                        </table>
        </div>
    </div>
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
            // Add the knockout row section for the selected part
            addKnockoutSection(partsRowsContainer, selectedPartId, selectedPOId);
            // Show and populate rejection section for this part
            let rejectionOptions = `<option value='${selectedPartId}'>${partSelect.options[partSelect.selectedIndex].text}</option>`;
            addRejectionRow(rejectionOptions);
            rejectionSection.style.display = 'block';
        }
    });

    function addKnockoutSection(container, partId, poId) {
        const section = document.createElement('div');
        section.className = 'part-section mb-4 p-3 border rounded';
        // Heat code input
        const heatCodeRow = document.createElement('div');
        heatCodeRow.className = 'row';
        heatCodeRow.innerHTML = `
            <div class='col-md-3'>
                <label class='form-label'>Heat Code</label>
                <input type='text' class='form-control' name='heat_code[0]'>
            </div>
            <div class='col-md-9 d-flex align-items-end justify-content-end'>
                <button type='button' class='btn btn-success btn-sm add-knockout-row' title='Add Row'><i class='fas fa-plus-circle'></i> Add Row</button>
            </div>
        `;
        section.appendChild(heatCodeRow);
        // Container for knockout rows
        const knockoutRowsContainer = document.createElement('div');
        knockoutRowsContainer.className = 'knockout-rows';
        section.appendChild(knockoutRowsContainer);
        container.appendChild(section);
        // Add at least one knockout row
        addKnockoutRow(knockoutRowsContainer, 0);
        // Add row button logic
        heatCodeRow.querySelector('.add-knockout-row').addEventListener('click', function() {
            addKnockoutRow(knockoutRowsContainer, 0);
        });
    }

    function addKnockoutRow(container, partIdx) {
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-end knockout-row-item';
        row.innerHTML = `
            <div class='col-md-4'>
                <label class='form-label'>Mould Name</label>
                <input type='text' name='mould_name[${partIdx}][]' class='form-control' required>
            </div>
            <div class='col-md-4'>
                <label class='form-label'>Cooling Time (min)</label>
                <input type='number' name='cooling_time_minutes[${partIdx}][]' class='form-control' required>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Pieces Processed</label>
                <div class='quantity-info-text form-text mb-1'></div>
                <input type='number' name='pieces_processed[${partIdx}][]' class='form-control quantity-info' required>
                <div class='text-danger quantity-warning' style='display:none;'></div>
            </div>
            <div class='col-md-1 d-flex align-items-end'>
                <button type='button' class='btn btn-orange btn-sm remove-knockout-row' title='Remove Row'><i class='fas fa-times'></i></button>
            </div>
        `;
        container.appendChild(row);
        // Remove row logic
        row.querySelector('.remove-knockout-row').addEventListener('click', function() {
            if (container.querySelectorAll('.knockout-row-item').length > 1) {
                row.remove();
            }
            updateKnockoutRemoveButtons(container);
        });
        updateKnockoutRemoveButtons(container);
        // Quantity info logic
        const piecesInput = row.querySelector('input[name^="pieces_processed"]');
        const infoDiv = row.querySelector('.quantity-info-text');
        const warningDiv = row.querySelector('.quantity-warning');
        let alreadyProcessed = 0;
        // Fetch poured and already processed quantities for max attribute and info
        const selectedPO = document.getElementById('po_id').value;
        const selectedPartId = document.getElementById('part_id').value;
        fetch(`ajax_get_pouring_qty.php?po_id=${selectedPO}&product_id=${selectedPartId}`)
            .then(res => res.json())
            .then(data => {
                let poured_qty = 0;
                if (data.success) {
                    poured_qty = parseFloat(data.poured) || 0; // Use 'poured' for knockout
                }
                fetch(`ajax_get_knockout_processed.php?po_id=${selectedPO}&part_id=${selectedPartId}`)
                    .then(res2 => res2.json())
                    .then(data2 => {
                        alreadyProcessed = data2.success ? (parseFloat(data2.processed) || 0) : 0;
                        const maxAvailable = Math.max(0, poured_qty - alreadyProcessed);
                        piecesInput.setAttribute('max', maxAvailable);
                        function updateInfo() {
                            const inputVal = parseFloat(piecesInput.value) || 0;
                            const remaining = maxAvailable - inputVal;
                            infoDiv.innerHTML = `Poured: ${poured_qty}, Already knocked out: ${alreadyProcessed}, Remaining: ${maxAvailable}`;
                            if (inputVal > maxAvailable) {
                                piecesInput.value = maxAvailable;
                                warningDiv.textContent = `Cannot knock out more than ${maxAvailable} pieces!`;
                                warningDiv.style.display = '';
                            } else {
                                warningDiv.style.display = 'none';
                            }
                        }
                        piecesInput.addEventListener('input', updateInfo);
                        updateInfo();
                    });
            });
    }
    function updateKnockoutRemoveButtons(container) {
        const rows = container.querySelectorAll('.knockout-row-item');
        const buttons = container.querySelectorAll('.remove-knockout-row');
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
            const selectedPartId = partSelect.value;
            if (!selectedPartId) return;
            let rejectionOptions = `<option value='${selectedPartId}'>${partSelect.options[partSelect.selectedIndex].text}</option>`;
            addRejectionRow(rejectionOptions);
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