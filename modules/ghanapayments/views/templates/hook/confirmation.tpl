{*
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{*
* Ghana Payments Module
*
* Payment Confirmation Template
*}

<div class="box">
    <h3>{l s='Order summary' mod='ghanapayments'}</h3>
    
    {if $params.objOrder->module == 'ghanapayments' && strpos($params.objOrder->payment, 'Mobile Money') !== false}
        <h4 class="alert alert-warning">{l s='Your order is awaiting Mobile Money payment confirmation' mod='ghanapayments'}</h4>
        
        {if isset($smarty.get.transaction_id)}
            <div class="alert alert-success">
                <p>{l s='Thank you! Your Mobile Money transaction has been submitted.' mod='ghanapayments'}</p>
                <p>{l s='Transaction ID:' mod='ghanapayments'} <strong>{$smarty.get.transaction_id|escape:'html':'UTF-8'}</strong></p>
                <p>{l s='We will verify your payment and update your order shortly.' mod='ghanapayments'}</p>
            </div>
        {else}
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="alert alert-info">
                        <p><strong>{l s='Please complete your Mobile Money payment:' mod='ghanapayments'}</strong></p>
                        <ol>
                            <li>{l s='Send' mod='ghanapayments'} <strong>{displayPrice price=$params.total_to_pay}</strong> {l s='to our number:' mod='ghanapayments'} <strong>{Configuration::get('GHANAPAYMENTS_MOMO_NUMBER')}</strong></li>
                            <li>{l s='Use your order reference' mod='ghanapayments'} <strong>{$reference}</strong> {l s='as payment description' mod='ghanapayments'}</li>
                            <li>{l s='After payment, enter your transaction ID below' mod='ghanapayments'}</li>
                        </ol>
                    </div>
                    
                    <form action="{$link->getModuleLink('ghanapayments', 'validation', ['source' => 'mobilemoney'], true)|escape:'html':'UTF-8'}" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="transaction_id" class="control-label">{l s='Enter Mobile Money Transaction ID' mod='ghanapayments'}</label>
                            <input type="text" name="transaction_id" id="transaction_id" class="form-control" required placeholder="{l s='e.g. 1234567890' mod='ghanapayments'}" />
                        </div>
                        
                        <div class="form-group">
                            <label for="network" class="control-label">{l s='Mobile Money Network Used' mod='ghanapayments'}</label>
                            <select name="network" id="network" class="form-control" required>
                                <option value="">{l s='-- Select network --' mod='ghanapayments'}</option>
                                <option value="MTN">{l s='MTN Mobile Money' mod='ghanapayments'}</option>
                                <option value="VODAFONE">{l s='Vodafone Cash' mod='ghanapayments'}</option>
                                <option value="AIRTELTIGO">{l s='AirtelTigo Money' mod='ghanapayments'}</option>
                            </select>
                        </div>
                        
                        <input type="hidden" name="cart_id" value="{$params.objOrder->id_cart}" />
                        
                        <button type="submit" class="btn btn-primary">{l s='Submit Transaction ID' mod='ghanapayments'}</button>
                    </form>
                </div>
                
                <div class="col-xs-12 col-md-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{l s='Order Details' mod='ghanapayments'}</h3>
                        </div>
                        <div class="panel-body">
                            <p><strong>{l s='Order Reference:' mod='ghanapayments'}</strong> {$reference}</p>
                            <p><strong>{l s='Total:' mod='ghanapayments'}</strong> {$total}</p>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
        
    {elseif $params.objOrder->module == 'ghanapayments' && strpos($params.objOrder->payment, 'Card (Paystack)') !== false}
        <h4 class="alert alert-success">{l s='Your payment via Paystack has been confirmed!' mod='ghanapayments'}</h4>
        <p>{l s='Your order has been processed and will be shipped soon.' mod='ghanapayments'}</p>
        
    {elseif $params.objOrder->module == 'ghanapayments' && strpos($params.objOrder->payment, 'Pay at Check-in') !== false}
        <h4 class="alert alert-success">{l s='Your reservation has been confirmed!' mod='ghanapayments'}</h4>
        <div class="alert alert-info">
            <p><strong>{l s='Important information:' mod='ghanapayments'}</strong></p>
            <p>{l s='You have chosen to pay at check-in. Please bring the total amount of' mod='ghanapayments'} <strong>{$total}</strong> {l s='when you arrive.' mod='ghanapayments'}</p>
            <p>{l s='We accept cash, mobile money, and card payments at the property.' mod='ghanapayments'}</p>
            <p>{l s='Please use your order reference' mod='ghanapayments'} <strong>{$reference}</strong> {l s='when you arrive.' mod='ghanapayments'}</p>
        </div>
        
    {/if}
    
    <p>
        {l s='If you have questions, comments or concerns, please contact our' mod='ghanapayments'} <a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='customer support team' mod='ghanapayments'}</a>.
    </p>
</div>