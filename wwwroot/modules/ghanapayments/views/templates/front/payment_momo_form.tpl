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
  <p>{l s='Pay with Ghana Mobile Money (MTN, Vodafone, AirtelTigo)' mod='ghanapayments'}</p>
  
  <div class="form-group">
    <label for="momo_network">{l s='Select Mobile Money Network' mod='ghanapayments'}</label>
    <select name="momo_network" id="momo_network" class="form-control">
      <option value="MTN">MTN Mobile Money</option>
      <option value="Vodafone">Vodafone Cash</option>
      <option value="AirtelTigo">AirtelTigo Money</option>
    </select>
  </div>
  
  <div class="form-group">
    <label for="momo_phone">{l s='Your Mobile Money Number' mod='ghanapayments'}</label>
    <input type="text" name="momo_phone" id="momo_phone" class="form-control" placeholder="0201234567" required>
  </div>
  
  <div class="alert alert-info">
    <p>{l s='Please send payment to this number:' mod='ghanapayments'} <strong>{$momo_number}</strong></p>
    <p>{$momo_instructions}</p>
  </div>
  
  <div class="form-group">
    <label for="momo_transaction_id">{l s='Transaction ID / Reference' mod='ghanapayments'}</label>
    <input type="text" name="momo_transaction_id" id="momo_transaction_id" class="form-control" required>
    <small class="form-text text-muted">{l s='Enter the transaction ID or reference number you received after making the payment.' mod='ghanapayments'}</small>
  </div>
</section>

