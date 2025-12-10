<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/access_control.php'; // Include access control

// Enforce page access before processing anything else
enforcePageAccess();

// Handle AJAX request for parts
if (isset($_GET['get_parts'])) {
    $poId = $_GET['po_id'];
    $stmt = $pdo->prepare("SELECT p.id, p.name FROM products p 
                           JOIN purchase_order_products pop ON p.id = pop.product_id
                           WHERE pop.purchase_order_id = ?
                           ORDER BY p.name");
    $stmt->execute([$poId]);
    $parts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($parts);
    exit;
}

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

// Get all purchase orders for the dropdown
$stmt = $pdo->query("SELECT id, po_number, customer_id FROM purchase_orders ORDER BY po_number DESC");
$purchaseOrders = $stmt->fetchAll();

// Get all users/inspectors for the dropdown
$stmt = $pdo->query("SELECT id, name FROM users WHERE role = 'inspector' OR role = 'admin' ORDER BY name");
$inspectors = $stmt->fetchAll();
if (empty($inspectors)) {
    // If no specific inspectors, get all users
    $stmt = $pdo->query("SELECT id, name FROM users ORDER BY name");
    $inspectors = $stmt->fetchAll();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Log the POST data
    error_log("Rejection form submitted: " . json_encode($_POST));
    
    $data = [
        'po_id' => $_POST['po_id'],
        'product_id' => $_POST['product_id'],
        'process_stage' => $_POST['process_stage'],
        'quantity' => $_POST['quantity'],
        'reason_code' => $_POST['reason_code'],
        'reason_description' => $_POST['reason_description'] ?? '',
        'inspector_id' => $_POST['inspector_id'],
        'remarks' => $_POST['remarks'] ?? ''
    ];
    
    // Debug: Log the processed data
    error_log("Processed rejection data: " . json_encode($data));
    
    // Insert rejection record
    $sql = "INSERT INTO rejections (po_id, product_id, process_stage, quantity, reason_code, reason_description, inspector_id, remarks) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $result = $stmt->execute([
            $data['po_id'], $data['product_id'], $data['process_stage'], $data['quantity'], 
            $data['reason_code'], $data['reason_description'], 
            $data['inspector_id'], $data['remarks']
        ]);
        
        if ($result) {
            $lastId = $pdo->lastInsertId();
            error_log("Rejection record inserted successfully with ID: $lastId");
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log("Failed to insert rejection record: " . json_encode($errorInfo));
        }
    } catch (Exception $e) {
        error_log("Error inserting rejection record: " . $e->getMessage());
    }
    
    // TODO: Update inventory to reflect rejected items
    
    // Redirect to prevent form resubmission
    header('Location: rejection.php?success=1');
    exit;
}

// Get all rejection records
$stmt = $pdo->query("SELECT 
    r.*, 
    po.po_number, 
    u.name as inspector_name,
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
LEFT JOIN purchase_orders po ON r.po_id = po.id
LEFT JOIN users u ON r.inspector_id = u.id
LEFT JOIN products p ON r.product_id = p.id
ORDER BY r.created_at DESC");
$rejections = $stmt->fetchAll();

// Group rejections by PO
$rejectionsByPO = [];
foreach ($rejections as $rejection) {
    if (!isset($rejectionsByPO[$rejection['po_id']])) {
        $rejectionsByPO[$rejection['po_id']] = [];
    }
    $rejectionsByPO[$rejection['po_id']][] = $rejection;
}
?>

<div class="container mt-4">
    <h2 class="p-3">Rejection Management</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Rejection record added successfully!</div>
    <?php endif; ?>
    
    <form method="POST" action="rejection.php" class="row g-3 mb-4" id="rejectionForm" style="background-color:     #d1e0e0 ;">        
        <div class="col-md-2">
            <label for="po_id" class="form-label">Purchase Order</label>
            <select name="po_id" id="po_id" class="form-select" required>
                <option value="">Select PO</option>
                <?php foreach($purchaseOrders as $po): ?>
                <option value="<?= $po['id'] ?>"><?= htmlspecialchars($po['po_number']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="product_id" class="form-label">Part Name</label>
            <select name="product_id" id="product_id" class="form-select" required>
                <option value="">Select Part</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="process_stage" class="form-label">Process Stage</label>
            <select name="process_stage" id="process_stage" class="form-select" required>
                <option value="">Select Stage</option>
                <option value="melting">Melting</option>
                <option value="moulding">Moulding</option>
                <option value="knockout">Knockout</option>
                <option value="pouring">Pouring</option>
                <option value="fettling">Fettling</option>
                <option value="shot_blasting">Shot Blasting</option>
                <option value="final_inspection">Final Inspection</option>
            </select>
        </div>
        <div class="col-md-1">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Qty" required>
        </div>
        <div class="col-md-2">
            <label for="reason_code" class="form-label">Reason</label>
            <input type="text" name="reason_code" id="reason_code" class="form-control" placeholder="Enter reason" required>
        </div>
        <div class="col-md-2">
            <label for="reason_description" class="form-label">Description</label>
            <input type="text" name="reason_description" id="reason_description" class="form-control" placeholder="Description">
        </div>
        <div class="col-md-2">
            <label for="inspector_id" class="form-label">Inspector</label>
            <select name="inspector_id" id="inspector_id" class="form-select" required>
                <option value="">Select Inspector</option>
                <?php foreach($inspectors as $inspector): ?>
                <option value="<?= $inspector['id'] ?>"><?= htmlspecialchars($inspector['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-1">
            <label for="remarks" class="form-label">Remarks</label>
            <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks">
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-danger">Add Rejection Record</button>
        </div>
    </form>
    
    <!-- Rejection History Section -->
    <div class="mt-5">
        <h3 class="mb-4">Rejection History by Order</h3>
        <div class="accordion" id="rejectionHistoryAccordion">
            <?php foreach ($rejectionsByPO as $poId => $rejections): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?= $poId ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#collapse<?= $poId ?>" aria-expanded="false" 
                            aria-controls="collapse<?= $poId ?>">
                        PO: <?= htmlspecialchars($rejections[0]['po_number']) ?> - 
                        Total Rejections: <?= count($rejections) ?>
                    </button>
                </h2>
                <div id="collapse<?= $poId ?>" class="accordion-collapse collapse" 
                     aria-labelledby="heading<?= $poId ?>" data-bs-parent="#rejectionHistoryAccordion">
                    <div class="accordion-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="background-color: #d1e0e0;">
                                    <th>Purchase Order</th>
                                    <th>Process Stage</th>
                                    <th>Part Name</th>
                                    <th>Quantity</th>
                                    <th>Reason</th>
                                    <th>Inspector</th>
                                    <th>Remarks</th>
                                    <th>Date / Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rejections as $rejection): ?>
                                <tr>
                                    <td><?= htmlspecialchars($rejection['po_number']) ?></td>
                                    <td><?= htmlspecialchars($rejection['process_name']) ?></td>
                                    <td><?= htmlspecialchars($rejection['part_name'] ?? '') ?></td>
                                    <td><?= $rejection['quantity'] ?></td>
                                    <td><?= $reasonCodes[$rejection['reason_code']] ?? htmlspecialchars($rejection['reason_code']) ?></td>
                                    <td><?= htmlspecialchars($rejection['inspector_name']) ?></td>
                                    <td><?= htmlspecialchars($rejection['remarks'] ?? '-') ?></td>
                                    <td>
                                        <?= date('Y-m-d H:i', strtotime($rejection['created_at'])) ?>
                                        <div class="btn-group btn-group-sm ms-2">
                                            <a href="edit_rejection.php?id=<?= $rejection['id'] ?>" class="btn btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="delete_rejection.php?id=<?= $rejection['id'] ?>" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Summary Charts Section -->
    <!-- <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Rejections by Process Stage</h5>
                </div>
                <div class="card-body">
                    <canvas id="rejectionsByStageChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Rejections by Reason</h5>
                </div>
                <div class="card-body">
                    <canvas id="rejectionsByReasonChart"></canvas>
                </div>
            </div>
        </div>
    </div> -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle PO selection change
    document.getElementById('po_id').addEventListener('change', function() {
        const poId = this.value;
        const productSelect = document.getElementById('product_id');
        
        // Clear existing options
        productSelect.innerHTML = '<option value="">Select Part</option>';
        
        // If PO is selected, fetch parts
        if (poId) {
            fetch(`rejection.php?get_parts=1&po_id=${poId}`)
                .then(response => response.json())
                .then(parts => {
                    parts.forEach(part => {
                        const option = document.createElement('option');
                        option.value = part.id;
                        option.textContent = part.name;
                        productSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching parts:', error));
        }
    });
    
    // Form validation
    const rejectionForm = document.getElementById('rejectionForm');
    
    if (rejectionForm) {
        rejectionForm.addEventListener('submit', function(e) {
            // Debug form values before submission
            const processStage = document.getElementById('process_stage').value;
            console.log('Form submission - process_stage value:', processStage);
            
            if (!processStage) {
                e.preventDefault();
                alert('Please select a Process Stage');
                return false;
            }
            
            // Log all form data
            const formData = new FormData(rejectionForm);
            const formValues = {};
            for (let [key, value] of formData.entries()) {
                formValues[key] = value;
            }
            console.log('Form data being submitted:', formValues);
        });
    }
    
    // Chart for rejections by stage
    new Chart(document.getElementById('rejectionsByStageChart'), {
        type: 'pie',
        data: {
            labels: ['Pouring', 'Fettling', 'Shot Blasting', 'Final Inspection'],
            datasets: [{
                data: [12, 19, 3, 5],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
            }]
        }
    });
    
    // Chart for rejections by reason
    new Chart(document.getElementById('rejectionsByReasonChart'), {
        type: 'bar',
        data: {
            labels: ['Porosity', 'Cracks', 'Shrinkage', 'Misrun', 'Inclusions', 'Dimensional', 'Surface'],
            datasets: [{
                label: 'Rejection Count',
                data: [12, 19, 3, 5, 2, 3, 8],
                backgroundColor: '#36A2EB'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const poSelect = document.getElementById('po_id');
    const partSelect = document.getElementById('product_id');

    function buildPartOptions(parts) {
        let options = '<option value="">Select Part</option>';
        if (Array.isArray(parts)) {
            parts.forEach(function(part) {
                options += `<option value="${part.id}">${part.name}</option>`;
            });
        }
        return options;
    }

    function fetchPartsForPO(poId) {
        if (!poId) {
            partSelect.innerHTML = '<option value="">Select Part</option>';
            return;
        }
        partSelect.innerHTML = '<option value="">Loading...</option>';
        fetch('ajax_get_po_parts.php?po_id=' + encodeURIComponent(poId))
            .then(res => res.json())
            .then(data => {
                partSelect.innerHTML = buildPartOptions(data.success && Array.isArray(data.parts) ? data.parts : []);
            })
            .catch(() => {
                partSelect.innerHTML = '<option value="">Failed to load parts</option>';
            });
    }

    poSelect.addEventListener('change', function() {
        fetchPartsForPO(this.value);
    });

    // On page load, if a PO is preselected, fetch its products
    if (poSelect.value) {
        fetchPartsForPO(poSelect.value);
    } else {
        partSelect.innerHTML = '<option value="">Select Part</option>';
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>