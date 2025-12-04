{* filepath: c:\xampp\htdocs\modules\mtnmomo\views\templates\front\phone_entry.tpl *}
{extends file='page.tpl'}

{block name='page_content'}
<div class="mtnmomo-phone-entry">
    <div class="card">
        <div class="card-header">
            <h1>{l s='MTN Mobile Money Payment' mod='mtnmomo'}</h1>
        </div>
        
        <div class="card-block">
            <form action="{$action}" method="post">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label required">
                        {l s='Mobile Phone Number' mod='mtnmomo'}
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">+233</span>
                            <input type="text" name="phone_number" class="form-control" required
                                   placeholder="{l s='e.g. 241234567' mod='mtnmomo'}">
                        </div>
                        <small class="form-text text-muted">
                            {l s='Enter your Ghana phone number connected to MTN Mobile Money.' mod='mtnmomo'}
                        </small>
                        
                        {if isset($error)}
                        <div class="alert alert-danger mt-2">
                            {$error}
                        </div>
                        {/if}
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary">
                            {l s='Continue to Payment' mod='mtnmomo'}
                        </button>
                        <a href="{$link->getPageLink('order', true, NULL, "step=3")}" class="btn btn-link">
                            {l s='Cancel and Return to Checkout' mod='mtnmomo'}
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-footer">
            <div class="mtnmomo-info">
                <img src="{$urls.base_url}modules/mtnmomo/views/img/mtnmomo.png" alt="MTN MoMo" height="40">
                <p>{l s='You will receive a prompt on your mobile phone to approve the payment.' mod='mtnmomo'}</p>
            </div>
        </div>
    </div>
</div>
{/block}