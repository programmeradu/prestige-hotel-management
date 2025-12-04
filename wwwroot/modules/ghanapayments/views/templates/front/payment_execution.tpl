{*
* 2023-2025 StaNetwork
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
* @author    StaNetwork <contact@stanetwork.com>
* @copyright 2023-2025 StaNetwork
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

{capture name=path}
    {l s='Mobile Money Payment' mod='ghanapayments'}
{/capture}

{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='ghanapayments'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if isset($nbProducts) && $nbProducts <= 0}
    <p class="warning">{l s='Your shopping cart is empty.' mod='ghanapayments'}</p>
{else}
    <h3>{l s='Mobile Money Payment' mod='ghanapayments'}</h3>
    <form action="{$link->getModuleLink('ghanapayments', 'validation', ['method' => 'momo'], true)|escape:'html'}" method="post">
        <div class="box cheque-box">
            <h3 class="page-subheading">{l s='Mobile Money Payment Instructions' mod='ghanapayments'}</h3>
            <p>
                <strong>{l s='You have chosen to pay by Mobile Money.' mod='ghanapayments'}</strong>
            </p>
            <p>
                {l s='Here is a summary of your order:' mod='ghanapayments'}
            </p>
            <p>
                - {l s='The total amount of your order is' mod='ghanapayments'}
                <span id="amount" class="price">{displayPrice price=$total}</span>
                {if $use_taxes == 1}
                    {l s='(tax incl.)' mod='ghanapayments'}
                {/if}
            </p>
            <p>
                {l s='Please follow these steps to complete your payment:' mod='ghanapayments'}
            </p>
            <ol>
                <li>{l s='Send the exact amount to the following Mobile Money number:' mod='ghanapayments'} <strong>{$momo_number|escape:'html':'UTF-8'}</strong></li>
                <li>{$momo_instructions|escape:'html':'UTF-8'}</li>
                <li>{l s='After sending the payment, click the "I confirm my order" button below.' mod='ghanapayments'}</li>
            </ol>
        </div>
        <p class="cart_navigation clearfix">
            <a class="button-exclusive btn btn-default" href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}">
                <i class="icon-chevron-left"></i>{l s='Other payment methods' mod='ghanapayments'}
            </a>
            <button type="submit" class="button btn btn-default button-medium">
                <span>{l s='I confirm my order' mod='ghanapayments'}<i class="icon-chevron-right right"></i></span>
            </button>
        </p>
    </form>
{/if}
