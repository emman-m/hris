<?php

session()->set(['menu' => '']);

$pageTitle = 'Updates';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $pageTitle ?>
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <?= $pageTitle ?>
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <?= $context ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>