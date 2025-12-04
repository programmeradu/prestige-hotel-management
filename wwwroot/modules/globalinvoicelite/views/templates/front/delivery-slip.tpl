{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- ADDRESSES -->

<table style="width:100%; padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="0" cellspacing="0">
	<tr>                   		
   		<td style="width: 46%;">&nbsp;</td>			
        <td style="width: 8%">&nbsp;</td>            
        <td style="width: 46%">
        	<table style="padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="6" cellspacing="0">
				<tr>
					<td style="font-weight: normal; line-height: 0.3pt; font-size: 9pt; color: #808080; padding:0;">{l s='Delivery address' mod='globalinvoicelite'}</td>
				</tr>            
           		<tr>
           			<td style="border-top: 0.8pt solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; font-size: 10pt; background-color: #FFF;">{$delivery_address|escape:'quotes':'UTF-8'}</td>
              	</tr>
             </table>
        </td>						
	</tr>
</table>


<!-- / ADDRESSES -->

<div style="line-height: 1px;">&nbsp;</div>

<!-- PRODUCTS TAB -->
<table style="width: 100%; padding:0; font-size: 8pt; border-collapse: separate; border-spacing: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table style="width: 100%; vertical-align:center; border-collapse: separate; border-spacing: 0; margin-bottom:10px;" cellpadding="5" cellspacing="0">
			    <tr style=" color:{if Configuration::get('FSPA_textColor')}{Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'}{else}#FFF{/if}; line-height: 1pt; text-align:left; background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
					<td style="width: 23%; border-right: 2px solid #FFF;">
						{l s='Order Ref.:' mod='globalinvoicelite'} <strong>{$order->getUniqReference()|escape:'htmlall':'UTF-8'}</strong>
					</td>
					<td style="width: 23%;">
						{l s='Order ID:' mod='globalinvoicelite'} <strong>{$order->id|escape:'htmlall':'UTF-8'}</strong>	
					</td>
					<td style="width: 8%; background-color:#FFF;">&nbsp;</td>
                {foreach from=$order_invoice->getOrderPaymentCollection() item=payment}
            		<td style="width: 46%; text-align:right; background-color:#FFF; color:{if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">	
            		</td>
				{foreachelse}
					<td style="width: 46%; text-align:right; background-color:#FFF; color:{if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">	
					</td>
				{/foreach}       
					</tr>               		        		
				</table>
				<div style="line-height: 1px;">&nbsp;</div>
				<table style="width: 100%; vertical-align:top; border-collapse: separate; border-spacing: 0; border-top: 1px solid #DDD;" cellpadding="5" cellspacing="0">
	                <tr style="text-align: left; font-size: 6pt; line-height: 1px; color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; ">					
		                <td style="width: 20%; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
		                	{l s='Ref.' mod='globalinvoicelite'}
		                </td>                    
		                <td style="width: 70%; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
		                	{l s='Product' mod='globalinvoicelite'}
		                </td>	                    						
	                    <td style="width: 10%; text-align:center; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
	                    	{l s='Items' mod='globalinvoicelite'}
	                    </td>				
					</tr>				
                <!-- PRODUCTS -->
                {foreach $order_details as $order_detail}
					{cycle values='#DDD,#FFF' assign=bgcolor}
					<tr style="background-color:{$bgcolor|escape:'htmlall':'UTF-8'}; color:#000; page-break-inside: avoid;">
                        <td style="width: 20%; font-size:7pt; border-right: 2px solid #FFF; ">           	
  							{if empty($order_detail.product_reference)}
								No ref.
							{else}
								{$order_detail.product_reference|escape:'htmlall':'UTF-8'}
							{/if}                
                  		</td>
						<td style="text-align: left; width: 70%; border-right: 2px solid #FFF; ">
							{if Configuration::get('FSPA_imagesAlbaran') == 1}
								<table width="100%">
									<tr>
										<td width="15%">
											{assign var="x" value= Product::getCover($order_detail.product_id)}
											{assign var="y" value= Product::getUrlRewriteInformations($order_detail.product_id)}
											{foreach from=$y item=a}
												{assign var="linki" value=$a.link_rewrite}
												{break}
											{/foreach}
											{assign var=ellink value=$order_detail.product_id|cat:"-"|cat:$x.id_image}
											<img src="{Context::getContext()->link->getImageLink($linki,$ellink,ImageType::getFormatedName('small'))|escape:'htmlall':'UTF-8'}">
										</td>
										<td width="5%">&nbsp;</td>
										<td width="80%;">
											{$order_detail.product_name|escape:'htmlall':'UTF-8'}
										</td>
									</tr>
								</table>
							{else}
								{$order_detail.product_name|escape:'htmlall':'UTF-8'}
							{/if}
						</td>		                    					
	                    <td style="width: 10%; text-align:center; border-right: 2px solid #FFF; ">{$order_detail.product_quantity|escape:'htmlall':'UTF-8'}</td>
						
					</tr>
				{/foreach}
				<!-- END PRODUCTS -->	
			</table>
      	</td>
    </tr>
</table>
<!-- / PRODUCTS TAB -->

<table style="width: 100%; padding:0; font-size: 8pt; border-collapse: separate; border-spacing: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td style="text-align:right">{l s='Carrier' mod='globalinvoicelite'}: {$order_invoice->getCarrier($order_invoice->id)->name|escape:'htmlall':'UTF-8'}
		</td>
	</tr>
</table>

<!-- MENSAJES -->
<div style="line-height: 1pt">&nbsp;</div>
<table style="width: 100%; padding:0; font-size: 8pt; border-collapse: separate; border-spacing: 0;" cellpadding="5" cellspacing="0">
	<tr style="background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; color: {Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'};">
		<td>{l s='Customer´s message' mod='globalinvoicelite'}</td>
	</tr>
	{foreach Message::getMessagesByOrderId($order->id, true) as $mensaje}
	{cycle values='#FFF,#DDD' assign=bgcolor}
	    <tr style="line-height:6px;">
			<td style="text-align: center;  padding-left: 10px; font-size:7pt; width: 15%;">{$mensaje.date_add|date_format:"%D"}</td>
			<td style="color:#000; text-align: left; font-size:9pt; width: 80%">{$mensaje.message|escape:'htmlall':'UTF-8'}</td>
		</tr>
	{/foreach}
</table>
<!-- / MENSAJES -->

<div style="line-height: 1pt">&nbsp;</div>

{if isset($HOOK_DISPLAY_PDF)}
	<div style="line-height: 1pt">&nbsp;</div>
	<table style="width: 100%">
		<tr>
			<td style="width: 15%"></td>
			<td style="width: 85%">
				{$HOOK_DISPLAY_PDF|escape:'htmlall':'UTF-8'}
			</td>
		</tr>
	</table>
{/if}