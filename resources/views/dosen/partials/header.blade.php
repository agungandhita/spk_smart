<header class="position-fixed top-0 start-0 end-0 bg-white border-bottom shadow-sm" style="z-index: 1040;">
    <div class="d-flex align-items-center justify-content-between px-3 py-2 px-lg-4">
        <!-- Logo dan Toggle Sidebar -->
        <div class="d-flex align-items-center">
            <button id="sidebar-toggle" class="btn btn-outline-secondary me-3 d-lg-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Menu Kanan -->
        <div class="d-flex align-items-center">
            <!-- Notifikasi -->
            <div class="position-relative me-2">
                <button id="notification-toggle" class="btn btn-outline-secondary position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </button>
                @include('dosen.partials.norifikasi')
            </div>

            <!-- Profile Info (tanpa dropdown) -->
            <div class="d-flex align-items-center">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                    <i class="fas fa-chalkboard-teacher text-white" style="font-size: 0.875rem;"></i>
                </div>
                <span class="d-none d-sm-inline fw-medium">Dosen</span>
            </div>
        </div>
    </div>
</header>
