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
                <div class="col-auto ms-auto">
                    <!-- Print Form -->
                    <a class="btn btn-outline-primary" href="<?= route_to('employees-show', $user_id) ?>" target="_blank" title="Print">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                        </svg>
                        Print
                    </a>
                </div>
            </div>
            <div class="col-12">

                <form action="<?= route_to('employees-update') ?>" class="card" method="post">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <!-- User role -->
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">

                    <?= view('Pages/Employees/Partials/employees_form', ['form' => $form, 'errors' => $errors]) ?>


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