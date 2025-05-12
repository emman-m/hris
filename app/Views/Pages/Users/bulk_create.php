<?php

use App\Enums\UserRole;
session()->set(['menu' => 'users']);
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'Bulk User Registration';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<?= $this->endSection() ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <?= $title ?>
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <form action="<?= route_to('users-bulk-store') ?>" class="card" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="<?= route_to('users-download-template')?>" class="btn btn-light">Download Template</a>
                        </div>
                        <hr>
                        <!-- CSV File -->
                        <div class="mb-3">
                            <div class="form-label required">File</div>
                            <input type="file" name="file" class="form-control">
                            <!-- Error Message -->
                            <?php if (isset($errors['file'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['file'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="alert alert-info">
                            <h4 class="alert-title">Instructions</h4>
                            <p>Please follow these guidelines when preparing your CSV file:</p>
                            <ul>
                                <li>Role must be one of: <?= implode(', ', array_column($roles, 'value')) ?></li>
                                <li>Email addresses must be unique</li>
                                <li>Employee ID is required only for employee role</li>
                                <li>Default password will be set to 'password'</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 