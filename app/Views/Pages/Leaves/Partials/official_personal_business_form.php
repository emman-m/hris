<?php

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;

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
<!-- Department -->
<div class="mb-3">
    <label class="form-label required">Department</label>
    <select class="form-control" name="department">
        <option value="" selected disabled>Select Department</option>
        <?php foreach (EmployeeDepartment::cases() as $item): ?>
            <option value="<?= $item->value ?>" <?= (old('department') == $item->value) ? 'selected' : '' ?>>
                <?= $item->value ?>
            </option>
        <?php endforeach; ?>

        <!-- Error Message -->
        <?php if (isset($errors['department'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['department'] ?>
            </div>
        <?php endif; ?>
    </select>
</div>

<!-- Institution -->
<div class="mb-3">
    <div class="form-label required">Institution</div>
    <input type="text" name="institution" class="form-control" value="<?= old('institution') ?>" />
    <!-- Error Message -->
    <?php if (isset($errors['institution'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['institution'] ?>
        </div>
    <?php endif; ?>
</div>

<!-- Reason -->
<div class="mb-3">
    <div class="form-label">Reason/Purpose</div>
    <textarea name="reason" class="form-control" rows="3"><?= old('reason') ?></textarea>
    <!-- Error Message -->
    <?php if (isset($errors['reason'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['reason'] ?>
        </div>
    <?php endif; ?>
</div>

<!-- Venue -->
<div class="mb-3">
    <div class="form-label">Venue/Address</div>
    <input type="text" name="venue" class="form-control" value="<?= old('venue') ?>">
    <!-- Error Message -->
    <?php if (isset($errors['venue'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['venue'] ?>
        </div>
    <?php endif; ?>
</div>

<div class="row">
    <!-- Date -->
    <div class="col-sm-12 col-md-4 mb-3">
        <div class="form-label required">Date</div>
        <input type="date" name="start_date" class="form-control" value="<?= explode(" ", old('start_date'))[0] ?>" />
        <!-- Error Message -->
        <?php if (isset($errors['start_date'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['start_date'] ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- Time In -->
    <div class="col-sm-12 col-md-4 mb-3">
        <div class="form-label required">Time In</div>
        <input type="time" name="time_in" class="form-control" value="<?= old('time_in') ?>" />
        <!-- Error Message -->
        <?php if (isset($errors['time_in'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['time_in'] ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- Time Out -->
    <div class="col-sm-12 col-md-4 mb-3">
        <div class="form-label required">Time Out</div>
        <input type="time" name="time_out" class="form-control" value="<?= old('time_out') ?>">
        <!-- Error Message -->
        <?php if (isset($errors['time_out'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['time_out'] ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Approval proof -->
<div class="mb-3">
    <div class="form-label required">Approval Proof</div>
    <input type="file" name="approval_proof" class="form-control" />
    <!-- Error Message -->
    <?php if (isset($errors['approval_proof'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['approval_proof'] ?>
        </div>
    <?php endif; ?>
</div>