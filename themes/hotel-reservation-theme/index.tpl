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

{* 2. PREMIUM COMPACT CHRISTMAS BANNER *}
<div class="holiday-showcase-compact" style="position: relative; margin: 40px auto; max-width: 1100px; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); background: #0f172a; display: grid; grid-template-columns: 1.2fr 1fr;">

    {* LEFT SIDE: VISUAL IMMERSION *}
    <div class="holiday-visual" style="position: relative; min-height: 400px; overflow: hidden;">
        {* Real Hotel Image as Base *}
        <div style="position: absolute; inset: 0; background-image: url('{$link->getMediaLink("`$smarty.const._PS_IMG_`{Configuration::get('WK_HOTEL_HEADER_IMAGE')}")}'); background-size: cover; background-position: center; transition: transform 10s ease;"></div>
        
        {* Sophisticated Overlay *}
        <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(13, 19, 33, 0.4), rgba(13, 19, 33, 0.95));"></div>
        <div style="position: absolute; inset: 0; background: radial-gradient(circle at 30% 50%, transparent, rgba(13, 19, 33, 0.8));"></div>
        
        {* REAL ASSETS LAYER - Lottie Animations *}
        
        {* 1. Premium Christmas Tree (Center Left) *}
        <div style="position: absolute; bottom: 0; left: -30px; width: 320px; height: 320px; z-index: 10; filter: drop-shadow(0 10px 30px rgba(0,0,0,0.5));">
            <lottie-player src="https://assets10.lottiefiles.com/private_files/lf30_m6j5igxb.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
        </div>

        {* 2. Wrapped Gifts (Bottom Center) *}
        <div style="position: absolute; bottom: 20px; left: 190px; width: 200px; height: 200px; z-index: 12; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.4));">
             <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_penc2u.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
        </div>
        
        {* 3. Hanging Ornaments (Top Left) *}
        <div class="ornament-container" style="position: absolute; top: -20px; left: 40px; width: 150px; height: 150px; z-index: 15; animation: swing 5s ease-in-out infinite;">
            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_1LhsaB.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
        </div>


        {* Lottie Snow Effect (Subtle) *}
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.6; mix-blend-mode: screen;">
             <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_ystsffqy.json" background="transparent" speed="0.5" loop autoplay style="width: 100%; height: 100%;"></lottie-player>
        </div>
    </div>

    {* RIGHT SIDE: LUXURY CONTENT *}
    <div class="holiday-content" style="position: relative; padding: 40px 50px; display: flex; flex-direction: column; justify-content: center; background: linear-gradient(135deg, #0d1321 0%, #1a2332 100%); border-left: 1px solid rgba(255,255,255,0.05);">
        
        {* Gold Dust Texture Overlay *}
        <div style="position: absolute; inset: 0; background-image: url('https://www.transparenttextures.com/patterns/stardust.png'); opacity: 0.1; pointer-events: none;"></div>

        {* Badge *}
        <div style="margin-bottom: 20px;">
            <span style="background: rgba(201, 169, 110, 0.15); color: #C9A96E; border: 1px solid rgba(201, 169, 110, 0.3); padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px;">
                <span style="animation: pulse 2s infinite;">✨</span> EXCLUSIVE HOLIDAY OFFER
            </span>
        </div>

        {* Heading *}
        <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 3vw, 2.8rem); color: #fff; line-height: 1.2; margin-bottom: 15px;">
            Celebrate Christmas in <span style="color: #C9A96E; font-style: italic;">Luxury</span>
        </h2>

        {* Description *}
        <p style="color: #94a3b8; font-size: 1rem; line-height: 1.6; margin-bottom: 30px; font-family: 'Montserrat', sans-serif;">
            Immerse yourself in the magic of Cape Coast this season. Enjoy our festive dining, premium suites, and complimentary holiday breakfast.
        </p>

        {* Features List (Compact) *}
        <div style="display: flex; gap: 20px; margin-bottom: 35px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #C9A96E;">✓</div>
                <span style="color: #cbd5e1; font-size: 13px;">Festive Dinner</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #C9A96E;">✓</div>
                <span style="color: #cbd5e1; font-size: 13px;">Live Music</span>
            </div>
        </div>

        {* Call to Action *}
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="#hotelRoomsBlock" class="btn-holiday-gold" style="background: linear-gradient(135deg, #C9A96E 0%, #B08D55 100%); color: #0d1321; padding: 14px 32px; border-radius: 8px; font-weight: 700; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(201, 169, 110, 0.2); display: inline-flex; align-items: center; gap: 10px;">
                Book Now 
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <span style="color: #64748b; font-size: 12px;">Limited rooms available</span>
        </div>
    </div>

    {* Inline CSS for responsive grid *}
    <style>
        @media (max-width: 900px) {
            .holiday-showcase-compact {
                grid-template-columns: 1fr !important;
                margin: 30px 15px !important;
                max-width: 100% !important;
            }
            .holiday-visual {
                min-height: 250px !important;
            }
            .holiday-content {
                padding: 30px 20px !important;
            }
        }
    </style>
</div>

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
