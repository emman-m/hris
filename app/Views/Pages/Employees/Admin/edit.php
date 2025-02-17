<?php

use App\Enums\AffiliationType;
use App\Enums\EducationLevel;
use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
use App\Enums\EmployeeStatus;
session()->set(['menu' => 'employees']);

$form = session()->get('form');
$errors = session()->get('errors');

$pageTitle = 'Update Employee';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/togglepassword.js') ?>"></script>
<script src="<?= base_url('js/users/employee.js') ?>"></script>
<?= $this->endSection() ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $pageTitle ?>
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
        <div class="row my-3">
            <!-- Stepper -->
            <div class="col-12">
                <div class="steps steps-counter">
                    <a href="#" class="step-item active"></a>
                    <span href="#" class="step-item"></span>
                    <span href="#" class="step-item"></span>
                    <span href="#" class="step-item"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">

                <form action="<?= route_to('employees-update') ?>" class="card" method="post">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <!-- User role -->
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">

                    <?= view('Pages/Employees/Partials/employees_form', ['form' => $form, 'errors' => $errors])?>


                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" id="back-form" class="btn btn-light" data-form="2">Back</button>
                        <div>
                            <button type="submit" class="btn btn-primary">Save Employee</button>
                            <button type="button" id="next-form" class="btn btn-light" data-form="2">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const employeeStatus = '<?= EmployeeStatus::MARRIED->value ?>'
</script>
<?= $this->endSection() ?>