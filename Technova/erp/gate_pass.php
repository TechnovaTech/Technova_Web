<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Check if dispatch ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setAlert("Invalid dispatch ID.", 'danger');
    header('Location: dispatch.php');
    exit;
}

$dispatch_id = (int)$_GET['id'];

// Get dispatch details with related information (new structure)
$sql = "SELECT d.*, po.po_number, c.name as customer_name, c.address as customer_address, c.city as customer_city, c.state as customer_state, c.pincode as customer_pincode FROM dispatch d JOIN purchase_orders po ON d.po_id = po.id JOIN customers c ON d.customer_id = c.id WHERE d.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$dispatch_id]);
$dispatch = $stmt->fetch();

if (!$dispatch) {
    setAlert("Dispatch not found.", 'danger');
    header('Location: dispatch.php');
    exit;
}

// Fetch all products for this dispatch
$sql = "SELECT di.*, p.name as product_name FROM dispatch_items di JOIN products p ON di.product_id = p.id WHERE di.dispatch_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$dispatch_id]);
$dispatch_items = $stmt->fetchAll();

// Check if gate_pass_number column exists in dispatches table
$sql = "SHOW COLUMNS FROM dispatches LIKE 'gate_pass_number'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$column_exists = $stmt->fetch();

// Generate gate pass number
// Format: GP-YYYYMMDD-XXXX (where XXXX is the dispatch ID padded with zeros)
$gate_pass_number = 'GP-' . date('Ymd') . '-' . str_pad($dispatch_id, 4, '0', STR_PAD_LEFT);

// If column exists and gate pass number is not already assigned, update the record
if ($column_exists && empty($dispatch['gate_pass_number'])) {
    // Update the dispatch record with the gate pass number
    $sql = "UPDATE dispatches SET gate_pass_number = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$gate_pass_number, $dispatch_id]);
}

// Set the gate pass number for use in this page
$dispatch['gate_pass_number'] = $gate_pass_number;

// Create gate pass verification code (simpler alternative to QR code)
$verification_code = strtoupper(substr(md5($dispatch['gate_pass_number'] . $dispatch_id), 0, 8));

// Store gate pass data for display
$gate_pass_data = [
    'gate_pass' => $dispatch['gate_pass_number'],
    'verification_code' => $verification_code,
    'po_number' => $dispatch['po_number'],
    'customer' => $dispatch['customer_name'],
    'products' => array_map(function($item) {
        return [
            'name' => $item['product_name'],
            'quantity' => $item['quantity']
        ];
    }, $dispatch_items),
    'dispatch_date' => $dispatch['date'],
    'transport' => $dispatch['transporter']
];

// Convert to JSON for potential future use
$gate_pass_json = json_encode($gate_pass_data);

// Check if print view is requested
$print_view = isset($_GET['print']) && $_GET['print'] === 'true';

if ($print_view) {
    // Display print-friendly version
    require_once 'includes/print_header.php'; // A minimal header for printing
    ?>
    <div class="container print-container my-4" id="printable-gate-pass">
        <div class="text-center mb-4">
            <h1>GATE PASS</h1>
            <h3><?php echo htmlspecialchars($dispatch['gate_pass_number']); ?></h3>
            <p>Date: <?php echo formatDate($dispatch['date'] ?? ''); ?></p>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h5>Customer Details</h5></div>
                    <div class="card-body">
                        <p>
                            <strong>Name:</strong> <?php echo htmlspecialchars($dispatch['customer_name']); ?><br>
                            <strong>Address:</strong> <?php echo htmlspecialchars($dispatch['customer_address']); ?><br>
                            <?php echo htmlspecialchars($dispatch['customer_city']); ?>, 
                            <?php echo htmlspecialchars($dispatch['customer_state']); ?> - 
                            <?php echo htmlspecialchars($dispatch['customer_pincode']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h5>Product Details</h5></div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dispatch_items as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h5>Transport Details</h5></div>
                    <div class="card-body">
                        <p>
                            <?php echo htmlspecialchars($dispatch['transporter'] ?? ''); ?><br>
                            <?php if (!empty($dispatch['notes'])): ?>
                                <strong>Notes:</strong> <?php echo htmlspecialchars($dispatch['notes']); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="verification-code-container p-4 border" style="background-color: #f8f9fa;">
                    <h3 class="mb-3">Verification Code</h3>
                    <div class="verification-code p-3 border bg-white" style="font-family: monospace; font-size: 24px; letter-spacing: 3px;">
                        <?php echo $verification_code; ?>
                    </div>
                    <p class="text-muted mt-3">Use this code to verify the gate pass</p>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-6 text-center">
                <div class="signature-box p-3 border-top">
                    <p class="mt-2">Authorized Signature</p>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="signature-box p-3 border-top">
                    <p class="mt-2">Receiver's Signature</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
    <?php
    exit;
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gate Pass</h2>
        <div>
            <button id="downloadPdfBtn" class="btn btn-success me-2">
                <i class="fas fa-download me-1"></i> Download Gate Pass PDF
            </button>
            <a href="dispatch.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Dispatch List
            </a>
        </div>
    </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gate Pass #<?php echo htmlspecialchars($dispatch['gate_pass_number']); ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h6>Customer Details</h6>
                    <p>
                        <strong>Name:</strong> <?php echo htmlspecialchars($dispatch['customer_name']); ?><br>
                        <strong>Address:</strong> <?php echo htmlspecialchars($dispatch['customer_address']); ?><br>
                        <?php echo htmlspecialchars($dispatch['customer_city']); ?>, 
                        <?php echo htmlspecialchars($dispatch['customer_state']); ?> - 
                        <?php echo htmlspecialchars($dispatch['customer_pincode']); ?>
                    </p>
                    <h6>Product Details</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dispatch_items as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h6>Dispatch Date:</h6>
                    <p><?php echo formatDate($dispatch['date'] ?? ''); ?></p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="verification-code-container p-4 border mb-3" style="background-color: #f8f9fa;">
                        <h3 class="mb-3">Verification Code</h3>
                        <div class="verification-code p-3 border bg-white" style="font-family: monospace; font-size: 28px; letter-spacing: 3px;">
                            <?php echo $verification_code; ?>
                        </div>
                        <p class="text-muted mt-3">Use this code to verify the gate pass</p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h6>Transport Details</h6>
                    <p>
                        <?php echo htmlspecialchars($dispatch['transporter'] ?? ''); ?><br>
                        <?php if (!empty($dispatch['notes'])): ?>
                            <strong>Notes:</strong> <?php echo htmlspecialchars($dispatch['notes']); ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 text-center">
            <div class="signature-box p-3 border mb-2" style="min-height: 80px;">
                <span class="mt-2">Authorized Signature</span>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <div class="signature-box p-3 border mb-2" style="min-height: 80px;">
                <span class="mt-2">Receiver's Signature</span>
            </div>
        </div>
    </div>
</div>

<!-- Include jsPDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    document.getElementById('downloadPdfBtn').addEventListener('click', function() {
        const doc = new window.jspdf.jsPDF({ orientation: 'portrait', unit: 'pt', format: 'a4' });
        const pageWidth = doc.internal.pageSize.getWidth();
        let y = 50;

        // Title
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(24);
        doc.text('GATE PASS', pageWidth / 2, y, { align: 'center' });
        y += 30;
        doc.setFontSize(16);
        doc.text('GP-<?php echo $dispatch["gate_pass_number"]; ?>', pageWidth / 2, y, { align: 'center' });
        y += 20;
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(12);
        doc.text('Date: <?php echo formatDate($dispatch['date'] ?? ''); ?>', pageWidth / 2, y, { align: 'center' });
        y += 30;

        // Customer Details
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(12);
        doc.text('Customer Details:', 60, y);
        y += 18;
        doc.setFont('helvetica', 'normal');
        doc.text('Name: <?php echo htmlspecialchars($dispatch['customer_name']); ?>', 80, y);
        y += 15;
        doc.text('Address: <?php echo htmlspecialchars($dispatch['customer_address']); ?>', 80, y);
        y += 15;
        doc.text('<?php echo htmlspecialchars($dispatch['customer_city']); ?>, <?php echo htmlspecialchars($dispatch['customer_state']); ?> - <?php echo htmlspecialchars($dispatch['customer_pincode']); ?>', 80, y);
        y += 25;

        // Product Details
        doc.setFont('helvetica', 'bold');
        doc.text('Product Details:', 60, y);
        y += 18;
        doc.setFont('helvetica', 'normal');
        doc.text('PO Number: <?php echo htmlspecialchars($dispatch['po_number']); ?>', 80, y);
        y += 15;
        <?php foreach ($dispatch_items as $item): ?>
        doc.text('Product: <?php echo htmlspecialchars($item['product_name']); ?>', 80, y);
        y += 15;
        doc.text('Quantity: <?php echo $item['quantity']; ?>', 80, y);
        y += 15;
        <?php endforeach; ?>
        doc.text('Packaging: <?php echo htmlspecialchars($dispatch['box_name'] ?? ''); ?>', 80, y);
        y += 25;

        // Transport Details
        doc.setFont('helvetica', 'bold');
        doc.text('Transport Details:', 60, y);
        y += 18;
        doc.setFont('helvetica', 'normal');
        doc.text('<?php echo htmlspecialchars($dispatch['transporter'] ?? ''); ?>', 80, y);
        y += 30;

        // Verification Code
        doc.setFont('helvetica', 'bold');
        doc.text('Verification Code:', pageWidth / 2, y, { align: 'center' });
        y += 20;
        doc.setFont('courier', 'bold');
        doc.setFontSize(18);
        doc.text('<?php echo $verification_code; ?>', pageWidth / 2, y, { align: 'center' });
        y += 60;

        // Signature lines
        const sigY = 700;
        doc.setDrawColor(0);
        doc.setLineWidth(1);
        doc.line(80, sigY, 220, sigY); // Left signature line
        doc.line(pageWidth - 220, sigY, pageWidth - 80, sigY); // Right signature line
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(12);
        doc.text('Authorized Signature', 150, sigY + 15, { align: 'center' });
        doc.text("Receiver's Signature", pageWidth - 150, sigY + 15, { align: 'center' });

        doc.save('gate_pass_<?php echo $dispatch["gate_pass_number"]; ?>.pdf');
    });
</script>

<?php require_once 'includes/footer.php'; ?>
