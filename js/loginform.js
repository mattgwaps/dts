
function removeUrlParameter(parameter) {
            // Parse the current URL
            const url = new URL(window.location.href);
            // Remove the specified parameter
            url.searchParams.delete(parameter);
            // Update the URL without reloading the page
            window.history.replaceState(null, null, url.toString());
        }

        // Execute the function to remove the 'error' parameter
        document.addEventListener("DOMContentLoaded", function() {
            removeUrlParameter('error');
        });
