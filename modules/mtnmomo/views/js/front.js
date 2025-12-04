/**
 * MTN Mobile Money payment module
 * Front-end JavaScript
 */
$(document).ready(function() {
    // Format phone number input for Ghana
    $('input[name="phone_number"]').on('input', function() {
        // Remove non-numeric characters
        var phoneNumber = $(this).val().replace(/[^0-9]/g, '');
        
        // Limit to 9 digits (excluding country code)
        if (phoneNumber.length > 9) {
            phoneNumber = phoneNumber.substring(0, 9);
        }
        
        // Update the input value
        $(this).val(phoneNumber);
    });
});
