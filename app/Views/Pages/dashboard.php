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
                <div class="card">
                    <div class="card-body" style="height: 10rem"></div>
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