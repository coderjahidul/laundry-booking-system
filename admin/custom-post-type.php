<?php
// Register Custom Post Type
function create_booking_post_type() {
    register_post_type('booking',
        array(
            'labels' => array(
                'name' => __('Bookings'),
                'singular_name' => __('Booking')
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array('title', 'editor', 'custom-fields'),
        )
    );
}
add_action('init', 'create_booking_post_type');


// add meta box for custom fields in booking post type
function add_booking_meta_boxes(){
    add_meta_box(
        'booking_details_meta_box', // ID
        'Booking Details', // Title
        'display_booking_meta_box', // Callback
        'booking', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'add_booking_meta_boxes');


// display booking meta box
function display_booking_meta_box($post){
    $date = get_post_meta($post->ID, '_booking_date', true);
    $time_slot = get_post_meta($post->ID, '_booking_time_slot', true);
    $status = get_post_meta($post->ID, '_booking_status', true);
    $price = get_post_meta($post->ID, '_booking_price', true);
    ?>
<div class="booking-form">
    <!-- Date Field -->
    <label for="booking_date">Date:</label>
    <input type="date" name="booking_date" id="booking_date" value="<?php echo esc_attr($date); ?>">

    <!-- Time Slot Field -->
    <label for="booking_time_slot">Time Slot:</label>
    <select name="booking_time_slot" id="booking_time_slot">
        <option value="8am - 9am" <?php selected($time_slot, '8am - 9am'); ?>>8am - 9am</option>
        <option value="9am - 10am" <?php selected($time_slot, '9am - 10am'); ?>>9am - 10am</option>
        <option value="10am - 11am" <?php selected($time_slot, '10am - 11am'); ?>>10am - 11am</option>
        <option value="11am - 12pm" <?php selected($time_slot, '11am - 12pm'); ?>>11am - 12pm</option>
        <option value="12pm - 1pm" <?php selected($time_slot, '12pm - 1pm'); ?>>12pm - 1pm</option>
        <option value="1pm - 2pm" <?php selected($time_slot, '1pm - 2pm'); ?>>1pm - 2pm</option>
        <option value="2pm - 3pm" <?php selected($time_slot, '2pm - 3pm'); ?>>2pm - 3pm</option>
        <option value="3pm - 4pm" <?php selected($time_slot, '3pm - 4pm'); ?>>3pm - 4pm</option>
        <option value="4pm - 5pm" <?php selected($time_slot, '4pm - 5pm'); ?>>4pm - 5pm</option>
        <option value="5pm - 6pm" <?php selected($time_slot, '5pm - 6pm'); ?>>5pm - 6pm</option>
        <option value="6pm - 7pm" <?php selected($time_slot, '6pm - 7pm'); ?>>6pm - 7pm</option>
        <option value="7pm - 8pm" <?php selected($time_slot, '7pm - 8pm'); ?>>7pm - 8pm</option>
        <option value="8pm - 9pm" <?php selected($time_slot, '8pm - 9pm'); ?>>8pm - 9pm</option>
    </select>

    <!-- Status Field -->
    <label for="booking_status">Status:</label>
    <select name="booking_status" id="booking_status">
        <option value="available" <?php selected($status, 'available'); ?>>Available</option>
        <option value="fully_booked" <?php selected($status, 'fully_booked'); ?>>Fully Booked</option>
        <option value="unavailable" <?php selected($status, 'unavailable'); ?>>Unavailable</option>
    </select>

    <!-- Price Field -->
    <label for="booking_price">Price:</label>
    <input type="text" name="booking_price" id="booking_price" placeholder="£" value="<?php echo esc_attr($price); ?>">
</div>

<?php 
}

// save booking meta box
function save_booking_meta_box_data($post_id) {
    // Verify this is not an auto-save routine.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check if current user has permission to edit post.
    if (!current_user_can('edit_post', $post_id)) return;

    // Save the meta box data as post meta
    if (isset($_POST['booking_date'])) {
        update_post_meta($post_id, '_booking_date', sanitize_text_field($_POST['booking_date']));
    }
    if (isset($_POST['booking_time_slot'])) {
        update_post_meta($post_id, '_booking_time_slot', sanitize_text_field($_POST['booking_time_slot']));
    }
    if (isset($_POST['booking_status'])) {
        update_post_meta($post_id, '_booking_status', sanitize_text_field($_POST['booking_status']));
    }
    if (isset($_POST['booking_price'])) {
        update_post_meta($post_id, '_booking_price', sanitize_text_field($_POST['booking_price']));
    }
}
add_action('save_post', 'save_booking_meta_box_data');