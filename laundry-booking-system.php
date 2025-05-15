<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/coderjahidul/
 * @since             1.1.0
 * @package           Laundry_Booking_System
 *
 * @wordpress-plugin
 * Plugin Name:       Laundry Booking System
 * Plugin URI:        https://github.com/coderjahidul/laundry-booking-system
 * Description:       Laundry booking System WordPress plugin
 * Version:           1.1.0
 * Author:            Jahidul Islam Sabuz
 * Author URI:        https://github.com/coderjahidul/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       laundry-booking-system
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LAUNDRY_BOOKING_SYSTEM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-laundry-booking-system-activator.php
 */
function activate_laundry_booking_system() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-laundry-booking-system-activator.php';
	Laundry_Booking_System_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-laundry-booking-system-deactivator.php
 */
function deactivate_laundry_booking_system() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-laundry-booking-system-deactivator.php';
	Laundry_Booking_System_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_laundry_booking_system' );
register_deactivation_hook( __FILE__, 'deactivate_laundry_booking_system' );

function my_plugin_enqueue_assets() {
    // Deregister default WordPress jQuery if you want custom version
    if ( !is_admin() ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', [], '3.5.1', true );
        wp_enqueue_script( 'jquery' );
    }

    // Enqueue FontAwesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', [], '5.15.3' );

    // Enqueue Bootstrap
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css', [], '5.0.1' );
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.1', true );

    // Enqueue jQuery UI Datepicker
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_style( 'jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css', [], '1.14.0' );

    // Enqueue Alpine.js
    wp_enqueue_script( 'alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', [], null, true );

    // Enqueue your public custom CSS
    wp_enqueue_style( 'custom-public-css', plugin_dir_url(__FILE__) . 'public/css/custom.css', [], '1.0.0' );

    // Enqueue your public custom JS
    wp_enqueue_script( 'custom-public-js', plugin_dir_url(__FILE__) . 'public/js/custom.js', array('jquery'), '1.0.0', true );

    // Localize custom JS (for AJAX)
    wp_localize_script( 'custom-public-js', 'ajax_object', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'site_url' => get_site_url(),
    ] );

    // Enqueue custom datepicker enhancements if any
    wp_enqueue_script( 'custom-datepicker-script', plugin_dir_url(__FILE__) . 'public/js/custom-datepicker.js', array('jquery', 'jquery-ui-datepicker'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_assets' );


// Enqueue Custom Admin CSS (for backend)
function my_plugin_enqueue_admin_assets() {
    wp_enqueue_style( 'custom-admin-css', plugin_dir_url(__FILE__) . 'admin/css/laundry-booking-system-admin.css', [], '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'my_plugin_enqueue_admin_assets' );



// Hook to WooCommerce checkout fields to auto-fill billing details
add_action('woocommerce_checkout_fields', 'auto_fill_billing_details');

function auto_fill_billing_details($fields) {
    global $wpdb;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Clear any default WooCommerce billing fields before setting custom values
    $fields['billing']['billing_first_name']['default'] = '';
    $fields['billing']['billing_last_name']['default'] = '';
    $fields['billing']['billing_phone']['default'] = '';
    $fields['billing']['billing_country']['default'] = '';
    $fields['billing']['billing_address_1']['default'] = '';
    $fields['billing']['billing_address_2']['default'] = '';
    $fields['billing']['billing_city']['default'] = '';
    $fields['billing']['billing_postcode']['default'] = '';

    // Check if user is logged in
    if ($user_id) {
        // Get the selected address ID from user meta
        $selected_address_id = get_user_meta($user_id, 'selected_address', true);

        // Fetch the selected address from the custom table
        $table_name = $wpdb->prefix . 'lbs_customar_address';
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d AND id = %d", $user_id, $selected_address_id);
        $get_selected_address = $wpdb->get_row($sql);

        // If the selected address exists, pre-fill the billing fields
        if ($get_selected_address) {
            $fields['billing']['billing_first_name']['default'] = $get_selected_address->first_name;
            $fields['billing']['billing_last_name']['default'] = $get_selected_address->last_name;
            $fields['billing']['billing_phone']['default'] = $get_selected_address->phone;
            $fields['billing']['billing_country']['default'] = $get_selected_address->country;
            $fields['billing']['billing_address_1']['default'] = $get_selected_address->address_1;
            $fields['billing']['billing_address_2']['default'] = $get_selected_address->address_2;
            $fields['billing']['billing_city']['default'] = $get_selected_address->city;
            $fields['billing']['billing_postcode']['default'] = $get_selected_address->postcode;
        }
    }

    return $fields;
}

// Optional: Disable postcode validation if necessary
add_filter('woocommerce_default_address_fields', 'disable_postcode_validation', 10, 1);

function disable_postcode_validation($address_fields) {
    // Remove postcode validation
    $address_fields['postcode']['validate'] = array();

    return $address_fields;
}

// Restrict page to logged in users
function restrict_page_to_logged_in_users() {
    if (!is_user_logged_in() && (is_page('lave-collects') || is_page('you-drop-off') || is_page('lave-return') || is_page('you-collect'))) {
        $redirect_url = site_url('/lave-collects/');
        wp_redirect(add_query_arg('redirect_to', urlencode($redirect_url), site_url('/my-account/')));
        exit;
    }
}
add_action('template_redirect', 'restrict_page_to_logged_in_users');

function custom_login_redirect( $redirect, $user ) {
    // Check if the user is logging in through WooCommerce
    if (isset($_REQUEST['woocommerce-login-nonce'])) {
        // Redirect to custom page
        return site_url('/lave-collects');
    }

    return $redirect;
}
add_filter('woocommerce_login_redirect', 'custom_login_redirect', 10, 2);


// Redirect after login
function redirect_after_login($redirect_to, $request, $user) {
    if (isset($_REQUEST['redirect_to'])) {
        return $_REQUEST['redirect_to'];
    }
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_after_login', 10, 3);

// add to cart redirect not logged in user 
// add_filter( 'woocommerce_add_to_cart_redirect', 'custom_add_to_cart_redirect' );
// function custom_add_to_cart_redirect( $url ) {
//     // if user is not logged in, redirect to login page
//     if (!is_user_logged_in()){
//         $redirect_url = site_url() . '/my-account';
//         return $redirect_url;
//     }else{
//         return $url;
//     }
// }




/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-laundry-booking-system.php';

/**
 * Custom Post Type
 * */

require plugin_dir_path(__FILE__) . 'admin/custom-post-type.php';

/**
 *  Admin Endpoints
 *  */
require plugin_dir_path(__FILE__) . 'admin/endpoints.php';

/**
 * Booking Management Page in Admin Dashboard
 * */

require plugin_dir_path(__FILE__) . 'admin/booking-management-page.php';

/**
 * Delivery vans Management Page in Admin Dashboard
 */

require plugin_dir_path(__FILE__) . 'admin/delivery-vans-management.php';

// Register shortcode function file
require plugin_dir_path(__FILE__) . 'public/loundry-booking-slot-shortcode.php';

require plugin_dir_path(__FILE__) . 'templates/bookslot-delivery.php';

// includes custom functions
require plugin_dir_path(__FILE__) . 'public/lbs-custom-function.php';

// includes handle ajax function
require plugin_dir_path(__FILE__) . 'public/handle_ajax_function.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_laundry_booking_system() {

	$plugin = new Laundry_Booking_System();
	$plugin->run();

}
run_laundry_booking_system();

// Restrict cart and checkout pages to logged in users
// function restrict_cart_checkout_pages() {
//     if (is_user_logged_in()) {
//         return; // Allow access if user is logged in
//     }

//     // Check if the user is trying to access the Cart or Checkout page
//     if (is_cart() || is_checkout()) {
//         wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id'))); 
//         exit;
//     }
// }
// add_action('template_redirect', 'restrict_cart_checkout_pages');

// Restrict cart and checkout pages to logged in users
function restrict_cart_checkout_pages() {
    if (is_user_logged_in()) {
        return; // Allow access if user is logged in
    }

    // Check if the user is trying to access the Cart or Checkout page
    if (is_cart() || is_checkout()) {
        // Redirect to a custom page (e.g., 'lave-collects')
        wp_redirect(home_url('/lave-collects/')); 
        exit;
    }
}
add_action('template_redirect', 'restrict_cart_checkout_pages');

add_action('woocommerce_checkout_process', 'custom_minimum_order_amount_check');
function custom_minimum_order_amount_check() {
    // get the current user
    $user_id = get_current_user_id();
    // set the minimum order amount
    $minimum = 40;
    // get selected address id
    $selected_booking_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
    // get selected return address id
    $selected_return_booking_slot_id = get_user_meta($user_id, 'selected_return_booking_slot', true);


    if (WC()->cart->total < $minimum) {
        wc_add_notice(
            sprintf('Your order total is %s. The minimum order amount is %s. Please add some more products.', 
            wc_price(WC()->cart->total), wc_price($minimum)), 
            'error'
        );
    }elseif(empty($selected_booking_slot_id)){
        wc_add_notice(
            'Please <a href="' . site_url('/lave-collects') . '">select a booking slot</a> before proceeding.',
            'error'
        );        
    }elseif(empty($selected_return_booking_slot_id)){
        wc_add_notice(
            'Please <a href="' . site_url('/lave-return') . '">select a return booking slot</a> before proceeding.', 
            'error'
        );
    }
}

add_action('woocommerce_checkout_order_processed', 'clear_booking_slots_after_checkout', 10, 1);
function clear_booking_slots_after_checkout($order_id) {
    // Get the order
    $order = wc_get_order($order_id);

    // Get user ID
    $user_id = $order->get_user_id();

    // If user is logged in
    if ($user_id) {
        update_user_meta($user_id, 'selected_booking_slot', '');
        update_user_meta($user_id, 'selected_return_booking_slot', '');
    }
}

function clear_after_booking_slot($user_id) {
    // Get the current scheduled time (if exists)
    $timestamp = wp_next_scheduled('clear_user_booking_slots', array($user_id));

    // If scheduled, unschedule it
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'clear_user_booking_slots', array($user_id));
    }

    // Always schedule a new one (in 1 hours from now)
    wp_schedule_single_event(time() + HOUR_IN_SECONDS, 'clear_user_booking_slots', array($user_id));
}


add_action('clear_user_booking_slots', 'clear_user_booking_slots_callback');

function clear_user_booking_slots_callback($user_id) {
    // Get user selected booking slot id
    $selected_booking_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
    $selected_return_booking_slot_id = get_user_meta($user_id, 'selected_return_booking_slot', true);

    // Set both slots to available
    if (!empty($selected_booking_slot_id)) {
        update_post_meta($selected_booking_slot_id, '_booking_status', 'available');
    }

    if (!empty($selected_return_booking_slot_id)) {
        update_post_meta($selected_return_booking_slot_id, '_booking_return_status', 'available');
    }

    // Clear user meta
    delete_user_meta($user_id, 'selected_booking_slot');
    delete_user_meta($user_id, 'selected_return_booking_slot');

    // Store expiration data in user meta
    update_user_meta($user_id, 'booking_slot_expired', time());
}

// Add "Collection Location" tab to My Account menu
add_filter('woocommerce_account_menu_items', 'add_collection_location_link', 40);
function add_collection_location_link($menu_links){
    $menu_links = array_slice($menu_links, 0, 5, true)
        + array('collection-location' => 'Collection Location')
        + array_slice($menu_links, 5, NULL, true);

    return $menu_links;
}

// Register the endpoint
add_action('init', 'register_collection_location_endpoint');
function register_collection_location_endpoint(){
    add_rewrite_endpoint('collection-location', EP_ROOT | EP_PAGES);
}

// Flush rewrite rules after activation
register_activation_hook(__FILE__, 'flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');

add_action('woocommerce_account_collection-location_endpoint', 'collection_location_content');

function collection_location_content() {
    echo '<h3>Collection Location</h3>';
    $user_id = get_current_user_id();
    global $wpdb;
    $table_name = $wpdb->prefix . 'lbs_customar_address';

    // Handle deletion
    if (isset($_GET['action'], $_GET['address_id'], $_GET['_wpnonce']) && $_GET['action'] === 'delete') {
        $address_id = intval($_GET['address_id']);
        if (wp_verify_nonce($_GET['_wpnonce'], 'delete_address_' . $address_id)) {
            $wpdb->delete($table_name, ['id' => $address_id, 'user_id' => $user_id]);
            echo '<div style="color: green;">✅ Address deleted successfully.</div>';
        } else {
            echo '<div style="color: red;">❌ Security check failed. Try again.</div>';
        }
    }

    $addresses = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d ORDER BY id DESC", $user_id)
    );

    if (!empty($addresses)) {
        foreach ($addresses as $address) {
            echo '<div class="my-acc-address-card">';

            if (!empty($address->title) && !empty($address->first_name)) {
                echo '<strong>' . esc_html($address->title . ': ' . $address->first_name . ' ' . $address->last_name) . '</strong><br>';
            }
            if (!empty($address->phone)) {
                echo esc_html($address->phone) . '<br>';
            }
            if (!empty($address->country)) {
                echo esc_html($address->country) . '<br>';
            }
            if (!empty($address->address_or_postcode)) {
                echo esc_html($address->address_or_postcode) . '<br>';
            }
            if (!empty($address->address_1)) {
                echo esc_html($address->address_1) . '<br>';
            }
            if (!empty($address->address_2)) {
                echo esc_html($address->address_2) . '<br>';
            }
            if (!empty($address->address_3)) {
                echo esc_html($address->address_3) . '<br>';
            }
            if (!empty($address->city)) {
                echo esc_html($address->city) . '<br>';
            }
            if (!empty($address->postcode)) {
                echo  esc_html($address->postcode) . '<br>';
            }
            if (!empty($address->created_at)) {
                echo '<small> Created at: ' . esc_html($address->created_at) . '</small><br>';
            }

            $delete_url = wp_nonce_url(
                add_query_arg(['action' => 'delete', 'address_id' => $address->id]),
                'delete_address_' . $address->id
            );

            echo '<a href="' . esc_url($delete_url) . '" onclick="return confirm(\'Are you sure you want to delete this address?\');">Delete</a>';

            echo '</div>';
        }
    } else {
        echo '<p>No delivery addresses found.</p>';
    }
}

// Enqueue scripts
function enqueue_booking_slot_scripts() {
    wp_enqueue_script('booking-slot-handler', plugin_dir_url(__FILE__) . 'public/js/booking-slot-handler.js', array('jquery', 'heartbeat'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_booking_slot_scripts');

function heartbeat_received($response, $data) {
    $user_id = get_current_user_id();
    if ($user_id && isset($data['booking_slot_check'])) {
        $expired_time = get_user_meta($user_id, 'booking_slot_expired', true);
        if ($expired_time) {
            $response['booking_slot_expired'] = true;
            // Clear the flag after sending
            delete_user_meta($user_id, 'booking_slot_expired');
        }
    }
    return $response;
}
add_filter('heartbeat_received', 'heartbeat_received', 10, 2);

add_action('wp_footer', 'add_booking_expired_modal');
function add_booking_expired_modal() {
    if (is_user_logged_in()) { // Only load if user is logged in
        ?>
        <!-- Booking Expired Modal -->
        <div class="modal fade" id="booking-expired-modal" tabindex="-1" aria-labelledby="expiredModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="lead">Sorry, your slot has now expired.</p>
                        <p>You'll need to re-book your slot before you can check out. Your items remain in your cart.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a href="<?php echo esc_url(home_url('/book-a-slot-for-your-dry-cleaning')); ?>" class="btn btn-primary">
                            <i class="bi bi-calendar-plus me-2"></i>
                            Book New Slot
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}