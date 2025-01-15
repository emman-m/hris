<?php

use App\Enums\UserRole;
use App\Enums\EmployeeStatus;
session()->set(['menu' => 'users']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

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
                    Create User
                </h2>
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
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <!-- Last Name -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Family Name</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Given Name</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Middle Name</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Date of Birth</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Place of Birth</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Gender</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Status</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Spouse Name</label>
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
                            <div class="col-12">
                                <!-- Permanent Address -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Permanent Address</label>
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
                            <div class="col-12">
                                <!-- Present Address -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Present Address</label>
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
                                    <label class="block text-gray-700 font-bold mb-2">Father's Name</label>
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
                                        <label class="block text-gray-700 font-bold mb-2">Mother's Name</label>
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
                                            <label class="block text-gray-700 font-bold mb-2">Mother's Maiden Name</label>
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
                        
                        <!-- Contact Number -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control mt-1 block w-full" value="<?= old('contact_number') ?>"
                                autocomplete="off">
                            <!-- Error Message -->
                            <?php if (isset($errors['contact_number'])): ?>
                                <div class="text-red-500 text-sm mt-1">
                                    <?= $errors['contact_number'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr>
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
                                            class="icon">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                            </path>
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
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>