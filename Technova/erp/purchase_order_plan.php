<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: production_plan.php');
    exit;
}
$po_id = (int)$_GET['id'];
+$product_id_filter = isset($_GET['product_id']) ? (int)$_GET['product_id'] : null;

// Fetch purchase order details
$sql = "SELECT po.*, c.name as customer_name FROM purchase_orders po JOIN customers c ON po.customer_id = c.id WHERE po.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po_id]);
$po = $stmt->fetch();
if (!$po) {
    header('Location: production_plan.php');
    exit;
}

// Fetch all products in this purchase order
$sql = "SELECT pop.*, p.name as product_name, p.description as product_description FROM purchase_order_products pop JOIN products p ON pop.product_id = p.id WHERE pop.purchase_order_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po_id]);
$order_products = $stmt->fetchAll();
// If a product_id filter is set, filter the array to only that product
if ($product_id_filter) {
    $order_products = array_filter($order_products, function($prod) use ($product_id_filter) {
        return $prod['product_id'] == $product_id_filter;
    });
}

// Fetch production date for this PO
$production_date = null;
$sql = "SELECT production_date FROM production_plan_dates WHERE purchase_order_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$po_id]);
if ($row = $stmt->fetch()) {
    $production_date = $row['production_date'];
}

?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Purchase Order Plan</h2>
        <a href="production_plan.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Production Plan
        </a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Order Information</h5>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr><th>PO Number:</th><td><?php echo htmlspecialchars($po['po_number']); ?></td></tr>
                <tr><th>Customer:</th><td><?php echo htmlspecialchars($po['customer_name']); ?></td></tr>
                <tr><th>Status:</th><td><?php echo htmlspecialchars(ucfirst($po['status'])); ?></td></tr>
                <tr><th>Created At:</th><td><?php echo htmlspecialchars($po['created_at']); ?></td></tr>
                <tr>
                    <th>Production Date:</th>
                    <td>
                        <input type="date" id="productionDateInput" class="form-control form-control-sm d-inline-block" style="width:auto;max-width:180px;" value="<?php echo htmlspecialchars($production_date); ?>">
                        <button id="saveProductionDateBtn" class="btn btn-sm btn-primary ms-2">Save</button>
                        <span id="productionDateStatus" class="ms-2"></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Parts in this Order</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($order_products)): ?>
                <?php foreach ($order_products as $prod): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($prod['product_name']); ?></h5>
                            <small class="text-muted"><?php echo htmlspecialchars($prod['product_description']); ?></small>
                        </div>
                        <div class="card-body">
                            <p><strong>Quantity:</strong> <?= (int)$prod['quantity'] ?></p>
                            <?php
                            // Fetch BOM for this product, with override if present
                            $sql = "
                                SELECT m.id as material_id, m.name, m.unit, m.type as material_type, b.quantity_per_unit, o.per_unit as override_per_unit
                                FROM bom_items b
                                JOIN materials m ON b.material_id = m.id
                                LEFT JOIN production_plan_bom_overrides o
                                    ON o.purchase_order_id = ? AND o.product_id = ? AND o.material_id = b.material_id
                                WHERE b.product_id = ?
                                UNION
                                SELECT m.id as material_id, m.name, m.unit, m.type as material_type, NULL as quantity_per_unit, o.per_unit as override_per_unit
                                FROM production_plan_bom_overrides o
                                JOIN materials m ON o.material_id = m.id
                                LEFT JOIN bom_items b ON b.product_id = o.product_id AND b.material_id = o.material_id
                                WHERE o.purchase_order_id = ? AND o.product_id = ? AND b.material_id IS NULL
                            ";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$po_id, $prod['product_id'], $prod['product_id'], $po_id, $prod['product_id']]);
                            $bom = $stmt->fetchAll();
                            ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Material Type</th>
                                            <th>Total Required</th>
                                            <th>Per Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($bom): ?>
                                            <?php foreach ($bom as $item): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['material_type']); ?></td>
                                                    <?php $per_unit = isset($item['override_per_unit']) && $item['override_per_unit'] !== null ? $item['override_per_unit'] : $item['quantity_per_unit']; ?>
                                                    <td><?php echo number_format($per_unit * $prod['quantity'], 3) . ' ' . htmlspecialchars($item['unit']); ?></td>
                                                    <td><?php echo number_format($per_unit, 3) . ' ' . htmlspecialchars($item['unit']); ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary me-1 edit-bom-btn" title="Edit"
                                                            data-material-id="<?php echo $item['material_id']; ?>"
                                                            data-product-id="<?php echo $prod['product_id']; ?>"
                                                            data-purchase-order-id="<?php echo $po_id; ?>"
                                                            data-material-name="<?php echo htmlspecialchars($item['name']); ?>"
                                                            data-per-unit="<?php echo number_format($per_unit, 3); ?>"
                                                            data-unit="<?php echo htmlspecialchars($item['unit']); ?>"
                                                        ><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="4" class="text-muted">No BOM defined</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Add New Material Button -->
                            <div class="mt-2 text-end">
                                <button class="btn btn-success btn-sm add-bom-btn" 
                                    data-product-id="<?php echo $prod['product_id']; ?>"
                                    data-product-quantity="<?php echo htmlspecialchars($prod['quantity']); ?>"
                                    data-purchase-order-id="<?php echo $po_id; ?>">
                                    <i class="fas fa-plus me-1"></i> Add New Material
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info mb-0">No products found in this order.</div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    // Fetch all process materials for this entire PO
    $sql_all_mats = "
        SELECT
            p.name as product_name,
            pm.product_id,
            pm.process_name,
            m.name as material_name,
            m.type as material_type
        FROM process_materials pm
        JOIN materials m ON pm.material_id = m.id
        JOIN products p ON pm.product_id = p.id
        WHERE pm.purchase_order_id = ?
        ORDER BY p.name, pm.process_name, m.name
    ";
    $stmt_all_mats = $pdo->prepare($sql_all_mats);
    $stmt_all_mats->execute([$po_id]);
    $all_process_materials = $stmt_all_mats->fetchAll();

    // Only show consolidated materials for the selected part if product_id_filter is set
    if ($product_id_filter) {
        $all_process_materials = array_filter($all_process_materials, function($row) use ($product_id_filter) {
            return $row['product_id'] == $product_id_filter;
        });
    }

    $consolidated_materials = [];
    if ($all_process_materials) {
        foreach ($all_process_materials as $row) {
            $consolidated_materials[$row['product_name']][$row['process_name']][] = [
                'name' => $row['material_name'],
                'type' => $row['material_type']
            ];
        }
    }
    ?>
    <?php if (!empty($consolidated_materials)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Consolidated Process Materials</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Part Name</th>
                            <th>Process</th>
                            <th>Materials Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consolidated_materials as $product_name => $processes): ?>
                            <?php foreach ($processes as $process_name => $materials): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product_name); ?></td>
                                    <td><strong><?php echo htmlspecialchars($process_name); ?></strong></td>
                                    <td>
                                        <?php
                                        echo implode(', ', array_map(function($mat) {
                                            $display = htmlspecialchars($mat['name']);
                                            if (!empty($mat['type'])) {
                                                $display .= ' (' . htmlspecialchars($mat['type']) . ')';
                                            }
                                            return $display;
                                        }, $materials));
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Edit BOM Material Modal -->
<div class="modal fade" id="editBomMaterialModal" tabindex="-1" aria-labelledby="editBomMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBomMaterialModalLabel">Edit BOM Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBomMaterialForm">
                    <div class="mb-3">
                        <label class="form-label">Material</label>
                        <input type="text" class="form-control" id="editMaterialName" name="material_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Quantity</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="editTotalQuantity" name="total_quantity" step="0.001" min="0" required>
                            <span class="input-group-text" id="editMaterialUnit"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add BOM Material Modal -->
<div class="modal fade" id="addBomMaterialModal" tabindex="-1" aria-labelledby="addBomMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBomMaterialModalLabel">Add Material to BOM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBomMaterialForm">
                    <input type="hidden" id="addProductId" name="product_id">
                    <input type="hidden" id="addPurchaseOrderId" name="purchase_order_id">
                    <input type="hidden" id="addProductQuantity" name="product_quantity">
                    <div class="mb-3">
                        <label for="addMaterialId" class="form-label">Material</label>
                        <select class="form-select" id="addMaterialId" name="material_id" required>
                            <option value="">Select Material</option>
                            <?php
                            require_once 'includes/db_functions.php';
                            $all_materials = getAllMaterials($pdo);
                            foreach ($all_materials as $mat): ?>
                                <option value="<?php echo $mat['id']; ?>" data-unit="<?php echo htmlspecialchars($mat['unit']); ?>" data-type="<?php echo htmlspecialchars($mat['type']); ?>">
                                    <?php echo htmlspecialchars($mat['name']); ?> (<?php echo htmlspecialchars($mat['type']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addTotalQuantity" class="form-label">Total Quantity</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="addTotalQuantity" name="total_quantity" step="0.001" min="0" required>
                            <span class="input-group-text" id="addMaterialUnit"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="plan-alert-container" style="position:fixed;top:20px;right:20px;z-index:9999;width:350px;max-width:90%;display:none;"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit BOM Material Modal
    const editButtons = document.querySelectorAll('.edit-bom-btn');
    editButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('editMaterialName').value = btn.getAttribute('data-material-name');
            // Calculate and set total quantity
            const perUnit = btn.getAttribute('data-per-unit');
            const productQuantity = btn.closest('.card-body').querySelector('p strong + text') ? btn.closest('.card-body').querySelector('p strong + text').textContent.trim() : btn.closest('.card-body').querySelector('p strong').nextSibling.textContent.trim();
            const totalQuantity = (Number(perUnit) * Number(productQuantity)).toFixed(3);
            document.getElementById('editTotalQuantity').value = totalQuantity;
            document.getElementById('editMaterialUnit').textContent = btn.getAttribute('data-unit');
            document.getElementById('editBomMaterialForm').setAttribute('data-material-id', btn.getAttribute('data-material-id'));
            document.getElementById('editBomMaterialForm').setAttribute('data-product-id', btn.getAttribute('data-product-id'));
            document.getElementById('editBomMaterialForm').setAttribute('data-purchase-order-id', btn.getAttribute('data-purchase-order-id'));
            document.getElementById('editBomMaterialForm').setAttribute('data-product-quantity', productQuantity);
            var modal = new bootstrap.Modal(document.getElementById('editBomMaterialModal'));
            modal.show();
        });
    });
    document.getElementById('editBomMaterialForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const totalQuantity = document.getElementById('editTotalQuantity').value;
        const materialId = form.getAttribute('data-material-id');
        const productId = form.getAttribute('data-product-id');
        const poId = form.getAttribute('data-purchase-order-id');
        const productQuantity = form.getAttribute('data-product-quantity');
        const perUnit = (Number(productQuantity) > 0) ? (Number(totalQuantity) / Number(productQuantity)) : 0;
        fetch('ajax_update_plan_bom.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `purchase_order_id=${encodeURIComponent(poId)}&product_id=${encodeURIComponent(productId)}&material_id=${encodeURIComponent(materialId)}&per_unit=${encodeURIComponent(perUnit)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update the table cell in the UI
                const btn = document.querySelector(`.edit-bom-btn[data-material-id='${materialId}'][data-product-id='${productId}']`);
                if (btn) {
                    const row = btn.closest('tr');
                    const unit = btn.getAttribute('data-unit');
                    row.querySelector('td:nth-child(4)').textContent = Number(perUnit).toFixed(3) + ' ' + unit;
                    // Use the product quantity from the card
                    let qty = Number(productQuantity);
                    if (isNaN(qty) || qty <= 0) {
                        // fallback: try to get from the UI
                        qty = 1;
                    }
                    row.querySelector('td:nth-child(3)').textContent = (Number(perUnit) * qty).toFixed(3) + ' ' + unit;
                    btn.setAttribute('data-per-unit', Number(perUnit).toFixed(3));
                }
                // Show notification
                showPlanAlert('Total quantity updated successfully!', 'success');
                bootstrap.Modal.getInstance(document.getElementById('editBomMaterialModal')).hide();
            } else {
                showPlanAlert('Failed to save.', 'danger');
            }
        });
    });
    // Add BOM Material Modal
    document.querySelectorAll('.add-bom-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('addProductId').value = btn.getAttribute('data-product-id');
            document.getElementById('addPurchaseOrderId').value = btn.getAttribute('data-purchase-order-id');
            document.getElementById('addProductQuantity').value = btn.getAttribute('data-product-quantity');
            document.getElementById('addMaterialId').value = '';
            document.getElementById('addTotalQuantity').value = '';
            document.getElementById('addMaterialUnit').textContent = '';
            var modal = new bootstrap.Modal(document.getElementById('addBomMaterialModal'));
            modal.show();
        });
    });
    document.getElementById('addMaterialId').addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        document.getElementById('addMaterialUnit').textContent = selected.getAttribute('data-unit') || '';
    });
    document.getElementById('addBomMaterialForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const productId = document.getElementById('addProductId').value;
        const poId = document.getElementById('addPurchaseOrderId').value;
        const materialId = document.getElementById('addMaterialId').value;
        const totalQuantity = document.getElementById('addTotalQuantity').value;
        const productQuantity = document.getElementById('addProductQuantity').value;
        const perUnit = (Number(productQuantity) > 0) ? (Number(totalQuantity) / Number(productQuantity)) : 0;
        const materialName = document.getElementById('addMaterialId').options[document.getElementById('addMaterialId').selectedIndex].text.split(' (')[0];
        const materialUnit = document.getElementById('addMaterialUnit').textContent;
        fetch('ajax_add_plan_bom.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `purchase_order_id=${encodeURIComponent(poId)}&product_id=${encodeURIComponent(productId)}&material_id=${encodeURIComponent(materialId)}&per_unit=${encodeURIComponent(perUnit)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Dynamically add the new material row to the correct product's BOM table
                const productCard = document.querySelector(`.add-bom-btn[data-product-id='${productId}']`).closest('.card');
                const tbody = productCard.querySelector('tbody');
                // Remove 'No BOM defined' row if present
                const noBomRow = tbody.querySelector('tr td.text-muted');
                if (noBomRow) noBomRow.parentElement.remove();
                // Create new row
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${materialName}</td>
                    <td>${document.getElementById('addMaterialId').options[document.getElementById('addMaterialId').selectedIndex].getAttribute('data-type') || ''}</td>
                    <td>${Number(totalQuantity).toFixed(3)} ${materialUnit}</td>
                    <td>${Number(perUnit).toFixed(3)} ${materialUnit}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-1 edit-bom-btn" title="Edit"
                            data-material-id="${materialId}"
                            data-product-id="${productId}"
                            data-purchase-order-id="${poId}"
                            data-material-name="${materialName}"
                            data-per-unit="${Number(perUnit).toFixed(3)}"
                            data-unit="${materialUnit}"
                        ><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
                // Re-attach edit event to the new button
                tr.querySelector('.edit-bom-btn').addEventListener('click', function() {
                    document.getElementById('editMaterialName').value = this.getAttribute('data-material-name');
                    document.getElementById('editTotalQuantity').value = this.getAttribute('data-per-unit');
                    document.getElementById('editMaterialUnit').textContent = this.getAttribute('data-unit');
                    document.getElementById('editBomMaterialForm').setAttribute('data-material-id', this.getAttribute('data-material-id'));
                    document.getElementById('editBomMaterialForm').setAttribute('data-product-id', this.getAttribute('data-product-id'));
                    document.getElementById('editBomMaterialForm').setAttribute('data-purchase-order-id', this.getAttribute('data-purchase-order-id'));
                    document.getElementById('editBomMaterialForm').setAttribute('data-product-quantity', this.getAttribute('data-product-quantity'));
                    var modal = new bootstrap.Modal(document.getElementById('editBomMaterialModal'));
                    modal.show();
                });
                // Show notification
                showPlanAlert('Material added successfully!', 'success');
                bootstrap.Modal.getInstance(document.getElementById('addBomMaterialModal')).hide();
            } else {
                showPlanAlert('Failed to add material.', 'danger');
            }
        });
    });
    // Handle delete BOM material
    document.querySelectorAll('.table .btn-danger').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to delete this material from the plan?')) return;
            const row = btn.closest('tr');
            const materialId = row.querySelector('.edit-bom-btn').getAttribute('data-material-id');
            const productId = row.querySelector('.edit-bom-btn').getAttribute('data-product-id');
            const poId = row.querySelector('.edit-bom-btn').getAttribute('data-purchase-order-id');
            fetch('ajax_delete_plan_bom.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `purchase_order_id=${encodeURIComponent(poId)}&product_id=${encodeURIComponent(productId)}&material_id=${encodeURIComponent(materialId)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                    showPlanAlert('Material deleted successfully!', 'success');
                    // If table is empty, show 'No BOM defined'
                    const tbody = row.parentElement;
                    if (tbody.children.length === 0) {
                        const tr = document.createElement('tr');
                        tr.innerHTML = '<td colspan="4" class="text-muted">No BOM defined</td>';
                        tbody.appendChild(tr);
                    }
                } else {
                    showPlanAlert('Failed to delete material.', 'danger');
                }
            });
        });
    });
    // Save Production Date
    document.getElementById('saveProductionDateBtn').addEventListener('click', function() {
        const date = document.getElementById('productionDateInput').value;
        if (!date) {
            document.getElementById('productionDateStatus').textContent = 'Please select a date.';
            document.getElementById('productionDateStatus').className = 'ms-2 text-danger';
            return;
        }
        fetch('ajax_save_production_date.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `purchase_order_id=<?php echo $po_id; ?>&production_date=${encodeURIComponent(date)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('productionDateStatus').textContent = 'Saved!';
                document.getElementById('productionDateStatus').className = 'ms-2 text-success';
            } else {
                document.getElementById('productionDateStatus').textContent = 'Failed to save.';
                document.getElementById('productionDateStatus').className = 'ms-2 text-danger';
            }
        });
    });
    function showPlanAlert(message, type) {
        const alertContainer = document.getElementById('plan-alert-container');
        alertContainer.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
        alertContainer.style.display = 'block';
        setTimeout(() => {
            alertContainer.style.display = 'none';
            alertContainer.innerHTML = '';
        }, 2500);
    }
    // Set Material for Process Form logic
    const selectPart = document.getElementById('selectPart');
    const selectProcess = document.getElementById('selectProcess');
    const materialsDiv = document.getElementById('materialsCheckboxes');

    function checkSavedMaterials() {
        const partId = selectPart.value;
        const processName = selectProcess.value;

        // Uncheck all boxes first
        materialsDiv.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

        if (partId && processName) {
            fetch(`ajax_get_saved_process_materials.php?po_id=<?php echo $po_id; ?>&product_id=${partId}&process_name=${processName}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.saved_materials.length > 0) {
                        const savedIds = data.saved_materials.map(m => String(m.material_id)); // Use material_id field
                        materialsDiv.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                            if (savedIds.includes(cb.value)) {
                                cb.checked = true;
                            }
                        });
                    }
                })
                .catch(err => console.error("Could not fetch saved materials:", err));
        }
    }

    selectPart.addEventListener('change', function() {
        const partId = this.value;
        materialsDiv.innerHTML = '';
        selectProcess.value = ''; // Reset process dropdown

        if (partId) {
            fetch('ajax_get_po_part_materials.php?po_id=<?php echo $po_id; ?>&product_id=' + encodeURIComponent(partId))
                .then(res => res.json())
                .then(data => {
                    if (data.success && Array.isArray(data.materials) && data.materials.length > 0) {
                        data.materials.forEach(function(mat) {
                            const wrapper = document.createElement('div');
                            wrapper.className = 'form-check';
                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.className = 'form-check-input';
                            checkbox.name = 'materials[]';
                            checkbox.value = mat.id;
                            checkbox.id = 'mat_' + mat.id;
                            const label = document.createElement('label');
                            label.className = 'form-check-label';
                            label.htmlFor = checkbox.id;
                            label.textContent = mat.name + (mat.type ? ' (' + mat.type + ')' : '');
                            wrapper.appendChild(checkbox);
                            wrapper.appendChild(label);
                            materialsDiv.appendChild(wrapper);
                        });
                        // If Melting is already selected, auto-select saved materials
                        if (selectProcess.value === 'Melting') {
                            checkSavedMaterials();
                        }
                    } else {
                        materialsDiv.innerHTML = '<span class="text-muted">No materials in BOM</span>';
                    }
                });
        }
    });

    selectProcess.addEventListener('change', checkSavedMaterials);

    // On page load, if both part and process are pre-selected, auto-select saved materials
    if (selectPart.value && selectProcess.value === 'Melting') {
        checkSavedMaterials();
    }

    // Optionally, handle form submit (currently just prevent default and show alert)
    document.getElementById('setMaterialProcessForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const partId = document.getElementById('selectPart').value;
        const process = document.getElementById('selectProcess').value;
        const materialCheckboxes = document.querySelectorAll('#materialsCheckboxes input[type="checkbox"]:checked');
        let selectedMaterials = [];
        materialCheckboxes.forEach(cb => {
            selectedMaterials.push(cb.value);
        });
        if (!partId || !process || selectedMaterials.length === 0) {
            showPlanAlert('Please select a part, a process, and at least one material.', 'warning');
            return;
        }
        const data = {
            purchase_order_id: <?php echo $po_id; ?>,
            part_id: partId,
            process: process,
            materials: selectedMaterials
        };
        fetch('ajax_set_process_materials.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(resData => {
            if (resData.success) {
                showPlanAlert(resData.message, 'success');
                // Optional: reload the page to see changes immediately
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showPlanAlert('Error: ' + resData.error, 'danger');
            }
        })
        .catch(err => {
            showPlanAlert('An unexpected error occurred.', 'danger');
            console.error(err);
        });
    });
});
</script>

<!-- Set Material for Process Form -->
<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Set Material for Process</h5>
        </div>
        <div class="card-body">
            <form id="setMaterialProcessForm">
                <div class="mb-3">
                    <label for="selectPart" class="form-label">Select Part</label>
                    <select class="form-select" id="selectPart" name="part_id" required>
                        <option value="">Select Part</option>
                        <?php foreach ($order_products as $prod): ?>
                            <option value="<?php echo $prod['product_id']; ?>">
                                <?php echo htmlspecialchars($prod['product_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="selectProcess" class="form-label">Select Process</label>
                    <select class="form-select" id="selectProcess" name="process" required>
                        <option value="">Select Process</option>
                        <option value="Melting">Melting</option>
                        <option value="Moulding">Moulding</option>
                        <option value="Pouring">Pouring</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="materialsCheckboxes" class="form-label">Select Materials</label>
                    <div id="materialsCheckboxes" style="min-height:48px; border:1px solidrgb(255, 255, 255); border-radius:0.375rem; padding:0.5rem; background-color:rgb(207, 204, 204); color:rgb(0, 0, 0);"></div>
                    <div class="form-text">Tick one or more materials to select.</div>
                </div>
                <button type="submit" class="btn btn-primary">Set Material for Process</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 