<?php 
// public\loundry_booking_slot_shortcode

function lbs_loundry_booking_slot_shortcode() {
    ?>
    <div class="booking-slot">
        <!-- Header Section -->
        <section class="header">
			<h4><strong>WELCOME TO YOUR DEDICATED COLLECTION AND DELIVERY PORTAL</strong></h4>
			<h6 style="font-size: 15px;line-height: 1.7;">You've been redirected here because scheduling your collection and delivery times is required to view your cart or checkout. If you haven’t logged in or registered, you’ll be prompted when you click any of the buttons below. Once logged in, enter your address, select your collection and return times, and proceed to your cart, checkout, or shopping.</h6>
        </section>

        <!-- Booking Section -->
        <section class="booking">
            <!-- <h3>BOOK A SLOT</h3> -->
            <div class="options">
                <!-- Book Collection Option -->
                <div class="option">
                    <div class="icon"><i class="fas fa-truck"></i></div>
                    <h4>Book Collection & Delivery</h4>
                    <h4>Let us collect your laundry right from your doorstep and return it expertly cleaned and refreshed.</h4>
                    <button onclick="window.location.href=<?php site_url(); ?>'lave-collects/';">Choose delivery</button>
                </div>

                <!-- Drop off & Collect Option -->
                <div class="option">
                    <div class="icon"><i class="fas fa-map-marker"></i></div>
                    <h4>Drop off & Collect</h4>
                    <h4>Drop off your laundry at a drop off center and collect it from there when ready.</h4>
                    <button onclick="window.location.href=<?php site_url(); ?>'you-drop-off/';">Drop-off & Collect</button>
                </div>
            </div>
        </section>
    </div>
    <?php
}

// Register the shortcode with WordPress
add_shortcode('lbs_loundry_booking_slot', 'lbs_loundry_booking_slot_shortcode');