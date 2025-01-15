<?php

use App\Enums\UserRole;
session()->set(['menu' => 'users']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
Users
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
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('hris/create-user') ?>">
                            <!-- User Type -->
                            <div class="mb-3">
                                <div class="form-label">Select User Type</div>
                                <div>
                                    <?php foreach (UserRole::cases() as $role): ?>
                                        <label class="form-check">
                                            <input class="form-check-input" type="radio" name="role" value="<?= $role->value; ?>" />
                                            <span
                                                class="form-check-label"><?= $role->value; ?>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>