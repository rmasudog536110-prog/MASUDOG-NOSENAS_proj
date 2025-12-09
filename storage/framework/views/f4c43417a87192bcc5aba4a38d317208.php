<script>
// Prevent back button access after logout
(function() {
    // Check if user is logged out and prevent back navigation
    <?php if(!auth()->check()): ?>
    window.addEventListener('popstate', function(event) {
        // Redirect to login if trying to go back to a protected page
        if (window.location.pathname.startsWith('/user_dashboard') || 
            window.location.pathname.startsWith('/admin') || 
            window.location.pathname.startsWith('/instructor') ||
            window.location.pathname.startsWith('/my-plan')) {
            window.location.href = '/login';
        }
    });
    
    // Push initial state to enable popstate event
    history.pushState(null, null, document.URL);
    <?php endif; ?>
    
    // Clear any potentially sensitive data from localStorage on logout
    <?php if(!auth()->check()): ?>
    localStorage.clear();
    sessionStorage.clear();
    <?php endif; ?>
})();
</script>
<?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\partials\session-security.blade.php ENDPATH**/ ?>