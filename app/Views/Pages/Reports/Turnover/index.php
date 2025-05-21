<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
session()->set(['menu' => 'reports-turnover-rate']);

$pageTitle = 'Dashboard';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('apexchart/apexcharts.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Turnover Rate Report
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Month</label>
                        <input type="month" class="form-control" name="month" value="<?= $month ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Department</label>
                        <select class="form-select" name="department">
                            <option value="all">All Departments</option>
                            <?php foreach (EmployeeDepartment::cases() as $dept): ?>
                                <option value="<?= $dept->value ?>" <?= $department == $dept->value ? 'selected' : '' ?>><?= $dept->value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?= view('Pages/Reports/Turnover/chart', ['turnover' => $turnover]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 