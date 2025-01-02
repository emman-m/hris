<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <?= view('Components/notification') ?>
                </div>
            </div>
            <?= view('Components/user-menu') ?>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            
        </div>
    </div>
</header>