{*
* 2013 Pos Tpv Prestashop
*
* NOTICE OF LICENSE
*
* This source file is subject to a Private Software License
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to customize this module
* please contact with us.
*
*  @author Alejandro Lozano AELE <soporte@pos-tpv-prestashop.com>
*  @copyright  2013 Pos Tpv Prestashop
*  @license private
*}
{$style_tab}
<div style="font-size: 8pt; color: #444">
<table>
    <tr><td>&nbsp;</td></tr>
</table>
<!-- ADDRESSES -->
<table style="width: 100%">
    <tr>
        <td width="40%">
            <span class="bold">{Configuration::get('PS_SHOP_NAME')}</span><br/>
            {configuration::get('PS_SHOP_DETAILS')}<br/>
            {configuration::get('PS_SHOP_ADDR1')} {configuration::get('PS_SHOP_ADDR2')}<br/>
            {configuration::get('PS_SHOP_CODE')} {configuration::get('PS_SHOP_CITY')}<br/>
            {configuration::get('PS_SHOP_COUNTRY')}<br/>
            {configuration::get('PS_SHOP_PHONE')}<br/>
            {configuration::get('PS_SHOP_EMAIL')}<br/>
        </td>
        <td style="width: 20%"></td>
        <td style="width: 57%">
            {if !empty($delivery_address)}
                <table style="width: 100%">
                    <tr>
                        <td style="width: 70%">
                            <span style="font-weight: bold; font-size: 10pt; color: #9E9F9E">{l s='Dirección de envio' mod='tpvtienda'}</span><br />
                            {$delivery_address}
                        </td>
                    </tr>
                </table>
            {/if}
        </td>
    </tr>
</table>
<!-- / ADDRESSES -->
<table>
    <tr><td>&nbsp;</td></tr>
</table>
<div style="line-height: 1pt">&nbsp;</div>
<!-- PRODUCTS TAB -->
<table style="width: 100%">
    <tr>
        <td style="width: 100%; ">
            <table class="product" width="100%" cellpadding="4" cellspacing="0">
                <tr style="line-height:4px;">
                    {if ($refEnabled)}
                        <th class="product header small" style="width: 9%">{l s='Ref.' mod='tpvtienda'}</th>
                    {/if}
                    <th class="product header small" style="width: {$widthNombre}%">{l s='Producto' mod='tpvtienda'}</th>
                    <!-- unit price tax excluded is mandatory -->
                    <th class="product header small" style="width:5%">{l s='Cant.' mod='tpvtienda'}</th>
                    {if ($discountsEnabled)}
                        <th class="product header small" style="width:8%;white-space: nowrap;">{l s='Desc.' mod='tpvtienda'}</th>
                    {/if}
                    {if !$ocultarPrecios}
                        <th class="product header small" width="8%">{l s='Imp.' mod='tpvtienda'}</th>
                        <th class="product header small" style="width: 13%">{l s='P. unit.' mod='tpvtienda'} </th>
                        {if $tax}<th class="product header small" style="width: 13%; white-space: nowrap;">{l s='con imp.' mod='tpvtienda'}</th>{/if}
                        <th class="product header small" style="width: {if $tax}13%{else}23%{/if}">{l s='Importe' mod='tpvtienda'}</th>
                    {/if}
                </tr>
                <!-- PRODUCTS -->
                {foreach $products as $product}
                {cycle values=["color_line_even", "color_line_odd"] assign=bgcolor_class}
                <tr class="product {$bgcolor_class}">
                    {if ($refEnabled)}
                        <td class="product left">{$product.reference}</td>
                    {/if}
                    <td class="product left" style="width: {$widthNombre}%">
                        {if $display_product_images}
                            <table width="100%">
                                <tr>
                                    <td width="15%">
                                        {if isset($product.image_tag)}
                                            {$product.image_tag}
                                        {/if}
                                    </td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="80%">
                                        {$product.name}
                                    </td>
                                </tr>
                            </table>
                        {else}
                            {$product.name}
                        {/if}
                    </td>
                    <!-- unit price tax excluded is mandatory -->

                    <td style="width: 5%">{$product.quantity}</td>
                    {if ($discountsEnabled)}
                        <td style="width: 8%">
                        {if (isset($discounts[$product.id_product]['reduction']) && $discounts[$product.id_product]['reduction_type'] == "percentage")}
                            {$discounts[$product.id_product]['reduction']*100}%
                        {else if (isset($discounts[$product.id_product]['reduction']) && $discounts[$product.id_product]['reduction_type'] == "amount")}
                            {Tools::displayPrice ($discounts[$product.id_product]['reduction'])}
                        {else}
                            -
                        {/if}
                        </td>
                    {/if}
                    {if !$ocultarPrecios}
                        <td style="width: 8%">
                            {$product.tax_rate}
                        </td>
                        <td style="width: 13%">
                            {displayPrice currency=$cart->id_currency price=$product.unit_price_tax_excl}
                        </td>
                        {if $tax}
                            <td style="width: 13%">
                                {assign var='preciosinIVA' value=$product.unit_price_tax_excl}
                                {assign var='precioConIVA' value=$product.unit_price_tax_incl}
                                {displayPrice currency=$cart->id_currency price=$precioConIVA}
                            </td>
                        {/if}
                        <td style="width: {if $tax}13%{else}23%{/if}">
                            {displayPrice currency=$cart->id_currency price=$product.unit_price_tax_incl*$product.quantity}
                        </td>
                    {/if}
                </tr>
                {if isset($product.customizedFields) && !empty($product.customizedFields)}
                {$i = 0}
                    {foreach $product.customizedFields as $customization}
                            <tr style="line-height:6px">
                                <td style="line-height:3px; width: 45%; vertical-align: top">
                                        <blockquote>
                                            {if isset($customization.type) && $customization.type == $smarty.const._CUSTOMIZE_TEXTFIELD_}
                                                {$customization.name}: {if isset($product.customizedDatas[$i++].value)} {$product.customizedDatas[$i++].value} {/if}
                                                    {if !$smarty.foreach.custo_foreach.last}<br />
                                                    {else}
                                                    <div style="line-height:0.4pt">&nbsp;</div>
                                                    {/if}
                                            {/if}

                                            {if isset($customization.datas[$smarty.const._CUSTOMIZE_FILE_]) && count($customization.datas[$smarty.const._CUSTOMIZE_FILE_]) > 0}
                                                {count($customization.datas[$smarty.const._CUSTOMIZE_FILE_])} {l s='imagen(es)' mod='tpvtienda'}
                                            {/if}
                                        </blockquote>
                                </td>
                                {if !$tax}
                                    <td style="text-align: center;"></td>
                                {/if}
                                <td style="width: 10%"></td>
                                <td style="width: 10%; vertical-align: top"></td>
                                <td style="width: 15%; text-align: center;"></td>
                            </tr>
                    {/foreach}
                {/if}
                {/foreach}
                <!-- END PRODUCTS -->

                <!-- CART RULES -->
                {assign var="shipping_discount_tax_incl" value="0"}
                {foreach $cart_rules as $cart_rule}
                    {cycle values='#FFF,#DDD' assign=bgcolor}
                    <tr style="line-height:6px;background-color:{$bgcolor};text-align:left;">
                        <td colspan="{if !$ocultarPrecios}5{else}1{/if}">{$cart_rule.name}</td>
                        {if $cart_rule.reduction_amount != 0}
                            <td style="text-align: right">- {$cart_rule.reduction_amount}</td>
                        {else}
                            <td style="text-align: right">- {$cart_rule.reduction_percent}%</td>
                        {/if}
                    </tr>
                {/foreach}
                <!-- END CART RULES -->
            </table>
            <table style="width: 100%">
                <tr><td colspan="12" height="10">&nbsp;</td></tr>
                <tr>
                    <td colspan="6" class="left">
                        {$summary_tab}
                    </td>
                    <td colspan="1">&nbsp;</td>
                    <td colspan="5" rowspan="5" class="right">
                        {$total_tab}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- / PRODUCTS TAB -->

<div style="line-height: 1pt">&nbsp;</div>

{$tax_tab}

{if isset($note)}
<div style="line-height: 1pt">&nbsp;</div>
<table style="width: 100%">
    <tr>
        <td class="grey" style="width: 17%;line-height:6px;"><h3>&nbsp;{l s='Info extra' mod='tpvtienda'}:</h3></td>
        <td cellpadding="15" style="width: 83%">{$note|nl2br}</td>
    </tr>
</table>
{/if}

{if isset($HOOK_DISPLAY_PDF)}
<div style="line-height: 1pt">&nbsp;</div>
<table style="width: 100%">
    <tr>
        <td style="width: 17%"></td>
        <td style="width: 83%">{$HOOK_DISPLAY_PDF}</td>
    </tr>
</table>
{/if}

</div>
