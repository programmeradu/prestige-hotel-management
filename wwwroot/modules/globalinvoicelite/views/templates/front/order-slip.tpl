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
{if !empty($delivery_address)}
	<table style="width:100%; padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="0" cellspacing="0">
		<tr>                   		
       		<td style="width: 46%;">
       		{if Configuration::get('FSPA_showdeliveryaddress') == 1}
       			<table style="padding:0; border-collapse: separate; border-spacing: 0; margin:0;" cellpadding="6" cellspacing="0">
					<tr>
		  				<td style="font-weight: normal; line-height: 0.3pt; font-size: 9pt; color: #808080; padding:0;">{l s='Delivery address' mod='globalinvoicelite'}</td>
		  			</tr>
               		<tr>
               			<td style="border-top: 0.8pt solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; font-size: 10pt; background-color: #FFF;">{$delivery_address|escape:'quotes':'UTF-8'}</td>
					</tr>
				</table> 
			{else}
				<table style="width: 100%; vertical-align:center; border-collapse: separate; border-spacing: 0; margin-bottom:10px;padding:0; font-size: 8pt" cellpadding="5" cellspacing="0">
			    	<tr style=" color:{if Configuration::get('FSPA_textColor')}{Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'}{else}#FFF{/if}; line-height: 1pt; text-align:left; background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
						<td style="width: 100%">
							{l s='Order Ref.:' mod='globalinvoicelite'} <strong>{$order->getUniqReference()|escape:'htmlall':'UTF-8'}</strong>
						</td>
					</tr>
					<tr style=" color:{if Configuration::get('FSPA_textColor')}{Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'}{else}#FFF{/if}; line-height: 1pt; text-align:left; background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
						<td style="width: 100%;">
							{l s='Order ID:' mod='globalinvoicelite'} <strong>{$order->id|escape:'htmlall':'UTF-8'}</strong>	
						</td>
					</tr>						
				</table>	
			{/if}
			</td>			
            <td style="width: 8%">&nbsp;</td>            
            <td style="width: 46%">
            	<table style="padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="6" cellspacing="0">
					<tr>
						<td style="font-weight: normal; line-height: 0.3pt; font-size: 9pt; color: #808080; padding:0;">{l s='Invoice address' mod='globalinvoicelite'}</td>
					</tr>            
               		<tr>
               			<td style="border-top: 0.8pt solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; font-size: 10pt; background-color: #FFF;">{$invoice_address|escape:'quotes':'UTF-8'}</td>
                  	</tr>
                 </table>
            </td>						
		</tr>
	</table>
{else}	
	<table style="width:100%; padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="0" cellspacing="0">	
		<tr>      		
       		<td style="width: 46%">{if Configuration::get('FSPA_showdeliveryaddress') == 1}<table style="padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="6" cellspacing="0">
					<tr>
						<td style="font-weight: normal; line-height: 0.3pt; font-size: 9pt; color: #808080; padding:0;">{l s='Delivery address' mod='globalinvoicelite'}</td>
		  			</tr> 
               		<tr>
               			<td style="border-top: 0.8pt solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; font-size: 10pt; background-color: #DDD;">{$invoice_address|escape:'quotes':'UTF-8'}</td>
                  	</tr>
                </table>    
                {else}
                	<table style="width: 100%; vertical-align:center; border-collapse: separate; border-spacing: 0; margin-bottom:10px;padding:0; font-size: 8pt" cellpadding="5" cellspacing="0">
			    	<tr style=" color:{if Configuration::get('FSPA_textColor')}{Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'}{else}#FFF{/if}; line-height: 1pt; text-align:left; background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
						<td style="width: 100%">
							{l s='Order Ref.:' mod='globalinvoicelite'} <strong>{$order->getUniqReference()|escape:'htmlall':'UTF-8'}</strong>
						</td>
					</tr>
					<tr style=" color:{if Configuration::get('FSPA_textColor')}{Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'}{else}#FFF{/if}; line-height: 1pt; text-align:left; background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
						<td style="width: 100%;">
							{l s='Order ID:' mod='globalinvoicelite'} <strong>{$order->id|escape:'htmlall':'UTF-8'}</strong>	
						</td>
					</tr>						
				</table>	            
				{/if}
			</td>

            <td style="width: 8%">&nbsp;</td>
				
			<td style="width: 46%">
				<table style="padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="6" cellspacing="0">
					<tr>
						<td style="font-weight: normal; line-height: 0.3pt; font-size: 9pt; color: #808080; padding:0;">{l s='Invoice address' mod='globalinvoicelite'}</td>
			  		</tr> 
                	<tr>
                  		<td style="border-top: 0.8pt solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; font-size: 10pt; background-color: #DDD;">{$invoice_address|escape:'quotes':'UTF-8'}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
{/if}

<!-- / ADDRESSES -->

<div style="line-height: 1px;">&nbsp;</div>

<!-- PRODUCTS TAB -->

<table style="width: 100%; padding:0; font-size: 8pt; border-collapse: separate; border-spacing: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			{if Configuration::get('FSPA_showdeliveryaddress') == 1}
			<table style="width: 100%; vertical-align:center; border-collapse: separate; border-spacing: 0; margin-bottom:10px;" cellpadding="5" cellspacing="0">
			    <tr style=" color:{if Configuration::get('FSPA_textColor')}{Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'}{else}#FFF{/if}; line-height: 1pt; text-align:left; background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
					<td style="width: 23%; border-right: 2px solid #FFF;">
						{l s='Order Ref.:' mod='globalinvoicelite'} <strong>{$order->getUniqReference()|escape:'htmlall':'UTF-8'}</strong>
					</td>
					<td style="width: 23%; border-right: 2px solid #FFF;">
						{l s='Fact. rectificada:' mod='globalinvoicelite'} <br><strong>{PDFGenerator::getInvoiceBySlipOrder($order->id)}</strong>
					</td>
					<td style="width: 23%;">
						{l s='Order ID:' mod='globalinvoicelite'} <strong>{$order->id|escape:'htmlall':'UTF-8'}</strong>	
					</td>
					<td style="width: 8%; background-color:#FFF;">&nbsp;</td>
                {*foreach from=$order_invoice->getOrderPaymentCollection() item=payment}
            		<td style="width: 46%; text-align:right; background-color:#FFF; color:{if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
            			{l s='Payments methods:' mod='globalinvoicelite'} {$payment->payment_method|escape:'htmlall':'UTF-8'}
            		</td>
				{foreachelse}
					<td style="width: 46%; text-align:right; background-color:#FFF; color:{if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
						{l s='No payment' mod='globalinvoicelite'}
					</td>
				{/foreach*}       
					</tr>               	
        			        		
				</table>
			{/if}
				<div style="line-height: 1px;">&nbsp;</div>
				<table style="width: 100%; vertical-align:top; border-collapse: separate; border-spacing: 0; border-top: 1px solid #DDD; " cellpadding="5" cellspacing="0">
	                <tr style="text-align: left; font-size: 6pt; line-height: 1px; color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; ">					
		                <td style="width: 11%; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
		                	{l s='Ref.' mod='globalinvoicelite'}
		                </td>                    
		                <td style="width: {if Configuration::get('FSPA_details') == 1}35%;{else}56%{/if}; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
		                	{l s='Product' mod='globalinvoicelite'}
		                </td>	                    
						<!-- unit price tax excluded is mandatory -->
	                    {if Configuration::get('FSPA_details') == 1}
		                    <td style="width: 12%; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
		                    	{l s='Base price' mod='globalinvoicelite'}
		                    </td>						
		                    <td style="width: 10%; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
		                    	{l s='Discount' mod='globalinvoicelite'}
		                    </td>
	                    {/if}                    
						<td style="width: 12%; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
							{l s='Final price' mod='globalinvoicelite'}
						</td>						
	                    <td style="width: 6%; text-align:center; border-right: 2px solid #FFF; border-bottom: 2px solid #DDD;">
	                    	{l s='Items' mod='globalinvoicelite'}
	                    </td>				
					 	<td style="width: 14%; text-align:right; border-bottom: 2px solid #DDD;">
					 		{l s='Total' mod='globalinvoicelite'}
					 	</td>
					</tr>				
                <!-- PRODUCTS -->
                {foreach $order_details as $order_detail}
					{cycle values='#DDD,#FFF' assign=bgcolor}
					<tr style="background-color:{$bgcolor|escape:'htmlall':'UTF-8'}; color:#000; page-break-inside: avoid;">
                        <td style="width: 11%; font-size:7pt; border-right: 2px solid #FFF; ">           	
  							{if empty($order_detail.product_reference)}
								No ref.
							{else}
								{$order_detail.product_reference|escape:'htmlall':'UTF-8'}
							{/if}                
                  		</td>
						<td style="text-align: left; width: {if Configuration::get('FSPA_details') == 1}35%;{else}56%{/if}; border-right: 2px solid #FFF; ">
							{if Configuration::get('FSPA_images') == 1}
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
	                    {if Configuration::get('FSPA_details') == 1}
	                        <td style="width: 12%; border-right: 2px solid #FFF; ">
	                        	{displayPrice currency=$order->id_currency price=$order_detail.original_product_price}
	                        </td>
	                        <td style="width: 10%; border-right: 2px solid #FFF; ">
	                        {if (isset($order_detail.reduction_amount) && $order_detail.reduction_amount > 0)}
	                            -{displayPrice currency=$order->id_currency price=$order_detail.reduction_amount}
	                        {else if (isset($order_detail.reduction_percent) && $order_detail.reduction_percent > 0)}
	                            -{$order_detail.reduction_percent|escape:'htmlall':'UTF-8'}%
	                        {else}
	                        --
	                        {/if}
	                    	</td>
	                    {/if}						
						<!-- unit price tax excluded is mandatory -->				
						<td style="width: 12%; border-right: 2px solid #FFF; ">{displayPrice currency=$order->id_currency price=$order_detail.unit_price_tax_excl}</td>					
	                    <td style="width: 6%; text-align:center; border-right: 2px solid #FFF; ">{$order_detail.product_quantity|escape:'htmlall':'UTF-8'}</td>
						<td style="width: 14%; text-align:right;">{displayPrice currency=$order->id_currency price=$order_detail.total_price_tax_excl}</td>
					</tr>
				{/foreach}
				<!-- END PRODUCTS -->	
			</table>
      	</td>
    </tr>
</table>
<!-- / PRODUCTS TAB -->
<!-- DESCUENTO Y ENVÍOS -->
<table style="width: 100%; vertical-align:top; text-align:right; font-size:8pt; line-height:1pt; padding:0;" cellpadding="5" cellspacing="0">
	<!-- CART RULES -->
	{if ($order_invoice->total_discount_tax_excl) > 0}
		{assign var="shipping_discount_tax_incl" value="0"}
		{foreach $cart_rules as $cart_rule}					
			<tr>
		        <td style="width:87%; color:#404040; border-top: 1px solid #DDD;">{$cart_rule.name|escape:'htmlall':'UTF-8'}</td>				
		        <td style="width:13%; color:#000000; border-top: 1px solid #DDD;">
					{if $cart_rule.free_shipping}
						{assign var="shipping_discount_tax_excl" value=$order_invoice->total_shipping_tax_excl}
					{/if}
					{if $tax_excluded_display}
						- {displayPrice currency=$order->id_currency price=($cart_rule.value_tax_excl)}
					{else}
						- {displayPrice currency=$order->id_currency price=($cart_rule.value_tax_excl)}
					{/if}
				</td>
			</tr>	
		{/foreach}	
		<tr>
			<td style="width:87%; color:#404040; border-top: 1px solid #DDD;">{l s='Total Vouchers' mod='globalinvoicelite'}</td>			
			<td style="width:13%; color:#000000; border-top: 1px solid #DDD;">- {displayPrice currency=$order->id_currency price=($order_invoice->total_discount_tax_excl)}</td>
		</tr>
	{/if}		
	{if $order_invoice->total_wrapping_tax_excl > 0}
		<tr>
			<td style="width:87%; color:#404040; border-top: 1px solid #DDD;">{l s='Wrapping Cost' mod='globalinvoicelite'}</td>            
			<td style="width:13%; color:#000000; border-top: 1px solid #DDD;">
			{if $tax_excluded_display}
				{displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_excl}
			{else}
				{displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_incl}
			{/if}
			</td>
		</tr>
	{/if}			
	<!-- END CART RULES -->
	<tr>
		<td style="width:87%; color:#404040; border-top: 1px solid #DDD; border-bottom: 1px solid #DDD;">{l s='Shipping Cost' mod='globalinvoicelite'} {l s='Tax Incl.' mod='globalinvoicelite'} - {l s='Carrier:' mod='globalinvoicelite'}</td>
		<td style="width:13%; color:#000000; border-top: 1px solid #DDD; border-bottom: 1px solid #DDD;">{displayPrice currency=$order->id_currency price=$order->total_shipping_tax_incl}</td>
	</tr>
</table>
<!-- / DESCUENTO Y ENVÍOS -->

<!-- / DETALLES COMPLEMENTARIOS -->

<div style="line-height: 1pt">&nbsp;</div>

{$tax_tab|escape:'quotes':'UTF-8'}

{if isset($order_invoice->note) && $order_invoice->note}
	<table style="width: 100%">
		<tr>
			<td style="width: 13%"></td>
			<td style="width: 87%">{$order_invoice->note|nl2br|escape:'htmlall':'UTF-8'}</td>
		</tr>
	</table>
{/if}

{if isset($HOOK_DISPLAY_PDF)}
	<div style="line-height: 1pt">&nbsp;</div>
	<table style="width: 100%">
		<tr>
			<td style="width: 13%"></td>
			<td style="width: 87%">{$HOOK_DISPLAY_PDF|escape:'htmlall':'UTF-8'}</td>
		</tr>
	</table>
{/if}