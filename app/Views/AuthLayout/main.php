<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('tabler/dist/css/tabler.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tabler/dist/css/tabler-flags.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tabler/dist/css/tabler-payments.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tabler/dist/css/tabler-vendors.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('tabler/dist/css/demo.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/main.css'); ?>">
    <script src="<?= base_url('jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('sweetalert2/theme-borderless/borderless.min.css'); ?>">
    <?= $this->renderSection('header-script') ?>
    <title>HRMS | <?= $this->renderSection('title') ?></title>
</head>

<body>
    <!-- Toast -->
    <?php if (session()->has('toast')): ?>
        <?= view('Components/alert', session()->get('toast')) ?>
    <?php endif; ?>
    <!-- Swal -->
    <?php if (session()->has('swal')): ?>
        <?= view('Components/swal', session()->get('swal')) ?>
    <?php endif; ?>

    <div class="page">
        <!-- Navbar -->
        <?= view('Components/navbar') ?>

        <!-- Sidebar -->
        <?= view('Components/sidebar') ?>

        <!-- Content -->
        <div class="page-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    <script src="<?= base_url('tabler/dist/js/tabler.min.js'); ?>"></script>
    <script src="<?= base_url('tabler/dist/js/demo-theme.min.js'); ?>"></script>
    <script src="<?= base_url('tabler/dist/js/demo.min.js'); ?>"></script>
    <!-- Script to update CSRF dynamically -->
    <script>
        const csrfTokenName = '<?= csrf_token() ?>';
        let csrfTokenValue = '<?= csrf_hash() ?>';
        const baseUrl = '<?= base_url() ?>';
    </script>
    <?= $this->renderSection('footer-script') ?>

    <!-- Notification -->
    <script>
        $(function () {

            // Fetch Notification
            let processing = false;
            let notifCount = 0;
            setInterval(() => {
                fetchNotif();
            }, 3000);

            function fetchNotif() {
                if (!processing) {
                    // Set request data
                    var request = {};
                    request[csrfTokenName] = csrfTokenValue;

                    $.ajax({
                        url: '<?= route_to('get-notification') ?>',
                        type: 'post',
                        data: request,
                        dataType: 'json',
                        beforeSend: function () {
                            processing = true;
                        },
                        success: function (data) {
                            // Refresh token
                            csrfTokenValue = data.csrfToken;
                            $(`input[name="${csrfTokenName}"]`).val(csrfTokenValue);

                            if (data.success) {
                                if (data.count > notifCount) {
                                    $('.notif-box').html(data.html);
                                    notifCount = data.count;
                                }

                                if (notifCount === 0) {
                                    $('.notif-box').html(data.html);
                                }

                                if (data.has_new) {
                                    $('#badgeIcon').html(`<span class="badge bg-red"></span>`);
                                }
                            }
                            processing = false;
                        },
                        error: function (err) {
                            console.log(err.responseText);
                        }
                    })
                }
            }

            // fetchNotif();
        });
    </script>
</body>

</html>