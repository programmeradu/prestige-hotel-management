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
{if !$ocultarPrecios}
<table id="total-tab" width="100%">

	<tr>
		<td class="grey" width="60%">
			{l s='Total Products' pdf='true'}
		</td>
		<td class="white" width="40%">
			{displayPrice currency=$cart->id_currency price=$totalProducts}
		</td>
	</tr>


	{if $totalDescuentos != 0}
		<tr>
			<td class="grey" width="60%">{l s='Total Discounts' pdf='true'}</td>
			<td class="white" width="40%">-{displayPrice currency=$cart->id_currency price=$totalDescuentos}</td>
		</tr>
	{/if}


	{if $totalShipping > 0}
		<tr class="bold">
			<td class="grey" width="60%">{l s='Shipping Cost' pdf='true'}</td>
			<td class="white" width="40%">{displayPrice currency=$cart->id_currency price=$totalShipping}</td>
		</tr>
	{/if}
	
	{if $totalWithoutTax > 0}
		<tr class="bold">
			<td class="grey" width="60%">{l s='Total (Tax excl.)' pdf='true'}</td>
			<td class="white" width="40%">{displayPrice currency=$cart->id_currency price=$totalWithoutTax}</td>
		</tr>
	{/if}
	
	{if $totalIva > 0}
		<tr class="bold">
			<td class="grey" width="60%">{l s='Total Tax' pdf='true'}</td>
			<td class="white" width="40%">{displayPrice currency=$cart->id_currency price=$totalIva}</td>
		</tr>
	{/if}
	
	<tr class="bold big">
		<td class="grey" width="60%">{l s='Total' pdf='true'}</td>
		<td class="white" width="40%">{displayPrice currency=$cart->id_currency price=$total}</td>
	</tr>
</table>
{/if}