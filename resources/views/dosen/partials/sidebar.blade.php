<!-- Sidebar -->
<aside id="sidebar" class="sidebar bg-white shadow-sm position-fixed top-0 start-0 h-100 d-lg-block" style="width: 240px; z-index: 1050; transform: translateX(-100%); transition: transform 0.3s ease;">
    <!-- Sidebar Header -->
    <div class="sidebar-header p-3 border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="rounded me-2" width="28" height="28">
                <h6 class="mb-0 fw-semibold">SPK Akademik</h6>
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
            <li class="nav-item mb-1">
                <a href="{{ route('dosen.dashboard') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.dashboard') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-home me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item mb-1">
                <a href="{{ route('dosen.profile.show') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.profile.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-user me-2"></i>
                    Profile
                </a>
            </li>

            <!-- Pengajuan Pembimbing -->
            <li class="nav-item mb-1">
                <a href="{{ route('dosen.pembimbing.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.pengajuan-pembimbing.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-user-graduate me-2"></i>
                    Pengajuan Pembimbing
                </a>
            </li>

            <!-- Topik Skripsi -->
            <li class="nav-item mb-1">
                <a href="{{ route('dosen.topik-skripsi.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.topik-skripsi.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-book me-2"></i>
                    Topik Skripsi
                </a>
            </li>

            <!-- Rekomendasi -->
            <li class="nav-item mb-1">
                <a href="{{ route('dosen.rekomendasi.index') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded {{ request()->routeIs('dosen.rekomendasi.*') ? 'bg-primary text-white' : 'text-dark' }}">
                    <i class="fas fa-lightbulb me-2"></i>
                    Rekomendasi
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="position-absolute bottom-0 start-0 end-0 p-3 border-top">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                <i class="fas fa-sign-out-alt me-2"></i>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- Sidebar Overlay untuk Mobile -->
<div id="sidebar-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-lg-none d-none" style="z-index: 1020;"></div>
