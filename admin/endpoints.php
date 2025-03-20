<?php 
// register endpoint
add_action('rest_api_init', function () {
    // Add hour booking slot
    register_rest_route('booking/v1', '/add-hour-slot', array(
        'methods' => 'POST',
        'callback' => 'add_hour_booking_slot',
        'permission_callback' => '__return_true', // Update this with authentication as needed
    ));

    // Add saver booking slot
    register_rest_route('booking/v1', '/add-saver-slot', array(
        'methods' => 'POST',
        'callback' => 'add_saver_booking_slot',
        'permission_callback' => '__return_true', // Update this with authentication as needed
    ));

    // Add collection booking slot
    register_rest_route('booking/v1', '/add-collection-slot', array(
        'methods' => 'POST',
        'callback' => 'add_collection_booking_slot',
        'permission_callback' => '__return_true', // Update this with authentication as needed
    ));

    // add hour return slot
    register_rest_route('booking/v1', '/add-hour-return-slot', array(
        'methods' => 'POST',
        'callback' => 'add_hour_return_booking_slot',
        'permission_callback' => '__return_true', // Update this with authentication as needed
    ));

    // add saver return slot
    register_rest_route('booking/v1', '/add-saver-return-slot', array(
        'methods' => 'POST',
        'callback' => 'add_saver_return_booking_slot',
        'permission_callback' => '__return_true', // Update this with authentication as needed
    ));

    // add collection return slot    
    register_rest_route('booking/v1', '/add-collection-return-slot', array(
        'methods' => 'POST',
        'callback' => 'add_collection_return_booking_slot',
        'permission_callback' => '__return_true', // Update this with authentication as needed
    ));

    // delete hour booking slot
    register_rest_route('booking/v1', '/delete-hour-slot', array(
        'methods' => 'DELETE',
        'callback' => 'delete_hour_booking_slot',
        'permission_callback' => '__return_true', // Adjust with proper authentication for security
    ));

    // delete saver booking slot
    register_rest_route('booking/v1', '/delete-saver-slot', array(
        'methods' => 'DELETE',
        'callback' => 'delete_saver_booking_slot',
        'permission_callback' => '__return_true', // Adjust with proper authentication for security
    ));

    // delete collection booking slot
    register_rest_route('booking/v1', '/delete-collection-slot', array(
        'methods' => 'DELETE',
        'callback' => 'delete_collection_booking_slot',
        'permission_callback' => '__return_true', // Adjust with proper authentication for security
    ));

    // delete hour return booking slot
    register_rest_route('booking/v1', '/delete-hour-return-slot', array(
        'methods' => 'DELETE',
        'callback' => 'delete_hour_return_booking_slot',
        'permission_callback' => '__return_true', // Adjust with proper authentication for security
    ));

    // delete saver return booking slot
    register_rest_route('booking/v1', '/delete-saver-return-slot', array(
        'methods' => 'DELETE',
        'callback' => 'delete_saver_return_booking_slot',
        'permission_callback' => '__return_true', // Adjust with proper authentication for security
    ));

    // delete collection return booking slot
    register_rest_route('booking/v1', '/delete-collection-return-slot', array(
        'methods' => 'DELETE',
        'callback' => 'delete_collection_return_booking_slot',
        'permission_callback' => '__return_true', // Adjust with proper authentication for security
    ));

});


// Add hour booking slot function
function add_hour_booking_slot() {
    // Define the parameters
    global $wpdb;
    $query = "SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = '_booking_date' ORDER BY `meta_value` DESC LIMIT 1";

    // Execute the query
    $latest_booking_date = $wpdb->get_var($query);
    if(!empty($latest_booking_date)){
        // get latest booking date PLUS 1 day
        $date = date('Y-m-d', strtotime('+1 day', strtotime($latest_booking_date)));
    }else{
        // get current date
        $date = date('Y-m-d');
    }
    $time_slots = array(
        "6am - 7am", 
        "7am - 8am", 
        "8am - 9am", 
        "9am - 10am", 
        "10am - 11am", 
        "11am - 12pm", 
        "12pm - 1pm", 
        "1pm - 2pm", 
        "2pm - 3pm",
        "3pm - 4pm",
        "4pm - 5pm",
        "5pm - 6pm",
        "6pm - 7pm",
        "7pm - 8pm",
        "8pm - 9pm",
        "9pm - 10pm"
    );
    $status = "available";
    $price = 4;

    // Loop through each time slot and create a new post
    foreach ($time_slots as $time_slot) {
        // Create a new post
        $post_id = wp_insert_post(array(
            'post_title'   => "Hour Booking Slot: {$date} on {$time_slot}",
            'post_type'    => 'booking',
            'post_status'  => 'publish',
            'meta_input'   => array(
                '_booking_date'      => $date,
                '_booking_time_slot' => $time_slot,
                '_booking_status'    => $status,
                '_booking_price'     => $price,
            ),
        ));

        // Check if the post was created successfully
        if (is_wp_error($post_id)) {
            return new WP_REST_Response([
                'error'   => 'Failed to create booking slot',
                'message' => $post_id->get_error_message(),
            ], 500);
        }
    }

    // Return success message
    return new WP_REST_Response([
        'success' => true,
        'message' => 'All booking slots created successfully!',
    ], 200);
}

// Add saver booking slot function
function add_saver_booking_slot() {
    // Define the parameters
    global $wpdb;
    $query = "SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = '_saver_booking_date' ORDER BY `meta_value` DESC LIMIT 1";

    // Execute the query
    $latest_booking_date = $wpdb->get_var($query);
    if(!empty($latest_booking_date)){
        // get latest booking date PLUS 1 day
        $date = date('Y-m-d', strtotime('+1 day', strtotime($latest_booking_date)));
    }else{
        // get current date
        $date = date('Y-m-d');
    }
    $time_slots = array(
       "8am - 12pm",
       "12pm - 4pm",
       "4pm - 8pm"
    );
    $status = "available";
    $price = 2;
    // Sort by index (default behavior of foreach)
    // ksort($time_slots);
    // Loop through each time slot and create a new post
    foreach ($time_slots as $time_slot) {
        // Create a new post
        $post_id = wp_insert_post(array(
            'post_title'   => "Saver Booking Slot: {$date} on {$time_slot}",
            'post_type'    => 'saver-booking',
            'post_status'  => 'publish',
            'meta_input'   => array(
                '_saver_booking_date'      => $date,
                '_saver_booking_time_slot' => $time_slot,
                '_saver_booking_status'    => $status,
                '_saver_booking_price'     => $price,
            ),
        ));

        // Check if the post was created successfully
        if (is_wp_error($post_id)) {
            return new WP_REST_Response([
                'error'   => 'Failed to create booking slot',
                'message' => $post_id->get_error_message(),
            ], 500);
        }
    }

    // $total_slots = count($time_slots); // Get total number of time slots

    // for ($i = 0; $i < $total_slots; $i++) {
    //     $time_slot = $time_slots[$i]; // Get time slot at index $i

    //     // Create a new post
    //     $post_id = wp_insert_post(array(
    //         'post_title'   => "Saver Booking Slot: {$date} on {$time_slot}",
    //         'post_type'    => 'saver-booking',
    //         'post_status'  => 'publish',
    //         'meta_input'   => array(
    //             '_saver_booking_index'     => $i, // Store index
    //             '_saver_booking_date'      => $date,
    //             '_saver_booking_time_slot' => $time_slot,
    //             '_saver_booking_status'    => $status,
    //             '_saver_booking_price'     => $price,
    //         ),
    //     ));

    //     // Check if the post was created successfully
    //     if (is_wp_error($post_id)) {
    //         return new WP_REST_Response([
    //             'error'   => 'Failed to create booking slot',
    //             'message' => $post_id->get_error_message(),
    //         ], 500);
    //     }
    // }

    // Return success message
    return new WP_REST_Response([
        'success' => true,
        'message' => 'All saver booking slots created successfully!',
    ], 200);
}

// Add collection booking slot function
function add_collection_booking_slot() {
    // Define the parameters
    global $wpdb;
    $query = "SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = '_collection_booking_date' ORDER BY `meta_value` DESC LIMIT 1";

    // Execute the query
    $latest_booking_date = $wpdb->get_var($query);
    if(!empty($latest_booking_date)){
        // get latest booking date PLUS 1 day
        $date = date('Y-m-d', strtotime('+1 day', strtotime($latest_booking_date)));
    }else{
        // get current date
        $date = date('Y-m-d');
    }
    $time_slots = array(
       "10am - 11am",
       "11am - 12pm",
       "12pm - 1pm",
       "1pm - 2pm",
       "2pm - 3pm",
       "3pm - 4pm",
       "4pm - 5pm",
       "5pm - 6pm",
       "6pm - 7pm",
       "7pm - 8pm"
    );
    $status = "available";
    $price = 0;

    // Loop through each time slot and create a new post
    foreach ($time_slots as $time_slot) {
        // Create a new post
        $post_id = wp_insert_post(array(
            'post_title'   => "Collection Booking Slot: {$date} on {$time_slot}",
            'post_type'    => 'collection',
            'post_status'  => 'publish',
            'meta_input'   => array(
                '_collection_booking_date'      => $date,
                '_collection_booking_time_slot' => $time_slot,
                '_collection_booking_status'    => $status,
                '_collection_booking_price'     => $price,
            ),
        ));

        // Check if the post was created successfully
        if (is_wp_error($post_id)) {
            return new WP_REST_Response([
                'error'   => 'Failed to create booking slot',
                'message' => $post_id->get_error_message(),
            ], 500);
        }
    }

    // Return success message
    return new WP_REST_Response([
        'success' => true,
        'message' => 'All collection booking slots created successfully!',
    ], 200);
}

// add hour return booking slot function
function add_hour_return_booking_slot() {
    // Define the parameters
    global $wpdb;
    $query = "SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = '_booking_return_date' ORDER BY `meta_value` DESC LIMIT 1";

    // Execute the query
    $latest_booking_date = $wpdb->get_var($query);
    if(!empty($latest_booking_date)){
        // get latest booking date PLUS 1 day
        $date = date('Y-m-d', strtotime('+1 day', strtotime($latest_booking_date)));
    }else{
        // get current date
        $date = date('Y-m-d');
    }
    $time_slots = array(
        "6am - 7am", 
        "7am - 8am", 
        "8am - 9am", 
        "9am - 10am", 
        "10am - 11am", 
        "11am - 12pm", 
        "12pm - 1pm", 
        "1pm - 2pm", 
        "2pm - 3pm",
        "3pm - 4pm",
        "4pm - 5pm",
        "5pm - 6pm",
        "6pm - 7pm",
        "7pm - 8pm",
        "8pm - 9pm",
        "9pm - 10pm"
    );
    $status = "available";
    $price = 0;

    // Loop through each time slot and create a new post
    foreach ($time_slots as $time_slot) {
        // Create a new post
        $post_id = wp_insert_post(array(
            'post_title'   => "Hour Return Booking Slot: {$date} on {$time_slot}",
            'post_type'    => 'booking-return',
            'post_status'  => 'publish',
            'meta_input'   => array(
                '_booking_return_date'      => $date,
                '_booking_return_time_slot' => $time_slot,
                '_booking_return_status'    => $status,
                '_booking_return_price'     => $price,
            ),
        ));

        // Check if the post was created successfully
        if (is_wp_error($post_id)) {
            return new WP_REST_Response([
                'error'   => 'Failed to create booking slot',
                'message' => $post_id->get_error_message(),
            ], 500);
        }
    }

    // Return success message
    return new WP_REST_Response([
        'success' => true,
        'message' => 'All hour return booking slots created successfully!',
    ], 200);
}

// add saver return booking slot function
function add_saver_return_booking_slot() {
    // Define the parameters
    global $wpdb;
    $query = "SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = '_saver_booking_return_date' ORDER BY `meta_value` DESC LIMIT 1";

    // Execute the query
    $latest_booking_date = $wpdb->get_var($query);
    if(!empty($latest_booking_date)){
        // get latest booking date PLUS 1 day
        $date = date('Y-m-d', strtotime('+1 day', strtotime($latest_booking_date)));
    }else{
        // get current date
        $date = date('Y-m-d');
    }
    $time_slots = array(
        "8am - 12pm",
        "12pm - 4pm",
        "4pm - 8pm"
    );
    $status = "available";
    $price = 0;

    // Loop through each time slot and create a new post
    foreach ($time_slots as $time_slot) {
        // Create a new post
        $post_id = wp_insert_post(array(
            'post_title'   => "Saver Return Booking Slot: {$date} on {$time_slot}",
            'post_type'    => 'saver-booking-return',
            'post_status'  => 'publish',
            'meta_input'   => array(
                '_saver_booking_return_date'      => $date,
                '_saver_booking_return_time_slot' => $time_slot,
                '_saver_booking_return_status'    => $status,
                '_saver_booking_return_price'     => $price,
            ),
        ));

        // Check if the post was created successfully
        if (is_wp_error($post_id)) {
            return new WP_REST_Response([
                'error'   => 'Failed to create booking slot',
                'message' => $post_id->get_error_message(),
            ], 500);
        }
    }

    // Return success message
    return new WP_REST_Response([
        'success' => true,
        'message' => 'All saver return booking slots created successfully!',
    ], 200);
}

// add collection return booking slot function
function add_collection_return_booking_slot() {
    // Define the parameters
    global $wpdb;
    $query = "SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = '_collection_booking_return_date' ORDER BY `meta_value` DESC LIMIT 1";

    // Execute the query
    $latest_booking_date = $wpdb->get_var($query);
    if(!empty($latest_booking_date)){
        // get latest booking date PLUS 1 day
        $date = date('Y-m-d', strtotime('+1 day', strtotime($latest_booking_date)));
    }else{
        // get current date
        $date = date('Y-m-d');
    }
    $time_slots = array(
        "10am - 11am", 
        "11am - 12pm", 
        "12pm - 1pm",
        "1pm - 2pm",
        "2pm - 3pm",
        "3pm - 4pm",
        "4pm - 5pm",
        "5pm - 6pm",
        "6pm - 7pm",
        "7pm - 8pm"
    );
    $status = "available";
    $price = 0;

    // Loop through each time slot and create a new post
    foreach ($time_slots as $time_slot) {
        // Create a new post
        $post_id = wp_insert_post(array(
            'post_title'   => "Collection Return Booking Slot: {$date} on {$time_slot}",
            'post_type'    => 'collection-return',
            'post_status'  => 'publish',
            'meta_input'   => array(
                '_collection_booking_return_date'      => $date,
                '_collection_booking_return_time_slot' => $time_slot,
                '_collection_booking_return_status'    => $status,
                '_collection_booking_return_price'     => $price,
            ),
        ));

        // Check if the post was created successfully
        if (is_wp_error($post_id)) {
            return new WP_REST_Response([
                'error'   => 'Failed to create booking slot',
                'message' => $post_id->get_error_message(),
            ], 500);
        }
    }

    // Return success message
    return new WP_REST_Response([
        'success' => true,
        'message' => 'All collection return booking slots created successfully!',
    ], 200);
}

// delete hour booking slot
function delete_hour_booking_slot() {
    global $wpdb;

    // Fetch the latest booking date
    $query = $wpdb->prepare("SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s ORDER BY `meta_value` ASC LIMIT 1",'_booking_date'
    );
    $last_slot_date = $wpdb->get_var($query);

    // Check if a booking date is found
    if (empty($last_slot_date)) {
        return new WP_REST_Response(['error' => 'No booking date found'], 404);
    }

    // Find posts with the matching booking date
    $query = $wpdb->prepare("SELECT `post_id` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s AND `meta_value` = %s",'_booking_date', $last_slot_date
    );
    $post_ids = $wpdb->get_col($query);

    // Check if any posts are found
    if (empty($post_ids)) {
        return new WP_REST_Response(['error' => 'No matching posts found'], 404);
    }

    // Delete each post permanently
    foreach ($post_ids as $post_id) {
        wp_delete_post($post_id, true);
    }

    return new WP_REST_Response(['success' => true, 'message' => 'Posts deleted successfully'], 200);
}

// delete saver booking slot
function delete_saver_booking_slot() {
    global $wpdb;

    // Fetch the latest booking date
    $query = $wpdb->prepare("SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s ORDER BY `meta_value` ASC LIMIT 1",'_saver_booking_date'
    );
    $last_slot_date = $wpdb->get_var($query);

    // Check if a booking date is found
    if (empty($last_slot_date)) {
        return new WP_REST_Response(['error' => 'No booking date found'], 404);
    }

    // Find posts with the matching booking date
    $query = $wpdb->prepare("SELECT `post_id` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s AND `meta_value` = %s",'_saver_booking_date', $last_slot_date
    );
    $post_ids = $wpdb->get_col($query);

    // Check if any posts are found
    if (empty($post_ids)) {
        return new WP_REST_Response(['error' => 'No matching posts found'], 404);
    }

    // Delete each post permanently
    foreach ($post_ids as $post_id) {
        wp_delete_post($post_id, true);
    }

    return new WP_REST_Response(['success' => true, 'message' => 'Posts deleted successfully'], 200);
}

// delete collection booking slot
function delete_collection_booking_slot() {
    global $wpdb;

    // Fetch the latest booking date
    $query = $wpdb->prepare("SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s ORDER BY `meta_value` ASC LIMIT 1",'_collection_booking_date'
    );
    $last_slot_date = $wpdb->get_var($query);

    // Check if a booking date is found
    if (empty($last_slot_date)) {
        return new WP_REST_Response(['error' => 'No booking date found'], 404);
    }

    // Find posts with the matching booking date
    $query = $wpdb->prepare("SELECT `post_id` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s AND `meta_value` = %s",'_collection_booking_date', $last_slot_date
    );
    $post_ids = $wpdb->get_col($query);

    // Check if any posts are found
    if (empty($post_ids)) {
        return new WP_REST_Response(['error' => 'No matching posts found'], 404);
    }

    // Delete each post permanently
    foreach ($post_ids as $post_id) {
        wp_delete_post($post_id, true);
    }

    return new WP_REST_Response(['success' => true, 'message' => 'Posts deleted successfully'], 200);
}

// delete return booking slot
function delete_hour_return_booking_slot() {
    global $wpdb;

    // Fetch the latest booking date
    $query = $wpdb->prepare("SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s ORDER BY `meta_value` ASC LIMIT 1",'_booking_return_date'
    );
    $last_slot_date = $wpdb->get_var($query);

    // Check if a booking date is found
    if (empty($last_slot_date)) {
        return new WP_REST_Response(['error' => 'No booking date found'], 404);
    }

    // Find posts with the matching booking date
    $query = $wpdb->prepare("SELECT `post_id` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s AND `meta_value` = %s",'_booking_return_date', $last_slot_date
    );
    $post_ids = $wpdb->get_col($query);

    // Check if any posts are found
    if (empty($post_ids)) {
        return new WP_REST_Response(['error' => 'No matching posts found'], 404);
    }

    // Delete each post permanently
    foreach ($post_ids as $post_id) {
        wp_delete_post($post_id, true);
    }

    return new WP_REST_Response(['success' => true, 'message' => 'Posts deleted successfully'], 200);
}

// delete saver return booking slot
function delete_saver_return_booking_slot() {
    global $wpdb;

    // Fetch the latest booking date
    $query = $wpdb->prepare("SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s ORDER BY `meta_value` ASC LIMIT 1",'_saver_booking_return_date'
    );
    $last_slot_date = $wpdb->get_var($query);

    // Check if a booking date is found
    if (empty($last_slot_date)) {
        return new WP_REST_Response(['error' => 'No booking date found'], 404);
    }

    // Find posts with the matching booking date
    $query = $wpdb->prepare("SELECT `post_id` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s AND `meta_value` = %s",'_saver_booking_return_date', $last_slot_date
    );
    $post_ids = $wpdb->get_col($query);

    // Check if any posts are found
    if (empty($post_ids)) {
        return new WP_REST_Response(['error' => 'No matching posts found'], 404);
    }

    // Delete each post permanently
    foreach ($post_ids as $post_id) {
        wp_delete_post($post_id, true);
    }

    return new WP_REST_Response(['success' => true, 'message' => 'Posts deleted successfully'], 200);
}

// delete collection return booking slot
function delete_collection_return_booking_slot() {
    global $wpdb;

    // Fetch the latest booking date
    $query = $wpdb->prepare("SELECT `meta_value` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s ORDER BY `meta_value` ASC LIMIT 1",'_collection_booking_return_date'
    );
    $last_slot_date = $wpdb->get_var($query);

    // Check if a booking date is found
    if (empty($last_slot_date)) {
        return new WP_REST_Response(['error' => 'No booking date found'], 404);
    }

    // Find posts with the matching booking date
    $query = $wpdb->prepare("SELECT `post_id` FROM `{$wpdb->postmeta}` WHERE `meta_key` = %s AND `meta_value` = %s",'_collection_booking_return_date', $last_slot_date
    );
    $post_ids = $wpdb->get_col($query);

    // Check if any posts are found
    if (empty($post_ids)) {
        return new WP_REST_Response(['error' => 'No matching posts found'], 404);
    }

    // Delete each post permanently
    foreach ($post_ids as $post_id) {
        wp_delete_post($post_id, true);
    }

    return new WP_REST_Response(['success' => true, 'message' => 'Posts deleted successfully'], 200);
}
