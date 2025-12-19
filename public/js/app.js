// Auto-hide success alerts after 3 seconds with fade-out effect
document.addEventListener('DOMContentLoaded', function() {
    // Handle auto-hiding of success alerts
    const successAlerts = document.querySelectorAll('.alert.success');
    successAlerts.forEach(function(alert) {
        setTimeout(function() {
            alert.classList.add('fade-out');
            // Remove the element after the fade-out transition completes
            setTimeout(function() {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 500); // Match the CSS transition duration
        }, 3000); // 3 seconds delay before starting fade-out
    });

    // Handle delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const confirmed = confirm('Are you sure you want to delete this item? This action cannot be undone.');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });

    // Simple form validation for reservation form
    const reserveForm = document.querySelector('.js-reserve-form');
    if (reserveForm) {
        reserveForm.addEventListener('submit', function(e) {
            let isValid = true;
            const nameInput = reserveForm.querySelector('input[name="name"]');
            const emailInput = reserveForm.querySelector('input[type="email"]');
            const phoneInput = reserveForm.querySelector('input[name="phone"]');

            // Clear previous error states
            const inputs = reserveForm.querySelectorAll('input');
            inputs.forEach(input => input.classList.remove('error'));

            // Validate name
            if (!nameInput.value || nameInput.value.length < 2) {
                nameInput.classList.add('error');
                isValid = false;
            }

            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailInput.value || !emailRegex.test(emailInput.value)) {
                emailInput.classList.add('error');
                isValid = false;
            }

            // Validate phone
            if (!phoneInput.value || phoneInput.value.length < 6) {
                phoneInput.classList.add('error');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = reserveForm.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
    }
    
    // Handle search functionality in reservations
    const searchInput = document.querySelector('#reservationSearch');
    if (searchInput) {
        // Get the current URL and parameters
        const urlParams = new URLSearchParams(window.location.search);
        const eventId = urlParams.get('event_id');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();
            
            // Update URL with search term (without page reload)
            const newUrl = new URL(window.location);
            if (searchTerm) {
                newUrl.searchParams.set('search', searchTerm);
            } else {
                newUrl.searchParams.delete('search');
            }
            
            // Use history.pushState to update URL without reload
            window.history.replaceState({}, '', newUrl);
            
            // If we have an event_id, redirect to include search term
            if (eventId) {
                const baseUrl = window.location.pathname;
                const newUrlWithSearch = `${baseUrl}?event_id=${eventId}&search=${encodeURIComponent(searchTerm)}`;
                window.location.href = newUrlWithSearch;
            } else {
                // For all reservations page, we would need a different approach
                // For now, we'll just show a message that search is working
                console.log('Search term:', searchTerm);
            }
        });
    }
});