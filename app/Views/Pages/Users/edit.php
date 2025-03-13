<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
session()->set(['menu' => 'users']);
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'Edit Account';
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

                <form action="<?= route_to('update-user') ?>" class="card" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <!-- User role -->
                        <div class="mb-4">
                            <label class="form-label">Role</label>
                            <select id="role" name="role" class="form-select mt-1 block w-full">
                                <option value="" selected disabled>- Please Select -</option>
                                <?php foreach (UserRole::cases() as $userRole): ?>
                                    <option value="<?= $userRole->value ?>" <?= $userRole->value === $role ? 'selected' : '' ?>>
                                        <?= $userRole->value ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Error Message -->
                            <?php if (isset($errors['role'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['role'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Employee ID -->
                        <div class="mb-3 employee_id_container"
                            style="display: <?= $role === UserRole::EMPLOYEE->value ? 'block' : 'none' ?>;">
                            <label class="form-label required">Employee ID</label>
                            <input type="text" name="employee_id" class="form-control"
                                value="<?= old('employee_id') ?? $employee_id ?>" autocomplete="off" />

                            <!-- Error Message -->
                            <?php if (isset($errors['employee_id'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['employee_id'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- First name -->
                        <div class="mb-3">
                            <label class="form-label required">First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                value="<?= old('first_name') ?? $first_name ?>" autocomplete="off" />

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
                            <input type="text" name="middle_name" class="form-control"
                                value="<?= old('middle_name') ?? $middle_name ?>" autocomplete="off" />
                        </div>
                        <!-- Last name -->
                        <div class="mb-3">
                            <label class="form-label required">Last Name</label>
                            <input type="text" name="last_name" class="form-control"
                                value="<?= old('last_name') ?? $last_name ?>" autocomplete="off" />

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
                            <label class="form-label required">Email</label>
                            <input type="text" name="email" class="form-control" value="<?= old('email') ?? $email ?>"
                                autocomplete="off" />

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
                            <label class="form-label required">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control toggle-password"
                                autocomplete="off" />

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
<script>
    const employeeRole = '<?= UserRole::EMPLOYEE->value ?>';
</script>
<?= $this->endSection() ?>