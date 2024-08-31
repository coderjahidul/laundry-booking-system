<?php
// Booking Management Page in Admin Dashboard
function booking_admin_menu(){
    add_menu_page(
        'Booking Management', 
        'Booking Management', 
        'manage_options', 
        'booking-management', 
        'booking_admin_page', 
        'dashicons-calendar-alt',
        20
    );
}
add_action('admin_menu', 'booking_admin_menu');

function booking_admin_page() {
    ?>
    <div class="wrap booking-management">
        <h1 class="wp-heading-inline">Booking Management</h1>

        <!-- Filter Form -->
        <form method="post" class="search-form wp-clearfix">
            <p class="search-box">
                <label class="screen-reader-text" for="filter_date">Filter by Date:</label>
                <input type="date" name="filter_date" id="filter_date" class="input-date">
                <label class="screen-reader-text" for="filter_status">Filter by Status:</label>
                <select name="filter_status" id="filter_status">
                    <option value="">All</option>
                    <option value="available">Available</option>
                    <option value="fully_booked">Fully Booked</option>
                    <option value="unavailable">Unavailable</option>
                </select>
                <input type="submit" class="button" value="Filter">
            </p>
        </form>

        <?php
        // Fetch filtered bookings with pagination
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $args = array(
            'post_type' => 'booking',
            'posts_per_page' => 10, // Adjust as needed
            'paged' => $paged,
        );

        // Add meta_query conditions here if required...

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
                echo '<td><a href="' . get_edit_post_link() . '" class="button">Edit</a> <a href="' . get_delete_post_link() . '" class="button button-danger">Delete</a></td>';
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
