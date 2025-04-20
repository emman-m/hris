$(function () {
    $('.status-switch').on('change', function () {
        const state = $(this).prop('checked') ? 1 : 0;
        
        Swal.fire({
            title: "Are you sure?",
            text: "This may affect the user's status.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: `Yes ${state ? 'Enable' : 'Disable'} it!`, 
        }).then((result) => {
            if (result.isConfirmed) {
                const url = $(this).data('url');
                const user_id = $(this).data('id');

                const status = state ? 1 : 0;

                var data = {
                    status: status,
                    user_id: user_id
                };

                data[csrfTokenName] = csrfTokenValue;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        $('.status-switch').prop('disabled', true);
                        Swal.fire({
                            title: "Loading...",
                            html: "Please wait while we process your request.",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        // Refresh token
                        csrfTokenValue = response.csrfToken;
                        if (response.success) {
                            $('.status-switch').prop('disabled', false);
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                customClass: {
                                    popup: 'alert alert-success', // Add a custom class for the toast
                                },
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                text: response.message,
                            });
                            $('.status-switch').prop('disabled', false);
                        }
                    },
                    error: function (err) {
                        $('.status-switch').prop('disabled', false);
                        console.error(err);
                        Swal.close(); // Close the loading dialog
                    }
                })
            } else {
                $(this).prop('checked', !state);
            }
        });


    })
});