<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
session()->set(['menu' => 'users']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
Users
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/users/index.js') ?>"></script>
<script src="<?= base_url('js/users/switch.js') ?>"></script>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Users
                </h2>
            </div>
            <!-- Create new user button -->
            <div class="col-auto ms-auto">
                <a href="<?= route_to('create-user'); ?>" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Create User
                </a>
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
                            <!-- User Role -->
                            <div class="col-md-4">
                                <select name="role" class="form-select">
                                    <option value="">All Roles</option>
                                    <?php foreach (UserRole::cases() as $role): ?>
                                        <option value="<?= $role->value ?>"
                                            <?= (service('request')->getGet('role') == $role->value) ? 'selected' : '' ?>>
                                            <?= $role->value ?>
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
                                    placeholder="Search by name or email">
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
                    <a href="<?= route_to('users-download') . '?' . http_build_query($_GET) ?>" class="btn btn-primary">
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
                    <button id="printButton" class="btn btn-outline-primary" data-url="<?= route_to('users-print') ?>"
                        title="Print">
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
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $item): ?>
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <label class="form-check form-switch d-inline-block m-0">
                                                <input type="checkbox" class="form-check-input status-switch" data-url="<?= route_to('user-update-status')?>" data-id="<?= $item['user_id'] ?>"
                                                    <?= $item['status'] === UserStatus::ACTIVE->value ? 'checked' : '' ?> />
                                            </label>

                                            <?= $item['name'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['email'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?= $item['role'] ?>
                                        </td>
                                        <td>
                                            <a href="<?= route_to('edit-users', $item['user_id']) ?>">Edit</a>
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