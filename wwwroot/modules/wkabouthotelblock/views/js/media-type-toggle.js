/**
 * Media Type Toggle Script
 * Shows/hides image or video upload fields based on selection
 * Also auto-extracts video thumbnail using HTML5 Canvas
 */
$(document).ready(function () {
    var mediaTypeSelect = $('select[name="media_type"]');
    var imageGroup = $('input[name="interior_img"]').closest('.form-group');
    var videoGroup = $('input[name="interior_video"]').closest('.form-group');
    var videoInput = $('input[name="interior_video"]');

    // Create hidden field for auto-generated thumbnail
    var thumbnailField = $('<input type="hidden" name="auto_thumbnail" id="auto_thumbnail" value="">');
    $('form').append(thumbnailField);

    // Create thumbnail preview container
    var previewContainer = $('<div id="video-thumb-preview" style="margin-top:10px;display:none;">' +
        '<label style="font-weight:bold;margin-bottom:5px;display:block;">Auto-generated Thumbnail:</label>' +
        '<img id="thumb-preview-img" style="max-width:200px;border-radius:8px;border:2px solid #C9A96E;">' +
        '<p style="font-size:12px;color:#666;margin-top:5px;">Thumbnail captured from video first frame</p>' +
        '</div>');
    videoGroup.after(previewContainer);

    function toggleMediaFields() {
        var mediaType = mediaTypeSelect.val();

        if (mediaType === 'video') {
            imageGroup.slideUp(200);
            videoGroup.slideDown(200);
        } else {
            imageGroup.slideDown(200);
            videoGroup.slideUp(200);
            previewContainer.hide();
        }
    }

    /**
     * Extract thumbnail from video file
     * Captures a frame at 1 second (or 0 if video is shorter)
     */
    function extractVideoThumbnail(file) {
        return new Promise(function (resolve, reject) {
            var video = document.createElement('video');
            video.preload = 'metadata';
            video.muted = true;
            video.playsInline = true;

            video.onloadedmetadata = function () {
                // Seek to 1 second or 10% into video, whichever is smaller
                var seekTime = Math.min(1, video.duration * 0.1);
                video.currentTime = seekTime;
            };

            video.onseeked = function () {
                // Create canvas and capture frame
                var canvas = document.createElement('canvas');
                canvas.width = 720;
                canvas.height = 360;

                var ctx = canvas.getContext('2d');

                // Calculate scaling to fit 720x360 while maintaining aspect ratio
                var videoRatio = video.videoWidth / video.videoHeight;
                var canvasRatio = canvas.width / canvas.height;
                var drawWidth, drawHeight, offsetX, offsetY;

                if (videoRatio > canvasRatio) {
                    // Video is wider - fit by height
                    drawHeight = canvas.height;
                    drawWidth = video.videoWidth * (canvas.height / video.videoHeight);
                    offsetX = (canvas.width - drawWidth) / 2;
                    offsetY = 0;
                } else {
                    // Video is taller - fit by width
                    drawWidth = canvas.width;
                    drawHeight = video.videoHeight * (canvas.width / video.videoWidth);
                    offsetX = 0;
                    offsetY = (canvas.height - drawHeight) / 2;
                }

                // Fill background (for letterboxing)
                ctx.fillStyle = '#1a1a2e';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Draw video frame
                ctx.drawImage(video, offsetX, offsetY, drawWidth, drawHeight);

                // Convert to base64 JPEG
                var thumbnail = canvas.toDataURL('image/jpeg', 0.85);

                // Clean up
                URL.revokeObjectURL(video.src);

                resolve(thumbnail);
            };

            video.onerror = function (e) {
                console.error('Video load error:', e);
                reject(new Error('Failed to load video'));
            };

            // Load video from file
            video.src = URL.createObjectURL(file);
        });
    }

    // Listen for video file selection
    videoInput.on('change', function (e) {
        var file = this.files[0];
        if (!file) {
            thumbnailField.val('');
            previewContainer.hide();
            return;
        }

        // Check if it's a video file
        if (!file.type.startsWith('video/')) {
            console.log('Not a video file');
            return;
        }

        // Show loading state
        previewContainer.show();
        $('#thumb-preview-img').attr('src', '').css('opacity', '0.5');
        previewContainer.find('p').text('Extracting thumbnail...');

        // Extract thumbnail
        extractVideoThumbnail(file).then(function (thumbnail) {
            thumbnailField.val(thumbnail);
            $('#thumb-preview-img').attr('src', thumbnail).css('opacity', '1');
            previewContainer.find('p').text('Thumbnail captured from video');
            console.log('Video thumbnail extracted successfully');
        }).catch(function (err) {
            console.error('Thumbnail extraction failed:', err);
            previewContainer.find('p').text('Could not extract thumbnail (will use gradient fallback)');
            thumbnailField.val('');
        });
    });

    // Initial toggle
    if (mediaTypeSelect.length) {
        toggleMediaFields();

        // On change
        mediaTypeSelect.on('change', toggleMediaFields);
    }

    // Add visual indicator for media type in list
    $('.badge-info').parent().css('background', 'rgba(23, 162, 184, 0.1)');
});

