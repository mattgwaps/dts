//ACTION CHECKBOX VALIDATION
$(document).ready(function() {
    $('#myForm').on('submit', function(event) {
        // Check if any checkbox is checked
        if ($('div.checkbox-group.required :checkbox:checked').length === 0) {
            alert("PLEASE CHECK THE BOX");
            event.preventDefault(); // Prevent form submission
        }
    });
});
