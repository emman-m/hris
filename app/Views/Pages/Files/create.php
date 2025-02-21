<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
if (session()->get('role') === UserRole::EMPLOYEE->value) {
    session()->set(['menu' => 'my-files']);
} else {
    session()->set(['menu' => 'employees']);
}
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'Upload File';
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

                <form action="<?= route_to('files-save') ?>" class="card" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">

                        <!-- User id -->
                        <input type="hidden" name="user_id" , value="<?= $user_id ?>">
                        <!-- Upload form -->
                        <?= view('Pages/Files/Partials/upload_form', ['errors' => $errors]) ?>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save File</button>
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