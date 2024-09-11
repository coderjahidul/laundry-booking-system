<?php 
// Template Name: Bookslot Delivery
add_shortcode( 'lbs_bookslot_delivery', 'lbs_bookslot_delivery_function' );

function lbs_bookslot_delivery_function() {
    ?>
    <div class="bookslot-delivery">
        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center border-0" id="deliveryTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery"
                    type="button" role="tab" aria-controls="delivery" aria-selected="true">Delivery</button>
            </li>
            <li class="nav-item" role="presentation">
                <a href="<?php echo site_url(); ?>/click-collect" class="nav-link"  type="button" >Click & Collect</a>
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
    <div class="slot-section" x-data="{ open: false }">
        <div class="choose-your-slot-section">
            <?php 
                // If user logged in
                if(is_user_logged_in()){
                    lbs_choose_your_slot();
                }else{
                    // If user not logged in
                    echo '<h2 class="text-center">Please login to choose your slot</h2>';
                }
            ?>
        </div>

        <!-- Reserved Slot -->
        <div class="reserved-delivery-slot-section">
            <?php 
                $user_id = get_current_user_id();
                if(get_user_meta($user_id, 'selected_booking_slot', true)){
                    ?>
                    <div class="delivery-details">
                        <?php lbs_reserved_slot($user_id); ?>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="delivery-details" x-show="open">
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

add_shortcode( 'lbs_bookslot_click_collect', 'lbs_bookslot_click_collect_function' );

function lbs_bookslot_click_collect_function() {
    ?>
    <div class="bookslot-delivery">
        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center border-0" id="deliveryTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="<?php echo site_url(); ?>/bookslot-delivery/" class="nav-link" type="button">Delivery</a>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="click-collect-tab" data-bs-toggle="tab" data-bs-target="#click-collect" type="button" role="tab" aria-controls="click-collect" aria-selected="false">Click & Collect</button>
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
    
     
<?php
}

?>
