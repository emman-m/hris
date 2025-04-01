$(function() {
    // Print leave request
    $('#printButton').on('click', function () {
        const leave_id = $(this).data('id');
        const printUrl = $(this).data('url');

        // Fetch filters
        const filters = {
            id: leave_id,
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
                
                printWindow.onload = function () {
                    printWindow.print();
                };
            },
            error: function (err) {
                console.error(err);
                Swal.fire('Error', 'Failed to fetch data for printing', 'error');
            }
        });
    });
});