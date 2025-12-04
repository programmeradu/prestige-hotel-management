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
            <span class="bold">{$shop_name}</span><br/>
            {$shop_details}<br/>
            {$shop_address}<br/>
            {$shop_city}<br/>
            {$shop_country}<br/>
            {$shop_phone}<br/>
            {$shop_email}<br/>
        </td>
        <td style="width: 20%"></td>
        <td style="width: 57%">
            {if !empty($delivery_address)}
                <table style="width: 100%">
                    <tr>
                        <td style="width: 70%"><span style="font-weight: bold; font-size: 10pt; color: #9E9F9E">{l s='Dirección de envio' mod='tpvtienda'}</span><br />
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
                <tr style="line-height:6px;">
                    <th class="product header small" style="width: {if $tax}39{else}49{/if}%">{l s='Producto' mod='tpvtienda'}</th>
                    <!-- unit price tax excluded is mandatory -->
                    <th class="product header small" style="width:6%">{l s='Cant' mod='tpvtienda'}</th>
                    {if !$ocultarPrecios}
                        <th class="product header small" style="width:6%">{l s='Imp' mod='tpvtienda'}</th>
                        <th class="product header small" style="width:10%">{l s='P. orig' mod='tpvtienda'} </th>
                        <th class="product header small" style="width:9%;white-space: nowrap;">{l s='Dto' mod='tpvtienda'}</th>
                        {if $tax}
                            <th class="product header small" style="width:10%">{l s='P. sin imp' mod='tpvtienda'} </th>
                        {/if}
                        <th class="product header small" style="width:10%">{l s='P. unit' mod='tpvtienda'}{if $tax} {l s='con imp' mod='tpvtienda'}{/if}</th>
                        <th class="product header small" style="width:10%">{l s='Total' mod='tpvtienda'}</th>
                    {/if}
                </tr>
                <!-- PRODUCTS -->
                {foreach $products as $product}
                {cycle values=["color_line_even", "color_line_odd"] assign=bgcolor_class}
                <tr class="product {$bgcolor_class}">
                    <td class="product left">
                        {if $display_product_images && isset($product.image_tag)}
                            <table width="100%">
                                <tr>
                                    <td width="15%">
                                        {if isset($product.image_tag)}
                                            {$product.image_tag}
                                        {/if}
                                    </td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="80%">{$product.name}{if ($refEnabled)}, {l s='Ref.' mod='tpvtienda'} {$product.reference}{/if}</td>
                                </tr>
                            </table>
                        {else}{$product.name}{if ($refEnabled)}, {l s='Ref.' mod='tpvtienda'} {$product.reference}{/if}{/if}
                    </td>
                    <!-- unit price tax excluded is mandatory -->

                    <td class="center">{$product.quantity}</td>

                    {if !$ocultarPrecios}
                        <td class="center">
                            {$product.tax_rate}
                        </td>

                        <td class="center">
                            {if $product.original_product_price_tax_incl > 0}
                                {displayPrice currency=$cart->id_currency price=$product.original_product_price_tax_incl}
                            {else}
                                -
                            {/if}
                        </td>
                        <td class="center" style="width:9%">{if ($esOrder)}{if $product.reduction_percent > 0}{$product.reduction_percent}%
                                {else if $product.reduction > 0}
                                    {Tools::displayPrice ($product.reduction)}
                                {else}
                                    -
                                {/if}
                            {else}
                                {if (isset($discounts[$product.id_product]['reduction']) && $discounts[$product.id_product]['reduction_type'] == "percentage")}{$discounts[$product.id_product]['reduction']}%
                                {else if (isset($discounts[$product.id_product]['reduction']) && $discounts[$product.id_product]['reduction_type'] == "amount")}{Tools::displayPrice ($discounts[$product.id_product]['reduction'])}
                                {else}-{/if}
                            {/if}
                        </td>
                        {if $tax}
                            <td class="center">
                                {displayPrice currency=$cart->id_currency price=$product.unit_price_tax_excl}
                            </td>
                        {/if}
                        <td class="center">
                            {if $tax}
                                {displayPrice currency=$cart->id_currency price=$product.unit_price_tax_incl}
                            {else}
                                {displayPrice currency=$cart->id_currency price=$product.unit_price_tax_excl}
                            {/if}
                        </td>
                        <td class="center">{displayPrice currency=$cart->id_currency price=$product.total_price_tax_incl}</td>
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
                    <tr style="line-height:10px;background-color:{$bgcolor};text-align:left;">
                        <td class="cartRule">{$cart_rule.name}<br>{l s='Código:' mod='tpvtienda'} {$cart_rule.code}</td>
                        <td class="cartRule" colspan="1" class="center">1</td>
                        <td class="cartRule" colspan="{if !$ocultarPrecios}4{else}1{/if}"></td>
                        {if $cart_rule.reduction_amount != 0}
                            <td class="cartRule" style="text-align: right">-{displayPrice currency=$cart->id_currency price=$cart_rule.reduction_amount}</td>
                        {else}
                            <td class="cartRule" style="text-align: right">-{$cart_rule.reduction_percent|number_format:2:".":","}%</td>
                        {/if}
                    </tr>
                {/foreach}
                <!-- END CART RULES -->
            </table>
            <table style="width: 100%">
                <tr><td colspan="12" height="10">&nbsp;</td></tr>
                <tr><td colspan="6">{$summary_tab}</td><td colspan="1">&nbsp;</td><td colspan="5" rowspan="5" class="right">{$total_tab}</td></tr>
            </table>
        </td>
    </tr>
</table>
<!-- / PRODUCTS TAB -->

<div style="line-height: 1pt">&nbsp;</div>

{$tax_tab}

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
