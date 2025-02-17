<?php

use App\Enums\UserRole;
if (session()->get('role') === UserRole::EMPLOYEE->value) {
    session()->set(['menu' => 'files']);
} else {
    session()->set(['menu' => 'employees']);
}


// page title
$title = 'Files';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>

<?= $this->endSection() ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

hey
<?= $this->endSection() ?>