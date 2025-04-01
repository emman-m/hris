<?php

use App\Enums\LeaveType;

?>
<!-- Leave Type -->
<div class="mb-3">
    <label class="form-label required">Leave Type</label>
    <select class="form-control" name="type">
        <option value="">Select Leave Type</option>
        <?php foreach (LeaveType::cases() as $type): ?>
            <option value="<?= $type->value ?>"
                <?= (old('type') == $type->value) ? 'selected' : '' ?>>
                <?= $type->value ?>
            </option>
        <?php endforeach; ?>

    <!-- Error Message -->
    <?php if (isset($errors['file_name'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['file_name'] ?>
            </div>
    <?php endif; ?>
</div>
<!-- File -->
<div class="mb-3">
    <div class="form-label required">File</div>
    <input type="file" name="file" class="form-control">
    <!-- Error Message -->
    <?php if (isset($errors['file'])): ?>
            <div class="invalid-feedback d-block">
                <?= $errors['file'] ?>
            </div>
    <?php endif; ?>
</div>