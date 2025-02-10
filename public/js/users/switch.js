$(function () {
    $('.status-switch').on('change', function () {
        const url = $(this).data('url');
        const user_id = $(this).data('id');
        const status = $(this).prop('checked') ? 1 : 0;
        console.log(status);
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
            },
            success: function (response) {
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
            }
        })
    })
});