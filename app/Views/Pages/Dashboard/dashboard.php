<?php
session()->set(['menu' => 'dashboard']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Vertical layout
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="height: 10rem"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="height: 10rem"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Announcement -->
                <div class="card">
                    <div class="card-stamp card-stamp-md">
                        <div class="card-stamp-icon bg-primary" style="transform: scaleX(-1) rotate(-10deg);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-speakerphone">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 8a3 3 0 0 1 0 6" />
                                <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" />
                                <path
                                    d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />
                            </svg>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between" style="height: 10rem">
                        <?php if ($announcement['data']): ?>
                            <?= view('Pages/Dashboard/Widgets/announcement', $announcement)?>
                        <?php else: ?>
                            <div class="h1 m-auto">No announcement</div>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>