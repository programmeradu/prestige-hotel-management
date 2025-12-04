{*
* 2007-2024 PrestaShop
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
*  @copyright  2007-2024 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{*
* Paystack payment module
* Order Confirmation Template
*}

{if $status == 'ok'}
    <div class="box order-confirmation">
        <h3 class="page-subheading">{l s='Paystack Payment Confirmation' mod='paystack'}</h3>
        <p>
            {l s='Your payment with Paystack was processed successfully.' mod='paystack'}
        </p>
        <p>
            {l s='Order Reference:' mod='paystack'} <strong>{$reference}</strong>
        </p>
        <p>
            {l s='Thank you for your purchase at' mod='paystack'} <strong>{$shop_name}</strong>
        </p>
        <p>
            {l s='Payment Amount:' mod='paystack'} <strong>{$total}</strong>
        </p>
        <p>
            {l s='A confirmation email has been sent with your order details.' mod='paystack'}
        </p>
    </div>
{else}
    <div class="box order-confirmation">
        <h3 class="page-subheading">{l s='Your order has NOT been processed.' mod='paystack'}</h3>
        <p>
            {l s='There was an error processing your payment.' mod='paystack'}
        </p>
        <p>
            {l s='Please contact our' mod='paystack'} <a href="{$contact_url}">{l s='customer service department' mod='paystack'}</a>.
        </p>
    </div>
{/if}

<style type="text/css">
.box.order-confirmation {
    background: #f5f5f5;
    border-radius: 4px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 5px solid #4caf50;
}
.reference {
    font-weight: bold;
    color: #4caf50;
}
.price {
    font-weight: bold;
}
</style>
