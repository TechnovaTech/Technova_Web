// Purchase Orders JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Purchase Orders JS loaded');
    
    // Material check function
    window.checkMaterials = function() {
        const productId = document.getElementById('product_id').value;
        const quantity = document.getElementById('quantity').value;
        
        if (!productId || !quantity) {
            alert('Please select a product and enter quantity first');
            return;
        }
        
        // Show loading indicator
        document.getElementById('materialCheck').style.display = 'block';
        document.getElementById('materialResultsBody').innerHTML = '<tr><td colspan="5" class="text-center">Loading...</td></tr>';
        document.getElementById('materialSummary').innerHTML = '';
        
        // Fetch material requirements
        fetch(`purchase_orders.php?action=check_materials&product_id=${productId}&quantity=${quantity}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let html = '';
                    
                    // Generate rows for each material
                    data.requirements.forEach(item => {
                        const status = item.deficit > 0 
                            ? `<span class="badge bg-danger">Insufficient (-${item.deficit} ${item.unit})</span>` 
                            : `<span class="badge bg-success">Available</span>`;
                        
                        html += `
                            <tr>
                                <td>${item.material_name}</td>
                                <td>${item.material_type}</td>
                                <td>${item.required} ${item.unit}</td>
                                <td>${item.available} ${item.unit}</td>
                                <td>${status}</td>
                            </tr>
                        `;
                    });
                    
                    document.getElementById('materialResultsBody').innerHTML = html;
                    
                    // Generate summary message
                    let summaryHtml = '';
                    if (data.has_deficit) {
                        summaryHtml = `
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Insufficient materials:</strong> ${data.total_deficit_items} materials need to be produced/procured.
                                Tasks will be automatically created when the order is submitted.
                            </div>
                        `;
                    } else {
                        summaryHtml = `
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>All materials available:</strong> Materials will be deducted from stock when the order is submitted.
                            </div>
                        `;
                    }
                    
                    document.getElementById('materialSummary').innerHTML = summaryHtml;
                } else {
                    document.getElementById('materialResultsBody').innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center text-danger">
                                Error: ${data.message}
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(error => {
                document.getElementById('materialResultsBody').innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            Error: Could not fetch material requirements. Please try again.
                        </td>
                    </tr>
                `;
                console.error('Error:', error);
            });
    };
    
    // View PO function
    window.viewPO = function(id) {
        window.location.href = `purchase_order_details.php?id=${id}`;
    };
    
    // Mark completed function
    window.markCompleted = function(id) {
        if (confirm('Are you sure you want to mark this order as completed?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'purchase_orders.php';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'mark_completed';
            
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'po_id';
            idInput.value = id;
            
            form.appendChild(actionInput);
            form.appendChild(idInput);
            document.body.appendChild(form);
            form.submit();
        }
    };
    
    // Delete PO function
    window.deletePO = function(id) {
        if (confirm('Are you sure you want to delete this purchase order?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'purchase_orders.php';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'delete';
            
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = id;
            
            form.appendChild(actionInput);
            form.appendChild(idInput);
            document.body.appendChild(form);
            form.submit();
        }
    };
}); 