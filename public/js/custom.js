jQuery(document).ready(function($){
    $('.address-card').on('click', function () {
        // Remove 'selected' class from all address cards
        $('.address-card').removeClass('selected');

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
