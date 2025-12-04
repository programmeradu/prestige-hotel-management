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


<table style="border-collapse: separate; border-spacing:0; padding:0; color:#808080; text-align:left; font-size: 7pt; line-height:1pt; font-weight: normal;" cellpadding="0" cellspacing="0" valign="top" >
	 <tr>
		 <td>{if Configuration::get('FSPA_razonSocial')}<strong>{Configuration::get('FSPA_razonSocial')|escape:'htmlall':'UTF-8'}</strong><br/>{/if}
			 {if Configuration::get('FSPA_nombre')}<em>{Configuration::get('FSPA_nombre')|escape:'htmlall':'UTF-8'}</em><br/>{/if}
			 {if Configuration::get('FSPA_cif')}{Configuration::get('FSPA_cif')|escape:'htmlall':'UTF-8'}<br/>{/if}
			 {if Configuration::get('FSPA_domicilio')}{Configuration::get('FSPA_domicilio')|escape:'htmlall':'UTF-8'}<br/>{/if}
			 {if Configuration::get('FSPA_localidad')}{Configuration::get('FSPA_localidad')|escape:'htmlall':'UTF-8'}{/if}{if Configuration::get('FSPA_Provincia')}, {Configuration::get('FSPA_Provincia')|escape:'htmlall':'UTF-8'}{/if}{if Configuration::get('FSPA_Pais')} ({Configuration::get('FSPA_Pais')|escape:'htmlall':'UTF-8'}){/if}<br/>			 
			 {if Configuration::get('FSPA_telefono')}Tel: {Configuration::get('FSPA_telefono')|escape:'htmlall':'UTF-8'}{/if}{if Configuration::get('FSPA_fax')} | Fax: {Configuration::get('FSPA_fax')|escape:'htmlall':'UTF-8'}{/if}<br/>
			 {if Configuration::get('FSPA_mail')}<a href="mailto:{Configuration::get('FSPA_mail')|escape:'htmlall':'UTF-8'}" style="color:{if Configuration::get('FSPA_color')}{Configuration::get('FSPA_color')|escape:'htmlall':'UTF-8'}{else}#808080{/if};">{Configuration::get('FSPA_mail')|escape:'htmlall':'UTF-8'}</a>{/if}
			 {if Configuration::get('FSPA_otro')}<br/>{Configuration::get('FSPA_otro')|escape:'htmlall':'UTF-8'}{/if}
		</td>
	</tr>
</table>              
  