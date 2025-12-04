/**
* 2007-2025 PrestaShop
*
* Ghana Payments Module - Front-end JavaScript
*/

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Money form validation
    const momoForm = document.getElementById('mobilemoney_form');
    if (momoForm) {
        const phoneInput = document.getElementById('momo_phone');
        
        phoneInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/\D/g, '');
            
            // Limit to 9 digits
            if (this.value.length > 9) {
                this.value = this.value.slice(0, 9);
            }
        });
        
        momoForm.addEventListener('submit', function(e) {
            const network = document.getElementById('momo_network').value;
            const phone = document.getElementById('momo_phone').value;
            const termsCheckbox = document.getElementById('terms_agreement');
            
            if (!network) {
                e.preventDefault();
                alert('Please select your mobile money network');
                return false;
            }
            
            if (!phone || phone.length !== 9) {
                e.preventDefault();
                alert('Please enter a valid 9-digit mobile number');
                return false;
            }
            
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Please agree to the payment terms');
                return false;
            }
            
            return true;
        });
    }
    
    // Pay at Check-in form validation
    const payCashForm = document.getElementById('paycash_form');
    if (payCashForm) {
        payCashForm.addEventListener('submit', function(e) {
            const arrivalDate = document.getElementById('arrival_date').value;
            const termsCheckbox = document.getElementById('terms_agreement');
            
            if (!arrivalDate) {
                e.preventDefault();
                alert('Please select your expected arrival date');
                return false;
            }
            
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Please agree to the payment terms');
                return false;
            }
            
            return true;
        });
    }
    
    // Mobile Money transaction ID submission in confirmation page
    const transactionForm = document.querySelector('form[action*="validation"]');
    if (transactionForm && transactionForm.querySelector('[name="transaction_id"]')) {
        transactionForm.addEventListener('submit', function(e) {
            const txnId = document.getElementById('transaction_id').value;
            const network = document.getElementById('network').value;
            
            if (!txnId || txnId.trim() === '') {
                e.preventDefault();
                alert('Please enter your transaction ID');
                return false;
            }
            
            if (!network) {
                e.preventDefault();
                alert('Please select the network you used for payment');
                return false;
            }
            
            return true;
        });
    }
});
