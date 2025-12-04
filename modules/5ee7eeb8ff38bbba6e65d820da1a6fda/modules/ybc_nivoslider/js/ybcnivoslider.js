/**
 * Copyright: YourBestCode.Com
 * Email: support@yourbestcode.com
 */
jQuery(window).load(function(){
    $('#ybc-nivo-slider').nivoSlider({
        pauseTime: YBCNIVO_PAUSE,        
        textFrameWidth: YBCNIVO_FRAME_WIDTH,
        captionDelay : YBCNIVO_CAPTION_SPEED,
        animSpeed: YBCNIVO_SPEED,  
        startSlide: YBCNIVO_START_SLIDE - 1, 
        controlNav: YBCNIVO_SHOW_CONTROL,
        pauseOnHover: YBCNIVO_PAUSE_ON_HOVER,
        manualAdvance: !YBCNIVO_LOOP,
        directionNav: YBCNIVO_SHOW_PREV_NEXT,
        afterLoad: function(){   
            $('#ybc-nivo-slider').css('opacity',1);
            $('.ybc-nivo-link').fadeIn();
            $('#ybc-nivo-slider-loader').fadeOut();
        }
    });
});