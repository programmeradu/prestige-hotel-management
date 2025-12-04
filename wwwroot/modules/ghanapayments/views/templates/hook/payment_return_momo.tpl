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

<section>
  <h3>{l s='Your booking is confirmed' mod='ghanapayments'}</h3>
  <p>{l s='Thank you for your reservation!' mod='ghanapayments'}</p>
  
  <p>
    {l s='Your booking reference is' mod='ghanapayments'} <strong>{$reference}</strong>.
  </p>
  
  <div class="alert alert-info">
    <p>{l s='We have received your Mobile Money payment details and are verifying the transaction.' mod='ghanapayments'}</p>
    <p>{l s='Your booking will be processed as soon as we confirm your payment.' mod='ghanapayments'}</p>
  </div>
  
  <p>
    {l s='If you have questions, comments or concerns, please contact our' mod='ghanapayments'} 
    <a href="{$contact_url}">{l s='customer support team' mod='ghanapayments'}</a>.
  </p>
</section>

