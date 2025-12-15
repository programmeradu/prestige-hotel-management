/**
 * Header Search Modal Handler
 * 
 * This script creates fixed-position modal overlays for the header search form's
 * datepicker and occupancy selector to ensure they appear above all page content.
 * 
 * @author Prestige Hotel
 * @version 1.0
 */

(function ($) {
    'use strict';

    // Modal overlay container
    var $modalOverlay = null;
    var $modalContent = null;
    var activeModal = null;

    /**
     * Initialize the modal system
     */
    function init() {
        // Create the modal overlay container (appended to body)
        createModalOverlay();

        // Intercept clicks on the header search inputs
        bindDatePickerTrigger();
        bindOccupancyTrigger();

        // Close modal when clicking outside
        $(document).on('click', '.header-search-modal-overlay', function (e) {
            if ($(e.target).hasClass('header-search-modal-overlay')) {
                closeModal();
            }
        });

        // Close modal on escape key
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27 && activeModal) {
                closeModal();
            }
        });
    }

    /**
     * Create the modal overlay container
     */
    function createModalOverlay() {
        $modalOverlay = $('<div class="header-search-modal-overlay" style="display:none;"></div>');
        $modalContent = $('<div class="header-search-modal-content"></div>');
        $modalOverlay.append($modalContent);
        $('body').append($modalOverlay);
    }

    /**
     * Bind click handler to the daterange input
     */
    function bindDatePickerTrigger() {
        // Target: #daterange_value in header search only
        $(document).on('click', '#search_hotel_block_form #daterange_value', function (e) {
            var $input = $(this);
            var datePickerInstance = $input.data('dateRangePicker');

            if (datePickerInstance) {
                e.stopPropagation();

                // Get the date picker wrapper element
                var $datePicker = datePickerInstance.getDatePicker();

                if ($datePicker && $datePicker.length) {
                    openDatePickerModal($input, $datePicker);
                }
            }
        });
    }

    /**
     * Bind click handler to the occupancy button
     */
    function bindOccupancyTrigger() {
        // Remove Bootstrap dropdown behavior from header search occupancy button
        var $headerOccupancy = $('#search_hotel_block_form #guest_occupancy');
        if ($headerOccupancy.length) {
            $headerOccupancy.removeAttr('data-toggle');
            $headerOccupancy.closest('.dropdown').off('show.bs.dropdown hide.bs.dropdown');
        }

        // Target: #guest_occupancy in header search only
        $(document).on('click', '#search_hotel_block_form #guest_occupancy', function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            var $button = $(this);
            var $dropdown = $button.closest('.dropdown').find('#search_occupancy_wrapper');

            if ($dropdown.length) {
                openOccupancyModal($button, $dropdown);
            }

            return false;
        });
    }

    /**
     * Open the datepicker in a fixed modal
     */
    function openDatePickerModal($input, $datePicker) {
        if (activeModal === 'datepicker') {
            closeModal();
            return;
        }

        closeModal();
        activeModal = 'datepicker';

        // Store original parent and styles for restoration
        $datePicker.data('original-parent', $datePicker.parent());
        $datePicker.data('original-style', $datePicker.attr('style') || '');

        // Clear all inline styles that interfere with modal positioning
        $datePicker.css({
            'top': 'auto',
            'left': 'auto',
            'right': 'auto',
            'bottom': 'auto',
            'position': 'static',
            'transform': 'none',
            'display': 'block',
            'visibility': 'visible',
            'opacity': '1',
            'overflow': 'visible'
        });

        // Move datepicker to modal
        $modalContent.empty().append($datePicker);

        // Position modal below the input
        positionModalBelow($input);

        // Show overlay and datepicker
        $modalOverlay.show();
        $datePicker.show();

        // Add class for styling
        $modalContent.addClass('datepicker-modal');
    }

    /**
     * Open the occupancy dropdown in a fixed modal
     */
    function openOccupancyModal($button, $dropdown) {
        if (activeModal === 'occupancy') {
            closeModal();
            return;
        }

        closeModal();
        activeModal = 'occupancy';

        // Clone the dropdown content so we don't break the original
        var $clonedDropdown = $dropdown.clone(true, true);
        $clonedDropdown.attr('id', 'search_occupancy_wrapper_modal');

        // Store reference to original for syncing values
        $clonedDropdown.data('original-dropdown', $dropdown);

        // Move to modal
        $modalContent.empty().append($clonedDropdown);

        // Position modal below the button
        positionModalBelow($button);

        // Show overlay and dropdown
        $modalOverlay.show();
        $clonedDropdown.show().css('display', 'block');

        // Add class for styling
        $modalContent.addClass('occupancy-modal');

        // Bind Done button to sync and close
        $clonedDropdown.find('.submit_occupancy_btn').off('click').on('click', function (e) {
            e.preventDefault();
            syncOccupancyValues($clonedDropdown, $dropdown, $button);
            closeModal();
        });

        // Bind quantity buttons
        bindQuantityButtons($clonedDropdown, $dropdown, $button);

        // Bind add room
        bindAddRoom($clonedDropdown, $dropdown);

        // Bind remove room
        bindRemoveRoom($clonedDropdown, $dropdown);
    }

    /**
     * Bind quantity up/down buttons in the modal
     */
    function bindQuantityButtons($modal, $original, $button) {
        $modal.find('.occupancy_quantity_up, .occupancy_quantity_down').off('click').on('click', function (e) {
            e.preventDefault();

            var $btn = $(this);
            var isUp = $btn.hasClass('occupancy_quantity_up');
            var $countBlock = $btn.closest('.occupancy_count_block');
            var $countInput = $countBlock.find('.num_occupancy');
            var $countDisplay = $countBlock.find('.occupancy_count span');

            var currentVal = parseInt($countInput.val()) || 0;
            var newVal = isUp ? currentVal + 1 : Math.max(0, currentVal - 1);

            // For adults, minimum is 1
            if ($countInput.hasClass('num_adults')) {
                newVal = Math.max(1, newVal);
            }

            $countInput.val(newVal);
            $countDisplay.text(newVal);
        });
    }

    /**
     * Bind add room functionality
     */
    function bindAddRoom($modal, $original) {
        $modal.find('.add_new_occupancy_btn').off('click').on('click', function (e) {
            e.preventDefault();

            var $innerWrapper = $modal.find('#occupancy_inner_wrapper');
            var roomCount = $innerWrapper.find('.occupancy-room-block').length;
            var newIndex = roomCount;

            // Clone the first room block as template
            var $firstRoom = $innerWrapper.find('.occupancy-room-block').first();
            var $newRoom = $firstRoom.clone();

            // Update the room number and index
            $newRoom.find('.room_num_wrapper').text('Room - ' + (roomCount + 1));
            $newRoom.find('.occupancy_info_block').attr('occ_block_index', newIndex);

            // Reset values
            $newRoom.find('.num_adults').val(1).attr('name', 'occupancy[' + newIndex + '][adults]');
            $newRoom.find('.num_children').val(0).attr('name', 'occupancy[' + newIndex + '][children]');
            $newRoom.find('.occupancy_count span').first().text('1');
            $newRoom.find('.occupancy_count span').last().text('0');

            // Add remove link if not present
            if (!$newRoom.find('.remove-room-link').length) {
                $newRoom.find('.occupancy_info_head').append('<a class="remove-room-link pull-right" href="#">Remove</a>');
            }

            $innerWrapper.append($newRoom);

            // Rebind buttons for new room
            bindQuantityButtons($modal, $original, null);
            bindRemoveRoom($modal, $original);
        });
    }

    /**
     * Bind remove room functionality
     */
    function bindRemoveRoom($modal, $original) {
        $modal.find('.remove-room-link').off('click').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.occupancy-room-block').remove();

            // Renumber rooms
            $modal.find('.occupancy-room-block').each(function (index) {
                $(this).find('.room_num_wrapper').text('Room - ' + (index + 1));
                $(this).find('.occupancy_info_block').attr('occ_block_index', index);
                $(this).find('.num_adults').attr('name', 'occupancy[' + index + '][adults]');
                $(this).find('.num_children').attr('name', 'occupancy[' + index + '][children]');
            });
        });
    }

    /**
     * Sync occupancy values from modal back to original form
     */
    function syncOccupancyValues($modal, $original, $button) {
        // Get all room data from modal
        var rooms = [];
        var totalAdults = 0;
        var totalChildren = 0;

        $modal.find('.occupancy-room-block').each(function () {
            var adults = parseInt($(this).find('.num_adults').val()) || 1;
            var children = parseInt($(this).find('.num_children').val()) || 0;
            rooms.push({ adults: adults, children: children });
            totalAdults += adults;
            totalChildren += children;
        });

        // Update button text
        var buttonText = totalAdults + ' ' + (totalAdults > 1 ? 'Adults' : 'Adult');
        if (totalChildren > 0) {
            buttonText += ', ' + totalChildren + ' ' + (totalChildren > 1 ? 'Children' : 'Child');
        }
        buttonText += ', ' + rooms.length + ' ' + (rooms.length > 1 ? 'Rooms' : 'Room');
        $button.find('span').text(buttonText);

        // Rebuild original dropdown to match modal
        var $originalInner = $original.find('#occupancy_inner_wrapper');
        $originalInner.empty();

        rooms.forEach(function (room, index) {
            var roomHtml = createRoomHtml(index, room.adults, room.children, index > 0);
            $originalInner.append(roomHtml);
        });
    }

    /**
     * Create HTML for a room block
     */
    function createRoomHtml(index, adults, children, showRemove) {
        return '<div class="occupancy-room-block">' +
            '<div class="occupancy_info_head"><span class="room_num_wrapper">Room - ' + (index + 1) + '</span>' +
            (showRemove ? '<a class="remove-room-link pull-right" href="#">Remove</a>' : '') +
            '</div>' +
            '<div class="occupancy_info_block" occ_block_index="' + index + '">' +
            '<div class="row">' +
            '<div class="form-group occupancy_count_block col-sm-5 col-xs-6">' +
            '<label>Adults</label>' +
            '<div>' +
            '<input type="hidden" class="num_occupancy num_adults room_occupancies" name="occupancy[' + index + '][adults]" value="' + adults + '">' +
            '<div class="occupancy_count pull-left"><span>' + adults + '</span></div>' +
            '<div class="qty_direction pull-left">' +
            '<a href="#" class="btn btn-default occupancy_quantity_up"><span><i class="icon-plus"></i></span></a>' +
            '<a href="#" class="btn btn-default occupancy_quantity_down"><span><i class="icon-minus"></i></span></a>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="form-group occupancy_count_block col-sm-7 col-xs-6">' +
            '<label>Children</label>' +
            '<div class="clearfix">' +
            '<input type="hidden" class="num_occupancy num_children room_occupancies" name="occupancy[' + index + '][children]" value="' + children + '">' +
            '<div class="occupancy_count pull-left"><span>' + children + '</span></div>' +
            '<div class="qty_direction pull-left">' +
            '<a href="#" class="btn btn-default occupancy_quantity_up"><span><i class="icon-plus"></i></span></a>' +
            '<a href="#" class="btn btn-default occupancy_quantity_down"><span><i class="icon-minus"></i></span></a>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<hr class="occupancy-info-separator">' +
            '</div>';
    }

    /**
     * Position the modal below a target element
     */
    function positionModalBelow($target) {
        var offset = $target.offset();
        var targetHeight = $target.outerHeight();
        var targetWidth = $target.outerWidth();

        $modalContent.css({
            position: 'absolute',
            top: offset.top + targetHeight + 10,
            left: offset.left,
            minWidth: Math.max(300, targetWidth)
        });
    }

    /**
     * Close the modal
     */
    function closeModal() {
        if (!activeModal) return;

        // If datepicker, return it to original parent with original styles
        if (activeModal === 'datepicker') {
            var $datePicker = $modalContent.find('.date-picker-wrapper');
            var $originalParent = $datePicker.data('original-parent');
            var originalStyle = $datePicker.data('original-style');

            if ($originalParent && $originalParent.length) {
                // Restore original style attribute
                if (originalStyle) {
                    $datePicker.attr('style', originalStyle);
                } else {
                    $datePicker.removeAttr('style');
                }
                $datePicker.hide().appendTo($originalParent);
            }
        }

        // Clear and hide modal
        $modalOverlay.hide();
        $modalContent.empty().removeClass('datepicker-modal occupancy-modal');
        activeModal = null;
    }

    // Initialize when DOM is ready
    $(document).ready(function () {
        // Small delay to ensure other scripts have initialized
        setTimeout(init, 500);
    });

})(jQuery);
