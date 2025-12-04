{*
* 2007-2015 PrestaShop
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
{if $posts}
    <div class="footer-block ybc-blog-posts ybc_latest_posts_block {$blog_config.YBC_BLOG_FREE_RTL_CLASS|escape:'html':'UTF-8'} {if isset($page) && $page}page_{$page|escape:'html':'UTF-8'}{else}page_blog{/if} {if isset($page) && $page=='home'}{if isset($blog_config.YBC_BLOG_FREE_HOME_POST_TYPE) && $blog_config.YBC_BLOG_FREE_HOME_POST_TYPE=='default' || count($posts)<=1}ybc_block_default{else}ybc_block_slider{/if}{else}{if isset($blog_config.YBC_BLOG_FREE_SIDEBAR_POST_TYPE) && $blog_config.YBC_BLOG_FREE_SIDEBAR_POST_TYPE=='default' || count($posts)<=1}ybc_block_default{else}ybc_block_slider{/if}{/if}">
        <h4 class="title_blog title_block">{l s='Latest posts' mod='ybc_blog_free'}</h4>
        <div class="block_content toggle-footer">
            <ul class="block_content" id="ybc_latest_posts_list">
                {foreach from=$posts item='post'}
                    <li>
                        {if $post.thumb}<a class="ybc_item_img" href="{$post.link|escape:'html':'UTF-8'}"><img src="{$post.thumb|escape:'html':'UTF-8'}" alt="{$post.title|escape:'html':'UTF-8'}" title="{$post.title|escape:'html':'UTF-8'}" /></a>{/if}
                        <div class="ybc-blog-latest-post-content">
                            <a class="ybc_title_block" href="{$post.link|escape:'html':'UTF-8'}">{$post.title|escape:'html':'UTF-8'}</a>
                            <span class="post-date">{if isset($blog_config.YBC_BLOG_FREE_DATE_FORMAT)&&$blog_config.YBC_BLOG_FREE_DATE_FORMAT}{date($blog_config.YBC_BLOG_FREE_DATE_FORMAT, strtotime($post.datetime_added))|escape:'html':'UTF-8'}{else}{date('F jS Y', strtotime($post.datetime_added))|escape:'html':'UTF-8'}{/if}</span>
                        </div>
                    </li>
                {/foreach}
            </ul>
        </div>
        <div class="clear"></div>
    </div>
{/if}
<script type="text/javascript">
    ybc_blog_free_like_url = '{$like_url|escape:'html':'UTF-8'}';
    ybc_like_error ='{$ybc_like_error|escape:'quotes':'UTF-8'}';
    YBC_BLOG_FREE_GALLERY_SPEED = {$YBC_BLOG_FREE_GALLERY_SPEED|intval};
    YBC_BLOG_FREE_SLIDER_SPEED = {$YBC_BLOG_FREE_SLIDER_SPEED|intval};
    YBC_BLOG_FREE_GALLERY_SKIN = '{$YBC_BLOG_FREE_GALLERY_SKIN|escape:'html':'UTF-8'}';
    YBC_BLOG_FREE_GALLERY_AUTO_PLAY = {$YBC_BLOG_FREE_GALLERY_AUTO_PLAY|intval};
</script>
