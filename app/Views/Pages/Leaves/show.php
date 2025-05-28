<?php

use App\Enums\LeaveType;
use App\Enums\UserRole;

session()->set(['menu' => 'leaves']);

$isEmployee = session()->get('role') === UserRole::EMPLOYEE->value;

$pageTitle = 'Leave Details';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $pageTitle ?>
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/leave/show.js') ?>"></script>
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
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="col-auto ms-auto">
                    <!-- Add Print Button -->
                    <button id="printButton" class="btn btn-outline-primary"
                        data-url="<?= route_to('leaves-print-show') ?>" title="Print" data-id="<?= $leave['id'] ?>">
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
                <?php if ($leave['type'] === LeaveType::VACATION_LEAVE->value): ?>
                    <?= view('Pages/Leaves/Partials/vacation_leave_details', ['leave' => $leave]) ?>
                <?php else: ?>
                    <?= view('Pages/Leaves/Partials/official_personal_leave_details', ['leave' => $leave]) ?>
                <?php endif ?>
            </div>
        </div>
        <!-- Approval proof -->
        <?php if ($leave['approval_proof']): ?>
            <div class="row">
                <div class="col-12">
                    <h2>Approval Proof</h2>
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="<?= base_url('uploads') . '/' . $leave['approval_proof'] ?>" alt="Proof">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>