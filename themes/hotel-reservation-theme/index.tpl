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
        {assign var='hotel_header_img' value=$smarty.const._PS_IMG_DIR_|cat:Configuration::get('WK_HOTEL_HEADER_IMAGE')}
        <div style="position: absolute; inset: 0; background-image: url('{$link->getMediaLink($hotel_header_img)}'); background-size: cover; background-position: center; transition: transform 10s ease;"></div>
        
        {* Sophisticated Overlay *}
        <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(13, 19, 33, 0.4), rgba(13, 19, 33, 0.95));"></div>
        <div style="position: absolute; inset: 0; background: radial-gradient(circle at 30% 50%, transparent, rgba(13, 19, 33, 0.8));"></div>
        
        {* REAL ASSETS LAYER - Lottie Animations *}
        
        {* 3. Hanging Ornaments (Top Left) *}
        <div id="ornaments-animation" class="ornament-container" style="position: absolute; top: -20px; left: 20px; width: 200px; height: 200px; z-index: 15; animation: swing 5s ease-in-out infinite;">
            <dotlottie-player class="allowed-lottie" src="https://assets-v2.lottiefiles.com/a/19defabe-1175-11ee-82ed-f3a7235b8559/8oIBquGoPo.lottie" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></dotlottie-player>
        </div>
    </div>

    {* RIGHT SIDE: LUXURY CONTENT *}
    <div class="holiday-content" style="position: relative; padding: 40px 50px; display: flex; flex-direction: column; justify-content: center; background: linear-gradient(135deg, #0d1321 0%, #1a2332 100%); border-left: 1px solid rgba(255,255,255,0.05);">
        
        {* Gold Dust Texture Overlay *}
        <div style="position: absolute; inset: 0; background-image: url('https://www.transparenttextures.com/patterns/stardust.png'); opacity: 0.1; pointer-events: none;"></div>

        {* Snowman (Moved to Bottom Right) *}
        <div id="snowman-animation" style="position: absolute; bottom: 10px; right: 10px; width: 120px; height: 120px; z-index: 5; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3)); opacity: 1;">
            <dotlottie-player src="https://assets-v2.lottiefiles.com/a/f5b6027e-a330-11ee-b0c3-eb4933c450f1/X0ouzbU8rx.lottie" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></dotlottie-player>
        </div>

        {* Badge *}
        <div style="margin-bottom: 20px;">
            <span style="background: rgba(201, 169, 110, 0.15); color: #C9A96E; border: 1px solid rgba(201, 169, 110, 0.3); padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px;">
                {* Custom SVG Icon for Exclusive Holiday Offer *}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="#C9A96E" stroke="#C9A96E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                EXCLUSIVE HOLIDAY OFFER
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
                <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #C9A96E;">âœ“</div>
                <span style="color: #cbd5e1; font-size: 13px;">Festive Meals</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #C9A96E;">âœ“</div>
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
        /* Defensive: hide any unexpected lottie/dotlottie inside the visual area except our allowlisted ones */
        .holiday-visual lottie-player:not(.allowed-lottie),
        .holiday-visual dotlottie-player:not(.allowed-lottie) {
            display: none !important;
        }

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

{* 3. Dynamic Events - Cape Coast Live *}
<section class="experiences-section py-80" id="live-events">
        <div class="container">
                <div class="section-header events-header">
                        <span class="badge-premium">Live in Cape Coast</span>
                        <h2 class="home-section-title">Curated Experiences</h2>
                        <p class="home-section-subtitle">Real upcoming events near Prestige Hotel, powered by Eventbrite &amp; PredictHQ.</p>
                </div>

                <div id="events-showcase" class="events-grid" data-endpoint="{$link->getModuleLink('eventsfeed', 'feed')}" aria-live="polite">
                        {for $i=1 to 4}
                        <div class="event-card skeleton">
                                <div class="event-media"></div>
                                <div class="event-body">
                                        <div class="event-date shimmer"></div>
                                        <div class="event-title shimmer"></div>
                                        <div class="event-desc shimmer"></div>
                                        <div class="event-desc shimmer short"></div>
                                        <div class="event-cta shimmer"></div>
                                </div>
                        </div>
                        {/for}
                </div>

                {block name='displayHome'}
                        {if isset($HOOK_HOME) && $HOOK_HOME|trim}
                        <div id="events-fallback" class="home-hook-content" style="display:none;">
                                {$HOOK_HOME}
                        </div>
                        {/if}
                {/block}
        </div>
</section>

{literal}
<script>
(function(){
    var grid = document.getElementById('events-showcase');
    if (!grid) return;
    var endpoint = grid.getAttribute('data-endpoint');
    var fallback = document.getElementById('events-fallback');

    function formatDate(d) {
        if (!d) return '';
        var dt = new Date(d);
        if (isNaN(dt)) return '';
        return dt.toLocaleDateString('en-GB', {month:'short',day:'numeric'}) + ' - ' + dt.toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'});
    }

    function card(e) {
        var c = document.createElement('article');
        c.className = 'event-card';
        var m = document.createElement('div');
        m.className = 'event-media' + (e.image ? '' : ' event-media-ai');
        if (e.image) m.style.backgroundImage = 'url(' + e.image + ')';
        var badge = document.createElement('div');
        badge.className = 'event-badge';
        badge.textContent = (e.category || 'event').replace(/_/g,' ');
        m.appendChild(badge);
        if (e.needs_ai_image) {
            var ai = document.createElement('div');
            ai.className = 'ai-badge';
            ai.textContent = 'AI Visual';
            m.appendChild(ai);
        }
        var b = document.createElement('div');
        b.className = 'event-body';
        var dt = document.createElement('div');
        dt.className = 'event-date';
        dt.textContent = formatDate(e.start);
        b.appendChild(dt);
        var t = document.createElement('h3');
        t.className = 'event-title';
        t.textContent = e.title || 'Upcoming Event';
        b.appendChild(t);
        var desc = document.createElement('p');
        desc.className = 'event-desc';
        desc.textContent = e.description || 'Experience Cape Coast with Prestige Hotel.';
        b.appendChild(desc);
        var meta = document.createElement('div');
        meta.className = 'event-meta';
        var v = document.createElement('span');
        v.textContent = e.venue && e.venue.name ? e.venue.name : 'Cape Coast';
        meta.appendChild(v);
        var s = document.createElement('span');
        s.textContent = e.source ? e.source.toUpperCase() : 'LIVE';
        meta.appendChild(s);
        b.appendChild(meta);
        var cta = document.createElement('a');
        cta.className = 'event-cta';
        cta.href = e.url || '#';
        cta.target = '_blank';
        cta.rel = 'noopener';
        cta.textContent = 'View Details';
        if (!e.url) cta.className += ' disabled';
        b.appendChild(cta);
        c.appendChild(m);
        c.appendChild(b);
        return c;
    }

    function render(events) {
        grid.innerHTML = '';
        if (!events || !events.length) {
            grid.innerHTML = '<p class="event-empty">No live events found. Check back soon!</p>';
            if (fallback) fallback.style.display = 'block';
            return;
        }
        events.slice(0,4).forEach(function(e){ grid.appendChild(card(e)); });
    }

    fetch(endpoint + '?limit=4', {credentials:'same-origin'})
        .then(function(r){ return r.json(); })
        .then(function(data){ render(data.events || []); })
        .catch(function(){ 
            grid.innerHTML = '<p class="event-empty">Could not load events.</p>';
            if (fallback) fallback.style.display = 'block';
        });
})();
</script>
{/literal}
