<?php

use App\Enums\UserRole;
?>
<aside class="navbar navbar-vertical navbar-expand-lg">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand navbar-brand-autodark">
            <a href=".">
                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="50" viewBox="0 0 200 50">
                    <text x="10" y="35" font-family="Arial, sans-serif" font-size="30" fill="black">LCCT HRMS</text>
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
                <!-- Announcement -->
                <?php if (session()->get('role') !== UserRole::EMPLOYEE->value): ?>
                    <li class="nav-item <?= session()->get('menu') == 'announcements' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= route_to('announcements') ?>">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
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
                            </span>
                            <span class="nav-link-title">
                                Announcements
                            </span>
                        </a>
                    </li>
                    <li class="nav-item <?= session()->get('menu') == 'memos' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= route_to('memos') ?>">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M9 9l1 0" />
                                    <path d="M9 13l6 0" />
                                    <path d="M9 17l6 0" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Memos
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
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
                <!-- Department Heads -->
                <?php if (session()->get('role') !== UserRole::EMPLOYEE->value): ?>
                    <li class="nav-item <?= session()->get('menu') == 'department-heads' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= route_to('department-heads') ?>">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Department Heads
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Attendance -->
                <li class="nav-item <?= session()->get('menu') == 'attendance' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= route_to('attendance') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-fingerprint">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" />
                                <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" />
                                <path d="M12 11v2a14 14 0 0 0 2.5 8" />
                                <path d="M8 15a18 18 0 0 0 1.8 6" />
                                <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Attendance
                        </span>
                    </a>
                </li>
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
                    <!-- My Informations -->
                    <li class="nav-item <?= session()->get('menu') == 'my-informations' ? 'active' : '' ?>">
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
                                My Information
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Leaves -->
                <li class="nav-item <?= session()->get('menu') == 'leaves' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= route_to('leaves') ?>">
                        <span
                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-cog">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 21h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M19.001 15.5v1.5" />
                                <path d="M19.001 21v1.5" />
                                <path d="M22.032 17.25l-1.299 .75" />
                                <path d="M17.27 20l-1.3 .75" />
                                <path d="M15.97 17.25l1.3 .75" />
                                <path d="M20.733 20l1.3 .75" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Leaves
                        </span>
                    </a>
                </li>

                <!-- Reports -->
                <?php if (session()->get('role') !== UserRole::EMPLOYEE->value): ?>
                    <li class="nav-item dropdown <?= in_array(session()->get('menu'), ['reports-turnover-rate', 'reports-tardiness-rate']) ? 'active' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#navbar-reports" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 3m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" />
                                    <path d="M12 8l4 4l-4 4" />
                                    <path d="M8 12h8" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Reports
                            </span>
                        </a>
                        <div class="dropdown-menu show">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item <?= session()->get('menu') == 'reports-turnover-rate' ? 'active' : '' ?>" href="<?= route_to('reports-turnover-rate') ?>">
                                        Turnover Rate
                                    </a>
                                    <a class="dropdown-item <?= session()->get('menu') == 'reports-tardiness-rate' ? 'active' : '' ?>" href="<?= route_to('reports-tardiness-rate') ?>">
                                        Tardiness Rate
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</aside>