<?php

use App\Enums\UserRole;
use App\Enums\VLeaveType;

$isCreate ??= false
?>
<div class="row">
    <?php if (session()->get('role') !== UserRole::EMPLOYEE->value && $isCreate): ?>
        <div class="col mb-3">
            <div class="form-label required">Employee ID</div>
            <input type="text" name="employee_id" class="form-control" value="<?= old('employee_id') ?>"
                placeholder="E10-00001" />
            <!-- Error Message -->
            <?php if (isset($errors['employee_id'])): ?>
                <div class="invalid-feedback d-block">
                    <?= $errors['employee_id'] ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<div class="row">
    <!-- Number of days -->
    <div class="col-sm-12 col-md-4 mb-3">
        <div class="form-label required">Number of day(s)</div>
        <input type="text" name="days" class="form-control" value="<?= old('days') ?>" />
        <!-- Error Message -->
        <?php if (isset($errors['days'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['days'] ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- Start Date -->
    <div class="col-sm-12 col-md-4 mb-3">
        <div class="form-label required">Start Date</div>
        <input type="date" name="start_date" class="form-control" value="<?= old('start_date') ?>" />
        <!-- Error Message -->
        <?php if (isset($errors['start_date'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['start_date'] ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- End Date -->
    <div class="col-sm-12 col-md-4 mb-3">
        <div class="form-label required">End Date</div>
        <input type="date" name="end_date" class="form-control" value="<?= old('end_date') ?>">
        <!-- Error Message -->
        <?php if (isset($errors['end_date'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['end_date'] ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Leave Type -->
<div class="mb-3">
    <label class="form-label required">Leave Type</label>
    <select class="form-control" name="vl_type">
        <option value="" selected disabled>Select Leave Type</option>
        <?php foreach (VLeaveType::cases() as $type): ?>
            <option value="<?= $type->value ?>" <?= (old('vl_type') == $type->value) ? 'selected' : '' ?>>
                <?= $type->value ?>
            </option>
        <?php endforeach; ?>

        <!-- Error Message -->
        <?php if (isset($errors['vl_type'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['vl_type'] ?>
            </div>
        <?php endif; ?>
    </select>
</div>

<!-- Reason -->
<div class="mb-3">
    <div class="form-label">Reason</div>
    <textarea name="reason" class="form-control" rows="3"><?= old('reason') ?></textarea>
    <!-- Error Message -->
    <?php if (isset($errors['reason'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['reason'] ?>
        </div>
    <?php endif; ?>
</div>

<!-- Approval proof -->
<div class="mb-3">
    <div class="form-label">Approval Proof</div>
    <input type="file" name="approval_proof" class="form-control" />
    <!-- Error Message -->
    <?php if (isset($errors['approval_proof'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['approval_proof'] ?>
        </div>
    <?php endif; ?>
</div>