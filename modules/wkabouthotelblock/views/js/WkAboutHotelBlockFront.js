/**
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
*/

$(document).ready(function(){
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

    // Slideshow Logic
    const featured = $('.featured-image');
    const items = $('.gallery-item');
    let currentIndex = 0;
    
    // Collect all images
    const images = [];
    
    // Add featured image first
    if (featured.length) {
        let bg = featured.css('background-image');
        if (bg) {
            bg = bg.replace('url(','').replace(')','').replace(/\"/g, "");
            images.push({
                src: bg,
                href: featured.find('a').attr('href'),
                title: featured.find('a').attr('title')
            });
        }
    }

    // Add grid images
    items.each(function() {
        let bg = $(this).css('background-image');
        if (bg) {
            bg = bg.replace('url(','').replace(')','').replace(/\"/g, "");
            images.push({
                src: bg,
                href: $(this).find('a').attr('href'),
                title: $(this).find('a').attr('title')
            });
        }
    });

    // Auto switch every 4 seconds
    if (images.length > 1) {
        setInterval(function() {
            currentIndex = (currentIndex + 1) % images.length;
            updateFeatured(currentIndex);
        }, 4000);
    }

    function updateFeatured(index) {
        const img = images[index];
        if (!img) return;
        
        // Fade out
        featured.css('opacity', '0.5');
        
        setTimeout(function() {
            // Update background and link
            featured.css('background-image', 'url("' + img.src + '")');
            featured.find('a').attr('href', img.href).attr('title', img.title);
            
            // Fade in
            featured.css('opacity', '1');
            
            // Highlight active thumbnail (optional)
            items.removeClass('active-thumb');
            if (index > 0) { // 0 is the original featured, so subsequent ones match grid items
                items.eq(index - 1).addClass('active-thumb');
            }
        }, 400);
    }

    // Optional: Click on thumbnail to set as featured
    items.on('click', function(e) {
        e.preventDefault();
        // Find index in our images array
        let href = $(this).find('a').attr('href');
        let idx = images.findIndex(img => img.href === href);
        if (idx !== -1) {
            currentIndex = idx;
            updateFeatured(currentIndex);
        }
    });
});

    if (images.length > 1) {
        setInterval(function() {
            currentIndex = (currentIndex + 1) % images.length;
            updateFeatured(currentIndex);
        }, 4000);
    }

    function updateFeatured(index) {
        const img = images[index];
        if (!img) return;
        
        // Fade out
        featured.css('opacity', '0.5');
        
        setTimeout(function() {
            // Update background and link
            featured.css('background-image', 'url("' + img.src + '")');
            featured.find('a').attr('href', img.href).attr('title', img.title);
            
            // Fade in
            featured.css('opacity', '1');
            
            // Highlight active thumbnail (optional)
            items.removeClass('active-thumb');
            if (index > 0) { // 0 is the original featured, so subsequent ones match grid items
                items.eq(index - 1).addClass('active-thumb');
            }
        }, 400);
    }

    // Optional: Click on thumbnail to set as featured
    items.on('click', function(e) {
        e.preventDefault();
        // Find index in our images array
        let href = $(this).find('a').attr('href');
        let idx = images.findIndex(img => img.href === href);
        if (idx !== -1) {
            currentIndex = idx;
            updateFeatured(currentIndex);
        }
    });
});


    // Pause on hover
    $('.premium-gallery-container').hover(
        function() { clearInterval(rotateInterval); },
        function() { rotateInterval = setInterval(rotateGallery, 4000); }
    );

    function rotateGallery() {
        currentIndex = (currentIndex + 1) % images.length;
        updateDisplay(currentIndex);
    }

    function updateDisplay(index) {
        const img = images[index];
        if (!img) return;

        // A. Update Featured Image with Fade
        featured.css('opacity', '0.7');
        setTimeout(function() {
            featured.css('background-image', 'url("' + img.src + '")');
            featured.find('a').attr('href', img.href).attr('title', img.title);
            featured.css('opacity', '1');
        }, 300);

        // B. Update Carousel Sidebar
        // Logic: The sidebar should conceptually 'rotate' too.
        // We will highlight the active thumb if visible, or scroll to it.
        
        items.removeClass('active-thumb');
        
        // Find the thumbnail that corresponds to this image
        // (Note: index 0 is the original featured image, which might not have a thumb if it was separate)
        // But in our TPL, thumbnails start from index 1 of the PHP array. 
        // Our 'images' array has [Featured, Thumb1, Thumb2...]
        // So 'images[index]' corresponds to 'items[index-1]' approximately.
        
        let thumbIndex = index - 1; 
        if (thumbIndex >= 0 && thumbIndex < items.length) {
            let activeItem = items.eq(thumbIndex);
            activeItem.addClass('active-thumb');
            
            // Scroll sidebar to keep active item in view
            // Simple logic: Scroll to putting active item in middle if possible
            if (listContainer.height() > 0) { // PC mode
                 let scrollPos = activeItem.position().top + listContainer.scrollTop() - (listContainer.height()/2) + (activeItem.height()/2);
                 listContainer.animate({ scrollTop: scrollPos }, 500);
            } else { // Mobile mode (horizontal)
                 let scrollPos = activeItem.position().left + listContainer.scrollLeft() - (listContainer.width()/2) + (activeItem.width()/2);
                 listContainer.animate({ scrollLeft: scrollPos }, 500);
            }
        } else if (index === 0) {
            // If back to start, scroll to top
            listContainer.animate({ scrollTop: 0, scrollLeft: 0 }, 500);
        }
    }

    // Click to Select
    items.on('click', function(e) {
        if ($(e.target).hasClass('fancybox-item')) return; // Allow fancybox open
        e.preventDefault();
        
        let href = $(this).find('a').attr('href');
        let idx = images.findIndex(img => img.href === href);
        if (idx !== -1) {
            currentIndex = idx;
            updateDisplay(currentIndex);
        }
    });
});
