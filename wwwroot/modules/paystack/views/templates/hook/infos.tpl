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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2025 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="paystack-header">
    <img src="../modules/paystack/logo.png" alt="Paystack" height="60">
    <div class="paystack-header-content">
        <h2>{l s="Paystack Payment Gateway" d='Modules.Paystack.Admin'}</h2>
        <p>{l s="Accept secure payments via Paystack - Card, Mobile Money, Bank Transfer and USSD" d='Modules.Paystack.Admin'}</p>
    </div>
</div>

<div class="paystack-info">
    <h3>{l s="Key Features" d='Modules.Paystack.Admin'}</h3>
    <ul>
        <li>{l s="Seamless integration with PrestaShop 1.7+ and QloApps" d='Modules.Paystack.Admin'}</li>
        <li>{l s="Accept multiple payment methods: Cards, Mobile Money, Bank Transfers, and USSD" d='Modules.Paystack.Admin'}</li>
        <li>{l s="Secure checkout with PCI-DSS compliance" d='Modules.Paystack.Admin'}</li>
        <li>{l s="Real-time payment verification" d='Modules.Paystack.Admin'}</li>
        <li>{l s="Automatic order status updates" d='Modules.Paystack.Admin'}</li>
    </ul>
</div>

<div class="paystack-currencies">
    <h3>{l s="Supported Currencies" d='Modules.Paystack.Admin'}</h3>
    <ul>
        <li>NGN</li>
        <li>GHS</li>
        <li>ZAR</li>
        <li>USD</li>
        <li>XOF</li>
        <li>KES</li>
        <li>EGP</li>
        <li>UGX</li>
        <li>TZS</li>
        <li>RWF</li>
        <li>EUR</li>
        <li>GBP</li>
    </ul>
</div>

<div class="alert alert-info">
    <p><strong>{l s="Setup Instructions:" d='Modules.Paystack.Admin'}</strong></p>
    <ol>
        <li>{l s="Sign up for a Paystack account at" d='Modules.Paystack.Admin'} <a href="https://paystack.com" target="_blank">paystack.com</a></li>
        <li>{l s="Obtain your API keys from the Paystack Dashboard" d='Modules.Paystack.Admin'}</li>
        <li>{l s="Configure the module with your API keys below" d='Modules.Paystack.Admin'}</li>
        <li>{l s="Set your preferred mode (Test or Live)" d='Modules.Paystack.Admin'}</li>
    </ol>
    <p>{l s="If the client chooses to pay by Paystack, the order's status will change to 'Payment Successful'" d='Modules.Paystack.Admin'}</p>
</div>
