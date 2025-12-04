{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="paystack-payment-intro">
    <p class="payment-description">
        {l s='Choose your preferred payment method:' d='Modules.Paystack.Shop'}
    </p>
    
    <div class="payment-methods">
        <div class="payment-method">
            <i class="material-icons">credit_card</i>
            <span>{l s='Card Payment' d='Modules.Paystack.Shop'}</span>
            <small>{l s='Pay securely with your debit or credit card' d='Modules.Paystack.Shop'}</small>
        </div>
        
        <div class="payment-method">
            <i class="material-icons">phone_android</i>
            <span>{l s='Mobile Money (Momo)' d='Modules.Paystack.Shop'}</span>
            <small>{l s='Pay easily using your mobile money account' d='Modules.Paystack.Shop'}</small>
        </div>
    </div>

    <div class="security-info">
        <i class="material-icons">security</i>
        <span>{l s='Secure Payment' d='Modules.Paystack.Shop'}</span>
        <small>{l s='Your payment information is securely encrypted' d='Modules.Paystack.Shop'}</small>
    </div>
</div>

<style type="text/css">
    .paystack-payment-intro {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .payment-description {
        font-size: 16px;
        color: #333;
        margin-bottom: 15px;
    }

    .payment-methods {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .payment-method {
        flex: 1;
        padding: 15px;
        background: white;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: #2fb5d2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .payment-method i {
        font-size: 24px;
        color: #2fb5d2;
        margin-right: 10px;
        vertical-align: middle;
    }

    .payment-method span {
        display: block;
        font-weight: 600;
        margin: 8px 0;
    }

    .payment-method small {
        display: block;
        color: #666;
        font-size: 13px;
    }

    .security-info {
        display: flex;
        align-items: center;
        padding: 10px;
        background: #e8f5e9;
        border-radius: 6px;
    }

    .security-info i {
        color: #4caf50;
        margin-right: 10px;
    }

    .security-info span {
        font-weight: 600;
        margin-right: 10px;
    }

    .security-info small {
        color: #666;
    }

    @media (max-width: 768px) {
        .payment-methods {
            flex-direction: column;
        }
        
        .payment-method {
            margin-bottom: 10px;
        }
    }
</style>