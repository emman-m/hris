$(function () {
    // Detect Windows theme
    const isDarkTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (isDarkTheme) {
        $('#dark-theme').prop('disabled', false);
    }

    // Parse the URL query parameters
    const params = new URLSearchParams(window.location.search);

    const date = new Date();
    const current_date = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;

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

    // Default value
    $("#to").val(params.get('to'));

    $("#to").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        minDate: $("#from").val() || current_date,
    });

    /**
     * ----------------------------------------------
     * Print attendance report
     * ----------------------------------------------
     */
    $('#printButton').on('click', function () {
        const printUrl = $(this).data('url');

        // Fetch filters
        const filters = {
            from: params.get('from') || '',
            to: params.get('to') || '',
            search: params.get('search') || '',
        };

        // Include csrf
        filters[csrfTokenName] = csrfTokenValue;

        // AJAX call to fetch filtered data
        $.ajax({
            url: printUrl, // Set globally in the view
            type: 'POST',
            data: filters,
            dataType: 'json',
            success: function (response) {
                // Refresh token
                csrfTokenValue = response.csrfToken;
                // Open a new window and write the response content for printing
                const printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(response.html);
                printWindow.document.close();
                printWindow.print();
            },
            error: function (err) {
                console.error(err);
                Swal.fire('Error', 'Failed to fetch data for printing', 'error');
            }
        });
    });
});