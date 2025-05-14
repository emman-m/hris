<?php

session()->set(['menu' => 'memos']);

$pageTitle = 'Memos';
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
<?= $pageTitle ?>
<?= $this->endSection() ?>

<!-- Custom import -->
<?= $this->section('footer-script') ?>
<script src="<?= base_url('js/memos/index.js') ?>"></script>
<script src="<?= base_url('js/memos/data-delete.js') ?>"></script>
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
            <!-- Create new memo button -->
            <div class="col-auto ms-auto">
                <a href="<?= route_to('memos-create'); ?>" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Create Memo
                </a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="<?= current_url() ?>" class="row g-3">
                            <!-- Search -->
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    value="<?= service('request')->getGet('search') ?>"
                                    placeholder="Search by title or creator">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Created By</th>
                                    <th>Recipients</th>
                                    <th>Created At</th>
                                    <th class="w-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($memos)): ?>
                                    <?php foreach ($memos as $memo): ?>
                                        <tr>
                                            <td><?= esc($memo['title']) ?></td>
                                            <td><?= esc($memo['creator_name']) ?></td>
                                            <td>
                                                <?php 
                                                $recipientNames = array_map(function($recipient) {
                                                    return $recipient['name'];
                                                }, $memo['recipients']);
                                                echo esc(implode(', ', $recipientNames));
                                                ?>
                                            </td>
                                            <td><?= date('M d, Y H:i', strtotime($memo['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= route_to('memos-edit', $memo['id']) ?>">Edit</a>
                                                |
                                                <a href="<?= route_to('memos-download', $memo['id']) ?>">Download</a>
                                                |
                                                <a href="javascript:void(0)" class="data-delete" data-id="<?= $memo['id'] ?>"
                                                    data-url="<?= route_to('memos-delete') ?>">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <?= $paginationInfo['start'] ?> to <?= $paginationInfo['end'] ?> of
                            <?= $paginationInfo['totalItems'] ?> entries
                        </p>
                        <?= $pager->links('default', 'custom_pagination') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> 