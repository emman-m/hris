<?php

use App\Enums\UserRole;
session()->set(['menu' => 'memos']);
// Set errors variable
$errors = session()->get('errors');

// page title
$title = 'Create Memo';
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
<script src="<?= base_url('js/memos/create.js') ?>"></script>
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
                <form action="<?= route_to('memos-store') ?>" class="card" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <?php if (session()->has('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label class="form-label required">Memo Title</label>
                            <input type="text" class="form-control" name="title" value="<?= old('title') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Recipients</label>
                            <select class="form-select" name="recipients[]" id="recipients" multiple required>
                                <?php if (!empty(old('recipients'))): ?>
                                    <?php foreach (old('recipients') as $recipient): ?>
                                        <?php if (is_array($recipient) && isset($recipient['id']) && isset($recipient['name'])): ?>
                                            <option value="<?= $recipient['id'] ?>" selected><?= esc($recipient['name']) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="form-hint">Type at least 2 characters to search for recipients</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">PDF File</label>
                            <input type="file" name="file" class="form-control" accept="application/pdf" required>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> 