<?php

use App\Enums\LeaveType;
use App\Enums\UserRole;

session()->set(['menu' => 'leaves']);

// page title
$title = 'Create Leave';
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
            <div class="col-12 gap-4">
                <!-- Vacation leave -->
                <a href="<?= route_to('leaves-create-vacation-leave') ?>" class="btn btn-light h1 h-100 w-100">
                    <?= LeaveType::APPLICATION_FOR_LEAVE->value ?>
                </a>
                <!-- OFFICIAL_BUSINESS -->
                <a href="<?= route_to('leaves-create-official-business') ?>" class="btn btn-light h1 h-100 w-100">
                    <?= LeaveType::OFFICIAL_BUSINESS->value ?>
                </a>
                <!-- PERSONAL_BUSINESS -->
                <a href="<?= route_to('leaves-create-personal-business') ?>" class="btn btn-light h1 h-100 w-100">
                    <?= LeaveType::PERSONAL_BUSINESS->value ?>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    const employeeRole = '<?= UserRole::EMPLOYEE->value ?>';
</script>
<?= $this->endSection() ?>