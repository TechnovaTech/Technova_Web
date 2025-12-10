<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
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

// Get all users/inspectors for the dropdown
$stmt = $pdo->query("SELECT id, name FROM users ORDER BY name");
$inspectors = $stmt->fetchAll();

// Check if we're editing an existing rejection
$rejectionId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$rejection = null;

if ($rejectionId > 0) {
    // Get the rejection details
    $stmt = $pdo->prepare("SELECT 
        r.*, 
        po.po_number, 
        u.name as inspector_name
    FROM rejections r 
    LEFT JOIN purchase_orders po ON r.po_id = po.id
    LEFT JOIN users u ON r.inspector_id = u.id
    WHERE r.id = ?");
    $stmt->execute([$rejectionId]);
    $rejection = $stmt->fetch();
    
    if (!$rejection) {
        // Rejection not found, redirect back to rejection management
        setAlert("Rejection record not found.", 'danger');
        header('Location: rejection.php');
        exit;
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: edit_rejection.php' . ($rejectionId ? "?id=$rejectionId" : ''));
        exit;
    }

    $data = [
        'quantity' => $_POST['quantity'],
        'reason_code' => $_POST['reason_code'],
        'reason_description' => $_POST['reason_description'] ?? '',
        'inspector_id' => $_POST['inspector_id'],
        'remarks' => $_POST['remarks'] ?? ''
    ];
    
    // Check if process_stage column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM rejections LIKE 'process_stage'");
    $processStageExists = $stmt->rowCount() > 0;
    
    if ($rejectionId) {
        // Update existing rejection
        $sql = "UPDATE rejections SET 
                quantity = ?, 
                reason_code = ?, 
                reason_description = ?, 
                inspector_id = ?, 
                remarks = ?";
        
        $params = [
            $data['quantity'],
            $data['reason_code'],
            $data['reason_description'],
            $data['inspector_id'],
            $data['remarks']
        ];
        
        if ($processStageExists) {
            $sql .= ", process_stage = ?";
            $params[] = $_POST['process_stage'];
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $rejectionId;
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);
        
        if ($result) {
            setAlert("Rejection record updated successfully.", 'success');
        } else {
            setAlert("Error updating rejection record.", 'danger');
        }
        
        header('Location: rejection.php');
        exit;
    } else {
        // Should not happen - redirect back to rejection management
        setAlert("Invalid operation.", 'danger');
        header('Location: rejection.php');
        exit;
    }
}

// Get all purchase orders for reference
$poStmt = $pdo->query("SELECT id, po_number FROM purchase_orders ORDER BY po_number DESC");
$purchaseOrders = $poStmt->fetchAll();

// Create a lookup array for PO numbers
$poLookup = [];
foreach ($purchaseOrders as $po) {
    $poLookup[$po['id']] = $po['po_number'];
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Rejection Record</h2>
        <a href="rejection.php" class="btn btn-secondary">Back to Rejection Management</a>
    </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <?php if ($rejection): ?>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Rejection for PO: <?= htmlspecialchars($rejection['po_number']) ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" action="edit_rejection.php?id=<?= $rejectionId ?>">
                <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="po_id" class="form-label">Purchase Order</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($rejection['po_number']) ?>" disabled>
                        <input type="hidden" name="po_id" value="<?= $rejection['po_id'] ?>">
                    </div>
                    
                    <?php 
                    // Check if process_stage column exists in the rejection record
                    $hasProcessStage = isset($rejection['process_stage']);
                    if ($hasProcessStage):
                    ?>
                    <div class="col-md-6">
                        <label for="process_stage" class="form-label">Process Stage</label>
                        <select name="process_stage" id="process_stage" class="form-select" required>
                            <option value="melting" <?= $rejection['process_stage'] === 'melting' ? 'selected' : '' ?>>Melting</option>
                            <option value="moulding" <?= $rejection['process_stage'] === 'moulding' ? 'selected' : '' ?>>Moulding</option>
                            <option value="knockout" <?= $rejection['process_stage'] === 'knockout' ? 'selected' : '' ?>>Knockout</option>
                            <option value="pouring" <?= $rejection['process_stage'] === 'pouring' ? 'selected' : '' ?>>Pouring</option>
                            <option value="fettling" <?= $rejection['process_stage'] === 'fettling' ? 'selected' : '' ?>>Fettling</option>
                            <option value="shot_blasting" <?= $rejection['process_stage'] === 'shot_blasting' ? 'selected' : '' ?>>Shot Blasting</option>
                            <option value="final_inspection" <?= $rejection['process_stage'] === 'final_inspection' ? 'selected' : '' ?>>Final Inspection</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $rejection['quantity'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="reason_code" class="form-label">Reason</label>
                        <select name="reason_code" id="reason_code" class="form-select" required>
                            <?php foreach($reasonCodes as $code => $label): ?>
                            <option value="<?= $code ?>" <?= $rejection['reason_code'] === $code ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="reason_description" class="form-label">Description</label>
                        <input type="text" name="reason_description" id="reason_description" class="form-control" 
                               value="<?= htmlspecialchars($rejection['reason_description'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="inspector_id" class="form-label">Inspector</label>
                        <select name="inspector_id" id="inspector_id" class="form-select" required>
                            <?php foreach($inspectors as $inspector): ?>
                            <option value="<?= $inspector['id'] ?>" <?= $rejection['inspector_id'] == $inspector['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($inspector['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="2"><?= htmlspecialchars($rejection['remarks'] ?? '') ?></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted">Created: <?= date('Y-m-d H:i', strtotime($rejection['created_at'])) ?></p>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="rejection.php" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Rejection</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-danger">
        <p>No rejection record found or invalid ID provided.</p>
        <a href="rejection.php" class="btn btn-primary mt-3">Back to Rejection Management</a>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?> 