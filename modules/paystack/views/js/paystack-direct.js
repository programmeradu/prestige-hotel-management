/**
 * Direct Paystack integration
 * Handles payment initialization directly from the product page
 */

function initPaystackPayment(config) {
    console.log('Initializing Paystack payment with config:', config);
    
    if (!window.PaystackPop) {
        console.error('PaystackPop not loaded. Make sure the Paystack JS is loaded correctly.');
        return false;
    }
    
    try {
        var handler = PaystackPop.setup({
            key: config.publicKey,
            email: config.email,
            amount: config.amount,
            currency: config.currency,
            ref: config.reference,
            callback: function(response) {
                console.log('Payment successful! Reference:', response.reference);
                window.location.href = config.callbackUrl + '?reference=' + response.reference;
            },
            onClose: function() {
                console.log('Payment window closed');
            }
        });
        
        handler.openIframe();
        return true;
    } catch (e) {
        console.error('Error initializing Paystack payment:', e);
        return false;
    }
}

// Make it available globally
window.initPaystackPayment = initPaystackPayment;
