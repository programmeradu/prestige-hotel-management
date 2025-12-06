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
                {assign var='image_link' value=$link->getImageLink($room.link_rewrite, $room.id_image, 'home_default')}
                <div class="room-card">
                    <div class="room-image">
                        <a href="{$room.link|escape:'html':'UTF-8'}">
                            <img src="{$image_link}" alt="{$room.name|escape:'html':'UTF-8'}">
                        </a>
                    </div>
                    <div class="room-content">
                        <h3 class="room-name">
                            <a href="{$room.link|escape:'html':'UTF-8'}">{$room.name|escape:'html':'UTF-8'}</a>
                        </h3>
                        <div class="room-price">
                            <span class="price-amount">{convertPrice price=$room.show_price}</span>
                            <span class="price-period">/ {l s='Per Night'}</span>
                        </div>
                        <p class="room-description">
                            {$room.description_short|strip_tags:'UTF-8'|truncate:100:'...'}
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

{* 2. World-Class Amenities Section *}
<section class="hotel-features-section">
	<div class="container">
		<div class="section-header">
			<h2 class="home-section-title">World-Class Amenities & Services</h2>
			<p class="section-subtitle">Relax in the comfort of our rooms. With modern amenities, serene décor, and stunning lake or any views, each room offers a peaceful retreat for your stay.</p>
		</div>
		
		<span class="decor-dot coral" style="top: 20%; left: 5%;"></span>
		<span class="decor-dot gold" style="top: 40%; right: 8%;"></span>
		<span class="decor-dot teal" style="bottom: 30%; left: 15%;"></span>
		<span class="decor-dot purple" style="bottom: 20%; right: 12%;"></span>
		
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon"><i class="icon-food"></i></div>
					<h4 class="feature-title">Fine Dining</h4>
					<p class="feature-description">Enjoy our award-winning restaurant offering fine dining and catering services for travelers and visitors.</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="feature-item featured">
					<div class="feature-icon"><i class="icon-tint"></i></div>
					<h4 class="feature-title">Infinity Pool</h4>
					<p class="feature-description">Start your night right overlooking our panoramic pool, infinity pool convenience and infinity foot.</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon"><i class="icon-heart"></i></div>
					<h4 class="feature-title">Spa & Wellness</h4>
					<p class="feature-description">Spa & Vees breakfast routine cornered wellness, and healthy medium consultations, and meals.</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon"><i class="icon-user"></i></div>
					<h4 class="feature-title">Concierge</h4>
					<p class="feature-description">Concierge for your attention, crew any and hotel our concierge service at your disposal 24/7.</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon"><i class="icon-sun"></i></div>
					<h4 class="feature-title">Private Beach Access</h4>
					<p class="feature-description">Experience managed to contest for each room, access to your rooms, and pristine beach access.</p>
				</div>
			</div>
		</div>
	</div>
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
