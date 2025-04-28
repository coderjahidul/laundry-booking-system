<?php 
// Template Name: Bookslot Delivery
// lave collects shortcode
add_shortcode( 'lbs_lave_collects', 'lbs_bookslot_delivery_function' );

function lbs_bookslot_delivery_function() {
    ?>
    <div class="bookslot-delivery">
        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center border-0" id="deliveryTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery"
                    type="button" role="tab" aria-controls="delivery" aria-selected="true">LAVE COLLECTS</button>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?php echo site_url(); ?>/you-drop-off/" class="nav-link"  type="button" >YOU DROP-OFF</a>
            </li>
        </ul>

        <!-- Delivery Address Section -->
        <div class="tab-content" id="deliveryTabContent">

            <!-- Delivery Section -->
            <?php lbs_delevery(); ?>

            <!-- Click & Collect Section -->
            <?php //lbs_collection(); ?>
        </div>
    </div>
    <!-- add address from -->
    <?php add_address_from();?>
    <div class="slot-section">
        <div class="choose-your-slot-section">
            <?php 
                // If user logged in
                if(is_user_logged_in()){
                    lbs_choose_your_slot();
                }else{
                    // If user not logged in
                    echo '<h2 class="text-center">Log in to choose your preferred laundry pickup and delivery schedule.</h2>';
                }
            ?>
        </div>

        <!-- Reserved Slot -->
        <div class="reserved-delivery-slot-section">
            <?php 
                $user_id = get_current_user_id();
                $selected_booking_slot = get_user_meta($user_id, 'selected_booking_slot', true);
                $bookings_slot = get_post_meta($selected_booking_slot, '_saver_booking_status', true);
                $saver_bookings_slot = get_post_meta($selected_booking_slot, '_booking_status', true);
                
                if(!empty($selected_booking_slot) && (!empty($bookings_slot) || !empty($saver_bookings_slot))){
                    ?>
                    <div class="delivery-details">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="delivery-details d-none">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
    <!-- Choose your slot -->
    
     
<?php
}

// you drop off shortcode
add_shortcode( 'lbs_you_drop_off', 'lbs_bookslot_click_collect_function' );

function lbs_bookslot_click_collect_function() {
    ?>
    <div class="bookslot-delivery">
        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center border-0" id="deliveryTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="<?php echo site_url(); ?>/lave-collects/" class="nav-link" type="button">LAVE COLLECTS</a>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="click-collect-tab" data-bs-toggle="tab" data-bs-target="#click-collect" type="button" role="tab" aria-controls="click-collect" aria-selected="false">YOU DROP-OFF</button>
            </li>
        </ul>

        <!-- Delivery Address Section -->
        <div class="tab-content" id="deliveryTabContent">

            <!-- Delivery Section -->
            <?php //lbs_delevery(); ?>

            <!-- Click & Collect Section -->
            <?php lbs_collection(); ?>
        </div>
    </div>
    <div class="slot-section">
        <div class="choose-your-slot-section">
            <?php 
                // If user logged in
                if(is_user_logged_in()){
                    lbs_choose_your_collection_slot();
                }else{
                    // If user not logged in
                    echo '<h2 class="text-center">Log in to choose your preferred laundry pickup and delivery schedule.</h2>';
                }
            ?>
        </div>

        <!-- Reserved Slot -->
        <div class="reserved-delivery-slot-section">
            <?php 
                $user_id = get_current_user_id();
                $selected_booking_slot = get_user_meta($user_id, 'selected_booking_slot', true);
                $bookings_slot = get_post_meta($selected_booking_slot, '_collection_booking_status', true);
                if(!empty($selected_booking_slot) && !empty($bookings_slot)){
                    ?>
                    <div class="delivery-details">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="delivery-details d-none">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
     
<?php
}

// lave return shortcode
add_shortcode( 'lbs_lave_return_shortcode', 'lbs_lave_return_function' );
function lbs_lave_return_function() {
    ?>
    <div class="bookslot-delivery">
        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center border-0" id="deliveryTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery"
                    type="button" role="tab" aria-controls="delivery" aria-selected="true">LAVE RETURN</button>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?php echo site_url(); ?>/you-collect/" class="nav-link"  type="button" >YOU COLLECT</a>
            </li>
        </ul>

        <!-- Delivery Address Section -->
        <div class="tab-content" id="deliveryTabContent">

            <!-- Delivery Section -->
            <?php lbs_lave_return(); ?>

            <!-- Click & Collect Section -->
            <?php //lbs_you_collect_return(); ?>
        </div>
    </div>
    <!-- add address from -->
    <?php add_address_from();?>
    <div class="slot-section">
        <div class="choose-your-slot-section">
            <?php 
                // If user logged in
                if(is_user_logged_in()){
                    lbs_choose_lave_return_slot();
                }else{
                    // If user not logged in
                    echo '<h2 class="text-center">Log in to choose your preferred laundry pickup and delivery schedule.</h2>';
                }
            ?>
        </div>

        <!-- Reserved Slot -->
        <div class="reserved-delivery-slot-section">
            <?php 
                $user_id = get_current_user_id();
                $selected_booking_slot = get_user_meta($user_id, 'selected_booking_slot', true);
                $bookings_slot = get_post_meta($selected_booking_slot, '_saver_booking_status', true);
                $saver_bookings_slot = get_post_meta($selected_booking_slot, '_booking_status', true);
                
                if(!empty($selected_booking_slot) && (!empty($bookings_slot) || !empty($saver_bookings_slot))){
                    ?>
                    <div class="delivery-details">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="delivery-details d-none">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
    <!-- Choose your slot -->
    
     
<?php
}
// you collect shortcode
add_shortcode( 'lbs_you_collect_shortcode', 'lbs_you_collect_function' );

function lbs_you_collect_function() {
    ?>
    <div class="bookslot-delivery">
        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center border-0" id="deliveryTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="<?php echo site_url(); ?>/lave-return/" class="nav-link" type="button">LAVE RETURN</a>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="click-collect-tab" data-bs-toggle="tab" data-bs-target="#click-collect" type="button" role="tab" aria-controls="click-collect" aria-selected="false">YOU COLLECT</button>
            </li>
        </ul>

        <!-- Delivery Address Section -->
        <div class="tab-content" id="deliveryTabContent">

            <!-- Delivery Section -->
            <?php //lbs_lave_return(); ?>

            <!-- Click & Collect Section -->
            <?php lbs_collection(); ?>
        </div>
    </div>
    <div class="slot-section">
        <div class="choose-your-slot-section">
            <?php 
                // If user logged in
                if(is_user_logged_in()){
                    lbs_choose_your_collect_return_slot();
                }else{
                    // If user not logged in
                    echo '<h2 class="text-center">Log in to choose your preferred laundry pickup and delivery schedule.</h2>';
                }
            ?>
        </div>

        <!-- Reserved Slot -->
        <div class="reserved-delivery-slot-section">
            <?php 
                $user_id = get_current_user_id();
                $selected_booking_slot = get_user_meta($user_id, 'selected_booking_slot', true);
                $bookings_slot = get_post_meta($selected_booking_slot, '_collection_booking_status', true);
                if(!empty($selected_booking_slot) && $bookings_slot){
                    ?>
                    <div class="delivery-details">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="delivery-details d-none">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
     
<?php
}

?>
