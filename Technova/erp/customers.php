<?php 
require_once 'includes/header.php'; 
require_once 'includes/functions.php';
require_once 'includes/db_functions.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        setAlert("Invalid security token. Please try again.", 'danger');
        header('Location: customers.php');
        exit;
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_customer') {
        // Sanitize input
        $name = sanitizeInput($_POST['name']);
        $contact_person = sanitizeInput($_POST['contact_person']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $address = sanitizeInput($_POST['address']);
        $city = sanitizeInput($_POST['city']);
        $state = sanitizeInput($_POST['state']);
        $pincode = sanitizeInput($_POST['pincode']);
        $gst_number = sanitizeInput($_POST['gst_number']);
        
        // Create customer data array
        $customer_data = [
            'name' => $name,
            'contact_person' => $contact_person,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'pincode' => $pincode,
            'gst_number' => $gst_number
        ];
        
        // Create customer
        $customer_id = createCustomer($pdo, $customer_data);
        
        if ($customer_id) {
            setAlert("Customer created successfully.", 'success');
        } else {
            setAlert("Error creating customer.", 'danger');
        }
        
        header('Location: customers.php');
        exit;
    }
    elseif ($action === 'update_customer') {
        $id = (int)$_POST['id'];
        
        // Sanitize input
        $name = sanitizeInput($_POST['name']);
        $contact_person = sanitizeInput($_POST['contact_person']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $address = sanitizeInput($_POST['address']);
        $city = sanitizeInput($_POST['city']);
        $state = sanitizeInput($_POST['state']);
        $pincode = sanitizeInput($_POST['pincode']);
        $gst_number = sanitizeInput($_POST['gst_number']);
        
        // Create customer data array
        $customer_data = [
            'name' => $name,
            'contact_person' => $contact_person,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'pincode' => $pincode,
            'gst_number' => $gst_number
        ];
        
        // Update customer
        if (updateCustomer($pdo, $id, $customer_data)) {
            setAlert("Customer updated successfully.", 'success');
        } else {
            setAlert("Error updating customer.", 'danger');
        }
        
        header('Location: customers.php');
        exit;
    }
    elseif ($action === 'delete_customer') {
        $id = (int)$_POST['id'];
        
        // Delete customer
        try {
            if (deleteCustomer($pdo, $id)) {
                setAlert("Customer deleted successfully.", 'success');
            } else {
                setAlert("Error deleting customer.", 'danger');
            }
        } catch (Exception $e) {
            setAlert($e->getMessage(), 'danger');
        }
        
        header('Location: customers.php');
        exit;
    }
}

// Get all customers for display
$customers = getAllCustomers($pdo);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customer Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newCustomerModal">
            <i class="fas fa-plus me-1"></i> Add New Customer
        </button>
    </div>
    
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?php echo $_SESSION['alert']['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['alert']['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Customer List</h5>
            <div class="input-group" style="max-width: 300px;">
                <input type="text" class="form-control" id="customerSearchInput" placeholder="Search customers...">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="customerTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>GST Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($customers) > 0): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['contact_person']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['city']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['gst_number']); ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewCustomerModal" 
                                                    data-customer-id="<?php echo $customer['id']; ?>"
                                                    data-customer-name="<?php echo htmlspecialchars($customer['name']); ?>"
                                                    data-customer-contact="<?php echo htmlspecialchars($customer['contact_person']); ?>"
                                                    data-customer-email="<?php echo htmlspecialchars($customer['email']); ?>"
                                                    data-customer-phone="<?php echo htmlspecialchars($customer['phone']); ?>"
                                                    data-customer-address="<?php echo htmlspecialchars($customer['address']); ?>"
                                                    data-customer-city="<?php echo htmlspecialchars($customer['city']); ?>"
                                                    data-customer-state="<?php echo htmlspecialchars($customer['state']); ?>"
                                                    data-customer-pincode="<?php echo htmlspecialchars($customer['pincode']); ?>"
                                                    data-customer-gst="<?php echo htmlspecialchars($customer['gst_number']); ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCustomerModal" 
                                                    data-customer-id="<?php echo $customer['id']; ?>"
                                                    data-customer-name="<?php echo htmlspecialchars($customer['name']); ?>"
                                                    data-customer-contact="<?php echo htmlspecialchars($customer['contact_person']); ?>"
                                                    data-customer-email="<?php echo htmlspecialchars($customer['email']); ?>"
                                                    data-customer-phone="<?php echo htmlspecialchars($customer['phone']); ?>"
                                                    data-customer-address="<?php echo htmlspecialchars($customer['address']); ?>"
                                                    data-customer-city="<?php echo htmlspecialchars($customer['city']); ?>"
                                                    data-customer-state="<?php echo htmlspecialchars($customer['state']); ?>"
                                                    data-customer-pincode="<?php echo htmlspecialchars($customer['pincode']); ?>"
                                                    data-customer-gst="<?php echo htmlspecialchars($customer['gst_number']); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal" 
                                                    data-customer-id="<?php echo $customer['id']; ?>"
                                                    data-customer-name="<?php echo htmlspecialchars($customer['name']); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No customers found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- New Customer Modal -->
<div class="modal fade" id="newCustomerModal" tabindex="-1" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="customers.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="create_customer">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="contact_person" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        <div class="col-md-4">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="text" class="form-control" id="pincode" name="pincode">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="gst_number" class="form-label">GST Number</label>
                        <input type="text" class="form-control" id="gst_number" name="gst_number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Customer Modal -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1" aria-labelledby="viewCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCustomerModalLabel">Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Company Name:</strong> <span id="view_name"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Contact Person:</strong> <span id="view_contact_person"></span></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Email:</strong> <span id="view_email"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Phone:</strong> <span id="view_phone"></span></p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <p><strong>Address:</strong> <span id="view_address"></span></p>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>City:</strong> <span id="view_city"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>State:</strong> <span id="view_state"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Pincode:</strong> <span id="view_pincode"></span></p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <p><strong>GST Number:</strong> <span id="view_gst_number"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="customers.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_customer">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_contact_person" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="edit_contact_person" name="contact_person">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Address</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="2"></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="edit_city" class="form-label">City</label>
                            <input type="text" class="form-control" id="edit_city" name="city">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_state" class="form-label">State</label>
                            <input type="text" class="form-control" id="edit_state" name="state">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_pincode" class="form-label">Pincode</label>
                            <input type="text" class="form-control" id="edit_pincode" name="pincode">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_gst_number" class="form-label">GST Number</label>
                        <input type="text" class="form-control" id="edit_gst_number" name="gst_number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Customer Modal -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCustomerModalLabel">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="customers.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete_customer">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    <input type="hidden" name="id" id="delete_id">
                    
                    <p>Are you sure you want to delete customer: <strong id="delete_name"></strong>?</p>
                    <p class="text-danger"><strong>Warning:</strong> This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Customer Modal
    const viewCustomerModal = document.getElementById('viewCustomerModal');
    if (viewCustomerModal) {
        viewCustomerModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('view_name').textContent = button.getAttribute('data-customer-name');
            document.getElementById('view_contact_person').textContent = button.getAttribute('data-customer-contact');
            document.getElementById('view_email').textContent = button.getAttribute('data-customer-email');
            document.getElementById('view_phone').textContent = button.getAttribute('data-customer-phone');
            document.getElementById('view_address').textContent = button.getAttribute('data-customer-address');
            document.getElementById('view_city').textContent = button.getAttribute('data-customer-city');
            document.getElementById('view_state').textContent = button.getAttribute('data-customer-state');
            document.getElementById('view_pincode').textContent = button.getAttribute('data-customer-pincode');
            document.getElementById('view_gst_number').textContent = button.getAttribute('data-customer-gst');
        });
    }
    
    // Edit Customer Modal
    const editCustomerModal = document.getElementById('editCustomerModal');
    if (editCustomerModal) {
        editCustomerModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('edit_id').value = button.getAttribute('data-customer-id');
            document.getElementById('edit_name').value = button.getAttribute('data-customer-name');
            document.getElementById('edit_contact_person').value = button.getAttribute('data-customer-contact');
            document.getElementById('edit_email').value = button.getAttribute('data-customer-email');
            document.getElementById('edit_phone').value = button.getAttribute('data-customer-phone');
            document.getElementById('edit_address').value = button.getAttribute('data-customer-address');
            document.getElementById('edit_city').value = button.getAttribute('data-customer-city');
            document.getElementById('edit_state').value = button.getAttribute('data-customer-state');
            document.getElementById('edit_pincode').value = button.getAttribute('data-customer-pincode');
            document.getElementById('edit_gst_number').value = button.getAttribute('data-customer-gst');
        });
    }
    
    // Delete Customer Modal
    const deleteCustomerModal = document.getElementById('deleteCustomerModal');
    if (deleteCustomerModal) {
        deleteCustomerModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('delete_id').value = button.getAttribute('data-customer-id');
            document.getElementById('delete_name').textContent = button.getAttribute('data-customer-name');
        });
    }
    
    // Real-time search for customers
    const searchInput = document.getElementById('customerSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            const table = document.getElementById('customerTable');
            if (!table) return;
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
