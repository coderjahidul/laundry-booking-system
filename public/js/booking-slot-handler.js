jQuery(document).ready(function($) {
    // Listen for heartbeat response
    $(document).on('heartbeat-tick', function(e, data) {
        if (data.booking_slot_expired) {
            showBookingExpiredPopup();
        }
    });
    
    // Send check with each heartbeat
    $(document).on('heartbeat-send', function(e, data) {
        data['booking_slot_check'] = true;
    });
    
    function showBookingExpiredPopup() {
        // Show the booking expired modal
        $('#booking-expired-modal').modal('show');
    }

});