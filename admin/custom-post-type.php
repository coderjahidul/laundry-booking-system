<?php
// Register Custom Post Type
function create_booking_post_type() {
    register_post_type('booking',
        array(
            'labels' => array(
                'name' => __('Hour Bookings'),
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

// Register Custom Post Type
function create_saver_booking_post_type() {
    register_post_type('saver-booking',
        array(
            'labels' => array(
                'name' => __('Saver Bookings'),
                'singular_name' => __('Saver Booking')
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array('title', 'editor', 'custom-fields'),
        )
    );
}
add_action('init', 'create_saver_booking_post_type');

// Register Custom Post Type collection
function create_collection_post_type() {
    register_post_type('collection',
        array(
            'labels' => array(
                'name' => __('Collection Bookings'),
                'singular_name' => __('Collection Booking')
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array('title', 'editor', 'custom-fields'),
        )
    );
}

add_action('init', 'create_collection_post_type');


// add meta box for custom fields in booking post type
function add_booking_meta_boxes(){
    add_meta_box(
        'booking_details_meta_box', // ID
        'Hour Booking Details', // Title
        'display_booking_meta_box', // Callback
        'booking', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'add_booking_meta_boxes');

// add meta box for custom fields in saver booking post type
function add_saver_booking_meta_boxes(){
    add_meta_box(
        'saver_booking_details_meta_box', // ID
        'Saver Booking Details', // Title
        'display_saver_booking_meta_box', // Callback
        'saver-booking', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'add_saver_booking_meta_boxes');

// add meta box for custom fields in collection post type
function add_collection_meta_boxes(){
    add_meta_box(
        'collection_details_meta_box', // ID
        'Collection Details', // Title
        'display_collection_meta_box', // Callback
        'collection', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'add_collection_meta_boxes');

// hour display booking meta box
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
            <option value="9pm - 10pm" <?php selected($time_slot, '9pm - 10pm'); ?>>9pm - 10pm</option>
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

// saver display booking meta box
function display_saver_booking_meta_box($post){
    $date = get_post_meta($post->ID, '_saver_booking_date', true);
    $time_slot = get_post_meta($post->ID, '_saver_booking_time_slot', true);
    $status = get_post_meta($post->ID, '_saver_booking_status', true);
    $price = get_post_meta($post->ID, '_saver_booking_price', true);
    ?>
    <div class="booking-form">
        <!-- Date Field -->
        <label for="saver_booking_date">Date:</label>
        <input type="date" name="saver_booking_date" id="saver_booking_date" value="<?php echo esc_attr($date); ?>">

        <!-- Time Slot Field -->
        <label for="saver_booking_time_slot">Time Slot:</label>
        <select name="saver_booking_time_slot" id="saver_booking_time_slot">
            <option value="8am - 12pm" <?php selected($time_slot, '8am - 12pm'); ?>>8am - 12pm</option>
            <option value="12pm - 4pm" <?php selected($time_slot, '12pm - 4pm'); ?>>12pm - 4pm</option>
            <option value="4pm - 8pm" <?php selected($time_slot, '4pm - 8pm'); ?>>4pm - 8pm</option>
        </select>

        <!-- Status Field -->
        <label for="saver_booking_status">Status:</label>
        <select name="saver_booking_status" id="saver_booking_status">
            <option value="available" <?php selected($status, 'available'); ?>>Available</option>
            <option value="fully_booked" <?php selected($status, 'fully_booked'); ?>>Fully Booked</option>
            <option value="unavailable" <?php selected($status, 'unavailable'); ?>>Unavailable</option>
        </select>

        <!-- Price Field -->
        <label for="saver_booking_price">Price:</label>
        <input type="text" name="saver_booking_price" id="saver_booking_price" placeholder="£" value="<?php echo esc_attr($price); ?>">
    </div>

<?php 
}

// collection display booking meta box
function display_collection_meta_box($post){
    $date = get_post_meta($post->ID, '_collection_booking_date', true);
    $time_slot = get_post_meta($post->ID, '_collection_booking_time_slot', true);
    $status = get_post_meta($post->ID, '_collection_booking_status', true);
    $price = get_post_meta($post->ID, '_collection_booking_price', true);
    ?>
        <div class="booking-form">
            <!-- Date Field -->
            <label for="collection_booking_date">Date:</label>
            <input type="date" name="collection_booking_date" id="collection_booking_date" value="<?php echo esc_attr($date); ?>">

            <!-- Time Slot Field -->
            <label for="collection_booking_time_slot">Time Slot:</label>
            <select name="collection_booking_time_slot" id="collection_booking_time_slot">
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
            </select>

            <!-- Status Field -->
            <label for="collection_booking_status">Status:</label>
            <select name="collection_booking_status" id="collection_booking_status">
                <option value="available" <?php selected($status, 'available'); ?>>Available</option>
                <option value="fully_booked" <?php selected($status, 'fully_booked'); ?>>Fully Booked</option>
                <option value="unavailable" <?php selected($status, 'unavailable'); ?>>Unavailable</option>
            </select>

            <!-- Price Field -->
            <label for="collection_booking_price">Price:</label>
            <input type="text" name="collection_booking_price" id="collection_booking_price" placeholder="£" value="<?php echo esc_attr($price); ?>">
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

// saver save booking meta box
function save_saver_booking_meta_box_data($post_id) {
    // Verify this is not an auto-save routine.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check if current user has permission to edit post.
    if (!current_user_can('edit_post', $post_id)) return;

    // Save the meta box data as post meta
    if (isset($_POST['saver_booking_date'])) {
        update_post_meta($post_id, '_saver_booking_date', sanitize_text_field($_POST['saver_booking_date']));
    }
    if (isset($_POST['saver_booking_time_slot'])) {
        update_post_meta($post_id, '_saver_booking_time_slot', sanitize_text_field($_POST['saver_booking_time_slot']));
    }
    if (isset($_POST['saver_booking_status'])) {
        update_post_meta($post_id, '_saver_booking_status', sanitize_text_field($_POST['saver_booking_status']));
    }
    if (isset($_POST['saver_booking_price'])) {
        update_post_meta($post_id, '_saver_booking_price', sanitize_text_field($_POST['saver_booking_price']));
    }
}
add_action('save_post', 'save_saver_booking_meta_box_data');

// collection save booking meta box
function save_collection_booking_meta_box_data($post_id) {
    // Verify this is not an auto-save routine.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check if current user has permission to edit post.
    if (!current_user_can('edit_post', $post_id)) return;

    // Save the meta box data as post meta
    if (isset($_POST['collection_booking_date'])) {
        update_post_meta($post_id, '_collection_booking_date', sanitize_text_field($_POST['collection_booking_date']));
    }
    if (isset($_POST['collection_booking_time_slot'])) {
        update_post_meta($post_id, '_collection_booking_time_slot', sanitize_text_field($_POST['collection_booking_time_slot']));
    }
    if (isset($_POST['collection_booking_status'])) {
        update_post_meta($post_id, '_collection_booking_status', sanitize_text_field($_POST['collection_booking_status']));
    }
    if (isset($_POST['collection_booking_price'])) {
        update_post_meta($post_id, '_collection_booking_price', sanitize_text_field($_POST['collection_booking_price']));
    }
}
add_action('save_post', 'save_collection_booking_meta_box_data');


// Register Custom Post Type store
function create_store_post_type() {
    register_post_type('store',
        array(
            'labels' => array(
                'name' => __('Stores'),
                'singular_name' => __('Store'),
                'add_new_item' => __('Add New Store'),
                'edit_item' => __('Edit Store'),
                'view_item' => __('View Store'),
                'all_items' => __('All Stores'),
                'search_items' => __('Search Stores'),
                'not_found' => __('No stores found'),
                'not_found_in_trash' => __('No stores found in trash'),
                'menu_name' => __('Stores'),
                'name_admin_bar' => __('Store'),
                'archives' => __('Store Archives'),
                'attributes' => __('Store Attributes'),
                'view_item' => __('View Store'),
                'uploaded_to_this_item' => __('Uploaded to this store'),
                'filter_items_list' => __('Filter stores list'),
                'items_list_navigation' => __('Stores list navigation'),
                'items_list' => __('Stores list'),
                'item_published' => __('Store published')
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-location',
            'supports' => array('title'),
        )
    );
}
add_action('init', 'create_store_post_type');
    
// add meta box for custom fields in store post type
function add_store_meta_boxes() {
    add_meta_box(
        'store_details_meta_box', // ID
        'Add Store Details', // Title
        'display_store_meta_box', // Callback
        'store', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'add_store_meta_boxes');


// display meta box for custom fields in store post type
function display_store_meta_box($post) {
    $store_name = get_post_meta($post->ID, '_store_name', true);
    $store_address = get_post_meta($post->ID, '_store_address', true);
    $store_postcode = get_post_meta($post->ID, '_store_postcode', true);
    $store_phone = get_post_meta($post->ID, '_store_phone', true);
    $store_email = get_post_meta($post->ID, '_store_email', true);
    $store_distance = get_post_meta($post->ID, '_store_distance', true);
    $store_description = get_post_meta($post->ID, '_store_description', true);
    ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="store_name">Store Name</label></th>
                <td><input type="text" id="store_name" name="store_name" placeholder="Enter Your Store Name" value="<?php echo esc_attr($store_name); ?>" /></td>
            </tr>
            <tr>
                <th><label for="store_address">Store Address</label></th>
                <td><input type="text" id="store_address" name="store_address" placeholder="Enter Your Store Address" value="<?php echo esc_attr($store_address); ?>" /></td>
            </tr>
            <tr>
                <th><label for="store_postcode">Store Postcode</label></th>
                <td><input type="text" id="store_postcode" name="store_postcode" placeholder="Enter Your Store Postcode" value="<?php echo esc_attr($store_postcode); ?>" /></td>
            </tr>
            <tr>
                <th><label for="store_phone">Store Phone</label></th>
                <td><input type="text" id="store_phone" name="store_phone" placeholder="Enter Your Store Phone" value="<?php echo esc_attr($store_phone); ?>" /></td>
            </tr>
            <tr>
                <th><label for="store_email">Store Email</label></th>
                <td><input type="text" id="store_email" name="store_email" placeholder="Enter Your Store Email" value="<?php echo esc_attr($store_email); ?>" /></td>
            </tr>
            <tr>
                <th><label for="store_distance">Store Distance</label></th>
                <td><input type="text" id="store_distance" name="store_distance" placeholder="Enter Your Store Distance" value="<?php echo esc_attr($store_distance); ?>" /></td>
            </tr>
            <tr>
                <th><label for="store_description">Store Description</label></th>
                <td><textarea id="store_description" name="store_description" rows="5" cols="50"><?php echo esc_attr($store_description); ?></textarea></td>
            </tr>
        </tbody>
    </table>

    <?php
}

// save meta box for custom fields in store post type
function save_store_meta_box_data($post_id) {
    // Verify this is not an auto-save routine.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check if current user has permission to edit post.
    if (!current_user_can('edit_post', $post_id)) return;

    // Save the meta box data as post meta
    if (isset($_POST['store_name'])) {
        update_post_meta($post_id, '_store_name', sanitize_text_field($_POST['store_name']));
    }
    
    if (isset($_POST['store_address'])) {
        update_post_meta($post_id, '_store_address', sanitize_text_field($_POST['store_address']));
    }

    if (isset($_POST['store_postcode'])) {
        update_post_meta($post_id, '_store_postcode', sanitize_text_field($_POST['store_postcode']));
    }

    if (isset($_POST['store_phone'])) {
        update_post_meta($post_id, '_store_phone', sanitize_text_field($_POST['store_phone']));
    }

    if (isset($_POST['store_email'])) {
        update_post_meta($post_id, '_store_email', sanitize_text_field($_POST['store_email']));
    }

    if (isset($_POST['store_distance'])) {
        update_post_meta($post_id, '_store_distance', sanitize_text_field($_POST['store_distance']));
    }

    if (isset($_POST['store_description'])) {
        update_post_meta($post_id, '_store_description', sanitize_text_field($_POST['store_description']));
    }

}

add_action('save_post', 'save_store_meta_box_data');

