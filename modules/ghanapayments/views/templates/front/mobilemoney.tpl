{*
* Ghana Payments Module
*
* Mobile Money Payment Template
*}

{extends file='page.tpl'}

{block name='page_content'}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{l s='Pay with Mobile Money' mod='ghanapayments'}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="alert alert-info">
                    <p><strong>{l s='Follow these steps to complete payment:' mod='ghanapayments'}</strong></p>
                    <ol>
                        <li>{l s='Select your mobile money network below' mod='ghanapayments'}</li>
                        <li>{l s='Enter your mobile phone number' mod='ghanapayments'}</li>
                        <li>{l s='Click "Confirm Order" to receive details' mod='ghanapayments'}</li>
                        <li>{l s='Send' mod='ghanapayments'} <strong>{displayPrice price=$total}</strong> {l s='to our number:' mod='ghanapayments'} <strong>{$momo_number|escape:'html':'UTF-8'}</strong></li>
                        <li>{l s='Use your order reference as payment description' mod='ghanapayments'}</li>
                        <li>{l s='After payment, you will receive a transaction ID' mod='ghanapayments'}</li>
                        <li>{l s='Submit your transaction ID on the next page' mod='ghanapayments'}</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>{l s='Order Summary' mod='ghanapayments'}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>{l s='Total to pay:' mod='ghanapayments'}</strong> {displayPrice price=$total}</p>
                        <p><strong>{l s='Customer:' mod='ghanapayments'}</strong> {$customer_name|escape:'html':'UTF-8'}</p>
                        <p><strong>{l s='Reference:' mod='ghanapayments'}</strong> {$reference|escape:'html':'UTF-8'}</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{$link->getModuleLink('ghanapayments', 'mobilemoney', [], true)|escape:'html':'UTF-8'}" method="post" id="mobilemoney_form">
            <div class="form-group">
                <label for="momo_network">{l s='Select Network' mod='ghanapayments'} <span class="required">*</span></label>
                <select name="momo_network" id="momo_network" class="form-control" required>
                    <option value="">{l s='-- Select your mobile money network --' mod='ghanapayments'}</option>
                    <option value="MTN">{l s='MTN Mobile Money' mod='ghanapayments'}</option>
                    <option value="VODAFONE">{l s='Vodafone Cash' mod='ghanapayments'}</option>
                    <option value="AIRTELTIGO">{l s='AirtelTigo Money' mod='ghanapayments'}</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="momo_phone">{l s='Mobile Phone Number' mod='ghanapayments'} <span class="required">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">+233</span>
                    </div>
                    <input type="text" name="momo_phone" id="momo_phone" class="form-control" required pattern="[0-9]{9}" placeholder="Example: 501234567" />
                </div>
                <small class="form-text text-muted">{l s='Enter your 9-digit mobile number without the country code' mod='ghanapayments'}</small>
            </div>
            
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="terms_agreement" name="terms_agreement" required>
                    <label class="custom-control-label" for="terms_agreement">{l s='I agree to submit my mobile money payment within 24 hours' mod='ghanapayments'}</label>
                </div>
            </div>
            
            <div class="form-group text-center">
                <button type="submit" name="submit_mobilemoney" class="btn btn-primary">{l s='Confirm Order' mod='ghanapayments'}</button>
            </div>
        </form>
    </div>
</div>
{/block}
