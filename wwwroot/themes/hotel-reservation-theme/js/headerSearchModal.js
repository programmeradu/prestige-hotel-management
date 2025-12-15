/**
 * Header Search Modal System v2.0
 * 
 * A clean, compact modal system for the header search form.
 * Creates custom modal overlays that are appended to body with proper z-index.
 * 
 * @author Prestige Hotel
 */

(function ($) {
    'use strict';

    var modalId = 'header-search-modal';
    var $modal = null;
    var currentType = null;

    /**
     * Initialize the modal system
     */
    function init() {
        createModal();
        bindTriggers();
    }

    /**
     * Create the modal container (appended to body)
     */
    function createModal() {
        var modalHtml =
            '<div id="' + modalId + '" class="hsm-overlay">' +
            '<div class="hsm-backdrop"></div>' +
            '<div class="hsm-container">' +
            '<div class="hsm-header">' +
            '<span class="hsm-title"></span>' +
            '<button type="button" class="hsm-close">&times;</button>' +
            '</div>' +
            '<div class="hsm-body"></div>' +
            '</div>' +
            '</div>';

        $modal = $(modalHtml);
        $('body').append($modal);

        // Close handlers
        $modal.find('.hsm-backdrop, .hsm-close').on('click', closeModal);
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) closeModal();
        });
    }

    /**
     * Bind click handlers to triggers
     */
    function bindTriggers() {
        // Date picker trigger (header form only)
        $(document).on('click', '#search_hotel_block_form #daterange_value, #search_hotel_block_form .input-date', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openDateModal($(this));
            return false;
        });

        // Occupancy trigger (header form only)
        $(document).on('click', '#search_hotel_block_form #guest_occupancy', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openOccupancyModal($(this));
            return false;
        });

        // Disable Bootstrap dropdown on header occupancy
        $('#search_hotel_block_form #guest_occupancy').removeAttr('data-toggle');
    }

    /**
     * Open the date picker modal
     */
    function openDateModal($trigger) {
        currentType = 'date';

        // Get current dates
        var checkIn = $('#check_in_time').val() || '';
        var checkOut = $('#check_out_time').val() || '';

        // Build date picker content
        var content = buildDatePickerContent(checkIn, checkOut);

        showModal('Select Dates', content, $trigger);
        initDatePickerBehavior();
    }

    /**
     * Build date picker HTML content
     */
    function buildDatePickerContent(checkIn, checkOut) {
        var today = new Date();
        var currentMonth = today.getMonth();
        var currentYear = today.getFullYear();

        return '<div class="hsm-datepicker" data-check-in="' + checkIn + '" data-check-out="' + checkOut + '">' +
            buildCalendar(currentMonth, currentYear) +
            '<div class="hsm-date-actions">' +
            '<div class="hsm-date-display">' +
            '<span class="hsm-date-label">Check-in:</span> <span id="hsm-checkin-display">' + (checkIn || 'Select') + '</span>' +
            ' &nbsp;&rarr;&nbsp; ' +
            '<span class="hsm-date-label">Check-out:</span> <span id="hsm-checkout-display">' + (checkOut || 'Select') + '</span>' +
            '</div>' +
            '<button type="button" class="hsm-btn hsm-btn-primary hsm-apply-dates">Apply</button>' +
            '</div>' +
            '</div>';
    }

    /**
     * Build calendar for a given month/year
     */
    function buildCalendar(month, year) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'];
        var days = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];

        var firstDay = new Date(year, month, 1).getDay();
        firstDay = firstDay === 0 ? 6 : firstDay - 1; // Adjust for Monday start
        var daysInMonth = new Date(year, month + 1, 0).getDate();
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        var html = '<div class="hsm-calendar" data-month="' + month + '" data-year="' + year + '">';
        html += '<div class="hsm-cal-header">';
        html += '<button type="button" class="hsm-cal-nav hsm-cal-prev">&lsaquo;</button>';
        html += '<span class="hsm-cal-title">' + months[month] + ' ' + year + '</span>';
        html += '<button type="button" class="hsm-cal-nav hsm-cal-next">&rsaquo;</button>';
        html += '</div>';

        html += '<table class="hsm-cal-table"><thead><tr>';
        for (var d = 0; d < 7; d++) {
            html += '<th>' + days[d] + '</th>';
        }
        html += '</tr></thead><tbody><tr>';

        // Empty cells before first day
        for (var i = 0; i < firstDay; i++) {
            html += '<td></td>';
        }

        // Days of month
        var cellCount = firstDay;
        for (var day = 1; day <= daysInMonth; day++) {
            var date = new Date(year, month, day);
            var dateStr = formatDate(date);
            var isPast = date < today;
            var isToday = date.getTime() === today.getTime();

            var classes = 'hsm-day';
            if (isPast) classes += ' hsm-day-disabled';
            if (isToday) classes += ' hsm-day-today';

            html += '<td><span class="' + classes + '" data-date="' + dateStr + '">' + day + '</span></td>';

            cellCount++;
            if (cellCount % 7 === 0 && day < daysInMonth) {
                html += '</tr><tr>';
            }
        }

        // Fill remaining cells
        while (cellCount % 7 !== 0) {
            html += '<td></td>';
            cellCount++;
        }

        html += '</tr></tbody></table></div>';
        return html;
    }

    /**
     * Initialize date picker behavior
     */
    function initDatePickerBehavior() {
        var $dp = $modal.find('.hsm-datepicker');
        var checkIn = null;
        var checkOut = null;

        // Day click
        $modal.on('click', '.hsm-day:not(.hsm-day-disabled)', function () {
            var date = $(this).data('date');

            if (!checkIn || (checkIn && checkOut)) {
                // Start new selection
                checkIn = date;
                checkOut = null;
                $modal.find('.hsm-day').removeClass('hsm-day-selected hsm-day-range');
                $(this).addClass('hsm-day-selected');
            } else {
                // Complete selection
                if (date > checkIn) {
                    checkOut = date;
                } else {
                    checkOut = checkIn;
                    checkIn = date;
                }
                highlightRange(checkIn, checkOut);
            }

            $('#hsm-checkin-display').text(checkIn || 'Select');
            $('#hsm-checkout-display').text(checkOut || 'Select');
        });

        // Navigation
        $modal.on('click', '.hsm-cal-prev, .hsm-cal-next', function () {
            var $cal = $(this).closest('.hsm-calendar');
            var month = parseInt($cal.data('month'));
            var year = parseInt($cal.data('year'));

            if ($(this).hasClass('hsm-cal-prev')) {
                month--;
                if (month < 0) { month = 11; year--; }
            } else {
                month++;
                if (month > 11) { month = 0; year++; }
            }

            $cal.replaceWith(buildCalendar(month, year));
            if (checkIn) highlightRange(checkIn, checkOut);
        });

        // Apply button
        $modal.on('click', '.hsm-apply-dates', function () {
            if (checkIn && checkOut) {
                $('#check_in_time').val(checkIn);
                $('#check_out_time').val(checkOut);

                // Update display
                var displayText = checkIn + ' - ' + checkOut;
                $('#search_hotel_block_form #daterange_value span').text(displayText);
                $('#search_hotel_block_form .input-date span').first().text(checkIn);

                closeModal();
            }
        });
    }

    /**
     * Highlight date range
     */
    function highlightRange(start, end) {
        $modal.find('.hsm-day').removeClass('hsm-day-selected hsm-day-range');
        $modal.find('.hsm-day').each(function () {
            var date = $(this).data('date');
            if (date === start || date === end) {
                $(this).addClass('hsm-day-selected');
            } else if (date > start && date < end) {
                $(this).addClass('hsm-day-range');
            }
        });
    }

    /**
     * Open occupancy modal
     */
    function openOccupancyModal($trigger) {
        currentType = 'occupancy';

        // Clone the dropdown content
        var $original = $('#search_hotel_block_form #search_occupancy_wrapper');
        var content = buildOccupancyContent($original);

        showModal('Select Guests', content, $trigger);
        initOccupancyBehavior();
    }

    /**
     * Build occupancy modal content
     */
    function buildOccupancyContent($original) {
        return '<div class="hsm-occupancy">' +
            '<div class="hsm-room-block">' +
            '<div class="hsm-room-header">Room 1</div>' +
            '<div class="hsm-room-row">' +
            '<div class="hsm-room-field">' +
            '<label>Adults</label>' +
            '<div class="hsm-counter">' +
            '<button type="button" class="hsm-counter-btn hsm-minus" data-target="adults">−</button>' +
            '<span class="hsm-counter-value" id="hsm-adults">1</span>' +
            '<button type="button" class="hsm-counter-btn hsm-plus" data-target="adults">+</button>' +
            '</div>' +
            '</div>' +
            '<div class="hsm-room-field">' +
            '<label>Children</label>' +
            '<div class="hsm-counter">' +
            '<button type="button" class="hsm-counter-btn hsm-minus" data-target="children">−</button>' +
            '<span class="hsm-counter-value" id="hsm-children">0</span>' +
            '<button type="button" class="hsm-counter-btn hsm-plus" data-target="children">+</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="hsm-occupancy-actions">' +
            '<button type="button" class="hsm-btn hsm-btn-primary hsm-apply-occupancy">Done</button>' +
            '</div>' +
            '</div>';
    }

    /**
     * Initialize occupancy behavior
     */
    function initOccupancyBehavior() {
        var adults = 1;
        var children = 0;

        $modal.on('click', '.hsm-counter-btn', function () {
            var target = $(this).data('target');
            var isPlus = $(this).hasClass('hsm-plus');

            if (target === 'adults') {
                adults = isPlus ? adults + 1 : Math.max(1, adults - 1);
                $('#hsm-adults').text(adults);
            } else {
                children = isPlus ? children + 1 : Math.max(0, children - 1);
                $('#hsm-children').text(children);
            }
        });

        $modal.on('click', '.hsm-apply-occupancy', function () {
            // Update form
            var $original = $('#search_hotel_block_form #search_occupancy_wrapper');
            $original.find('.num_adults').val(adults);
            $original.find('.num_children').val(children);
            $original.find('.occupancy_count').first().find('span').text(adults);
            $original.find('.occupancy_count').last().find('span').text(children);

            // Update button text
            var text = adults + ' Adult' + (adults > 1 ? 's' : '') + ', 1 Room';
            if (children > 0) {
                text = adults + ' Adult' + (adults > 1 ? 's' : '') + ', ' +
                    children + ' Child' + (children > 1 ? 'ren' : '') + ', 1 Room';
            }
            $('#search_hotel_block_form #guest_occupancy span').text(text);

            closeModal();
        });
    }

    /**
     * Show the modal
     */
    function showModal(title, content, $trigger) {
        $modal.find('.hsm-title').text(title);
        $modal.find('.hsm-body').html(content);

        // Position near trigger
        var offset = $trigger.offset();
        var triggerHeight = $trigger.outerHeight();

        $modal.find('.hsm-container').css({
            top: Math.min(offset.top + triggerHeight + 10, window.innerHeight - 400),
            left: Math.max(10, Math.min(offset.left, window.innerWidth - 340))
        });

        $modal.addClass('hsm-open');
    }

    /**
     * Close the modal
     */
    function closeModal() {
        $modal.removeClass('hsm-open');
        $modal.find('.hsm-body').empty();
        $modal.off('click', '.hsm-day');
        $modal.off('click', '.hsm-cal-prev, .hsm-cal-next');
        $modal.off('click', '.hsm-apply-dates');
        $modal.off('click', '.hsm-counter-btn');
        $modal.off('click', '.hsm-apply-occupancy');
        currentType = null;
    }

    /**
     * Format date as DD-MM-YYYY
     */
    function formatDate(date) {
        var d = date.getDate();
        var m = date.getMonth() + 1;
        var y = date.getFullYear();
        return (d < 10 ? '0' : '') + d + '-' + (m < 10 ? '0' : '') + m + '-' + y;
    }

    // Initialize when ready
    $(document).ready(function () {
        setTimeout(init, 300);
    });

})(jQuery);
