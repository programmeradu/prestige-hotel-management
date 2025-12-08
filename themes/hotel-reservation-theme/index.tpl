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

                {* Generate product link properly *}
                {assign var='room_link' value=$link->getProductLink($room.id_product, $room.link_rewrite)}
                
                <div class="room-card">
                    <div class="room-image">
                        <a href="{$room_link|escape:'html':'UTF-8'}">
                            <img src="{$image_link}" alt="{$room.name|escape:'html':'UTF-8'}" loading="lazy">
                        </a>
                        <div class="room-info-overlay">
                            <h3 class="room-name">
                                <a href="{$room_link|escape:'html':'UTF-8'}">{$room.name|escape:'html':'UTF-8'}</a>
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
                        <a href="{$room_link|escape:'html':'UTF-8'}" class="btn-book-now">
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
<link rel="stylesheet" href="{$css_dir}christmas.css" type="text/css" media="all" />
<div class="holiday-wrapper" style="width: 100%; padding: 0 5%;">
<div class="holiday-showcase-compact" style="position: relative; margin: 40px auto; max-width: 1800px; width: 100%; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); background: #0f172a; display: grid; grid-template-columns: 1.2fr 1fr;">

    {* LEFT SIDE: CHRISTMAS TREE ANIMATION WITH HERO BACKDROP & ORNAMENTS *}
    <div class="holiday-visual christmas-tree-container" style="position: relative; min-height: 400px; overflow: hidden; background-color: #151522;">
        {* Hero image as soft backdrop (with fallback) *}
        {assign var='hotel_header_img' value=$smarty.const._PS_IMG_|cat:Configuration::get('WK_HOTEL_HEADER_IMAGE')}
        {if $hotel_header_img}
            <div style="position: absolute; inset: 0; background-image: url('{$link->getMediaLink($hotel_header_img)|escape:'htmlall':'UTF-8'}'); background-size: cover; background-position: center; opacity: 0.35; filter: blur(1px);"></div>
        {else}
            <div style="position: absolute; inset: 0; background: linear-gradient(135deg, #0f172a, #1a2332); opacity: 0.35; filter: blur(1px);"></div>
        {/if}
        {* Gradient overlays to keep focus on the tree *}
        <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(13, 19, 33, 0.25), rgba(13, 19, 33, 0.4));"></div>
        <div style="position: absolute; inset: 0; background: radial-gradient(circle at 30% 50%, transparent 0%, rgba(13, 19, 33, 0.35) 70%);"></div>

        <svg class="mainSVG" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 800 600" style="width: 100%; height: 100%;">
            <defs>
                <circle id="circ" class="particle" cx="0" cy="0" r="1" />
                <polygon id="star" class="particle" points="4.55,0 5.95,2.85 9.1,3.3 6.82,5.52 7.36,8.65 4.55,7.17 1.74,8.65 2.27,5.52 0,3.3 3.14,2.85 " />
                <polygon id="cross" class="particle" points="4,3.5 2.5,2 4,0.5 3.5,0 2,1.5 0.5,0 0,0.5 1.5,2 0,3.5 0.5,4 2,2.5 3.5,4 " />
                <path id="heart" class="particle" d="M2.9,0C2.53,0,2.2,0.18,2,0.47C1.8,0.18,1.47,0,1.1,0C0.49,0,0,0.49,0,1.1 C0,2.6,1.56,4,2,4s2-1.4,2-2.9C4,0.49,3.51,0,2.9,0z" />
                <radialGradient id="grad" cx="3" cy="3" r="6" gradientUnits="userSpaceOnUse">
                    <stop offset="0" style="stop-color:red" />
                    <stop offset="0.4" style="stop-color:#334673" />
                    <stop offset="0.6" style="stop-color:#EDDDC4" />
                    <stop offset="0.9" style="stop-color:#FEE8C7" />
                    <stop offset="1" style="stop-color:red" />
                </radialGradient>
                <radialGradient id="dotGrad" cx="0" cy="0" r="50" gradientUnits="userSpaceOnUse">
                    <stop offset="0" style="stop-color:#FFFFFF;stop-opacity:1" />
                    <stop offset="0.1" style="stop-color:#0867C7;stop-opacity:0.6" />
                    <stop offset="1" style="stop-color:#081029;stop-opacity:0" />
                </radialGradient>
                <mask id="treePathMask">
                    <path class="treePathMask" fill="none" stroke-width="18" stroke="#FFF" d="M252.9,447.9c0,0-30.8-21.6,33.9-44.7c64.7-23.1,46.2-37,33.9-41.6 c-12.3-4.6-59.3-11.6-42.4-28.5s114-52.4,81.7-66.2c-32.4-13.9-58.5-10.8-35.4-29.3s66.2-101.7,70.9-115.6 c4.4-13.2,16.9-18.5,24.7,0c7.7,18.5,44.7,100.1,67.8,115.6c23.1,15.4-10.8,21.6-26.2,24.7c-15.4,3.1-20,33.9,33.9,49.3 c53.9,15.4,47.8,40.1,27.7,44.7c-20,4.6-63.2,4.6-27.7,32.4s98.6,21.6,61.6,60.1" />
                </mask>
                <mask id="treeBottomMask">
                    <path class="treeBottomMask" stroke="#FFF" stroke-width="8" d="M207.5,484.1c0,0,58.5-43.1,211.1-3.1s191-16.9,191-16.9" />
                </mask>
                <mask id="treePotMask">
                    <path class="treePotMask" stroke="#FFF" stroke-width="8" d="M374.3,502.5c0,0-4.6,20,7.7,29.3c12.3,9.2,40.1,7.7,50.8,0s10.8-23.1,10.8-29.3" />
                </mask>
                <filter id="glow" x="-150%" y="-150%" width="280%" height="280%">
                    <feOffset result="offOut" in="SourceGraphic" dx="0" dy="0" />
                    <feGaussianBlur in="offOut" stdDeviation="16" result="blur" />
                    <feComponentTransfer>
                        <feFuncR type="discrete" tableValues="0.8" />
                        <feFuncG type="discrete" tableValues="0.3" />
                        <feFuncB type="discrete" tableValues="0.2" />
                    </feComponentTransfer>
                    <feComposite in="SourceGraphic" operator="over" />
                </filter>
            </defs>
            <g class="whole">
                <g class="pContainer"></g>
                <g class="tree" mask="url(#treePathMask)">
                    <path d="M252.95,447.85a20.43,20.43,0,0,1-5.64-6.24,14,14,0,0,1-1.91-8.22,16.93,16.93,0,0,1,3.06-8,33.16,33.16,0,0,1,5.79-6.28A74.78,74.78,0,0,1,268.54,410a163.48,163.48,0,0,1,15.52-6.84c10.54-3.93,21-8.07,30.72-13.46a80.83,80.83,0,0,0,7-4.37,37.51,37.51,0,0,0,6.13-5.24c1.75-1.92,3.14-4.18,3.25-6.35s-1.12-4.18-3-5.81a25,25,0,0,0-6.72-3.91,61.25,61.25,0,0,0-7.8-2.42c-5.41-1.4-10.91-2.72-16.38-4.32a84.17,84.17,0,0,1-16.2-6.19,28.26,28.26,0,0,1-3.86-2.5,15.06,15.06,0,0,1-3.44-3.63,9,9,0,0,1-1.51-5.47,10.22,10.22,0,0,1,.61-2.78,12.88,12.88,0,0,1,1.2-2.34,26.73,26.73,0,0,1,6.58-6.56c2.35-1.76,4.76-3.33,7.19-4.84,4.87-3,9.82-5.75,14.77-8.46,9.91-5.4,19.88-10.59,29.63-16.08,4.87-2.75,9.68-5.56,14.33-8.56A81.88,81.88,0,0,0,359.45,280a23,23,0,0,0,2.41-2.79,8.36,8.36,0,0,0,1.35-2.65,2.13,2.13,0,0,0-.17-1.7,5.53,5.53,0,0,0-1.88-1.77,13.15,13.15,0,0,0-1.49-.83c-.52-.26-1.1-.49-1.76-.77-1.27-.53-2.55-1-3.83-1.53q-3.86-1.48-7.8-2.77c-5.26-1.74-10.6-3.23-16-4.79-2.72-.79-5.47-1.58-8.29-2.61a31.74,31.74,0,0,1-4.33-1.92,14.39,14.39,0,0,1-2.29-1.53,8.74,8.74,0,0,1-2.22-2.66,7.2,7.2,0,0,1-.78-4,9.09,9.09,0,0,1,1-3.24,18.93,18.93,0,0,1,3-4.21,44.88,44.88,0,0,1,3.29-3.19c.56-.5,1.12-1,1.68-1.45l1.61-1.33a84,84,0,0,0,10.88-11.88,326.2,326.2,0,0,0,18.79-27.53c5.88-9.5,11.48-19.19,16.89-29S380.1,146.16,385,136.13c1.22-2.51,2.42-5,3.57-7.54s2.29-5.09,3.14-7.45l.36-1c.14-.38.26-.75.42-1.12.29-.75.64-1.48,1-2.21a25.51,25.51,0,0,1,2.65-4.21,19.15,19.15,0,0,1,3.76-3.69,13.74,13.74,0,0,1,5.24-2.42,12.11,12.11,0,0,1,6.12.25,14.59,14.59,0,0,1,5,2.79,20.59,20.59,0,0,1,3.47,3.79,30.33,30.33,0,0,1,2.5,4.1c.35.7.7,1.39,1,2.1l.46,1.05.4,1,1.64,3.84,3.39,7.67q6.88,15.32,14.36,30.37c5,10,10.18,19.94,15.69,29.65a274.94,274.94,0,0,0,17.9,28A73.36,73.36,0,0,0,487.74,233c.49.4,1,.8,1.48,1.15l1.7,1.19a35,35,0,0,1,3.66,3,17.84,17.84,0,0,1,3.32,4.08,10.83,10.83,0,0,1,1.14,2.94,8.54,8.54,0,0,1,0,3.54,10.27,10.27,0,0,1-3.22,5.39,20.71,20.71,0,0,1-4.15,2.91,49,49,0,0,1-8.4,3.46,154,154,0,0,1-16.77,4.09l-4.15.81a9.18,9.18,0,0,0-2.87,1.08,9.51,9.51,0,0,0-4,4.7,12.55,12.55,0,0,0-.67,6.58,19.5,19.5,0,0,0,2.46,6.74A37.19,37.19,0,0,0,468,295.75a75,75,0,0,0,14.14,7.86,129.67,129.67,0,0,0,15.58,5.49A141.4,141.4,0,0,1,513.88,315a75,75,0,0,1,15.19,8.65,37.29,37.29,0,0,1,6.55,6.24,21.05,21.05,0,0,1,4.31,8.49,14.43,14.43,0,0,1-1.24,9.88,18.08,18.08,0,0,1-6.66,6.94,26.74,26.74,0,0,1-8.56,3.33c-2.84.61-5.65,1.06-8.44,1.49-5.58.86-11.13,1.61-16.52,2.77a53.48,53.48,0,0,0-7.81,2.22c-2.43.94-4.81,2.22-6,3.93a4.34,4.34,0,0,0-.77,2.82,8.45,8.45,0,0,0,1,3.29,28,28,0,0,0,4.82,6.25,80.74,80.74,0,0,0,12.81,10.4c9.29,6,19.72,10.29,30.24,14.17,5.27,1.95,10.59,3.79,15.85,5.86,2.63,1,5.24,2.14,7.79,3.39a37.94,37.94,0,0,1,7.28,4.51,11.9,11.9,0,0,1,3.63,15.57,34.68,34.68,0,0,1-4.53,7.16,77.45,77.45,0,0,1-5.64,6.29,77.31,77.31,0,0,0,5.41-6.46,34.27,34.27,0,0,0,4.22-7.21,12.64,12.64,0,0,0,.88-8,12.44,12.44,0,0,0-4.71-6.43,37.71,37.71,0,0,0-7.15-4.16c-2.53-1.16-5.13-2.18-7.76-3.14-5.26-1.91-10.62-3.62-16-5.44-10.65-3.63-21.34-7.64-31.11-13.64a83.84,83.84,0,0,1-13.61-10.49,31.27,31.27,0,0,1-5.6-6.94,12,12,0,0,1-1.55-4.68,8.17,8.17,0,0,1,.19-2.7,8.56,8.56,0,0,1,1.09-2.5,12.1,12.1,0,0,1,3.6-3.44,24.27,24.27,0,0,1,4.08-2.08,57.3,57.3,0,0,1,8.36-2.56c5.59-1.31,11.19-2.17,16.71-3.12,2.76-.48,5.5-1,8.15-1.59a22.1,22.1,0,0,0,7-2.87,13.3,13.3,0,0,0,4.82-5.15,9.42,9.42,0,0,0,.69-6.53,16,16,0,0,0-3.42-6.33,33.25,33.25,0,0,0-5.73-5.27,69.74,69.74,0,0,0-14.19-7.8,135.81,135.81,0,0,0-15.61-5.42,135.53,135.53,0,0,1-16.3-5.51,81,81,0,0,1-15.41-8.31,43.39,43.39,0,0,1-12.6-13,25.53,25.53,0,0,1-3.34-9,19.13,19.13,0,0,1,1-10,16.17,16.17,0,0,1,6.69-8,15.88,15.88,0,0,1,5-1.93l4.13-.84a147.75,147.75,0,0,0,16-4,42.41,42.41,0,0,0,7.17-3,14,14,0,0,0,2.74-1.92,3.42,3.42,0,0,0,1.12-1.68,2.41,2.41,0,0,0-.43-1.61,11.07,11.07,0,0,0-2-2.4,28,28,0,0,0-2.92-2.31l-1.76-1.22c-.65-.46-1.26-.94-1.86-1.43a59,59,0,0,1-6.43-6.27c-2-2.19-3.79-4.44-5.54-6.74a267,267,0,0,1-18.55-28.74c-5.63-9.85-10.89-19.86-16-30s-9.91-20.31-14.57-30.61l-3.45-7.76L417,124.48l-.42-1-.39-.88c-.25-.59-.54-1.15-.82-1.71a22.74,22.74,0,0,0-1.89-3.09,13,13,0,0,0-2.2-2.42,7,7,0,0,0-2.31-1.33,4.49,4.49,0,0,0-2.22-.09,8.55,8.55,0,0,0-4.59,3.32,17.85,17.85,0,0,0-1.84,2.92c-.26.54-.51,1.07-.73,1.64-.12.27-.22.56-.32.85l-.35,1c-1.06,2.93-2.23,5.47-3.42,8.1s-2.42,5.16-3.67,7.7c-5,10.18-10.29,20.16-15.77,30.05s-11.17,19.66-17.16,29.28a310.2,310.2,0,0,1-19.39,28.11,90.46,90.46,0,0,1-12,12.85l-1.65,1.35c-.52.43-1,.85-1.53,1.29a38,38,0,0,0-2.79,2.65,12.42,12.42,0,0,0-1.94,2.57,2.33,2.33,0,0,0-.28.76c0,.11,0,0,0,.09a4.57,4.57,0,0,0,1.7,1.35,25.15,25.15,0,0,0,3.36,1.51c2.46.92,5.11,1.72,7.79,2.52,5.36,1.58,10.84,3.16,16.25,5q4.06,1.37,8.08,2.94c1.34.53,2.67,1.07,4,1.63.64.27,1.36.57,2.1.94a19.66,19.66,0,0,1,2.18,1.24,11.85,11.85,0,0,1,4,4.13,8.64,8.64,0,0,1,1,3.24,9.11,9.11,0,0,1-.27,3.23,14.48,14.48,0,0,1-2.42,4.85,29.32,29.32,0,0,1-3.14,3.56,87.46,87.46,0,0,1-14,10.47c-4.85,3-9.79,5.84-14.76,8.55-9.94,5.42-20,10.49-29.91,15.72-5,2.62-9.88,5.28-14.63,8.12-2.37,1.42-4.7,2.89-6.88,4.46a22.06,22.06,0,0,0-5.45,5.14,8,8,0,0,0-.76,1.39,5.36,5.36,0,0,0-.33,1.32,4.1,4.1,0,0,0,.69,2.53,15.62,15.62,0,0,0,5.49,4.62A80.14,80.14,0,0,0,298.56,353c5.31,1.66,10.73,3.06,16.18,4.58a64.81,64.81,0,0,1,8.26,2.74,27.74,27.74,0,0,1,7.69,4.74,13.65,13.65,0,0,1,3,3.81,9.27,9.27,0,0,1,1,5,11.14,11.14,0,0,1-1.54,4.7,19.09,19.09,0,0,1-2.8,3.67,40.6,40.6,0,0,1-6.81,5.54,83.78,83.78,0,0,1-7.41,4.35c-10.11,5.26-20.76,9.16-31.39,12.82a161.69,161.69,0,0,0-15.52,6.37A74.57,74.57,0,0,0,255,420a32.17,32.17,0,0,0-5.82,5.89,16.21,16.21,0,0,0-3.19,7.52,13.61,13.61,0,0,0,1.59,8A20.29,20.29,0,0,0,252.95,447.85Z" fill="#cb9866" />
                    <path d="M207.5,484.06c7.05-5.11,15.14-8.66,23.34-11.63a177.13,177.13,0,0,1,25.29-6.88,263.65,263.65,0,0,1,52.22-4.49h3.28l3.28.09,6.56.19,6.55.39c2.18.13,4.37.26,6.54.48,4.35.39,8.71.74,13,1.28l6.51.75,6.49.91c17.3,2.5,34.41,6,51.36,10.19l12.62,3.2c4.18,1,8.34,2.18,12.55,3.06,8.38,2,16.82,3.63,25.29,5.13a353.5,353.5,0,0,0,51.17,5.47c17.11.32,34.36-.66,51-4.7a118.55,118.55,0,0,0,24.21-8.47,84.82,84.82,0,0,0,11.11-6.49,47.55,47.55,0,0,0,9.69-8.53,48.1,48.1,0,0,1-9,9.45,85.1,85.1,0,0,1-10.81,7.45,116.56,116.56,0,0,1-24.23,10.24,165.66,165.66,0,0,1-25.79,5.35,232.1,232.1,0,0,1-26.27,1.71c-8.77,0-17.55-.24-26.26-1.09-2.18-.2-4.37-.35-6.54-.6l-6.52-.78c-4.36-.46-8.67-1.19-13-1.82-8.64-1.37-17.22-3.09-25.74-5-4.28-.87-8.5-2-12.75-3l-12.62-3.11q-25.06-6.37-50.58-10.47a426.37,426.37,0,0,0-51.3-5.3c-8.59-.42-17.19-.29-25.78,0a240.1,240.1,0,0,0-25.68,2.24,186.57,186.57,0,0,0-25.27,5.19c-4.15,1.16-8.26,2.49-12.28,4.05-2,.79-4,1.6-6,2.52A50.82,50.82,0,0,0,207.5,484.06Z" fill="#cb9866" />
                    <path d="M374.32,502.55a48.15,48.15,0,0,0,1.24,14.35c1.15,4.52,3.29,8.64,6.49,11.35a18.5,18.5,0,0,0,5.51,3.14,39.06,39.06,0,0,0,6.41,1.82,65.78,65.78,0,0,0,13.68,1.12,72.9,72.9,0,0,0,13.72-1.44,44.51,44.51,0,0,0,6.46-1.85,17.75,17.75,0,0,0,5.51-3.15,25.45,25.45,0,0,0,7.24-11.17,52,52,0,0,0,1.9-6.91c.48-2.37.83-4.8,1.18-7.25a55.16,55.16,0,0,1,.64,7.42,40.11,40.11,0,0,1-.52,7.56,31.23,31.23,0,0,1-2.19,7.5,24.37,24.37,0,0,1-4.46,6.79,25.16,25.16,0,0,1-6.61,5,39.72,39.72,0,0,1-7.4,3A58.55,58.55,0,0,1,407.75,542a55,55,0,0,1-15.47-1.9,36.65,36.65,0,0,1-7.46-3,25.3,25.3,0,0,1-6.6-5,19.63,19.63,0,0,1-2.5-3.34,21.72,21.72,0,0,1-1.79-3.67,27.66,27.66,0,0,1-1.65-7.7,38.16,38.16,0,0,1,2-14.87Z" fill="#cb9866" />
                </g>
                <path class="treeBottomPath" stroke="none" fill="none" stroke-width="8" d="M207.5,484.1c0,0,58.5-43.1,211.1-3.1s191-16.9,191-16.9" />
                <path class="treePath" fill="none" stroke="none" stroke-miterlimit="10" d="M252.95,447.85s-30.81-21.57,33.89-44.68,46.22-37,33.89-41.6-59.32-11.56-42.37-28.5,114-52.38,81.66-66.25S301.48,256,324.59,237.55,390.84,135.87,395.46,122c4.41-13.24,16.95-18.49,24.65,0s44.68,100.14,67.79,115.55-10.78,21.57-26.19,24.65-20,33.89,33.89,49.3,47.76,40.06,27.73,44.68-63.17,4.62-27.73,32.35,98.6,21.57,61.63,60.09" />
                <path class="treeBottom" mask="url(#treeBottomMask)" d="M207.5,484.06c7.05-5.11,15.14-8.66,23.34-11.63a177.13,177.13,0,0,1,25.29-6.88,263.65,263.65,0,0,1,52.22-4.49h3.28l3.28.09,6.56.19,6.55.39c2.18.13,4.37.26,6.54.48,4.35.39,8.71.74,13,1.28l6.51.75,6.49.91c17.3,2.5,34.41,6,51.36,10.19l12.62,3.2c4.18,1,8.34,2.18,12.55,3.06,8.38,2,16.82,3.63,25.29,5.13a353.5,353.5,0,0,0,51.17,5.47c17.11.32,34.36-.66,51-4.7a118.55,118.55,0,0,0,24.21-8.47,84.82,84.82,0,0,0,11.11-6.49,47.55,47.55,0,0,0,9.69-8.53,48.1,48.1,0,0,1-9,9.45,85.1,85.1,0,0,1-10.81,7.45,116.56,116.56,0,0,1-24.23,10.24,165.66,165.66,0,0,1-25.79,5.35,232.1,232.1,0,0,1-26.27,1.71c-8.77,0-17.55-.24-26.26-1.09-2.18-.2-4.37-.35-6.54-.6l-6.52-.78c-4.36-.46-8.67-1.19-13-1.82-8.64-1.37-17.22-3.09-25.74-5-4.28-.87-8.5-2-12.75-3l-12.62-3.11q-25.06-6.37-50.58-10.47a426.37,426.37,0,0,0-51.3-5.3c-8.59-.42-17.19-.29-25.78,0a240.1,240.1,0,0,0-25.68,2.24,186.57,186.57,0,0,0-25.27,5.19c-4.15,1.16-8.26,2.49-12.28,4.05-2,.79-4,1.6-6,2.52A50.82,50.82,0,0,0,207.5,484.06Z" fill="#cb9866" />
                <path class="treePot" mask="url(#treePotMask)" d="M374.32,502.55a48.15,48.15,0,0,0,1.24,14.35c1.15,4.52,3.29,8.64,6.49,11.35a18.5,18.5,0,0,0,5.51,3.14,39.06,39.06,0,0,0,6.41,1.82,65.78,65.78,0,0,0,13.68,1.12,72.9,72.9,0,0,0,13.72-1.44,44.51,44.51,0,0,0,6.46-1.85,17.75,17.75,0,0,0,5.51-3.15,25.45,25.45,0,0,0,7.24-11.17,52,52,0,0,0,1.9-6.91c.48-2.37.83-4.8,1.18-7.25a55.16,55.16,0,0,1,.64,7.42,40.11,40.11,0,0,1-.52,7.56,31.23,31.23,0,0,1-2.19,7.5,24.37,24.37,0,0,1-4.46,6.79,25.16,25.16,0,0,1-6.61,5,39.72,39.72,0,0,1-7.4,3A58.55,58.55,0,0,1,407.75,542a55,55,0,0,1-15.47-1.9,36.65,36.65,0,0,1-7.46-3,25.3,25.3,0,0,1-6.6-5,19.63,19.63,0,0,1-2.5-3.34,21.72,21.72,0,0,1-1.79-3.67,27.66,27.66,0,0,1-1.65-7.7,38.16,38.16,0,0,1,2-14.87Z" fill="#cb9866" />
                <g class="treeStar">
                    <path class="treeStarOutline" opacity="0" d="M421,53.27c5,.83,10.08,1.52,15.15,2.13l3.8.45,1.9.21c.33,0,.6.06,1,.12a2.41,2.41,0,0,1,1.27.66,2.52,2.52,0,0,1,.56,2.76,3.42,3.42,0,0,1-.78,1.07l-.66.69-2.65,2.77c-1.78,1.83-3.54,3.68-5.35,5.48l-2.7,2.71L429.81,75l-.69.67-.34.33,0,0h0a.14.14,0,0,0,0-.08s0-.07,0,0l0,.24.07.47.57,3.78c.4,2.52.71,5,1.06,7.57l.94,7.59.22,1.9c0,.06,0,.19,0,.34a2.21,2.21,0,0,1,0,.43,2.72,2.72,0,0,1-.21.84,2.85,2.85,0,0,1-2.65,1.75,2.57,2.57,0,0,1-.82-.14,3.12,3.12,0,0,1-.65-.3l-1.64-1-6.58-3.91-6.63-3.81-3.34-1.86-.42-.23-.21-.12-.14-.07a1,1,0,0,0-.59,0,1.15,1.15,0,0,0-.31.12l-.43.22-.85.44c-2.27,1.17-4.54,2.31-6.79,3.52s-4.51,2.38-6.74,3.61l-3.36,1.83-.84.46a3.07,3.07,0,0,1-1.28.44,2.68,2.68,0,0,1-2.84-3l.15-1,.29-1.89.57-3.78,1.18-7.56,1.24-7.52a.13.13,0,0,0,0,.08l0,0-.1-.09-.17-.17-1.37-1.34-2.73-2.68-10.93-10.7-.34-.33a4,4,0,0,1-.64-.84,3.63,3.63,0,0,1-.43-2.12,3.68,3.68,0,0,1,2.64-3.17l.52-.11.25,0,.47-.06.95-.12,1.9-.25,7.58-1,7.6-.9,1.9-.23.95-.11c.24,0,.11,0,.09,0l-.09.05-.07.08,0,0,.09-.16.46-.84.91-1.68c2.41-4.5,4.95-8.92,7.51-13.34l1-1.66.48-.83.24-.41.13-.23a3.49,3.49,0,0,1,.22-.33,2.66,2.66,0,0,1,2.83-.9,2.52,2.52,0,0,1,1.26.84,2.85,2.85,0,0,1,.37.62l.18.44q1.45,3.54,3,7.06c1,2.36,2,4.68,3.06,7,.51,1.17,1.06,2.32,1.59,3.48l.8,1.74a2.12,2.12,0,0,0,.45.75A1.42,1.42,0,0,0,421,53.27Zm-.06.39a1.82,1.82,0,0,1-1-.46,2.52,2.52,0,0,1-.56-.86l-.84-1.72c-.56-1.14-1.11-2.3-1.69-3.43-1.17-2.27-2.29-4.56-3.5-6.81s-2.39-4.51-3.6-6.76l-.23-.42a.8.8,0,0,0-.14-.18.58.58,0,0,0-.33-.15.56.56,0,0,0-.57.28L407,36.48c-2.09,4.66-4.2,9.31-6.45,13.88l-.83,1.72-.42.86-.13.27a3.57,3.57,0,0,1-2,1.67,4.26,4.26,0,0,1-.84.18l-.95.13-1.89.27L386,56.53l-7.58,1-3.49.44a.45.45,0,0,0,.34-.4.51.51,0,0,0-.07-.28s-.06-.08-.07-.08l.33.34,10.65,11,2.66,2.75,1.33,1.37.4.42a3.41,3.41,0,0,1,.53.84,3.36,3.36,0,0,1,.24,1.95c-.53,2.56-1,5-1.57,7.52L388,90.85l-.83,3.73-.42,1.87-.2.9a.5.5,0,0,0,0,.3.58.58,0,0,0,.52.37,6.28,6.28,0,0,0,1.38-.58l3.46-1.62q3.47-1.61,6.9-3.3c2.3-1.1,4.57-2.26,6.85-3.39l.86-.43.43-.21a2.55,2.55,0,0,1,.57-.22,2.21,2.21,0,0,1,1.29.08l.29.13.21.11.42.23,3.37,1.81,6.8,3.51,6.85,3.41,1.71.85c.19.09.15.07.22.08a.25.25,0,0,0,.12,0,.42.42,0,0,0,.21-.1.33.33,0,0,0,.1-.19.2.2,0,0,0,0-.09.1.1,0,0,0,0,0l0-.13L428.74,96l-1.42-7.52c-.43-2.51-.9-5-1.29-7.54l-.6-3.78-.08-.47,0-.24a3.75,3.75,0,0,1,0-.45,3.37,3.37,0,0,1,.52-1.9,3.33,3.33,0,0,1,.3-.4,3.73,3.73,0,0,1,.3-.3l.35-.32.7-.65,2.81-2.59,2.86-2.54c1.9-1.71,3.84-3.36,5.77-5l2.91-2.49a12.91,12.91,0,0,0,1.15-1,.7.7,0,0,0-.06-.79.73.73,0,0,0-.37-.26c-.23-.06-.6-.13-.89-.2l-1.87-.4L436,56.39C431,55.39,426,54.45,420.95,53.66Z" fill="#FFFCF9" />
                    <path d="M408.12,83.45l-17.78,8.94,3.72-19.55-14-14.15,19.74-2.5,9.13-17.68,8.48,18L437,59.73l-14.5,13.63,3,19.67Z" fill="#C89568" />
                </g>
                <circle class="sparkle" fill="url(#dotGrad)" cx="0" cy="0" r="50" />
            </g>
            <foreignObject id="endMessage" x="0" y="550" width="800" height="250">
                <span class="endMessage">
                  Happy Holidays from <a href="#" class="endMessageLink">Prestige Hotel</a>
                </span>
            </foreignObject>
        </svg>
        {* Hanging ornaments restored *}
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
        <div style="margin-bottom: 20px; display: flex; justify-content: center; align-items: center; width: 100%;">
            <span style="background: rgba(201, 169, 110, 0.15); color: #C9A96E; border: 1px solid rgba(201, 169, 110, 0.3); padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
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
                    <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #C9A96E; font-weight: 700;">✓</div>
                <span style="color: #cbd5e1; font-size: 13px;">Festive Meals</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #C9A96E; font-weight: 700;">✓</div>
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
</div> {* Close container wrapper *}

<!-- GSAP Animation Dependencies -->
<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/MorphSVGPlugin.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/DrawSVGPlugin.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/MotionPathPlugin.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/Physics2DPlugin.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/EasePack.min.js"></script>

<!-- Custom Animation Script -->
<script src="{$js_dir}christmas.js"></script>

{* 3. Dynamic Events - Cape Coast Live *}
<section class="experiences-section py-80" id="live-events">
        <div class="container">
                <div class="section-header events-header">
                        <span class="badge-premium">Live in Cape Coast</span>
                        <h2 class="home-section-title">Curated Experiences</h2>
                        <p class="home-section-subtitle">Real upcoming events near Prestige Hotel, powered by Eventbrite &amp; PredictHQ.</p>
                </div>

                <div id="events-showcase" class="events-grid" data-endpoint="{$base_dir}themes/hotel-reservation-theme/ajax/events.php" aria-live="polite">
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

    // Ensure HTTPS for endpoint (fix mixed content issue)
    if (endpoint && endpoint.indexOf('http://') === 0 && window.location.protocol === 'https:') {
        endpoint = endpoint.replace('http://', 'https://');
    }
    // If relative URL, make it absolute
    if (endpoint && endpoint.indexOf('http') !== 0) {
        endpoint = window.location.protocol + '//' + window.location.host + (endpoint.indexOf('/') === 0 ? '' : '/') + endpoint;
    }

    fetch(endpoint + '?limit=4', {credentials:'same-origin'})
        .then(function(r){ 
            if (!r.ok) {
                throw new Error('HTTP ' + r.status);
            }
            return r.json(); 
        })
        .then(function(data){ 
            if (data.success !== false && data.events) {
                render(data.events || []); 
            } else {
                throw new Error(data.error || 'Failed to load events');
            }
        })
        .catch(function(err){ 
            console.error('Events feed error:', err);
            grid.innerHTML = '<p class="event-empty">Could not load events.</p>';
            if (fallback) fallback.style.display = 'block';
        });
})();
</script>
{/literal}
