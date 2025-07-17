<header class="position-fixed top-0 start-0 end-0 bg-white border-bottom shadow-sm" style="z-index: 1040;">
    <div class="d-flex align-items-center justify-content-between px-3 py-2 px-lg-4">
        <!-- Logo dan Toggle Sidebar -->
        <div class="d-flex align-items-center">
            <button id="sidebar-toggle" class="btn btn-outline-secondary me-3 d-lg-none">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex align-items-center">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="rounded me-2" width="32" height="32">
                <h1 class="h5 mb-0 fw-semibold d-none d-sm-block">SPK Rekomendasi Skripsi</h1>
            </div>
        </div>

        <!-- Menu Kanan -->
        <div class="d-flex align-items-center">
            <!-- Notifikasi -->
            <div class="position-relative me-2">
                <button id="notification-toggle" class="btn btn-outline-secondary position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </button>
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <button id="profile-toggle" class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-user-graduate text-white" style="font-size: 0.875rem;"></i>
                    </div>
                    <span class="d-none d-sm-inline">Mahasiswa</span>
                </button>

                <!-- Profile Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a href="#" class="dropdown-item d-flex align-items-center">
                            <i class="fas fa-user-circle me-2 text-muted"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item d-flex align-items-center">
                            <i class="fas fa-cog me-2 text-muted"></i>
                            Pengaturan
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
