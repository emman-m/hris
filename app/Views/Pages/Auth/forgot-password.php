<?php

// Set errors variable
$errors = session()->get('errors');
?>

<?= $this->extend('GuessLayout/main') ?>

<?= $this->section('title') ?>
Forgot Password
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
                <h2 class="h2 text-center mb-4">Forgot Password</h2>

                <!-- Validation messages -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('forgot-password') ?>" method="post" autocomplete="off" novalidate="">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="your@email.com"
                            value="<?= esc(set_value('email')) ?>" autocomplete="off">
                        <!-- Error Message -->
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback d-block">
                                <?= $errors['email'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <a href="<?= route_to('login') ?>">Login</a>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Send Verification Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>