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

{if $status == 'ok'}
    <div class="box order-confirmation">
        <h3 class="page-subheading">{l s='Your order has been processed successfully!' mod='paystack'}</h3>
        <p>
            <strong>{l s='Your order reference is:' mod='paystack'} <span class="reference">{$reference}</span></strong>
        </p>
        <p>
            {l s='We received your payment of' mod='paystack'} <span class="price">{$total}</span>
        </p>
        <p>
            {l s='An email has been sent to you with this information.' mod='paystack'}
        </p>
        <p>
            {l s='If you have any questions, please contact our' mod='paystack'} <a href="{$contact_url}">{l s='customer service department' mod='paystack'}</a>.
        </p>
    </div>
{else}
    <div class="box order-confirmation">
        <h3 class="page-subheading">{l s='Your order has NOT been processed.' mod='paystack'}</h3>
        <p>
            {l s='There was an error processing your payment.' mod='paystack'}
        </p>
        <p>
            {l s='Please contact our' mod='paystack'} <a href="{$contact_url}">{l s='customer service department' mod='paystack'}</a>.
        </p>
    </div>
{/if}

<style type="text/css">
.box.order-confirmation {
    background: #f5f5f5;
    border-radius: 4px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 5px solid #4caf50;
}
.reference {
    font-weight: bold;
    color: #4caf50;
}
.price {
    font-weight: bold;
}
</style>
