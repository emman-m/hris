<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('dist/styles.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/app.css') ?>">
    <script src="<?= base_url('dist/app.bundle.js') ?>"></script>
    <script src="<?= base_url('js/togglepassword.js') ?>"></script>
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
    <script src="<?= base_url('dist/footer.bundle.js') ?>"></script>
</body>

</html>