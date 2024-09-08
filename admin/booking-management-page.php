<?php
// Booking Management Page in Admin Dashboard
function booking_admin_menu(){
    add_menu_page(
        'Hour Booking Management', 
        'Hour Booking Management', 
        'manage_options', 
        'booking-management', 
        'booking_admin_page', 
        'dashicons-calendar-alt',
        20
    );
}
add_action('admin_menu', 'booking_admin_menu');

// Saver Booking Management Menu
function saver_booking_admin_menu() {
    add_menu_page(
        'Saver Booking Management', 
        'Saver Booking Management', 
        'manage_options', 
        'saver-booking-management', 
        'saver_booking_admin_page', // Correct function name
        'dashicons-calendar-alt',
        20
    );
}
add_action('admin_menu', 'saver_booking_admin_menu');

// Booking Management Page
function booking_admin_page() {
    ?>
    <div class="wrap booking-management">
        <h1 class="wp-heading-inline">Hour Booking Management</h1>

        <!-- Filter Form -->
        <form method="post" class="search-form wp-clearfix">
            <p class="search-box">
                <label class="screen-reader-text" for="filter_date">Filter by Date:</label>
                <input type="date" name="filter_date" id="filter_date" class="input-date" value="<?php echo isset($_POST['filter_date']) ? esc_attr($_POST['filter_date']) : ''; ?>">
                <label class="screen-reader-text" for="filter_status">Filter by Status:</label>
                <select name="filter_status" id="filter_status">
                    <option value="">All</option>
                    <option value="available" <?php selected(isset($_POST['filter_status']) ? $_POST['filter_status'] : '', 'available'); ?>>Available</option>
                    <option value="fully_booked" <?php selected(isset($_POST['filter_status']) ? $_POST['filter_status'] : '', 'fully_booked'); ?>>Fully Booked</option>
                    <option value="unavailable" <?php selected(isset($_POST['filter_status']) ? $_POST['filter_status'] : '', 'unavailable'); ?>>Unavailable</option>
                </select>
                <input type="submit" class="button" value="Filter">
            </p>
        </form>

        <?php
        // Fetch filtered bookings with pagination
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $args = array(
            'post_type' => 'booking',
            'posts_per_page' => 20, // Adjust as needed
            'paged' => $paged,
        );

        // Check if filter values are set and add to meta_query
        $meta_query = array();
        
        if (!empty($_POST['filter_date'])) {
            $meta_query[] = array(
                'key' => '_booking_date',
                'value' => sanitize_text_field($_POST['filter_date']),
                'compare' => '=',
            );
        }

        if (!empty($_POST['filter_status'])) {
            $meta_query[] = array(
                'key' => '_booking_status',
                'value' => sanitize_text_field($_POST['filter_status']),
                'compare' => '=',
            );
        }

        // Add meta_query if it's not empty
        if (!empty($meta_query)) {
            $args['meta_query'] = $meta_query;
        }

        $bookings = new WP_Query($args);

        if ($bookings->have_posts()) {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col" class="manage-column column-date">Date</th>';
            echo '<th scope="col" class="manage-column column-time-slot">Time Slot</th>';
            echo '<th scope="col" class="manage-column column-status">Status</th>';
            echo '<th scope="col" class="manage-column column-price">Price</th>';
            echo '<th scope="col" class="manage-column column-actions">Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($bookings->have_posts()) {
                $bookings->the_post();
                $date = get_post_meta(get_the_ID(), '_booking_date', true);
                $time_slot = get_post_meta(get_the_ID(), '_booking_time_slot', true);
                $status = get_post_meta(get_the_ID(), '_booking_status', true);
                $price = get_post_meta(get_the_ID(), '_booking_price', true);

                echo '<tr>';
                echo '<td>' . esc_html($date) . '</td>';
                echo '<td>' . esc_html($time_slot) . '</td>';
                echo '<td>' . esc_html($status) . '</td>';
                echo '<td>£' . esc_html($price) . '</td>';
                echo '<td><a href="' . esc_url(get_edit_post_link()) . '" class="button">Edit</a> <a href="' . esc_url(get_delete_post_link()) . '" class="button button-danger">Delete</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Display pagination
            $total_pages = $bookings->max_num_pages;

            if ($total_pages > 1) {
                $current_page = max(1, $paged);
                echo '<div class="tablenav bottom">';
                echo '<div class="tablenav-pages">';
                echo paginate_links(array(
                    'base' => add_query_arg('paged', '%#%'),
                    'format' => '',
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                    'total' => $total_pages,
                    'current' => $current_page,
                    'class' => 'pagination-links', // Added class for styling
                ));
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No bookings found.</p>';
        }

        wp_reset_postdata();
        ?>
    </div>
    <?php
}

// Saver Booking Management Page
function saver_booking_admin_page() {
    ?>
    <div class="wrap booking-management">
        <h1 class="wp-heading-inline">Saver Booking Management</h1>

        <!-- Filter Form -->
        <form method="post" class="search-form wp-clearfix">
            <p class="search-box">
                <label class="screen-reader-text" for="filter_date">Filter by Date:</label>
                <input type="date" name="filter_date" id="filter_date" class="input-date" value="<?php echo isset($_POST['filter_date']) ? esc_attr($_POST['filter_date']) : ''; ?>">
                <label class="screen-reader-text" for="filter_status">Filter by Status:</label>
                <select name="filter_status" id="filter_status">
                    <option value="">All</option>
                    <option value="available" <?php selected(isset($_POST['filter_status']) ? $_POST['filter_status'] : '', 'available'); ?>>Available</option>
                    <option value="fully_booked" <?php selected(isset($_POST['filter_status']) ? $_POST['filter_status'] : '', 'fully_booked'); ?>>Fully Booked</option>
                    <option value="unavailable" <?php selected(isset($_POST['filter_status']) ? $_POST['filter_status'] : '', 'unavailable'); ?>>Unavailable</option>
                </select>
                <input type="submit" class="button" value="Filter">
            </p>
        </form>

        <?php
        // Fetch filtered bookings with pagination
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $args = array(
            'post_type' => 'saver-booking',
            'posts_per_page' => 20, // Adjust as needed
            'paged' => $paged,
        );

        // Check if filter values are set and add to meta_query
        $meta_query = array();
        
        if (!empty($_POST['filter_date'])) {
            $meta_query[] = array(
                'key' => '_saver_booking_date',
                'value' => sanitize_text_field($_POST['filter_date']),
                'compare' => '=',
            );
        }

        if (!empty($_POST['filter_status'])) {
            $meta_query[] = array(
                'key' => '_saver_booking_status',
                'value' => sanitize_text_field($_POST['filter_status']),
                'compare' => '=',
            );
        }

        // Add meta_query if it's not empty
        if (!empty($meta_query)) {
            $args['meta_query'] = $meta_query;
        }

        $bookings = new WP_Query($args);

        if ($bookings->have_posts()) {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col" class="manage-column column-date">Date</th>';
            echo '<th scope="col" class="manage-column column-time-slot">Time Slot</th>';
            echo '<th scope="col" class="manage-column column-status">Status</th>';
            echo '<th scope="col" class="manage-column column-price">Price</th>';
            echo '<th scope="col" class="manage-column column-actions">Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($bookings->have_posts()) {
                $bookings->the_post();
                $date = get_post_meta(get_the_ID(), '_saver_booking_date', true);
                $time_slot = get_post_meta(get_the_ID(), '_saver_booking_time_slot', true);
                $status = get_post_meta(get_the_ID(), '_saver_booking_status', true);
                $price = get_post_meta(get_the_ID(), '_saver_booking_price', true);

                echo '<tr>';
                echo '<td>' . esc_html($date) . '</td>';
                echo '<td>' . esc_html($time_slot) . '</td>';
                echo '<td>' . esc_html($status) . '</td>';
                echo '<td>£' . esc_html($price) . '</td>';
                echo '<td><a href="' . esc_url(get_edit_post_link()) . '" class="button">Edit</a> <a href="' . esc_url(get_delete_post_link()) . '" class="button button-danger">Delete</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Display pagination
            $total_pages = $bookings->max_num_pages;

            if ($total_pages > 1) {
                $current_page = max(1, $paged);
                echo '<div class="tablenav bottom">';
                echo '<div class="tablenav-pages">';
                echo paginate_links(array(
                    'base' => add_query_arg('paged', '%#%'),
                    'format' => '',
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                    'total' => $total_pages,
                    'current' => $current_page,
                    'class' => 'pagination-links', // Added class for styling
                ));
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No bookings found.</p>';
        }

        wp_reset_postdata();
        ?>
    </div>
    <?php
}