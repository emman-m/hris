$(function() {
    // Filter leave types based on selected leave type
    $('#type').on('change', function() {
        var leaveType = $(this).val();
        if (leaveType === vacationLeave) {
            $('.vl-type').show();
        } else {
            $('.vl-type').hide();
        }
    });

    // Print leave request
    $('#printButton').on('click', function () {
        const userId = $(this).data('id');
        const printUrl = $(this).data('url');

        // Parse the URL query parameters
        const params = new URLSearchParams(window.location.search);

        // Fetch filters
        const filters = {
            type: params.get('type'),
            vl_type: params.get('vl_type'),
            status: params.get('status'),
            start_date: params.get('start_date'),
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