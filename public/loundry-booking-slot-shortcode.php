<?php 
// public\loundry_booking_slot_shortcode

function lbs_loundry_booking_slot_shortcode() {
    ?>
    <div class="booking-slot">
        <!-- Header Section -->
        <section class="header">
            <h2>BOOK A SLOT FOR LAUNDRY AND DRY CLEANING</h2>
        </section>

        <!-- Booking Section -->
        <section class="booking">
            <!-- <h3>BOOK A SLOT</h3> -->
            <div class="options">
                <!-- Book Collection Option -->
                <div class="option">
                    <div class="icon"><i class="fas fa-truck"></i></div>
                    <h4>Book Collection</h4>
                    <h4>Let us collect your laundry right from your doorstep and return it expertly cleaned and refreshed.</h4>
                    <button onclick="window.location.href=<?php site_url(); ?>'lave-collects/';">Choose delivery</button>
                </div>

                <!-- Drop off & Collect Option -->
                <div class="option">
                    <div class="icon"><i class="fas fa-map-marker"></i></div>
                    <h4>Drop off & Collect</h4>
                    <h4>Drop off your laundry at a drop off center and collect it from there when ready.</h4>
                    <button onclick="window.location.href=<?php site_url(); ?>'you-drop-off/';">Choose Click & Collect</button>
                </div>
            </div>
        </section>
    </div>
    <?php
}

// Register the shortcode with WordPress
add_shortcode('lbs_loundry_booking_slot', 'lbs_loundry_booking_slot_shortcode');