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
    <script src="<?= base_url('js/togglepassword.js') ?>"></script>
    <title><?= $this->renderSection('title') ?></title>
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

    <?= $this->renderSection('content') ?>

    <script src="<?= base_url('tabler/dist/js/tabler.min.js'); ?>"></script>
    <script src="<?= base_url('tabler/dist/js/demo-theme.min.js'); ?>"></script>
    <script src="<?= base_url('tabler/dist/js/demo.min.js'); ?>"></script>
</body>

</html>