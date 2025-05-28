<?php
/**
 * filepath: c:\wamp64\www\hris\app\Views\Pages\Leaves\Partials\official_personal_leave_details.php
 * 
 * if this file modified, please check the following files:
 * - app/Views/Templates/Leaves/official_personal_leave_details.php
 */

use App\Enums\ApproveStatus;
use App\Enums\EmployeeDepartment;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Business Form</title>
    <link rel="stylesheet" href="<?= base_url('tabler/dist/css/tabler.min.css'); ?>">
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

        .text-bold {
            font-weight: bold;
        }
    </style>
    </>

<body>
    <div class="form-container">
        <div class="form-header">
            <h3>Official Business (OB) Form</h3>
            <p>HR Form 011a - Rev. 11/2021</p>
        </div>

        <div class="form-section">
            <label>Name of Faculty/Personnel:</label>
            <input type="text" class="form-control" value="<?= $leave['name'] ?>" readonly>
        </div>

        <div class="form-section">
            <label>Department:</label>
            <div class="row">
                <div class="form-check">
                    <input type="checkbox" id="ls" name="department" value="LS" disabled
                        <?= EmployeeDepartment::LOWER_SCHOOL->value === $leave['department'] ? 'checked' : '' ?>>
                    <label for="ls">LS</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="ms" name="department" value="MS" disabled
                        <?= EmployeeDepartment::MIDDLE_HIGH_SCHOOL->value === $leave['department'] ? 'checked' : '' ?>>
                    <label for="ms">MS</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="jhs" name="department" value="JHS" disabled
                        <?= EmployeeDepartment::JUNIOR_HIGH_SCHOOL->value === $leave['department'] ? 'checked' : '' ?>>
                    <label for="jhs">JHS</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="shs" name="department" value="SHS" disabled
                        <?= EmployeeDepartment::SENIOR_HIGH_SCHOOL->value === $leave['department'] ? 'checked' : '' ?>>
                    <label for="shs">SHS</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="col" name="department" value="COL" disabled
                        <?= EmployeeDepartment::COLLEGE->value === $leave['department'] ? 'checked' : '' ?>>
                    <label for="col">COL</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="ntp" name="department" value="NTP" disabled
                        <?= EmployeeDepartment::NON_TEACHING_PERSONNEL->value === $leave['department'] ? 'checked' : '' ?>>
                    <label for="ntp">NTP</label>
                </div>
            </div>
        </div>

        <div class="form-section">
            <label>Institution to Visit:</label>
            <input type="text" class="form-control" value="<?= $leave['institution'] ?>" readonly>
        </div>

        <div class="form-section">
            <label>Purpose:</label>
            <textarea type="text" class="form-control" style="resize:none" readonly><?= $leave['reason'] ?></textarea>
        </div>

        <div class="form-section">
            <label>Venue/Address:</label>
            <input type="text" class="form-control" value="<?= $leave['venue'] ?>" readonly>
        </div>

        <div class="form-section">
            <label>Date:</label>
            <input type="date" class="form-control" value="<?= dateFormat($leave['start_date'], 'Y-m-d') ?>" readonly>
        </div>

        <div class="form-section">
            <div class="row">
                <div class="col">
                    <label>Time In:</label>
                    <input type="time" class="form-control" value="<?= $leave['time_in'] ?>" readonly>
                </div>
                <div class="col">
                    <label>Time Out:</label>
                    <input type="time" class="form-control" value="<?= $leave['time_out'] ?>" readonly>
                </div>
            </div>
        </div>

        <div class="form-section">
            <label>Signature:</label>
            <div class="signature-line"></div>

        </div>

        <div class="form-section">
            <label>Department Head Approval:</label>
            <div class="row">
                <div class="col text-center">
                    <?php if ($leave['dept_head_approve_by']): ?>
                        <p class="name">
                            <?= $leave['dept_head_approve_by'] ?>
                            <?php if ($leave['department_head_approval_status'] === ApproveStatus::DENIED->value): ?>
                                <?= approve_status($leave['department_head_approval_status']) ?>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                    <div class="signature-line"></div>
                    <p class="mb-0">Department Head</p>
                </div>
            </div>
        </div>

        <div class="form-section">
            <label>Admin Approval:</label>
            <div class="row">
                <div class="col text-center">
                    <?php if ($leave['admin_approve_by']): ?>
                        <p class="name">
                            <?= $leave['admin_approve_by'] ?>
                            <?php if ($leave['admin_approval_status'] === ApproveStatus::DENIED->value): ?>
                                <?= approve_status($leave['admin_approval_status']) ?>
                            <?php endif; ?>
                        </p>
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

    Downloaded by: <?= $downloadedBy ?? 'Unknown User' ?>
</body>

</html>