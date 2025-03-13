$(function () {
    // Detect Windows theme
    const isDarkTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (isDarkTheme) {
        $('#dark-theme').prop('disabled', false);
    }

    $("#from").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        onSelect: function (selectedDate) {
            // Set the minimum date for the "to" date picker
            $("#to").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#to").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        autoclose: true
    });
});