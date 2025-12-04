{*
* Ghana Payments Module
*
* Pay at Check-in Template
*}

{extends file='page.tpl'}

{block name='page_content'}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{l s='Pay at Check-in' mod='ghanapayments'}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="alert alert-info">
                    <p><strong>{l s='Pay when you arrive' mod='ghanapayments'}</strong></p>
                    <p>{l s='Your reservation will be confirmed without immediate payment.' mod='ghanapayments'}</p>
                    <p>{l s='You will need to pay the full amount when you arrive for check-in.' mod='ghanapayments'}</p>
                    <p>{l s='Please note that we accept cash, mobile money, and card payments at the property.' mod='ghanapayments'}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>{l s='Order Summary' mod='ghanapayments'}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>{l s='Total to pay at check-in:' mod='ghanapayments'}</strong> {displayPrice price=$total}</p>
                        <p><strong>{l s='Customer:' mod='ghanapayments'}</strong> {$customer_name|escape:'html':'UTF-8'}</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{$link->getModuleLink('ghanapayments', 'paycash', [], true)|escape:'html':'UTF-8'}" method="post" id="paycash_form">
            <div class="form-group">
                <label for="arrival_date">{l s='Expected Arrival Date' mod='ghanapayments'} <span class="required">*</span></label>
                <input type="date" name="arrival_date" id="arrival_date" class="form-control" required min="{$smarty.now|date_format:'%Y-%m-%d'}" />
            </div>
            
            <div class="form-group">
                <label for="additional_notes">{l s='Additional Notes' mod='ghanapayments'}</label>
                <textarea name="additional_notes" id="additional_notes" class="form-control" rows="3" placeholder="{l s='Any special requests or information about your arrival' mod='ghanapayments'}"></textarea>
            </div>
            
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="terms_agreement" name="terms_agreement" required>
                    <label class="custom-control-label" for="terms_agreement">{l s='I understand that I must pay the full amount upon arrival, and that failure to arrive or pay may result in cancellation of my reservation.' mod='ghanapayments'}</label>
                </div>
            </div>
            
            <div class="form-group text-center">
                <button type="submit" name="confirm_paycash" class="btn btn-primary">{l s='Confirm Reservation' mod='ghanapayments'}</button>
            </div>
        </form>
    </div>
</div>
{/block}
