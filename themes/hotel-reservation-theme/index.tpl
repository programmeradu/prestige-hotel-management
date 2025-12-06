{*
* 2007-2017 PrestaShop
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
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{* 1. Our Exquisite Rooms (Consolidated) *}
<section id="hotelRoomsBlock" class="rooms-section py-80">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title">Our Exquisite Rooms</h2>
			<div class="title-underline"></div>
			<p class="section-description">Step into the sophisticated elegance of our hotel, where every detail is designed for your comfort in mind.</p>
		</div>
		
		{* Dynamic Room Fetching *}
		{assign var='room_cat_id' value=Configuration::get('HOTEL_ROOMS_CATEGORY_ID')}
        {if !$room_cat_id}{assign var='room_cat_id' value=2}{/if}
        {assign var='hotel_rooms' value=Product::getProducts($cookie->id_lang, 0, 4, 'position', 'ASC', $room_cat_id, true)}
        
        {if $hotel_rooms}
        <div class="room-cards-grid">
            {foreach from=$hotel_rooms item=room}
                {assign var='has_image' value=false}
                {if isset($room.id_image) && $room.id_image}
                    {assign var='image_id' value=$room.id_image}
                    {assign var='has_image' value=true}
                {else}
                    {assign var='cover' value=Product::getCover($room.id_product)}
                    {if isset($cover.id_image) && $cover.id_image}
                        {assign var='image_id' value=$cover.id_image}
                        {assign var='has_image' value=true}
                    {/if}
                {/if}

                {if $has_image}
                    {assign var='image_link' value=$link->getImageLink($room.link_rewrite, $image_id, 'thickbox_default')}
                {else}
                    {assign var='image_link' value="https://via.placeholder.com/800x600/1a2332/C9A96E?text=No+Image"}
                {/if}

                <div class="room-card">
                    <div class="room-image">
                        <a href="{$room.link|escape:'html':'UTF-8'}">
                            <img src="{$image_link}" alt="{$room.name|escape:'html':'UTF-8'}" loading="lazy">
                        </a>
                        <div class="room-info-overlay">
                            <h3 class="room-name">
                                <a href="{$room.link|escape:'html':'UTF-8'}">{$room.name|escape:'html':'UTF-8'}</a>
                            </h3>
                            <div class="room-price">
                                {assign var='price_tax_incl' value=Product::getPriceStatic($room.id_product, true)}
                                <span class="price-amount">{convertPrice price=$price_tax_incl}</span>
                                <span class="price-period">/ {l s='Per Night'}</span>
                            </div>
                        </div>
                    </div>
                    <div class="room-content">
                        <p class="room-description">
                            {$room.description_short|strip_tags:'UTF-8'|truncate:80:'...'}
                        </p>
                        <a href="{$room.link|escape:'html':'UTF-8'}" class="btn-book-now">
                            {l s='Book Now'}
                        </a>
                    </div>
                </div>
            {/foreach}
        </div>
        {else}
            <p class="text-center text-muted">No rooms available at the moment.</p>
        {/if}
	</div>
</section>

{* 2. Christmas Promotional Banner (Inline Styles for Visibility Guarantee) *}
<section class="christmas-promo-banner" style="background: linear-gradient(135deg, #0B1120 0%, #2C0B0E 100%); color: #ffffff; padding: 80px 20px; border-radius: 20px; margin: 60px 0; overflow: hidden; position: relative; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
    <div class="promo-content-wrapper">
        <div class="promo-header">
            <span class="promo-badge" style="display:inline-block; background:rgba(201, 169, 110, 0.15); color:#C9A96E; padding:8px 16px; border-radius:50px; font-weight:bold; text-transform:uppercase; border:1px solid rgba(201, 169, 110, 0.3); margin-bottom:20px;">🎄 {l s='Holiday Special'}</span>
            <h2 class="promo-title" style="font-family:'Playfair Display', serif; font-size:3.5rem; color:white; margin-bottom:20px; text-shadow:0 2px 10px rgba(0,0,0,0.3);">{l s='Celebrate Christmas at Prestige Hotel'}</h2>
            <p class="promo-subtitle" style="font-size:1.2rem; color:rgba(255,255,255,0.8); max-width:700px; margin:0 auto; line-height:1.6;">{l s="Experience Cape Coast's premier luxury accommodation this festive season. Enjoy our warm hospitality and modern comforts."}</p>
        </div>
        
        <div class="promo-features-grid" style="margin: 50px 0;">
            <div class="promo-feature">
                <div class="feature-icon-circle"><i class="icon-coffee"></i></div>
                <h4>{l s='Complimentary Breakfast'}</h4>
                <p>{l s='Start your day with our delicious festive spread'}</p>
            </div>
            <div class="promo-feature">
                <div class="feature-icon-circle"><i class="icon-food"></i></div>
                <h4>{l s='Fine Dining Restaurant'}</h4>
                <p>{l s='Savor exquisite local and international cuisine'}</p>
            </div>
            <div class="promo-feature">
                <div class="feature-icon-circle"><i class="icon-star"></i></div>
                <h4>{l s='Luxurious Comfort'}</h4>
                <p>{l s='AC, High-speed WiFi, and 24/7 Concierge'}</p>
            </div>
            <div class="promo-feature">
                <div class="feature-icon-circle"><i class="icon-map-marker"></i></div>
                <h4>{l s='Prime Location'}</h4>
                <p>{l s='Minutes away from Cape Coast Castle & Kakum Park'}</p>
            </div>
        </div>

        <div class="promo-cta-container">
            <a href="#hotelRoomsBlock" class="btn-promo-cta" style="display:inline-block; background:#C9A96E; color:#1C2331; font-weight:bold; padding:18px 40px; border-radius:50px; font-size:16px; text-decoration:none; box-shadow:0 10px 30px rgba(201, 169, 110, 0.3);">{l s='Book Your Holiday Stay'}</a>
        </div>
    </div>
    {* Subtle Snow Effect *}
    <div class="snow-overlay"></div>
</section>

{* 3. Curated Experiences (Hooks for Blog/Other) *}
<section class="experiences-section py-80">
	<div class="container">
		<div class="section-header">
			<h2 class="home-section-title">Curated Experiences</h2>
			<p class="home-section-subtitle">Enjoy Prestige Hotel, where natural bay space activities, our local experiences await in your stay.</p>
		</div>
		
		{block name='displayHome'}
			{if isset($HOOK_HOME) && $HOOK_HOME|trim}
                {* Hide duplicate rooms block if it appears here *}
                <div class="home-hook-content">
				    {$HOOK_HOME}
                </div>
			{/if}
		{/block}
	</div>
</section>
