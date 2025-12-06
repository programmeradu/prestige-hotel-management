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

{* 2. MAGICAL CHRISTMAS SHOWCASE with Real Decorations *}
<div class="holiday-showcase" style="position: relative; margin: 60px 0; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.4); min-height: 700px;">
    
    {* Background Image with Warm Christmas Overlay *}
    <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1482517967863-00e15c9b44be?w=1920&q=80'); background-size: cover; background-position: center;"></div>
    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(139, 21, 56, 0.88) 0%, rgba(76, 8, 24, 0.92) 50%, rgba(19, 1, 6, 0.95) 100%);"></div>
    
    {* ========== CHRISTMAS DECORATIONS ========== *}
    
    {* Christmas Lights Garland (Top) *}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 80px; z-index: 15;">
        <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_UJNc2t.json" background="transparent" speed="1" style="width: 100%; height: 80px;" loop autoplay></lottie-player>
    </div>
    
    {* Animated Christmas Tree (Left) *}
    <div style="position: absolute; bottom: 0; left: -20px; width: 250px; height: 300px; z-index: 10; opacity: 0.9;">
        <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_svy4ivvy.json" background="transparent" speed="1" style="width: 250px; height: 300px;" loop autoplay></lottie-player>
    </div>
    
    {* Falling Snowflakes (Right Top) *}
    <div style="position: absolute; top: 10%; right: 5%; width: 200px; height: 200px; z-index: 8; opacity: 0.7;">
        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_ystsffqy.json" background="transparent" speed="0.5" style="width: 200px; height: 200px;" loop autoplay></lottie-player>
    </div>
    
    {* More Snowflakes (Left Top) *}
    <div style="position: absolute; top: 5%; left: 15%; width: 150px; height: 150px; z-index: 8; opacity: 0.5;">
        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_ystsffqy.json" background="transparent" speed="0.3" style="width: 150px; height: 150px;" loop autoplay></lottie-player>
    </div>
    
    {* Animated Gift Box (Right Bottom) *}
    <div style="position: absolute; bottom: 5%; right: 3%; width: 180px; height: 180px; z-index: 10; opacity: 0.9;">
        <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_yzoqyyqf.json" background="transparent" speed="1" style="width: 180px; height: 180px;" loop autoplay></lottie-player>
    </div>
    
    {* Hanging Ornament (Right Top) *}
    <div class="hanging-ornament" style="position: absolute; top: 80px; right: 12%; z-index: 12;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #D4AF37 0%, #FFD700 50%, #B8860B 100%); border-radius: 50%; box-shadow: 0 10px 40px rgba(212, 175, 55, 0.5), inset 0 -10px 20px rgba(0,0,0,0.2), inset 0 10px 20px rgba(255,255,255,0.3); animation: swing 4s ease-in-out infinite; transform-origin: top center;"></div>
        <div style="width: 4px; height: 40px; background: linear-gradient(to bottom, #228B22, #006400); margin: -45px auto 0; border-radius: 2px;"></div>
    </div>
    
    {* Second Ornament *}
    <div class="hanging-ornament" style="position: absolute; top: 100px; right: 22%; z-index: 11;">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #C41E3A 0%, #FF0000 50%, #8B0000 100%); border-radius: 50%; box-shadow: 0 8px 30px rgba(196, 30, 58, 0.4), inset 0 -8px 15px rgba(0,0,0,0.2), inset 0 8px 15px rgba(255,255,255,0.3); animation: swing 3.5s ease-in-out infinite 0.5s; transform-origin: top center;"></div>
    </div>
    
    {* Sparkles Overlay *}
    <div style="position: absolute; inset: 0; background: url('https://i.gifer.com/4SWl.gif') repeat; opacity: 0.08; pointer-events: none; mix-blend-mode: screen; z-index: 5;"></div>
    
    {* ========== MAIN CONTENT ========== *}
    <div style="position: relative; z-index: 20; padding: 120px 40px 80px; text-align: center;">
        
        {* Animated Badge with Christmas Glow *}
        <div class="holiday-badge" style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, rgba(212, 175, 55, 0.25) 0%, rgba(255, 215, 0, 0.15) 100%); border: 2px solid rgba(255, 215, 0, 0.5); padding: 12px 28px; border-radius: 50px; margin-bottom: 30px; box-shadow: 0 0 30px rgba(255, 215, 0, 0.4), 0 0 60px rgba(212, 175, 55, 0.2); animation: glow-pulse 2s ease-in-out infinite;">
            <span style="font-size: 22px; animation: twinkle 1.5s ease-in-out infinite;">🎄</span>
            <span style="color: #FFD700; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 3px; text-transform: uppercase; text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);">{l s='Holiday Special'}</span>
            <span style="font-size: 22px; animation: twinkle 1.5s ease-in-out infinite 0.5s;">✨</span>
        </div>
        
        {* Main Title with Festive Styling *}
        <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2.8rem, 6vw, 4.5rem); color: #FFFFFF; margin: 0 0 20px 0; text-shadow: 0 4px 30px rgba(0,0,0,0.5), 0 0 60px rgba(255, 215, 0, 0.2); line-height: 1.15;">
            {l s='Celebrate Christmas'}<br>
            <span style="background: linear-gradient(135deg, #FFD700, #D4AF37, #FFD700); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{l s='at Prestige Hotel'}</span>
        </h2>
        
        {* Decorative Divider *}
        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin: 25px 0;">
            <div style="width: 60px; height: 2px; background: linear-gradient(to right, transparent, #D4AF37);"></div>
            <span style="font-size: 24px;">❄️</span>
            <div style="width: 60px; height: 2px; background: linear-gradient(to left, transparent, #D4AF37);"></div>
        </div>
        
        {* Subtitle *}
        <p style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; color: rgba(255, 250, 240, 0.9); max-width: 650px; margin: 0 auto 50px; line-height: 1.8;">
            {l s='Experience Cape Coast premier luxury accommodation this festive season. Indulge in world-class hospitality and create unforgettable holiday memories.'}
        </p>
        
        {* Feature Cards Grid - Wrapped Present Style *}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; max-width: 1000px; margin: 0 auto 50px;">
            
            {* Card 1 - Breakfast *}
            <div class="feature-card glass-card" style="background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(212, 175, 55, 0.08) 100%); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 2px solid rgba(212, 175, 55, 0.4); border-radius: 20px; padding: 35px 20px 25px; position: relative; overflow: visible; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <span style="position: absolute; top: -18px; right: 15px; font-size: 2.2rem; animation: twinkle 2s ease-in-out infinite;">🎀</span>
                <div style="width: 70px; height: 70px; margin: 0 auto 20px;">
                    <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_ysas4vcp.json" background="transparent" speed="1" style="width: 70px; height: 70px;" loop autoplay></lottie-player>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.15rem; color: #FFD700; margin: 0 0 10px 0; text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);">{l s='Complimentary Breakfast'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.75); margin: 0; line-height: 1.5;">{l s='Start your day with our delicious festive spread'}</p>
            </div>
            
            {* Card 2 - Dining *}
            <div class="feature-card glass-card" style="background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(212, 175, 55, 0.08) 100%); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 2px solid rgba(212, 175, 55, 0.4); border-radius: 20px; padding: 35px 20px 25px; position: relative; overflow: visible; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <span style="position: absolute; top: -18px; right: 15px; font-size: 2.2rem; animation: twinkle 2s ease-in-out infinite 0.3s;">🎀</span>
                <div style="width: 70px; height: 70px; margin: 0 auto 20px;">
                    <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_tll0j4bb.json" background="transparent" speed="1" style="width: 70px; height: 70px;" loop autoplay></lottie-player>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.15rem; color: #FFD700; margin: 0 0 10px 0; text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);">{l s='Fine Dining'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.75); margin: 0; line-height: 1.5;">{l s='Savor exquisite local and international cuisine'}</p>
            </div>
            
            {* Card 3 - Comfort *}
            <div class="feature-card glass-card" style="background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(212, 175, 55, 0.08) 100%); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 2px solid rgba(212, 175, 55, 0.4); border-radius: 20px; padding: 35px 20px 25px; position: relative; overflow: visible; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <span style="position: absolute; top: -18px; right: 15px; font-size: 2.2rem; animation: twinkle 2s ease-in-out infinite 0.6s;">🎀</span>
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);">
                    <span style="font-size: 30px;">⭐</span>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.15rem; color: #FFD700; margin: 0 0 10px 0; text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);">{l s='Luxurious Comfort'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.75); margin: 0; line-height: 1.5;">{l s='AC, High-speed WiFi, and 24/7 Concierge'}</p>
            </div>
            
            {* Card 4 - Location *}
            <div class="feature-card glass-card" style="background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(212, 175, 55, 0.08) 100%); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 2px solid rgba(212, 175, 55, 0.4); border-radius: 20px; padding: 35px 20px 25px; position: relative; overflow: visible; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <span style="position: absolute; top: -18px; right: 15px; font-size: 2.2rem; animation: twinkle 2s ease-in-out infinite 0.9s;">🎀</span>
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);">
                    <span style="font-size: 30px;">📍</span>
                </div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.15rem; color: #FFD700; margin: 0 0 10px 0; text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);">{l s='Prime Location'}</h4>
                <p style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; color: rgba(255,255,255,0.75); margin: 0; line-height: 1.5;">{l s='Minutes from Cape Coast Castle & Kakum'}</p>
            </div>
            
        </div>
        
        {* Premium CTA Button with Shimmer *}
        <a href="#hotelRoomsBlock" class="holiday-cta-btn" style="display: inline-flex; align-items: center; gap: 12px; background: linear-gradient(135deg, #FFD700 0%, #D4AF37 50%, #B8860B 100%); color: #4C0818; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 1.1rem; padding: 20px 45px; border-radius: 50px; text-decoration: none; box-shadow: 0 10px 40px rgba(212, 175, 55, 0.5), 0 0 30px rgba(255, 215, 0, 0.3); transition: all 0.4s ease; position: relative; overflow: hidden; border: 2px solid rgba(255, 255, 255, 0.3);">
            <span style="font-size: 20px;">🎁</span>
            <span>{l s='Book Your Holiday Stay'}</span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        
        {* Bottom Decorative Snowflakes *}
        <div style="margin-top: 40px; display: flex; justify-content: center; gap: 20px; opacity: 0.6;">
            <span style="font-size: 20px; animation: float 3s ease-in-out infinite;">❄️</span>
            <span style="font-size: 16px; animation: float 3s ease-in-out infinite 0.5s;">❄️</span>
            <span style="font-size: 24px; animation: float 3s ease-in-out infinite 1s;">❄️</span>
            <span style="font-size: 16px; animation: float 3s ease-in-out infinite 1.5s;">❄️</span>
            <span style="font-size: 20px; animation: float 3s ease-in-out infinite 2s;">❄️</span>
        </div>
        
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
