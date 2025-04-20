$(function () {
    $('.lock-unlock-employee').on('click', function () {
        let ele = $(this);
        let userId = $(this).data('id');
        let url = $(this).data('url');
        let state = ele.attr('data-state') == 1 ? 0 : 1;

        Swal.fire({
            title: "Are you sure?",
            text: state === 1
                ? "Employee will not be able to edit his information"
                : "Employee will be able to edit his information",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: `Yes ${state === 0 ? 'Unlock' : 'Lock'} it!`,
        }).then((result) => {
            if (result.isConfirmed) {

                var data = {
                    state: state,
                    user_id: userId
                };

                data[csrfTokenName] = csrfTokenValue;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        ele.prop('disabled', true);
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
                        // Refresh token
                        csrfTokenValue = response.csrfToken;
                        if (response.success) {
                            ele.prop('disabled', false);
                            ele.html(state === 0 ? 'Lock' : 'Unlock');
                            ele.attr('data-state', state);

                            // Close loading popup
                            Swal.close();

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
                            ele.prop('disabled', false);
                        }
                    },
                    error: function (err) {
                        ele.prop('disabled', false);
                        console.error(err);
                        // Close loading
                        Swal.close();
                    }
                })
            } else {
                ele.html(state === 0 ? 'Unlock' : 'Lock');
            }
        });
    });
});
