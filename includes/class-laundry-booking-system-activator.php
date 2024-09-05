<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://github.com/coderjahidul/
 * @since      1.0.0
 *
 * @package    Laundry_Booking_System
 * @subpackage Laundry_Booking_System/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Laundry_Booking_System
 * @subpackage Laundry_Booking_System/includes
 * @author     Jahidul islam Sabuz <sobuz0349@gmail.com>
 */
class Laundry_Booking_System_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Create table customar delivery address in database if not exist
		global $wpdb;
		$table_name = $wpdb->prefix . 'lbs_customar_address';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id INT AUTO_INCREMENT PRIMARY KEY,
			user_id INT,
			title VARCHAR(100),
			first_name VARCHAR(100),
			last_name VARCHAR(100),
			phone VARCHAR(20),
			country VARCHAR(100),
			address_or_postcode VARCHAR(100),
			address_1 VARCHAR(255),
			address_2 VARCHAR(255),
			address_3 VARCHAR(255),
			city VARCHAR(100),
			postcode VARCHAR(20),
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		

	}

}


