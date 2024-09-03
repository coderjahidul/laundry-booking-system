
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
                    let city = response.data.city;
                    let postcode = response.data.postcode;
                    $('#show-selected-address').html('<span>' + city + ' - ' + postcode + '</span>');
                } else {
                    console.log('Failed to select the address.');
                }
            },
            error: function () {
                console.log('There was an error.');
            }
        });
    });
});
