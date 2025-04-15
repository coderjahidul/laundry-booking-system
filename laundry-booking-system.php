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

// Enqueue Font Awesome
function enqueue_font_awesome() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3', 'all' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );

// Enqueue custom CSS
function enqueue_custom_css() {
	wp_enqueue_style( 'custom-css', plugin_dir_url( __FILE__ ) . 'public/css/custom.css', array(), '1.0.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_css' );

// Function to include Bootstrap CSS and JS
function enqueue_bootstrap_assets() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css', array(), '5.0.1', 'all' );
    
    // Enqueue Bootstrap JS (including Popper.js for Bootstrap's JavaScript components)
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.1', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_bootstrap_assets' );



// Function to include Bootstrap and custom JS conditionally
function enqueue_bootstrap_assets_conditionally() {
    // Check if we're on a specific page or single post
    if ( is_page( 'contact' ) || is_single() ) {
        // Deregister the default WordPress jQuery
        wp_deregister_script( 'jquery' );
        
        // Register jQuery from the Google CDN
        wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', false, '3.5.1', true );

        // Enqueue jQuery
        wp_enqueue_script( 'jquery' );

        // Enqueue Bootstrap CSS
        wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css', array(), '5.0.1', 'all' );

        // Enqueue Bootstrap JS
        wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.1', true );

        // // Enqueue custom JS file
        // wp_enqueue_script( 'custom-js', plugin_dir_url( __FILE__ ) . 'public/js/custom.js', array('jquery'), '1.0.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_bootstrap_assets_conditionally' );

// add css laundry-booking-system-admin.css
function enqueue_custom_admin_css() {
    wp_enqueue_style( 'custom-admin-css', plugin_dir_url( __FILE__ ) . 'admin/css/laundry-booking-system-admin.css', array(), '1.0.0', 'all' );
}


function my_plugin_enqueue_scripts() {
    // Enqueue the custom JS file
    wp_enqueue_script(
        'custom-js',
        plugin_dir_url( __FILE__ ) . 'public/js/custom.js',
        array('jquery'), // Dependencies
        '1.0.0',         // Version
        true             // Load in footer
    );

    // Localize the script with AJAX URL
    wp_localize_script('custom-js', 'ajax_object', array(
        'ajaxurl'  => admin_url('admin-ajax.php'),
        'site_url' => get_site_url() // Ensure this is passed
    ));
}
add_action('wp_enqueue_scripts', 'my_plugin_enqueue_scripts');


function my_enqueue_scripts() {
    // Enqueue jQuery UI Datepicker
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css');
    
    // Add custom JavaScript to initialize the datepicker
    wp_add_inline_script('jquery-ui-datepicker', '
        jQuery(document).ready(function($) {
            $("#saver_datepicker").datepicker();
            $("#open-saver_datepicker").click(function() {
                $("#saver_datepicker").datepicker("show");
            });
        });
        jQuery(document).ready(function($) {
            $("#hour_datepicker").datepicker();
            $("#open-hour_datepicker").click(function() {
                $("#hour_datepicker").datepicker("show");
            });
        });
    ');
    // Enqueue Alpine.js
    wp_enqueue_script(
        'alpine-js', 
        'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', 
        [], 
        null, // Set the version to null to avoid appending a version query string
        true // Load script in the footer
    );
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');


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



