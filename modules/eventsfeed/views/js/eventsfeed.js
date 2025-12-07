/**
 * Events Feed Module JavaScript
 * 2024-2025 Prestige Hotel
 */

(function() {
    'use strict';

    // Check if we need to load events dynamically
    var grid = document.getElementById('eventsGrid');
    if (!grid) return;

    var feedUrl = grid.getAttribute('data-feed-url');
    if (!feedUrl) return;

    // Check if events are already loaded (from TPL)
    var existingCards = grid.querySelectorAll('.event-card:not(.event-skeleton)');
    if (existingCards.length > 0) {
        // Events already loaded from server
        return;
    }

    // Load events via AJAX
    loadEvents();

    function loadEvents() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', feedUrl + '?limit=4', true);
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success && response.events) {
                            renderEvents(response.events);
                        } else {
                            showError();
                        }
                    } catch (e) {
                        showError();
                    }
                } else {
                    showError();
                }
            }
        };

        xhr.send();
    }

    function renderEvents(events) {
        if (!events || events.length === 0) {
            showError();
            return;
        }

        var html = '';
        for (var i = 0; i < events.length; i++) {
            html += createEventCard(events[i]);
        }

        grid.innerHTML = html;
    }

    function createEventCard(event) {
        var dateObj = parseDate(event.start);
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        var imageHtml = '';
        if (event.image) {
            imageHtml = '<img src="' + escapeHtml(event.image) + '" alt="' + escapeHtml(event.title) + '" loading="lazy">';
        } else {
            imageHtml = '<div class="event-image-placeholder"><i class="icon-calendar"></i></div>';
        }

        var sourceBadge = '';
        if (event.source === 'demo') {
            sourceBadge = '<span class="event-source-badge">Sample</span>';
        }

        var venueHtml = '';
        if (event.venue && event.venue.name) {
            venueHtml = '<span class="event-venue"><i class="icon-map-marker"></i> ' + escapeHtml(event.venue.name) + '</span>';
        }

        var linkHtml = '';
        if (event.url && event.url !== '#') {
            linkHtml = '<a href="' + escapeHtml(event.url) + '" class="event-link" target="_blank" rel="noopener">Learn More <i class="icon-angle-right"></i></a>';
        }

        return '<div class="event-card" data-event-id="' + escapeHtml(event.id) + '">' +
            '<div class="event-image">' +
                imageHtml +
                '<div class="event-date-badge">' +
                    '<span class="event-month">' + monthNames[dateObj.getMonth()] + '</span>' +
                    '<span class="event-day">' + padZero(dateObj.getDate()) + '</span>' +
                '</div>' +
                sourceBadge +
            '</div>' +
            '<div class="event-content">' +
                '<span class="event-category">' + escapeHtml(event.category || 'event') + '</span>' +
                '<h3 class="event-title">' + escapeHtml(event.title) + '</h3>' +
                '<p class="event-description">' + escapeHtml(event.description || '') + '</p>' +
                '<div class="event-meta">' + venueHtml + '</div>' +
                linkHtml +
            '</div>' +
        '</div>';
    }

    function showError() {
        grid.innerHTML = '<div class="events-error" style="text-align:center;padding:40px;color:#888;">' +
            '<i class="icon-calendar" style="font-size:48px;margin-bottom:15px;display:block;"></i>' +
            '<p>Unable to load events at this time.</p>' +
        '</div>';
    }

    function parseDate(dateStr) {
        if (!dateStr) return new Date();
        // Handle ISO 8601 format
        return new Date(dateStr);
    }

    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }

    function escapeHtml(str) {
        if (!str) return '';
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }
})();



