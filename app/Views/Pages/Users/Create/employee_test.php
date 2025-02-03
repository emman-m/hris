<?php

use App\Enums\AffiliationType;
use App\Enums\EducationLevel;
use App\Enums\UserRole;
use App\Enums\EmployeeStatus;
session()->set(['menu' => 'users']);

$formData = session()->get('formData');
$errors = session()->get('errors');
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
Create Employee
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Create Employee
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

                <form action="<?= base_url('hris/create-user') ?>" class="card" method="post">
                    <div class="card-status-top bg-primary"></div>
                    <?= csrf_field() ?>
                    <!-- User role -->
                    <input type="hidden" name="role" value="<?= UserRole::EMPLOYEE->value ?>">

                    <div class="card-body">
                        
                        <!-- Step 3 -->
                        <div class="step-form step1">
                            <h2>Dependents/Beneficiaries</h2>

                            <div class="row">
                                <div id="employmentContainer">
                                    <?php
                                    $employments = $formData['eh_name'] ?? [''];
                                    foreach ($employments as $index => $employment): ?>
                                        <div class="employment-row row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Institution/Company</label>
                                                <input type="text" name="eh_name[]" class="form-control" placeholder="Enter institution/company"
                                                    value="<?= isset($formData['eh_name'][$index]) ? esc($formData['eh_name'][$index]) : '' ?>" />
                                                <!-- Error Message -->
                                                <?php if (isset($errors["eh_name.$index"]) && $errors["eh_name.$index"]): ?>
                                                    <div class="invalid-feedback d-block">
                                                        <?= $errors["eh_name.$index"] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Position</label>
                                                <input type="text" name="eh_position[]" class="form-control" placeholder="Enter position"
                                                    value="<?= isset($formData['eh_position'][$index]) ? esc($formData['eh_position'][$index]) : '' ?>" />
                                                <!-- Error Message -->
                                                <?php if (isset($errors["eh_position.$index"]) && $errors["eh_position.$index"]): ?>
                                                    <div class="invalid-feedback d-block">
                                                        <?= $errors["eh_position.$index"] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Inclusive Years</label>
                                                <input type="text" name="eh_inclusive_year[]" class="form-control" placeholder="Enter inclusive years"
                                                    value="<?= isset($formData['eh_inclusive_year'][$index]) ? esc($formData['eh_inclusive_year'][$index]) : '' ?>" />
                                                <!-- Error Message -->
                                                <?php if (isset($errors["eh_inclusive_year.$index"]) && $errors["eh_inclusive_year.$index"]): ?>
                                                    <div class="invalid-feedback d-block">
                                                        <?= $errors["eh_inclusive_year.$index"] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <!-- Remove button -->
                                                <button type="button" class="btn btn-danger remove-employment" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 7l16 0" />
                                                        <path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <!-- Add Button -->
                                    <button type="button" id="addEmployment" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <hr>

                        </div>

                    </div>
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
    const employeeStatus = '<?= EmployeeStatus::MARRIED->name?>'
</script>
<?= $this->endSection() ?>