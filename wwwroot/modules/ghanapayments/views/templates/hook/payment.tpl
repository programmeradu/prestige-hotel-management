{if $payment_options.cash.enabled}
<div class="row">
    <div class="col-xs-12">
        <p class="payment_module">
            <a class="cash" href="{$link->getModuleLink('ghanapayments', 'validation', ['method' => 'cash'], true)|escape:'html'}" title="{l s='Pay at Check-in' mod='ghanapayments'}">
                {$payment_options.cash.title|escape:'html':'UTF-8'}
                <span>{$payment_options.cash.description|escape:'html':'UTF-8'}</span>
            </a>
        </p>
    </div>
</div>
{/if}

{if $payment_options.momo.enabled}
<div class="row">
    <div class="col-xs-12">
        <p class="payment_module">
            <a class="momo" href="{$link->getModuleLink('ghanapayments', 'validation', ['method' => 'momo'], true)|escape:'html'}" title="{l s='Pay with Mobile Money' mod='ghanapayments'}">
                {$payment_options.momo.title|escape:'html':'UTF-8'}
                <span>{$payment_options.momo.description|escape:'html':'UTF-8'}</span>
            </a>
        </p>
    </div>
</div>

<style type="text/css">
    .payment_module .cash,
    .payment_module .momo {
        display: block;
        border: 1px solid #d6d4d4;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 10px;
        background: #fbfbfb;
        text-decoration: none;
    }
    
    .payment_module .cash:hover,
    .payment_module .momo:hover {
        background: #f6f6f6;
    }
    
    .payment_module a span {
        display: block;
        color: #777;
        font-size: 13px;
        margin-top: 5px;
    }
</style>
{/if}
