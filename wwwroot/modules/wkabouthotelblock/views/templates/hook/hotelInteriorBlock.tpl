{*
* 2010-2025 Webkul/Prestige Hotel.
*
* Interior Media Block - Supports both images and videos
*}

{block name='hotel_interior_block'}
    {if (isset($InteriorMedia) && $InteriorMedia) || (isset($InteriorImg) && $InteriorImg)}
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
                        {* Main Featured Display *}
                        <div class="gallery-featured">
                            {* Check for uploaded videos first (in InteriorMedia) *}
                            {assign var='featuredSet' value=false}
                            
                            {if isset($InteriorMedia) && $InteriorMedia}
                                {foreach from=$InteriorMedia item=media name=featuredLoop}
                                    {if $smarty.foreach.featuredLoop.first}
                                        {if isset($media['media_type']) && $media['media_type'] == 'video'}
                                            {* First item is a video - show as featured *}
                                            <div class="featured-video-container uploaded-video">
                                                <video class="featured-uploaded-video" controls poster="">
                                                    <source src="{$link->getMediaLink("`$module_dir`views/video/hotel_interior/`$media['video_file']`")}" type="video/mp4">
                                                    Your browser does not support video.
                                                </video>
                                                {if $media['display_name']}
                                                    <div class="video-title-overlay">{$media['display_name']|escape:'htmlall':'UTF-8'}</div>
                                                {/if}
                                            </div>
                                            {assign var='featuredSet' value=true}
                                        {else}
                                            {* First item is an image *}
                                            <div class="featured-image active" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$media['name']`.jpg")}')">
                                                <div class="image-overlay">
                                                    <span class="view-btn"><i class="icon-search-plus"></i></span>
                                                </div>
                                                <a class="fancybox-trigger" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$media['name']`.jpg")}" title="{$media['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                            </div>
                                            {assign var='featuredSet' value=true}
                                        {/if}
                                    {/if}
                                {/foreach}
                            {/if}
                            
                            {* Fallback: Legacy external video URL *}
                            {if !$featuredSet && isset($video_enabled) && $video_enabled && $video_embed}
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
                                                </video>
                                            {else}
                                                <iframe id="hotel-video-iframe" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            {/if}
                                        </div>
                                    {else}
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
                                {assign var='featuredSet' value=true}
                            {/if}
                            
                            {* Fallback to first image if nothing set *}
                            {if !$featuredSet && isset($InteriorImg[0])}
                                <div class="featured-image active" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$InteriorImg[0]['name']`.jpg")}')">
                                    <div class="image-overlay">
                                        <span class="view-btn"><i class="icon-search-plus"></i></span>
                                    </div>
                                    <a class="fancybox-trigger" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$InteriorImg[0]['name']`.jpg")}" title="{$InteriorImg[0]['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                </div>
                            {/if}
                        </div>

                        {* Side Grid - Show all media (images and videos) except featured *}
                        <div class="gallery-grid">
                            {if isset($InteriorMedia) && $InteriorMedia}
                                {foreach from=$InteriorMedia item=media name=gridLoop}
                                    {if !$smarty.foreach.gridLoop.first} {* Skip first as it's featured *}
                                        {if isset($media['media_type']) && $media['media_type'] == 'video'}
                                            {* Video in grid - with gradient placeholder background *}
                                            <div class="gallery-item gallery-video-item" 
                                                 data-video-src="{$link->getMediaLink("`$module_dir`views/video/hotel_interior/`$media['video_file']`")}"
                                                 data-title="{$media['display_name']|escape:'htmlall':'UTF-8'}"
                                                 style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
                                                <div class="video-play-icon">
                                                    <svg viewBox="0 0 68 48" width="40" height="30">
                                                        <path d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#C9A96E"></path>
                                                        <path d="M45,24L27,14v20L45,24z" fill="#fff"></path>
                                                    </svg>
                                                </div>
                                                <div class="image-overlay"></div>
                                                {if $media['display_name']}
                                                    <span class="media-title">{$media['display_name']|escape:'htmlall':'UTF-8'}</span>
                                                {/if}
                                            </div>
                                        {else}
                                            {* Image in grid *}
                                            <div class="gallery-item" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$media['name']`.jpg")}')">
                                                <div class="image-overlay"></div>
                                                <a class="fancybox-item" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$media['name']`.jpg")}" title="{$media['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                            </div>
                                        {/if}
                                    {/if}
                                {/foreach}
                            {else}
                                {* Fallback to InteriorImg only *}
                                {foreach from=$InteriorImg item=img_name name=intImg}
                                    {if !$smarty.foreach.intImg.first}
                                        <div class="gallery-item" style="background-image: url('{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$img_name['name']`.jpg")}')">
                                            <div class="image-overlay"></div>
                                            <a class="fancybox-item" href="{$link->getMediaLink("`$module_dir`views/img/hotel_interior/`$img_name['name']`.jpg")}" title="{$img_name['display_name']|escape:'htmlall':'UTF-8'}"></a>
                                        </div>
                                    {/if}
                                {/foreach}
                            {/if}
                        </div>
                    </div>
                {/block}
            </div>
            <hr class="home_block_seperator"/>
        </div>
        
        {* Scripts *}
        {literal}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var featuredContainer = document.querySelector('.gallery-featured');
            var videoItems = document.querySelectorAll('.gallery-video-item');
            var imageItems = document.querySelectorAll('.gallery-item:not(.gallery-video-item)');
            
            // Store original featured content for restoration
            var originalFeaturedHTML = featuredContainer ? featuredContainer.innerHTML : '';
            var currentVideoPlayer = null;
            
            // Legacy external video play button
            var playBtn = document.getElementById('play-video-btn');
            var thumbnail = document.getElementById('video-thumbnail');
            var iframeWrapper = document.getElementById('video-iframe-wrapper');
            var iframe = document.getElementById('hotel-video-iframe');
            
            if (playBtn && thumbnail) {
                var videoEmbed = '{/literal}{if isset($video_embed)}{$video_embed|escape:'javascript'}{/if}{literal}';
                
                function playExternalVideo() {
                    thumbnail.style.display = 'none';
                    if (iframeWrapper) {
                        iframeWrapper.style.display = 'block';
                        if (iframe && videoEmbed) {
                            iframe.src = videoEmbed;
                        }
                    }
                }
                
                playBtn.addEventListener('click', playExternalVideo);
                thumbnail.addEventListener('click', playExternalVideo);
            }
            
            // Play video in featured area when grid video is clicked
            videoItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    var videoSrc = this.getAttribute('data-video-src');
                    var title = this.getAttribute('data-title') || '';
                    
                    if (videoSrc && featuredContainer) {
                        // Stop any existing video
                        if (currentVideoPlayer) {
                            currentVideoPlayer.pause();
                        }
                        
                        // Create video player HTML for featured area
                        var videoHTML = '<div class="featured-video-container uploaded-video active-video">' +
                            '<video class="featured-uploaded-video" controls autoplay style="width:100%;height:100%;object-fit:cover;border-radius:16px;">' +
                            '<source src="' + videoSrc + '" type="video/mp4">' +
                            'Your browser does not support video.' +
                            '</video>' +
                            (title ? '<div class="video-title-overlay">' + title + '</div>' : '') +
                            '<button class="video-close-btn" style="position:absolute;top:15px;right:15px;background:rgba(0,0,0,0.7);color:#fff;border:none;border-radius:50%;width:36px;height:36px;font-size:20px;cursor:pointer;z-index:10;">&times;</button>' +
                            '</div>';
                        
                        featuredContainer.innerHTML = videoHTML;
                        
                        // Get references to new elements
                        currentVideoPlayer = featuredContainer.querySelector('video');
                        var closeBtn = featuredContainer.querySelector('.video-close-btn');
                        
                        // Auto-play
                        if (currentVideoPlayer) {
                            currentVideoPlayer.play().catch(function(e) {
                                console.log('Autoplay blocked, user must click play');
                            });
                        }
                        
                        // Close button to restore original featured
                        if (closeBtn) {
                            closeBtn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                if (currentVideoPlayer) {
                                    currentVideoPlayer.pause();
                                }
                                featuredContainer.innerHTML = originalFeaturedHTML;
                                currentVideoPlayer = null;
                            });
                        }
                        
                        // Highlight active thumbnail
                        videoItems.forEach(function(v) { v.classList.remove('active-thumb'); });
                        imageItems.forEach(function(v) { v.classList.remove('active-thumb'); });
                        this.classList.add('active-thumb');
                        
                        // Scroll to featured area smoothly
                        featuredContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            });
            
            // Click on image thumbnail to show in featured
            imageItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    // If there's a fancybox link, let it handle the click for lightbox
                    // But also update the featured area
                    var bgImage = this.style.backgroundImage;
                    var link = this.querySelector('a');
                    var imgSrc = link ? link.getAttribute('href') : '';
                    var title = link ? link.getAttribute('title') : '';
                    
                    if (imgSrc && featuredContainer) {
                        // Stop any playing video
                        if (currentVideoPlayer) {
                            currentVideoPlayer.pause();
                            currentVideoPlayer = null;
                        }
                        
                        // Create image HTML for featured area
                        var imageHTML = '<div class="featured-image active" style="background-image: url(\'' + imgSrc + '\')">' +
                            '<div class="image-overlay">' +
                            '<span class="view-btn"><i class="icon-search-plus"></i></span>' +
                            '</div>' +
                            '<a class="fancybox-trigger" href="' + imgSrc + '" title="' + title + '"></a>' +
                            '</div>';
                        
                        featuredContainer.innerHTML = imageHTML;
                        
                        // Re-initialize fancybox for the new element
                        if (typeof $.fn.fancybox !== 'undefined') {
                            $(featuredContainer).find('.fancybox-trigger').fancybox({
                                padding: 0,
                                margin: 20,
                                openEffect: 'elastic',
                                closeEffect: 'elastic'
                            });
                        }
                        
                        // Highlight active thumbnail
                        videoItems.forEach(function(v) { v.classList.remove('active-thumb'); });
                        imageItems.forEach(function(v) { v.classList.remove('active-thumb'); });
                        this.classList.add('active-thumb');
                    }
                });
            });
        });
        </script>
        {/literal}
    {/if}
{/block}
