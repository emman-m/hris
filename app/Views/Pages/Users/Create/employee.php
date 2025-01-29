<?php

use App\Enums\AffiliationType;
use App\Enums\EducationLevel;
use App\Enums\UserRole;
use App\Enums\EmployeeStatus;
session()->set(['menu' => 'users']);
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
                        <!-- Step 1 -->
                        <div class="step-form step1">
                            <h2>Personal Information</h2>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <!-- Last Name -->
                                    <div class="mb-4">
                                        <label class="form-label required">Family Name</label>
                                        <input type="text" name="ui_last_name" class="form-control mt-1 block w-full" value="<?= old('ui_last_name') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ui_last_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ui_last_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- First Name -->
                                    <div class="mb-4">
                                        <label class="form-label required">Given Name</label>
                                        <input type="text" name="ui_first_name" class="form-control mt-1 block w-full" value="<?= old('ui_first_name') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ui_first_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ui_first_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- Middle Name -->
                                    <div class="mb-4">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" name="ui_middle_name" class="form-control mt-1 block w-full" value="<?= old('ui_middle_name') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ui_middle_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ui_middle_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <!-- Date of Birth -->
                                    <div class="mb-4">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="ei_date_of_birth" class="form-control mt-1 block w-full" value="<?= old('ei_date_of_birth') ?>"
                                                    autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_date_of_birth'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_date_of_birth'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Place of Birth -->
                                    <div class="mb-4">
                                        <label class="form-label">Place of Birth</label>
                                        <input type="text" name="ei_birth_place" class="form-control mt-1 block w-full" value="<?= old('ei_birth_place') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_birth_place'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_birth_place'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Gender -->
                                    <div class="mb-4">
                                        <label class="form-label">Gender</label>
                                        <select name="ei_gender" class="form-select mt-1 block w-full">
                                            <option value="" selected disabled>- Please Select -</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_gender'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_gender'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Status -->
                                    <div class="mb-4">
                                        <label class="form-label">Status</label>
                                        <select id="ei_status" name="ei_status" class="form-select mt-1 block w-full">
                                            <option value="" selected disabled>- Please Select -</option>
                                            <?php foreach (EmployeeStatus::cases() as $status): ?>
                                                <option
                                                    value="<?= $status->value ?>"
                                                    <?= $status->value === old('ei_status') ? 'selected' : ''?>>
                                                <?= $status->value ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_status'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_status'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-4 spouse-div" style="display:none">
                                    <!-- Spouse -->
                                    <div class="mb-4">
                                        <label class="form-label">Spouse Name</label>
                                        <input type="text" name="ei_spouse" class="form-control mt-1 block w-full" value="<?= old('ei_spouse') ?>"
                                        autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_spouse'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_spouse'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <!-- Permanent Address -->
                                    <div class="mb-4">
                                        <label class="form-label">Permanent Address</label>
                                        <input type="text" name="ei_permanent_address" class="form-control mt-1 block w-full"
                                            value="<?= old('ei_permanent_address') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_permanent_address'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_permanent_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <!-- Present Address -->
                                    <div class="mb-4">
                                        <label class="form-label">Present Address</label>
                                        <input type="text" name="ei_present_address" class="form-control mt-1 block w-full"
                                            value="<?= old('ei_present_address') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_present_address'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_present_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <!-- Father's Name -->
                                    <div class="mb-4">
                                        <label class="form-label">Father's Name</label>
                                        <input type="text" name="ei_fathers_name" class="form-control mt-1 block w-full"
                                            value="<?= old('ei_fathers_name') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_fathers_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_fathers_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <!-- Mother's Name -->
                                            <div class="mb-4">
                                                <label class="form-label">Mother's Name</label>
                                                <input type="text" name="ei_mothers_name" class="form-control mt-1 block w-full"
                                                    value="<?= old('ei_mothers_name') ?>" autocomplete="off">
                                                <!-- Error Message -->
                                                <?php if (isset($errors['ei_mothers_name'])): ?>
                                                    <div class="text-red-500 text-sm mt-1">
                                                        <?= $errors['ei_mothers_name'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <!-- Mother's Maiden Name -->
                                            <div class="mb-4">
                                                <label class="form-label">Mother's Maiden Name</label>
                                                <input type="text" name="ei_mothers_maiden_name" class="form-control mt-1 block w-full"
                                                    value="<?= old('ei_mothers_maiden_name') ?>" autocomplete="off">
                                                <!-- Error Message -->
                                                <?php if (isset($errors['ei_mothers_maiden_name'])): ?>
                                                    <div class="text-red-500 text-sm mt-1">
                                                        <?= $errors['ei_mothers_maiden_name'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <!-- Religion -->
                                    <div class="mb-4">
                                        <label class="form-label">Religion</label>
                                        <input type="text" name="ei_religion" class="form-control mt-1 block w-full" value="<?= old('ei_religion') ?>"
                                                autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_religion'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_religion'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Tel No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Tel No.</label>
                                        <input type="text" name="ei_tel" class="form-control mt-1 block w-full" value="<?= old('ei_tel') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_tel'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_tel'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Phone No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Phone No.</label>
                                        <input type="text" name="ei_phone" class="form-control mt-1 block w-full" value="<?= old('ei_phone') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_phone'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_phone'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Nationality -->
                                    <div class="mb-4">
                                        <label class="form-label">Nationality</label>
                                        <input type="text" name="ei_nationality" class="form-control mt-1 block w-full" value="<?= old('ei_nationality') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_nationality'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_nationality'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <!-- SSS No -->
                                    <div class="mb-4">
                                        <label class="form-label">SSS No</label>
                                        <input type="text" name="ei_sss" class="form-control mt-1 block w-full" value="<?= old('ei_sss') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_sss'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_sss'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <!-- Date of Coverage -->
                                    <div class="mb-4">
                                        <label class="form-label">SSS Date of Coverage</label>
                                        <input type="date" name="ei_date_of_coverage" class="form-control mt-1 block w-full" value="<?= old('ei_date_of_coverage') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_date_of_coverage'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_date_of_coverage'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Pag-ibig MID No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Pag-ibig MID No.</label>
                                        <input type="text" name="ei_pagibig" class="form-control mt-1 block w-full" value="<?= old('ei_pagibig') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_pagibig'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_pagibig'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- TIN No. -->
                                    <div class="mb-4">
                                        <label class="form-label">TIN No.</label>
                                        <input type="text" name="ei_tin" class="form-control mt-1 block w-full" value="<?= old('ei_tin') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_tin'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_tin'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-3">
                                    <!-- Philhealth No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Philhealth No.</label>
                                        <input type="text" name="ei_philhealth" class="form-control mt-1 block w-full" value="<?= old('ei_philhealth') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_philhealth'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_philhealth'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <!-- Res Cert No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Res Cert No.</label>
                                        <input type="text" name="ei_res_cert_no" class="form-control mt-1 block w-full" value="<?= old('ei_res_cert_no') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_res_cert_no'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_res_cert_no'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Issued on -->
                                    <div class="mb-4">
                                        <label class="form-label">Issued On</label>
                                        <input type="date" name="ei_res_issued_on" class="form-control mt-1 block w-full" value="<?= old('ei_res_issued_on') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_res_issued_on'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_res_issued_on'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Issued At -->
                                    <div class="mb-4">
                                        <label class="form-label">Issued At</label>
                                        <input type="date" name="ei_res_issued_at" class="form-control mt-1 block w-full" value="<?= old('ei_res_issued_at') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_res_issued_at'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_res_issued_at'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <!-- Contact Person in Case of Emergency -->
                                    <div class="mb-4">
                                        <label class="form-label">Contact Person in Case of Emergency</label>
                                        <input type="text" name="ei_contact_person" class="form-control mt-1 block w-full" value="<?= old('ei_contact_person') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_contact_person'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_contact_person'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- Contact No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Contact No.</label>
                                        <input type="text" name="ei_contact_person_no" class="form-control mt-1 block w-full" value="<?= old('ei_contact_person_no') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_contact_person_no'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_contact_person_no'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- Relationship -->
                                    <div class="mb-4">
                                        <label class="form-label">Relationship</label>
                                        <input type="text" name="ei_contact_person_relation" class="form-control mt-1 block w-full" value="<?= old('ei_contact_person_relation') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_contact_person_relation'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_contact_person_relation'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <!-- Year Employed in LCCT -->
                                    <div class="mb-4">
                                        <label class="form-label">Year Employed in LCCT</label>
                                        <input type="date" name="ei_employment_date" class="form-control mt-1 block w-full" value="<?= old('ei_employment_date') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['ei_employment_date'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['ei_employment_date'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-12">
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label required">Email</label>
                                        <input type="text" name="u_email" class="form-control" value="<?= old('u_email') ?>" autocomplete="off" />
                            
                                        <!-- Error Message -->
                                        <?php if (isset($errors['u_email'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['u_email'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label class="form-label required">Password</label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="u_password" class="form-control toggle-password">
                                            <span class="input-group-text">
                                                <a href="javascript:void(0)" class="link-secondary" id="togglePassword" data-bs-toggle="tooltip"
                                                    aria-label="Show/Hide" data-bs-original-title="Show/Hide">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye-closed">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
                                                        <path d="M3 15l2.5 -3.8" />
                                                        <path d="M21 14.976l-2.492 -3.776" />
                                                        <path d="M9 17l.5 -4" />
                                                        <path d="M15 17l-.5 -4" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                            
                                        <!-- Error Message -->
                                        <?php if (isset($errors['u_password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['u_password'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Confirm Password -->
                                    <div class="mb-3">
                                        <label class="form-label required">Confirm Password</label>
                                        <input type="password" name="u_confirm_password" class="form-control toggle-password" autocomplete="off" />
                            
                                        <!-- Error Message -->
                                        <?php if (isset($errors['u_confirm_password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['u_confirm_password'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Step 2 -->
                        <div class="step-form step2">
                            <h2>Education</h2>
                            <div class="row">
                                <!-- Elementary -->
                                <h4>Elementary</h4>
                                <div class="row mb-3">
                                    <input type="hidden" name="e_level[]" value="<?= EducationLevel::ELEMENTARY->value?>">
                                    <div class="col-md-6">
                                        <label class="form-label">School/Address</label>
                                        <input type="text" name="e_school_address[]" class="form-control"
                                            value="<?= old('e_school_address') ?>"
                                            placeholder="Enter school and address" />

                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_school_address'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_school_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Year Graduated</label>
                                        <input type="date" name="e_year_graduated[]" class="form-control" 
                                            value="<?= old('e_year_graduated') ?>"/>
                                        
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_year_graduated'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_year_graduated'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <hr>
                                <!-- High School -->
                                <h4>High School</h4>
                                <div class="row mb-3">
                                    <input type="hidden" name="e_level[]" value="<?= EducationLevel::HIGHSCHOOL->value ?>">
                                    <div class="col-md-6">
                                        <label class="form-label">School/Address</label>
                                        <input type="text" name="e_school_address[]" class="form-control"
                                            value="<?= old('e_school_address') ?>"
                                            placeholder="Enter school and address" />
                                    
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_school_address'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_school_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Year Graduated</label>
                                        <input type="date" name="e_year_graduated[]" class="form-control" 
                                            value="<?= old('e_year_graduated') ?>" />
                                    
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_year_graduated'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_year_graduated'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <hr>
                                <!-- Undergraduate -->
                                <h4>Undergraduate</h4>
                                <div class="row mb-3">
                                    <input type="hidden" name="e_level[]" value="<?= EducationLevel::UNDERGRADUATE->value ?>">
                                    <div class="col-md-4">
                                        <label class="form-label">Degree</label>
                                        <input type="text" name="e_degree[]" class="form-control"
                                            value="<?= old('e_degree')?>"
                                            placeholder="Enter degree" />

                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_degree'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_degree'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Major/Minor</label>
                                        <input type="text" name="e_major_minor[]" class="form-control"
                                            value="<?= old('e_major_minor') ?>"
                                            placeholder="Enter major/minor" />
                                        
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_major_minor'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_major_minor'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">School/Address</label>
                                        <input type="text" name="e_school_address[]" class="form-control"
                                            value="<?= old('e_school_address') ?>"
                                            placeholder="Enter school and address" />
                                        
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_school_address'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_school_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Year Graduated</label>
                                        <input type="date" name="e_year_graduated[]" class="form-control"
                                            value="<?= old('e_year_graduated') ?>"/>

                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_year_graduated'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_year_graduated'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <hr>
                                <!-- Graduate -->
                                <h4>Graduate</h4>
                                <div class="row mb-3">
                                    <input type="hidden" name="e_level[]" value="<?= EducationLevel::GRADUATE->value ?>">
                                    <div class="col-md-4">
                                        <label class="form-label">Degree</label>
                                        <input type="text" name="e_degree[]" class="form-control"
                                            value="<?= old('e_degree') ?>"
                                            placeholder="Enter degree" />
                                        
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_degree'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_degree'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Major/Minor</label>
                                        <input type="text" name="e_major_minor[]" class="form-control"
                                            value="<?= old('e_major_minor') ?>"
                                            placeholder="Enter major/minor" />

                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_major_minor'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_major_minor'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">School/Address</label>
                                        <input type="text" name="e_school_address[]" class="form-control"
                                            value="<?= old('e_school_address') ?>"
                                            placeholder="Enter school and address" />
                                        
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_school_address'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_school_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Year Graduated</label>
                                        <input type="date" name="e_year_graduated[]" class="form-control"
                                            value="<?= old('e_year_graduated') ?>"/>

                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_year_graduated'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_year_graduated'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <hr>
                                <!-- Post Graduate -->
                                <h4>
                                    Post Graduate<br>
                                    <small>Please indicate the number of units earned in your post-graduate course</small>
                                </h4>
                                <div class="row mb-3">
                                    <input type="hidden" name="e_level[]" value="<?= EducationLevel::POSTGRADUATE->value ?>">
                                    <div class="col-md-4">
                                        <label class="form-label">Degree</label>
                                        <input type="text" name="e_degree[]" class="form-control"
                                            value="<?= old('e_degree') ?>"
                                            placeholder="Enter degree" />

                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_degree'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_degree'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">Major/Minor</label>
                                        <input type="text" name="e_major_minor[]" class="form-control"
                                            value="<?= old('e_major_minor') ?>"
                                            placeholder="Enter major/minor" />
                                        
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_major_minor'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_major_minor'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">School/Address</label>
                                        <input type="text" name="e_school_address[]" class="form-control"
                                            value="<?= old('e_school_address') ?>"
                                            placeholder="Enter school and address" />
                                        
                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_school_address'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_school_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Year Graduated</label>
                                        <input type="date" name="e_year_graduated[]" class="form-control"
                                            value="<?= old('e_year_graduated') ?>" />

                                        <!-- Error Message -->
                                        <?php if (isset($errors['e_year_graduated'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['e_year_graduated'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Step 3 -->
                        <div class="step-form step3">
                            <h2>Dependents/Beneficiaries</h2>

                            <div class="row">
                                <div id="beneficiariesContainer">
                                    <!-- Beneficiary Row Template -->
                                    <div class="beneficiary-row row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="d_name[]" class="form-control" placeholder="Enter name" />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" name="d_birth[]" class="form-control" />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Relationship to Employee</label>
                                            <input type="text" name="d_relationship[]" class="form-control" placeholder="Enter relationship" />
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <!-- Remove button -->
                                            <button type="button" class="btn btn-danger remove-beneficiary" disabled>
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <!-- Add Button -->
                                    <button type="button" id="addBeneficiary" class="btn btn-primary">
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

                            <h2>Previous Employement History</h2>
                            <div class="row">
                                <div id="employmentContainer">
                                    <!-- Employment Row Template -->
                                    <div class="employment-row row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Institution/Company</label>
                                            <input type="text" name="eh_name[]" class="form-control" placeholder="Enter institution/company" />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Position</label>
                                            <input type="text" name="eh_position[]" class="form-control" placeholder="Enter position" />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Inclusive Years</label>
                                            <input type="text" name="eh_inclusive_year[]" class="form-control" placeholder="Enter inclusive years" />
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <!-- Remove button -->
                                            <button type="button" class="btn btn-danger remove-employment" disabled>
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <!-- Add button -->
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

                            <h2>Affiliation in Professional Organization</h2>
                            <div class="row">
                                <div id="affiliationProContainer">
                                    <div class="affiliation-pro-row row mb-3">
                                        <input type="hidden" name="type[]" value="<?= AffiliationType::PROFESSIONAL->value?>">
                                        <div class="col-md-6">
                                            <label class="form-label">Name of Organization</label>
                                            <input type="text" name="a_p_name[]" class="form-control" placeholder="Enter Name of Organization" />
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Position</label>
                                            <input type="text" name="a_p_position[]" class="form-control" placeholder="Enter position" />
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <!-- Remove button -->
                                            <button type="button" class="btn btn-danger remove-affiliation-pro" disabled>
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <!-- Add button -->
                                    <button type="button" id="addAffiliationPro" class="btn btn-primary">
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

                            <h2>Affiliation in Socio-Civic Organization</h2>
                            <div class="row">
                                <div id="affiliationSocioContainer">
                                    <div class="affiliation-socio-row row mb-3">
                                        <input type="hidden" name="type[]" value="<?= AffiliationType::SOCIOCIVIC->value ?>">
                                        <div class="col-md-6">
                                            <label class="form-label">Name of Organization</label>
                                            <input type="text" name="a_s_name[]" class="form-control" placeholder="Enter Name of Organization" />
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Position</label>
                                            <input type="text" name="a_s_position[]" class="form-control" placeholder="Enter position" />
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <!-- Remove button -->
                                            <button type="button" class="btn btn-danger remove-affiliation-socio" disabled>
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
                                </div>
                            
                                <div class="d-flex justify-content-between mt-4">
                                    <!-- Add button -->
                                    <button type="button" id="addAffiliationSocio" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="step-form step4">
                            <h2>Licensure/Government Exam Passed</h2>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Institution/Company</label>
                                    <input type="text" name="eh_name[]" class="form-control" placeholder="Enter institution/company" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Position</label>
                                    <input type="text" name="eh_position[]" class="form-control" placeholder="Enter position" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Inclusive Years</label>
                                    <input type="text" name="eh_inclusive_year[]" class="form-control" placeholder="Enter inclusive years" />
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <!-- Remove button -->
                                    <button type="button" class="btn btn-danger remove-employment" disabled>
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
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