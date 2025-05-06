<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
session()->set(['menu' => 'attendance']);

$pageTitle = 'Attendance';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $pageTitle ?>
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('header-script') ?>
<link rel="stylesheet" href="<?= base_url('jquery/css/jquery-ui.css') ?>">
<link rel="stylesheet" href="<?= base_url('jquery/css/dark-datepicker.css') ?>" id="dark-theme" disabled>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('footer-script') ?>
<!-- Print js -->
<script src="<?= base_url('js/attendance/index.js') ?>"></script>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <?= $pageTitle ?>
                </h2>
            </div>
            <!-- Create new user button -->
            <?php if (session()->get('role') !== UserRole::EMPLOYEE->value): ?>
                <div class="col-auto ms-auto">
                    <a href="<?= route_to('attendance-create'); ?>" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Import Attendance
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="<?= current_url() ?>" class="row g-3">
                            <!-- Date Range -->
                            <div class="col-md-2">
                                <input type="text" id="from" name="from" class="form-control block w-full"
                                    placeholder="Date From" value="<?= service('request')->getGet('from') ?>" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="to" name="to" class="form-control block w-full"
                                    placeholder="Date To" value="<?= service('request')->getGet('from') ?>" />
                            </div>
                            <!-- Employee/Employee ID key -->
                            <?php if (session()->get('role') !== UserRole::EMPLOYEE->value): ?>
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        value="<?= service('request')->getGet('search') ?>"
                                        placeholder="Search by Employee Name or ID">
                                </div>
                            <?php endif; ?>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-12">
                <div class="col-auto ms-auto">
                    <!-- Download CSV -->
                    <a href="<?= route_to('attendance-download') . '?' . http_build_query($_GET) ?>"
                        class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                        CSV
                    </a>
                    <!-- Add Print Button -->
                    <button id="printButton" class="btn btn-outline-primary"
                        data-url="<?= route_to('attendance-print') ?>" title="Print">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                        </svg>
                        Print
                    </button>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Date</th>
                                    <th>Time In/Out</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $item): ?>
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <?= $item['name'] ?? 'Not registered' ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['employee_id'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['transaction_date'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['time_in'] . ' - ' . $item['time_out'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['machine'] . ' - ' . $item['remark'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($data)): ?>
                                    <tr>
                                        <td colspan="4" style="text-align:center">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <?= $paginationInfo['start'] ?> to <?= $paginationInfo['end'] ?> of
                            <?= $paginationInfo['totalItems'] ?>
                            entries
                        </p>
                        <?= $pager->links('default', 'custom_pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>