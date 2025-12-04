{*
* Paystack Direct Payment Template
* Simplified payment experience
*}

<div class="payment-container" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 4px; background: #f9f9f9;">
    <h2 style="color: #333; text-align: center; margin-bottom: 20px;">{l s='Complete Your Payment' mod='paystack'}</h2>
    
    <div class="payment-summary" style="background: white; border: 1px solid #eee; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
        <p style="font-size: 16px; font-weight: bold; color: #333; text-align: center;">
            {l s='Total Amount:' mod='paystack'} <span style="color: #2fb5d2;">{displayPrice price=$total}</span>
        </p>
        
        <div style="text-align: center; margin: 15px 0;">
            <img src="{$this_path_ssl}card-logos.png" alt="{l s='Payment Methods' mod='paystack'}" style="max-width: 250px;">
        </div>
    </div>
    
    <div id="payment-error" class="alert alert-danger" style="display: none; margin-bottom: 15px;">
        <p>{l s='There was an error processing your payment. Please try again.' mod='paystack'}</p>
    </div>
    
    <div style="text-align: center;">
        <button id="pay-button" class="btn btn-primary" style="padding: 10px 20px; font-size: 16px; background: #2fb5d2; border: none; border-radius: 4px; color: white; cursor: pointer; width: 100%;">
            {l s='Pay Now' mod='paystack'}
        </button>
        
        <p style="margin-top: 15px; font-size: 13px; color: #777;">
            <i class="icon-lock"></i> {l s='Secured by Paystack' mod='paystack'}
        </p>
        
        <div style="margin-top: 20px;">
            <a href="{$cancelUrl}" class="btn btn-default" style="font-size: 13px; color: #555;">
                <i class="icon-chevron-left"></i> {l s='Return to Checkout' mod='paystack'}
            </a>
        </div>
    </div>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script type="text/javascript">
document.getElementById('pay-button').addEventListener('click', function() {
    // Disable button and show loading state
    this.disabled = true;
    this.innerHTML = '<i class="icon-spinner icon-spin"></i> {l s="Processing..." mod="paystack"}';
    
    try {
        console.log('Direct payment initiated');
        
        var handler = PaystackPop.setup({
            key: '{$publicKey|escape:'javascript':'UTF-8'}',
            email: '{$email|escape:'javascript':'UTF-8'}',
            amount: {$amount},
            currency: '{$currency|escape:'javascript':'UTF-8'}',
            ref: '{$reference|escape:'javascript':'UTF-8'}',
            callback: function(response) {
                console.log('Payment completed with reference: ' + response.reference);
                window.location.href = '{$callbackUrl|escape:'javascript':'UTF-8'}?reference=' + response.reference;
            },
            onClose: function() {
                console.log('Payment window closed');
                var payButton = document.getElementById('pay-button');
                payButton.disabled = false;
                payButton.innerHTML = '{l s="Pay Now" mod="paystack"}';
            }
        });
        
        handler.openIframe();
    } catch (error) {
        console.error('Payment initialization error:', error);
        document.getElementById('payment-error').style.display = 'block';
        var payButton = document.getElementById('pay-button');
        payButton.disabled = false;
        payButton.innerHTML = '{l s="Try Again" mod="paystack"}';
    }
});
</script>
