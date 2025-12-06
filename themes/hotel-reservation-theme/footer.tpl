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
{if !isset($content_only) || !$content_only}
					</div><!-- #center_column -->
					{if isset($right_column_size) && !empty($right_column_size)}
						<div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
					{/if}
					</div><!-- .row -->
					{block name='displayColumnsBottom'}
						{hook h='displayColumnsBottom'}
					{/block}
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			
			{block name='displayFooter'}
				
				<!-- Hidden original hook to preserve scripts/functionality -->
				<div style="display: none;">
					{if isset($HOOK_FOOTER)}
						{$HOOK_FOOTER}
					{/if}
				</div>

				<!-- NEW MODERN PREMIUM FOOTER - DYNAMIC -->
				<footer class="footer-main">
				  <!-- Footer Top Section -->
				  <div class="footer-top">
				    <div class="container">
				      <div class="footer-grid">
				        
				        <!-- Column 1: About -->
				        <div class="footer-column">
				          <h4>{l s='ABOUT PRESTIGE HOTEL'}</h4>
				          <p>
				            {if Configuration::get('FOOTER_ABOUT_TEXT')}
				                {Configuration::get('FOOTER_ABOUT_TEXT')|escape:'htmlall':'UTF-8'}
				            {else}
				                {l s='Choose Prestige Hotel for a stay that goes beyond expectations. With our perfect mix of hospitality, comfort, and convenience, you\'ll be sure to enjoy every moment of your time in Cape Coast, Ghana.'}
				            {/if}
				          </p>
				        </div>

				        <!-- Column 2: Contact -->
				        <div class="footer-column">
				          <h4>{l s='CONTACT US'}</h4>
				          <ul class="contact-info">
				            {* Address *}
				            {if Configuration::get('PS_SHOP_ADDR1') || Configuration::get('PS_SHOP_CITY')}
				                <li>
				                    <i class="icon-map-marker"></i> 
				                    {Configuration::get('PS_SHOP_ADDR1')|escape:'html':'UTF-8'}, 
				                    {Configuration::get('PS_SHOP_CITY')|escape:'html':'UTF-8'}
				                </li>
				            {/if}
				            
				            {* Email *}
				            {if Configuration::get('PS_SHOP_EMAIL')}
				                <li>
				                    <i class="icon-envelope"></i> 
				                    <a href="mailto:{Configuration::get('PS_SHOP_EMAIL')}">{Configuration::get('PS_SHOP_EMAIL')}</a>
				                </li>
				            {/if}
				            
				            {* Phone *}
				            {if Configuration::get('PS_SHOP_PHONE')}
				                <li>
				                    <i class="icon-phone"></i> 
				                    <a href="tel:{Configuration::get('PS_SHOP_PHONE')|replace:' ':''}">{Configuration::get('PS_SHOP_PHONE')}</a>
				                </li>
				            {/if}

				            {* WhatsApp (Fallback to Shop Phone if not set) *}
				            {assign var='whatsapp_num' value=Configuration::get('HOTEL_WHATSAPP_NUMBER')}
				            {if !$whatsapp_num}
				                {assign var='whatsapp_num' value=Configuration::get('PS_SHOP_PHONE')}
				            {/if}
				            
				            {if $whatsapp_num}
				                <li>
				                    <i class="icon-whatsapp"></i> 
				                    <a href="https://wa.me/{$whatsapp_num|replace:'+':''|replace:' ':''|replace:'-':''}" target="_blank">{$whatsapp_num}</a>
				                </li>
				            {/if}
				          </ul>
				        </div>

				        <!-- Column 3: Explore / CMS Links -->
				        <div class="footer-column">
				          <h4>{l s='EXPLORE'}</h4>
				          <ul class="footer-links">
				            <li><a href="{$base_dir}">{l s='Home'}</a></li>
				            
				            {* Rooms & Amenities (Anchors) *}
				            <li><a href="{$base_dir}#hotelRoomsBlock">{l s='Rooms'}</a></li>
				            <li><a href="{$base_dir}#hotelAmenitiesBlock">{l s='Amenities'}</a></li>
				            
				            {* Dynamic CMS Pages *}
				            {if class_exists('CMS')}
				                {assign var='cms_pages' value=CMS::listCms($cookie->id_lang, false, true)}
				                {foreach from=$cms_pages item=cms}
				                    {if $cms.meta_title != 'About Us' && $cms.meta_title != 'Policies'}
				                    <li>
				                        <a href="{$link->getCMSLink($cms.id_cms, $cms.link_rewrite)|escape:'html':'UTF-8'}">
				                            {$cms.meta_title|escape:'html':'UTF-8'}
				                        </a>
				                    </li>
				                    {/if}
				                {/foreach}
				            {/if}
				            
				            {* Common pages *}
				            <li><a href="{$link->getCMSLink(4, 'about-us')|default:'#'}">{l s='About Us'}</a></li>
				            <li><a href="{$link->getCMSLink(1, 'policies')|default:'#'}">{l s='Policies'}</a></li>
				            <li><a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}">{l s='Contact'}</a></li>
				            {if Module::isInstalled('ybc_blog_free')}
                                {assign var='ybc_module' value=Module::getInstanceByName('ybc_blog_free')}
				                <li><a href="{$ybc_module->getLink('blog')|escape:'html':'UTF-8'}">{l s='Blog'}</a></li>
                            {/if}
				          </ul>
				        </div>

				        <!-- Column 4: Latest Posts (Dynamic Fetch) -->
				        <div class="footer-column">
				          <h4>{l s='LATEST POSTS'}</h4>
				          <ul class="footer-blog">
				            {assign var='footer_posts' value=false}
				            {if Module::isInstalled('ybc_blog_free') && Module::isEnabled('ybc_blog_free')}
				                {assign var='ybc_module' value=Module::getInstanceByName('ybc_blog_free')}
				                {if $ybc_module}
				                    {assign var='footer_posts' value=$ybc_module->getPostsWithFilter(' AND p.enabled=1', 'p.id_post desc,', 0, 3)}
				                {/if}
				            {/if}

				            {if $footer_posts}
				                {foreach from=$footer_posts item=post}
				                    {assign var='post_link' value=$ybc_module->getLink('blog', ['id_post' => $post.id_post])}
				                    <li>
				                        <a href="{$post_link|escape:'html':'UTF-8'}">
				                            {$post.title|escape:'html':'UTF-8'}
				                        </a>
				                        <span class="date" style="display:block; font-size:12px; color:#666;">
                                            {date('F jS Y', strtotime($post.datetime_added))|escape:'html':'UTF-8'}
				                        </span>
				                    </li>
				                {/foreach}
				            {else}
				                {* Fallback if no posts found *}
				                <li>
				                  <a href="#">Welcome to Prestige Hotel</a>
				                  <span class="date" style="display:block; font-size:12px; color:#666;">{date('F jS Y')}</span>
				                </li>
				            {/if}
				          </ul>
				        </div>

				      </div>
				    </div>
				  </div>

				  <!-- Footer Middle Section: Payment & Social -->
				  <div class="footer-middle">
				    <div class="container">
				      <div class="footer-payment-social">
				        <div class="payment-methods">
				          <h5 style="color: #C0A062; font-size: 14px; margin-bottom: 10px; text-transform: uppercase;">{l s='PAYMENT ACCEPTED'}</h5>
				          <i class="icon-credit-card" style="font-size: 24px; margin-right: 10px;"></i>
				          <i class="icon-cc-visa" style="font-size: 24px; margin-right: 10px;"></i>
				          <i class="icon-cc-mastercard" style="font-size: 24px; margin-right: 10px;"></i>
				          <i class="icon-cc-paypal" style="font-size: 24px; margin-right: 10px;"></i>
				        </div>
				        <div class="social-media">
				          <h5 style="color: #C0A062; font-size: 14px; margin-bottom: 10px; text-transform: uppercase; display:inline-block; margin-right:15px;">{l s='FOLLOW US'}</h5>
				          
				          {if Configuration::get('BLOCKSOCIAL_FACEBOOK')}
				            <a href="{Configuration::get('BLOCKSOCIAL_FACEBOOK')}" target="_blank"><i class="icon-facebook"></i></a>
				          {/if}
				          
				          {if Configuration::get('BLOCKSOCIAL_TWITTER')}
				            <a href="{Configuration::get('BLOCKSOCIAL_TWITTER')}" target="_blank"><i class="icon-twitter"></i></a>
				          {/if}
				          
				          {if Configuration::get('BLOCKSOCIAL_INSTAGRAM')}
				            <a href="{Configuration::get('BLOCKSOCIAL_INSTAGRAM')}" target="_blank"><i class="icon-instagram"></i></a>
				          {/if}
				          
				          {if Configuration::get('BLOCKSOCIAL_LINKEDIN')}
				            <a href="{Configuration::get('BLOCKSOCIAL_LINKEDIN')}" target="_blank"><i class="icon-linkedin"></i></a>
				          {/if}

				          {* WhatsApp Icon - Uses same variable as Contact *}
				          {if $whatsapp_num}
				            <a href="https://wa.me/{$whatsapp_num|replace:'+':''|replace:' ':''|replace:'-':''}" target="_blank"><i class="icon-whatsapp"></i></a>
				          {/if}
				        </div>
				      </div>
				    </div>
				  </div>

				  <!-- Footer Bottom: Copyright -->
				  <div class="footer-bottom">
				    <div class="container">
				      <p>© {$smarty.now|date_format:"%Y"} {Configuration::get('PS_SHOP_NAME')}. {l s='All rights reserved.'}</p>
				    </div>
				  </div>
				</footer>
				
				<!-- Hidden post-footer hook to remove extra dark section -->
				<div style="display: none;">
					{block name='displayAfterDefautlFooterHook'}
						{hook h="displayAfterDefautlFooterHook"}
					{/block}
				</div>

			{/block}
		</div><!-- #page -->
{/if}
{block name='global'}
	{include file="$tpl_dir./global.tpl"}
{/block}
	</body>
</html>
