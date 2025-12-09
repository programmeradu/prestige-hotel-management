/**
 * 2010-2025 Webkul/Prestige Hotel.
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
 *  @copyright 2010-2025 Webkul IN
 *  @license   https://store.webkul.com/license.html
 */

$(document).ready(function () {
    // Initialize Fancybox for gallery
    $(".fancybox-trigger, .fancybox-item").fancybox({
        padding: 0,
        margin: 20,
        openEffect: 'elastic',
        closeEffect: 'elastic',
        helpers: {
            overlay: {
                css: { 'background': 'rgba(0, 0, 0, 0.85)' }
            }
        }
    });

    // Slideshow Logic - supports both images and videos
    const featured = $('.gallery-featured');
    const imageItems = $('.gallery-item:not(.gallery-video-item)');
    const videoItems = $('.gallery-video-item');
    const allItems = $('.gallery-item');

    let currentIndex = 0;
    let currentVideoPlayer = null;
    let slideshowInterval = null;
    const SLIDE_INTERVAL = 5000; // 5 seconds for images, videos play to completion

    // Collect all media items (images and videos)
    const media = [];

    // Add featured content first (check if it's video or image)
    const featuredVideo = featured.find('.featured-uploaded-video');
    const featuredImage = featured.find('.featured-image');

    if (featuredVideo.length) {
        media.push({
            type: 'video',
            src: featuredVideo.find('source').attr('src'),
            title: featured.find('.video-title-overlay').text() || ''
        });
    } else if (featuredImage.length) {
        let bg = featuredImage.css('background-image');
        if (bg) {
            bg = bg.replace('url(', '').replace(')', '').replace(/\"/g, "");
            media.push({
                type: 'image',
                src: bg,
                href: featuredImage.find('a').attr('href'),
                title: featuredImage.find('a').attr('title') || ''
            });
        }
    }

    // Add grid items (images and videos)
    allItems.each(function () {
        const $item = $(this);

        if ($item.hasClass('gallery-video-item')) {
            // Video item
            media.push({
                type: 'video',
                src: $item.data('video-src'),
                title: $item.data('title') || ''
            });
        } else {
            // Image item
            let bg = $item.css('background-image');
            if (bg) {
                bg = bg.replace('url(', '').replace(')', '').replace(/\"/g, "");
                media.push({
                    type: 'image',
                    src: bg,
                    href: $item.find('a').attr('href'),
                    title: $item.find('a').attr('title') || ''
                });
            }
        }
    });

    // Start slideshow if we have multiple items
    if (media.length > 1) {
        startSlideshow();
    }

    function startSlideshow() {
        slideshowInterval = setInterval(function () {
            currentIndex = (currentIndex + 1) % media.length;
            updateFeatured(currentIndex);
        }, SLIDE_INTERVAL);
    }

    function stopSlideshow() {
        if (slideshowInterval) {
            clearInterval(slideshowInterval);
            slideshowInterval = null;
        }
    }

    function restartSlideshow() {
        stopSlideshow();
        startSlideshow();
    }

    function updateFeatured(index) {
        const item = media[index];
        if (!item) return;

        // Stop current video if any
        if (currentVideoPlayer) {
            currentVideoPlayer.pause();
            currentVideoPlayer = null;
        }

        // Fade out
        featured.css('opacity', '0.7');

        setTimeout(function () {
            if (item.type === 'video') {
                // Show video
                const videoHTML = '<div class="featured-video-container uploaded-video active-video" style="position:relative;width:100%;height:100%;">' +
                    '<video class="featured-uploaded-video" controls autoplay muted playsinline style="width:100%;height:100%;object-fit:contain;background:#000;border-radius:12px;">' +
                    '<source src="' + item.src + '" type="video/mp4">' +
                    'Your browser does not support video.' +
                    '</video>' +
                    (item.title ? '<div class="video-title-overlay">' + item.title + '</div>' : '') +
                    '</div>';

                featured.html(videoHTML);

                // Get video element and auto-play
                currentVideoPlayer = featured.find('video')[0];
                if (currentVideoPlayer) {
                    // Unmute after user interaction (autoplay policy)
                    currentVideoPlayer.muted = false;

                    // Play video
                    currentVideoPlayer.play().catch(function (e) {
                        console.log('Video autoplay blocked, keeping muted');
                        currentVideoPlayer.muted = true;
                        currentVideoPlayer.play();
                    });

                    // When video ends, advance to next slide
                    $(currentVideoPlayer).on('ended', function () {
                        currentIndex = (currentIndex + 1) % media.length;
                        updateFeatured(currentIndex);
                    });

                    // Pause slideshow while video plays
                    stopSlideshow();
                }
            } else {
                // Show image
                const imageHTML = '<div class="featured-image active" style="background-image: url(\'' + item.src + '\')">' +
                    '<div class="image-overlay">' +
                    '<span class="view-btn"><i class="icon-search-plus"></i></span>' +
                    '</div>' +
                    '<a class="fancybox-trigger" href="' + (item.href || item.src) + '" title="' + (item.title || '') + '"></a>' +
                    '</div>';

                featured.html(imageHTML);

                // Re-initialize fancybox
                featured.find('.fancybox-trigger').fancybox({
                    padding: 0,
                    margin: 20,
                    openEffect: 'elastic',
                    closeEffect: 'elastic'
                });

                // Resume slideshow for images
                restartSlideshow();
            }

            // Fade in
            featured.css('opacity', '1');

            // Highlight active thumbnail
            allItems.removeClass('active-thumb');
            if (index > 0) {
                // Index 0 is the original featured, subsequent ones match grid items
                allItems.eq(index - 1).addClass('active-thumb');
            }
        }, 300);
    }

    // Click handlers for manual selection
    imageItems.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let href = $(this).find('a').attr('href');
        let idx = media.findIndex(function (m) { return m.href === href || m.src.includes(href); });
        if (idx !== -1) {
            currentIndex = idx;
            updateFeatured(currentIndex);
        }
    });

    videoItems.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let videoSrc = $(this).data('video-src');
        let idx = media.findIndex(function (m) { return m.src === videoSrc; });
        if (idx !== -1) {
            currentIndex = idx;
            updateFeatured(currentIndex);
        }
    });

    // Pause slideshow on hover
    featured.on('mouseenter', function () {
        stopSlideshow();
    });

    featured.on('mouseleave', function () {
        // Only restart if not playing a video
        if (!currentVideoPlayer || currentVideoPlayer.paused) {
            restartSlideshow();
        }
    });
});
