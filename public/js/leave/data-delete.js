$(function() {

    // delete data
    $('.data-delete').on('click', function(){
        let ele = $(this);
        let id = $(this).data('id');
        let url = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            text: "You might not recover this.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: `Yes Delete it!`,
        }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    id: id
                };

                data[csrfTokenName] = csrfTokenValue;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        ele.html('Deleting...');
                    },
                    success: function (response) {
                        // Refresh token
                        csrfTokenValue = response.csrfToken;
                        if (response.success) {
                            ele.closest('tr').remove();

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
                        console.error(err);
                    }
                })
            } else {
                
            }
        });
    });
});