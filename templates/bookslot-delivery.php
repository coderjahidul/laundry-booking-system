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
                <button class="nav-link" id="click-collect-tab" data-bs-toggle="tab" data-bs-target="#click-collect"
                    type="button" role="tab" aria-controls="click-collect" aria-selected="false">Click & Collect</button>
            </li>
        </ul>

        <!-- Delivery Address Section -->
        <div class="tab-content" id="deliveryTabContent">

            <!-- Delivery Section -->
            <?php lbs_delevery(); ?>

            <!-- Click & Collect Section -->
            <?php lbs_collection(); ?>
        </div>
    </div>
    <!-- add address from -->
    <?php add_address_from();?>
    <!-- Choose your slot -->
    <?php lbs_choose_your_slot(); ?>

    <!-- Reserved Slot -->
     <?php lbs_reserved_slot();?>
<?php
}

?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        $(".change-address").click(function (e) {
            e.preventDefault(); // Prevent the default anchor behavior
            $(".address-options").slideToggle(); // Toggle the address options
        });
    });
</script>