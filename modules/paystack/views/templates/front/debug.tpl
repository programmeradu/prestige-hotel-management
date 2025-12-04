{*
* Paystack payment module - Debug Template
*}

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Paystack Integration Debugger</h3>
    </div>
    <div class="panel-body">
        <div class="alert alert-info">
            This page helps you test if your Paystack integration is working correctly.
        </div>
        
        <h4>Configuration Status</h4>
        <ul>
            <li>Mode: <strong>{if $testMode}Test{else}Live{/if}</strong></li>
            <li>Public Key: <strong>{if $hasPublicKey}✓ Set{else}❌ Missing{/if}</strong></li>
            <li>Secret Key: <strong>{if $hasSecretKey}✓ Set{else}❌ Missing{/if}</strong></li>
        </ul>
        
        <h4>Test Payment</h4>
        <p>Click the button below to test the Paystack payment popup:</p>
        <button id="test-paystack-button" class="btn btn-primary">Test Paystack Payment</button>
        
        <div id="debug-output" class="well" style="margin-top: 20px; display: none;">
            <h4>Debug Output</h4>
            <pre id="debug-log"></pre>
        </div>
    </div>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var debugLog = document.getElementById('debug-log');
    var debugOutput = document.getElementById('debug-output');
    
    function log(message) {
        debugOutput.style.display = 'block';
        debugLog.textContent += "\n" + message;
    }
    
    document.getElementById('test-paystack-button').addEventListener('click', function() {
        log('Initializing Paystack payment...');
        
        var handler = PaystackPop.setup({
            key: '{$publicKey}',
            email: '{$email}',
            amount: 100 * 100, // Test with 100 units
            currency: '{$currency}',
            ref: 'debug_' + Math.floor(Math.random() * 1000000000 + 1),
            callback: function(response) {
                log('SUCCESS: Payment complete! Reference: ' + response.reference);
            },
            onClose: function() {
                log('Payment window closed');
            }
        });
        
        try {
            handler.openIframe();
            log('Paystack popup opened successfully');
        } catch (e) {
            log('ERROR: Failed to open Paystack popup: ' + e.message);
        }
    });
});
</script>
