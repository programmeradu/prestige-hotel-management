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

				<!-- NEW MODERN PREMIUM FOOTER -->
				<footer class="footer-main">
				  <!-- Footer Top Section -->
				  <div class="footer-top">
				    <div class="container">
				      <div class="footer-grid">
				        
				        <!-- Column 1: About -->
				        <div class="footer-column">
				          <h4>ABOUT PRESTIGE HOTEL</h4>
				          <p>Choose Prestige Hotel for a stay that goes beyond expectations. With our perfect mix of hospitality, comfort, and convenience, you'll be sure to enjoy every moment of your time in Cape Coast, Ghana.</p>
				        </div>

				        <!-- Column 2: Contact -->
				        <div class="footer-column">
				          <h4>CONTACT US</h4>
				          <ul class="contact-info">
				            <li><i class="icon-map-marker"></i> Mooneye Street, Amamoma, Cape Coast</li>
				            <li><i class="icon-envelope"></i> prestigehotelcc@gmail.com</li>
				            <li><i class="icon-phone"></i> +233 20 532 8339</li>
				            <li><i class="icon-whatsapp"></i> +233 20 532 8339</li>
				          </ul>
				        </div>

				        <!-- Column 3: Quick Links -->
				        <div class="footer-column">
				          <h4>EXPLORE</h4>
				          <ul class="footer-links">
				            <li><a href="{$base_dir}">Home</a></li>
				            <li><a href="{$base_dir}#hotelRoomsBlock">Rooms</a></li>
				            <li><a href="{$base_dir}#hotelAmenitiesBlock">Amenities</a></li>
				            <li><a href="{$link->getCMSLink(4, 'about-us')}">About Us</a></li>
				            <li><a href="{$link->getCMSLink(1, 'policies')}">Policies</a></li>
				            <li><a href="{$link->getPageLink('contact')}">Contact</a></li>
				             <!-- Blog link - adjust if module is different -->
				            <li><a href="{$link->getPageLink('blog', true)|escape:'html':'UTF-8'}">Blog</a></li>
				          </ul>
				        </div>

				        <!-- Column 4: Latest Posts -->
				        <div class="footer-column">
				          <h4>LATEST POSTS</h4>
				          <ul class="footer-blog">
				            <!-- Static placeholder until dynamic fetch is implemented -->
				            <li>
				              <a href="#">10 Best Things to Do in Cape Coast</a>
				              <span class="date" style="display:block; font-size:12px; color:#666;">December 3rd 2025</span>
				            </li>
				            <li>
				              <a href="#">Experience Ghanaian Hospitality</a>
				              <span class="date" style="display:block; font-size:12px; color:#666;">November 20th 2025</span>
				            </li>
				            <li>
				              <a href="#">A Guide to Our Luxury Suites</a>
				              <span class="date" style="display:block; font-size:12px; color:#666;">November 15th 2025</span>
				            </li>
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
				          <h5 style="color: #C0A062; font-size: 14px; margin-bottom: 10px; text-transform: uppercase;">PAYMENT ACCEPTED</h5>
				          <!-- Use placeholders or theme icons -->
				          <i class="icon-credit-card" style="font-size: 24px; margin-right: 10px;"></i>
				          <i class="icon-cc-visa" style="font-size: 24px; margin-right: 10px;"></i>
				          <i class="icon-cc-mastercard" style="font-size: 24px; margin-right: 10px;"></i>
				          <i class="icon-cc-paypal" style="font-size: 24px; margin-right: 10px;"></i>
				        </div>
				        <div class="social-media">
				          <h5 style="color: #C0A062; font-size: 14px; margin-bottom: 10px; text-transform: uppercase; display:inline-block; margin-right:15px;">FOLLOW US</h5>
				          <a href="https://wa.me/233205328339" target="_blank"><i class="icon-whatsapp"></i></a>
				          <a href="#" target="_blank"><i class="icon-instagram"></i></a>
				          <a href="#" target="_blank"><i class="icon-linkedin"></i></a>
				        </div>
				      </div>
				    </div>
				  </div>

				  <!-- Footer Bottom: Copyright -->
				  <div class="footer-bottom">
				    <div class="container">
				      <p>© {$smarty.now|date_format:"%Y"} Prestige Hotel. All rights reserved.</p>
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
