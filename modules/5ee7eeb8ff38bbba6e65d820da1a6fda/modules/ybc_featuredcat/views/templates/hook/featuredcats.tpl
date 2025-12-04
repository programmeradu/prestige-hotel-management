{if $featuredCats}
    <ul class="ybc_featuredcats">
        {foreach from=$featuredCats item='cat'}
            <li class="ybc-fc-item-frontend {if $cat.categories}has-cat{else}no-cat{/if} {if isset($cat.image) && $cat.image}ybc-fc-has-cat-image-display{else}ybc-fc-no-cat-image{/if}">
                {if $cat.banner_position=='TOP' && ($cat.banner1 || $cat.banner2 || $cat.banner3)}
                    <div class="ybc-fc-banners banner-{$cat.bannerClass}">
                        {if $cat.banner1}{if $cat.banner1_link}<a href="{$cat.banner1_link}">{/if}<figure><img src="{$cat.banner1}" alt="{$cat.title}" /></figure>{if $cat.banner1_link}</a>{/if}{/if}
                        {if $cat.banner2}{if $cat.banner2_link}<a href="{$cat.banner2_link}">{/if}<figure><img src="{$cat.banner2}" alt="{$cat.title}" /></figure>{if $cat.banner2_link}</a>{/if}{/if}
                        {if $cat.banner3}{if $cat.banner3_link}<a href="{$cat.banner3_link}">{/if}<figure><img src="{$cat.banner3}" alt="{$cat.title}" /></figure>{if $cat.banner3_link}</a>{/if}{/if}
                    </div>
                {/if}
                <div class="fc-content-frontend">
                    <h4>{if $cat.link}<a class="title_cat" href="{$cat.link}">{/if}{$cat.title}{if $cat.link}</a>{/if}</h4>
                    <div class="cats">
                        {if $cat.image}{if $cat.link}<a class="ybc_cat_img" href="{$cat.link}">{/if}<figure><img src="{$cat.image}" title="{$cat.title}" alt="{$cat.title}" /></figure>{if $cat.link}</a>{/if}{/if}
                        {if $cat.categories}
                            <ul class="fc_categories_list">
                                {foreach from=$cat.categories item='c'}
                                    <li><a href="{$c.url}">{$c.name}</a></li>
                                {/foreach}
                            </ul>
                        {/if}
                        {if $cat.products}
                            {include file="$product_list_tpl" products=$cat.products class='ybc-featuredcats' id='ybc-featuredcats-'|cat:$cat.id_category}
                        {/if}
                    </div>
                </div> 
                {if $cat.banner_position!='TOP' && ($cat.banner1 || $cat.banner2 || $cat.banner3)}
                    <div class="ybc-fc-banners banner-{$cat.bannerClass} row">
                        {if $cat.banner1}{if $cat.banner1_link}<a href="{$cat.banner1_link}">{/if}<figure><img src="{$cat.banner1}" alt="{$cat.title}" /></figure>{if $cat.banner1_link}</a>{/if}{/if}
                        {if $cat.banner2}{if $cat.banner2_link}<a href="{$cat.banner2_link}">{/if}<figure><img src="{$cat.banner2}" alt="{$cat.title}" /></figure>{if $cat.banner2_link}</a>{/if}{/if}
                        {if $cat.banner3}{if $cat.banner3_link}<a href="{$cat.banner3_link}">{/if}<figure><img src="{$cat.banner3}" alt="{$cat.title}" /></figure>{if $cat.banner3_link}</a>{/if}{/if}
                    </div>
                {/if}               
            </li>
        {/foreach}
    </ul>
{else}
    <p id="ybc-featured-cats-warning" class="alert alert-warning">{l s='You have no featured categories. Please add some from backoffice'}</p>
{/if}