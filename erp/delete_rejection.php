<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if the user is logged in and has appropriate permissions
// This would depend on your authentication system

// Check if an ID was provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setAlert("Invalid rejection record ID.", 'danger');
    header('Location: rejection.php');
    exit;
}

$rejectionId = (int)$_GET['id'];

// Check for CSRF token if using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: rejection.php');
        exit;
    }
    
    try {
        // Get the rejection record first to confirm it exists
        $stmt = $pdo->prepare("SELECT id, po_id FROM rejections WHERE id = ?");
        $stmt->execute([$rejectionId]);
        $rejection = $stmt->fetch();
        
        if (!$rejection) {
            setAlert("Rejection record not found.", 'danger');
            header('Location: rejection.php');
            exit;
        }
        
        // Delete the rejection record
        $stmt = $pdo->prepare("DELETE FROM rejections WHERE id = ?");
        $result = $stmt->execute([$rejectionId]);
        
        if ($result) {
            setAlert("Rejection record deleted successfully.", 'success');
        } else {
            setAlert("Error deleting rejection record.", 'danger');
        }
        
        header('Location: rejection.php');
        exit;
    } catch (PDOException $e) {
        setAlert("Database error: " . $e->getMessage(), 'danger');
        header('Location: rejection.php');
        exit;
    }
} else {
    // Display confirmation page
    require_once 'includes/header.php';
    
    // Get the rejection details
    $stmt = $pdo->prepare("SELECT 
        r.*, 
        po.po_number, 
        u.name as inspector_name,
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
    WHERE r.id = ?");
    $stmt->execute([$rejectionId]);
    $rejection = $stmt->fetch();
    
    if (!$rejection) {
        setAlert("Rejection record not found.", 'danger');
        header('Location: rejection.php');
        exit;
    }
    
    // Define reason codes for display
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
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Delete Rejection Record</h2>
        <a href="rejection.php" class="btn btn-secondary">Back to Rejection Management</a>
    </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Confirm Deletion</h5>
        </div>
        <div class="card-body">
            <p class="mb-4">Are you sure you want to delete the following rejection record? This action cannot be undone.</p>
            
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <tr>
                        <th>Purchase Order</th>
                        <td><?= htmlspecialchars($rejection['po_number']) ?></td>
                    </tr>
                    <?php if (isset($rejection['process_stage'])): ?>
                    <tr>
                        <th>Process Stage</th>
                        <td><?= htmlspecialchars($rejection['process_name']) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Quantity</th>
                        <td><?= $rejection['quantity'] ?></td>
                    </tr>
                    <tr>
                        <th>Reason</th>
                        <td><?= $reasonCodes[$rejection['reason_code']] ?? htmlspecialchars($rejection['reason_code']) ?></td>
                    </tr>
                    <tr>
                        <th>Inspector</th>
                        <td><?= htmlspecialchars($rejection['inspector_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td><?= htmlspecialchars($rejection['remarks'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td><?= date('Y-m-d H:i', strtotime($rejection['created_at'])) ?></td>
                    </tr>
                </table>
            </div>
            
            <form method="POST" action="delete_rejection.php?id=<?= $rejectionId ?>">
                <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                <div class="d-flex justify-content-end">
                    <a href="rejection.php" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-danger">Delete Rejection Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    require_once 'includes/footer.php';
}
?> 