/**
 * Paystack integration script
 * filepath: c:\Users\sam\Downloads\prestashop-payment-module (2)\ghanapayments\generated module\views\js\paystack.js
 */

// This script provides utility functions for Paystack integration

/**
 * Format a monetary amount for display
 * @param {number} amount - The amount to format
 * @param {string} currency - The currency code
 * @return {string} - The formatted amount
 */
function formatCurrency(amount, currency) {
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
    });
    return formatter.format(amount / 100);
}

/**
 * Handle Paystack payment initialization
 * @param {string} publicKey - Paystack public key
 * @param {string} email - Customer email
 * @param {number} amount - Amount in minor units (e.g. kobo)
 * @param {string} currency - Currency code (e.g. GHS)
 * @param {string} reference - Payment reference
 * @param {string} callbackUrl - URL to redirect to after payment
 * @param {string} customerName - Customer name
 */
function initializePaystackPayment(publicKey, email, amount, currency, reference, callbackUrl, customerName) {
    const handler = PaystackPop.setup({
        key: publicKey,
        email: email,
        amount: amount,
        currency: currency,
        ref: reference,
        firstname: customerName,
        metadata: {
            custom_fields: [
                {
                    display_name: "Payment For",
                    variable_name: "payment_for",
                    value: "Hotel Booking"
                }
            ]
        },
        callback: function(response) {
            window.location = callbackUrl;
        },
        onClose: function() {
            alert('Transaction was not completed, window closed.');
        }
    });
    handler.openIframe();
}

// Initialize when document is ready
document.addEventListener("DOMContentLoaded", function() {
    // This function will be called if there's a Paystack payment button on the page
    if (document.getElementById('paystack-payment-button')) {
        document.getElementById('paystack-payment-button').addEventListener('click', function(e) {
            e.preventDefault();
            // The button should have data attributes with the necessary information
            const button = this;
            initializePaystackPayment(
                button.getAttribute('data-key'),
                button.getAttribute('data-email'),
                button.getAttribute('data-amount'),
                button.getAttribute('data-currency'),
                button.getAttribute('data-ref'),
                button.getAttribute('data-callback'),
                button.getAttribute('data-name')
            );
        });
    }
});
