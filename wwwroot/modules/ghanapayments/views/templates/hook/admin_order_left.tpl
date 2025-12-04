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

<div class="card mt-2">
  <div class="card-header">
    <h3 class="card-header-title">
      {l s='Mobile Money Transaction Details' mod='ghanapayments'}
    </h3>
  </div>
  
  <div class="card-body">
    {if !empty($transaction_info)}
      <div class="row">
        <div class="col-sm-6">
          <p><strong>{l s='Network:' mod='ghanapayments'}</strong> {$transaction_info.network}</p>
        </div>
        <div class="col-sm-6">
          <p><strong>{l s='Phone:' mod='ghanapayments'}</strong> {$transaction_info.phone}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <p><strong>{l s='Transaction ID:' mod='ghanapayments'}</strong> {$transaction_info.transaction_id}</p>
        </div>
      </div>
    {else}
      <p>{l s='No transaction details available.' mod='ghanapayments'}</p>
    {/if}
  </div>
</div>

