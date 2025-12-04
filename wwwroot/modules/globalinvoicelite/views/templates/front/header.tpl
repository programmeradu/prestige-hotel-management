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

<!-- HEADER -->
<table style="width: 100%; padding:0; border-collapse: separate; border-spacing: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="5">
			<div style="height: 4pt;">&nbsp;</div>
		</td>
	</tr>
	<tr>		
		{assign var=foo value=","|explode:Configuration::get('FSPA_panelHeader')}
		{assign var=cont value=1}  
		{foreach from=$foo item=p}				
		{if ($cont == 1)}		
			<td style="width:32%;">			
		{else}
			<td style="width:2%;">&nbsp;</td>
			<td style="width:32%;">			
		{/if}
		 	{if $tpl_dir == ''}
		 		{include file="$tpl_dir../pdf/"|cat:$p|cat:'.tpl'}
		 	{else}
		 		{include file=$tpl_dir|cat:'pdf/'|cat:$p|cat:'.tpl'}
		 	{/if}	
		 	</td>
		{assign var=cont value=$cont+1} 
		{/foreach}		
	</tr>	
</table>
<!-- /HEADER -->

