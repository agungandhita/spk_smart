<!-- Sidebar -->
<aside id="sidebar" class="sidebar bg-white shadow-sm position-fixed top-0 start-0 h-100 d-lg-block" style="width: 240px; z-index: 1050; transform: translateX(-100%); transition: transform 0.3s ease;">
    <!-- Sidebar Header -->
    <div class="sidebar-header p-3 border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="rounded me-2" width="32" height="32">
                <h5 class="mb-0 fw-semibold">SPK Skripsi</h5>
            </div>
            <button id="sidebar-close" class="btn btn-sm btn-outline-secondary d-lg-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav p-3">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a href="{{ route('dosen.dashboard') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.dashboard') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item mb-2">
                <a href="{{ route('dosen.profile.show') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.profile.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-user-circle me-2"></i>
                    Profile
                </a>
            </li>

            <!-- Pembimbing Akademik -->
            <li class="nav-item mb-2">
                <a href="{{ route('dosen.pembimbing.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.pembimbing.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-user-tie me-2"></i>
                    Pembimbing Akademik
                </a>
            </li>

            <!-- Kriteria -->
            <li class="nav-item mb-2">
                <a href="" class="nav-link d-flex align-items-center py-2 px-3 rounded">
                    <i class="fas fa-list-check me-2"></i>
                    Kriteria
                </a>
            </li>

            <!-- Topik Skripsi -->
            <li class="nav-item mb-2">
                <a href="" class="nav-link d-flex align-items-center py-2 px-3 rounded ">
                    <i class="fas fa-book me-2"></i>
                    Topik Skripsi
                </a>
            </li>

            <!-- Rekomendasi -->
            <li class="nav-item mb-2">
                <a href="{{ route('dosen.rekomendasi.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.rekomendasi.*') ? 'active' : '' }}">
                    <i class="fas fa-lightbulb me-2"></i>
                    Rekomendasi Judul
                </a>
            </li>

            <!-- Laporan -->
            <li class="nav-item mb-2">
                <a href="" class="nav-link d-flex align-items-center py-2 px-3 rounded">
                    <i class="fas fa-chart-bar me-2"></i>
                    Laporan
                </a>
            </li>
        </ul>
        
        <!-- Logout Button -->
        <div class="mt-3 pt-3 border-top">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="position-absolute bottom-0 start-0 end-0 p-3 border-top">
        <div class="d-flex align-items-center p-2 bg-light rounded">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                <i class="fas fa-user text-white" style="font-size: 0.875rem;"></i>
            </div>
            <div class="flex-grow-1 text-truncate">
                <p class="mb-0 fw-medium" style="font-size: 0.875rem;">Admin User</p>
                <p class="mb-0 text-muted" style="font-size: 0.75rem;">admin@konveksi.com</p>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay untuk Mobile -->
<div id="sidebar-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-lg-none d-none" style="z-index: 1020;"></div>
