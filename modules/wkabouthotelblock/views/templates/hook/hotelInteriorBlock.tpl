{*
* 2010-2020 Webkul.
*
* NOTICE OF LICENSE
*
* All right is reserved,
* Please go through this link for complete license : https://store.webkul.com/license.html
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to https://store.webkul.com/customisation-guidelines/ for more information.
*
*  @author    Webkul IN <support@webkul.com>
*  @copyright 2010-2020 Webkul IN
*  @license   https://store.webkul.com/license.html
*}

{block name='hotel_interior_block'}
    {if isset($InteriorImg) && $InteriorImg}
        <div id="hotelInteriorBlock" class="row home_block_container premium-interior-block">
            <div class="col-xs-12 col-sm-12">
                {if $HOTEL_INTERIOR_HEADING && $HOTEL_INTERIOR_DESCRIPTION}
                    <div class="row home_block_desc_wrapper">
                        <div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                            {block name='hotel_interior_block_heading'}
                                <p class="home_block_heading">{$HOTEL_INTERIOR_HEADING|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            {block name='hotel_interior_block_description'}
                                <p class="home_block_description">{$HOTEL_INTERIOR_DESCRIPTION|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            <hr class="home_block_desc_line"/>
                        </div>
                    </div>
                {/if}

                {block name='hotel_interior_images'}
                    <div class="premium-gallery-container">
                        {* Main Featured Display *}
                        <div class="gallery-featured">
                            {if isset($InteriorImg[0])}
                                <div class="featured-image active" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$InteriorImg[0]['name']`.jpg")}')">
                                    <div class="image-overlay">
                                        <span class="view-btn"><i class="icon-search-plus"></i></span>
                                    </div>
                                    <a class="fancybox-trigger" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$InteriorImg[0]['name']`.jpg")}" title="{$InteriorImg[0]['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                </div>
                            {/if}
                        </div>

                        {* Side Grid *}
                        <div class="gallery-grid">
                            {foreach from=$InteriorImg item=img_name name=intImg}
                                {if !$smarty.foreach.intImg.first} {* Skip first as it's featured *}
                                    <div class="gallery-item" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$img_name['name']`.jpg")}')">
                                        <div class="image-overlay"></div>
                                        <a class="fancybox-item" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$img_name['name']`.jpg")}" title="{$img_name['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                    </div>
                {/block}
            </div>
            <hr class="home_block_seperator"/>
        </div>
    {/if}
{/block}
