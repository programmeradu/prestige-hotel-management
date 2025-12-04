{*
* Paystack payment module
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
*  @author Paystack <support@paystack.com>
*  @copyright Paystack
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

{capture name=path}
    <a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}" title="{l s='Go back to the Checkout' mod='paystack'}">{l s='Checkout' mod='paystack'}</a>
    <span class="navigation-pipe">{$navigationPipe}</span>{l s='Paystack payment' mod='paystack'}
{/capture}

<h1 class="page-heading">
    {l s='Order summary' mod='paystack'}
</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./errors.tpl"}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
    <p class="alert alert-warning">
        {l s='Your shopping cart is empty.' mod='paystack'}
    </p>
{else}
    <div class="box cheque-box">
        <h3 class="page-subheading">
            {l s='Paystack Payment' mod='paystack'}
        </h3>
        <p class="cheque-indent">
            <strong class="dark">
                {l s='You have chosen to pay with Paystack.' mod='paystack'} {l s='Here is a short summary of your order:' mod='paystack'}
            </strong>
        </p>
        <p>
            - {l s='The total amount of your order is' mod='paystack'}
            <span id="amount" class="price">{displayPrice price=$total}</span>
            {if $use_taxes == 1}
                {l s='(tax incl.)' mod='paystack'}
            {/if}
        </p>
        <div id="paystack-checkout-summary">
            <img src="{$this_path_ssl}card-logos.png" alt="{l s='Pay with Card or Mobile Money' mod='paystack'}" style="max-width: 250px;"/>
        </div>
        <p>
            <strong>{l s='Please click the button below to pay securely with Paystack.' mod='paystack'}</strong>
        </p>
        <p class="cart_navigation clearfix" id="cart_navigation">
            <a class="btn" href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}">
                <i class="icon-chevron-left"></i>&nbsp;{l s='Other payment methods' mod='paystack'}
            </a>
            <button class="btn btn-default button button-medium pull-right" id="paystack-payment-button" type="button">
                <span>{l s='Pay Now with Paystack' mod='paystack'}&nbsp;<i class="icon-lock right"></i></span>
            </button>
        </p>
    </div>
{/if}

<script src="https://js.paystack.co/v1/inline.js"></script>
<script type="text/javascript">
// Ultra Simple direct implementation
document.getElementById('paystack-payment-button').onclick = function() {
    try {
        var paystackHandler = PaystackPop.setup({
            key: '{$key|escape:'javascript':'UTF-8'}',
            email: '{$email|escape:'javascript':'UTF-8'}',
            amount: {$amount},
            currency: '{$currency|escape:'javascript':'UTF-8'}',
            ref: '{$reference|escape:'javascript':'UTF-8'}',
            callback: function(response) {
                window.location.href = '{$callback_url|escape:'javascript':'UTF-8'}?reference=' + response.reference;
            },
            onClose: function() {
                document.getElementById('paystack-payment-button').innerHTML = '<span>{l s="Pay Now with Paystack" mod="paystack"} <i class="icon-lock right"></i></span>';
                document.getElementById('paystack-payment-button').disabled = false;
            }
        });
        
        document.getElementById('paystack-payment-button').innerHTML = '<span><i class="icon-spinner icon-spin"></i> {l s="Processing..." mod="paystack"}</span>';
        document.getElementById('paystack-payment-button').disabled = true;
        
        paystackHandler.openIframe();
    } catch (error) {
        alert('Error initializing payment: ' + error.message);
        document.getElementById('paystack-payment-button').innerHTML = '<span>{l s="Try Again" mod="paystack"}</span>';
    }
    
    return false;
};
</script>
