<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Default to last 30 days if no dates provided
$endDate = date('Y-m-d');
$startDate = date('Y-m-d', strtotime('-30 days'));
$reportType = '';
$reportData = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'] ?? $startDate;
    $endDate = $_POST['end_date'] ?? $endDate;
    $reportType = $_POST['report_type'] ?? '';
    
    // Validate dates
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
        echo '<div class="alert alert-danger">Invalid date format</div>';
    } else {
        // Generate report data based on report type
        switch ($reportType) {
            case 'production':
                $sql = "SELECT 
                            DATE(p.created_at) as date,
                            COUNT(p.id) as batch_count,
                            SUM(p.metal_used_kg) as total_output,
                            AVG(p.metal_used_kg) as avg_output_per_batch
                        FROM pouring_batches p
                        WHERE p.created_at BETWEEN ? AND ?
                        GROUP BY DATE(p.created_at)
                        ORDER BY date";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$startDate, $endDate]);
                $reportData = $stmt->fetchAll();
                break;
                
            case 'rejection':
                $sql = "SELECT 
                            r.process_stage,
                            r.reason_code,
                            COUNT(r.id) as rejection_count,
                            SUM(r.quantity) as total_rejected
                        FROM rejections r
                        WHERE r.created_at BETWEEN ? AND ?
                        GROUP BY r.process_stage, r.reason_code
                        ORDER BY total_rejected DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$startDate, $endDate]);
                $reportData = $stmt->fetchAll();
                break;
                
            case 'material':
                $sql = "SELECT 
                            m.material_id,
                            mat.name as material_name,
                            SUM(m.quantity) as total_consumed,
                            m.transaction_type
                        FROM material_transactions m
                        LEFT JOIN materials mat ON m.material_id = mat.id
                        WHERE m.transaction_date BETWEEN ? AND ?
                        AND m.transaction_type = 'consumption'
                        GROUP BY m.material_id
                        ORDER BY total_consumed DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$startDate, $endDate]);
                $reportData = $stmt->fetchAll();
                break;
                
            case 'dispatch':
                $sql = "SELECT 
                            d.date,
                            c.name as customer_name,
                            COUNT(d.id) as dispatch_count,
                            SUM(d.total_boxes) as total_boxes,
                            SUM(d.total_weight_kg) as total_weight
                        FROM dispatch d
                        LEFT JOIN customers c ON d.customer_id = c.id
                        WHERE d.date BETWEEN ? AND ?
                        GROUP BY d.date, d.customer_id
                        ORDER BY d.date DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$startDate, $endDate]);
                $reportData = $stmt->fetchAll();
                break;
                
            case 'efficiency':
                $sql = "SELECT 
                            DATE(p.created_at) as date,
                            SUM(p.metal_used_kg) as total_input,
                            SUM(p.metal_used_kg) as total_output,
                            100 as efficiency_percentage
                        FROM pouring_batches p
                        WHERE p.created_at BETWEEN ? AND ?
                        GROUP BY DATE(p.created_at)
                        ORDER BY date";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$startDate, $endDate]);
                $reportData = $stmt->fetchAll();
                break;
                
            case 'operator':
                $sql = "SELECT 
                            u.id as operator_id,
                            u.name as operator_name,
                            COUNT(f.id) as task_count,
                            SUM(f.output_quantity) as total_output,
                            AVG(f.time_taken_hours) as avg_time_per_task
                        FROM fettling f
                        LEFT JOIN users u ON f.operator_id = u.id
                        WHERE f.date BETWEEN ? AND ?
                        GROUP BY f.operator_id
                        ORDER BY total_output DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$startDate, $endDate]);
                $reportData = $stmt->fetchAll();
                break;
                
            case 'po_status':
                $sql = "SELECT 
                            status,
                            COUNT(id) as order_count,
                            SUM(quantity) as total_quantity,
                            MIN(date) as earliest_date,
                            MAX(date) as latest_date
                        FROM purchase_orders
                        GROUP BY status";
                $stmt = $pdo->query($sql);
                $reportData = $stmt->fetchAll();
                break;
                
            default:
                echo '<div class="alert alert-danger">Invalid report type selected</div>';
                break;
        }
    }
}

// Helper function to convert report data to JSON for charts
function dataToJson($data, $labelKey, $valueKey) {
    $labels = [];
    $values = [];
    
    foreach ($data as $row) {
        $labels[] = $row[$labelKey];
        $values[] = $row[$valueKey];
    }
    
    return [
        'labels' => json_encode($labels),
        'values' => json_encode($values)
    ];
}
?>

<div class="container mt-4">
    <h2>Reports & Analytics</h2>
    
    <!-- Report Selection Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5>Generate Report</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="reports.php" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Report Type</label>
                    <select name="report_type" class="form-control" required>
                        <option value="">Select Report Type</option>
                        <option value="production" <?= $reportType === 'production' ? 'selected' : '' ?>>Production Overview</option>
                        <option value="rejection" <?= $reportType === 'rejection' ? 'selected' : '' ?>>Rejection Analysis</option>
                        <option value="material" <?= $reportType === 'material' ? 'selected' : '' ?>>Material Consumption</option>
                        <option value="dispatch" <?= $reportType === 'dispatch' ? 'selected' : '' ?>>Dispatch Report</option>
                        <option value="efficiency" <?= $reportType === 'efficiency' ? 'selected' : '' ?>>Efficiency Report</option>
                        <option value="operator" <?= $reportType === 'operator' ? 'selected' : '' ?>>Operator Performance</option>
                        <option value="po_status" <?= $reportType === 'po_status' ? 'selected' : '' ?>>PO Status Summary</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?= $startDate ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?= $endDate ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php if (!empty($reportType) && !empty($reportData)): ?>
    <!-- Report Results -->
    <div class="card">
        <div class="card-header">
            <h5>
                <?php
                switch($reportType) {
                    case 'production': echo 'Production Overview'; break;
                    case 'rejection': echo 'Rejection Analysis'; break;
                    case 'material': echo 'Material Consumption'; break;
                    case 'dispatch': echo 'Dispatch Report'; break;
                    case 'efficiency': echo 'Efficiency Report'; break;
                    case 'operator': echo 'Operator Performance'; break;
                    case 'po_status': echo 'Purchase Order Status Summary'; break;
                }
                ?>
                (<?= $startDate ?> to <?= $endDate ?>)
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <canvas id="reportChart" height="300"></canvas>
                </div>
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <?php if ($reportType === 'production'): ?>
                                        <th>Date</th><th>Batches</th><th>Output</th><th>Avg/Batch</th>
                                    <?php elseif ($reportType === 'rejection'): ?>
                                        <th>Stage</th><th>Reason</th><th>Count</th><th>Total</th>
                                    <?php elseif ($reportType === 'material'): ?>
                                        <th>Material</th><th>Consumed</th>
                                    <?php elseif ($reportType === 'dispatch'): ?>
                                        <th>Date</th><th>Customer</th><th>Dispatches</th><th>Boxes</th><th>Weight</th>
                                    <?php elseif ($reportType === 'efficiency'): ?>
                                        <th>Date</th><th>Input</th><th>Output</th><th>Efficiency %</th>
                                    <?php elseif ($reportType === 'operator'): ?>
                                        <th>Operator</th><th>Tasks</th><th>Output</th><th>Avg Time</th>
                                    <?php elseif ($reportType === 'po_status'): ?>
                                        <th>Status</th><th>Orders</th><th>Quantity</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reportData as $row): ?>
                                    <tr>
                                        <?php if ($reportType === 'production'): ?>
                                            <td><?= $row['date'] ?></td>
                                            <td><?= $row['batch_count'] ?></td>
                                            <td><?= $row['total_output'] ?></td>
                                            <td><?= round($row['avg_output_per_batch'], 1) ?></td>
                                        <?php elseif ($reportType === 'rejection'): ?>
                                            <td><?= ucfirst(str_replace('_', ' ', $row['process_stage'])) ?></td>
                                            <td><?= ucfirst($row['reason_code']) ?></td>
                                            <td><?= $row['rejection_count'] ?></td>
                                            <td><?= $row['total_rejected'] ?></td>
                                        <?php elseif ($reportType === 'material'): ?>
                                            <td><?= htmlspecialchars($row['material_name']) ?></td>
                                            <td><?= $row['total_consumed'] ?></td>
                                        <?php elseif ($reportType === 'dispatch'): ?>
                                            <td><?= $row['date'] ?></td>
                                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                            <td><?= $row['dispatch_count'] ?></td>
                                            <td><?= $row['total_boxes'] ?></td>
                                            <td><?= $row['total_weight'] ?> kg</td>
                                        <?php elseif ($reportType === 'efficiency'): ?>
                                            <td><?= $row['date'] ?></td>
                                            <td><?= $row['total_input'] ?></td>
                                            <td><?= $row['total_output'] ?></td>
                                            <td><?= round($row['efficiency_percentage'], 1) ?>%</td>
                                        <?php elseif ($reportType === 'operator'): ?>
                                            <td><?= htmlspecialchars($row['operator_name']) ?></td>
                                            <td><?= $row['task_count'] ?></td>
                                            <td><?= $row['total_output'] ?></td>
                                            <td><?= round($row['avg_time_per_task'], 1) ?> hrs</td>
                                        <?php elseif ($reportType === 'po_status'): ?>
                                            <td><?= ucfirst($row['status']) ?></td>
                                            <td><?= $row['order_count'] ?></td>
                                            <td><?= $row['total_quantity'] ?></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button class="btn btn-outline-secondary" onclick="window.print()">Print Report</button>
                <a href="#" class="btn btn-outline-primary" onclick="exportTableToCSV('report.csv')">Export to CSV</a>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('reportChart').getContext('2d');
        let chartType = 'bar';
        let chartData = {
            labels: [],
            datasets: [{
                label: '',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        
        <?php if ($reportType === 'production'): ?>
            <?php $chartData = dataToJson($reportData, 'date', 'total_output'); ?>
            chartData.labels = <?= $chartData['labels'] ?>;
            chartData.datasets[0].label = 'Total Output';
            chartData.datasets[0].data = <?= $chartData['values'] ?>;
            
        <?php elseif ($reportType === 'rejection'): ?>
            <?php 
                $labels = [];
                $values = [];
                foreach ($reportData as $row) {
                    $labels[] = ucfirst($row['reason_code']);
                    $values[] = $row['total_rejected'];
                }
            ?>
            chartType = 'pie';
            chartData.labels = <?= json_encode($labels) ?>;
            chartData.datasets[0].data = <?= json_encode($values) ?>;
            chartData.datasets[0].backgroundColor = [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ];
            
        <?php elseif ($reportType === 'material'): ?>
            <?php 
                $labels = [];
                $values = [];
                foreach ($reportData as $row) {
                    $labels[] = $row['material_name'];
                    $values[] = $row['total_consumed'];
                }
            ?>
            chartData.labels = <?= json_encode($labels) ?>;
            chartData.datasets[0].label = 'Material Consumption';
            chartData.datasets[0].data = <?= json_encode($values) ?>;
            
        <?php elseif ($reportType === 'dispatch'): ?>
            <?php 
                $labels = [];
                $values = [];
                foreach ($reportData as $row) {
                    $labels[] = $row['date'] . ' - ' . $row['customer_name'];
                    $values[] = $row['total_weight'];
                }
            ?>
            chartData.labels = <?= json_encode($labels) ?>;
            chartData.datasets[0].label = 'Dispatch Weight (kg)';
            chartData.datasets[0].data = <?= json_encode($values) ?>;
            
        <?php elseif ($reportType === 'efficiency'): ?>
            <?php 
                $labels = [];
                $values = [];
                foreach ($reportData as $row) {
                    $labels[] = $row['date'];
                    $values[] = $row['efficiency_percentage'];
                }
            ?>
            chartType = 'line';
            chartData.labels = <?= json_encode($labels) ?>;
            chartData.datasets[0].label = 'Efficiency %';
            chartData.datasets[0].data = <?= json_encode($values) ?>;
            chartData.datasets[0].fill = false;
            
        <?php elseif ($reportType === 'operator'): ?>
            <?php 
                $labels = [];
                $values = [];
                foreach ($reportData as $row) {
                    $labels[] = $row['operator_name'];
                    $values[] = $row['total_output'];
                }
            ?>
            chartData.labels = <?= json_encode($labels) ?>;
            chartData.datasets[0].label = 'Total Output';
            chartData.datasets[0].data = <?= json_encode($values) ?>;
            
        <?php elseif ($reportType === 'po_status'): ?>
            <?php 
                $labels = [];
                $values = [];
                foreach ($reportData as $row) {
                    $labels[] = ucfirst($row['status']);
                    $values[] = $row['order_count'];
                }
            ?>
            chartType = 'doughnut';
            chartData.labels = <?= json_encode($labels) ?>;
            chartData.datasets[0].data = <?= json_encode($values) ?>;
            chartData.datasets[0].backgroundColor = [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)'
            ];
        <?php endif; ?>
        
        new Chart(ctx, {
            type: chartType,
            data: chartData,
            options: {
                responsive: true,
                scales: chartType === 'pie' || chartType === 'doughnut' ? {} : {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    
    // Export table to CSV function
    function exportTableToCSV(filename) {
        const table = document.querySelector('table');
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [], cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                row.push('"' + cols[j].innerText + '"');
            }
            
            csv.push(row.join(','));
        }
        
        // Download CSV file
        downloadCSV(csv.join('\n'), filename);
    }
    
    function downloadCSV(csv, filename) {
        const csvFile = new Blob([csv], {type: 'text/csv'});
        const downloadLink = document.createElement('a');
        
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
    </script>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>