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
$title = 'Edit File';
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
                    <a href="javascript:history.back()" class="d-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left align-middle">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                    </a>
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

                <form action="<?= route_to('files-update') ?>" class="card" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">

                        <!-- ID -->
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <!-- Upload form -->
                        <?= view('Pages/Files/Partials/upload_form', ['errors' => $errors, 'file_name' => $file_name]) ?>
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