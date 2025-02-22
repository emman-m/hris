<?php

use App\Enums\UserRole;
?>
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand navbar-brand-autodark">
            <a href=".">
                <svg xmlns="http://www.w3.org/2000/svg" width="110" height="50" viewBox="0 0 200 50">
                    <text x="10" y="35" font-family="Arial, sans-serif" font-size="40" fill="white">HRIS</text>
                </svg>
            </a>
        </div>
        <div class="navbar-nav flex-row d-lg-none">
            <div class=" d-flex">
                <div class="nav-item dropdown d-flex me-3">
                    <?= view('Components/notification') ?>
                </div>
            </div>
            <?= view('Components/user-menu') ?>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <!-- Dashboard -->
                <li class="nav-item <?= session()->get('menu') == 'dashboard' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= route_to('dashboard') ?>">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M13.45 11.55l2.05 -2.05" />
                                <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Dashboard
                        </span>
                    </a>
                </li>
                <!-- Users -->
                <?php if (session()->get('role') !== UserRole::EMPLOYEE->value): ?>
                    <li class="nav-item <?= session()->get('menu') == 'users' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= route_to('users') ?>">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Users
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Employees -->
                <?php if (session()->get('role') !== UserRole::EMPLOYEE->value): ?>
                    <li class="nav-item <?= session()->get('menu') == 'employees' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= route_to('employees') ?>">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-square">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 10a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    <path d="M6 21v-1a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v1" />
                                    <path
                                        d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Employees
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- My Files -->
                <?php if (session()->get('role') === UserRole::EMPLOYEE->value): ?>
                    <li class="nav-item <?= session()->get('menu') == 'my-files' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= route_to('my-files') ?>">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-stack">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                    <path d="M5 21h14" />
                                    <path d="M5 18h14" />
                                    <path d="M5 15h14" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                My Files
                            </span>
                        </a>
                    </li>
                    <li class="nav-item <?= session()->get('menu') == 'my-files' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= route_to('my-informations') ?>">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                    <path
                                        d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                    <path d="M9 12h6" />
                                    <path d="M9 16h6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                My Informations
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</aside>