/**
 * Media Type Toggle Script
 * Shows/hides image or video upload fields based on selection
 */
$(document).ready(function() {
    var mediaTypeSelect = $('select[name="media_type"]');
    var imageGroup = $('input[name="interior_img"]').closest('.form-group');
    var videoGroup = $('input[name="interior_video"]').closest('.form-group');
    
    function toggleMediaFields() {
        var mediaType = mediaTypeSelect.val();
        
        if (mediaType === 'video') {
            imageGroup.slideUp(200);
            videoGroup.slideDown(200);
        } else {
            imageGroup.slideDown(200);
            videoGroup.slideUp(200);
        }
    }
    
    // Initial toggle
    if (mediaTypeSelect.length) {
        toggleMediaFields();
        
        // On change
        mediaTypeSelect.on('change', toggleMediaFields);
    }
    
    // Add visual indicator for media type in list
    $('.badge-info').parent().css('background', 'rgba(23, 162, 184, 0.1)');
});
