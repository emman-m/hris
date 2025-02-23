<?php

use App\Enums\EmployeeStatus;
session()->set(['menu' => 'my-informations']);

$form = session()->get('form');
$errors = session()->get('errors');

$pageTitle = 'Informations';
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
<?= $pageTitle ?>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <?= $pageTitle ?> <?= $is_locked ? '(Locked)' : '' ?>
                </h2>
                <?= $is_locked ? '<cite>This page is currently locked for editing. Please reach out to the admin for further assistance.</cite>' : '' ?>
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

                <form action="<?= route_to('my-informations-update') ?>" class="card" method="post">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>

                    <?= view('Pages/Employees/Partials/employees_form', ['form' => $form, 'errors' => $errors, 'is_locked' => $is_locked]) ?>


                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" id="back-form" class="btn btn-light" data-form="2">Back</button>
                        <div>
                            <?php if (!$is_locked): ?>
                                <button type="submit" class="btn btn-primary">Save</button>
                            <?php endif; ?>
                            <button type="button" id="next-form" class="btn btn-light" data-form="2">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const employeeStatus = '<?= EmployeeStatus::MARRIED->value ?>'
</script>
<?= $this->endSection() ?>