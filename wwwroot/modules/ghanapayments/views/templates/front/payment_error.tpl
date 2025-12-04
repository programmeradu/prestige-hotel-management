{* Payment error template *}
{extends file='page.tpl'}

{block name='page_content'}
    <div class="card">
        <div class="card-header">
            <h3>{l s='Payment Error' mod='ghanapayments'}</h3>
        </div>
        <div class="card-body">
            {if isset($errors) && $errors|count > 0}
                <div class="alert alert-danger">
                    <ul>
                        {foreach from=$errors item='error'}
                            <li>{$error}</li>
                        {/foreach}
                    </ul>
                </div>
            {/if}

            {if isset($transaction_ref)}
                <div class="alert alert-warning">
                    <p>{l s='Your transaction reference:' mod='ghanapayments'} <strong>{$transaction_ref}</strong></p>
                    <p>{l s='Please keep this reference for your records.' mod='ghanapayments'}</p>
                </div>
            {/if}
            
            <p>{l s='There was an error processing your payment.' mod='ghanapayments'}</p>
            <p>{l s='Please try again or contact our customer support for assistance.' mod='ghanapayments'}</p>
            
            <div class="mt-4">
                <a href="{$contact_url}" class="btn btn-outline-primary">{l s='Contact Support' mod='ghanapayments'}</a>
                <a href="{$link->getPageLink('order', true, null, ['step' => 3])|escape:'html':'UTF-8'}" class="btn btn-primary">{l s='Try Again' mod='ghanapayments'}</a>
            </div>
        </div>
    </div>
{/block}
