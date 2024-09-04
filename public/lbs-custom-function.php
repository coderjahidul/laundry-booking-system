<?php
// lbs-delevery function
function lbs_delevery() {
    $user_id = get_current_user_id();
    $get_shipping_city = get_user_meta($user_id, 'customar_shipping_city');
    $get_shipping_postcode = get_user_meta($user_id, 'customar_shipping_postcode');
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
                <?php if(!empty($get_shipping_city) && !empty($get_shipping_postcode)){
                    foreach($get_shipping_city as $index => $city){
                        $city = $city;
                        $postcode = isset($get_shipping_postcode[$index]) ? $get_shipping_postcode[$index] : '';
                        $post_id = $index + 1;
                        $get_selected_address = get_user_meta($user_id, 'selected_address', true);
                        if($get_selected_address == $post_id ){
                            ?>
                            <div class="address-card select-address selected" data-post-id="<?= $post_id; ?>">
                                <span><?= $city; ?></span>
                                <br>
                                <span><?= $postcode; ?></span>
                            </div>
                            <?php
                        }else {
                            ?>
                            <div class="address-card select-address" data-post-id="<?= $post_id; ?>">
                                <span><?= $city; ?></span>
                                <br>
                                <span><?= $postcode; ?></span>
                            </div>
                            <?php
                        }
                    }
                }?>
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
<div class="collect-section tab-pane fade " id="click-collect" role="tabpanel" aria-labelledby="click-collect-tab">
    <h2 class="text-center mb-4">Choose a store for collection</h2>

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
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Morningside</h5>
                    <p class="card-text">
                        145 Morningside Road<br>
                        Edinburgh<br>
                        EH10 4AX<br>
                        <strong>5.3 miles away</strong><br>
                    </p>
                    <p class="card-text">Car park or in-store collection</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Comely Bank</h5>
                    <p class="card-text">
                        38 Comely Bank Road<br>
                        Edinburgh<br>
                        EH4 1AW<br>
                        <strong>6 miles away</strong><br>
                    </p>
                    <p class="card-text">Car park or in-store collection</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Stirling</h5>
                    <p class="card-text">
                        Waitrose Ltd Burghmuir Road<br>
                        FK7 7GX<br>
                        <strong>35.5 miles away</strong><br>
                    </p>
                    <p class="card-text">Car park or in-store collection</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Byres Road</h5>
                    <p class="card-text">
                        373 Byres Road<br>
                        Glasgow<br>
                        G12 8AU<br>
                        <strong>47.3 miles away</strong><br>
                    </p>
                    <p class="card-text">In-store collection</p>
                </div>
            </div>
        </div>
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

// Hour function
function hour_function(){
    ?>
<div class="hour-section tab-pane fade show active" id="hour" role="tabpanel" aria-labelledby="hour-tab">
    <p class="text-center">Perfect if you need delivery within a 1 hour window. On the day, we’ll text you when the
        driver is close.</p>
    <div class="container my-4">
        <div class="d-flex justify-content-between">
            <!-- Previous button -->
            <a href="#" class="btn btn-link">&lt; Previous</a>
            <!-- calendar -->
            <input type="text" id="hour_datepicker" style="display:none;">
            <button class="btn btn-outline-secondary" id="open-hour_datepicker">View calendar</button>

            <!-- Next button -->
            <a href="#" class="btn btn-link">Next &gt;</a>
        </div>

        <div class="row text-center">
            <div class="col schedule-header"></div>
            <!-- <div class="col schedule-header">Tue 27 Aug</div> -->
            <?php
                $args = array(
                    'post_type' => 'booking',
                    'posts_per_page' => -1, // Adjust as needed,
                    'meta_key' => '_booking_date',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                );
                
                $bookings_date = new WP_Query($args);
                
                $delivery_dates = array(); // Array to keep track of printed dates
                $unique_dates_count = 0;  // Counter to limit to 5 unique dates
                
                if ($bookings_date->have_posts()) {
                    while ($bookings_date->have_posts()) {
                        $bookings_date->the_post();
                
                        $slot_date = get_post_meta(get_the_ID(), '_booking_date', true);
                        // $slot_date = date("D, j M", strtotime($get_date));
                
                        // Check if the formatted date is already in the array
                        if (!in_array($slot_date, $delivery_dates)) {
                            echo "<div class='col schedule-header'> " . date("D, j M", strtotime($slot_date) ) . "</div>";
                
                            // Add the date to the array and increment the counter
                            $delivery_dates[] = $slot_date;
                            $unique_dates_count++;
                
                            // Break the loop if 5 unique dates have been printed
                            if ($unique_dates_count >= 5) {
                                break;
                            }
                        }
                    }
                }
                
                // Reset post data to avoid conflicts
                wp_reset_postdata();                
            ?>
        </div>

        <div class="row">
            <div class="col">
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
            <?php foreach($delivery_dates as $delivery_date){?>
            <div class="col slot-with-price">
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
                                        <div class="booking-slot booking-slot-hour available selected" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">Free</span><span class="loader-wrapper"></span></div>
                                    <?php
                                }elseif($bookings_slot_status == 'fully_booked' && $user_bookings_slot_id == $bookings_slot_id){
                                    ?>
                                        <div class="booking-slot booking-slot-hour available selected" data-bookings-slot-id = "<?= $bookings_slot_id;?>" data-bookings-slot-date = "<?= $bookings_slot_date;?>" data-bookings-slot-status = "<?= $bookings_slot_status;?>" data-bookings-slot-price = "<?= $bookings_slot_price;?>" data-bookings-slot-time = "<?= $bookings_slot_time;?>"><span class="slot-price">£<?php echo $bookings_slot_price;?></span><span class="loader-wrapper"></span></div>
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
            <!-- Previous button -->
            <a href="#" class="btn btn-link">&lt; Previous</a>
            <!-- calendar -->
            <input type="text" id="saver_datepicker" style="display:none;">
            <button class="btn btn-outline-secondary" id="open-saver_datepicker">View calendar</button>

            <!-- Next button -->
            <a href="#" class="btn btn-link">Next &gt;</a>
        </div>

        <div class="row text-center">
            <div class="col schedule-header"></div>
            <div class="col schedule-header">Tue 27 Aug</div>
            <div class="col schedule-header">Wed 28 Aug</div>
            <div class="col schedule-header">Thu 29 Aug</div>
            <div class="col schedule-header">Fri 30 Aug</div>
            <div class="col schedule-header">Sat 31 Aug</div>
        </div>

        <div class="row">
            <div class="col">
                <div class="booking-time-list align-items-center">8 - 12pm</div>
                <div class="booking-time-list align-items-center">12 - 4pm</div>
                <div class="booking-time-list align-items-center">4 - 8pm</div>

                <!-- Additional fully booked slots can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 3; $i++) {
                            echo '<div class="booking-slot fully-booked">Fully booked <br> 8am - 12pm</div>';
                        }
                    ?>
                <!-- Additional fully booked slots can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 3; $i++) {
                            echo '<div class="booking-slot available">$2 <br> 8am - 12pm</div>';
                        }
                    ?>
                <!-- Additional fully booked slots can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 3; $i++) {
                            echo '<div class="booking-slot fully-booked">Fully booked <br> 8am - 12pm</div>';
                        }
                    ?>
                <!-- Additional slots with prices can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 3; $i++) {
                            echo '<div class="booking-slot available">$2 <br> 8am - 12pm</div>';
                        }
                    ?>
                <!-- Additional slots with prices can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 3; $i++) {
                            echo '<div class="booking-slot fully-booked">Fully booked <br> 8am - 12pm</div>';
                        }
                    ?>
                <!-- Additional slots with prices can be added here -->
            </div>
        </div>
    </div>
</div>
<?php
}

// reserved slot function
function lbs_reserved_slot($user_id){
    $user_bookings_slot_id = get_user_meta($user_id, 'selected_booking_slot', true);
    $booking_slot_price = get_post_meta($user_bookings_slot_id, '_booking_price', true);
    $booking_slot_current_time = get_user_meta($user_id, 'booking_slot_current_time', true);
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
                            <p id="show-selected-delivery-time-date">Sunday 1 September 12pm - 1pm</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box">
                            <strong>Delivery address</strong>
                            <p id="show-selected-delivery">
                                <?php selected_address(); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <a href="#" class="btn btn-outline-secondary mt-3 continue-btn">Continue</a>
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
            <input type="text" class="form-control" name="customar_shipping_first_name" id="firstName" placeholder="First name"
                required>
        </div>

        <!-- Last Name -->
        <div class="mb-3">
            <label for="lastName" class="form-label">Last name</label>
            <input type="text" class="form-control" name="customar_shipping_last_name" id="lastName" placeholder="Last name"
                required>
        </div>

        <!-- Contact Number -->
        <div class="mb-3">
            <label for="contactNumber" class="form-label">Contact number</label>
            <input type="text" class="form-control" name="customar_shipping_phone" id="contactNumber"
                placeholder="Contact number" required>
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
                placeholder="Start typing an address or postcode" required>
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
                <input type="text" class="form-control" name="customar_shipping_postcode" id="postcode" placeholder="Postcode"
                    required>
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

function handle_uk_address_form_submission(){
    // Check if the form has been submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customar_shipping_first_name'])){

        // Get the user ID
        $user_id = get_current_user_id();

        if($user_id > 0){
            if(!empty($_POST['customar_shipping_title'])) {
                add_user_meta($user_id, 'customar_shipping_title', sanitize_text_field($_POST['customar_shipping_title']));
            }
            if(!empty($_POST['customar_shipping_first_name'])) {
                add_user_meta($user_id, 'customar_shipping_first_name', sanitize_text_field($_POST['customar_shipping_first_name']));
            }
            if(!empty($_POST['customar_shipping_last_name'])) {
                add_user_meta($user_id, 'customar_shipping_last_name', sanitize_text_field($_POST['customar_shipping_last_name']));
            }
            if(!empty($_POST['customar_shipping_phone'])) {
                add_user_meta($user_id, 'customar_shipping_phone', sanitize_text_field($_POST['customar_shipping_phone']));
            }
            if(!empty($_POST['customar_shipping_country'])) {
                add_user_meta($user_id, 'customar_shipping_country', sanitize_text_field($_POST['customar_shipping_country']));
            }
            if(!empty($_POST['customar_shipping_address_or_postcode'])) {
                add_user_meta($user_id, 'customar_shipping_address_or_postcode', sanitize_text_field($_POST['customar_shipping_address_or_postcode']));
            }
            if(!empty($_POST['customar_shipping_address_1'])) {
                add_user_meta($user_id, 'customar_shipping_address_1', sanitize_text_field($_POST['customar_shipping_address_1']));
            }
            if(!empty($_POST['customar_shipping_address_2'])) {
                add_user_meta($user_id, 'customar_shipping_address_2', sanitize_text_field($_POST['customar_shipping_address_2']));
            }
            if(!empty($_POST['customar_shipping_address_3'])) {
                add_user_meta($user_id, 'customar_shipping_address_3', sanitize_text_field($_POST['customar_shipping_address_3']));
            }
            if(!empty($_POST['customar_shipping_city'])) {
                add_user_meta($user_id, 'customar_shipping_city', sanitize_text_field($_POST['customar_shipping_city']));
            }
            if(!empty($_POST['customar_shipping_postcode'])) {
                add_user_meta($user_id, 'customar_shipping_postcode', sanitize_text_field($_POST['customar_shipping_postcode']));
            }

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
    $user_id = get_current_user_id();
    $get_selected_address = get_user_meta($user_id, 'selected_address', true);

    $get_shipping_city = get_user_meta($user_id, 'customar_shipping_city');
    $get_shipping_postcode = get_user_meta($user_id, 'customar_shipping_postcode');

    foreach($get_shipping_city as $index => $city){
        $pos_index = $index;
        $index = $index + 1;
        $shipping_postcode = isset($get_shipping_postcode[$pos_index]) ? $get_shipping_postcode[$pos_index] : '';
        if($get_selected_address == $index ){
            echo $city . ' - ' . $shipping_postcode;
        }
    }
}

