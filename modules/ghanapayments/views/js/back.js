/**
* 2007-2025 PrestaShop
*
* Ghana Payments Module - Admin JavaScript
*/

$(document).ready(function() {
    // Set up tabs in admin configuration
    $('.ghanapayments-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Toggle settings based on enabled/disabled switches
    $('input[name="GHANAPAYMENTS_CASH_ENABLED"]').change(function() {
        toggleFieldsetVisibility('cash-settings', $(this).val() == 1);
    });
    
    $('input[name="GHANAPAYMENTS_MOMO_ENABLED"]').change(function() {
        toggleFieldsetVisibility('momo-settings', $(this).val() == 1);
    });
    
    $('input[name="GHANAPAYMENTS_PAYSTACK_ENABLED"]').change(function() {
        toggleFieldsetVisibility('paystack-settings', $(this).val() == 1);
    });
    
    function toggleFieldsetVisibility(id, show) {
        if (show) {
            $('#' + id).slideDown();
        } else {
            $('#' + id).slideUp();
        }
    }
    
    // Initialize visibility on page load
    toggleFieldsetVisibility('cash-settings', $('input[name="GHANAPAYMENTS_CASH_ENABLED"]:checked').val() == 1);
    toggleFieldsetVisibility('momo-settings', $('input[name="GHANAPAYMENTS_MOMO_ENABLED"]:checked').val() == 1);
    toggleFieldsetVisibility('paystack-settings', $('input[name="GHANAPAYMENTS_PAYSTACK_ENABLED"]:checked').val() == 1);

    // Toggle display of test/live API keys based on mode selection
    const updateApiKeysDisplay = function() {
        const liveMode = $('#GHANAPAYMENTS_LIVE_MODE_on').prop('checked');
        
        if (liveMode) {
            $('input[name="GHANAPAYMENTS_PAYSTACK_LIVE_PUBLIC_KEY"]').closest('.form-group').show();
            $('input[name="GHANAPAYMENTS_PAYSTACK_LIVE_SECRET_KEY"]').closest('.form-group').show();
            $('input[name="GHANAPAYMENTS_PAYSTACK_TEST_PUBLIC_KEY"]').closest('.form-group').hide();
            $('input[name="GHANAPAYMENTS_PAYSTACK_TEST_SECRET_KEY"]').closest('.form-group').hide();
        } else {
            $('input[name="GHANAPAYMENTS_PAYSTACK_LIVE_PUBLIC_KEY"]').closest('.form-group').hide();
            $('input[name="GHANAPAYMENTS_PAYSTACK_LIVE_SECRET_KEY"]').closest('.form-group').hide();
            $('input[name="GHANAPAYMENTS_PAYSTACK_TEST_PUBLIC_KEY"]').closest('.form-group').show();
            $('input[name="GHANAPAYMENTS_PAYSTACK_TEST_SECRET_KEY"]').closest('.form-group').show();
        }
    };
    
    // Run on page load
    updateApiKeysDisplay();
    
    // Run when live mode is toggled
    $('#GHANAPAYMENTS_LIVE_MODE_on, #GHANAPAYMENTS_LIVE_MODE_off').change(function() {
        updateApiKeysDisplay();
    });
    
    // Toggle display of Mobile Money settings based on enablement
    const updateMomoDisplay = function() {
        const momoEnabled = $('#GHANAPAYMENTS_MOBILE_MONEY_ENABLED_on').prop('checked');
        
        if (momoEnabled) {
            $('input[name="GHANAPAYMENTS_MOMO_NUMBER"]').closest('.form-group').show();
            $('input[name="GHANAPAYMENTS_TRANSACTION_TIMEOUT"]').closest('.form-group').show();
        } else {
            $('input[name="GHANAPAYMENTS_MOMO_NUMBER"]').closest('.form-group').hide();
            $('input[name="GHANAPAYMENTS_TRANSACTION_TIMEOUT"]').closest('.form-group').hide();
        }
    };
    
    // Run on page load
    updateMomoDisplay();
    
    // Run when Mobile Money is toggled
    $('#GHANAPAYMENTS_MOBILE_MONEY_ENABLED_on, #GHANAPAYMENTS_MOBILE_MONEY_ENABLED_off').change(function() {
        updateMomoDisplay();
    });
    
    // Toggle display of Paystack settings based on enablement
    const updatePaystackDisplay = function() {
        const paystackEnabled = $('#GHANAPAYMENTS_PAYSTACK_ENABLED_on').prop('checked');
        
        if (paystackEnabled) {
            $('input[name^="GHANAPAYMENTS_PAYSTACK_"]').not('[name$="_ENABLED"]').closest('.form-group').show();
            updateApiKeysDisplay(); // Also consider the live/test mode
        } else {
            $('input[name^="GHANAPAYMENTS_PAYSTACK_"]').not('[name$="_ENABLED"]').closest('.form-group').hide();
        }
    };
    
    // Run on page load
    updatePaystackDisplay();
    
    // Run when Paystack is toggled
    $('#GHANAPAYMENTS_PAYSTACK_ENABLED_on, #GHANAPAYMENTS_PAYSTACK_ENABLED_off').change(function() {
        updatePaystackDisplay();
    });
});
