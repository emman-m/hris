<div class="nav-item dropdown">
    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
        <!-- <span class="avatar avatar-sm" style="background-image: url(https://i.pravatar.cc/150?img=67)"></span> -->
        <span class="avatar"><?= session()->get('initials')?></span>
        <div class="d-none d-xl-block ps-2">
            <div><?= session()->get('name') ?></div>
            <div class="mt-1 small text-secondary"><?= session()->get('role') ?></div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <a href="<?= route_to('my-account')?>" class="dropdown-item">Account</a>
        <a href="<?= base_url('logout') ?>" class="dropdown-item">Logout</a>
    </div>
</div>