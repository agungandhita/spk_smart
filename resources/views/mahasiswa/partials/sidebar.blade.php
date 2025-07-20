<aside id="sidebar" class="position-fixed start-0 top-0 bg-white border-end shadow-sm d-lg-block" style="z-index: 1030; height: 100vh; width: 240px; transform: translateX(-100%); transition: transform 0.3s ease;">
    <!-- Sidebar Header -->
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
        <div class="d-flex align-items-center">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="rounded me-2" width="32" height="32">
            <span class="h6 mb-0 fw-semibold">SPK Skripsi</span>
        </div>
        <button id="sidebar-close" class="btn btn-sm btn-outline-secondary d-lg-none">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-3 px-3">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item mb-1">
                <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('mahasiswa.profile.show') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('mahasiswa.profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate me-2"></i>
                    Profil Akademik
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('mahasiswa.nilai.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('mahasiswa.nilai.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line me-2"></i>
                    Riwayat Nilai
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('mahasiswa.pembimbing.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('mahasiswa.pembimbing.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie me-2"></i>
                    Pembimbing Akademik
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('mahasiswa.rekomendasi.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('mahasiswa.rekomendasi.*') ? 'active' : '' }}">
                    <i class="fas fa-lightbulb me-2"></i>
                    Rekomendasi Judul
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('mahasiswa.topik-skripsi.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('mahasiswa.topik-skripsi.*') ? 'active' : '' }}">
                    <i class="fas fa-book me-2"></i>
                    Referensi Topik Skripsi
                </a>
            </li>
        </ul>

        <hr class="my-3">

        <div class="mb-3">
            <h6 class="px-3 text-muted text-uppercase small mb-2">Pengaturan</h6>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <i class="fas fa-cog me-2"></i>
                        Konfigurasi
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <i class="fas fa-user-circle me-2"></i>
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="position-absolute bottom-0 start-0 end-0 p-3 border-top">
        <div class="d-flex align-items-center p-2 bg-light rounded">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                <i class="fas fa-user-graduate text-white" style="font-size: 0.875rem;"></i>
            </div>
            <div class="flex-grow-1 text-truncate">
                <p class="small fw-medium mb-0 text-truncate">Mahasiswa</p>
                <p class="small text-muted mb-0 text-truncate">mahasiswa@unibillfath.ac.id</p>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay untuk Mobile -->
<div id="sidebar-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-lg-none d-none" style="z-index: 1020;"></div>
