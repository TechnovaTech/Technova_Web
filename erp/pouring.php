<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

require_once 'includes/header.php';

// Database connection would be established in config.php

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

// Get the logged-in user's ID and name
$loggedInUserId = $_SESSION['user_id'];
$userNameStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$userNameStmt->execute([$loggedInUserId]);
$loggedInUserName = $userNameStmt->fetchColumn();

// Add product_id to pouring_batches if it doesn't exist
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM `pouring_batches` LIKE 'product_id'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE pouring_batches ADD COLUMN product_id INT(11) NULL AFTER po_id");
        try {
            $pdo->exec("ALTER TABLE pouring_batches ADD CONSTRAINT fk_pouring_batches_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL");
        } catch (PDOException $e) { /* ignore */ }
    }
} catch (PDOException $e) {
    error_log("Could not alter pouring_batches table: " . $e->getMessage());
}

// Helper function to check if a PO has any parts with remaining pouring required
function is_po_pourable($pdo, $po_id) {
    // Get all products for the PO
    $sql_parts = "SELECT product_id, quantity FROM purchase_order_products WHERE purchase_order_id = ?";
    $stmt_parts = $pdo->prepare($sql_parts);
    $stmt_parts->execute([$po_id]);
    $products = $stmt_parts->fetchAll(PDO::FETCH_ASSOC);

    if (empty($products)) return false;

    foreach ($products as $prod) {
        $product_id = $prod['product_id'];
        $product_qty = $prod['quantity'];
        // Get all materials for this part for pouring (from BOM and overrides)
        $sql_mats = "SELECT m.name, (COALESCE(o.per_unit, b.quantity_per_unit) * ?) AS total_required
            FROM bom_items b
            JOIN materials m ON b.material_id = m.id
            LEFT JOIN production_plan_bom_overrides o
                ON o.purchase_order_id = ? AND o.product_id = ? AND o.material_id = b.material_id
            WHERE b.product_id = ?
            UNION
            SELECT m.name, (o.per_unit * ?) AS total_required
            FROM production_plan_bom_overrides o
            JOIN materials m ON o.material_id = m.id
            LEFT JOIN bom_items b ON b.product_id = o.product_id AND b.material_id = o.material_id
            WHERE o.purchase_order_id = ? AND o.product_id = ? AND b.material_id IS NULL";
        $stmt_mats = $pdo->prepare($sql_mats);
        $stmt_mats->execute([
            $product_qty, $po_id, $product_id, $product_id,
            $product_qty, $po_id, $product_id
        ]);
        $materials = $stmt_mats->fetchAll(PDO::FETCH_ASSOC);
        foreach ($materials as $mat) {
            $material_name = $mat['name'];
            $total_required = (float)($mat['total_required'] ?? 0);
            // Calculate already poured quantity from pouring_batches
            $pouredStmt = $pdo->prepare("SELECT SUM(metal_used_kg) FROM pouring_batches WHERE po_id = ? AND product_id = ? AND TRIM(LOWER(metal_name)) = TRIM(LOWER(?))");
            $pouredStmt->execute([$po_id, $product_id, $material_name]);
            $already_poured = (float)($pouredStmt->fetchColumn() ?: 0);
            if (($total_required - $already_poured) > 0.001) {
                return true; // Found a material that is not fully poured, so this PO is pourable.
            }
        }
    }
    return false; // All parts and materials for this PO are fully poured.
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();
    try {
        $po_id = $_POST['po_id'];
        $part_id = $_POST['part_id'];
        $date = $_POST['date'];
        $shift = $_POST['shift'];
        $operator_id = $_POST['operator_id'];
        $heat_code = $_POST['heat_code'] ?? null;

        // --- BACKEND VALIDATION: Prevent over-pouring ---
        $stmt_moulded = $pdo->prepare("SELECT COALESCE(SUM(mould_quantity), 0) FROM moulding_batches WHERE po_id = ? AND product_id = ?");
        $stmt_moulded->execute([$po_id, $part_id]);
        $moulded_qty = (float)($stmt_moulded->fetchColumn() ?: 0);
        $stmt_poured = $pdo->prepare("SELECT COALESCE(SUM(quantity), 0) FROM pouring_batches WHERE po_id = ? AND product_id = ?");
        $stmt_poured->execute([$po_id, $part_id]);
        $already_poured_qty = (float)($stmt_poured->fetchColumn() ?: 0);
        $new_pouring_qty = 0;
        if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $q) {
                $new_pouring_qty += (float)$q;
            }
        }
        if (($already_poured_qty + $new_pouring_qty) > $moulded_qty + 0.001) {
            $pdo->rollBack();
            $form_error = 'Cannot pour more than the moulded quantity! (Moulded: ' . $moulded_qty . ', Already poured: ' . $already_poured_qty . ', Attempted: ' . $new_pouring_qty . ')';
        } else {
        $sql = "INSERT INTO pouring_batches (batch_number, po_id, product_id, quantity, date, shift, operator_id, metal_name, metal_used_kg, temp, f_temp, l_temp, heat_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
            if (isset($_POST['metal_name']) && is_array($_POST['metal_name'])) {
                foreach ($_POST['metal_name'] as $row_index => $metal_name) {
    $batchNumber = 'PB-' . date('Ymd') . '-' . rand(1000, 9999);
                    $quantity = $_POST['quantity'][$row_index] ?? null;
                    $metal_used_kg = $_POST['metal_used_kg'][$row_index] ?? 0;
                    $temp = !empty($_POST['temp'][$row_index]) ? $_POST['temp'][$row_index] : null;
                    $f_temp = !empty($_POST['f_temp'][$row_index]) ? $_POST['f_temp'][$row_index] : null;
                    $l_temp = !empty($_POST['l_temp'][$row_index]) ? $_POST['l_temp'][$row_index] : null;
    $stmt->execute([
                            $batchNumber,
                            $po_id,
                            $part_id,
                            $quantity,
                            $date,
                            $shift,
                            $operator_id,
                            $metal_name,
                            $metal_used_kg,
                            $temp,
                            $f_temp,
                            $l_temp,
                            $heat_code
                        ]);
            }
        }
        $pdo->commit();
    header('Location: pouring.php?success=1');
    exit;
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $form_error = 'An error occurred while adding the batch.';
        error_log("Error adding pouring batch: " . $e->getMessage() . "\n" . print_r($_POST, true));
    }
}

// Get all active purchase orders and parts for dropdown
$poStmt = $pdo->query("SELECT DISTINCT p.id as part_id, p.product_id_manual as part_id_manual, p.name as part_name, po.id as po_id, po.po_number, COALESCE(pop.sequence_order, 999) as sequence_order
                       FROM purchase_order_products pop
                       JOIN products p ON pop.product_id = p.id
                       JOIN purchase_orders po ON pop.purchase_order_id = po.id
    WHERE po.status IN ('pending', 'processing') 
                       ORDER BY COALESCE(pop.sequence_order, 999), po.created_at DESC, p.name");
$allParts = $poStmt->fetchAll();

// Only include parts that have some moulding done and are not fully poured
$availableParts = array_filter($allParts, function($part) use ($pdo) {
    $part_id = $part['part_id'];
    $po_id = $part['po_id'];
    // Check if ANY moulding has been done
    $stmt_moulded = $pdo->prepare("SELECT COALESCE(SUM(mould_quantity), 0) FROM moulding_batches WHERE po_id = ? AND product_id = ?");
    $stmt_moulded->execute([$po_id, $part_id]);
    $moulded_qty = (float)($stmt_moulded->fetchColumn() ?: 0);
    if ($moulded_qty < 0.001) return false; // No moulding done
    // Check if fully poured
    $stmt_req = $pdo->prepare("SELECT quantity FROM purchase_order_products WHERE purchase_order_id = ? AND product_id = ?");
    $stmt_req->execute([$po_id, $part_id]);
    $required_qty = (float)($stmt_req->fetchColumn() ?: 0);
    $stmt_poured = $pdo->prepare("SELECT COALESCE(SUM(quantity), 0) FROM pouring_batches WHERE po_id = ? AND product_id = ?");
    $stmt_poured->execute([$po_id, $part_id]);
    $poured_qty = (float)($stmt_poured->fetchColumn() ?: 0);
    // Only show if remaining > 0
    if (($moulded_qty - $poured_qty) <= 0.001) return false;
    return true;
});

// Get all batches for display
$stmt = $pdo->query("SELECT pb.*, u.name as operator_name, po.po_number, p.name as product_name
    FROM pouring_batches pb 
    LEFT JOIN users u ON pb.operator_id = u.id
    LEFT JOIN purchase_orders po ON pb.po_id = po.id
    LEFT JOIN products p ON pb.product_id = p.id
    ORDER BY pb.date DESC, po.po_number, p.name");
$batches = $stmt->fetchAll();

// Group batches by PO and Part Name for rowspan rendering
$grouped_batches = [];
foreach ($batches as $batch) {
    $po = $batch['po_number'] ?? 'N/A';
    $part = $batch['product_name'] ?? 'N/A';
    $grouped_batches[$po][$part][] = $batch;
}

?>

<div class="container mt-4">
    <h2 class="p-3">Pouring Batches</h2>
    
    <?php if (!empty($form_error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($form_error) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Batch added successfully!</div>
    <?php endif; ?>
    
    <form method="POST" action="pouring.php" class="g-3 mb-4" id="pouringForm" style="background-color: #d1e0e0; padding: 1rem;">        
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
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-info">Add Batch</button>
        </div>
    </form>
    
    <div class="table-responsive">
    <?php if (count($grouped_batches) > 0): ?>
    <div class="accordion" id="pouringHistoryAccordion">
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
                 aria-labelledby="heading<?= $poIndex ?>" data-bs-parent="#pouringHistoryAccordion">
                <div class="accordion-body">
                    <table class="table table-bordered table-striped table-nowrap mb-0">
        <thead>
            <tr style="background-color: #d1e0e0;">
                <th>PO #</th>
                    <th>Part Name</th>
                                <!--<th>Quantity</th>-->
                <th>Heat Code</th>
                <th>Date</th>
                <th>Shift</th>
                <th>Operator</th>
                    <th>Quantity</th>
                    <th>Metal Name</th>
                <th>Metal Used (kg)</th>
                    <th>Tapping temperature (°C)</th>
                    <th>First box temperature (°C)</th>
                    <th>Last box temperature (°C)</th>
            </tr>
        </thead>
        <tbody>
                        <?php $po_rowspan = 0; foreach ($parts as $rows) { $po_rowspan += count($rows); } ?>
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
                                    <!--<td rowspan="<?= $part_rowspan ?>" style="vertical-align: middle; background: #f8fafb;">
                                        <?= $row['quantity'] ?>
                                    </td>-->
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
                                <td><?= $row['quantity'] ?></td>
                                <td><?= htmlspecialchars($row['metal_name']) ?></td>
                                <td><?= $row['metal_used_kg'] ?></td>
                                <td><?= $row['temp'] ? $row['temp'] . ' °C' : '-' ?></td>
                                <td><?= $row['f_temp'] ? $row['f_temp'] . ' °C' : '-' ?></td>
                                <td><?= $row['l_temp'] ? $row['l_temp'] . ' °C' : '-' ?></td>
            </tr>
                            <?php } } ?>
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
                <!--<th>Quantity</th>-->
                <th>Heat Code</th>
                <th>Date</th>
                <th>Shift</th>
                <th>Operator</th>
                <th>Quantity</th>
                <th>Metal Name</th>
                <th>Metal Used (kg)</th>
                <th>Tapping temperature (°C)</th>
                <th>First box temperature (°C)</th>
                <th>Last box temperature (°C)</th>
            </tr>
        </thead>
        <tbody>
                    <tr><td colspan="12" class="text-center">No pouring batches found.</td></tr>
        </tbody>
    </table>
    <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const poSelect = document.getElementById('po_id');
    const partsRowsContainer = document.getElementById('partsRowsContainer');
    const partSelect = document.getElementById('part_id');

    partSelect.addEventListener('change', function() {
        const selectedPartId = this.value;
        const selectedPOId = this.options[this.selectedIndex].dataset.poId;
        poSelect.value = selectedPOId; // Update the hidden po_id field

        partsRowsContainer.innerHTML = '';
            if (selectedPartId) {
                // Fetch only materials set for Pouring in the plan for this part
            fetch('ajax_get_saved_process_materials.php?po_id=' + encodeURIComponent(selectedPOId) + '&product_id=' + encodeURIComponent(selectedPartId) + '&process_name=Pouring')
                    .then(res => res.json())
                    .then(data => {
                        let materialOptions = '<option value="">Select Material</option>';
                        if (data.success && Array.isArray(data.saved_materials) && data.saved_materials.length > 0) {
                            data.saved_materials.forEach(mat => {
                                materialOptions += `<option value='${mat.name}'>${mat.name} (${mat.type})</option>`;
                            });
                        } else {
                            materialOptions = '<option value="">No materials set for Pouring</option>';
                        }
                    
                    // Create the pouring section with heat code and add row button
                    partsRowsContainer.innerHTML = `
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Heat Code</label>
                                <input type="text" class="form-control" name="heat_code">
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex justify-content-end mb-2">
                                    <button type="button" class="btn btn-success btn-sm add-pouring-row" title="Add Pouring Row">
                                        <i class="fas fa-plus-circle"></i> Add Row
                                    </button>
                                </div>
                                <div class="pouring-rows"></div>
                            </div>
                        </div>
                    `;
                    
                    const pouringRowsContainer = partsRowsContainer.querySelector('.pouring-rows');
                    const addRowBtn = partsRowsContainer.querySelector('.add-pouring-row');
                    
                    // Fetch moulded and poured quantities for max logic
                    fetch('ajax_get_pouring_qty.php?po_id=' + encodeURIComponent(selectedPOId) + '&product_id=' + encodeURIComponent(selectedPartId))
                        .then(res => res.json())
                        .then(data => {
                            let moulded_qty = 0;
                            let poured_qty = 0;
                            let maxPourable = 0;
                            if (data.success) {
                                moulded_qty = parseFloat(data.moulded) || 0;
                                poured_qty = parseFloat(data.poured) || 0;
                                maxPourable = Math.max(0, moulded_qty - poured_qty);
                            }
                            // Add initial pouring row
                            addPouringRow(pouringRowsContainer, materialOptions, moulded_qty, poured_qty, maxPourable);
                            // Add row button functionality
                            addRowBtn.addEventListener('click', function() {
                                addPouringRow(pouringRowsContainer, materialOptions, moulded_qty, poured_qty, maxPourable);
                            });
                        });
                })
                .catch(() => {
                    partsRowsContainer.innerHTML = '<div class="col-12 text-danger">Failed to load material details.</div>';
                });
        } else {
            partsRowsContainer.innerHTML = '';
        }
    });

    function addPouringRow(container, materialOptions = '', moulded_qty = 0, poured_qty = 0, maxPourable = 0) {
        // First row: Quantity, Metal Name, Metal Used, Remove
        const row1 = document.createElement('div');
        row1.className = 'row mb-1 align-items-end pouring-row-item';
        row1.innerHTML = `
            <div class='col-md-3'>
                <label class='form-label'>Quantity</label>
                <div class='quantity-info-text form-text mb-1'></div>
                <input type='number' class='form-control quantity-info' name='quantity[]'>
                <div class='text-danger quantity-warning' style='display:none;'></div>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Metal Name</label>
                <select name='metal_name[]' class='form-select' required>${materialOptions}</select>
            </div>
            <div class='col-md-3'>
                <label class='form-label'>Metal Used (kg)</label>
                <input type='number' step='0.001' name='metal_used_kg[]' class='form-control' required>
            </div>
            <div class='col-md-3 d-flex align-items-end'>
                <button type='button' class='btn btn-orange btn-sm remove-pouring-row' title='Remove Row'><i class='fas fa-times'></i></button>
            </div>
        `;
        // Second row: Tapping, First box, Last box temperatures
        const row2 = document.createElement('div');
        row2.className = 'row mb-3 pouring-row-item';
        row2.innerHTML = `
            <div class='col-md-4'>
                <label class='form-label'>Tapping temperature (°C)</label>
                <input type='number' step='0.1' name='temp[]' class='form-control' placeholder='Tapping temperature'>
            </div>
            <div class='col-md-4'>
                <label class='form-label'>First box temperature (°C)</label>
                <input type='number' step='0.1' name='f_temp[]' class='form-control' placeholder='First box temperature'>
            </div>
            <div class='col-md-4'>
                <label class='form-label'>Last box temperature (°C)</label>
                <input type='number' step='0.1' name='l_temp[]' class='form-control' placeholder='Last box temperature'>
            </div>
        `;
        container.appendChild(row1);
        container.appendChild(row2);
        // Remove row logic
        row1.querySelector('.remove-pouring-row').addEventListener('click', function() {
            row1.remove();
            row2.remove();
            updateRemoveButtons(container);
        });
        updateRemoveButtons(container);
        // Live info for Quantity
        const qtyInput = row1.querySelector('.quantity-info');
        const infoDiv = row1.querySelector('.quantity-info-text');
        const warningDiv = row1.querySelector('.quantity-warning');
        qtyInput.setAttribute('max', maxPourable);
        function updateInfo() {
            const inputVal = parseFloat(qtyInput.value) || 0;
            const remaining = maxPourable - inputVal;
            infoDiv.innerHTML = `Moulded: ${moulded_qty}, Already poured: ${poured_qty}, Remaining: ${maxPourable}`;
            if (inputVal > maxPourable) {
                qtyInput.value = maxPourable;
                warningDiv.textContent = `Cannot pour more than ${maxPourable} pieces!`;
                warningDiv.style.display = '';
            } else {
                warningDiv.style.display = 'none';
            }
        }
        qtyInput.addEventListener('input', updateInfo);
        updateInfo();
    }

    function updateRemoveButtons(container) {
        const rowRemoveBtns = container.querySelectorAll('.remove-pouring-row');
        if (rowRemoveBtns.length === 1) {
            rowRemoveBtns[0].style.display = 'none';
        } else {
            rowRemoveBtns.forEach(btn => btn.style.display = '');
        }
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