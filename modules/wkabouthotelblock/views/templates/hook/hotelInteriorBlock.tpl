{*
* 2010-2020 Webkul.
*
* NOTICE OF LICENSE
*
* All right is reserved,
* Please go through this link for complete license : https://store.webkul.com/license.html
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to https://store.webkul.com/customisation-guidelines/ for more information.
*
*  @author    Webkul IN <support@webkul.com>
*  @copyright 2010-2020 Webkul IN
*  @license   https://store.webkul.com/license.html
*}

{block name='hotel_interior_block'}
    {if isset($InteriorImg) && $InteriorImg}
        <div id="hotelInteriorBlock" class="row home_block_container premium-interior-block">
            <div class="col-xs-12 col-sm-12">
                {if $HOTEL_INTERIOR_HEADING && $HOTEL_INTERIOR_DESCRIPTION}
                    <div class="row home_block_desc_wrapper">
                        <div class="col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                            {block name='hotel_interior_block_heading'}
                                <p class="home_block_heading">{$HOTEL_INTERIOR_HEADING|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            {block name='hotel_interior_block_description'}
                                <p class="home_block_description">{$HOTEL_INTERIOR_DESCRIPTION|escape:'htmlall':'UTF-8'}</p>
                            {/block}
                            <hr class="home_block_desc_line"/>
                        </div>
                    </div>
                {/if}

                {block name='hotel_interior_images'}
                    <div class="premium-gallery-container">
                        {* Main Featured Display - Video or Image *}
                        <div class="gallery-featured">
                            {if isset($video_enabled) && $video_enabled && $video_embed}
                                {* Video Featured *}
                                <div class="featured-video-container" id="video-container">
                                    {if $video_thumbnail}
                                        <div class="video-thumbnail" id="video-thumbnail" style="background-image: url('{$video_thumbnail|escape:'htmlall':'UTF-8'}')">
                                            <div class="video-play-overlay">
                                                <button class="play-btn" id="play-video-btn" aria-label="Play Video">
                                                    <svg viewBox="0 0 68 48" width="68" height="48">
                                                        <path class="play-btn-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#C9A96E"></path>
                                                        <path d="M45,24L27,14v20L45,24z" fill="#fff"></path>
                                                    </svg>
                                                </button>
                                                {if $video_title}
                                                    <span class="video-title">{$video_title|escape:'htmlall':'UTF-8'}</span>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="video-iframe-wrapper" id="video-iframe-wrapper" style="display: none;">
                                            {if $video_type == 'direct'}
                                                <video id="hotel-video" controls autoplay>
                                                    <source src="{$video_embed|escape:'htmlall':'UTF-8'}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            {else}
                                                <iframe id="hotel-video-iframe" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            {/if}
                                        </div>
                                    {else}
                                        {* No thumbnail - show video directly *}
                                        <div class="video-iframe-wrapper" style="display: block;">
                                            {if $video_type == 'direct'}
                                                <video id="hotel-video" controls>
                                                    <source src="{$video_embed|escape:'htmlall':'UTF-8'}" type="video/mp4">
                                                </video>
                                            {else}
                                                <iframe src="{$video_embed|escape:'htmlall':'UTF-8'}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            {/if}
                                        </div>
                                    {/if}
                                </div>
                            {elseif isset($InteriorImg[0])}
                                {* Default Image Featured *}
                                <div class="featured-image active" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$InteriorImg[0]['name']`.jpg")}')">
                                    <div class="image-overlay">
                                        <span class="view-btn"><i class="icon-search-plus"></i></span>
                                    </div>
                                    <a class="fancybox-trigger" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$InteriorImg[0]['name']`.jpg")}" title="{$InteriorImg[0]['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                </div>
                            {/if}
                        </div>

                        {* Side Grid *}
                        <div class="gallery-grid">
                            {assign var='startIndex' value=0}
                            {if isset($video_enabled) && $video_enabled && $video_embed}
                                {assign var='startIndex' value=0} {* Show all images if video is featured *}
                            {else}
                                {assign var='startIndex' value=1} {* Skip first if image is featured *}
                            {/if}
                            
                            {foreach from=$InteriorImg item=img_name name=intImg}
                                {if $smarty.foreach.intImg.index >= $startIndex}
                                    <div class="gallery-item" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$img_name['name']`.jpg")}')">
                                        <div class="image-overlay"></div>
                                        <a class="fancybox-item" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$img_name['name']`.jpg")}" title="{$img_name['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                    </div>
                {/block}
            </div>
            <hr class="home_block_seperator"/>
        </div>
        
        {* Video Play Script *}
        {if isset($video_enabled) && $video_enabled && $video_embed && $video_thumbnail}
            {literal}
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var playBtn = document.getElementById('play-video-btn');
                var thumbnail = document.getElementById('video-thumbnail');
                var iframeWrapper = document.getElementById('video-iframe-wrapper');
                var iframe = document.getElementById('hotel-video-iframe');
                var videoEmbed = '{/literal}{$video_embed|escape:'javascript'}{literal}';
                
                if (playBtn) {
                    playBtn.addEventListener('click', function() {
                        if (thumbnail) thumbnail.style.display = 'none';
                        if (iframeWrapper) {
                            iframeWrapper.style.display = 'block';
                            if (iframe) {
                                iframe.src = videoEmbed;
                            }
                        }
                    });
                }
                
                // Also allow clicking the thumbnail overlay
                if (thumbnail) {
                    thumbnail.addEventListener('click', function() {
                        thumbnail.style.display = 'none';
                        if (iframeWrapper) {
                            iframeWrapper.style.display = 'block';
                            if (iframe) {
                                iframe.src = videoEmbed;
                            }
                        }
                    });
                }
            });
            </script>
            {/literal}
        {/if}
    {/if}
{/block}
