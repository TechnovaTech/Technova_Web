<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Fetch all purchase orders with all parts and customer details
$sql = "SELECT po.id as po_id, po.po_number, po.created_at, po.status, c.name as customer_name, p.id as product_id, p.product_id_manual as part_id_manual, p.name as part_name, pop.quantity as part_quantity, COALESCE(pop.sequence_order, 0) as sequence_order
        FROM purchase_orders po
        JOIN customers c ON po.customer_id = c.id
        JOIN purchase_order_products pop ON pop.purchase_order_id = po.id
        JOIN products p ON pop.product_id = p.id
        WHERE po.status != 'completed'
        ORDER BY COALESCE(pop.sequence_order, 999), po.created_at DESC, po.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all process materials for all PO/parts
$processMaterialsStmt = $pdo->query("SELECT purchase_order_id, product_id, process_name FROM process_materials");
$processMaterials = $processMaterialsStmt->fetchAll(PDO::FETCH_ASSOC);
$processMaterialsMap = [];
foreach ($processMaterials as $pm) {
    $processMaterialsMap[$pm['purchase_order_id']][$pm['product_id']][$pm['process_name']] = true;
}
$requiredProcesses = ['Melting', 'Moulding', 'Pouring'];
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Production Plan</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sequenceModal">
            <i class="fas fa-list-ol"></i> Plan
        </button>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Purchase Order Parts</h5>
            <div class="input-group" style="max-width: 300px;">
                <input type="text" class="form-control" id="planSearchInput" placeholder="Search orders...">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Part ID</th>
                            <th>Part Name</th>
                            <th>PO Number</th>
                            <th>Customer</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($rows) > 0): ?>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['part_id_manual'] ?: $row['product_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['part_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['po_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                    <td><?php echo (int)$row['part_quantity']; ?></td>
                                    <td>
                                        <?php
                                        $allSet = true;
                                        foreach ($requiredProcesses as $proc) {
                                            if (empty($processMaterialsMap[$row['po_id']][$row['product_id']][$proc])) {
                                                $allSet = false;
                                                break;
                                            }
                                        }
                                        if ($allSet) {
                                            $badge_class = 'success';
                                            $status_text = 'Ready';
                                        } else {
                                            switch ($row['status']) {
                                                case 'completed': $badge_class = 'success'; $status_text = 'Completed'; break;
                                                case 'processing': $badge_class = 'primary'; $status_text = 'Processing'; break;
                                                case 'pending': $badge_class = 'warning'; $status_text = 'Pending'; break;
                                                default: $badge_class = 'secondary'; $status_text = ucfirst($row['status']);
                                            }
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $badge_class; ?>">
                                            <?php echo $status_text; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="purchase_order_details.php?id=<?php echo $row['po_id']; ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="purchase_order_plan.php?id=<?php echo $row['po_id']; ?>&product_id=<?php echo $row['product_id']; ?>" class="btn btn-warning btn-sm ms-1">
                                            <i class="fas fa-edit"></i> Edit Plan
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No purchase order parts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Sequence Modal -->
<div class="modal fade" id="sequenceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Production Sequence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="sequenceList">
                    <?php foreach ($rows as $index => $row): ?>
                    <div class="sequence-item card mb-2" data-po-id="<?php echo $row['po_id']; ?>" data-product-id="<?php echo $row['product_id']; ?>">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($row['part_id_manual'] ?: $row['product_id']); ?></strong> - 
                                    <?php echo htmlspecialchars($row['part_name']); ?>
                                    <small class="text-muted">(PO: <?php echo htmlspecialchars($row['po_number']); ?>)</small>
                                </div>
                                <div class="sequence-controls">
                                    <button type="button" class="btn btn-sm btn-outline-secondary move-up" title="Move Up">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary move-down" title="Move Down">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveSequence">Save Sequence</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('planSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            const table = document.querySelector('.table.table-striped.table-hover');
            if (!table) return;
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }

    // Sequence functionality
    const sequenceList = document.getElementById('sequenceList');
    
    // Move up/down functionality
    sequenceList.addEventListener('click', function(e) {
        if (e.target.closest('.move-up')) {
            const item = e.target.closest('.sequence-item');
            const prev = item.previousElementSibling;
            if (prev) {
                sequenceList.insertBefore(item, prev);
            }
        } else if (e.target.closest('.move-down')) {
            const item = e.target.closest('.sequence-item');
            const next = item.nextElementSibling;
            if (next) {
                sequenceList.insertBefore(next, item);
            }
        }
    });

    // Save sequence
    document.getElementById('saveSequence').addEventListener('click', function() {
        const items = sequenceList.querySelectorAll('.sequence-item');
        const sequence = [];
        
        items.forEach((item, index) => {
            sequence.push({
                po_id: item.dataset.poId,
                product_id: item.dataset.productId,
                sequence: index + 1
            });
        });

        // Send to server
        fetch('save_sequence.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({sequence: sequence})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Sequence saved successfully!');
                location.reload();
            } else {
                alert('Error saving sequence: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving sequence');
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?> 