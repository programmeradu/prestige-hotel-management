<div class="paystack-payment">
    <div class="panel">
        <div class="panel-heading">
            <h3>{l s='Pay with Card or Mobile Money' mod='paystack'}</h3>
        </div>
        <div class="panel-body text-center">
            <img src="../modules/paystack/card-logos.png" alt="{l s='Pay with Card or Mobile Money' mod='paystack'}" style="max-width: 250px;"/>
            <br><br>
            <button type="button" class="btn btn-primary" id="start-payment-button">
                {l s='Pay Now' mod='paystack'}
            </button>
        </div>
    </div>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script type="text/javascript">
document.getElementById('start-payment-button').addEventListener('click', function() {
    var handler = PaystackPop.setup({
        key: '{$key|escape:'htmlall':'UTF-8'}',
        email: '{$email|escape:'htmlall':'UTF-8'}',
        amount: {$amount},
        currency: '{$currency|escape:'htmlall':'UTF-8'}',
        ref: '{$reference|escape:'htmlall':'UTF-8'}',
        callback: function(response) {
            window.location.href = '{$callback_url|escape:'htmlall':'UTF-8'}?reference=' + response.reference;
        },
        onClose: function() {
            window.location.href = '{$cancel_url|escape:'htmlall':'UTF-8'}';
        }
    });
    handler.openIframe();
});
