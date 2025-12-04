{**
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

<div style="margin-top: 20px; padding: 15px; border: 1px solid #ddd; background: #f8f8f8;">
    <h3 style="color: #333; margin-bottom: 15px;">{l s='Mobile Money Payment Instructions' mod='ghanapayments'}</h3>
    
    <p>{l s='Please follow these steps to complete your payment:' mod='ghanapayments'}</p>
    
    <ol style="margin-left: 20px;">
        <li>{l s='Send payment to this Mobile Money number:' mod='ghanapayments'} <strong>{$momo_number}</strong></li>
        <li>{l s='Use your order reference' mod='ghanapayments'} <strong>{$order_reference}</strong> {l s='as payment description' mod='ghanapayments'}</li>
        <li>{l s='After sending payment, keep your transaction ID safe' mod='ghanapayments'}</li>
    </ol>
    
    <p style="margin-top: 15px; color: #666;">
        {l s='Note: Your order will be processed once we verify your payment. This usually takes a few minutes.' mod='ghanapayments'}
    </p>
    
    <p style="color: #666;">
        {l s='Payment must be completed within' mod='ghanapayments'} <strong>{$timeout_hours}</strong> {l s='hours' mod='ghanapayments'}
    </p>
</div>
