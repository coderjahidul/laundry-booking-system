<?php
// lbs-delevery function
function lbs_delevery() {
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
        <div class="address">Aberdeen, EH21 6UU</div>
        <a href="#" class="change-address">Change address <i class="fa fa-angle-down" aria-hidden="true"></i></a>
    </div>

    <!-- Address Options -->
    <div class="address-options" style="display: none;">
        <div class="address-card selected">
            <span>Aberdeen</span>
            <br>
            <span>EH21 6UU</span>
        </div>
        <div class="address-card">
            <span>94 Newman Street</span>
            <span>London</span>
            <br>
            <span>W1T 3EZ</span>
        </div>
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
                        <div class="container mt-5 add-address-from" id="addressForm">
                            <h2 class="text-center mb-4">ADD A UK ADDRESS</h2>
                            <form>
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <select class="form-select" id="title" aria-label="Title select">
                                        <option selected>Please select...</option>
                                        <option value="1">Mr</option>
                                        <option value="2">Mrs</option>
                                        <option value="3">Ms</option>
                                        <option value="4">Miss</option>
                                        <option value="5">Dr</option>
                                    </select>
                                </div>

                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="First name">
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Last name">
                                </div>

                                <!-- Contact Number -->
                                <div class="mb-3">
                                    <label for="contactNumber" class="form-label">Contact number</label>
                                    <input type="text" class="form-control" id="contactNumber"
                                        placeholder="Contact number">
                                    <small class="form-text text-muted">We use this if we need to contact you about your
                                        order</small>
                                </div>

                                <!-- Country -->
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country" aria-label="Country select">
                                        <option value="united-kingdom" selected>United Kingdom</option>
                                        <option value="bangladesh">Bangladesh</option>
                                        <option value="india">India</option>
                                        <option value="pakistan">Pakistan</option>
                                    </select>
                                </div>

                                <!-- Address Finder -->
                                <div class="mb-3" id="addressFinderDiv">
                                    <label for="addressFinder" class="form-label">Address finder</label>
                                    <input type="text" class="form-control" id="addressFinder"
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
                                        <input type="text" class="form-control" id="addressLine1"
                                            placeholder="Address line 1">
                                    </div>

                                    <!-- Address line 2 -->
                                    <div class="mb-3">
                                        <label for="addressLine2" class="form-label">Address line 2
                                            <span>(optional)</span></label>
                                        <input type="text" class="form-control" id="addressLine2"
                                            placeholder="Address line 2">
                                    </div>

                                    <!-- Address line 3 -->
                                    <div class="mb-3">
                                        <label for="addressLine3" class="form-label">Address line 3
                                            <span>(optional)</span></label>
                                        <input type="text" class="form-control" id="addressLine3"
                                            placeholder="Address line 3">
                                    </div>

                                    <!-- Town -->
                                    <div class="mb-3">
                                        <label for="town" class="form-label">Town <span>(optional)</span></label>
                                        <input type="text" class="form-control" id="town" placeholder="Town">
                                    </div>

                                    <!-- County -->
                                    <div class="mb-3">
                                        <label for="county" class="form-label">County <span>(optional)</span></label>
                                        <input type="text" class="form-control" id="county" placeholder="County">
                                    </div>

                                    <!-- Postcode -->
                                    <div class="mb-3">
                                        <label for="postcode" class="form-label">Postcode</label>
                                        <input type="text" class="form-control" id="postcode" placeholder="Postcode">
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

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
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

<script>
    // $(document).ready(function () {
    //     $('#myModal').on('shown.bs.modal', function () {
    //         // This event is triggered when the modal is fully shown
    //         console.log('Modal is now shown');
    //     });

    //     $('#myModal').on('hidden.bs.modal', function () {
    //         // This event is triggered when the modal is hidden
    //         console.log('Modal is now hidden');
    //     });
    // });
</script>
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
            <div class="col schedule-header">Tue 27 Aug</div>
            <div class="col schedule-header">Wed 28 Aug</div>
            <div class="col schedule-header">Thu 29 Aug</div>
            <div class="col schedule-header">Fri 30 Aug</div>
            <div class="col schedule-header">Sat 31 Aug</div>
        </div>

        <div class="row">
            <div class="col">
                <!-- <div class="booking-time-list align-items-center">8 - 9am</div>
                    <div class="booking-time-list align-items-center">9 - 10am</div> -->
                <?php 
                        for($i = 8; $i < 12; $i++) {
                            ?>
                <div class="booking-time-list"><?php echo $i . "-" . $i + 1 . "am"; ?></div>
                <?php
                        }
                        for($i = 1; $i < 9; $i++) {
                            ?>
                <div class="booking-time-list"><?php echo $i . "-" . $i + 1 . "am"; ?></div>
                <?php
                        }
                    ?>

                <!-- Additional fully booked slots can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 12; $i++) {
                            echo '<div class="booking-slot fully-booked">Fully booked</div>';
                        }
                    ?>
                <!-- Additional fully booked slots can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 12; $i++) {
                            echo '<div class="booking-slot available">Fully booked</div>';
                        }
                    ?>
                <!-- Additional fully booked slots can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 12; $i++) {
                            echo '<div class="booking-slot fully-booked">Fully booked</div>';
                        }
                    ?>
                <!-- Additional slots with prices can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 12; $i++) {
                            echo '<div class="booking-slot available">Fully booked</div>';
                        }
                    ?>
                <!-- Additional slots with prices can be added here -->
            </div>
            <div class="col slot-with-price">
                <?php 
                        for($i = 0; $i < 12; $i++) {
                            echo '<div class="booking-slot fully-booked">Fully booked</div>';
                        }
                    ?>
                <!-- Additional slots with prices can be added here -->
            </div>
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
function lbs_reserved_slot(){
    ?>
<div class="container mt-5">
    <div class="reserved-slot">
        <div class="icon mb-3">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
        </div>
        <h5>Slot reserved until 2:40pm</h5>
        <p>Check out before 2:40pm to confirm your slot booking. Minimum order spend £40. Delivery £4</p>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="info-box">
                    <strong>Date and time</strong>
                    <p>Sunday 1 September 12pm - 1pm</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <strong>Delivery address</strong>
                    <p>Aberdeen, EH21 6UU</p>
                </div>
            </div>
        </div>

        <button class="btn btn-outline-secondary mt-3 continue-btn">Continue</button>
    </div>
</div>
<?php
}

function add_address_from(){
    ?>

<?php
}
// add_shortcode('add_address', 'add_address_from');