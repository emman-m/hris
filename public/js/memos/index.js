$(function () {
    // Delete functionality
    $(document).on('click', '.data-delete', function() {
        const id = $(this).data('id');
        const url = $(this).data('url');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id: id,
                        [csrfTokenName]: csrfTokenValue
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Refresh token
                        csrfTokenValue = response.csrfToken;
                        
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                // Reload the page to refresh the list
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        // Refresh token if available
                        if (xhr.responseJSON && xhr.responseJSON.csrfToken) {
                            csrfTokenValue = xhr.responseJSON.csrfToken;
                        }
                        
                        let errorMessage = 'Failed to delete the memo.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('#printButton').on('click', function () {
        const printUrl = $(this).data('url');

        // Parse the URL query parameters
        const params = new URLSearchParams(window.location.search);

        // Fetch filters
        const filters = {
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
