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
    <h3><i class="icon icon-life-ring"></i> {l s='Support & Documentation' mod='ghanapayments'}</h3>
    
    <div class="row">
        <div class="col-md-6">
            <h4>{l s='Documentation' mod='ghanapayments'}</h4>
            <p>{l s='For detailed information about this module, please read the documentation:' mod='ghanapayments'}</p>
            <ul>
                <li><a href="#" target="_blank">{l s='User Guide' mod='ghanapayments'}</a></li>
                <li><a href="#" target="_blank">{l s='Developer Documentation' mod='ghanapayments'}</a></li>
                <li><a href="#" target="_blank">{l s='FAQ' mod='ghanapayments'}</a></li>
            </ul>
            
            <h4>{l s='Mobile Money Integration' mod='ghanapayments'}</h4>
            <p>{l s='This module allows customers to pay using the following mobile money providers:' mod='ghanapayments'}</p>
            <ul>
                <li>{l s='MTN Mobile Money' mod='ghanapayments'}</li>
                <li>{l s='Vodafone Cash' mod='ghanapayments'}</li>
                <li>{l s='AirtelTigo Money' mod='ghanapayments'}</li>
            </ul>
        </div>
        
        <div class="col-md-6">
            <h4>{l s='Need Help?' mod='ghanapayments'}</h4>
            <p>{l s='If you need assistance with this module, please contact support:' mod='ghanapayments'}</p>
            <ul>
                <li>{l s='Email:' mod='ghanapayments'} <a href="mailto:support@stanetwork.com">support@stanetwork.com</a></li>
                <li>{l s='Phone:' mod='ghanapayments'} +233 XX XXX XXXX</li>
                <li>{l s='Support hours: Monday to Friday, 9am - 5pm GMT' mod='ghanapayments'}</li>
            </ul>
            
            <h4>{l s='Paystack Integration' mod='ghanapayments'}</h4>
            <p>{l s='For card payments, this module uses Paystack as the payment gateway:' mod='ghanapayments'}</p>
            <ul>
                <li>{l s='Supports Visa, Mastercard, and local bank cards' mod='ghanapayments'}</li>
                <li>{l s='Secure transactions with PCI compliance' mod='ghanapayments'}</li>
                <li>{l s='For help with Paystack, visit' mod='ghanapayments'} <a href="https://paystack.com/support" target="_blank">paystack.com/support</a></li>
            </ul>
        </div>
    </div>
    
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="alert alert-info">
                <p><i class="icon icon-info-circle"></i> {l s='Reminder: Always test your payment methods thoroughly before enabling them in your live store.' mod='ghanapayments'}</p>
            </div>
        </div>
    </div>
</div>

{*
* Ghana Payments Module
*
* Admin Template 3 - Troubleshooting
*}

<div class="panel ghanapayments-admin">
	<div class="panel-heading">
		<i class="icon icon-wrench"></i> {l s='Ghana Payments Module - Troubleshooting' mod='ghanapayments'}
	</div>
	
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<h3>{l s='Common Issues & Solutions' mod='ghanapayments'}</h3>
				
				<div class="alert alert-info">
					<h4>{l s='Mobile Money Payments Not Being Received' mod='ghanapayments'}</h4>
					<ul>
						<li>{l s='Check that your mobile money number is correctly entered in the module configuration' mod='ghanapayments'}</li>
						<li>{l s='Ensure your mobile money account is active and can receive payments' mod='ghanapayments'}</li>
						<li>{l s='Confirm with the customer that they sent the correct amount to the right number' mod='ghanapayments'}</li>
						<li>{l s='Verify the transaction ID provided by the customer with your mobile money provider' mod='ghanapayments'}</li>
					</ul>
				</div>
				
				<div class="alert alert-info">
					<h4>{l s='Paystack Integration Issues' mod='ghanapayments'}</h4>
					<ul>
						<li>{l s='Ensure you have entered the correct API keys in the module configuration' mod='ghanapayments'}</li>
						<li>{l s='Check that you\'re using test keys for testing and live keys for production' mod='ghanapayments'}</li>
						<li>{l s='Make sure your Paystack account is properly set up and verified' mod='ghanapayments'}</li>
						<li>{l s='For test mode, use the test cards provided in the Paystack documentation' mod='ghanapayments'}</li>
						<li>{l s='Check your PrestaShop and server error logs for any API-related errors' mod='ghanapayments'}</li>
					</ul>
				</div>
				
				<div class="alert alert-info">
					<h4>{l s='Module Not Appearing at Checkout' mod='ghanapayments'}</h4>
					<ul>
						<li>{l s='Ensure the module is installed and enabled' mod='ghanapayments'}</li>
						<li>{l s='Check that at least one payment method is enabled in the configuration' mod='ghanapayments'}</li>
						<li>{l s='Verify that the currency being used is supported (GHS or USD)' mod='ghanapayments'}</li>
						<li>{l s='Make sure the customer\'s country is allowed to use the payment methods' mod='ghanapayments'}</li>
						<li>{l s='Clear your browser cache and PrestaShop cache, then try again' mod='ghanapayments'}</li>
					</ul>
				</div>
			</div>
		</div>
		
		<hr>
		
		<div class="row">
			<div class="col-md-12">
				<h3>{l s='Testing the Module' mod='ghanapayments'}</h3>
				<p>{l s='To test the module properly, follow these steps:' mod='ghanapayments'}</p>
				
				<h4>{l s='Testing Mobile Money:' mod='ghanapayments'}</h4>
				<ol>
					<li>{l s='Set up the module with your actual mobile money number' mod='ghanapayments'}</li>
					<li>{l s='Place a test order and select Mobile Money payment' mod='ghanapayments'}</li>
					<li>{l s='Send a small amount (e.g., 1 GHS) to your mobile money number' mod='ghanapayments'}</li>
					<li>{l s='Submit the actual transaction ID on the confirmation page' mod='ghanapayments'}</li>
					<li>{l s='Verify the transaction in your mobile money account' mod='ghanapayments'}</li>
				</ol>
				
				<h4>{l s='Testing Paystack:' mod='ghanapayments'}</h4>
				<ol>
					<li>{l s='Set the module to test mode and enter your Paystack test keys' mod='ghanapayments'}</li>
					<li>{l s='Place a test order and select Paystack payment' mod='ghanapayments'}</li>
					<li>{l s='Use the test cards provided by Paystack (e.g., 4084 0840 8408 4081, any future date for expiry, any 3 digits for CVV)' mod='ghanapayments'}</li>
					<li>{l s='Complete the test payment and check that the order status is updated correctly' mod='ghanapayments'}</li>
					<li>{l s='Verify the transaction in your Paystack dashboard' mod='ghanapayments'}</li>
				</ol>
				
				<h4>{l s='Testing Pay at Check-in:' mod='ghanapayments'}</h4>
				<ol>
					<li>{l s='Enable the Pay at Check-in payment method in the module configuration' mod='ghanapayments'}</li>
					<li>{l s='Place a test order and select Pay at Check-in' mod='ghanapayments'}</li>
					<li>{l s='Enter an arrival date and submit the form' mod='ghanapayments'}</li>
					<li>{l s='Check that the order is created with the correct status' mod='ghanapayments'}</li>
					<li>{l s='Verify that the email sent to the customer contains the correct payment instructions' mod='ghanapayments'}</li>
				</ol>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-warning">
					<p>
						<strong>{l s='Still having issues?' mod='ghanapayments'}</strong><br>
						{l s='Contact our support team at' mod='ghanapayments'} <a href="mailto:support@stanetwork.com">support@stanetwork.com</a> 
						{l s='or visit' mod='ghanapayments'} <a href="https://stanetwork.com/support" target="_blank">stanetwork.com/support</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>