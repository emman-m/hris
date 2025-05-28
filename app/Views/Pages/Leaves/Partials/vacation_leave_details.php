<?php
/**
 * filepath: c:\wamp64\www\hris\app\Views\Pages\Leaves\Partials\vacation_leave_details.php
 * 
 * if this file modified, please check the following files:
 * - app/Views/Templates/Leaves/vacation_leave_details.php
 */

use App\Enums\ApproveStatus;
use App\Enums\UserRole;
use App\Enums\VLeaveType;

?>
<style>
    .form-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .form-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-header h3 {
        margin: 0;
        font-size: 1.5rem;
        color: #333;
    }

    .form-header p {
        margin: 5px 0;
        font-size: 0.9rem;
        color: #333;
    }

    .form-section {
        margin-bottom: 15px;
    }

    .form-section label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .form-section p {
        margin: 5px 0;
        color: #333;
    }

    .name {
        font-weight: bold;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        color: #333;
    }

    .form-check input {
        margin-right: 10px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.9rem;
        background-color: transparent;
        color: #333;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .col {
        flex: 1;
        min-width: 200px;
    }

    .signature-line {
        border-top: 1px solid #000;
        width: 100%;
        margin-top: 10px;
        color: #333;
    }

    .text-center {
        text-align: center;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3>APPLICATION FOR LEAVE</h3>
        <p>The President<br>La Consolacion College Tanauan<br>Tanauan City, Batangas</p>
    </div>

    <div class="form-section">
        <p>Dear Sister:</p>
        <p>I am applying for <span class="fw-bold">__<?= $leave['days'] ?>__</span> working days/month from <span
                class="fw-bold">__<?= dateFormat($leave['start_date']) ?>__</span> to <span
                class="fw-bold">__<?= dateFormat($leave['end_date']) ?>__</span> (inclusive dates).</p>
    </div>

    <div class="form-section">
        <label>Type of Leave:</label>
        <div class="row">
            <div class="col">
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="sick" disabled
                        <?= VLeaveType::SICK_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Sick Leave</span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="vacation" disabled
                        <?= VLeaveType::VACATION_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Vacation Leave</span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="study" disabled
                        <?= VLeaveType::STUDY_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Study Leave</span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="emergency" disabled
                        <?= VLeaveType::EMERGENCY_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Emergency Leave</span>
                </div>
            </div>
            <div class="col">
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="maternity" disabled
                        <?= VLeaveType::MATERNITY_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Maternity Leave</span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="maternity" disabled
                        <?= VLeaveType::PATERNITY_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Paternity Leave</span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="bereavement" disabled
                        <?= VLeaveType::BEREAVEMENT_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Bereavement Leave</span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="service" disabled
                        <?= VLeaveType::SERVICE_INCENTIVE_LEAVE->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Service Incentive Leave</span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="leave_type" value="others" disabled
                        <?= VLeaveType::OTHERS->value === $leave['vl_type'] ? 'checked' : '' ?>>
                    <span>Others</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-section">
        <label>Reason for Leave:</label>
        <textarea type="text" class="form-control" style="resize:none" readonly><?= $leave['reason'] ?></textarea>
    </div>

    <div class="form-section">
        <p>Respectfully,</p>
        <div class="row">
            <div class="col text-center">
                <p class="name"><?= $leave['name'] ?></p>
                <div class="signature-line"></div>
                <p class="mb-0">Employee</p>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <div class="form-section">
        <div class="row">
            <div class="col text-center">
                <label class="text-start mb-2">Department Head Approval:</label>
                <?php if ($leave['dept_head_approve_by']): ?>
                    <p class="name">
                        <?= $leave['dept_head_approve_by'] ?>
                        <?php if ($leave['department_head_approval_status'] === ApproveStatus::DENIED->value): ?>
                            <?= approve_status($leave['department_head_approval_status']) ?>
                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <?php if (session()->get('isDepartmentHead')): ?>
                        <p class="name"><?= session()->get('name') ?>
                            <a href="<?= route_to('leaves-approve', $leave['id']) ?>" class="btn btn-primary btn-sm">
                                Approve Leave
                            </a>
                            <a href="<?= route_to('leaves-reject', $leave['id']) ?>" class="btn btn-danger btn-sm">
                                Reject Leave
                            </a>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="signature-line"></div>
                <p class="mb-0">Department Head</p>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="row">
            <div class="col text-center">
                <label class="text-start mb-2">Admin Approval:</label>
                <?php if ($leave['admin_approve_by']): ?>
                    <p class="name">
                        <?= $leave['admin_approve_by'] ?>
                        <?php if ($leave['admin_approval_status'] === ApproveStatus::DENIED->value): ?>
                            <?= approve_status($leave['admin_approval_status']) ?>
                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <?php if ($isAnyAdmin && ($leave['department_head_approval_status'] === ApproveStatus::APPROVED->value)): ?>
                        <p class="name"><?= session()->get('name') ?>
                            <a href="<?= route_to('leaves-approve', $leave['id']) ?>" class="btn btn-primary btn-sm">
                                Approve Leave
                            </a>
                            <a href="<?= route_to('leaves-reject', $leave['id']) ?>" class="btn btn-danger btn-sm">
                                Reject Leave
                            </a>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="signature-line"></div>
                <p class="mb-0">Human Resource</p>
            </div>
        </div>
    </div>

    <div class="form-section">
        <label>Action Taken:</label>
        <?php if ($leave['department_head_approval_status'] === ApproveStatus::PENDING->value): ?>
            <?= approve_status($leave['department_head_approval_status']) ?>
        <?php elseif ($leave['department_head_approval_status'] === ApproveStatus::DENIED->value): ?>
            <?= approve_status($leave['department_head_approval_status']) ?>
        <?php elseif (
            ($leave['department_head_approval_status'] === ApproveStatus::APPROVED->value) &&
            ($leave['admin_approval_status'] === ApproveStatus::PENDING->value)
        ): ?>
            <?= approve_status($leave['admin_approval_status']) ?>
        <?php elseif (
            ($leave['department_head_approval_status'] === ApproveStatus::APPROVED->value) &&
            ($leave['admin_approval_status'] === ApproveStatus::DENIED->value)
        ): ?>
            <?= approve_status($leave['admin_approval_status']) ?>
        <?php elseif (
            ($leave['department_head_approval_status'] === ApproveStatus::APPROVED->value) &&
            ($leave['admin_approval_status'] === ApproveStatus::APPROVED->value)
        ): ?>
            <?= approve_status($leave['admin_approval_status']) ?>
        <?php endif; ?>
    </div>
</div>