{*
* Ghana Payments Module
*
* Paystack Payment Template
*}

{extends file='page.tpl'}

{block name='page_content'}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{l s='Pay with Card via Paystack' mod='ghanapayments'}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="alert alert-info">
                    <p><strong>{l s='Secure Card Payment with Paystack' mod='ghanapayments'}</strong></p>
                    <p>{l s='Click the Pay Now button below to complete your payment securely.' mod='ghanapayments'}</p>
                    <p>{l s='You will be redirected to Paystack secure payment gateway.' mod='ghanapayments'}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>{l s='Order Summary' mod='ghanapayments'}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>{l s='Total to pay:' mod='ghanapayments'}</strong> {displayPrice price=$total}</p>
                        <p><strong>{l s='Email:' mod='ghanapayments'}</strong> {$email|escape:'html':'UTF-8'}</p>
                        <p><strong>{l s='Reference:' mod='ghanapayments'}</strong> {$reference|escape:'html':'UTF-8'}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button type="button" id="paystack-payment-button" class="btn btn-primary btn-lg">{l s='Pay Now' mod='ghanapayments'} - {displayPrice price=$total}</button>
        </div>

        <div class="text-center mt-3">
            <img src="{$this_path}views/img/supported-cards.png" alt="Supported Cards" />
        </div>
    </div>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('paystack-payment-button').addEventListener('click', function(e) {
            e.preventDefault();
            
            var handler = PaystackPop.setup({
                key: '{$public_key|escape:'html':'UTF-8'}',
                email: '{$email|escape:'html':'UTF-8'}',
                amount: {$amount_kobo},
                currency: '{$currency_code|escape:'html':'UTF-8'}',
                ref: '{$reference|escape:'html':'UTF-8'}',
                metadata: {
                    cart_id: '{$cart->id}',
                },
                callback: function(response) {
                    window.location.href = '{$link->getModuleLink('ghanapayments', 'validation', ['source' => 'paystack', 'reference' => $reference], true)|escape:'javascript':'UTF-8'}';
                },
                onClose: function() {
                    alert('{l s='Transaction was not completed, window closed.' mod='ghanapayments'}');
                }
            });
            handler.openIframe();
        });
    });
</script>
{/block}
