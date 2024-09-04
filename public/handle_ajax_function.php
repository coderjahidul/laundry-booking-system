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

        // Retrieve user meta for city and postcode
        $shipping_cities = get_user_meta($user_id, 'customar_shipping_city');
        $shipping_postcodes = get_user_meta($user_id, 'customar_shipping_postcode');

        // Check if they are arrays
        if (is_array($shipping_cities) && is_array($shipping_postcodes)) {
            foreach ($shipping_cities as $index => $city) {
                $postcode = isset($shipping_postcodes[$index]) ? $shipping_postcodes[$index] : '';
                if ($post_id == $index + 1) { // Adjusted comparison
                    wp_send_json_success(array('city' => $city, 'postcode' => $postcode));
                }
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

// Update Booking Slot
function update_booking_slot() {
    if(isset($_POST['bookings_slot_id']) && !empty($_POST['bookings_slot_id'])) {
        $bookings_slot_id = intval($_POST['bookings_slot_id']);
        $user_id = get_current_user_id();
        // Update previous booking slot status to available 
        $get_previous_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);

        // if previous booking slot id is not empty then update previous booking slot status to available
        if (!empty($get_previous_bookings_slot_id)) {
            update_post_meta($get_previous_bookings_slot_id, '_booking_status', 'available');
        }

        // Update the new selected_booking_slot_id post meta value
        update_user_meta($user_id, 'selected_booking_slot', $bookings_slot_id);

        $bookings_slot_price = intval($_POST['bookings_slot_price']);
        $bookings_slot_date = date("l, j F", strtotime(isset($_POST['bookings_slot_date']) ? $_POST['bookings_slot_date'] : ''));
        $bookings_slot_time = isset($_POST['bookings_slot_time']) ? $_POST['bookings_slot_time'] : '';
        $bookings_slot_status = intval($_POST['bookings_slot_status']);

        // Update booking slot status
        update_post_meta($bookings_slot_id, '_booking_status', 'fully_booked');

        // Slot Booking Current Time
        $time_format = get_option('time_format');
        $bookings_slot_current_time = date_i18n($time_format);

        // Update booking slot current time
        update_user_meta($user_id, 'booking_slot_current_time', $bookings_slot_current_time);

        wp_send_json_success(array("bookings_slot_price" => $bookings_slot_price, "bookings_slot_date" => $bookings_slot_date, "bookings_slot_time" => $bookings_slot_time, "bookings_slot_current_time" => $bookings_slot_current_time));


    }else {
        wp_send_json_error(array('message' => 'Error updating booking slot.'));
    }
}
add_action('wp_ajax_update_booking_slot', 'update_booking_slot');
add_action('wp_ajax_nopriv_update_booking_slot', 'update_booking_slot');

add_action( 'woocommerce_cart_calculate_fees', 'add_delivery_cost' );

function add_delivery_cost( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $user_id = get_current_user_id();
    $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
    $booking_slot_price = get_post_meta($user_bookings_slot_id, '_booking_price', true);
    // Define the delivery cost and set it to 0 initially
    $delivery_cost = isset($booking_slot_price) ? $booking_slot_price : 0;

    // Add the delivery cost to the cart
    $cart->add_fee( __( 'Delivery', 'woocommerce' ), $delivery_cost );
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




