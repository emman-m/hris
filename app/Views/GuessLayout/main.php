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
    <script src="<?= base_url('js/togglepassword.js') ?>"></script>
    <title><?= $this->renderSection('title') ?></title>
</head>

<body data-bs-theme="dark" class="d-flex flex-column">
    
    <?= $this->renderSection('content') ?>

    <script src="<?= base_url('tabler/dist/js/tabler.min.js'); ?>"></script>
</body>

</html>