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

{* Our Exquisite Rooms Section *}
<section class="rooms-section py-80">
	<div class="section-header">
		<h2 class="home-section-title">Our Exquisite Rooms</h2>
		<p class="home-section-subtitle">Step into the sophisticated elegance of our hotel, where every detail is designed for your comfort in mind.</p>
	</div>
	{block name='displayHomeTabContent'}
		{if isset($HOOK_HOME_TAB_CONTENT) && $HOOK_HOME_TAB_CONTENT|trim}
			{block name='displayHomeTab'}
				{if isset($HOOK_HOME_TAB) && $HOOK_HOME_TAB|trim}
					<ul id="home-page-tabs" class="nav nav-tabs clearfix">
						{$HOOK_HOME_TAB}
					</ul>
				{/if}
			{/block}
			<div class="tab-content">{$HOOK_HOME_TAB_CONTENT}</div>
		{/if}
	{/block}
</section>

{* World-Class Amenities Section *}
<section class="hotel-features-section">
	<div class="container">
		<div class="section-header">
			<h2 class="home-section-title">World-Class Amenities & Services</h2>
			<p class="section-subtitle">Relax in the comfort of our rooms. With modern amenities, serene décor, and stunning lake or any views, each room offers a peaceful retreat for your stay.</p>
		</div>
		
		{* Decorative Elements *}
		<span class="decor-dot coral" style="top: 20%; left: 5%;"></span>
		<span class="decor-dot gold" style="top: 40%; right: 8%;"></span>
		<span class="decor-dot teal" style="bottom: 30%; left: 15%;"></span>
		<span class="decor-dot purple" style="bottom: 20%; right: 12%;"></span>
		
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon">
						<i class="icon-food"></i>
					</div>
					<h4 class="feature-title">Fine Dining</h4>
					<p class="feature-description">Enjoy our award-winning restaurant offering fine dining and catering services for travelers and visitors.</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="feature-item featured">
					<div class="feature-icon">
						<i class="icon-tint"></i>
					</div>
					<h4 class="feature-title">Infinity Pool</h4>
					<p class="feature-description">Start your night right overlooking our panoramic pool, infinity pool convenience and infinity foot.</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon">
						<i class="icon-heart"></i>
					</div>
					<h4 class="feature-title">Spa & Wellness</h4>
					<p class="feature-description">Spa & Vees breakfast routine cornered wellness, and healthy medium consultations, and meals.</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon">
						<i class="icon-user"></i>
					</div>
					<h4 class="feature-title">Concierge</h4>
					<p class="feature-description">Concierge for your attention, crew any and hotel our concierge service at your disposal 24/7.</p>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="feature-item">
					<div class="feature-icon">
						<i class="icon-sun"></i>
					</div>
					<h4 class="feature-title">Private Beach Access</h4>
					<p class="feature-description">Experience managed to contest for each room, access to your rooms, and pristine beach access.</p>
				</div>
			</div>
		</div>
	</div>
</section>

{* Curated Experiences Section *}
<section class="experiences-section py-80">
	<div class="container">
		<div class="section-header">
			<h2 class="home-section-title">Curated Experiences</h2>
			<p class="home-section-subtitle">Enjoy Prestige Hotel, where natural bay space activities, our local experiences await in your stay.</p>
		</div>
		
		{block name='displayHome'}
			{if isset($HOOK_HOME) && $HOOK_HOME|trim}
				<div class="clearfix">{$HOOK_HOME}</div>
			{/if}
		{/block}
	</div>
</section>
