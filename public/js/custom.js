jQuery(document).ready(function($){
    $('.address-card').on('click', function () {
        // Remove 'selected' class from all address cards
        $('.address-card').removeClass('selected');

        // Add 'selected' class to the clicked address card
        $(this).addClass('selected');

        let postId = $(this).data('post-id');

        $.ajax({
            url: ajax_object.ajaxurl, // Use the localized variable
            type: 'POST',
            data: {
                action: 'update_selected_address',
                post_id: postId,
                selected_value: 'selected'
            },
            success: function (response) {
                if (response.success) {
                    console.log('Address selected successfully.');
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
