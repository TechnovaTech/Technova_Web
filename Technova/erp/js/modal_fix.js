// Bootstrap Modal Fix
document.addEventListener('DOMContentLoaded', function() {
    console.log('Modal fix script loaded');
    
    // Function to initialize modals
    function initModals() {
        // Check if Bootstrap is available
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap is not loaded!');
            return;
        }
        
        // Initialize all modals
        var modalElements = document.querySelectorAll('.modal');
        console.log('Found modal elements:', modalElements.length);
        
        modalElements.forEach(function(modalElement) {
            try {
                // Create modal instance
                var modalInstance = new bootstrap.Modal(modalElement);
                console.log('Modal initialized:', modalElement.id);
                
                // Store modal instance in the DOM element
                modalElement._bsModal = modalInstance;
            } catch (e) {
                console.error('Error initializing modal:', modalElement.id, e);
            }
        });
    }
    
    // Function to show a modal by ID
    window.showModal = function(modalId) {
        var modalElement = document.getElementById(modalId);
        if (!modalElement) {
            console.error('Modal element not found:', modalId);
            return;
        }
        
        try {
            // Get existing modal instance or create a new one
            var modalInstance = modalElement._bsModal || new bootstrap.Modal(modalElement);
            modalInstance.show();
            console.log('Modal shown:', modalId);
        } catch (e) {
            console.error('Error showing modal:', modalId, e);
        }
    };
    
    // Initialize modals on page load
    initModals();
    
    // Add click handlers for modal trigger buttons
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
        var targetId = button.getAttribute('data-bs-target');
        if (targetId && targetId.startsWith('#')) {
            targetId = targetId.substring(1); // Remove # from the beginning
            
            button.addEventListener('click', function(e) {
                e.preventDefault();
                window.showModal(targetId);
            });
            
            console.log('Added click handler for button targeting:', targetId);
        }
    });
    
    // Special handling for newPOButton
    var newPOButton = document.getElementById('newPOButton');
    if (newPOButton) {
        newPOButton.addEventListener('click', function() {
            window.showModal('newPOModal');
        });
        console.log('Added click handler for newPOButton');
    }
}); 