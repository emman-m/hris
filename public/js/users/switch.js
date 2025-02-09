$(function () {
    $('.status-switch').on('change', function () {
        const url = $(this).data('url');
        const user_id = $(this).data('id');
        const state = $(this).prop('checked');
        console.log({ user_id, state });

        const data = {
            state: state,
            user_id: user_id,
            csrfTokenName: csrfTokenValue
        };

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function () {
                $('.status-switch').prop('disabled', true);
            },
            success: function (response) {
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
                }
            },
            error: function (err) {
                $('.status-switch').prop('disabled', false);
                console.error(err);
            }
        })
    })
});