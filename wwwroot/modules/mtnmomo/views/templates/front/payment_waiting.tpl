{* filepath: c:\xampp\htdocs\modules\mtnmomo\views\templates\front\payment_waiting.tpl *}
{extends file='page.tpl'}

{block name='page_content'}
<div class="mtnmomo-payment-waiting">
    <div class="alert alert-info">
        <h4>{l s='MTN Mobile Money Payment in Progress' mod='mtnmomo'}</h4>
        <p>{l s='You should have received a prompt on your mobile phone to approve this payment.' mod='mtnmomo'}</p>
        <p>{l s='Please check your MTN Mobile Money app or messages to complete the payment.' mod='mtnmomo'}</p>
        <p>{l s='Reference: %s' sprintf=$reference_id mod='mtnmomo'}</p>
    </div>
    
    <div class="text-center waiting-animation">
        <i class="icon icon-refresh icon-spin"></i>
        <p>{l s='Checking payment status...' mod='mtnmomo'}</p>
    </div>
    
    <div class="payment-status" id="payment-status">
        <div class="alert alert-warning">
            {l s='Waiting for your payment approval...' mod='mtnmomo'}
        </div>
    </div>
    
    <div class="payment-actions hidden" id="payment-actions">
        <a href="{$confirmation_url}" class="btn btn-success btn-lg">
            {l s='Continue to Order Confirmation' mod='mtnmomo'}
        </a>
    </div>
</div>

<script type="text/javascript">
    var checkStatusUrl = '{$status_url|escape:'javascript':'UTF-8'}';
    var checkInterval = 5000; // Check status every 5 seconds
    var maxAttempts = 24; // Check for 2 minutes max (5s * 24)
    var currentAttempt = 0;
    
    function checkPaymentStatus() {
        $.ajax({
            url: checkStatusUrl,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                currentAttempt++;
                
                if (response.success) {
                    // Update status message
                    $('#payment-status').html('<div class="alert alert-' + getAlertClass(response.status) + '">' + response.message + '</div>');
                    
                    // If payment completed, show continue button
                    if (response.status === 'SUCCESSFUL' || response.status === 'COMPLETED') {
                        $('#payment-actions').removeClass('hidden');
                        $('.waiting-animation').addClass('hidden');
                        // Auto-redirect after 3 seconds
                        setTimeout(function() {
                            window.location.href = '{$confirmation_url|escape:'javascript':'UTF-8'}';
                        }, 3000);
                        return; // Stop checking
                    }
                    
                    // If payment failed or was rejected, stop polling
                    if (response.status === 'FAILED' || response.status === 'REJECTED') {
                        $('.waiting-animation').addClass('hidden');
                        return;
                    }
                } else {
                    // Show error
                    $('#payment-status').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
                
                // Continue checking if we haven't reached max attempts
                if (currentAttempt < maxAttempts) {
                    setTimeout(checkPaymentStatus, checkInterval);
                } else {
                    // Max attempts reached, show timeout message
                    $('.waiting-animation').addClass('hidden');
                    $('#payment-status').html('<div class="alert alert-warning">{l s='The payment verification has timed out. If you completed the payment, it will be processed shortly.' mod='mtnmomo'}</div>');
                }
            },
            error: function() {
                // Show error message
                $('#payment-status').html('<div class="alert alert-danger">{l s='Error checking payment status. Please refresh the page to try again.' mod='mtnmomo'}</div>');
                $('.waiting-animation').addClass('hidden');
            }
        });
    }
    
    function getAlertClass(status) {
        switch(status) {
            case 'SUCCESSFUL':
            case 'COMPLETED':
                return 'success';
            case 'FAILED':
            case 'REJECTED':
                return 'danger';
            case 'PENDING':
                return 'warning';
            default:
                return 'info';
        }
    }
    
    // Start checking status when page loads
    $(document).ready(function() {
        setTimeout(checkPaymentStatus, 3000); // First check after 3 seconds
    });
</script>
{/block}