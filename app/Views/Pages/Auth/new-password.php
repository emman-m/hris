<?php

// Set errors variable
$errors = session()->get('errors');
?>

<?= $this->extend('GuessLayout/main') ?>

<?= $this->section('title') ?>
New Password
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark">
                <img src="<?= base_url('assets/img/logo.png') ?>" width="80" alt="Tabler logo">
                <span class="h1" style="text-wrap: auto">La Consolacion College Tanauan - HRMS</span>
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Change Password</h2>

                <!-- Validation messages -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('new-password') ?>" method="post" autocomplete="off" novalidate="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="email" value="<?= esc($email) ?>">
                    <input type="hidden" name="code" value="<?= esc($code) ?>">
                    <div class="mb-2">
                        <label class="form-label">New Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="password" class="form-control toggle-password">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" class="link-secondary" id="togglePassword"
                                    data-bs-toggle="tooltip" aria-label="Show/Hide" data-bs-original-title="Show/Hide">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
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

                    <div class="mb-2">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="confirm_password" class="form-control toggle-password">
                            <!-- Error Message -->
                            <?php if (isset($errors['confirm_password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['confirm_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>