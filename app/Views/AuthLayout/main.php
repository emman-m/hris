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
    <script src="<?= base_url('jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('sweetalert2/theme-borderless/borderless.min.css'); ?>">
    <?= $this->renderSection('header-script') ?>
    <title>HRIS | <?= $this->renderSection('title') ?></title>
</head>

<body>
    <!-- Toast -->
    <?php if (session()->has('toast')): ?>
        <?= view('Components/alert', session()->get('toast')) ?>
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
    </script>
    <?= $this->renderSection('footer-script') ?>
</body>

</html>