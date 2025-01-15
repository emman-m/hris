<script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        showCloseButton: true,
        customClass: {
            popup: 'alert alert-<?= $class; ?>', // Add a custom class for the toast
        },
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "<?= $icon; ?>",
        text: "<?= $text; ?>",
    });
</script>