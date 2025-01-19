<?php

use App\Enums\UserRole;
use App\Enums\EmployeeStatus;
session()->set(['menu' => 'users']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/togglepassword.js') ?>"></script>
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
                    <input type="hidden" name="role" value="<?= UserRole::HR_ADMIN->value ?>">

                    <div class="card-body">
                        <!-- Step 1 -->
                        <div class="step1">
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <!-- Last Name -->
                                    <div class="mb-4">
                                        <label class="form-label required">Family Name</label>
                                        <input type="text" name="last_name" class="form-control mt-1 block w-full" value="<?= old('last_name') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['last_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['last_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- First Name -->
                                    <div class="mb-4">
                                        <label class="form-label required">Given Name</label>
                                        <input type="text" name="first_name" class="form-control mt-1 block w-full" value="<?= old('first_name') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['first_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['first_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- Middle Name -->
                                    <div class="mb-4">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control mt-1 block w-full" value="<?= old('middle_name') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['middle_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['middle_name'] ?>
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
                                        <input type="date" name="date_of_birth" class="form-control mt-1 block w-full" value="<?= old('date_of_birth') ?>"
                                                    autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['date_of_birth'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['date_of_birth'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Place of Birth -->
                                    <div class="mb-4">
                                        <label class="form-label">Place of Birth</label>
                                        <input type="text" name="birth_place" class="form-control mt-1 block w-full" value="<?= old('birth_place') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['birth_place'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['birth_place'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Gender -->
                                    <div class="mb-4">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select mt-1 block w-full">
                                            <option value="" selected disabled>- Please Select -</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <!-- Error Message -->
                                        <?php if (isset($errors['gender'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['gender'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Status -->
                                    <div class="mb-4">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select mt-1 block w-full">
                                            <option value="" selected disabled>- Please Select -</option>
                                            <?php foreach (EmployeeStatus::cases() as $status): ?>
                                                <option value="<?= $status->name ?>"><?= $status->value ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Error Message -->
                                        <?php if (isset($errors['status'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['status'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Row -->
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <!-- Spouse -->
                                    <div class="mb-4">
                                        <label class="form-label">Spouse Name</label>
                                        <input type="text" name="spouse" class="form-control mt-1 block w-full" value="<?= old('spouse') ?>"
                                        autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['spouse'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['spouse'] ?>
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
                                        <input type="text" name="permanent_address" class="form-control mt-1 block w-full"
                                            value="<?= old('permanent_address') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['permanent_address'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['permanent_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <!-- Present Address -->
                                    <div class="mb-4">
                                        <label class="form-label">Present Address</label>
                                        <input type="text" name="present_address" class="form-control mt-1 block w-full"
                                            value="<?= old('present_address') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['present_address'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['present_address'] ?>
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
                                        <input type="text" name="fathers_name" class="form-control mt-1 block w-full"
                                            value="<?= old('fathers_name') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['fathers_name'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['fathers_name'] ?>
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
                                                <input type="text" name="mothers_name" class="form-control mt-1 block w-full"
                                                    value="<?= old('mothers_name') ?>" autocomplete="off">
                                                <!-- Error Message -->
                                                <?php if (isset($errors['mothers_name'])): ?>
                                                    <div class="text-red-500 text-sm mt-1">
                                                        <?= $errors['mothers_name'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <!-- Mother's Maiden Name -->
                                            <div class="mb-4">
                                                <label class="form-label">Mother's Maiden Name</label>
                                                <input type="text" name="mothers_maiden_name" class="form-control mt-1 block w-full"
                                                    value="<?= old('mothers_maiden_name') ?>" autocomplete="off">
                                                <!-- Error Message -->
                                                <?php if (isset($errors['mothers_maiden_name'])): ?>
                                                    <div class="text-red-500 text-sm mt-1">
                                                        <?= $errors['mothers_maiden_name'] ?>
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
                                        <input type="text" name="religion" class="form-control mt-1 block w-full" value="<?= old('religion') ?>"
                                                autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['religion'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['religion'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Tel No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Tel No.</label>
                                        <input type="text" name="tel" class="form-control mt-1 block w-full" value="<?= old('tel') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['tel'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['tel'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Phone No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Phone No.</label>
                                        <input type="text" name="phone" class="form-control mt-1 block w-full" value="<?= old('phone') ?>" autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['phone'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['phone'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Nationality -->
                                    <div class="mb-4">
                                        <label class="form-label">Nationality</label>
                                        <input type="text" name="nationality" class="form-control mt-1 block w-full" value="<?= old('nationality') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['nationality'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['nationality'] ?>
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
                                        <input type="text" name="sss" class="form-control mt-1 block w-full" value="<?= old('sss') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['sss'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['sss'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <!-- Date of Coverage -->
                                    <div class="mb-4">
                                        <label class="form-label">SSS Date of Coverage</label>
                                        <input type="date" name="date_of_coverage" class="form-control mt-1 block w-full" value="<?= old('date_of_coverage') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['date_of_coverage'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['date_of_coverage'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Pag-ibig MID No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Pag-ibig MID No.</label>
                                        <input type="text" name="pagibig" class="form-control mt-1 block w-full" value="<?= old('pagibig') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['pagibig'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['pagibig'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- TIN No. -->
                                    <div class="mb-4">
                                        <label class="form-label">TIN No.</label>
                                        <input type="text" name="tin" class="form-control mt-1 block w-full" value="<?= old('tin') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['tin'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['tin'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-3">
                                    <!-- Philhealth No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Philhealth No.</label>
                                        <input type="text" name="philhealth" class="form-control mt-1 block w-full" value="<?= old('philhealth') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['philhealth'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['philhealth'] ?>
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
                                        <input type="text" name="res_cert_no" class="form-control mt-1 block w-full" value="<?= old('res_cert_no') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['res_cert_no'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['res_cert_no'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Issued on -->
                                    <div class="mb-4">
                                        <label class="form-label">Issued On</label>
                                        <input type="date" name="res_issued_on" class="form-control mt-1 block w-full" value="<?= old('res_issued_on') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['res_issued_on'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['res_issued_on'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <!-- Issued At -->
                                    <div class="mb-4">
                                        <label class="form-label">Issued At</label>
                                        <input type="date" name="res_issued_at" class="form-control mt-1 block w-full" value="<?= old('res_issued_at') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['res_issued_at'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['res_issued_at'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <!-- Contact Person in Case of Emergency -->
                                    <div class="mb-4">
                                        <label class="form-label">Contact Person in Case of Emergency</label>
                                        <input type="text" name="contact_person" class="form-control mt-1 block w-full" value="<?= old('contact_person') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['contact_person'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['contact_person'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- Contact No. -->
                                    <div class="mb-4">
                                        <label class="form-label">Contact No.</label>
                                        <input type="text" name="contact_person_no" class="form-control mt-1 block w-full" value="<?= old('contact_person_no') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['contact_person_no'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['contact_person_no'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <!-- Relationship -->
                                    <div class="mb-4">
                                        <label class="form-label">Relationship</label>
                                        <input type="text" name="contact_person_relation" class="form-control mt-1 block w-full" value="<?= old('contact_person_relation') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['contact_person_relation'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['contact_person_relation'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <!-- Year Employed in LCCT -->
                                    <div class="mb-4">
                                        <label class="form-label">Year Employed in LCCT</label>
                                        <input type="date" name="employment_date" class="form-control mt-1 block w-full" value="<?= old('employment_date') ?>"
                                            autocomplete="off">
                                        <!-- Error Message -->
                                        <?php if (isset($errors['employment_date'])): ?>
                                            <div class="text-red-500 text-sm mt-1">
                                                <?= $errors['employment_date'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Step 2 -->
                        <div class="step2">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label required">Email</label>
                                        <input type="text" name="email" class="form-control" value="<?= old('email') ?>" autocomplete="off" />
                            
                                        <!-- Error Message -->
                                        <?php if (isset($errors['email'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['email'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label class="form-label required">Password</label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password" class="form-control toggle-password">
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
                                        <?php if (isset($errors['password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['password'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Confirm Password -->
                                    <div class="mb-3">
                                        <label class="form-label required">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control toggle-password" autocomplete="off" />
                            
                                        <!-- Error Message -->
                                        <?php if (isset($errors['confirm_password'])): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $errors['confirm_password'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <!-- <div></div> -->
                        <button type="submit" class="btn btn-primary">Save Employee</button>
                        <button type="submit" class="btn btn-light">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>