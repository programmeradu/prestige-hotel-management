{*
* Paystack Payment Module
* For PrestaShop 1.7+ and QloApps
*}
{if isset($gateway_chosen) && $gateway_chosen == 'paystack'}

<form name="custompaymentmethod" id="paystack_form" method="post" action="{$form_url}">
  <input type="hidden" name="currency_payment" value="{$currencies.0.id_currency}" />
  <input type="hidden" name="amounttotal" value="{$total_amount}" />
  <input type="hidden" name="email" value="{$email}" />
  <input type="hidden" name="reference" value="{$reference}" />
</form>

<div class="paystack-loading">
  <div class="spinner"></div>
  <p>{l s='Initializing secure payment...' d='Modules.Paystack.Shop'}</p>
</div>

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('payment-confirmation');
    if (paymentForm) {
      paymentForm.style.display = 'none';
    }
    
    const handler = PaystackPop.setup({
      key: '{$key}',
      email: '{$email}',
      amount: '{$total_amount}',
      ref: '{$reference}',
      currency: '{$currency}',
      channels: ['card', 'mobile_money', 'bank', 'ussd'],
      metadata: {
        "custom_fields": [
          {
            "display_name": "Plugin",
            "variable_name": "plugin",
            "value": 'presta-1.7'
          }
        ]
      },
      callback: function(response) {
        document.getElementById("paystack_form").submit();
      },
      onClose: function() {
        window.location = '{$back_url}';
      }
    });
    
    setTimeout(function() {
      handler.openIframe();
    }, 1000);
  });
</script>

<style>
  .paystack-loading {
    text-align: center;
    padding: 30px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 20px;
  }
  
  .spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border-left-color: #00c3f7;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
{/if}
