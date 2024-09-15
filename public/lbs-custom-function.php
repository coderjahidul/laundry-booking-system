<?php
// lbs-delevery function
function lbs_delevery() {
    $user_id = get_current_user_id();
    // get customar all address city and postcode from table lbs_customar_address
    global $wpdb;
    $table_name = $wpdb->prefix . 'lbs_customar_address';
    $user_id = get_current_user_id();
    $sql = "SELECT id, city, postcode FROM $table_name WHERE user_id = $user_id";
    $get_shipping_address = $wpdb->get_results($sql);
    // check if city and postcode not empty
    $get_shipping_city = isset($get_shipping_address[0]->city) ? $get_shipping_address[0]->city : '';
    $get_shipping_postcode = isset($get_shipping_address[0]->postcode) ? $get_shipping_address[0]->postcode : '';
    
    if($get_shipping_city && $get_shipping_postcode){
        ?>
        <!-- Delivery Section -->
        <div class="delevery-section tab-pane fade show active" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
            <div class="delivery-address">
                <div class="header">
                    <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
                    <div class="title">
                        <h3>Your delivery address</h3>
                    </div>
                </div>
                <!-- Selected Address Section -->
                <div class="address" id="show-selected-address">
                    <?php 
                        selected_address();
                    ?>
                </div>
                <a href="#" class="change-address">Change address <i class="fa fa-angle-down" aria-hidden="true"></i></a>
            </div>

            <!-- Address Options -->
            <div class="address-options" style="display: none;">
                <?php 
                   $selected_address_id = get_user_meta($user_id, 'selected_address', true);
                   foreach ($get_shipping_address as $shipping_address) {
                        $city = $shipping_address->city;
                        $postcode = $shipping_address->postcode;
                        $post_id = $shipping_address->id;
                        if($selected_address_id == $post_id ){
                            ?>
                                <div class="address-card select-address selected" data-post-id="<?= $post_id; ?>">
                                    <span><?= $city; ?></span>
                                    <br>
                                    <span><?= $postcode; ?></span>
                                </div>
                            <?php
                        }else{
                            ?>
                                <div class="address-card select-address" data-post-id="<?= $post_id; ?>">
                                    <span><?= $city; ?></span>
                                    <br>
                                    <span><?= $postcode; ?></span>
                                </div>
                            <?php
                        }
                   }
                ?>
                
                <div class="address-card add-address" data-bs-toggle="modal" data-bs-target="#myModal">
                    <!-- <span onclick="showAddressForm()">+ Add an address</span> -->
                    <span>+ Add an address</span>
                </div>
                <div class="modal fade address-form-modal" id="myModal" tabindex="-1" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo add_address_from();?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }else{
        ?>
        <!-- Delivery Section -->
        <div class="delevery-section tab-pane fade show active" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
            <div class="delivery-address">
                <div class="header">
                    <!-- <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div> -->
                    <div class="title">
                        <h3>Enter your delivery postcode</h3>
                    </div>
                </div>
            </div>
            <div class="address-cards add-address" data-bs-toggle="modal" data-bs-target="#myModal">
                <!-- <span onclick="showAddressForm()">+ Add an address</span> -->
                <span>+ Add an address</span>
            </div>
            <div class="modal fade address-form-modal" id="myModal" tabindex="-1" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo add_address_from();?>
                            </div>

                        </div>
                    </div>
                </div>
        </div>

        <?php
    }
}

// Collection function
function lbs_collection() {
    ?>
<!-- Click & Collect Section -->
<div class="collect-section tab-pane fade show active" id="click-collect" role="tabpanel" aria-labelledby="click-collect-tab">
    <?php 
        $user_id = get_current_user_id();
        $selected_store_id = get_user_meta($user_id, 'selected_store_id', true);

        // if selected store is not set
        if(!$selected_store_id){
            ?>
                <div class="collection-address" id="show-collection-address">
                    <h2 class="text-center mb-4">Choose a store for collection</h2>
                </div>
            <?php
        }else{
            ?>
            <div class="collection-address">
                <div class="header">
                    <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
                    <div class="title">
                        <h3>Collection from</h3>
                    </div>
                </div>
                <!-- Selected Address Section -->
                <div class="address" id="show-selected-store-address">
                    <?php 
                        selected_store_address();
                    ?>
                </div>
            </div>
            <?php
        }
    ?>

    <!-- Search Bar -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Collection from" value="EH21 6UU">
                <button class="btn btn-secondary" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Store Cards -->
    <div class="row">
        <?php 
            $args = array(
                'post_type' => 'store',
                'posts_per_page' => -1,
                'order' => 'ASC',
            );
            $store = new WP_Query($args);
            if($store->have_posts()){
                while($store->have_posts()){
                    $store->the_post();
                    $post_id = get_the_ID();
                    $store_name = get_post_meta($post_id, '_store_name', true);
                    $store_address = get_post_meta($post_id, '_store_address', true);
                    $store_postcode = get_post_meta($post_id, '_store_postcode', true);
                    $store_distance = get_post_meta($post_id, '_store_distance', true);
                    $store_description = get_post_meta($post_id, '_store_description', true);

                    // if selected store id and post id matches then add selected class
                    if($selected_store_id == $post_id){
                        ?>
                            <div class="col-md-3 mb-3 store-list">
                                <div class="card collection-store select-store h-100 selected" data-post-id = <?= $post_id; ?>>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $store_name; ?></h5>
                                        <p class="card-text">
                                            <?php echo $store_address; ?><br>
                                            <?php echo $store_postcode;?><br>
                                            <strong><?php echo $store_distance; ?></strong><br>
                                        </p>
                                        <p class="card-text"><?php echo $store_description; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }else{
                        ?>
                            <div class="col-md-3 mb-3 store-list">
                                <div class="card collection-store select-store h-100" data-post-id = <?= $post_id; ?>>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $store_name; ?></h5>
                                        <p class="card-text">
                                            <?php echo $store_address; ?><br>
                                            <?php echo $store_postcode;?><br>
                                            <strong><?php echo $store_distance; ?></strong><br>
                                        </p>
                                        <p class="card-text"><?php echo $store_description; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                }
            }
        ?>
        
    </div>

    <!-- Accordion for Additional Information -->
    <div class="accordion" id="collectionInfo">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    How car park collection works
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#collectionInfo">
                <div class="accordion-body">
                    On arrival at the store, follow signs to our designated collection bay and call the number
                    printed on the sign. A partner will then bring your shopping out to you.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    How in-store collection works
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#collectionInfo">
                <div class="accordion-body">
                    On arrival at the store, please go to the welcome desk to collect your order and remember to
                    bring ID.
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}

// Choose your slot
function lbs_choose_your_slot() {
    ?>
<div class="choose-your-slot">
    <h2 class="text-center">Choose your slot</h2>

    <ul class="nav nav-tabs justify-content-center border-0" id="ChooseYourSlot" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="hour-tab" data-bs-toggle="tab" data-bs-target="#hour" type="button"
                role="tab" aria-controls="hour" aria-selected="true"><i class="fa fa-clock"></i> 1 Hour</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="saver-tab" data-bs-toggle="tab" data-bs-target="#saver" type="button"
                role="tab" aria-controls="saver" aria-selected="false"><i class="fa fa-dollar"></i> Saver</button>
        </li>
    </ul>

    <div class="tab-content" id="ChooseYourSlotContent">
        <!-- Hour Section -->
        <?php hour_function(); ?>
        <!-- Saver Section -->
        <?php saver_function();?>
    </div>

</div>
<?php
}
// Choose your collection slot
function lbs_choose_your_collection_slot() {
    ?>
<div class="choose-your-slot">
    <h2 class="text-center">Choose your slot</h2>
        <!-- Hour Section -->
        <?php collection_function(); ?>

</div>
<?php
}
// Hour function
function hour_function(){
    ?>
<div class="hour-section tab-pane fade show active" id="hour" role="tabpanel" aria-labelledby="hour-tab">
    <p class="text-center">Perfect if you need delivery within a 1 hour window. On the day, we’ll text you when the
        driver is close.</p>
    <div class="container my-4">
        <div class="d-flex justify-content-between">
            <?php 
                // Get current page, default is 1
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $per_page = 5; // Number of unique dates per page

                $args = array(
                    'post_type' => 'booking',
                    'posts_per_page' => -1, // Get all bookings
                    'meta_key' => '_booking_date',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                );

                $bookings_date = new WP_Query($args);
                $delivery_dates = array(); // Array to store unique booking dates

                if ($bookings_date->have_posts()) {
                    while ($bookings_date->have_posts()) {
                        $bookings_date->the_post();

                        $slot_date = get_post_meta(get_the_ID(), '_booking_date', true);

                        // Add the date if it is unique
                        if (!in_array($slot_date, $delivery_dates)) {
                            $delivery_dates[] = $slot_date;
                        }
                    }
                } else {
                    echo "<p>No bookings found.</p>";
                }

                // Reset post data
                wp_reset_postdata();

                // Pagination logic for the $delivery_dates array
                $total_dates = count($delivery_dates); // Total number of unique dates
                $total_pages = ceil($total_dates / $per_page); // Calculate total number of pages

                // Ensure current page is not beyond total pages
                if ($paged > $total_pages) {
                    $paged = $total_pages;
                }

                // Calculate the start index of the slice based on the current page
                $start_index = ($paged - 1) * $per_page;

                // Slice the array to get the dates for the current page
                $paged_dates = array_slice($delivery_dates, $start_index, $per_page);
                if ($total_pages > 1) {
                    // Previous Button
                    if ($paged > 1) {
                        $prev_page = $paged - 1;
                        echo '<a href="' . esc_url(add_query_arg('paged', $prev_page)) . '" class="btn btn-link">&lt; Previous</a>';
                    } else {
                        echo '<span class="btn btn-link disabled">&lt; Previous</span>';
                    }
                    ?>
                    <input type="text" id="hour_datepicker" style="display:none;">
                    <button class="btn btn-outline-secondary" id="open-hour_datepicker">View calendar</button>
                    <?php
                    // Next Button
                    if ($paged < $total_pages) {
                        $next_page = $paged + 1;
                        echo '<a href="' . esc_url(add_query_arg('paged', $next_page)) . '" class="btn btn-link">Next &gt;</a>';
                    } else {
                        echo '<span class="btn btn-link disabled">Next &gt;</span>';
                    }
                }
            ?>
        </div>

        <div class="row text-center">
            <div class="col-2 schedule-header"></div>
            <?php
                // Display the paginated dates
                foreach ($paged_dates as $date) {
                    echo "<div class='col-2 schedule-header'>" . date("D, j M", strtotime($date)) . "</div>";
                }
            ?>

        </div>

        <div class="row">
            <div class="col-2">
            <?php 
                $args = array(
                    'post_type' => 'booking',
                    'posts_per_page' => -1, // Fetch all posts
                    'meta_key' => '_booking_time_slot',
                    'orderby' => 'meta_value',
                    'order' => 'ASC', // Ascending order for natural time order
                );

                $bookings_time = new WP_Query($args);

                $printed_slots = array(); // Array to keep track of printed slots
                $unique_time_slot_count = 0;  // Counter to limit to 14 unique time slots

                $time_slots = array(); // Array to collect time slots

                if ($bookings_time->have_posts()) {
                    while ($bookings_time->have_posts()) {
                        $bookings_time->the_post();
                        // Get the time slot
                        $time_slot = get_post_meta(get_the_ID(), '_booking_time_slot', true);
                        
                        // Collect time slots in an array
                        $time_slots[] = $time_slot;
                    }

                    // Sort the time slots
                    $time_slots = sortTimeRanges($time_slots);

                    // Print the sorted and unique time slots
                    foreach ($time_slots as $time_slot) {
                        // Check if the time slot is already in the printed array
                        if (!in_array($time_slot, $printed_slots)) {
                            echo "<div class='booking-time-list'>$time_slot</div>";
                            // Add the time slot to the array and increment the counter
                            $printed_slots[] = $time_slot;
                            $unique_time_slot_count++;

                            // Break the loop if 14 unique time slots have been printed
                            if ($unique_time_slot_count >= 14) {
                                break;
                            }
                        }
                    }
                }
                ?>

                

                <!-- Additional fully booked slots can be added here -->
            </div>
            <?php foreach($paged_dates as $delivery_date){?>
            <div class="col-2 slot-with-price">
                <?php 
                    $args = array(
                        'post_type' => 'booking',
                        'posts_per_page' => -1, // Adjust as needed
                        'order' => 'ASC',
                    );

                    $bookings = new WP_Query($args);
                    if($bookings->have_posts()){
                        while($bookings->have_posts()){ 
                            $bookings->the_post();
                            $bookings_slot_id = get_the_ID();
                            $user_id = get_current_user_id();
                            $bookings_slot_date = get_post_meta(get_the_ID(), '_booking_date', true);
                            $bookings_slot_status = get_post_meta(get_the_ID(), '_booking_status', true);
                            $bookings_slot_price = get_post_meta(get_the_ID(), '_booking_price', true);
                            $bookings_slot_time = get_post_meta(get_the_ID(), '_booking_time_slot', true);
                            $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
                            if($delivery_date == $bookings_slot_date){
                                if($bookings_slot_status == 'fully_booked' && $user_bookings_slot_id == $bookings_slot_id && $bookings_slot_price == 0){
                                    ?>
                                        <div class="booking-slot booking-slot-hour available selected" data-bs-toggle="modal" data-bs-target="#cancelModal" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">Free</span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'fully_booked' && $user_bookings_slot_id == $bookings_slot_id){
                                    ?>
                                        <div class="booking-slot booking-slot-hour available selected" data-bs-toggle="modal" data-bs-target="#cancelModal" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">£<?php echo $bookings_slot_price;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'fully_booked'){
                                    ?>
                                        <div class="booking-slot fully-booked" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>">Fully Booked</div>
                                    <?php
                                }elseif($bookings_slot_status == 'unavailable'){
                                    ?>
                                        <div class="booking-slot unavailable" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>">Unavailable</div>
                                    <?php
                                }elseif($bookings_slot_status == 'available' && $bookings_slot_price == 0){
                                    ?>
                                        <div class="booking-slot booking-slot-hour available" @click="open = true" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">Free</span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'available'){
                                    ?>
                                        <div class="booking-slot booking-slot-hour available"  @click="open = true" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">£<?php echo $bookings_slot_price;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }
                            }
                        }
                    }
                ?>
                <!-- Additional fully booked slots can be added here -->
            </div>
            <!-- Modal -->
                <div class="modal slot-modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelModalLabel">Cancel reserved slot</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Are you sure you want to cancel your reserved delivery slot on <strong id="show-selected-bookings-time-date">
                                    <?php
                                    // Booking slot date and time
                                    booking_slot_date_time($user_bookings_slot_id);
                                    ?>
                                </strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary btn-keep" data-bs-dismiss="modal">Keep slot</button>
                                <button type="button" data-bookings-slot-id = "<?= $bookings_slot_id;?>" class="btn btn-cancel cancel-booking-slot">Cancel slot</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?php
}

// saver function
function saver_function(){
    ?>
<div class="saver-section tab-pane fade" id="saver" role="tabpanel" aria-labelledby="saver-tab">
    <p class="text-center">Great value if you can be more flexible. On the day, we’ll text you an estimated 1 hour
        delivery window.</p>
    <div class="container my-4">
        <div class="d-flex justify-content-between">
        <?php 
                // Get current page, default is 1
                $saver_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $saver_per_page = 5; // Number of unique dates per page

                $args = array(
                    'post_type' => 'saver-booking',
                    'posts_per_page' => -1, // Get all bookings
                    'meta_key' => '_saver_booking_date',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                );

                $saver_bookings_date = new WP_Query($args);
                $saver_delivery_dates = array(); // Array to store unique booking dates

                if ($saver_bookings_date->have_posts()) {
                    while ($saver_bookings_date->have_posts()) {
                        $saver_bookings_date->the_post();

                        $saver_slot_date = get_post_meta(get_the_ID(), '_saver_booking_date', true);

                        // Add the date if it is unique
                        if (!in_array($saver_slot_date, $saver_delivery_dates)) {
                            $saver_delivery_dates[] = $saver_slot_date;
                        }
                    }
                } else {
                    echo "<p>No bookings found.</p>";
                }

                // Reset post data
                wp_reset_postdata();

                // Pagination logic for the $delivery_dates array
                $saver_total_dates = count($saver_delivery_dates); // Total number of unique dates
                $saver_total_pages = ceil($saver_total_dates / $saver_per_page); // Calculate total number of pages

                // Ensure current page is not beyond total pages
                if ($saver_paged > $saver_total_pages) {
                    $saver_paged = $saver_total_pages;
                }

                // Calculate the start index of the slice based on the current page
                $saver_start_index = ($saver_paged - 1) * $saver_per_page;

                // Slice the array to get the dates for the current page
                $saver_paged_dates = array_slice($saver_delivery_dates, $saver_start_index, $saver_per_page);
                if ($saver_total_pages > 1) {
                    // Previous Button
                    if ($saver_paged > 1) {
                        $saver_prev_page = $saver_paged - 1;
                        echo '<a href="' . esc_url(add_query_arg('paged', $saver_prev_page)) . '" class="btn btn-link">&lt; Previous</a>';
                    } else {
                        echo '<span class="btn btn-link disabled">&lt; Previous</span>';
                    }
                    ?>
                    <input type="text" id="saver_datepicker" style="display:none;">
                    <button class="btn btn-outline-secondary" id="open-saver_datepicker">View calendar</button>
                    <?php
                    // Next Button
                    if ($saver_paged < $saver_total_pages) {
                        $saver_next_page = $saver_paged + 1;
                        echo '<a href="' . esc_url(add_query_arg('paged', $saver_next_page)) . '" class="btn btn-link">Next &gt;</a>';
                    } else {
                        echo '<span class="btn btn-link disabled">Next &gt;</span>';
                    }
                }
            ?>
        </div>

        <div class="row text-center">
            <div class="col-2 schedule-header"></div>
            <?php
                // Display the paginated dates
                foreach ($saver_paged_dates as $saver_date) {
                    echo "<div class='col-2 schedule-header'>" . date("D, j M", strtotime($saver_date)) . "</div>";
                }
            ?>
        </div>

        <div class="row">
            <div class="col-2">
            <?php 
                $args = array(
                    'post_type' => 'saver-booking',
                    'posts_per_page' => -1, // Fetch all posts
                    'meta_key' => '_saver_booking_time_slot',
                    'orderby' => 'meta_value',
                    'order' => 'ASC', // Ascending order for natural time order
                );

                $saver_bookings_time = new WP_Query($args);

                $saver_printed_slots = array(); // Array to keep track of printed slots
                $saver_unique_time_slot_count = 0;  // Counter to limit to 14 unique time slots

                $saver_time_slots = array(); // Array to collect time slots

                if ($saver_bookings_time->have_posts()) {
                    while ($saver_bookings_time->have_posts()) {
                        $saver_bookings_time->the_post();
                        // Get the time slot
                        $saver_time_slot = get_post_meta(get_the_ID(), '_saver_booking_time_slot', true);
                        
                        // Collect time slots in an array
                        $saver_time_slots[] = $saver_time_slot;
                    }

                    // Sort the time slots
                    $saver_time_slots = sortTimeRanges($saver_time_slots);

                    // Print the sorted and unique time slots
                    foreach ($saver_time_slots as $saver_time_slot) {
                        // Check if the time slot is already in the printed array
                        if (!in_array($saver_time_slot, $saver_printed_slots)) {
                            echo "<div class='booking-time-list'>$saver_time_slot</div>";
                            // Add the time slot to the array and increment the counter
                            $saver_printed_slots[] = $saver_time_slot;
                            $saver_unique_time_slot_count++;

                            // Break the loop if 14 unique time slots have been printed
                            if ($saver_unique_time_slot_count >= 14) {
                                break;
                            }
                        }
                    }
                }
                ?>

                <!-- Additional fully booked slots can be added here -->
            </div>
            <?php foreach($saver_paged_dates as $delivery_date){?>
            <div class="col-2 slot-with-price">
                <?php 
                    $args = array(
                        'post_type' => 'saver-booking',
                        'posts_per_page' => -1, // Adjust as needed
                        'order' => 'ASC',
                    );

                    $bookings = new WP_Query($args);
                    if($bookings->have_posts()){
                        while($bookings->have_posts()){ 
                            $bookings->the_post();
                            $bookings_slot_id = get_the_ID();
                            $user_id = get_current_user_id();
                            $bookings_slot_date = get_post_meta(get_the_ID(), '_saver_booking_date', true);
                            $bookings_slot_status = get_post_meta(get_the_ID(), '_saver_booking_status', true);
                            $bookings_slot_price = get_post_meta(get_the_ID(), '_saver_booking_price', true);
                            $bookings_slot_time = get_post_meta(get_the_ID(), '_saver_booking_time_slot', true);
                            $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
                            if($delivery_date == $bookings_slot_date){
                                if($bookings_slot_status == 'fully_booked' && $user_bookings_slot_id == $bookings_slot_id && $bookings_slot_price == 0){
                                    ?>
                                        <div class="booking-slot booking-slot-saver available selected" data-bs-toggle="modal" data-bs-target="#cancelModalSaver" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">Free <br> <?php echo $bookings_slot_time;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'fully_booked' && $user_bookings_slot_id == $bookings_slot_id){
                                    ?>
                                        <div class="booking-slot booking-slot-saver available selected" data-bs-toggle="modal" data-bs-target="#cancelModalSaver" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">£<?php echo $bookings_slot_price . '<br>' . $bookings_slot_time;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'fully_booked'){
                                    ?>
                                        <div class="booking-slot fully-booked" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>">Fully Booked <br> <?php echo $bookings_slot_time;?></div>
                                    <?php
                                }elseif($bookings_slot_status == 'unavailable'){
                                    ?>
                                        <div class="booking-slot unavailable" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>">Unavailable <br> <?php echo $bookings_slot_time;?></div>
                                    <?php
                                }elseif($bookings_slot_status == 'available' && $bookings_slot_price == 0){
                                    ?>
                                        <div class="booking-slot booking-slot-saver available" @click="open = true" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">Free <br> <?php echo $bookings_slot_time;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'available'){
                                    ?>
                                        <div class="booking-slot booking-slot-saver available"  @click="open = true" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">£<?php echo $bookings_slot_price . '<br>' . $bookings_slot_time;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }
                            }
                        }
                    }
                ?>
                <!-- Additional fully booked slots can be added here -->
            </div>
            <!-- Modal -->
                <div class="modal slot-modal fade" id="cancelModalSaver" tabindex="-1" aria-labelledby="cancelModalSaverLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelModalSaverLabel">Cancel reserved slot</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Are you sure you want to cancel your reserved delivery slot on <strong id="show-selected-bookings-time-date">
                                    <?php
                                    // Booking slot date and time
                                    booking_slot_date_time($user_bookings_slot_id);
                                    ?>
                                </strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary btn-keep" data-bs-dismiss="modal">Keep slot</button>
                                <button type="button" data-bookings-slot-id = "<?= $bookings_slot_id;?>" class="btn btn-cancel cancel-booking-slot">Cancel slot</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
            
        </div>
    </div>
</div>
<?php
}

// Collection function
function collection_function(){
    ?>
<div class="collection-section tab-pane fade show active" id="hour" role="tabpanel" aria-labelledby="hour-tab">
    <div class="container my-4">
        <div class="d-flex justify-content-between">
            <?php 
                // Get current page, default is 1
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $per_page = 5; // Number of unique dates per page

                $args = array(
                    'post_type' => 'collection',
                    'posts_per_page' => -1, // Get all bookings
                    'meta_key' => '_collection_booking_date',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                );

                $bookings_date = new WP_Query($args);
                $delivery_dates = array(); // Array to store unique booking dates

                if ($bookings_date->have_posts()) {
                    while ($bookings_date->have_posts()) {
                        $bookings_date->the_post();

                        $slot_date = get_post_meta(get_the_ID(), '_collection_booking_date', true);

                        // Add the date if it is unique
                        if (!in_array($slot_date, $delivery_dates)) {
                            $delivery_dates[] = $slot_date;
                        }
                    }
                } else {
                    echo "<p>No bookings found.</p>";
                }

                // Reset post data
                wp_reset_postdata();

                // Pagination logic for the $delivery_dates array
                $total_dates = count($delivery_dates); // Total number of unique dates
                $total_pages = ceil($total_dates / $per_page); // Calculate total number of pages

                // Ensure current page is not beyond total pages
                if ($paged > $total_pages) {
                    $paged = $total_pages;
                }

                // Calculate the start index of the slice based on the current page
                $start_index = ($paged - 1) * $per_page;

                // Slice the array to get the dates for the current page
                $paged_dates = array_slice($delivery_dates, $start_index, $per_page);
                if ($total_pages > 1) {
                    // Previous Button
                    if ($paged > 1) {
                        $prev_page = $paged - 1;
                        echo '<a href="' . esc_url(add_query_arg('paged', $prev_page)) . '" class="btn btn-link">&lt; Previous</a>';
                    } else {
                        echo '<span class="btn btn-link disabled">&lt; Previous</span>';
                    }
                    ?>
                    <input type="text" id="hour_datepicker" style="display:none;">
                    <button class="btn btn-outline-secondary" id="open-hour_datepicker">View calendar</button>
                    <?php
                    // Next Button
                    if ($paged < $total_pages) {
                        $next_page = $paged + 1;
                        echo '<a href="' . esc_url(add_query_arg('paged', $next_page)) . '" class="btn btn-link">Next &gt;</a>';
                    } else {
                        echo '<span class="btn btn-link disabled">Next &gt;</span>';
                    }
                }
            ?>
        </div>

        <div class="row text-center">
            <div class="col-2 schedule-header"></div>
            <?php
                // Display the paginated dates
                foreach ($paged_dates as $date) {
                    echo "<div class='col-2 schedule-header'>" . date("D, j M", strtotime($date)) . "</div>";
                }
            ?>

        </div>

        <div class="row">
            <div class="col-2">
            <?php 
                $args = array(
                    'post_type' => 'collection',
                    'posts_per_page' => -1, // Fetch all posts
                    'meta_key' => '_collection_booking_time_slot',
                    'orderby' => 'meta_value',
                    'order' => 'ASC', // Ascending order for natural time order
                );

                $bookings_time = new WP_Query($args);

                $printed_slots = array(); // Array to keep track of printed slots
                $unique_time_slot_count = 0;  // Counter to limit to 14 unique time slots

                $time_slots = array(); // Array to collect time slots

                if ($bookings_time->have_posts()) {
                    while ($bookings_time->have_posts()) {
                        $bookings_time->the_post();
                        // Get the time slot
                        $time_slot = get_post_meta(get_the_ID(), '_collection_booking_time_slot', true);
                        
                        // Collect time slots in an array
                        $time_slots[] = $time_slot;
                    }

                    // Sort the time slots
                    $time_slots = sortTimeRanges($time_slots);

                    // Print the sorted and unique time slots
                    foreach ($time_slots as $time_slot) {
                        // Check if the time slot is already in the printed array
                        if (!in_array($time_slot, $printed_slots)) {
                            echo "<div class='booking-time-list'>$time_slot</div>";
                            // Add the time slot to the array and increment the counter
                            $printed_slots[] = $time_slot;
                            $unique_time_slot_count++;

                            // Break the loop if 14 unique time slots have been printed
                            if ($unique_time_slot_count >= 14) {
                                break;
                            }
                        }
                    }
                }
                ?>

                

                <!-- Additional fully booked slots can be added here -->
            </div>
            <?php foreach($paged_dates as $delivery_date){?>
            <div class="col-2 slot-with-price">
                <?php 
                    $args = array(
                        'post_type' => 'collection',
                        'posts_per_page' => -1, // Adjust as needed
                        'order' => 'ASC',
                    );

                    $bookings = new WP_Query($args);
                    if($bookings->have_posts()){
                        while($bookings->have_posts()){ 
                            $bookings->the_post();
                            $bookings_slot_id = get_the_ID();
                            $user_id = get_current_user_id();
                            $bookings_slot_date = get_post_meta(get_the_ID(), '_collection_booking_date', true);
                            $bookings_slot_status = get_post_meta(get_the_ID(), '_collection_booking_status', true);
                            $bookings_slot_price = get_post_meta(get_the_ID(), '_collection_booking_price', true);
                            $bookings_slot_time = get_post_meta(get_the_ID(), '_collection_booking_time_slot', true);
                            $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
                            if($delivery_date == $bookings_slot_date){
                                if($bookings_slot_status == 'fully_booked' && $user_bookings_slot_id == $bookings_slot_id && $bookings_slot_price == 0){
                                    ?>
                                        <div class="booking-slot booking-slot-collection available selected" data-bs-toggle="modal" data-bs-target="#cancelModalCollection" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price"><i class="fa fa-check-circle" aria-hidden="true"></i></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'fully_booked' && $user_bookings_slot_id == $bookings_slot_id){
                                    ?>
                                        <div class="booking-slot booking-slot-collection available selected" data-bs-toggle="modal" data-bs-target="#cancelModalCollection" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">£<?php echo $bookings_slot_price;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'fully_booked'){
                                    ?>
                                        <div class="booking-slot fully-booked" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>">Fully Booked</div>
                                    <?php
                                }elseif($bookings_slot_status == 'unavailable'){
                                    ?>
                                        <div class="booking-slot unavailable" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>">Unavailable</div>
                                    <?php
                                }elseif($bookings_slot_status == 'available' && $bookings_slot_price == 0){
                                    ?>
                                        <div class="booking-slot booking-slot-collection available" @click="open = true" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price"><i class="fa fa-check-circle" aria-hidden="true"></i></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'available'){
                                    ?>
                                        <div class="booking-slot booking-slot-collection available"  @click="open = true" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">£<?php echo $bookings_slot_price;?></span><span class="loader-wrapper"></span></div>
                                    <?php
                                }
                            }
                        }
                    }
                ?>
                <!-- Additional fully booked slots can be added here -->
            </div>
            <!-- Modal -->
                <div class="modal slot-modal fade" id="cancelModalCollection" tabindex="-1" aria-labelledby="cancelModalCollectionLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelModalCollectionLabel">Cancel reserved slot</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Are you sure you want to cancel your reserved delivery slot on <strong id="show-selected-bookings-time-date">
                                    <?php
                                    // Booking slot date and time
                                    booking_slot_date_time($user_bookings_slot_id);
                                    ?>
                                </strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary btn-keep" data-bs-dismiss="modal">Keep slot</button>
                                <button type="button" data-bookings-slot-id = "<?= $bookings_slot_id;?>" class="btn btn-cancel cancel-booking-slot">Cancel slot</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?php
}

// reserved slot function
function lbs_reserved_slot($user_id){
    $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
    if(get_post_meta($user_bookings_slot_id, '_booking_price', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_booking_price', true);
    }elseif(get_post_meta($user_bookings_slot_id, '_saver_booking_price', true)){
        $booking_slot_price = get_post_meta($user_bookings_slot_id, '_saver_booking_price', true);
    }else{
        $booking_slot_price = 0;
    }
    $booking_slot_current_time = get_user_meta($user_id, 'booking_slot_current_time', true);
    $booking_slot_date = get_post_meta($user_bookings_slot_id, '_booking_date', true);
    $booking_slot_time = get_post_meta($user_bookings_slot_id, '_booking_time_slot', true);
    ?>
        <div class="container mt-5">
            <div class="reserved-slot">
                <div class="icon mb-3">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
                <h5>Slot reserved until <span id="show-selected-delivery-current-time"><?php echo $booking_slot_current_time; ?></span></h5>
                <p>Check out before <span id="show-selected-delivery-current-time-one"><?php echo $booking_slot_current_time; ?></span> to confirm your slot booking. Minimum order spend £40. Delivery <span id="show-selected-delivery-price">
                    <?php
                        // user booking slot price
                        echo "£" . $booking_slot_price;
                    ?>
                </span></p>

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="info-box">
                            <strong>Date and time</strong>
                            <p id="show-selected-delivery-time-date">
                                <?php
                                    // Booking slot date and time
                                    booking_slot_date_time($user_bookings_slot_id);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <?php 
                    $user_id = get_current_user_id(); 
                    global $wpdb;

                    // get post meta table from database postmeta
                    $table_name = $wpdb->prefix . 'postmeta';
                    $meta_key = '_collection_booking_status';
                    // Prepare the SQL query and use placeholders to avoid SQL injection
                    $sql = $wpdb->prepare("SELECT post_id FROM $table_name WHERE meta_key = %s", $meta_key);
                    $get_collection_slot_ids = $wpdb->get_col($sql); // Fetch post IDs as an array
                    $get_selected_booking_slot = get_user_meta($user_id, 'selected_booking_slot', true);

                    // Debug check to see if the selected slot is in the array
                    if (in_array($get_selected_booking_slot, $get_collection_slot_ids)) {
                        ?>
                        <div class="info-box collection">
                            <strong id="collection-title">Collection address</strong>
                            <p id="show-selected-collection">
                                <?php collection_address(); ?>
                            </p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="info-box delivery">
                            <strong>Delivery address</strong>
                            <p id="show-selected-delivery">
                                <?php selected_address(); ?>
                            </p>
                        </div>
                        <?php
                    }?>
                    </div>
                </div>

                <a href="<?php echo get_site_url(); ?>/laundry-service" class="btn btn-outline-secondary mt-3 continue-btn">Continue</a>
            </div>
        </div>
    <?php
}

function add_address_from(){
    ob_start();
    ?>
<div class="container mt-5 add-address-from" id="addressForm">
    <h2 class="text-center mb-4">ADD A UK ADDRESS</h2>
    <form method="post" action="">
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <select class="form-select" name="customar_shipping_title" id="title" aria-label="Title select">
                <option selected>Please select...</option>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Ms">Ms</option>
                <option value="Miss">Miss</option>
                <option value="Dr">Dr</option>
            </select>
        </div>

        <!-- First Name -->
        <div class="mb-3">
            <label for="firstName" class="form-label">First name</label>
            <input type="text" class="form-control" name="customar_shipping_first_name" id="firstName" placeholder="First name">
        </div>

        <!-- Last Name -->
        <div class="mb-3">
            <label for="lastName" class="form-label">Last name</label>
            <input type="text" class="form-control" name="customar_shipping_last_name" id="lastName" placeholder="Last name">
        </div>

        <!-- Contact Number -->
        <div class="mb-3">
            <label for="contactNumber" class="form-label">Contact number</label>
            <input type="text" class="form-control" name="customar_shipping_phone" id="contactNumber"
                placeholder="Contact number">
            <small class="form-text text-muted">We use this if we need to contact you about your
                order</small>
        </div>

        <!-- Country -->
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" name="customar_shipping_country" id="country" aria-label="Country select">
                <option value="united-kingdom" selected disabled>United Kingdom</option>
                <option value="bangladesh">Bangladesh</option>
                <option value="india">India</option>
                <option value="pakistan">Pakistan</option>
            </select>
        </div>

        <!-- Address Finder -->
        <div class="mb-3" id="addressFinderDiv">
            <label for="addressFinder" class="form-label">Address finder</label>
            <input type="text" class="form-control" name="customar_shipping_address_or_postcode" id="addressFinder"
                placeholder="Start typing an address or postcode">
            <small class="form-text text-muted">Start typing an address or postcode</small>
        </div>

        <!-- Enter Address Manually Button -->
        <div class="mb-3" id="enterAddressManuallyButton">
            <button type="button" class="btn btn-secondary" onclick="showManualAddress()">Enter
                address manually</button>
        </div>

        <!-- Hidden Address Fields -->
        <div id="manualAddressFields" class="d-none">
            <!-- Address line 1 -->
            <div class="mb-3">
                <label for="addressLine1" class="form-label">Address line 1</label>
                <input type="text" class="form-control" name="customar_shipping_address_1" id="addressLine1"
                    placeholder="Address line 1">
            </div>

            <!-- Address line 2 -->
            <div class="mb-3">
                <label for="addressLine2" class="form-label">Address line 2
                    <span>(optional)</span></label>
                <input type="text" class="form-control" name="customar_shipping_address_2" id="addressLine2"
                    placeholder="Address line 2">
            </div>

            <!-- Address line 3 -->
            <div class="mb-3">
                <label for="addressLine3" class="form-label">Address line 3
                    <span>(optional)</span></label>
                <input type="text" class="form-control" name="customar_shipping_address_3" id="addressLine3"
                    placeholder="Address line 3">
            </div>

            <!-- Town -->
            <div class="mb-3">
                <label for="town" class="form-label">Town <span>(optional)</span></label>
                <input type="text" class="form-control" name="customar_shipping_city" id="town" placeholder="Town">
            </div>

            <!-- County -->
            <div class="mb-3">
                <label for="county" class="form-label">County <span>(optional)</span></label>
                <input type="text" class="form-control" name="customar_shipping_state" id="county" placeholder="County">
            </div>

            <!-- Postcode -->
            <div class="mb-3">
                <label for="postcode" class="form-label">Postcode</label>
                <input type="text" class="form-control" name="customar_shipping_postcode" id="postcode" placeholder="Postcode">
            </div>
        </div>

        <!-- Save and Select Button -->
        <button type="submit" class="btn btn-dark w-100">Save and select</button>
    </form>
</div>
<!-- JavaScript to Show Hidden Fields -->
<script>
    function showManualAddress() {
        document.getElementById('manualAddressFields').classList.remove('d-none');
        document.getElementById('enterAddressManuallyButton').classList.add('d-none');
        document.getElementById('addressFinderDiv').classList.add('d-none');
    }
</script>
<?php
return ob_get_clean();
}

function handle_uk_address_form_submission() {
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customar_shipping_first_name'])) {

        // Get the user ID
        $user_id = get_current_user_id();

        if ($user_id > 0) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'lbs_customar_address';

            // Prepare the data for insertion
            $data = [
                'user_id' => $user_id,
                'title' => !empty($_POST['customar_shipping_title']) ? sanitize_text_field($_POST['customar_shipping_title']) : '',
                'first_name' => !empty($_POST['customar_shipping_first_name']) ? sanitize_text_field($_POST['customar_shipping_first_name']) : '',
                'last_name' => !empty($_POST['customar_shipping_last_name']) ? sanitize_text_field($_POST['customar_shipping_last_name']) : '',
                'phone' => !empty($_POST['customar_shipping_phone']) ? sanitize_text_field($_POST['customar_shipping_phone']) : '',
                'country' => !empty($_POST['customar_shipping_country']) ? sanitize_text_field($_POST['customar_shipping_country']) : '',
                'address_or_postcode' => !empty($_POST['customar_shipping_address_or_postcode']) ? sanitize_text_field($_POST['customar_shipping_address_or_postcode']) : '',
                'address_1' => !empty($_POST['customar_shipping_address_1']) ? sanitize_text_field($_POST['customar_shipping_address_1']) : '',
                'address_2' => !empty($_POST['customar_shipping_address_2']) ? sanitize_text_field($_POST['customar_shipping_address_2']) : '',
                'address_3' => !empty($_POST['customar_shipping_address_3']) ? sanitize_text_field($_POST['customar_shipping_address_3']) : '',
                'city' => !empty($_POST['customar_shipping_city']) ? sanitize_text_field($_POST['customar_shipping_city']) : '',
                'postcode' => !empty($_POST['customar_shipping_postcode']) ? sanitize_text_field($_POST['customar_shipping_postcode']) : '',
            ];

            // Insert the data into the lbs_customar_address table
            $wpdb->insert($table_name, $data);

            // Redirect to bookslot delivery page
            wp_redirect(home_url('bookslot-delivery'));
            exit;
        }
    }
}
add_action('init', 'handle_uk_address_form_submission');



// Time sorting function
function sortTimeRanges($timeRanges) {
    usort($timeRanges, function($a, $b) {
        // Convert the start times to 24-hour format for comparison
        $startA = strtotime(explode(' - ', $a)[0]);
        $startB = strtotime(explode(' - ', $b)[0]);
        
        // Compare the converted start times
        return $startA - $startB;
    });

    return $timeRanges;
}

function selected_address(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'lbs_customar_address';
    $user_id = get_current_user_id();
    $sql = "SELECT id, city, postcode FROM $table_name WHERE user_id = $user_id";
    $get_selected_address = $wpdb->get_results($sql);
    $selected_address_id = get_user_meta($user_id, 'selected_address', true);
    foreach($get_selected_address as $address){
        $city = $address->city;
        $postcode = $address->postcode;
        if($address->id == $selected_address_id){
            echo $city . ' - ' . $postcode;
        }

    }
}

function collection_address(){
    $selected_store_id = get_user_meta(get_current_user_id(), 'selected_store_id', true);
    $store_name = get_post_meta($selected_store_id, '_store_name', true);
    $store_address = get_post_meta($selected_store_id, '_store_address', true);
    $store_postcode = get_post_meta($selected_store_id, '_store_postcode', true);

    echo "Waitrose & Partners, " . $store_name . ', ' . $store_address . ', ' . $store_postcode;
}

// Booking slot date and time function
function booking_slot_date_time($user_bookings_slot_id) {
    if( get_post_meta($user_bookings_slot_id, '_booking_date', true) &&  get_post_meta($user_bookings_slot_id, '_booking_time_slot', true)) {
        $booking_slot_date = get_post_meta($user_bookings_slot_id, '_booking_date', true);
        $booking_slot_time = get_post_meta($user_bookings_slot_id, '_booking_time_slot', true);

        if(isset($booking_slot_date) && isset($booking_slot_time)){
            $booking_slot_date =  date("l, j F", strtotime($booking_slot_date));
            echo $booking_slot_date . " " . $booking_slot_time;
        }
    }elseif(get_post_meta($user_bookings_slot_id, '_collection_booking_date', true) &&  get_post_meta($user_bookings_slot_id, '_collection_booking_time_slot', true)){
        $booking_slot_date = get_post_meta($user_bookings_slot_id, '_collection_booking_date', true);
        $booking_slot_time = get_post_meta($user_bookings_slot_id, '_collection_booking_time_slot', true);

        if(isset($booking_slot_date) && isset($booking_slot_time)){
            $booking_slot_date =  date("l, j F", strtotime($booking_slot_date));
            echo $booking_slot_date . " " . $booking_slot_time;
        }

    }else{
        $booking_slot_date = get_post_meta($user_bookings_slot_id, '_saver_booking_date', true);
        $booking_slot_time = get_post_meta($user_bookings_slot_id, '_saver_booking_time_slot', true);

        if(isset($booking_slot_date) && isset($booking_slot_time)){
            $booking_slot_date =  date("l, j F", strtotime($booking_slot_date));
            echo $booking_slot_date . " " . $booking_slot_time;
        }
    }
}

// selected store address function
function selected_store_address(){
    $user_id = get_current_user_id();
    $selected_store_id = get_user_meta($user_id, 'selected_store_id', true);
    if(!empty($selected_store_id)){
        $store_name = get_post_meta($selected_store_id, '_store_name', true);
        echo "Waitrose & Partners " .  $store_name;
    }else{
        // No match found
    }
}



// update shipping address
// function update_billing_address($user_id) {
//     // get selected address
//     $selected_address_id = get_user_meta($user_id, 'selected_address', true);
//     // get selected address from database
//     $table_name = $wpdb->prefix . 'lbs_customar_address';
//     $sql = "SELECT * FROM $table_name WHERE user_id = $user_id AND id = $selected_address_id";
//     $get_selected_address = $wpdb->get_results($sql);
//     foreach($get_selected_address as $address) {
//         $order_id = wc_get_order_id_by_order_key($_POST['order_key']);
        
//         // Extracting address details
//         $title = $address->title;
//         $first_name = $address->first_name;
//         $last_name = $address->last_name;
//         $phone = $address->phone;
//         $country = $address->country;
//         $address_or_postcode = $address->address_or_postcode;
//         $address_1 = $address->address_1;
//         $address_2 = $address->address_2;
//         $address_3 = $address->address_3;
//         $city = $address->city;
//         $postcode = $address->postcode;
    
//         // Updating billing address fields
//         update_post_meta($order_id, 'shipping_title', sanitize_text_field($title));
//         update_post_meta($order_id, 'shipping_first_name', sanitize_text_field($first_name));
//         update_post_meta($order_id, 'shipping_last_name', sanitize_text_field($last_name));
//         update_post_meta($order_id, 'shipping_phone', sanitize_text_field($phone));
//         update_post_meta($order_id, 'shipping_country', sanitize_text_field($country));
//         update_post_meta($order_id, 'shipping_address_or_postcode', sanitize_text_field($address_or_postcode)); // Assuming this is a custom field
//         update_post_meta($order_id, 'shipping_address_1', sanitize_text_field($address_1));
//         update_post_meta($order_id, 'shipping_address_2', sanitize_text_field($address_2));
//         update_post_meta($order_id, 'shipping_address_3', sanitize_text_field($address_3)); // Assuming this is a custom field
//         update_post_meta($order_id, 'shipping_city', sanitize_text_field($city));
//         update_post_meta($order_id, 'shipping_postcode', sanitize_text_field($postcode));

//         echo 'Address updated successfully.';
//         exit;
//     }
    
// }
