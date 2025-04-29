jQuery(document).ready(function($) {
    function formatDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-based
        var day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    function getToday() {
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Normalize time
        return today;
    }

    $("#return_datepicker").datepicker({
        beforeShowDay: function(date) {
            var today = getToday();
            var fiveDaysLater = new Date(today);
            fiveDaysLater.setDate(today.getDate() + 7);

            if (date < today) {
                return [false, "", "Disabled - Past Date"];
            } else if (date.getDate() === today.getDate()) {
                return [false, "disabled-today", "Disabled - Past Date"];
            } else if (date >= today && date <= fiveDaysLater) {
                return [true, "", "Enabled - Selectable"];
            } else {
                return [false, "", "Disabled - Out of Range"];
            }
        },
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker("getDate");
            var formattedDate = formatDate(date);
            console.log(formattedDate);
            // Call Ajax Function
            $.ajax({
                type: 'POST',
                url: ajax_object.ajaxurl,
                data: {
                    action: 'get_return_datepicker',
                    return_datepicker: formattedDate
                },
                success: function(response) {
                    // You can log or update something based on the response here
                    console.log(response);
                    location.reload(); // Reload page to apply the selected date to the PHP variable
                }
            });
        }
    });

    $("#open-return_datepicker").click(function() {
        $("#return_datepicker").datepicker("show");
    });


    $("#booking_datepicker").datepicker({
        beforeShowDay: function(date) {
            var today = getToday();
            var fiveDaysLater = new Date(today);
            fiveDaysLater.setDate(today.getDate() + 7);

            if (date < today) {
                return [false, "", "Disabled - Past Date"];
            } else if (date.getDate() === today.getDate()) {
                return [false, "disabled-today", "Disabled - Past Date"];
            } else if (date >= today && date <= fiveDaysLater) {
                return [true, "", "Enabled - Selectable"];
            } else {
                return [false, "", "Disabled - Out of Range"];
            }
        },
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker("getDate");
            var formattedDate = formatDate(date);
            console.log(formattedDate);
            // Call Ajax Function
            $.ajax({
                type: 'POST',
                url: ajax_object.ajaxurl,
                data: {
                    action: 'get_booking_datepicker',
                    booking_datepicker: formattedDate
                },
                success: function(response) {
                    // You can log or update something based on the response here
                    console.log(response);
                    location.reload(); // Reload page to apply the selected date to the PHP variable
                }
            });
        }
    });

    $("#open-booking_datepicker").click(function() {
        $("#booking_datepicker").datepicker("show");
    });

    $("#return_datepicker_sever").datepicker({
        beforeShowDay: function(date) {
            var today = getToday();
            var fiveDaysLater = new Date(today);
            fiveDaysLater.setDate(today.getDate() + 7);

            if (date < today) {
                return [false, "", "Disabled - Past Date"];
            } else if (date.getDate() === today.getDate()) {
                return [false, "disabled-today", "Disabled - Past Date"];
            } else if (date >= today && date <= fiveDaysLater) {
                return [true, "", "Enabled - Selectable"];
            } else {
                return [false, "", "Disabled - Out of Range"];
            }
        },
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker("getDate");
            var formattedDate = formatDate(date);
            console.log(formattedDate);
            // Call Ajax Function
            $.ajax({
                type: 'POST',
                url: ajax_object.ajaxurl,
                data: {
                    action: 'get_return_datepicker',
                    return_datepicker: formattedDate
                },
                success: function(response) {
                    // You can log or update something based on the response here
                    console.log(response);
                    location.reload(); // Reload page to apply the selected date to the PHP variable
                }
            });
        }
    });

    $("#open-return_datepicker_sever").click(function() {
        $("#return_datepicker_sever").datepicker("show");
    });


    $("#booking_datepicker_sever").datepicker({
        beforeShowDay: function(date) {
            var today = getToday();
            var fiveDaysLater = new Date(today);
            fiveDaysLater.setDate(today.getDate() + 7);

            if (date < today) {
                return [false, "", "Disabled - Past Date"];
            } else if (date.getDate() === today.getDate()) {
                return [false, "disabled-today", "Disabled - Past Date"];
            } else if (date >= today && date <= fiveDaysLater) {
                return [true, "", "Enabled - Selectable"];
            } else {
                return [false, "", "Disabled - Out of Range"];
            }
        },
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker("getDate");
            var formattedDate = formatDate(date);
            console.log(formattedDate);
            // Call Ajax Function
            $.ajax({
                type: 'POST',
                url: ajax_object.ajaxurl,
                data: {
                    action: 'get_booking_datepicker',
                    booking_datepicker: formattedDate
                },
                success: function(response) {
                    // You can log or update something based on the response here
                    console.log(response);
                    location.reload(); // Reload page to apply the selected date to the PHP variable
                }
            });
        }
    });

    $("#open-booking_datepicker_sever").click(function() {
        $("#booking_datepicker_sever").datepicker("show");
    });
});
