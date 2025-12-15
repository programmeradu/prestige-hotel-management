{if $payment_options.cash.enabled}
<div class="row">
    <div class="col-xs-12">
        <p class="payment_module">
            <a class="cash" href="{$link->getModuleLink('ghanapayments', 'validation', ['method' => 'cash'], true)|escape:'html'}" title="{l s='Pay at Check-in' mod='ghanapayments'}">
                <div class="payment-icon-container">
                    <i class="icon-money"></i>
                </div>
                <div class="payment-text-container">
                    <span class="payment-title">{$payment_options.cash.title|escape:'html':'UTF-8'}</span>
                    <span class="payment-description">{$payment_options.cash.description|escape:'html':'UTF-8'}</span>
                </div>
            </a>
        </p>
    </div>
</div>
{/if}

{if $payment_options.momo.enabled}
<div class="row">
    <div class="col-xs-12">
        <p class="payment_module">
            <a class="momo ghanapayments-momo" href="{$link->getModuleLink('ghanapayments', 'validation', ['method' => 'momo'], true)|escape:'html'}" title="{l s='Pay with Mobile Money' mod='ghanapayments'}">
                <div class="payment-icon-container">
                    <i class="icon-mobile-phone"></i>
                </div>
                <div class="payment-text-container">
                    <span class="payment-title">{$payment_options.momo.title|escape:'html':'UTF-8'}</span>
                    <span class="payment-description">{$payment_options.momo.description|escape:'html':'UTF-8'}</span>
                </div>
                <div class="payment-badge-container">
                    <span class="badge badge-success">{l s='Instant' mod='ghanapayments'}</span>
                </div>
            </a>
        </p>
    </div>
</div>
{/if}
