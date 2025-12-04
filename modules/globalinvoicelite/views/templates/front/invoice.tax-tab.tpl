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

<!-- FINAL TABLE -->

<table style="width: 100%; padding:0; border-collapse: separate; border-spacing: 0; font-size:8pt; line-height:1pt; margin:0; page-break-inside: avoid;" cellpadding="0" cellspacing="0">	
	<tr>
		<!-- Taxes -->
		<td style="width:55%">
			{if Configuration::get('FSPA_taxBlock') == 1}
			<table style="width: 100%; padding:0; margin:0;" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						{if $tax_exempt}
							{l s='Exempt of VAT according section 259B of the General Tax Code.' mod='globalinvoicelite'}
						{else}
							<table style="width: 100%; padding:0; border-collapse: separate; border-spacing: 0; " cellpadding="5" cellspacing="0">							
								{if Configuration::get('NOHRE_activo') == 1}
									{* Recargo de equivalencia Activo *}
						            <tr>
						            	<td colspan="4" style="color: #808080; font-size:9pt; padding-bottom:0; border-bottom: 1px solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#DDD{/if};">{l s='Taxes' mod='globalinvoicelite'}</td>
						          	</tr>
						          							
									<tr style="font-size: 6pt; line-height: 1px; color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#DDD{/if};">										
										<td style="width: 25%;">{l s='Details' mod='globalinvoicelite'}</td>	
										<td style="width: 21%;">{l s='Base' mod='globalinvoicelite'}</td>
										<td style="width: 27%;">{l s='Rate' mod='globalinvoicelite'}</td>
										<td style="width: 27%;">{l s='Total Taxes' mod='globalinvoicelite'}</td>
									</tr>
								{else}
									{* Recargo de equivalencia NO Activo *}
									<tr>
						            	<td colspan="5" style="color: #808080; font-size:9pt; padding-bottom:0; border-bottom: 1px solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#DDD{/if};">{l s='Taxes' mod='globalinvoicelite'}</td>
						            </tr>
									<tr style="text-align: left; font-size: 6pt; color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#DDD{/if};">					
										<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Details' mod='globalinvoicelite'}</td>	
										<td style="width: 21%; border-right: 2px solid #FFF;">{l s='Base' mod='globalinvoicelite'}</td>	
										<td style="width: 17%; border-right: 2px solid #FFF;">{l s='Rate' mod='globalinvoicelite'}</td>
										<td style="width: 17%; border-right: 2px solid #FFF;">{l s='Total Taxes' mod='globalinvoicelite'}</td>
										<td style="width: 20%;">{l s='Total' mod='globalinvoicelite'}</td>
									</tr>
								{/if}
								{if isset($product_tax_breakdown)}									
									{if Configuration::get('NOHRE_activo') == 1}
										{* Recargo de equivalencia Activo *}							
										{foreach $product_tax_breakdown as $rate => $product_tax_infos}	
											<tr style="background-color:{cycle values='#DDD,#FFF'};">
									 			{if $product_tax_infos.name|substr:0:1 == 'R'}													 	
												 	<td style="width: 25%; border-right: 2px solid #FFF;">{$product_tax_infos.name|escape:'htmlall':'UTF-8'}</td>								 	
												 	<td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=($product_tax_infos.total_price_tax_excl + $order_invoice->total_discount_tax_excl) - $order_invoice->total_discount_tax_excl}</td>
													<td style="width: 27%; border-right: 2px solid #FFF;">{$rate|escape:'htmlall':'UTF-8'} %</td>
													<td style="width: 27%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip} {/if} {math equation="(t * ra) / 100" t = round($product_tax_infos.total_price_tax_excl,2) ra = $rate|replace:",":"." format="%.4f"} {Currency::getCurrent()->sign|escape:'htmlall':'UTF-8'}</td>
												{else}
													<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Products' mod='globalinvoicelite'}</td>
													<td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=($product_tax_infos.total_price_tax_excl + $order_invoice->total_discount_tax_excl) - $order_invoice->total_discount_tax_excl}</td>											
					                				<td style="width: 27%; border-right: 2px solid #FFF;">{$rate|escape:'htmlall':'UTF-8'} %</td>
													<td style="width: 27%;">{if isset($is_order_slip) && $is_order_slip} {/if}{round(round((($product_tax_infos.total_price_tax_excl + $order_invoice->total_discount_tax_excl) - $order_invoice->total_discount_tax_excl),2)*$rate/100,4)|escape:'htmlall':'UTF-8'} {Currency::getCurrent()->sign|escape:'htmlall':'UTF-8'}</td>					
												{/if}
												</tr>
										{/foreach}
									{else}
										{* Recargo de equivalencia NO Activo *}
										{foreach $product_tax_breakdown as $rate => $product_tax_infos}
											<tr style="background-color:{cycle values='#DDD,#FFF'};">
												 <td style="width: 25%; border-right: 2px solid #FFF;">{l s='Products' mod='globalinvoicelite'}</td>
												 <td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip} 
									 	{if ($product_tax_infos.total_price_tax_excl + $order_invoice->total_discount_tax_excl) == 0 }
													 		- {displayPrice currency=$order->id_currency price=$order->total_products_wt}
													 	{else}
													 		- {displayPrice currency=$order->id_currency price=($product_tax_infos.total_price_tax_excl + $order_invoice->total_discount_tax_excl) - $order_invoice->total_discount_tax_excl}
													 	{/if}
									 				{else}{displayPrice currency=$order->id_currency price=$product_tax_infos.total_price_tax_excl}
													 {/if}
												</td>
												<td style="width: 17%; border-right: 2px solid #FFF;">{round($rate,2)|escape:'htmlall':'UTF-8'} %</td>
												<td style="width: 17%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=(($product_tax_infos.total_price_tax_excl)*$rate) / 100}</td>
					                			<td style="width: 20%;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$product_tax_infos.total_amount + ($product_tax_infos.total_price_tax_excl + $order_invoice->total_discount_tax_excl) - $order_invoice->total_discount_tax_excl}</td>
											</tr>
										{/foreach}
									{/if}
								{/if}
								<!-- Transporte -->
								{if Configuration::get('NOHRE_activo') == 1}
									{if isset($shipping_tax_breakdown)}
										{foreach $shipping_tax_breakdown as $shipping_tax_infos}
							                {if $order->total_shipping_tax_incl > 0}
												<tr style="background-color:{cycle values='#DDD,#FFF'};">
									 				{if Configuration::get('NOHRE_aplicar_a_Envio') == 1}
													  	{if $shipping_tax_infos.name eq ''}
						                                	<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Shipping' mod='globalinvoicelite'}</td>
						                                {else}                                
							                                <td style="width: 25%; border-right: 2px solid #FFF;">{$shipping_tax_infos.name|escape:'htmlall':'UTF-8'}</td>
						                                {/if}
													{else}
									  					<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Shipping' mod='globalinvoicelite'}</td>
													{/if}					 								
										 				<td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}-{/if}{displayPrice currency=$order->id_currency price=$shipping_tax_infos.total_tax_excl}</td>									
				                					<td style="width: 27%; border-right: 2px solid #FFF;">{round($shipping_tax_infos.rate,2)|escape:'htmlall':'UTF-8'} %</td>
								 					<td style="width: 27%;">{round(($shipping_tax_infos.total_tax_excl * $shipping_tax_infos.rate) / 100,4)|escape:'htmlall':'UTF-8'} {Currency::getCurrent()->sign|escape:'htmlall':'UTF-8'}</td>
												</tr>
											{/if}
										{/foreach}
									{/if}

								{else}

									{if isset($shipping_tax_breakdown)}

										{foreach $shipping_tax_breakdown as $shipping_tax_infos}
							                {if $order->total_shipping_tax_incl > 0}
												<tr style="background-color:{cycle values='#DDD,#FFF'};">
													<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Shipping' mod='globalinvoicelite'}</td>									 		
													<td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$shipping_tax_infos.total_tax_excl}</td>
				               						<td style="width: 17%; border-right: 2px solid #FFF;">{round($shipping_tax_infos.rate,2)|escape:'htmlall':'UTF-8'} %</td>
								 					<td style="width: 17%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$shipping_tax_infos.total_amount}</td>
				                					<td style="width: 20%;">{if isset($is_order_slip) && $is_order_slip}- {displayPrice currency=$order->id_currency price=$order->total_shipping_tax_incl}{else}{displayPrice currency=$order->id_currency price=$order->total_shipping_tax_incl}{/if}</td>
												</tr>
											{/if}
										{/foreach}
									{/if}
								{/if}

								<!-- End transporte -->


								<!-- Embalaje -->

								{if Configuration::get('NOHRE_activo') == 1}

									{if $order_invoice->total_wrapping_tax_incl > 0}
										<tr style="background-color:{cycle values='#DDD,#FFF'};">
											<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Wrapping' mod='globalinvoicelite'}</td>
											<td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_excl}</td>
							                <td style="width: 27%; border-right: 2px solid #FFF;">{($order_invoice->total_wrapping_tax_incl-$order_invoice->total_wrapping_tax_excl)*100 / $order_invoice->total_wrapping_tax_excl|string_format:"%.2f"|escape:'htmlall':'UTF-8'} %</td>
					 						<td style="width: 27%;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_incl-$order_invoice->total_wrapping_tax_excl}</td>
										</tr>
									{/if}

								{else}

									{if $order_invoice->total_wrapping_tax_incl > 0}
										<tr style="background-color:{cycle values='#DDD,#FFF'};">
											<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Wrapping' mod='globalinvoicelite'}</td>
											<td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_excl}</td>
							                <td style="width: 17%; border-right: 2px solid #FFF;">{($order_invoice->total_wrapping_tax_incl-$order_invoice->total_wrapping_tax_excl)*100 / $order_invoice->total_wrapping_tax_excl|string_format:"%.2f"|escape:'htmlall':'UTF-8'} %</td>
											<td style="width: 17%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_incl-$order_invoice->total_wrapping_tax_excl}</td>
		                					<td style="width: 20%;">
		                						{displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_incl}
												
											</td>
										</tr>
									{/if}
								{/if}
								<!-- End embalaje -->					

								<!-- Ecotax -->
								{if isset($ecotax_tax_breakdown)}
									{foreach $ecotax_tax_breakdown as $ecotax_tax_infos}
										{if $ecotax_tax_infos.ecotax_tax_excl > 0}
											<tr style="background-color:{cycle values='#DDD,#FFF'};">
												<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Ecotax' mod='globalinvoicelite'}</td>
												
												<td style="width: 21%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$ecotax_tax_infos.ecotax_tax_excl}</td>
												
												<td style="width: 17%; border-right: 2px solid #FFF;">{round($ecotax_tax_infos.rate,2)|escape:'htmlall':'UTF-8'} %</td>
												<td style="width: 17%; border-right: 2px solid #FFF;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=($ecotax_tax_infos.ecotax_tax_incl - $ecotax_tax_infos.ecotax_tax_excl)}</td>
												<td style="width: 20%;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=($ecotax_tax_infos.ecotax_tax_incl)}</td>
											</tr>
										{/if}
									{/foreach}
								{/if}
								<!-- /EcoTax -->


								<!-- fee paypal -->
								{if isset($order->payment_fee) && $order->payment_fee > 0}
									<tr style="background-color:{cycle values='#DDD,#FFF'};">
										<td style="width: 25%; border-right: 2px solid #FFF;">{l s='Fee payment' mod='globalinvoicelite'}</td>
										<td style="width: 21%; border-right: 2px solid #FFF;">{displayPrice currency=$order->id_currency price=($order->payment_fee / (1+($order->payment_fee_rate/100)))}</td>
										<td style="width: 17%; border-right: 2px solid #FFF;">{round($order->payment_fee_rate,2)|escape:'htmlall':'UTF-8'} %</td>
										<td style="width: 17%; border-right: 2px solid #FFF;">{displayPrice currency=$order->id_currency price=($order->payment_fee - ($order->payment_fee / (1+($order->payment_fee_rate/100))))}</td>
										<td style="width: 20%; border-right: 2px solid #FFF;">{displayPrice currency=$order->id_currency price=($order->payment_fee * ($order->payment_fee_rate/100) / (1+($order->payment_fee_rate/100)) + ($order->payment_fee / (1+($order->payment_fee_rate/100))))}</td>
									</tr>
								{/if}
								<!-- /feepaypal -->
							</table>
						{/if}
					</td>
				</tr>
			</table>
			{/if}
		</td>
		
		<!--/ IVA -->
		
		<!-- MARGEN -->
		<td style="width:8%">&nbsp;</td>
		<!--/ MARGEN -->
		
		<!-- TOTALES -->
		{if ($order_invoice->total_discount_tax_excl) > 0}
			{assign var="el_total" value="0"}
			{foreach $cart_rules as $cart_rule}					
				{if $tax_excluded_display}
					
					{assign var="el_total" value=$el_total + $cart_rule.value_tax_excl}
				{else}
					{assign var="el_total" value=$el_total + $cart_rule.value_tax_incl}
					
				{/if}	
			{/foreach}
		{/if}
		<td style="width:37%">
			<table style="width: 100%;border-collapse: separate; border-spacing: 0; margin:0; padding:0;" cellpadding="5" cellspacing="0">
				<tr>
					<td colspan="2" style="color: #808080; font-size:9pt; padding-bottom:0; border-bottom: 1px solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#DDD{/if};">{l s='Invoice Total' mod='globalinvoicelite'}</td>
				</tr>
				
				<tr style="text-align: left; font-size: 6pt; line-height: 1px; color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#DDD{/if};">
					<td style="width:60%;">{l s='Detail' mod='globalinvoicelite'}</td>
					
					<td style="width:40%; text-align:right;">{l s='Price' mod='globalinvoicelite'}</td>
				</tr>

				<tr style="border-top:1px solid #DDD;">
					<td style="width:60%; color:#404040; border-right: 2px solid #FFF;">{l s='SubTotal' mod='globalinvoicelite'}</td>
					<td style="width:40%; text-align:right;">{if isset($is_order_slip) && $is_order_slip}- {displayPrice currency=$order->id_currency price=($order->total_products)}{else}{displayPrice currency=$order->id_currency price=($order->total_products+$shipping_tax_infos.total_tax_excl+$order->total_wrapping_tax_excl)}{/if}</td>
				</tr>

				{if isset($is_order_slip) && $is_order_slip}
					{if $shipping_tax_infos.total_tax_excl > 0}
						<tr>
							<td style="width:60%; color:#404040; border-right: 2px solid #FFF;">{l s='Carrier' mod='globalinvoicelite'}</td>
							<td style="width:40%; text-align:right;">
								
									{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$shipping_tax_infos.total_tax_excl}							
							</td>
						</tr>
					{/if}

				{/if}
					
				{if $order_invoice->total_discount_tax_incl > 0}
					<tr>
						<td style="width:60%; color:#404040; border-right: 2px solid #FFF;">{l s='Total Discounts' mod='globalinvoicelite'}</td>
						<td style="width:40%; text-align:right;">-{displayPrice currency=$order->id_currency price=$el_total}</td>
					</tr>

					<tr>
						<td style="width:60%; color:#404040; border-right: 2px solid #FFF;">{l s='Base Tax' mod='globalinvoicelite'}</td>
						<td style="width:40%; text-align:right;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=($order->total_products+$shipping_tax_infos.total_tax_excl+$order->total_wrapping_tax_excl) - ($el_total)}</td>
					</tr>
				{/if}

				{if ($order->total_paid_tax_incl - $order->total_paid_tax_excl) > 0}
					<tr>
						<td style="width:60%; color:#404040; border-right: 2px solid #FFF;">{l s='Total Taxes' mod='globalinvoicelite'}</td>
						<td style="width:40%; text-align:right;">{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=($order->total_paid_tax_incl - $order->total_paid_tax_excl)}</td>
					</tr>
				{/if}
                
                {if isset($order->payment_fee) && $order->payment_fee > 0}
					<tr>
						<td style="width:60%; color:#404040; border-right: 2px solid #FFF;">{l s='Fee' mod='globalinvoicelite'}</td>
						<td style="width:40%; text-align:right;">{displayPrice currency=$order->id_currency price=($order->payment_fee / (1+($order->payment_fee_rate/100)))}</td>
					</tr>
				{/if}

				{if Configuration::get('FSPA_showCarrier') == 1}
				{if $order_invoice->total_shipping_tax_incl > 0}
					<tr>
						<td style="width:60%; color:#404040; border-right: 2px solid #FFF;">{l s='Carrier' mod='globalinvoicelite'}</td>
						<td style="width:40%; text-align:right;">
							
								{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$order_invoice->total_shipping_tax_incl}							
						</td>
					</tr>
				{/if}
				{/if}

				<tr style="color:{Configuration::get('FSPA_textColor')|escape:'htmlall':'UTF-8'}; background-color: {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
					<td style="width:60%; border-right: 2px solid #FFF;">{l s='Total' mod='globalinvoicelite'}</td>
					<td style="width:40%; font-size:10pt; text-align:right;"><strong>{if isset($is_order_slip) && $is_order_slip}- {/if}{displayPrice currency=$order->id_currency price=$order->total_paid_tax_incl}</strong></td>
				</tr>
			</table>

			{if isset($is_order_slip) && $is_order_slip}
				<div style="line-height: 1pt">&nbsp;</div>
			{else}
				{if $order_invoice->getRestPaid() > 0}
				<div style="line-height: 1pt">&nbsp;</div>
				<table style="width: 100%; margin:0; padding:0; font-weight: bold;" cellpadding="5" cellspacing="0">
					<tr style="color:red; background-color:#DDD;">
						<td style="width:60%; border-right: 2px solid #FFF;">{l s='Remaining Amount Due' mod='globalinvoicelite'}</td>
						<td style="width:40%; text-align:right;">{displayPrice currency=$order->id_currency price=$order_invoice->getRestPaid()}</td>	
					</tr>
				</table>
				{/if}
			{/if}
		</td>
		<!--/ TOTALES -->
	</tr>
	
</table>
<!-- / FINAL TABLE -->