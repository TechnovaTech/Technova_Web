<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Check which tables exist
$tables = [
    'melting_batches' => false,
    'moulding_batches' => false,
    'pouring_batches' => false,
    'knockout_batches' => false,
    'shot_blasting' => false,
    'fettling' => false,
    'dispatch' => false,
    'dispatches' => false,
    'rejections' => false
];

try {
    foreach (array_keys($tables) as $tableName) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$tableName'");
        $tables[$tableName] = ($stmt->rowCount() > 0);
    }
} catch (Exception $e) {
    // Ignore errors
}

// Build the query parts based on which tables exist
$queryParts = [];
foreach ($tables as $tableName => $exists) {
    if ($exists) {
        if ($tableName === 'dispatch') {
            $queryParts[$tableName] = "(SELECT COUNT(*) FROM dispatch_items WHERE po_id = po.id AND product_id = pop.product_id)";
            $queryParts[$tableName.'_qty'] = "(SELECT COALESCE(SUM(dispatch_items.quantity), 0) FROM dispatch_items WHERE po_id = po.id AND product_id = pop.product_id)";
        } elseif ($tableName === 'dispatches') {
            $queryParts[$tableName] = "(SELECT COUNT(*) FROM dispatch_items WHERE po_id = po.id AND product_id = pop.product_id)";
            $queryParts[$tableName.'_qty'] = "(SELECT COALESCE(SUM(dispatch_items.quantity), 0) FROM dispatch_items WHERE po_id = po.id AND product_id = pop.product_id)";
        } elseif ($tableName === 'rejections') {
            $queryParts[$tableName] = "(SELECT COUNT(*) FROM rejections WHERE po_id = po.id AND product_id = pop.product_id)";
            $queryParts[$tableName.'_qty'] = "(SELECT COALESCE(SUM(rejections.quantity), 0) FROM rejections WHERE po_id = po.id AND product_id = pop.product_id)";
        } elseif ($tableName === 'moulding_batches') {
            $queryParts[$tableName] = "(SELECT COUNT(*) FROM moulding_batches WHERE po_id = po.id AND product_id = pop.product_id)";
            $queryParts[$tableName.'_qty'] = "(SELECT COALESCE(SUM(moulding_batches.mould_quantity), 0) FROM moulding_batches WHERE po_id = po.id AND product_id = pop.product_id)";
        } else {
            $queryParts[$tableName] = "(SELECT COUNT(*) FROM $tableName WHERE po_id = po.id AND product_id = pop.product_id)";
            $queryParts[$tableName.'_qty'] = "(SELECT COALESCE(SUM($tableName.quantity), 0) FROM $tableName WHERE po_id = po.id AND product_id = pop.product_id)";
        }
    } else {
        $queryParts[$tableName] = "0";
        $queryParts[$tableName.'_qty'] = "0";
    }
}

// Combine dispatch counts
$dispatchCountQuery = $queryParts['dispatch'];
$dispatchQtyQuery = $queryParts['dispatch_qty'];
if ($tables['dispatches']) {
    $dispatchCountQuery .= " + " . $queryParts['dispatches'];
    $dispatchQtyQuery .= " + " . $queryParts['dispatches_qty'];
}

// Get all purchase orders with all products per PO
$sql = "SELECT
            po.id, po.po_number, po.status,
            pop.product_id,
            pop.quantity AS product_quantity, po.unit,
            c.name as customer_name,
            p.name as product_name,

            -- Subquery for total required for melting
            (
                SELECT SUM(COALESCE(o.per_unit, b.quantity_per_unit, 0) * pop.quantity)
                FROM process_materials pm
                LEFT JOIN bom_items b ON pm.material_id = b.material_id AND b.product_id = pop.product_id
                LEFT JOIN production_plan_bom_overrides o ON pm.material_id = o.material_id AND o.product_id = pop.product_id AND o.purchase_order_id = po.id
                WHERE pm.purchase_order_id = po.id
                  AND pm.product_id = pop.product_id
                  AND pm.process_name = 'Melting'
            ) AS total_melting_required_kg,

            -- Subquery for total melted
            (
                SELECT COALESCE(SUM(mb.melted_metal_kg), 0)
                FROM melting_batches mb
                WHERE mb.po_id = po.id
                  AND mb.product_id = pop.product_id
            ) AS total_melted_kg,

            " . $queryParts['moulding_batches'] . " as moulding_count,
            " . $queryParts['moulding_batches_qty'] . " as moulding_qty,

               (SELECT COALESCE(SUM(dispatch_items.quantity), 0) FROM dispatch_items WHERE po_id = po.id AND product_id = pop.product_id) as dispatch_qty
        FROM purchase_orders po
        JOIN customers c ON po.customer_id = c.id
        JOIN purchase_order_products pop ON pop.purchase_order_id = po.id
        JOIN products p ON pop.product_id = p.id
        ORDER BY po.created_at DESC, po.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll();
// DEBUG: Print all orders fetched from the database
if (isset($_GET['debug'])) {
    echo '<pre>';
    print_r($orders);
    echo '</pre>';
}

// Define process stages
$stages = [
    'melting' => ['name' => 'Melting', 'icon' => 'fa-fire'],
    'moulding' => ['name' => 'Moulding', 'icon' => 'fa-cubes'],
    'pouring' => ['name' => 'Pouring', 'icon' => 'fa-fill-drip'],
    'knockout' => ['name' => 'Knockout', 'icon' => 'fa-hammer'],
    'shotblast' => ['name' => 'Shot Blasting', 'icon' => 'fa-spray-can'],
    'fettling' => ['name' => 'Fettling', 'icon' => 'fa-tools'],
    'dispatch' => ['name' => 'Dispatch', 'icon' => 'fa-truck']
];
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h2">Production Process Chart</h1>
        <div>
            <a href="purchase_orders.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i> Back to Purchase Orders
            </a>
        </div>
    </div>
    
    <?php if (empty($orders)): ?>
    <div class="alert alert-info">
        No active purchase orders found in production.
    </div>
    <?php else: ?>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Production Status</h5>
            <div class="input-group" style="max-width: 300px;">
                <input type="text" id="productionSearchInput" class="form-control" placeholder="Search...">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="productionStatusTable">
                    <thead>
                        <tr class="bg-light">
                            <th>PO Number</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Ordered</th>
                            <th>Status</th>
                            <?php foreach ($stages as $stage): ?>
                            <th class="text-center">
                                <i class="fas <?php echo $stage['icon']; ?>" title="<?php echo $stage['name']; ?>"></i>
                                <div class="small"><?php echo $stage['name']; ?></div>
                            </th>
                            <?php endforeach; ?>
                            <th class="text-center bg-danger text-white">
                                <i class="fas fa-exclamation-triangle" title="Rejections"></i>
                                <div class="small">Rejections</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <a href="purchase_order_details.php?id=<?php echo $order['id']; ?>">
                                    <?php echo htmlspecialchars($order['po_number']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo $order['product_quantity'] . ' ' . $order['unit']; ?></td>
                            <td>
                                <?php
                                $badge_class = '';
                                switch ($order['status']) {
                                    case 'completed': $badge_class = 'success'; break;
                                    case 'processing': $badge_class = 'primary'; break;
                                    case 'pending': $badge_class = 'warning'; break;
                                    default: $badge_class = 'secondary';
                                }
                                ?>
                                <span class="badge bg-<?php echo $badge_class; ?>"><?php echo ucfirst($order['status']); ?></span>
                            </td>
                            
                            <!-- Melting -->
                            <td class="text-center">
                                <?php
                                $required = (float)($order['total_melting_required_kg'] ?? 0);
                                $melted = (float)($order['total_melted_kg'] ?? 0);
                                $percentage = 0;
                                if ($required > 0.001) {
                                    $percentage = min(100, ($melted / $required) * 100);
                                }

                                if ($required <= 0.001) {
                                    echo '<span class="text-muted">-</span>';
                                } elseif ($percentage >= 99.9) {
                                    echo '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Done</span>';
                                } else {
                                ?>
                                <div class="progress" style="height: 20px;" title="<?php echo number_format($melted, 2) . ' / ' . number_format($required, 2) . ' kg'; ?>">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $percentage; ?>%;" 
                                         aria-valuenow="<?php echo $melted; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="<?php echo $required; ?>">
                                        <?php echo number_format($percentage, 0); ?>%
                                    </div>
                                </div>
                                <?php } ?>
                            </td>
                            
                            <!-- Moulding -->
                            <td class="text-center">
                                <?php
                                $required = (float)($order['product_quantity'] ?? 0);
                                $completed = isset($order['moulding_qty']) ? (float)$order['moulding_qty'] : 0;
                                $percentage = 0;
                                if ($required > 0.001) {
                                    $percentage = min(100, ($completed / $required) * 100);
                                }
                                if ($required <= 0.001) {
                                    echo '<span class="text-muted">-</span>';
                                } elseif ($percentage >= 99.9) {
                                    echo '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Done</span>';
                                } else {
                                ?>
                                <div class="progress" style="height: 20px;" title="<?php echo number_format($completed, 2) . ' / ' . number_format($required, 2); ?>">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $percentage; ?>%;"
                                         aria-valuenow="<?php echo $completed; ?>"
                                         aria-valuemin="0" 
                                         aria-valuemax="<?php echo $required; ?>">
                                        <?php echo number_format($percentage, 0); ?>%
                                    </div>
                                </div>
                                <?php }
                                ?>
                            </td>
                            
                            <!-- Pouring -->
                            <td class="text-center">
                                <?php
                                $required = (float)($order['product_quantity'] ?? 0);
                                // Calculate poured quantity for this PO and product
                                $stmt_poured = $pdo->prepare("SELECT SUM(quantity) FROM pouring_batches WHERE po_id = ? AND product_id = ?");
                                $stmt_poured->execute([$order['id'], $order['product_id']]);
                                $poured = (float)($stmt_poured->fetchColumn() ?: 0);
                                $percentage = 0;
                                if ($required > 0.001) {
                                    $percentage = min(100, ($poured / $required) * 100);
                                }
                                if ($required <= 0.001) {
                                    echo '<span class="text-muted">-</span>';
                                } elseif ($percentage >= 99.9) {
                                    echo '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Done</span>';
                                } else {
                                ?>
                                <div class="progress" style="height: 20px;" title="<?php echo number_format($poured, 2) . ' / ' . number_format($required, 2); ?>">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $percentage; ?>%;"
                                         aria-valuenow="<?php echo $poured; ?>"
                                         aria-valuemin="0" 
                                         aria-valuemax="<?php echo $required; ?>">
                                        <?php echo number_format($percentage, 0); ?>%
                                    </div>
                                </div>
                                <?php }
                                ?>
                            </td>
                            
                            <!-- Knockout -->
                            <td class="text-center">
                                <?php
                                $required = (float)($order['product_quantity'] ?? 0);
                                // Calculate processed quantity for this PO and product
                                $stmt_knockout = $pdo->prepare("SELECT SUM(pieces_processed) FROM knockout_batches WHERE po_id = ? AND product_id = ?");
                                $stmt_knockout->execute([$order['id'], $order['product_id']]);
                                $processed = (float)($stmt_knockout->fetchColumn() ?: 0);
                                $percentage = 0;
                                if ($required > 0.001) {
                                    $percentage = min(100, ($processed / $required) * 100);
                                }
                                if ($required <= 0.001) {
                                    echo '<span class="text-muted">-</span>';
                                } elseif ($percentage >= 99.9) {
                                    echo '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Done</span>';
                                } else {
                                ?>
                                <div class="progress" style="height: 20px;" title="<?php echo number_format($processed, 2) . ' / ' . number_format($required, 2); ?>">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $percentage; ?>%;"
                                         aria-valuenow="<?php echo $processed; ?>"
                                         aria-valuemin="0" 
                                         aria-valuemax="<?php echo $required; ?>">
                                        <?php echo number_format($percentage, 0); ?>%
                                    </div>
                                </div>
                                <?php }
                                ?>
                            </td>
                            
                            <!-- Shot Blasting -->
                            <td class="text-center">
                                <?php
                                $required = (float)($order['product_quantity'] ?? 0);
                                // Calculate processed quantity for this PO and product
                                $stmt_shot = $pdo->prepare("SELECT SUM(pieces_processed) FROM shot_blasting_batches WHERE po_id = ? AND product_id = ?");
                                $stmt_shot->execute([$order['id'], $order['product_id']]);
                                $processed = (float)($stmt_shot->fetchColumn() ?: 0);
                                $percentage = 0;
                                if ($required > 0.001) {
                                    $percentage = min(100, ($processed / $required) * 100);
                                }
                                if ($required <= 0.001) {
                                    echo '<span class="text-muted">-</span>';
                                } elseif ($percentage >= 99.9) {
                                    echo '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Done</span>';
                                } else {
                                ?>
                                <div class="progress" style="height: 20px;" title="<?php echo number_format($processed, 2) . ' / ' . number_format($required, 2); ?>">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $percentage; ?>%;"
                                         aria-valuenow="<?php echo $processed; ?>"
                                         aria-valuemin="0" 
                                         aria-valuemax="<?php echo $required; ?>">
                                        <?php echo number_format($percentage, 0); ?>%
                                    </div>
                                </div>
                                <?php }
                                ?>
                            </td>
                            
                            <!-- Fettling -->
                            <td class="text-center">
                                <?php
                                $required = (float)($order['product_quantity'] ?? 0);
                                // Calculate fettled quantity for this PO and product
                                $stmt_fettling = $pdo->prepare("SELECT SUM(output_quantity) FROM fettling WHERE po_id = ? AND product_id = ?");
                                $stmt_fettling->execute([$order['id'], $order['product_id']]);
                                $fettled = (float)($stmt_fettling->fetchColumn() ?: 0);
                                $percentage = 0;
                                if ($required > 0.001) {
                                    $percentage = min(100, ($fettled / $required) * 100);
                                }
                                if ($required <= 0.001) {
                                    echo '<span class="text-muted">-</span>';
                                } elseif ($percentage >= 99.9) {
                                    echo '<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Done</span>';
                                } else {
                                ?>
                                <div class="progress" style="height: 20px;" title="<?php echo number_format($fettled, 2) . ' / ' . number_format($required, 2); ?>">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $percentage; ?>%;"
                                         aria-valuenow="<?php echo $fettled; ?>"
                                         aria-valuemin="0" 
                                         aria-valuemax="<?php echo $required; ?>">
                                        <?php echo number_format($percentage, 0); ?>%
                                    </div>
                                </div>
                                <?php }
                                ?>
                            </td>
                            
                            <!-- Dispatch -->
                            <td class="text-center">
                                <?php
                                // Calculate total dispatched quantity for this PO and product
                                $stmt_dispatch = $pdo->prepare("SELECT SUM(quantity) FROM dispatch_items WHERE po_id = ? AND product_id = ?");
                                $stmt_dispatch->execute([$order['id'], $order['product_id']]);
                                $dispatch_qty = (float)($stmt_dispatch->fetchColumn() ?: 0);
                                if ($dispatch_qty > 0) {
                                    echo '<span class="fw-bold text-success">' . number_format($dispatch_qty, 0) . '</span>';
                                } else {
                                    echo '<span class="text-muted">-</span>';
                                }
                                ?>
                            </td>
                            
                            <!-- Rejections -->
                            <td class="text-center">
                                <?php
                                // Calculate total rejection quantity for this PO and product
                                $stmt_rej = $pdo->prepare("SELECT SUM(quantity) FROM rejections WHERE po_id = ? AND product_id = ?");
                                $stmt_rej->execute([$order['id'], $order['product_id']]);
                                $rejection_qty = (float)($stmt_rej->fetchColumn() ?: 0);
                                if ($rejection_qty > 0) {
                                    echo '<span class="fw-bold text-danger">' . number_format($rejection_qty, 0) . '</span>';
                                } else {
                                    echo '<span class="text-muted">-</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Process Flow Legend</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($stages as $key => $stage): ?>
                <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="fa-stack fa-lg">
                                <i class="fas fa-circle fa-stack-2x text-light"></i>
                                <i class="fas <?php echo $stage['icon']; ?> fa-stack-1x text-primary"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0"><?php echo $stage['name']; ?></h6>
                            <small class="text-muted">
                                <?php
                                switch ($key) {
                                    case 'melting':
                                        echo 'Metal melting process';
                                        break;
                                    case 'moulding':
                                        echo 'Mould preparation';
                                        break;
                                    case 'pouring':
                                        echo 'Pouring molten metal';
                                        break;
                                    case 'knockout':
                                        echo 'Removing casting from mould';
                                        break;
                                    case 'shotblast':
                                        echo 'Surface cleaning';
                                        break;
                                    case 'fettling':
                                        echo 'Removing excess material';
                                        break;
                                    case 'dispatch':
                                        echo 'Product shipping';
                                        break;
                                }
                                ?>
                            </small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <!-- Rejections Legend -->
                <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="fa-stack fa-lg">
                                <i class="fas fa-circle fa-stack-2x text-light"></i>
                                <i class="fas fa-exclamation-triangle fa-stack-1x text-danger"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0">Rejections</h6>
                            <small class="text-muted">
                                Items rejected during production
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // Add any JavaScript for interactive features here
    $('#productionSearchInput').on('input', function() {
        const filter = $(this).val().toLowerCase();
        $("#productionStatusTable tbody tr").each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(filter));
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?> 