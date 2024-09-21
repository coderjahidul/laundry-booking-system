
jQuery(document).ready(function($){
    // Toggle the address options
    $(".change-address").click(function(e) {
        e.preventDefault(); // Prevent the default anchor behavior
        $(".address-options").slideToggle(); // Toggle the address options
    });

    // Select an address
    $('.select-address').on('click', function () {
        // Remove 'selected' class from all address cards
        $('.select-address').removeClass('selected');

        // Add 'selected' class to the clicked address card
        $(this).addClass('selected');

        let postId = $(this).data('post-id');

        console.log('Selected Post ID:', postId); // Debugging line

        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            data: {
                action: 'update_selected_address',
                post_id: postId,
            },
            success: function(response) {
                if (response.success) {
                    // let city = response.data.city;
                    // let postcode = response.data.postcode;
                    let selected_address = response.data.selected_address;
                    $('#show-selected-address').html('<span>' + selected_address + '</span>');
                    $('#show-selected-delivery').html(selected_address);
                } else {
                    console.log('Failed to select the address.');
                }
            },
            error: function () {
                console.log('There was an error.');
            }
        });
    });

    // booking slot hour
    $('.booking-slot-hour').on('click', function () {
        // remove class from the previously selected booking slot
        $('.booking-slot-hour').removeClass('selected');
        $('.booking-slot-hour').attr('data-bs-toggle', '').attr('data-bs-target', '');
        $('.reserved-slot').removeClass('d-none');
        // Store the clicked element for later use
        let clickedElement = $(this);

        let loaderWrapper = $( this ).find( '.loader-wrapper');
        let slotPrice = $( this ).find( '.slot-price');
        // add loader class to the loader wrapper
        loaderWrapper.addClass('loader');
        slotPrice.addClass('d-none');


        let bookingsSlotId = $(this).data('bookings-slot-id');
        let bookingsSlotDate = $(this).data('bookings-slot-date');
        let bookingsSlotTime = $(this).data('bookings-slot-time');
        let bookingsSlotPrice = $(this).data('bookings-slot-price');
        let bookingsSlotStatus = $(this).data('bookings-slot-status');

        console.log("Slot ID: " + bookingsSlotId, "Slot Date: " + bookingsSlotDate, "Slot Time: " + bookingsSlotTime, "Slot Price: " + bookingsSlotPrice, "Slot Status: " + bookingsSlotStatus);

        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            data: {
                action: 'update_booking_slot',
                bookings_slot_id: bookingsSlotId,
                bookings_slot_date: bookingsSlotDate,
                bookings_slot_time: bookingsSlotTime,
                bookings_slot_price: bookingsSlotPrice,
                bookings_slot_status: bookingsSlotStatus
            },
            success: function(response){
                if(response.success){
                    let bookings_slot_price = response.data.bookings_slot_price;
                    let bookings_slot_date = response.data.bookings_slot_date;
                    let bookings_slot_time = response.data.bookings_slot_time;
                    let bookings_slot_current_time = response.data.bookings_slot_current_time;
                    // alert("Slot Price: " + bookings_slot_price + "Slot Date: " + bookings_slot_date + "Slot Time: " + bookings_slot_time);
                    // show booking slot date in reserved slot Delevery section
                    $("#show-selected-delivery-time-date").html(bookings_slot_date + " " + bookings_slot_time);
                    // show booking slot date and time in booking slot modal
                    $("#show-selected-bookings-time-date").html(bookings_slot_date + " " + bookings_slot_time);
                    // show booking slot price in reserved slot discription
                    $("#show-selected-delivery-price").html("£" + bookings_slot_price);
                    // show current time in reserved slot header
                    $("#show-selected-delivery-current-time").html(bookings_slot_current_time);
                    // show current time in reserved slot discription
                    $("#show-selected-delivery-current-time-one").html(bookings_slot_current_time);
                    // alert("Booking Slot Current Time: " + bookings_slot_current_time);
                    // Remove class to the success loader
                    loaderWrapper.removeClass('loader');
                    // Remove class to the success booking slot
                    slotPrice.removeClass('d-none');
                    // add class to the success booking slot
                    clickedElement.addClass('selected');
                    // add data-bs-toggle and data-bs-target in slot button
                    clickedElement.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#cancelModal');
                    

                }else{
                    console.log('Failed to select the booking slot.');
                }
            },
            error: function(){
                console.log('There was an error.');
                // Remove class to the error loader
                loaderWrapper.removeClass('loader');
                // Remove class to the error booking slot
                slotPrice.removeClass('d-none');
                // add class to the error booking slot
                clickedElement.addClass('selected');
                clickedElement.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#cancelModal');

            }
        });
        
    });

    // booking slot saver
    $('.booking-slot-saver').on('click', function () {
        // remove class from the previously selected booking slot
        $('.booking-slot-saver').removeClass('selected');
        $('.booking-slot-saver').attr('data-bs-toggle', '').attr('data-bs-target', '');
        $('.reserved-slot').removeClass('d-none');
        // Store the clicked element for later use
        let clickedElement = $(this);

        let loaderWrapper = $( this ).find( '.loader-wrapper');
        let slotPrice = $( this ).find( '.slot-price');
        // add loader class to the loader wrapper
        loaderWrapper.addClass('loader');
        slotPrice.addClass('d-none');


        let bookingsSlotId = $(this).data('bookings-slot-id');
        let bookingsSlotDate = $(this).data('bookings-slot-date');
        let bookingsSlotTime = $(this).data('bookings-slot-time');
        let bookingsSlotPrice = $(this).data('bookings-slot-price');
        let bookingsSlotStatus = $(this).data('bookings-slot-status');

        console.log("Slot ID: " + bookingsSlotId, "Slot Date: " + bookingsSlotDate, "Slot Time: " + bookingsSlotTime, "Slot Price: " + bookingsSlotPrice, "Slot Status: " + bookingsSlotStatus);

        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            data: {
                action: 'update_booking_slot',
                bookings_slot_id: bookingsSlotId,
                bookings_slot_date: bookingsSlotDate,
                bookings_slot_time: bookingsSlotTime,
                bookings_slot_price: bookingsSlotPrice,
                bookings_slot_status: bookingsSlotStatus
            },
            success: function(response){
                if(response.success){
                    let bookings_slot_price = response.data.bookings_slot_price;
                    let bookings_slot_date = response.data.bookings_slot_date;
                    let bookings_slot_time = response.data.bookings_slot_time;
                    let bookings_slot_current_time = response.data.bookings_slot_current_time;
                    // alert("Slot Price: " + bookings_slot_price + "Slot Date: " + bookings_slot_date + "Slot Time: " + bookings_slot_time);
                    // show booking slot date in reserved slot Delevery section
                    $("#show-selected-delivery-time-date").html(bookings_slot_date + " " + bookings_slot_time);
                    // show booking slot date and time in booking slot modal
                    $("#show-selected-bookings-time-date").html(bookings_slot_date + " " + bookings_slot_time);
                    // show booking slot price in reserved slot discription
                    $("#show-selected-delivery-price").html("£" + bookings_slot_price);
                    // show current time in reserved slot header
                    $("#show-selected-delivery-current-time").html(bookings_slot_current_time);
                    // show current time in reserved slot discription
                    $("#show-selected-delivery-current-time-one").html(bookings_slot_current_time);
                    // alert("Booking Slot Current Time: " + bookings_slot_current_time);
                    // Remove class to the success loader
                    loaderWrapper.removeClass('loader');
                    // Remove class to the success booking slot
                    slotPrice.removeClass('d-none');
                    // add class to the success booking slot
                    clickedElement.addClass('selected');
                    // add data-bs-toggle and data-bs-target in slot button
                    clickedElement.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#cancelModalSaver');
                    

                }else{
                    console.log('Failed to select the booking slot.');
                }
            },
            error: function(){
                console.log('There was an error.');
                // Remove class to the error loader
                loaderWrapper.removeClass('loader');
                // Remove class to the error booking slot
                slotPrice.removeClass('d-none');
                // add class to the error booking slot
                clickedElement.addClass('selected');
                clickedElement.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#cancelModalSaver');

            }
        });
        
    });

    // booking slot collection
    $('.booking-slot-collection').on('click', function () {
        // remove class from the previously selected booking slot
        $('.booking-slot-collection').removeClass('selected');
        $('.booking-slot-collection').attr('data-bs-toggle', '').attr('data-bs-target', '');
        $('.reserved-slot').removeClass('d-none');
        // Store the clicked element for later use
        let clickedElement = $(this);

        let loaderWrapper = $( this ).find( '.loader-wrapper');
        let slotPrice = $( this ).find( '.slot-price');
        // add loader class to the loader wrapper
        loaderWrapper.addClass('loader');
        slotPrice.addClass('d-none');


        let bookingsSlotId = $(this).data('bookings-slot-id');
        let bookingsSlotDate = $(this).data('bookings-slot-date');
        let bookingsSlotTime = $(this).data('bookings-slot-time');
        let bookingsSlotPrice = $(this).data('bookings-slot-price');
        let bookingsSlotStatus = $(this).data('bookings-slot-status');

        console.log("Slot ID: " + bookingsSlotId, "Slot Date: " + bookingsSlotDate, "Slot Time: " + bookingsSlotTime, "Slot Price: " + bookingsSlotPrice, "Slot Status: " + bookingsSlotStatus);

        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            data: {
                action: 'update_booking_slot',
                bookings_slot_id: bookingsSlotId,
                bookings_slot_date: bookingsSlotDate,
                bookings_slot_time: bookingsSlotTime,
                bookings_slot_price: bookingsSlotPrice,
                bookings_slot_status: bookingsSlotStatus
            },
            success: function(response){
                if(response.success){
                    let bookings_slot_price = response.data.bookings_slot_price;
                    let bookings_slot_date = response.data.bookings_slot_date;
                    let bookings_slot_time = response.data.bookings_slot_time;
                    let bookings_slot_current_time = response.data.bookings_slot_current_time;
                    // alert("Slot Price: " + bookings_slot_price + "Slot Date: " + bookings_slot_date + "Slot Time: " + bookings_slot_time);
                    // show booking slot date in reserved slot Delevery section
                    $("#show-selected-delivery-time-date").html(bookings_slot_date + " " + bookings_slot_time);
                    // show booking slot date and time in booking slot modal
                    $("#show-selected-bookings-time-date").html(bookings_slot_date + " " + bookings_slot_time);
                    // show booking slot price in reserved slot discription
                    $("#show-selected-delivery-price").html("£" + bookings_slot_price);
                    // show current time in reserved slot header
                    $("#show-selected-delivery-current-time").html(bookings_slot_current_time);
                    // show current time in reserved slot discription
                    $("#show-selected-delivery-current-time-one").html(bookings_slot_current_time);
                    // alert("Booking Slot Current Time: " + bookings_slot_current_time);
                    // Remove class to the success loader
                    loaderWrapper.removeClass('loader');
                    // Remove class to the success booking slot
                    slotPrice.removeClass('d-none');
                    // add class to the success booking slot
                    clickedElement.addClass('selected');
                    // add data-bs-toggle and data-bs-target in slot button
                    clickedElement.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#cancelModalCollection');
                    

                }else{
                    console.log('Failed to select the booking slot.');
                }
            },
            error: function(){
                console.log('There was an error.');
                // Remove class to the error loader
                loaderWrapper.removeClass('loader');
                // Remove class to the error booking slot
                slotPrice.removeClass('d-none');
                // add class to the error booking slot
                clickedElement.addClass('selected');
                clickedElement.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#cancelModalCollection');

            }
        });
        
    });

    // Cancel Booking Slot
    $('.cancel-booking-slot').on('click', function () {
        $('#cancelModal').modal('hide');
        $('#cancelModalSaver').modal('hide');
        $('#cancelModalCollection').modal('hide');
        $('.booking-slot-hour').removeClass('selected');
        $('.booking-slot-saver').removeClass('selected');
        $('.booking-slot-collection').removeClass('selected');
        $('.booking-slot-hour').attr('data-bs-toggle', '').attr('data-bs-target', '');
        $('.booking-slot-saver').attr('data-bs-toggle', '').attr('data-bs-target', '');
        $('.booking-slot-collection').attr('data-bs-toggle', '').attr('data-bs-target', '');
        $('.reserved-slot').addClass('d-none');

        let bookingsSlotId = $(this).data('bookings-slot-id');

        console.log("Slot ID: " + bookingsSlotId);

        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            data: {
                action: 'cancel_booking_slot',
                bookings_slot_id: bookingsSlotId
            },
            success: function(response){
                if(response.success){
                    console.log('Booking slot canceled successfully.');
                }else{
                    console.log('Failed to cancel the booking slot.');
                }
            },
            error: function(){
                console.log('There was an error.');
            }
        })

    });
    
    // Select Store
    $('.select-store').on('click', function () {
        // Remove 'selected' class from all store cards
        $('.select-store').removeClass('selected');

        // Add 'selected' class to the clicked store card
        $(this).addClass('selected');

        let postId = $(this).data('post-id');
        console.log('Selected Post ID:', postId); // Debugging line

        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            data: {
                action: 'update_selected_store',
                post_id: postId,
            },
            success: function(response){
                if(response.success){
                    let storeName = response.data.store_name;
                    let storeAddress = response.data.store_address;
                    let storePostcode = response.data.store_postcode;
                    //console.log('Selected store:', storeName); // Debugging line

                    // Add the store name to the HTML
                    $('#show-collection-address').html(
                        `<div class="header">
                            <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
                            <div class="title">
                                <h3>Collection from</h3>
                            </div>
                        </div>
                        <!-- Selected Address Section -->
                        <div class="address" id="show-selected-store-address">` + response + `</div>`
                    );
                    // Update the store name in the HTML
                    $('#show-selected-store-address').html("Waitrose & Partners" + " " + storeName);
                    $('#collection-title').html("Collection address");
                    $('#show-selected-collection').html("Waitrose & Partners, " + storeName + ", " + storeAddress + ", " + storePostcode);
                }else{
                    console.log('Failed to select the store.');
                }
            },
            error: function(){
                console.log('There was an error.');
            }
        })
    });

    // Address Autocomplete Function
    
    $('#address_autocomplete').on('input', function() {
        let query = $(this).val();
        let $suggestionsList = $('#suggestions');

        if (query.length > 2) {
            $.ajax({
                url: `https://api.radar.io/v1/search/autocomplete`,
                type: 'GET',
                data: { query: query },
                headers: {
                    'Authorization': 'prj_live_sk_827ca591a20f08a8adfbcc4b14880de5dcad2944'
                },
                success: function(response) {
                    let suggestions = response.addresses;
                    $suggestionsList.empty();

                    suggestions.forEach(function(suggestion) {
                        let displayText = suggestion.formattedAddress;
                        if (suggestion.postcode) {
                            displayText += ', ' + suggestion.postcode;
                        }
                        let $div = $('<div>').text(displayText);
                        $div.on('click', function() {
                            $('#address_autocomplete').val(displayText);
                            $suggestionsList.empty();
                        });
                        $suggestionsList.append($div);
                    });
                }
            });
        } else {
            $suggestionsList.empty();
        }
    });

    // Load shipping areas
    $.ajax({
        url: ajax_object.ajaxurl, // WordPress built-in AJAX URL.
        method: 'POST',
        data: {
            action: 'get_shipping_areas',
        },
        success: function(response) {
            if (response.success) {
                var $select = $('#select_area');
                $select.empty(); // Clear existing options.
                
                // Loop through the shipping areas and append them to the select.
                $.each(response.data, function(index, area) {
                    $select.append('<option value="' + area.title + '">' + area.title + '</option>');
                });
            } else {
                alert('Failed to load shipping areas.');
            }
        },
        error: function() {
            alert('AJAX error.');
        }
    });
});



