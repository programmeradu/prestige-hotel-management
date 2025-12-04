{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block categories module -->
<div id="categories_block_top">
	<div class="category_top">
        <button id="toggle-category">
            <p class="icon-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </p>
            <p>{l s='categories' mod='blockcategories'}</p>
        </button>
		<div id="category_top_list" class="list" style="display: none;">
			<ul class="tree {if $isDhtml}dhtml{/if} sf-menu sf-js-enabled clearfix">

			{foreach from=$blockCategTree.children item=child name=blockCategTree}				

				{if $smarty.foreach.blockCategTree.last}
					{include file="$branche_tpl_path" node=$child last='true'}
				{else}
					{include file="$branche_tpl_path" node=$child}
				{/if}

				{if isset($blockCategTree.thumbnails) && $blockCategTree.thumbnails|count > 0}
					<div id="category-thumbnails">
					{foreach $blockCategTree.thumbnails as $thumbnail}
						<div>{$thumbnail}</div>
					{/foreach}
					</div>
				{/if}
			
				{if ($smarty.foreach.blockCategTree.iteration mod $numberColumn) == 0 AND !$smarty.foreach.blockCategTree.last}
			</ul>
		</div>
	</div>

	<div class="category_footer" style="float:left;clear:none;width:{$widthColumn}%">
			<div style="float:left" class="list">
			<ul class="tree {if $isDhtml}dhtml{/if}">
				{/if}
				{/foreach}
			</ul>
		</div>
	</div>
	<br class="clear"/>
</div>
<script>
$(document).ready(function(){
    $("#toggle-category").click(function(){
        $("#category_top_list").toggle();
    });
});
</script>
<!-- /Block categories module -->