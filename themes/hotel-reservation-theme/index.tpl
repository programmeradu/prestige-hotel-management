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

{* 2. Premium Holiday Feature Section with Real Assets *}
<div class="holiday-showcase" style="position: relative; margin: 60px 0; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.3);">
    
    {* Background Image with Overlay *}
    <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1512389142860-9c449e58a543?w=1920&q=80'); background-size: cover; background-position: center;"></div>
    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(139, 21, 56, 0.92) 0%, rgba(76, 8, 24, 0.95) 50%, rgba(19, 1, 6, 0.97) 100%);"></div>
    
    {* Snowflake Lottie Animation (Top Right) *}
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; opacity: 0.3; pointer-events: none;">
        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_ystsffqy.json" background="transparent" speed="0.5" loop autoplay></lottie-player>
    </div>
    
    {* Snowflake Lottie Animation (Bottom Left) *}
    <div style="position: absolute; bottom: -80px; left: -80px; width: 350px; height: 350px; opacity: 0.25; pointer-events: none; transform: rotate(180deg);">
        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_ystsffqy.json" background="transparent" speed="0.3" loop autoplay></lottie-player>
    </div>
    
    {* Main Content *}
    <div style="position: relative; z-index: 2; padding: 80px 40px; text-align: center;">
        
        {* Badge *}
        <div style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, rgba(212, 175, 55, 0.2) 0%, rgba(212, 175, 55, 0.1) 100%); border: 1px solid rgba(212, 175, 55, 0.4); padding: 10px 24px; border-radius: 50px; margin-bottom: 30px; animation: pulse-glow 2s ease-in-out infinite;">
            <span style="font-size: 18px;">🎄</span>
            <span style="color: #D4AF37; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase;">{l s='Holiday Special'}</span>
            <span style="font-size: 18px;">✨</span>
        </div>
        
        {* Main Title *}
        <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 5vw, 4rem); color: #FFFFFF; margin: 0 0 20px 0; text-shadow: 0 4px 30px rgba(0,0,0,0.5); line-height: 1.2;">
            {l s='Celebrate Christmas'}<br>
            <span style="color: #D4AF37;">{l s='at Prestige Hotel'}</span>
        </h2>
        
        {* Subtitle *}
        <p style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; color: rgba(240, 230, 210, 0.9); max-width: 600px; margin: 0 auto 50px; line-height: 1.7;">
            {l s='Experience Cape Coast premier luxury accommodation this festive season. Indulge in world-class hospitality and create unforgettable holiday memories.'}
        </p>
        
        {* Feature Cards Grid *}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; max-width: 1000px; margin: 0 auto 50px;">
            
            {* Card 1 *}
            <div class="glass-card" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; padding: 30px 20px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);">
                    <i class="icon-coffee" style="font-size: 24px; color: #4C0818;"></i>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.1rem; color: #D4AF37; margin: 0 0 10px 0;">{l s='Complimentary Breakfast'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.7); margin: 0; line-height: 1.5;">{l s='Start your day with our delicious festive spread'}</p>
            </div>
            
            {* Card 2 *}
            <div class="glass-card" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; padding: 30px 20px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);">
                    <i class="icon-food" style="font-size: 24px; color: #4C0818;"></i>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.1rem; color: #D4AF37; margin: 0 0 10px 0;">{l s='Fine Dining'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.7); margin: 0; line-height: 1.5;">{l s='Savor exquisite local and international cuisine'}</p>
            </div>
            
            {* Card 3 *}
            <div class="glass-card" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; padding: 30px 20px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);">
                    <i class="icon-star" style="font-size: 24px; color: #4C0818;"></i>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.1rem; color: #D4AF37; margin: 0 0 10px 0;">{l s='Luxurious Comfort'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.7); margin: 0; line-height: 1.5;">{l s='AC, High-speed WiFi, and 24/7 Concierge'}</p>
            </div>
            
            {* Card 4 *}
            <div class="glass-card" style="background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; padding: 30px 20px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);">
                    <i class="icon-map-marker" style="font-size: 24px; color: #4C0818;"></i>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.1rem; color: #D4AF37; margin: 0 0 10px 0;">{l s='Prime Location'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.7); margin: 0; line-height: 1.5;">{l s='Minutes from Cape Coast Castle & Kakum'}</p>
            </div>
            
        </div>
        
        {* CTA Button *}
        <a href="#hotelRoomsBlock" class="holiday-cta-btn" style="display: inline-flex; align-items: center; gap: 12px; background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%); color: #4C0818; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 1rem; padding: 18px 40px; border-radius: 50px; text-decoration: none; box-shadow: 0 10px 40px rgba(212, 175, 55, 0.4); transition: all 0.4s ease; position: relative; overflow: hidden;">
            <span>{l s='Book Your Holiday Stay'}</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        
    </div>
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
