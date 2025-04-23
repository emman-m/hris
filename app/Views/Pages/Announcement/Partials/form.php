<?php

use App\Enums\EmployeeDepartment;

$content = html_entity_decode(old('content'));
?>

<!-- Target User -->
<div class="mb-4">
    <label class="form-label required">Target User</label>
    <select id="target" name="target[]" class="form-select mt-1 block w-full" multiple>
        <?php foreach (EmployeeDepartment::cases() as $department): ?>
            <option value="<?= $department->value ?>" <?= in_array($department->value, old('target') ?? []) ? 'selected' : '' ?>>
                <?= $department->value ?>
            </option>
        <?php endforeach; ?>
    </select>
    <!-- Error Message -->
    <?php if (isset($errors['target'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['target'] ?>
        </div>
    <?php endif; ?>
</div>
<!-- Title -->
<div class="mb-3">
    <label class="form-label required">Title</label>
    <input type="text" name="title" class="form-control" value="<?= old('title') ?>" autocomplete="off" />

    <!-- Error Message -->
    <?php if (isset($errors['title'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['title'] ?>
        </div>
    <?php endif; ?>
</div>
<!-- Content -->
<div class="mb-3">
    <label class="form-label required">Content</label>
    <textarea name="content" class="form-control" rows="7"><?= $content ?></textarea>

    <!-- Error Message -->
    <?php if (isset($errors['content'])): ?>
        <div class="invalid-feedback d-block">
            <?= $errors['content'] ?>
        </div>
    <?php endif; ?>
</div>