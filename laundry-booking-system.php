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
 * @since             1.0.0
 * @package           Laundry_Booking_System
 *
 * @wordpress-plugin
 * Plugin Name:       Laundry Booking System
 * Plugin URI:        https://github.com/coderjahidul/laundry-booking-system
 * Description:       Laundry booking System WordPress plugin
 * Version:           1.0.0
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
    wp_localize_script( 'custom-js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
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
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');


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