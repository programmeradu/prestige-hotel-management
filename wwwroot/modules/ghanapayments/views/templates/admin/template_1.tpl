{*
* Ghana Payments Module
*
* Admin Template 1 - General Settings
*}

<div class="panel ghanapayments-admin">
	<div class="panel-heading">
		<i class="icon icon-credit-card"></i> {l s='Ghana Payments Module - General Settings' mod='ghanapayments'}
	</div>
	
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<div class="alert alert-info">
					<p>{l s='This module allows you to accept payments in Ghana via:' mod='ghanapayments'}</p>
					<ul>
						<li>{l s='Mobile Money (MTN, Vodafone, AirtelTigo)' mod='ghanapayments'}</li>
						<li>{l s='Pay at Check-in (for hotel bookings)' mod='ghanapayments'}</li>
						<li>{l s='Credit/Debit Cards via Paystack' mod='ghanapayments'}</li>
					</ul>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="alert alert-warning">
					<h4>{l s='Important Information' mod='ghanapayments'}</h4>
					<p>
						{l s='To enable Paystack payments, you must create an account on' mod='ghanapayments'} 
						<a href="https://paystack.com" target="_blank">Paystack.com</a>
					</p>
					<p>
						{l s='Get your API keys from your Paystack dashboard and enter them in the module configuration.' mod='ghanapayments'}
					</p>
					<p>
						{l s='For Mobile Money payments, ensure you have a registered Mobile Money merchant account.' mod='ghanapayments'}
					</p>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<h3>{l s='Getting Started' mod='ghanapayments'}</h3>
				<ol>
					<li>{l s='Set up your payment preferences in the configuration tab' mod='ghanapayments'}</li>
					<li>{l s='Configure which payment methods you want to enable' mod='ghanapayments'}</li>
					<li>{l s='For Paystack, enter your API keys (test keys for testing, live keys for production)' mod='ghanapayments'}</li>
					<li>{l s='For Mobile Money, enter your registered Mobile Money number' mod='ghanapayments'}</li>
					<li>{l s='Save your settings and start accepting payments' mod='ghanapayments'}</li>
				</ol>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success">
					<p>
						{l s='Need help? Contact us at' mod='ghanapayments'} 
						<a href="mailto:support@stanetwork.com">support@stanetwork.com</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
