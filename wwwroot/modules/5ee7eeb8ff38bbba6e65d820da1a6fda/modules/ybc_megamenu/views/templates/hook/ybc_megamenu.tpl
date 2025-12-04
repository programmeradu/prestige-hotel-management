{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{*
* Copyright: YourBestCode.Com
* Email: support@yourbestcode.com
*}
{if $menus}
    <div class="ybc-menu-wrapper ybc-menu-{$effect}{if isset($customClass) && $customClass} {$customClass}{/if}{if isset($mobileImage) && !$mobileImage} ybc-menu-hide-image-on-mobile{/if}">
    	
        <div class="ybc-menu-toggle">
          <div class="ybc-menu-button-toggle">
            <i class="icon-menu"></i>
            <p>{l s='Menus'}</p>
          </div>
        </div>
        
        <div class="ybc-menu-main-content collapse" id="ybc-menu-main-content">
            <ul class="ybc-menu">  
    			{foreach from=$menus item=menu}
                    {if $menu.enabled}
        				<li class="ybc-menu-item {if $menu.custom_class}{$menu.custom_class}{/if} ybc-menu-type-{strtolower($menu.menu_type)}{if $menu.column_type} ybc-menu-column-type-{strtolower($menu.column_type)}{else} ybc-menu-column-type-left{/if}" id="ybc-menu-{$menu.id_menu}">	
                                <!-- level 1 -->
                            	<a class="ybc-menu-item-link" href="{$menu.url}"> {if $menu.show_icon && $menu.icon}<i class="fa {$menu.icon}"></i>{/if}<span>{$menu.title}</span>{if isset($menu.columns) && $menu.columns} <span class="icon-submenu-exist"></span>{/if}</a>
                                <!-- /leve 1 -->
                                <!-- Columns -->
                                {if isset($menu.columns) && $menu.columns}
                                    <span class="ybc-mm-control closed"></span>
                                    <div {if $menu.sub_menu_max_width && $menu.sub_menu_max_width}style="max-width: {(int)$menu.sub_menu_max_width}%;"{/if} class="ybc-menu-columns-wrapper ybc-mm-control-content" id="ybc-menu-columns-wrapper-{$menu.id_menu}">
                                        
                                        {foreach from=$menu.columns item=column}
                                            {if $column.enabled}
                                				<div class="ybc-menu-column-item ybc-menu-column-size-{$column.column_size} {if $column.custom_class}{$column.custom_class}{/if}" id="ybc-menu-column-{$column.id_column}">
                                                    <!-- Column content -->     
                                                    {if $column.show_title && $column.title || $column.show_image && $column.image || $column.show_description && $column.description}
                                                        <div class="ybc-menu-column-top">                                                 
                                                            {if $column.show_title && $column.title}<h6>{$column.title}</h6>{/if}
                                                            {if $column.show_image && $column.image}<img src="{$column.image}" alt="{$column.title}" />{/if}
                                                            {if $column.show_description && $column.description}<div class="ybc_description_block">{$column.description}</div>{/if}
                                                        </div>
                                                    {/if}  
                                                    <!-- /Column content -->                                                    	
                                                    <!-- Blocks -->
                                                    {if isset($column.blocks) && $column.blocks}                                                        
                                                            {foreach from=$column.blocks item=block}
                                                                {if $block.enabled}
                                                                    <div class="ybc-menu-block {if $block.custom_class}{$block.custom_class}{/if} ybc-menu-block-type-{strtolower($block.block_type)}">
                                                                        {if $block.show_title && $block.title || $block.show_image && $block.image || $block.show_description && $block.description}
                                                                            <div class="ybc-menu-block-top">                                                 
                                                                                {if $block.show_title && $block.title}<h6>{$block.title}</h6>{/if}
                                                                                {if $block.show_image && $block.image}<div class="ybc-menu-block-img"><img src="{$block.image}" alt="{$block.title}" /></div>{/if}
                                                                                {if $block.show_description && $block.description}<p>{$block.description}</p>{/if}
                                                                            </div>
                                                                        {/if} 
                                                                        {if $block.block_type=='HTML' && isset($block.params.HTML) && $block.params.HTML}
                                                                            <div class="ybc-menu-block-bottom">
                                                                                {base64_decode($block.params.HTML)}
                                                                            </div>
                                                                        {/if}     
                                                                        {if $block.block_type!='HTML' && isset($block.urls) && $block.urls}
                                                                            <div class="ybc-menu-block-bottom">
                                                                                <ul class="ybc-menu-block-links">
                                                                                    {foreach from=$block.urls item='url'}                                                                                        
                                                                                        <li {if isset($url.info) && $url.info}class="ybc-mm-product-block"{/if}>
                                                                                            {if isset($url.id)}
                                                                                                {assign var="subcatId" value=$url.id}
                                                                                            {else}
                                                                                                {assign var="subcatId" value=0}
                                                                                            {/if}
                                                                                            {if isset($url.info) && $url.info}
                                                                                                <a class="ybc-mm-product-img-link" href="{$url.url}"><img src="{$url.info.img_url}" alt="{$url.title}" /></a>
                                                                                            {/if}
                                                                                                <a class="{if isset($url.info) && $url.info}ybc-mm-product-link{else}ybc-mm-item-link{/if}" href="{$url.url}">{$url.title}{if isset($block.subCategories.$subcatId) && $block.subCategories.$subcatId} <span class="icon-subcat"></span>{/if}</a>  
                                                                                            {if isset($url.info) && $url.info}
                                                                                                <div itemtype="http://schema.org/Product" itemscope="" class="ybc-mm-product-review">{hook h='displayYbcReviews' product=$url.info.product}</div>
                                                                                                <div class="ybc-mm-price-row">                                                                                                    
                                                                                                    {if $url.info.price != $url.info.old_price}                                                                                                    
                                                                                                            <span class="ybc-mm-old-price">{$url.info.old_price}</span>
                                                                                                            <span class="ybc-mm-price">{$url.info.price}</span>
                                                                                                            <span class="ybc-mm-discount-percent">-{$url.info.discount_percent}%</span>
                                                                                                            <span class="ybc-mm-discount-saveup">{l s='Save up '}<span class="ybc-mm-discount-saveup-amount">{$url.info.discount_amount}</span></span>                                                                                                        
                                                                                                    {else}
                                                                                                        <span class="ybc-mm-price">{$url.info.price}</span>
                                                                                                    {/if}
                                                                                                </div>
                                                                                                {if $url.info.description}
                                                                                                    <div class="ybc-mm-description">{strip_tags($url.info.description)|truncate:100:'...'|escape:'html':'UTF-8'}</div>
                                                                                                {/if}
                                                                                            {/if}                                                                                            
                                                                                            {if isset($block.subCategories.$subcatId) && $block.subCategories.$subcatId}
                                                                                                <span class="ybc-mm-control closed"></span>
                                                                                                <ul class="ybc-menu-block-sub-links ybc-mm-control-content">                                                                                                    
                                                                                                    {foreach from=$block.subCategories.$subcatId item='subcat'}
                                                                                                        <li><a data-hover="{$subcat.title}" href="{$subcat.url}">{$subcat.title}</a></li>
                                                                                                    {/foreach}
                                                                                                </ul>
                                                                                            {/if}
                                                                                           
                                                                                        </li>
                                                                                    {/foreach}
                                                                                </ul>
                                                                            </div>
                                                                        {/if}                                                      				
                                                                    </div>
                                                                {/if}
                                                			{/foreach}                                                        
                                                    {/if}
                                                   <!-- /Blocks -->	
                                				</div>   
                                             {/if}                                     
                            			{/foreach}
                                        
                                    </div>
                                {/if}
                             <!-- /Columns  -->		
        				</li> 
                    {/if}                   
    			{/foreach}
    	   </ul>
        </div>
    </div>
{/if}