{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 *}

<form  method="post" accept-charset="utf-8" action="">
    <div class="panel" style="border-radius: 0px;">
        <div class="col-lg-1">
            <span class="pull-right">
            </span>
        </div>
        <div class="col-lg-2 form-group" style="text-align: right;margin-top: 9px;">
            <label class="control-label" for="available_for_order">
                {l s='Video Placements:' mod='bavideotab'}
            </label>
        </div>
        <div class="col-lg-9">
            <div class="checkbox">
                <label for="available_for_order">
                <input type="checkbox" name="position_tab" id="position_tab" value="1" 
                {if $position_tab == 1} checked="checked"{/if}>
                {l s='Product Tab' mod='bavideotab'}</label>
            </div>
            <div class="checkbox">
                <label for="show_price">
                <input type="checkbox" name="position_popup" id="position_popup" value="1" 
                {if $position_popup == 1} checked="checked"{/if}>
                {l s='Popup' mod='bavideotab'}</label>
            </div>
        </div>

        <div class="col-lg-1">
            <span class="pull-right">
            </span>
        </div>
        <div class="col-lg-2 form-group" style="text-align: right;">
            <label class="control-label" for="available_for_order">
                {l s='Video Extension:' mod='bavideotab'}
            </label>
        </div>
        <div class="col-lg-5">
            <input type="text" id="videoextension" name="videoextension" value="{$videoextension|escape:'htmlall':'UTF-8'}">
        </div>
        <div class="panel-footer" style="clear: both;">
            <button type="submit" name="saveposition" class="btn btn-default pull-right " id="save"> <i class="process-icon-save"></i>{l s='Save' mod='bavideotab'}</button>
        </div>        
    </div>
</form>
