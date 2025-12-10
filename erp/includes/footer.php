            </div>
        </div>
    </div>
    
    <!-- jQuery (required for some Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Popper.js (required for Bootstrap tooltips and popovers) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Global Helper Functions -->
    <script>
        // Global function to show modals by ID
        window.showModal = function(modalId) {
            console.log('Showing modal:', modalId);
            
            try {
                // Method 1: Bootstrap 5 approach
                if (typeof bootstrap !== 'undefined') {
                    var modalElement = document.getElementById(modalId);
                    if (modalElement) {
                        var modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    } else {
                        console.error('Modal element not found:', modalId);
                    }
                }
                // Method 2: jQuery approach (fallback)
                else if (typeof jQuery !== 'undefined' && typeof jQuery.fn.modal !== 'undefined') {
                    jQuery('#' + modalId).modal('show');
                }
                // Method 3: Direct DOM manipulation (last resort)
                else {
                    var modalElement = document.getElementById(modalId);
                    if (modalElement) {
                        modalElement.classList.add('show');
                        modalElement.style.display = 'block';
                        document.body.classList.add('modal-open');
                        
                        // Create backdrop
                        var backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    } else {
                        console.error('Modal element not found:', modalId);
                    }
                }
            } catch (e) {
                console.error('Failed to show modal:', e);
            }
        };
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? 'Loaded' : 'Not loaded');
            
            // Add click handlers for all modal triggers
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
                var targetId = button.getAttribute('data-bs-target');
                if (targetId && targetId.startsWith('#')) {
                    targetId = targetId.substring(1); // Remove # from the beginning
                    
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        window.showModal(targetId);
                    });
                }
            });
            
            // Auto-hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (bootstrap && bootstrap.Alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);
        });
    </script>
</body>
</html>
<?php
// Flush the output buffer and send content to browser
if (ob_get_level() > 0) {
    ob_end_flush();
}
?> 