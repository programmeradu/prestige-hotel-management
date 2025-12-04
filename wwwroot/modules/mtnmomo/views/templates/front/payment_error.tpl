{* filepath: c:\xampp\htdocs\modules\mtnmomo\views\templates\front\payment_error.tpl *}
{extends file='page.tpl'}

{block name='page_content'}
<div class="mtnmomo-payment-error">
    <div class="alert alert-danger">
        <h4>{l s='Payment Error' mod='mtnmomo'}</h4>
        <p>{$error}</p>
    </div>
    
    <div class="payment-actions">
        <a href="{$return_url}" class="btn btn-primary">
            {l s='Return to Checkout' mod='mtnmomo'}
        </a>
    </div>
</div>
{/block}