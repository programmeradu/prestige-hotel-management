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
{if $demoMode ==" 1"}
	<div class="bootstrap ba_error">
		<div class="module_error alert alert-danger">
			{l s='You are use ' mod='bavideotab'}
			<strong>{l s='Demo Mode ' mod='bavideotab'}</strong>
			{l s=', so some buttons, functions will be disabled because of security. ' mod='bavideotab'}
			{l s='You can use them in Live mode after you puchase our module. ' mod='bavideotab'}
			{l s='Thanks !' mod='bavideotab'}
		</div>
	</div>
{/if}
<ul class="nav nav-tabs">
    <li class="{if $taskbar=="Settings"}active{/if}">
        <a href="{$bamodule|escape:'htmlall':'UTF-8'}&token={$token|escape:'htmlall':'UTF-8'}&configure={$configure|escape:'htmlall':'UTF-8'}&task=Settings">{l s='Settings' mod='bavideotab'}</a>
    </li>
    <li class="{if $taskbar=="VideoList"}active{/if}">
        <a href="{$bamodule|escape:'htmlall':'UTF-8'}&token={$token|escape:'htmlall':'UTF-8'}&configure={$configure|escape:'htmlall':'UTF-8'}&task=VideoList">{l s='Video List' mod='bavideotab'}</a>
    </li>
</ul>