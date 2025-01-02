<?php
session()->set(['menu' => 'users']);
?>

<!-- Layout -->
<?= $this->extend('AuthLayout/main') ?>

<!-- Title -->
<?= $this->section('title') ?>
Users
<?= $this->endSection() ?>

<!-- Body -->
<?= $this->section('content') ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Users
                </h2>
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
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Paweł Kuna</td>
                                    <td class="text-secondary">
                                        UI Designer, Training
                                    </td>
                                    <td class="text-secondary"><a href="#"
                                            class="text-reset">paweluna@howstuffworks.com</a></td>
                                    <td class="text-secondary">
                                        User
                                    </td>
                                    <td>
                                        <a href="#">Edit</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jeffie Lewzey</td>
                                    <td class="text-secondary">
                                        Chemical Engineer, Support
                                    </td>
                                    <td class="text-secondary"><a href="#" class="text-reset">jlewzey1@seesaa.net</a>
                                    </td>
                                    <td class="text-secondary">
                                        Admin
                                    </td>
                                    <td>
                                        <a href="#">Edit</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mallory Hulme</td>
                                    <td class="text-secondary">
                                        Geologist IV, Support
                                    </td>
                                    <td class="text-secondary"><a href="#"
                                            class="text-reset">mhulme2@domainmarket.com</a></td>
                                    <td class="text-secondary">
                                        User
                                    </td>
                                    <td>
                                        <a href="#">Edit</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dunn Slane</td>
                                    <td class="text-secondary">
                                        Research Nurse, Sales
                                    </td>
                                    <td class="text-secondary"><a href="#" class="text-reset">dslane3@epa.gov</a>
                                    </td>
                                    <td class="text-secondary">
                                        Owner
                                    </td>
                                    <td>
                                        <a href="#">Edit</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Emmy Levet</td>
                                    <td class="text-secondary">
                                        VP Product Management, Accounting
                                    </td>
                                    <td class="text-secondary"><a href="#" class="text-reset">elevet4@senate.gov</a>
                                    </td>
                                    <td class="text-secondary">
                                        Admin
                                    </td>
                                    <td>
                                        <a href="#">Edit</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>