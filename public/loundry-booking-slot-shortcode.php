<?php 
// public\loundry_booking_slot_shortcode

function lbs_loundry_booking_slot_shortcode() {
    ?>
    <div class="booking-slot">
        <!-- Header Section -->
        <section class="header">
            <h2>WOMEN, MEN AND KIDS DRY CLEANING</h2>
            <p>We care for your whole family’s clothes, from delicate dresses to rugged jeans, with meticulous attention to detail. Our dry cleaning service keeps your entire clothes clean and refreshed, ensuring every piece looks impeccable.</p>
        </section>

        <!-- Booking Section -->
        <section class="booking">
            <h3>BOOK A SLOT</h3>
            <div class="options">
                <!-- Book Collection Option -->
                <div class="option">
                    <div class="icon"><i class="fas fa-truck"></i></div>
                    <h4>Book Collection</h4>
                    <h4>Let Lave pick up and deliver your laundry.</h4>
                    <button onclick="window.location.href=<?php site_url(); ?>'bookslot-delivery/';">Choose delivery</button>
                </div>

                <!-- Drop off & Collect Option -->
                <div class="option">
                    <div class="icon"><i class="fas fa-map-marker"></i></div>
                    <h4>Drop off & Collect</h4>
                    <h4>Drop off your laundry at a drop off center and collect it from there when ready.</h4>
                    <button>Choose Click & Collect</button>
                </div>
            </div>
        </section>
    </div>
    <?php
}

// Register the shortcode with WordPress
add_shortcode('lbs_loundry_booking_slot', 'lbs_loundry_booking_slot_shortcode');