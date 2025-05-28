<?php

use App\Enums\ApproveStatus;
use App\Enums\LeaveType;
use App\Enums\UserRole;
use App\Enums\VLeaveType;
session()->set(['menu' => 'leaves']);

$isEmployee = session()->get('role') === UserRole::EMPLOYEE->value;

$pageTitle = 'Leaves';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $pageTitle ?>
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script>
    const vacationLeave = '<?= LeaveType::VACATION_LEAVE->value; ?>';
</script>
<script src="<?= base_url('js/leave/index.js') ?>"></script>
<script src="<?= base_url('js/leave/data-delete.js') ?>"></script>
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
            <div class="col-auto ms-auto">
                <a href="<?= route_to('leaves-create'); ?>" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Apply Leave
                </a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <?php if (session()->get('isDepartmentHead')): ?>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="btn-group w-100">
                                <a href="<?= current_url() ?>"
                                    class="btn <?= empty(service('request')->getGet('tab')) ? 'btn-primary' : 'btn-outline-primary' ?>">
                                    All Leaves
                                </a>
                                <a href="<?= current_url() ?>?tab=department"
                                    class="btn <?= service('request')->getGet('tab') === 'department' ? 'btn-primary' : 'btn-outline-primary' ?>">
                                    Department Leaves
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="<?= current_url() ?>" class="row g-3">
                            <!-- Leave Type -->
                            <div class="col-md-4">
                                <select id="type" name="type" class="form-select">
                                    <option value="">All Leave Type</option>
                                    <?php foreach (LeaveType::cases() as $item): ?>
                                        <option value="<?= $item->value ?>"
                                            <?= (service('request')->getGet('type') == $item->value) ? 'selected' : '' ?>>
                                            <?= $item->value ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- VL type -->
                            <?php $vlTypeVisible = (service('request')->getGet('type') === LeaveType::VACATION_LEAVE->value) ? 'block' : 'none'; ?>
                            <div class="col-md-4 vl-type" style="display: <?= $vlTypeVisible ?>;">
                                <select name="vl_type" class="form-select">
                                    <option value="">All Vacation Leave Type</option>
                                    <?php foreach (VLeaveType::cases() as $item): ?>
                                        <option value="<?= $item->value ?>"
                                            <?= (service('request')->getGet('vl_type') == $item->value) ? 'selected' : '' ?>>
                                            <?= $item->value ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Approve Status -->
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <?php foreach (ApproveStatus::cases() as $item): ?>
                                        <option value="<?= $item->value ?>"
                                            <?= (service('request')->getGet('status') == $item->value) ? 'selected' : '' ?>>
                                            <?= $item->value ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Date -->
                            <div class="col-md-4">
                                <input type="date" name="date" class="form-control"
                                    value="<?= service('request')->getGet('date') ?>">
                            </div>
                            <!-- Employee -->
                            <?php if (!$isEmployee): ?>
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        value="<?= service('request')->getGet('search') ?>"
                                        placeholder="Search by name, email or employee ID">
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
                    <a href="<?= route_to('leaves-download') . '?' . http_build_query($_GET) ?>"
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
                    <button id="printButton" class="btn btn-outline-primary" data-url="<?= route_to('leaves-print') ?>"
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
                                    <?php if (!$isEmployee || (session()->get('isDepartmentHead') && $isDeptTab)): ?>
                                        <th>Employee</th>
                                    <?php endif; ?>
                                    <th>Leave Type</th>
                                    <th>Approval</th>
                                    <th>Effective Date</th>
                                    <th class="w-auto"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $item): ?>
                                    <tr>
                                        <?php if (!$isEmployee || (session()->get('isDepartmentHead') && $isDeptTab)): ?>
                                            <td>
                                                <?= $item['name'] ?>
                                            </td>
                                        <?php endif; ?>
                                        <td class="text-secondary">
                                            <?= $item['type'] ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?php if ($item['department_head_approval_status'] === ApproveStatus::PENDING->value): ?>
                                                <?= approve_status($item['department_head_approval_status']) ?>
                                            <?php elseif ($item['department_head_approval_status'] === ApproveStatus::DENIED->value): ?>
                                                <?= approve_status($item['department_head_approval_status']) ?>
                                            <?php elseif (
                                                ($item['department_head_approval_status'] === ApproveStatus::APPROVED->value) &&
                                                ($item['admin_approval_status'] === ApproveStatus::PENDING->value)
                                            ): ?>
                                                <?= approve_status($item['admin_approval_status']) ?>
                                            <?php elseif (
                                                ($item['department_head_approval_status'] === ApproveStatus::APPROVED->value) &&
                                                ($item['admin_approval_status'] === ApproveStatus::DENIED->value)
                                            ): ?>
                                                <?= approve_status($item['admin_approval_status']) ?>
                                            <?php elseif (
                                                ($item['department_head_approval_status'] === ApproveStatus::APPROVED->value) &&
                                                ($item['admin_approval_status'] === ApproveStatus::APPROVED->value)
                                            ): ?>
                                                <?= approve_status($item['admin_approval_status']) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-secondary">
                                            <?php if ($item['type'] === LeaveType::VACATION_LEAVE->value): ?>
                                                <?= dateFormat($item['start_date']) . ' - ' . dateFormat($item['end_date']) ?>
                                            <?php else: ?>
                                                <?= dateFormat($item['start_date'], 'd/m/Y') ?>
                                                <?= $item['time_in'] ?> - <?= $item['time_out'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= route_to('leaves-show', $item['id']) ?>">Details</a>
                                            <!-- if Approval status is pending -->
                                            <?php if ($item['admin_approval_status'] === ApproveStatus::PENDING->value): ?>

                                                <?php if ($item['created_user_id'] === session()->get('user_id')): ?>
                                                    |
                                                    <?php if ($item['type'] === LeaveType::VACATION_LEAVE->value): ?>
                                                        <a href="<?= route_to('leaves-vacation-leave-edit', $item['id']) ?>">Edit</a>
                                                    <?php elseif ($item['type'] === LeaveType::OFFICIAL_BUSINESS->value): ?>
                                                        <a href="<?= route_to('leaves-official-business-edit', $item['id']) ?>">Edit</a>
                                                    <?php else: ?>
                                                        <a href="<?= route_to('leaves-personal-business-edit', $item['id']) ?>">Edit</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if ($item['created_user_id'] === session()->get('user_id')): ?>
                                                    |
                                                    <a href="javascript:void(0)" class="data-delete" data-id="<?= $item['id'] ?>"
                                                        data-url="<?= route_to('leaves-delete') ?>">Delete</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
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