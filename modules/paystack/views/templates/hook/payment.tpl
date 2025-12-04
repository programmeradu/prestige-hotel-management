{*
* Paystack payment module
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
*  @author Paystack <support@paystack.com>
*  @copyright Paystack
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

<p class="payment_module">
	<a class="paystack automated-payment" href="{$link->getModuleLink('paystack', 'directpayment')|escape:'html'}" title="{l s='Pay instantly with Paystack' mod='paystack'}">
		<img src="{$this_path_bw}logo.png" alt="{l s='Pay with Paystack' mod='paystack'}" style="max-width: 52px; vertical-align: middle; margin-right: 10px;"/>
		{l s='Instant Online Payment' mod='paystack'}&nbsp;<span>{l s='(Card, Mobile Money, Bank Transfer)' mod='paystack'}</span>
		<small class="automated-tag">{l s='Instant - Automated' mod='paystack'}</small>
	</a>
</p>

<style type="text/css">
/* Styling for Paystack payment option */
.payment_module a.automated-payment {
    display: flex;
    align-items: center;
    position: relative;
    padding: 15px 10px;
    min-height: 20px;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.payment_module a.automated-payment:hover {
    background-color: #d0e9c6;
}

.payment_module a.automated-payment img {
    max-width: 50px;
    height: auto;
    display: inline-block;
}

.payment_module a.automated-payment span {
    font-size: 12px;
    color: #777;
}

.automated-tag {
    position: absolute;
    right: 15px;
    background: #5cb85c;
    color: white;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: bold;
}

/* For responsive behavior */
@media (max-width: 768px) {
    .payment_module a.automated-payment {
        padding: 10px;
    }
    .payment_module a.automated-payment img {
        max-width: 40px;
    }
    .automated-tag {
        position: static;
        display: block;
        margin-top: 8px;
        width: fit-content;
    }
}
</style>
