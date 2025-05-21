<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserStatus;
session()->set(['menu' => 'employees']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
Employees
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/employees/index.js') ?>"></script>
<script src="<?= base_url('js/employees/lock_employee.js') ?>"></script>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Employees
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
                        <form method="get" action="<?= current_url() ?>" class="row g-3">
                            <!-- Department -->
                            <div class="col-md-4">
                                <select name="department" class="form-select">
                                    <option value="">All Department</option>
                                    <?php foreach (EmployeeDepartment::cases() as $department): ?>
                                        <option value="<?= $department->value ?>"
                                            <?= (service('request')->getGet('department') == $department->value) ? 'selected' : '' ?>>
                                            <?= $department->value ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- User Status -->
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <?php foreach (UserStatus::cases() as $role): ?>
                                        <option value="<?= $role->value ?>"
                                            <?= (service('request')->getGet('status') == $role->value) ? 'selected' : '' ?>>
                                            <?= $role->value ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Name Email key -->
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    value="<?= service('request')->getGet('search') ?>"
                                    placeholder="Search by employee id, name or email">
                            </div>
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
                    <a href="<?= route_to('employees-download') . '?' . http_build_query($_GET) ?>"
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
                        data-url="<?= route_to('employees-print') ?>" title="Print">
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
                                    <th>Name</th>
                                    <th>Employee ID</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $item): ?>
                                    <tr>
                                        <td>
                                            <span
                                                class="badge bg-<?= $item['status'] === 'Active' ? 'green' : 'red' ?> badge-information"></span>
                                            <?= $item['name'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['employee_id'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['email'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['department'] ?>
                                        </td>
                                        <td class="d-flex gap-2">
                                            <!-- files -->
                                            <a href="<?= route_to('files', $item['user_id']) ?>">Files</a>
                                            |
                                            <!-- Edit information -->
                                            <a href="<?= route_to('employees-edit', $item['user_id']) ?>">Edit</a>
                                            |
                                            <!-- Lock/Unlock editing informations -->
                                            <a href="javascript:void(0)" class="lock-unlock-employee"
                                                data-id="<?= $item['user_id'] ?>"
                                                data-url="<?= route_to('employees-lock-info') ?>"
                                                data-state="<?= $item['is_locked'] ?? 0 ?>">
                                                <?= $item['is_locked'] ? 'Unlock' : 'Lock' ?>
                                            </a>
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