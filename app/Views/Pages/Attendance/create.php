<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
session()->set(['menu' => 'attendance']);
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'Import Attendance';
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

                <form action="<?= route_to('attendance-store') ?>" class="card" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="<?= route_to('attendance-download-template')?>" class="btn btn-light">Download Template</a>
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
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const employeeRole = '<?= UserRole::EMPLOYEE->value ?>';
</script>
<?= $this->endSection() ?>