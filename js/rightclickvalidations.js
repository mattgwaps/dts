document.addEventListener('DOMContentLoaded', (event) => {
    const message = "Right-click is disabled.";
    
    // Disable right-click context menu
    document.addEventListener('contextmenu', (e) => {
        e.preventDefault();
    });

    // Disable F12, Ctrl+Shift+I, Ctrl+U
    document.addEventListener('keydown', (e) => {
        if (e.key === 'F12') {
            // Disable F12 key
            e.preventDefault();
        } else if (e.key === 'F11') {
            // Disable opening developer tools with Ctrl+Shift+I
            e.preventDefault();
        } else if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) {
            // Disable opening developer tools with Ctrl+Shift+I
            e.preventDefault();
        } else if (e.ctrlKey && (e.key === 'U' || e.key === 'u')) {
            // Disable viewing source with Ctrl+U
            e.preventDefault();
        }
    });

    // Function to remove URL parameter
    function removeUrlParameter(parameter) {
        const url = new URL(window.location.href);
        url.searchParams.delete(parameter);
        window.history.replaceState(null, null, url.toString());
    }

    // Execute the function to remove the 'error' parameter
    removeUrlParameter('error');
});
