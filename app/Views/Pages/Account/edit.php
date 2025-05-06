<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
session()->set(['menu' => '']);
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'My Account';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/togglepassword.js') ?>"></script>
<script src="<?= base_url('js/users/create.js') ?>"></script>
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
                    <?= $title ?> <?= $is_locked ? '(Locked)' : '' ?>
                </h2>
                <?= $is_locked ? '<cite>This page is currently locked for editing. Please reach out to the admin for further assistance.</cite>' : '' ?>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">

                <form action="<?= route_to('my-account-save') ?>" class="card" method="post">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <?php if (session()->has('employee_id')): ?>
                            <!-- Employee ID -->
                            <div class="mb-3">
                                <label class="form-label">Employee ID</label>
                                <input type="text" name="employee_id" class="form-control" value="<?= old('employee_id') ?>"
                                    autocomplete="off" readonly />
                            </div>
                        <?php endif; ?>
                        <!-- First name -->
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?= old('first_name') ?>"
                                autocomplete="off" <?= $is_locked ? 'disabled' : '' ?> />

                            <!-- Error Message -->
                            <?php if (isset($errors['first_name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['first_name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Middle name -->
                        <div class="mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="<?= old('middle_name') ?>"
                                autocomplete="off" <?= $is_locked ? 'disabled' : '' ?> />
                        </div>
                        <!-- Last name -->
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?= old('last_name') ?>"
                                autocomplete="off" <?= $is_locked ? 'disabled' : '' ?> />

                            <!-- Error Message -->
                            <?php if (isset($errors['last_name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['last_name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" value="<?= old('email') ?>"
                                autocomplete="off" <?= session()->get('role') === UserRole::EMPLOYEE->value ? 'readonly' : '' ?> />
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control toggle-password"
                                    <?= $is_locked ? 'disabled' : '' ?>>
                                <span class="input-group-text">
                                    <a href="javascript:void(0)" class="link-secondary" id="togglePassword"
                                        data-bs-toggle="tooltip" aria-label="Show/Hide"
                                        data-bs-original-title="Show/Hide">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
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
                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control toggle-password"
                                autocomplete="off" <?= $is_locked ? 'disabled' : '' ?> />

                            <!-- Error Message -->
                            <?php if (isset($errors['confirm_password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['confirm_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <?php if (!$is_locked): ?>
                            <button type="submit" class="btn btn-primary">Save</button>
                        <?php endif; ?>
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