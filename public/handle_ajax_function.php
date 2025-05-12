<?php
/**
 * Handle AJAX function
 */

// Update selected address
function update_selected_address() {
    if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $user_id = get_current_user_id();

        // Update the selected_address post meta value
        update_user_meta($user_id, 'selected_address', $post_id);

        global $wpdb;
        $table_name = $wpdb->prefix . 'lbs_customar_address';
        $sql = "SELECT id, address_or_postcode, city, postcode FROM $table_name WHERE user_id = $user_id";
        $get_selected_address = $wpdb->get_results($sql);
        $selected_address_id = get_user_meta($user_id, 'selected_address', true);
        foreach($get_selected_address as $address){
            $address_or_postcode = $address->address_or_postcode;
            $city = $address->city;
            $postcode = $address->postcode;
            if($address->id == $selected_address_id && !empty($address_or_postcode)){
                $selected_address = $address_or_postcode;
                // wp_send_json_success(array('address_or_postcode' => $address_or_postcode));
                wp_send_json_success(array('selected_address' => $selected_address));
            }elseif($address->id == $selected_address_id && !empty($city) && !empty($postcode)){
                $selected_address = $city . ' - ' . $postcode;
                // wp_send_json_success(array('city' => $city, 'postcode' => $postcode));
                wp_send_json_success(array('selected_address' => $selected_address));
            }

        }

        // Fallback if no match found
        wp_send_json_error(array('message' => 'No matching address found.'));
    } else {
        wp_send_json_error(array('message' => 'Error updating address.'));
    }

    wp_die();
}

add_action('wp_ajax_update_selected_address', 'update_selected_address');
add_action('wp_ajax_nopriv_update_selected_address', 'update_selected_address');

// Update selected return address
function update_selected_return_address() {
    if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $user_id = get_current_user_id();

        // Update the selected_address post meta value
        update_user_meta($user_id, 'selected_return_address', $post_id);

        global $wpdb;
        $table_name = $wpdb->prefix . 'lbs_customar_address';
        $sql = "SELECT id, address_or_postcode, city, postcode FROM $table_name WHERE user_id = $user_id";
        $get_selected_address = $wpdb->get_results($sql);
        $selected_address_id = get_user_meta($user_id, 'selected_return_address', true);
        foreach($get_selected_address as $address){
            $address_or_postcode = $address->address_or_postcode;
            $city = $address->city;
            $postcode = $address->postcode;
            if($address->id == $selected_address_id && !empty($address_or_postcode)){
                $selected_address = $address_or_postcode;
                // wp_send_json_success(array('address_or_postcode' => $address_or_postcode));
                wp_send_json_success(array('selected_return_address' => $selected_address));
            }elseif($address->id == $selected_address_id && !empty($city) && !empty($postcode)){
                $selected_address = $city . ' - ' . $postcode;
                // wp_send_json_success(array('city' => $city, 'postcode' => $postcode));
                wp_send_json_success(array('selected_return_address' => $selected_address));
            }

        }

        // Fallback if no match found
        wp_send_json_error(array('message' => 'No matching address found.'));
    } else {
        wp_send_json_error(array('message' => 'Error updating address.'));
    }

    wp_die();
}

add_action('wp_ajax_update_selected_return_address', 'update_selected_return_address');
add_action('wp_ajax_nopriv_update_selected_return_address', 'update_selected_return_address');

// Update Booking Slot
function update_booking_slot() {
    if(isset($_POST['bookings_slot_id']) && !empty($_POST['bookings_slot_id'])) {
        global $wpdb;
        
        $bookings_slot_id = intval($_POST['bookings_slot_id']);
        $user_id = get_current_user_id();

        // Fetch previous booking slot
        $get_previous_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);

        // Fetch all booking slot IDs
        $hour_booking_post_id = $wpdb->get_col("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_booking_status'");
        $saver_booking_post_id = $wpdb->get_col("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_saver_booking_status'");
        $collection_booking_post_id = $wpdb->get_col("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_collection_booking_status'");

        // If the user has a previous booking, update its status to available
        if (!empty($get_previous_bookings_slot_id)) {
            if (in_array($get_previous_bookings_slot_id, $hour_booking_post_id)) {
                update_post_meta($get_previous_bookings_slot_id, '_booking_status', 'available');
            } elseif (in_array($get_previous_bookings_slot_id, $saver_booking_post_id)) {
                update_post_meta($get_previous_bookings_slot_id, '_saver_booking_status', 'available');
            } elseif (in_array($get_previous_bookings_slot_id, $collection_booking_post_id)) {
                update_post_meta($get_previous_bookings_slot_id, '_collection_booking_status', 'available');
            }
        }

        // Update user's selected booking slot
        update_user_meta($user_id, 'selected_booking_slot', $bookings_slot_id);

        // Sanitize and validate input data
        $bookings_slot_price = isset($_POST['bookings_slot_price']) ? intval($_POST['bookings_slot_price']) : 0;
        $bookings_slot_date = isset($_POST['bookings_slot_date']) ? date("l, j F", strtotime($_POST['bookings_slot_date'])) : '';
        $bookings_slot_time = isset($_POST['bookings_slot_time']) ? sanitize_text_field($_POST['bookings_slot_time']) : '';
        $bookings_slot_status = isset($_POST['bookings_slot_status']) ? sanitize_text_field($_POST['bookings_slot_status']) : '';
        $collection_address = isset($_POST['collection_address']) ? sanitize_text_field($_POST['collection_address']) : '';

        // Update booking slot status
        if (in_array($bookings_slot_id, $hour_booking_post_id)) {
            update_post_meta($bookings_slot_id, '_booking_status', 'fully_booked');
        } elseif (in_array($bookings_slot_id, $saver_booking_post_id)) {
            update_post_meta($bookings_slot_id, '_saver_booking_status', 'fully_booked');
        } elseif (in_array($bookings_slot_id, $collection_booking_post_id)) {
            update_post_meta($bookings_slot_id, '_collection_booking_status', 'fully_booked');
        }

        // Get the WordPress time format
        $time_format = get_option('time_format');

        // Get current WordPress-local time and add 1 hour
        $local_time = current_time('timestamp') + HOUR_IN_SECONDS;

        // Format it according to the time format and localization
        $bookings_slot_current_time = date_i18n($time_format, $local_time);

        // Update booking slot current time
        update_user_meta($user_id, 'booking_slot_current_time', $bookings_slot_current_time);

        // clear booking slots after 2 hours
        clear_after_booking_slot($user_id);

        // Return success response
        wp_send_json_success(array(
            "bookings_slot_price" => $bookings_slot_price, 
            "bookings_slot_date" => $bookings_slot_date, 
            "bookings_slot_time" => $bookings_slot_time, 
            "bookings_slot_current_time" => $bookings_slot_current_time, 
            "collection_address" => $collection_address
        ));
    } else {
        wp_send_json_error(array('message' => 'Error updating booking slot.'));
    }
}
add_action('wp_ajax_update_booking_slot', 'update_booking_slot');
add_action('wp_ajax_nopriv_update_booking_slot', 'update_booking_slot');


// update return booking slot
function update_return_booking_slot(){
    if(isset($_POST['bookings_slot_id']) && !empty($_POST['bookings_slot_id'])) {
        global $wpdb;

        $bookings_slot_id = intval($_POST['bookings_slot_id']);
        $user_id = get_current_user_id();
        // Fetch previous return booking slot
        $get_previous_bookings_slot_id = get_user_meta($user_id, 'selected_return_booking_slot', true);

        // Fetch all booking slot IDs
        $hour_booking_post_id = $wpdb->get_col("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_booking_return_status'");
        $saver_booking_post_id = $wpdb->get_col("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_saver_booking_return_status'");
        $collection_booking_post_id = $wpdb->get_col("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_collection_booking_return_status'");

        // if previous booking slot id is not empty then update previous booking slot status to available
        if (!empty($get_previous_bookings_slot_id) ) {
            if ( in_array( $get_previous_bookings_slot_id, $hour_booking_post_id) ) {
                // Update the booking status meta key for the found post
                update_post_meta($get_previous_bookings_slot_id, '_booking_return_status', 'available');
            }elseif( in_array( $get_previous_bookings_slot_id, $saver_booking_post_id) ) {
                // Update the booking status meta key for the found post
                update_post_meta($get_previous_bookings_slot_id, '_saver_booking_return_status', 'available');
            }elseif( in_array( $get_previous_bookings_slot_id, $collection_booking_post_id) ) {    
                // Update the booking status meta key for the found post
                update_post_meta($get_previous_bookings_slot_id, '_collection_booking_return_status', 'available');
            }
        }

        // Update the new selected_booking_slot_id post meta value
        update_user_meta($user_id, 'selected_return_booking_slot', $bookings_slot_id);


        // Sanitize and validate input data
        $bookings_slot_price = isset($_POST['bookings_slot_price']) ? intval($_POST['bookings_slot_price']) : 0;
        $bookings_slot_date = isset($_POST['bookings_slot_date']) ? date("l, j F", strtotime($_POST['bookings_slot_date'])) : '';
        $bookings_slot_time = isset($_POST['bookings_slot_time']) ? sanitize_text_field($_POST['bookings_slot_time']) : '';
        $bookings_slot_status = isset($_POST['bookings_slot_status']) ? sanitize_text_field($_POST['bookings_slot_status']) : '';
        $return_address = isset($_POST['return_address']) ? sanitize_text_field($_POST['return_address']) : '';

        // Update booking slot status
        if(in_array($bookings_slot_id, $hour_booking_post_id)) {
            update_post_meta($bookings_slot_id, '_booking_return_status', 'fully_booked');
        }elseif(in_array($bookings_slot_id, $saver_booking_post_id)) {
            update_post_meta($bookings_slot_id, '_saver_booking_return_status', 'fully_booked');
        }elseif(in_array($bookings_slot_id, $collection_booking_post_id)) {
            update_post_meta($bookings_slot_id, '_collection_booking_return_status', 'fully_booked');
        }

        // Get the WordPress time format
        $time_format = get_option('time_format');

        // Get current WordPress-local time and add 1 hour
        $local_time = current_time('timestamp') + HOUR_IN_SECONDS;

        // Format it according to the time format and localization
        $bookings_slot_current_time = date_i18n($time_format, $local_time);

        // Update customar shipping address
        // update_billing_address($user_id);

        // Update booking slot current time
        update_user_meta($user_id, 'booking_slot_current_time', $bookings_slot_current_time);

        wp_send_json_success(array(
            "bookings_slot_price" => $bookings_slot_price, 
            "bookings_slot_date" => $bookings_slot_date, 
            "bookings_slot_time" => $bookings_slot_time, 
            "bookings_slot_current_time" => $bookings_slot_current_time, 
            "return_address" => $return_address
        ));
    }else {
        wp_send_json_error(array('message' => 'Error updating booking slot.'));
    }
}
add_action('wp_ajax_update_return_booking_slot', 'update_return_booking_slot');
add_action('wp_ajax_nopriv_update_return_booking_slot', 'update_return_booking_slot');

// cancel booking slot
function cancel_booking_slot() {
    if(isset($_POST['bookings_slot_id']) && !empty($_POST['bookings_slot_id'])) {
        $bookings_slot_id = intval($_POST['bookings_slot_id']);
        $user_id = get_current_user_id();
        // get selected booking slot id
        $selected_booking_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
        
        global $wpdb;

        // Query to get the post IDs for each booking status
        $hour_booking_post_ids = $wpdb->get_col(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_booking_status'"
        );
        $saver_booking_post_ids = $wpdb->get_col(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_saver_booking_status'"
        );
        $collection_booking_post_ids = $wpdb->get_col(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_collection_booking_status'"
        );

        // Update booking slot status to available
        if (in_array($selected_booking_slot_id, $hour_booking_post_ids)) {
            update_post_meta($selected_booking_slot_id, '_booking_status', 'available');
        } elseif (in_array($selected_booking_slot_id, $saver_booking_post_ids)) {
            update_post_meta($selected_booking_slot_id, '_saver_booking_status', 'available');
        } elseif (in_array($selected_booking_slot_id, $collection_booking_post_ids)) {
            update_post_meta($selected_booking_slot_id, '_collection_booking_status', 'available');
        }


        // cancle booking slot select to update selected booking slot to empty
        update_user_meta($user_id, 'selected_booking_slot', '');

        wp_send_json_success("Booking slot canceled successfully.");
    }else {
        wp_send_json_error(array('message' => 'Error updating booking slot.'));
    }
}

add_action('wp_ajax_cancel_booking_slot', 'cancel_booking_slot');
add_action('wp_ajax_nopriv_cancel_booking_slot', 'cancel_booking_slot');

// cancel booking slot
function cancel_return_booking_slot() {
    if(isset($_POST['bookings_slot_id']) && !empty($_POST['bookings_slot_id'])) {
        $bookings_slot_id = intval($_POST['bookings_slot_id']);
        $user_id = get_current_user_id();
        // get selected booking slot id
        $selected_booking_slot_id = get_user_meta($user_id, 'selected_return_booking_slot', true);
        
        global $wpdb;

        // Query to get the post IDs for each booking status
        $hour_booking_post_ids = $wpdb->get_col(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_booking_return_status'"
        );
        $saver_booking_post_ids = $wpdb->get_col(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_saver_booking_return_status'"
        );
        $collection_booking_post_ids = $wpdb->get_col(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_collection_booking_return_status'"
        );

        // Update booking slot status to available
        if (in_array($selected_booking_slot_id, $hour_booking_post_ids)) {
            update_post_meta($selected_booking_slot_id, '_booking_return_status', 'available');
        } elseif (in_array($selected_booking_slot_id, $saver_booking_post_ids)) {
            update_post_meta($selected_booking_slot_id, '_saver_booking_return_status', 'available');
        } elseif (in_array($selected_booking_slot_id, $collection_booking_post_ids)) {
            update_post_meta($selected_booking_slot_id, '_collection_booking_return_status', 'available');
        }


        // cancle booking slot select to update selected booking slot to empty
        update_user_meta($user_id, 'selected_return_booking_slot', '');

        wp_send_json_success("Return Booking slot canceled successfully.");
    }else {
        wp_send_json_error(array('message' => 'Error updating booking slot.'));
    }
}

add_action('wp_ajax_cancel_return_booking_slot', 'cancel_return_booking_slot');
add_action('wp_ajax_nopriv_cancel_return_booking_slot', 'cancel_return_booking_slot');

// Update Selected Store
function update_selected_store() {
    if(isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'selected_store_id', $post_id);

        // get store name from database by post id
        $store_name = get_post_meta($post_id, '_store_name', true);
        $store_address = get_post_meta($post_id, '_store_address', true);
        $store_postcode = get_post_meta($post_id, '_store_postcode', true);
        wp_send_json_success(array('store_name' => $store_name, 'store_name' => $store_name, 'store_address' => $store_address, 'store_postcode' => $store_postcode));
    }else {
        wp_send_json_error(array('message' => 'Error updating selected store.'));
    }
}
add_action('wp_ajax_update_selected_store', 'update_selected_store');
add_action('wp_ajax_nopriv_update_selected_store', 'update_selected_store');

// Add delivery cost in checkout 
add_action( 'woocommerce_cart_calculate_fees', 'add_delivery_cost' );

function add_delivery_cost( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $user_id = get_current_user_id();
    global $wpdb;

    // get post meta table from database postmeta
    $table_name = $wpdb->prefix . 'postmeta';
    $meta_key = '_collection_booking_status';

    // Prepare the SQL query and use placeholders to avoid SQL injection
    $sql = $wpdb->prepare("SELECT post_id FROM $table_name WHERE meta_key = %s", $meta_key);
    $get_collection_slot_ids = $wpdb->get_col($sql); // Fetch post IDs as an array
    
    // Booking Slot
    $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
    if(get_post_meta($user_bookings_slot_id, '_booking_time_slot', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_booking_price', true);
        $delivery_booking_slot_time = get_post_meta($user_bookings_slot_id, '_booking_time_slot', true);
        $delivery_booking_date = get_post_meta($user_bookings_slot_id, '_booking_date', true);
        $delivery_type = "Hour";
    }elseif(get_post_meta($user_bookings_slot_id, '_saver_booking_time_slot', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_saver_booking_price', true);
        $delivery_booking_slot_time = get_post_meta($user_bookings_slot_id, '_saver_booking_time_slot', true);
        $delivery_booking_date = get_post_meta($user_bookings_slot_id, '_saver_booking_date', true);
        $delivery_type = "Saver";
    }elseif(get_post_meta($user_bookings_slot_id, '_collection_booking_time_slot', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_collection_booking_price', true);
        $delivery_booking_slot_time = get_post_meta($user_bookings_slot_id, '_collection_booking_time_slot', true);
        $delivery_booking_date = get_post_meta($user_bookings_slot_id, '_collection_booking_date', true);
        $delivery_type = "Collection";
    }
    
    // Define the delivery cost and set it to 0 initially
    $delivery_cost = isset($booking_slot_price) ? $booking_slot_price : 0;

    // date format to Y-m-d like Monday 23 September
    $delivery_date = date("l, j F", strtotime($delivery_booking_date));

    // Add the delivery cost to the cart
    if(!empty($delivery_booking_slot_time) && !empty($delivery_type)){
        if(in_array($user_bookings_slot_id, $get_collection_slot_ids)){
            // get selected address
            $selected_address = collection_address();
            $received_address = "DATE AND TIME WHEN YOU DROP-OFF (" . $delivery_date . " " . $delivery_booking_slot_time . ") \n ADDRESS WHERE YOU DROP-OFF (" . $selected_address . ")";
            update_user_meta( $user_id, 'product_received_address', $received_address );
            $cart->add_fee( __( $received_address, "woocommerce" ), $delivery_cost );
        }else{
            $selected_address = selected_address();
            $received_address = "DATE AND TIME WHEN LAVE COLLECTS DIRTY LAUNDRY (" . $delivery_date . " " . $delivery_booking_slot_time . ") \n ADDRESS WHERE LAVE COLLECTS FROM (" . $selected_address . ")";
            update_user_meta( $user_id, 'product_received_address', $received_address );
            $cart->add_fee( __( $received_address, "woocommerce" ), $delivery_cost );
        }
        
    }else{
        // If delivery time is not set
    }
    
}

// Add delivery cost in checkout 
add_action( 'woocommerce_cart_calculate_fees', 'add_delivery_return_cost' );

function add_delivery_return_cost( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $user_id = get_current_user_id();
    global $wpdb;

    // get post meta table from database postmeta
    $table_name = $wpdb->prefix . 'postmeta';
    $meta_key = '_collection_booking_return_status';

    // Prepare the SQL query and use placeholders to avoid SQL injection
    $sql = $wpdb->prepare("SELECT post_id FROM $table_name WHERE meta_key = %s", $meta_key);
    $get_collection_return_slot_ids = $wpdb->get_col($sql); // Fetch post IDs as an array
    
    // Booking Slot
    $user_bookings_slot_id = get_user_meta($user_id, 'selected_return_booking_slot', true);
    if(get_post_meta($user_bookings_slot_id, '_booking_return_time_slot', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_booking_return_price', true);
        $delivery_booking_slot_time = get_post_meta($user_bookings_slot_id, '_booking_return_time_slot', true);
        $delivery_booking_date = get_post_meta($user_bookings_slot_id, '_booking_return_date', true);
        $delivery_type = "Hour";
    }elseif(get_post_meta($user_bookings_slot_id, '_saver_booking_return_time_slot', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_saver_booking_return_price', true);
        $delivery_booking_slot_time = get_post_meta($user_bookings_slot_id, '_saver_booking_return_time_slot', true);
        $delivery_booking_date = get_post_meta($user_bookings_slot_id, '_saver_booking_return_date', true);
        $delivery_type = "Saver";
    }elseif(get_post_meta($user_bookings_slot_id, '_collection_booking_return_time_slot', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_collection_booking_return_price', true);
        $delivery_booking_slot_time = get_post_meta($user_bookings_slot_id, '_collection_booking_return_time_slot', true);
        $delivery_booking_date = get_post_meta($user_bookings_slot_id, '_collection_booking_return_date', true);
        $delivery_type = "Collection";
    }
    
    // Define the delivery cost and set it to 0 initially
    $delivery_cost = isset($booking_slot_price) ? $booking_slot_price : 0;

    // date format to Y-m-d like Monday 23 September
    $delivery_date = date("l, j F", strtotime($delivery_booking_date));

    // Add the delivery cost to the cart
    if(!empty($delivery_booking_slot_time) && !empty($delivery_type)){
        if(in_array($user_bookings_slot_id, $get_collection_return_slot_ids)){
            // get selected return address
            $get_selected_return_address = collection_address();
            $return_address = "DATE AND TIME YOU CAN COLLECT CLEANED LAUNDRY (" . $delivery_date . " " . $delivery_booking_slot_time . ") \n ADDRESS WHERE YOU COLLECT CLEANED LAUNDRY (" . $get_selected_return_address . ")";
            update_user_meta( $user_id, 'product_return_address', $return_address );
            $cart->add_fee( __( $return_address, "woocommerce" ), $delivery_cost );

            add_action('woocommerce_cart_totals_after_fees', 'show_delivery_edit_button');
            add_action('woocommerce_review_order_after_order_total', 'show_delivery_edit_button'); // for checkout

            function show_delivery_edit_button() {
                echo '<tr class="edit-delivery-info">
                    <td colspan="2" style="text-align: right;">
                        <a href="' . esc_url(site_url('/you-drop-off')) . '" class="button wc-forward">
                            Edit location
                        </a>
                    </td>
                </tr>';
            }
        }else{
            // get selected return address
            $get_selected_return_address = selected_return_address();
            $return_address = "DATE AND TIME WHEN LAVE RETURNS CLEANED LAUNDRY (" . $delivery_date . " " . $delivery_booking_slot_time . ") \n ADDRESS WHERE LAVE WILL RETURN CLEANED LAUNDRY (" . $get_selected_return_address . ")";
            update_user_meta( $user_id, 'product_return_address', $return_address );
            $cart->add_fee( __( $return_address, "woocommerce" ), $delivery_cost );

            add_action('woocommerce_cart_totals_after_fees', 'show_delivery_edit_button');
            add_action('woocommerce_review_order_after_order_total', 'show_delivery_edit_button'); // for checkout

            function show_delivery_edit_button() {
                echo '<tr class="edit-delivery-info">
                    <td colspan="2" style="text-align: right;">
                        <a href="' . esc_url(site_url('/lave-collects')) . '" class="button wc-forward">
                            Edit Address
                        </a>
                    </td>
                </tr>';
            }
        }
        
    }else{
        // If delivery time is not set
    }
}


// Add custom address after the order total on checkout page
function add_custom_address_after_order_total() {
    $user_id = get_current_user_id();
    $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
    if(get_post_meta($user_bookings_slot_id, '_collection_booking_time_slot', true)){
        $selected_store_id = get_user_meta(get_current_user_id(), 'selected_store_id', true);
        $store_name = get_post_meta($selected_store_id, '_store_name', true);
        $store_address = get_post_meta($selected_store_id, '_store_address', true);
        $store_postcode = get_post_meta($selected_store_id, '_store_postcode', true);

        $collection_store_address= "Waitrose & Partners, " . $store_name . ', ' . $store_address . ', ' . $store_postcode;
        echo '<tr class="store-address">
                <th>' . $collection_store_address . '</th>
            </tr>';
    }
}
add_action( 'woocommerce_review_order_after_order_total', 'add_custom_address_after_order_total' );

// Address Autocomplete API call 
function handle_address_autocomplete() {
    $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
    $secret_key = 'prj_live_sk_827ca591a20f08a8adfbcc4b14880de5dcad2944';
    $response = wp_remote_get("https://api.radar.io/v1/search/autocomplete?query=" . urlencode($query), array('headers' => array('Authorization' => 'Bearer ' . $secret_key)));

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to retrieve suggestions');
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    wp_send_json_success($data['addresses']);
}
add_action('wp_ajax_address_autocomplete', 'handle_address_autocomplete');
add_action('wp_ajax_nopriv_address_autocomplete', 'handle_address_autocomplete');

// Get Shipping Areas ajax call
function get_shipping_areas() {
    // Check if this is an AJAX request.
    if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
        return;
    }

    // Query the 'shipping-area' custom post type.
    $args = array(
        'post_type' => 'shipping-area',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );

    $shipping_areas = new WP_Query($args);

    $areas = array();

    if ($shipping_areas->have_posts()) {
        while ($shipping_areas->have_posts()) {
            $shipping_areas->the_post();
            $areas[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
            );
        }
        wp_reset_postdata();
    }

    // Return the data as JSON.
    wp_send_json_success($areas);
}
add_action('wp_ajax_get_shipping_areas', 'get_shipping_areas');
add_action('wp_ajax_nopriv_get_shipping_areas', 'get_shipping_areas');


function check_return_booking_slot() {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    if (!$user_id) {
        echo "empty";
        wp_die();
    }

    $user_selected_return_booking_slot = get_user_meta($user_id, 'selected_return_booking_slot', true);

    if (empty($user_selected_return_booking_slot)) {
        echo "empty";
    } else {
        echo "not_empty";
    }

    wp_die();
}

add_action('wp_ajax_check_return_booking_slot', 'check_return_booking_slot');
add_action('wp_ajax_nopriv_check_return_booking_slot', 'check_return_booking_slot'); // Allow non-logged-in users if needed


// For email
add_action( 'woocommerce_email_after_order_table', 'add_custom_message_before_billing_address', 15, 4 );
function add_custom_message_before_billing_address( $order, $sent_to_admin, $plain_text, $email ) {
    if ( $email->id === 'customer_processing_order' ) {
        $user_id = get_current_user_id();

        $product_received_address = get_user_meta( $user_id, 'product_received_address', true );
        $product_return_address = get_user_meta( $user_id, 'product_return_address', true );

        echo '<div class="custom-order-note">';
        echo '<hr>';
        echo '<br>';
        echo '<strong>Received Address:</strong><br>' . esc_html( $product_received_address ) . '<br><br>';
        echo '<strong>Return Address:</strong><br>' . esc_html( $product_return_address ) . '<br>';
        echo '<br><hr>';
        echo '</div>';
    }
}

// For order received page
add_action( 'woocommerce_order_details_after_order_table', 'custom_note_before_billing_address', 5 );
function custom_note_before_billing_address( $order ) {
    if ( is_wc_endpoint_url( 'order-received' ) ) {
        $user_id = get_current_user_id();

        $product_received_address = get_user_meta( $user_id, 'product_received_address', true );
        $product_return_address = get_user_meta( $user_id, 'product_return_address', true );

        echo '<div class="custom-order-note">';
        echo '<hr>';
        echo '<br>';
        echo '<strong>Received Address:</strong><br>' . esc_html( $product_received_address ) . '<br><br>';
        echo '<strong>Return Address:</strong><br>' . esc_html( $product_return_address ) . '<br>';
        echo '<br><hr>';
        echo '</div>';
    }
}


function get_booking_datepicker() {
    if (isset($_POST['booking_datepicker'])) {
        // Sanitize the date input
        $booking_datepicker = sanitize_text_field($_POST['booking_datepicker']);
        
        $date = new DateTime($booking_datepicker);
        $date->modify('-1 day'); // Subtract 1 day
        $booking_datepicker = $date->format('Y-m-d');

        // set cookie for 1 minute 
        setcookie('booking_datepicker', $booking_datepicker, time() + 10, '/', '', is_ssl(), true);

        // Send a response back to the client
        wp_send_json_success(array('booking_datepicker' => $booking_datepicker));
    }

    wp_die(); // Required to terminate Ajax
}

add_action('wp_ajax_get_booking_datepicker', 'get_booking_datepicker');
add_action('wp_ajax_nopriv_get_booking_datepicker', 'get_booking_datepicker');

function get_return_datepicker() {
    if (isset($_POST['return_datepicker'])) {
        // Sanitize the date input
        $return_datepicker = sanitize_text_field($_POST['return_datepicker']);
        
        $date = new DateTime($return_datepicker);
        $date->modify('-1 day'); // Subtract 1 day
        $return_datepicker = $date->format('Y-m-d');

        // set cookie for 1 minute 
        setcookie('return_datepicker', $return_datepicker, time() + 10, '/', '', is_ssl(), true);

        // Send a response back to the client
        wp_send_json_success(array('return_datepicker' => $return_datepicker));
    }

    wp_die(); // Required to terminate Ajax
}

add_action('wp_ajax_get_return_datepicker', 'get_return_datepicker');
add_action('wp_ajax_nopriv_get_return_datepicker', 'get_return_datepicker');



// Add this to your theme's functions.php or plugin file
add_action('wp_ajax_check_booking_expired_popup', 'check_booking_expired_popup');
add_action('wp_ajax_nopriv_check_booking_expired_popup', 'check_booking_expired_popup');
function check_booking_expired_popup() {
    $user_id = get_current_user_id();
    $show_popup = get_transient('show_booking_expired_popup_' . $user_id);
    
    if ($show_popup) {
        // Delete the transient so it only shows once
        delete_transient('show_booking_expired_popup_' . $user_id);
        wp_send_json(array('show_popup' => true));
    } else {
        wp_send_json(array('show_popup' => false));
    }
}




// // Update Woocommerce flat rate shipping cost
// add_action('woocommerce_before_calculate_totals', 'custom_update_flat_rate_shipping_cost');

// function custom_update_flat_rate_shipping_cost() {
//     if (is_admin() && !defined('DOING_AJAX')) {
//         return;
//     }

//     // Check if a booking slot price is set in POST data
//     if (isset($_POST['bookings_slot_price'])) {
//         // Get the custom shipping cost from POST data
//         $flat_rate_shipping_cost = intval($_POST['bookings_slot_price']);

//         // Set it in the session to make it persistent
//         WC()->session->set('custom_flat_rate_shipping_cost', $flat_rate_shipping_cost);
//     }
// }

// add_filter('woocommerce_package_rates', 'modify_flat_rate_shipping_cost', 10, 2);

// function modify_flat_rate_shipping_cost($rates, $package) {
//     // Retrieve the custom flat rate shipping cost from the session
//     $flat_rate_shipping_cost = WC()->session->get('custom_flat_rate_shipping_cost');

//     // Loop through available shipping rates
//     foreach ($rates as $rate_key => $rate) {
//         // Check if the rate is a flat rate
//         if ('flat_rate' === $rate->method_id) {
//             // Update the cost of the flat rate
//             $rates[$rate_key]->cost = $flat_rate_shipping_cost;
//         }
//     }

//     return $rates;
// }




