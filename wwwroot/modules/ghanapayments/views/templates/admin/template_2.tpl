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

<div class="panel">
	<div class="row ghanapayments-header">
		<img src="{$module_dir|escape:'html':'UTF-8'}views/img/template_2_logo.png" class="col-xs-6 col-md-3 text-center" id="payment-logo" />
		<div class="col-xs-6 col-md-6 text-center text-muted">
			{l s='My Payment Module and PrestaShop have partnered to provide the easiest way for you to accurately calculate and file sales tax.' mod='ghanapayments'}
		</div>
		<div class="col-xs-12 col-md-3 text-center">
			<a href="#" onclick="javascript:return false;" class="btn btn-primary" id="create-account-btn">{l s='Create an account' mod='ghanapayments'}</a><br />
			{l s='Already have one?' mod='ghanapayments'}<a href="#" onclick="javascript:return false;"> {l s='Log in' mod='ghanapayments'}</a>
		</div>
	</div>

	<hr />
	
	<div class="ghanapayments-content">
		<div class="row">
			<div class="col-md-5">
				<h5>{l s='Benefits of using my payment module' mod='ghanapayments'}</h5>
				<ul class="ul-spaced">
					<li>
						<strong>{l s='It is fast and easy' mod='ghanapayments'}:</strong>
						{l s='It is pre-integrated with PrestaShop, so you can configure it with a few clicks.' mod='ghanapayments'}
					</li>
					
					<li>
						<strong>{l s='It is global' mod='ghanapayments'}:</strong>
						{l s='Accept payments in XX currencies from XXX markets around the world.' mod='ghanapayments'}
					</li>
					
					<li>
						<strong>{l s='It is trusted' mod='ghanapayments'}:</strong>
						{l s='Industry-leading fraud an buyer protections keep you and your customers safe.' mod='ghanapayments'}
					</li>
					
					<li>
						<strong>{l s='It is cost-effective' mod='ghanapayments'}:</strong>
						{l s='There are no setup fees or long-term contracts. You only pay a low transaction fee.' mod='ghanapayments'}
					</li>
				</ul>
			</div>
			
			<div class="col-md-2">
				<h5>{l s='Pricing' mod='ghanapayments'}</h5>
				<dl class="list-unstyled">
					<dt>{l s='Payment Standard' mod='ghanapayments'}</dt>
					<dd>{l s='No monthly fee' mod='ghanapayments'}</dd>
					<dt>{l s='Payment Express' mod='ghanapayments'}</dt>
					<dd>{l s='No monthly fee' mod='ghanapayments'}</dd>
					<dt>{l s='Payment Pro' mod='ghanapayments'}</dt>
					<dd>{l s='$5 per month' mod='ghanapayments'}</dd>
				</dl>
				<a href="#" onclick="javascript:return false;">(Detailed pricing here)</a>
			</div>
			
			<div class="col-md-5">
				<h5>{l s='How does it work?' mod='ghanapayments'}</h5>
				<iframe src="//player.vimeo.com/video/75405291" width="335" height="188" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
		</div>

		<hr />
		
		<div class="row">
			<div class="col-md-12">
				<p class="text-muted">{l s='My Payment Module accepts more than 80 localized payment methods around the world' mod='ghanapayments'}</p>
				
				<div class="row">
					<img src="{$module_dir|escape:'html':'UTF-8'}views/img/template_2_cards.png" class="col-md-3" id="payment-logo" />
					<div class="col-md-9 text-center">
						<h6>{l s='For more information, call 888-888-1234' mod='ghanapayments'} {l s='or' mod='ghanapayments'} <a href="mailto:contact@prestashop.com">contact@prestashop.com</a></h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="panel">
	<p class="text-muted">
		<i class="icon icon-info-circle"></i> {l s='In order to create a secure account with My Payment Module, please complete the fields in the settings panel below:' mod='ghanapayments'}
		{l s='By clicking the "Save" button you are creating secure connection details to your store.' mod='ghanapayments'}
		{l s='My Payment Module signup only begins when you client on "Activate your account" in the registration panel below.' mod='ghanapayments'}
		{l s='If you already have an account you can create a new shop within your account.' mod='ghanapayments'}
	</p>
	<p>
		<a href="#" onclick="javascript:return false;"><i class="icon icon-file"></i> Link to the documentation</a>
	</p>
</div>

<div class="panel">
    <h3><i class="icon icon-cogs"></i> {l s='Configuration Guide' mod='ghanapayments'}</h3>
    
    <div class="alert alert-info">
        <p>{l s='Follow these steps to configure your Ghana Payments module:' mod='ghanapayments'}</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>{l s='Step 1: Activate Payment Methods' mod='ghanapayments'}</h4>
            <p>{l s='Enable the payment methods you want to offer to your customers by toggling the switches in the settings panel.' mod='ghanapayments'}</p>
            
            <h4>{l s='Step 2: Configure Mobile Money' mod='ghanapayments'}</h4>
            <ul>
                <li>{l s='Enter your Mobile Money number where you want to receive payments' mod='ghanapayments'}</li>
                <li>{l s='Customize payment instructions for your customers' mod='ghanapayments'}</li>
                <li>{l s='Set a timeout period (in hours) after which unpaid orders will be canceled' mod='ghanapayments'}</li>
            </ul>
            
            <h4>{l s='Step 3: Configure Paystack' mod='ghanapayments'}</h4>
            <p>{l s='If you want to accept card payments:' mod='ghanapayments'}</p>
            <ol>
                <li>{l s='Sign up for a Paystack account at' mod='ghanapayments'} <a href="https://paystack.com/" target="_blank">paystack.com</a></li>
                <li>{l s='Get your API keys from your Paystack dashboard' mod='ghanapayments'}</li>
                <li>{l s='Enter your Test and Live API keys in the module settings' mod='ghanapayments'}</li>
                <li>{l s='Toggle between Test and Live mode when you\'re ready to accept real payments' mod='ghanapayments'}</li>
            </ol>
            
            <h4>{l s='Step 4: Test Your Payment Methods' mod='ghanapayments'}</h4>
            <p>{l s='Before going live, place test orders to ensure everything is working correctly.' mod='ghanapayments'}</p>
        </div>
    </div>
</div>

{*
* Ghana Payments Module
*
* Admin Template 2 - Payment Documentation
*}

<div class="panel ghanapayments-admin">
	<div class="panel-heading">
		<i class="icon icon-book"></i> {l s='Ghana Payments Module - Documentation' mod='ghanapayments'}
	</div>
	
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<h3>{l s='Mobile Money Payment Process' mod='ghanapayments'}</h3>
				<ol>
					<li>{l s='Customer selects Mobile Money payment option at checkout' mod='ghanapayments'}</li>
					<li>{l s='Customer enters their mobile network and phone number' mod='ghanapayments'}</li>
					<li>{l s='An order is created with status "Awaiting Mobile Money Payment"' mod='ghanapayments'}</li>
					<li>{l s='Customer receives payment instructions by email' mod='ghanapayments'}</li>
					<li>{l s='Customer sends payment to your Mobile Money number using their mobile money service' mod='ghanapayments'}</li>
					<li>{l s='Customer submits the transaction ID on the order confirmation page' mod='ghanapayments'}</li>
					<li>{l s='You verify the payment and update the order status manually' mod='ghanapayments'}</li>
				</ol>
				
				<div class="alert alert-info">
					<p><strong>{l s='Note:' mod='ghanapayments'}</strong> {l s='This process requires manual verification of Mobile Money payments. You should check your mobile money account to confirm receipt of payment before updating the order status.' mod='ghanapayments'}</p>
				</div>
			</div>
		</div>
		
		<hr>
		
		<div class="row">
			<div class="col-md-12">
				<h3>{l s='Paystack Payment Process' mod='ghanapayments'}</h3>
				<ol>
					<li>{l s='Customer selects Paystack payment option at checkout' mod='ghanapayments'}</li>
					<li>{l s='Customer is presented with the Paystack payment popup' mod='ghanapayments'}</li>
					<li>{l s='Customer enters their card details directly in the secure Paystack form' mod='ghanapayments'}</li>
					<li>{l s='Payment is processed immediately by Paystack' mod='ghanapayments'}</li>
					<li>{l s='If payment is successful, order is created with status "Payment accepted"' mod='ghanapayments'}</li>
					<li>{l s='Customer sees order confirmation page' mod='ghanapayments'}</li>
				</ol>
				
				<div class="alert alert-info">
					<p><strong>{l s='Note:' mod='ghanapayments'}</strong> {l s='Paystack payments are fully automated and do not require manual verification.' mod='ghanapayments'}</p>
				</div>
			</div>
		</div>
		
		<hr>
		
		<div class="row">
			<div class="col-md-12">
				<h3>{l s='Pay at Check-in Process (for hotels)' mod='ghanapayments'}</h3>
				<ol>
					<li>{l s='Customer selects Pay at Check-in option at checkout' mod='ghanapayments'}</li>
					<li>{l s='Customer enters their expected arrival date and any notes' mod='ghanapayments'}</li>
					<li>{l s='An order is created with status "Awaiting Check-in Payment"' mod='ghanapayments'}</li>
					<li>{l s='Customer receives reservation confirmation by email' mod='ghanapayments'}</li>
					<li>{l s='Customer pays the full amount upon arrival at the property' mod='ghanapayments'}</li>
					<li>{l s='Once payment is received at check-in, update the order status manually' mod='ghanapayments'}</li>
				</ol>
				
				<div class="alert alert-warning">
					<p><strong>{l s='Important:' mod='ghanapayments'}</strong> {l s='This payment method should only be used for hotel or accommodation bookings where payment at check-in is a standard option.' mod='ghanapayments'}</p>
				</div>
			</div>
		</div>
	</div>
</div>