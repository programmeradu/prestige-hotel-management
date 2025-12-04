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

{$dir=$smarty.server.REQUEST_URI}
<table style="border: 0.8pt solid {if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#EEEEEE{/if}; border-collapse: separate; border-spacing: 0; padding:0; margin:0; color:#000; text-align:left; line-height:0.6pt;" cellpadding="10" cellspacing="0" valign="top">
	<tr>
		<td><p style="font-size: 14pt; font-weight: bold; padding:0; margin:0; color: {if Configuration::get('FSPA_titleColor')}{Configuration::get('FSPA_titleColor')|escape:'htmlall':'UTF-8'}{else}#000000{/if};">
			{if strpos($dir,"Invoice") !== false}
				{l s='Invoice' mod='globalinvoicelite'}
			{elseif strpos($dir,"OrderSlip") !== false}
				{l s='Credit Slip' mod='globalinvoicelite'}
			{elseif strpos($dir,"DeliverySlip") !== false}
				{l s='Delivery Slip' mod='globalinvoicelite'}
			{elseif strpos($dir,"id_order_slip") !== false}
				{l s='Credit Slip' mod='globalinvoicelite'}
			{else}
				{l s='Invoice' mod='globalinvoicelite'}	
			{/if}<br/>
		</p>
		<p style="font-size: 11pt; padding:0; margin:0; color: {if Configuration::get('FSPA_titleColor')}{Configuration::get('FSPA_titleColor')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; text-align: left;"><strong>{$title|escape:'htmlall':'UTF-8'}</strong></p>       
		<p style="font-size: 10pt; font-weight: normal; padding:0; margin:0; color: {if Configuration::get('FSPA_titleColor')}{Configuration::get('FSPA_titleColor')|escape:'htmlall':'UTF-8'}{else}#000000{/if}; text-align: left;">{l s='Date' mod='globalinvoicelite'}: {$date|escape:'htmlall':'UTF-8'}</p>
		</td>
	</tr>        
</table>
