<div id="ybc-advancedcats-wrapper">
    <h6 id="ybc-advancedcats-title" class="closed">
        <span>{l s='Categories'}</span>
    </h6>
    {if $advancedCats}
        <ul class="ybc-advancedcats" id="ybc-advancedcats-toggle">
            {foreach from=$advancedCats item='cat'}
                {if $cat.category}
                    <li class="ybc-ac-item-frontend submenu-position-{strtolower($cat.submenu_position)}">                    
                        <a href="{$cat.category.url}">{if $cat.image}<img src="{$cat.image}" alt="{$cat.category.name}" />{/if}{if $cat.icon}<i class="fa {$cat.icon}"></i>{/if}{$cat.category.name}</a>
                        {if $cat.products || $cat.show_banner && $cat.banner || $cat.show_title && $cat.title || $cat.show_description && $cat.description || $cat.include_subcategories && isset($cat.category.subcatHtml) && $cat.category.subcatHtml}
                            <i class="has-subcats"></i>
                            <span class="ybc-ac-oc-btn closed">{*l s='+/-'*}</span>
                            <div class="ybc-ac-sub-block {if ($cat.banner_position=='RIGHT' || $cat.banner_position=='TOP' || $cat.banner_position=='BOTTOM' || $cat.banner_position=='LEFT')&& $cat.banner && $cat.show_banner}ybc-ac-sub-block-{$cat.banner_position}{/if}" id="ybc-ac-sub-block-{$cat.id_category}">
                                
                                    {if $cat.show_title}<h6>{$cat.title}</h6>{/if}
                                    {if $cat.show_description}<div class="ybc-ac-subcat-description">{$cat.description}</div>{/if}
                                    {if ($cat.banner_position=='TOP' || $cat.banner_position=='LEFT') && $cat.banner && $cat.show_banner}
                                        <div class="ybc-ac-banners ybc-ac-banners-{strtolower($cat.banner_position)}">
                                            {if $cat.banner}<img src="{$cat.banner}" alt="{$cat.title}" />{/if}                        
                                        </div>
                                    {/if}
                                    {if $cat.include_subcategories}{$cat.category.subcatHtml}{/if} 
                                    {if ($cat.banner_position=='BOTTOM' || $cat.banner_position=='RIGHT') && $cat.banner && $cat.show_banner}
                                        <div class="ybc-ac-banners ybc-ac-banners-{strtolower($cat.banner_position)}">
                                            {if $cat.banner}<img src="{$cat.banner}" alt="{$cat.title}" />{/if}                        
                                        </div>
                                    {/if}
                                    {if $cat.products}
                                        <div class="ybc-ac-product-list">
                                            {include file="$product_list_tpl" products=$cat.products class='ybc-advancedcats-product-list' id='ybc-advancedcats-'|cat:$cat.id_category}
                                        </div>
                                    {/if}  
                              
                            </div>
                        {/if}
                    </li>
                {/if}
            {/foreach}
        </ul>
    {/if}
</div>