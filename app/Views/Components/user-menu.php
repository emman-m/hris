<div class="nav-item dropdown">
    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
        <!-- <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span> -->
        <span class="avatar">EM</span>
        <div class="d-none d-xl-block ps-2">
            <div><?= session()->get('name') ?></div>
            <div class="mt-1 small text-secondary"><?= session()->get('role') ?></div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <a href="#" class="dropdown-item">Status</a>
        <a href="./profile.html" class="dropdown-item">Profile</a>
        <a href="#" class="dropdown-item">Feedback</a>
        <div class="dropdown-divider"></div>
        <a href="./settings.html" class="dropdown-item">Settings</a>
        <a href="<?= base_url('logout') ?>" class="dropdown-item">Logout</a>
    </div>
</div>