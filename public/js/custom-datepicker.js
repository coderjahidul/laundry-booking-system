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

    $("#saver_datepicker").datepicker({
        beforeShowDay: function(date) {
            var today = getToday();
            var fiveDaysLater = new Date(today);
            fiveDaysLater.setDate(today.getDate() + 7);

            if (date < today) {
                return [false, "", "Disabled - Past Date"];
            } else if (date.getDate() === today.getDate()) {
                return [false, "", "Disabled - Past Date"];
            } else if (date >= today && date <= fiveDaysLater) {
                return [true, "", "Enabled - Selectable"];
            } else {
                return [false, "", "Disabled - Out of Range"];
            }
        },
        onSelect: function(dateText, inst) {
            var date = $(this).datepicker("getDate");
            var formattedDate = formatDate(date);
            $("#selected_date_display").text(formattedDate);
            console.log(formattedDate);
        }
    });

    $("#open-saver_datepicker").click(function() {
        $("#saver_datepicker").datepicker("show");
    });

    $("#hour_datepicker").datepicker({
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
            $("#selected_hour_date_display").text(formattedDate);
            console.log(formattedDate);
        }
    });

    $("#open-hour_datepicker").click(function() {
        $("#hour_datepicker").datepicker("show");
    });
});
