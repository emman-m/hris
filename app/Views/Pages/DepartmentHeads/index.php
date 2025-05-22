<?php

use App\Enums\EmployeeDepartment;
session()->set(['menu' => 'department-heads']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
Department Heads
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/department-heads/index.js') ?>"></script>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Department Heads
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <?php foreach (EmployeeDepartment::cases() as $department): ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title text-truncate"><?= $department->value ?></h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($departments[$department->value])): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-fill">
                                        <div class="font-weight-medium text-truncate">
                                            <?= $departments[$department->value]['name'] ?>
                                        </div>
                                        <div class="text-secondary text-truncate">
                                            <?= $departments[$department->value]['email'] ?>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-head" 
                                                data-user-id="<?= $departments[$department->value]['user_id'] ?>">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="empty h-100">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
                                        </svg>
                                    </div>
                                    <p class="empty-title">No department head assigned</p>
                                    <p class="empty-subtitle text-secondary">
                                        Click the button below to assign a department head
                                    </p>
                                    <div class="empty-action">
                                        <button type="button" class="btn btn-primary assign-head" 
                                                data-department="<?= $department->value ?>">
                                            Assign Department Head
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Assign Department Head Modal -->
<div class="modal modal-blur fade" id="assign-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Department Head</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Search Employee</label>
                    <input type="text" class="form-control" id="employee-search" placeholder="Search by name or email...">
                    <input type="hidden" id="department-value">
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Employee ID</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody id="employee-results">
                            <!-- Results will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> 