<?php

?>
<!-- File name -->
<div class="mb-3">
    <label class="form-label required">Certificate Name</label>
    <input type="text" name="file_name" class="form-control" value="<?= $file_name ?? old('file_name') ?>" autocomplete="off" />

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