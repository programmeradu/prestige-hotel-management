{* filepath: c:\Users\sam\Downloads\prestashop-payment-module (2)\ghanapayments\generated module\views\templates\hook\payment_return_paystack.tpl *}
{if $status == 'ok'}
    <div class="alert alert-success">
        <h4>{l s='Your order has been placed successfully!' mod='ghanapayments'}</h4>
        <p>
            {l s='Your order reference is' mod='ghanapayments'} <strong>{$reference}</strong>
            <br />
            {l s='Your payment via Paystack has been confirmed.' mod='ghanapayments'}
        </p>
        <p>
            {l s='For any questions or information, please contact us' mod='ghanapayments'} <a href="{$contact_url}">{l s='here' mod='ghanapayments'}</a>.
        </p>
    </div>
{else}
    <div class="alert alert-warning">
        <h4>{l s='Your order is pending' mod='ghanapayments'}</h4>
        <p>
            {l s='Your order reference is' mod='ghanapayments'} <strong>{$reference}</strong>
            <br />
            {l s='There seems to be an issue with your payment.' mod='ghanapayments'}
        </p>
        <p>
            {l s='Please contact our customer service using' mod='ghanapayments'} <a href="{$contact_url}">{l s='this form' mod='ghanapayments'}</a>.
        </p>
    </div>
{/if}
