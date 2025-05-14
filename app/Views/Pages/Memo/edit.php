<?php

use App\Enums\UserRole;
session()->set(['menu' => 'memos']);
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'Edit Memo';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Custom import -->
<?= $this->section('header-script') ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('footer-script') ?>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    const searchUserUrl = '<?= route_to('memos-search-users') ?>';
</script>
<script src="<?= base_url('js/memos/edit.js') ?>"></script>
<?= $this->endSection() ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <?= $title ?>
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <form action="<?= route_to('memos-update', $memo['id']) ?>" class="card" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <?php if (session()->has('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session()->get('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label required">Memo Title</label>
                            <input type="text" class="form-control" name="title"
                                value="<?= old('title', $memo['title']) ?>" required>
                            <!-- Error Message -->
                            <?php if (isset($errors['title'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['title'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Recipients</label>
                            <select class="form-select" name="recipients[]" id="recipients" multiple required>
                                <?php if (!empty($memo['recipients'])): ?>
                                    <?php foreach ($memo['recipients'] as $recipient): ?>
                                        <option value="<?= $recipient['user_id'] ?>" selected><?= esc($recipient['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="form-hint">Type at least 2 characters to search for recipients</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">PDF File</label>
                            <input type="file" name="file" class="form-control" accept="application/pdf">
                            <!-- Error Message -->
                            <?php if (isset($errors['file'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['file'] ?>
                                </div>
                            <?php endif; ?>

                            <small class="form-hint">Only PDF files are allowed. Maximum file size is 10MB. Leave empty
                                to keep the current file.</small>
                            <?php if (!empty($memo['file_path'])): ?>
                                <div class="mt-2">
                                    <a href="<?= route_to('memos-download', $memo['id']) ?>"
                                        class="btn btn-sm btn-outline-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <polyline points="7 11 12 16 17 11" />
                                            <line x1="12" y1="4" x2="12" y2="16" />
                                        </svg>
                                        Current File
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Update Memo</button>
                        <a href="<?= route_to('memos') ?>" class="btn btn-link">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>