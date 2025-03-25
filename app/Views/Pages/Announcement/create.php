<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
session()->set(['menu' => 'announcements']);
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'Create Announcement';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<?= $this->section('header-script') ?>
<!-- <link rel="stylesheet" href="<?= base_url('tom-select/styles.css') ?>"> -->
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('tom-select/complete.min.js') ?>"></script>
<!-- <script src="<?= base_url('tinymce/tinymce.min.js') ?>"></script> -->
<script src="https://cdn.tiny.cloud/1/qhsoyoafyafernaxvto2epyfdbd0u0zzhj21m9qb6ts5xhwi/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script src="<?= base_url('js/announcements/create.js') ?>"></script>
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

                <form action="<?= route_to('announcements-create') ?>" class="card" method="post">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">

                        <?= view('Pages/Announcement/Partials/form', ['errors' => $errors]) ?>
                        
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Post</button>
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