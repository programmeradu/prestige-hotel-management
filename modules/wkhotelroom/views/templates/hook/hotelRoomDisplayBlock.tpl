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

{block name='hotel_room_block'}
    {if isset($hotelRoomDisplay) && $hotelRoomDisplay}
        <div id="hotelRoomsBlock" class="row home_block_container premium-rooms-block">
            <div class="col-xs-12 col-sm-12">
                {if $HOTEL_ROOM_DISPLAY_HEADING && $HOTEL_ROOM_DISPLAY_DESCRIPTION}
                    <div class="row home_block_desc_wrapper">
                        <div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                            {block name='hotel_room_block_heading'}
                                <p class="home_block_heading">{$HOTEL_ROOM_DISPLAY_HEADING|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            {block name='hotel_room_block_description'}
                                <p class="home_block_description">{$HOTEL_ROOM_DISPLAY_DESCRIPTION|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            <hr class="home_block_desc_line"/>
                        </div>
                    </div>
                {/if}

                {block name='hotel_room_block_content'}
                    <div class="premium-rooms-grid">
                        {foreach from=$hotelRoomDisplay item=roomDisplay name=htlRoom}
                            <div class="premium-room-card">
                                {block name='hotel_room_block_room_type_image'}
                                    <div class="room-image-wrapper">
                                        {if isset($link)}
                                            <a href="{$link->getProductLink($roomDisplay.id_product)|escape:'html':'UTF-8'}" class="room-link">
                                        {elseif isset($roomDisplay.product_link)}
                                            <a href="{$roomDisplay.product_link|escape:'html':'UTF-8'}" class="room-link">
                                        {else}
                                            <a href="#" class="room-link">
                                        {/if}
                                            <img src="{$roomDisplay.image|escape:'htmlall':'UTF-8'}" alt="{$roomDisplay.name|escape:'htmlall':'UTF-8'}" class="room-img">
                                            <div class="room-overlay">
                                                <span class="btn btn-light">{l s='View Details' mod='wkhotelroom'}</span>
                                            </div>
                                        </a>
                                        {if $roomDisplay.show_price && !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
                                            <div class="room-price-badge">
                                                {if $roomDisplay.feature_price_diff >= 0}
                                                    <span class="price">{convertPrice price = $roomDisplay.price_without_reduction}</span>
                                                {/if}
                                                <span class="period">/ {l s='Night' mod='wkhotelroom'}</span>
                                            </div>
                                        {/if}
                                    </div>
                                {/block}

                                <div class="room-content">
                                    <h3 class="room-title">
                                        {if isset($link)}
                                            <a href="{$link->getProductLink($roomDisplay.id_product)|escape:'html':'UTF-8'}">{$roomDisplay.name|escape:'htmlall':'UTF-8'}</a>
                                        {elseif isset($roomDisplay.product_link)}
                                            <a href="{$roomDisplay.product_link|escape:'html':'UTF-8'}">{$roomDisplay.name|escape:'htmlall':'UTF-8'}</a>
                                        {else}
                                            <span>{$roomDisplay.name|escape:'htmlall':'UTF-8'}</span>
                                        {/if}
                                    </h3>

                                    <div class="room-desc">
                                        {$roomDisplay.description|strip_tags:'UTF-8'|truncate:100:'...'}
                                    </div>

                                    {block name='hotel_room_block_action'}
                                        <div class="room-actions">
                                            {if isset($link)}
                                                <a class="btn btn-primary btn-book-now" href="{$link->getProductLink($roomDisplay.id_product)|escape:'html':'UTF-8'}">
                                            {elseif isset($roomDisplay.product_link)}
                                                <a class="btn btn-primary btn-book-now" href="{$roomDisplay.product_link|escape:'html':'UTF-8'}">
                                            {else}
                                                <a class="btn btn-primary btn-book-now" href="#">
                                            {/if}
                                                {if !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
                                                    {l s='Book Now' mod='wkhotelroom'}
                                                {else}
                                                    {l s='View' mod='wkhotelroom'}
                                                {/if}
                                            </a>
                                        </div>
                                    {/block}
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
