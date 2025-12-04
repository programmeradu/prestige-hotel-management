{* Mobile Money payment template *}
{extends file='page.tpl'}

{block name='page_content'}
    <div class="card">
        <div class="card-header">
            <h3>{l s='Pay with Mobile Money' mod='ghanapayments'}</h3>
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
            
            <div class="alert alert-info">
                {l s='Please send the payment to our mobile money number:' mod='ghanapayments'} <strong>{$momo_number}</strong>
                <br>
                {l s='Amount:' mod='ghanapayments'} <strong>{$total}</strong>
            </div>
            
            {if $momo_instructions}
                <div class="momo-instructions">
                    <p><strong>{l s='Instructions:' mod='ghanapayments'}</strong></p>
                    <p>{$momo_instructions|nl2br}</p>
                </div>
            {/if}

            <form action="{$form_action}" method="post" id="momo_confirmation_form" class="mt-3">
                <div class="form-group">
                    <label for="network">{l s='Select your network' mod='ghanapayments'}</label>
                    <select name="network" id="network" class="form-control">
                        <option value="">{l s='-- Please select --' mod='ghanapayments'}</option>
                        {foreach from=$networks key=code item=name}
                            <option value="{$code}">{$name}</option>
                        {/foreach}
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="phone">{l s='Your phone number (used for payment)' mod='ghanapayments'}</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="0XXXXXXXXX" />
                </div>
                
                <div class="form-group">
                    <label for="transaction_id">{l s='Transaction ID' mod='ghanapayments'}</label>
                    <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="{l s='e.g. GH123456789' mod='ghanapayments'}" />
                    <small class="form-text text-muted">{l s='After making the payment, enter the transaction ID here' mod='ghanapayments'}</small>
                </div>
                
                <button type="submit" name="submitMomoConfirmation" class="btn btn-primary btn-lg mt-3">
                    {l s='Confirm Payment' mod='ghanapayments'}
                </button>
            </form>
        </div>
    </div>
{/block}
