<?= $this->extend('GuessLayout/main') ?>

<?= $this->section('title') ?>
Login
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <img src="<?= base_url('assets/img/logo.png') ?>" width="80" alt="Tabler logo"><br>
            <span class="h1" style="text-wrap: auto">La Consolacion College Tanauan - HRMS</span>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Login</h2>

                <!-- Validation messages -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="post" autocomplete="off" novalidate="">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="your@email.com"
                            value="<?= esc(set_value('email')) ?>" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="password" class="form-control toggle-password"
                                placeholder="password123">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" class="link-secondary" id="togglePassword"
                                    data-bs-toggle="tooltip" aria-label="Show/Hide" data-bs-original-title="Show/Hide">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye-closed">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
                                        <path d="M3 15l2.5 -3.8" />
                                        <path d="M21 14.976l-2.492 -3.776" />
                                        <path d="M9 17l.5 -4" />
                                        <path d="M15 17l-.5 -4" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <a href="<?= route_to('forgot-password') ?>">I forgot password</a>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>