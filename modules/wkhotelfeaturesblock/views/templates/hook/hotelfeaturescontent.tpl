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

{block name='hotel_features_block'}
    {if isset($hotelAmenities) && $hotelAmenities}
        <div id="hotelAmenitiesBlock" class="row home_block_container premium-amenities-block">
            <div class="col-xs-12 col-sm-12">
                {if $HOTEL_AMENITIES_HEADING && $HOTEL_AMENITIES_DESCRIPTION}
                    <div class="row home_block_desc_wrapper">
                        <div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                            {block name='hotel_features_block_heading'}
                                <p class="home_block_heading">{$HOTEL_AMENITIES_HEADING|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            {block name='hotel_features_block_description'}
                                <p class="home_block_description">{$HOTEL_AMENITIES_DESCRIPTION|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            <hr class="home_block_desc_line"/>
                        </div>
                    </div>
                {/if}

                {block name='hotel_features_images'}
                    <div class="amenities-grid-container">
                        {foreach from=$hotelAmenities item=amenity name=amenityBlock}
                            <div class="amenity-card">
                                <div class="amenity-image-wrapper">
                                    <div class="amenity-image" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotels_features_img/`$amenity.id_features_block`.jpg")}')"></div>
                                    <div class="amenity-overlay"></div>
                                </div>
                                <div class="amenity-content">
                                    <h3 class="amenity-title">{$amenity['feature_title']|escape:'htmlall':'UTF-8'}</h3>
                                    <div class="amenity-divider"></div>
                                    <p class="amenity-desc">{$amenity['feature_description']|escape:'htmlall':'UTF-8'}</p>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                {/block}
            </div>
            <hr class="home_block_seperator"/>
        </div>
    {/if}
{/block}
