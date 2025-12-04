<script>
// Prevent back button access after logout
(function() {
    // Check if user is logged out and prevent back navigation
    @if(!auth()->check())
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
    @endif
    
    // Clear any potentially sensitive data from localStorage on logout
    @if(!auth()->check())
    localStorage.clear();
    sessionStorage.clear();
    @endif
})();
</script>
