<aside id="sidebar" class="position-fixed start-0 top-0 bg-gradient-to-b from-slate-50 to-white border-end shadow-lg d-lg-block" style="z-index: 1030; height: 100vh; width: 250px; transform: translateX(-100%); transition: transform 0.3s ease; background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
    <!-- Sidebar Header dengan Logo Besar -->
    <div class="text-center py-4 border-bottom bg-white">
        <div class="mb-3">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo SPK" class="rounded-circle shadow-sm" width="64" height="64" style="object-fit: cover;">
        </div>
        <h5 class="fw-bold text-primary mb-1">SPK Rekomendasi</h5>
        <p class="small text-muted mb-0">Sistem Pendukung Keputusan</p>
        <button id="sidebar-close" class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 d-lg-none">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Menu dengan Konsep Card -->
    <nav class="px-3 py-3">
        <div class="mb-3">
            <h6 class="text-uppercase text-muted small fw-bold px-2 mb-2">Menu Utama</h6>
            <div class="nav-menu-cards">
                <a href="{{ route('mahasiswa.dashboard') }}" class="nav-card d-block text-decoration-none mb-2 {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                    <div class="card border-0 shadow-sm h-100" style="transition: all 0.2s ease;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-home text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Dashboard</h6>
                                <small class="text-muted">Ringkasan aktivitas</small>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('mahasiswa.profile.show') }}" class="nav-card d-block text-decoration-none mb-2 {{ request()->routeIs('mahasiswa.profile.*') ? 'active' : '' }}">
                    <div class="card border-0 shadow-sm h-100" style="transition: all 0.2s ease;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-user-graduate text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Profil Akademik</h6>
                                <small class="text-muted">Data mahasiswa</small>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('mahasiswa.nilai.index') }}" class="nav-card d-block text-decoration-none mb-2 {{ request()->routeIs('mahasiswa.nilai.*') ? 'active' : '' }}">
                    <div class="card border-0 shadow-sm h-100" style="transition: all 0.2s ease;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-chart-line text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Riwayat Nilai</h6>
                                <small class="text-muted">Transkrip nilai</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="mb-3">
            <h6 class="text-uppercase text-muted small fw-bold px-2 mb-2">Akademik</h6>
            <div class="nav-menu-cards">
                <a href="{{ route('mahasiswa.pembimbing.index') }}" class="nav-card d-block text-decoration-none mb-2 {{ request()->routeIs('mahasiswa.pembimbing.*') ? 'active' : '' }}">
                    <div class="card border-0 shadow-sm h-100" style="transition: all 0.2s ease;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-user-tie text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Pembimbing</h6>
                                <small class="text-muted">Dosen pembimbing</small>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('mahasiswa.rekomendasi.index') }}" class="nav-card d-block text-decoration-none mb-2 {{ request()->routeIs('mahasiswa.rekomendasi.*') ? 'active' : '' }}">
                    <div class="card border-0 shadow-sm h-100" style="transition: all 0.2s ease;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-lightbulb text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Rekomendasi</h6>
                                <small class="text-muted">Judul skripsi</small>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('mahasiswa.topik-skripsi.index') }}" class="nav-card d-block text-decoration-none mb-2 {{ request()->routeIs('mahasiswa.topik-skripsi.*') ? 'active' : '' }}">
                    <div class="card border-0 shadow-sm h-100" style="transition: all 0.2s ease;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-book text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Referensi Topik</h6>
                                <small class="text-muted">Bank topik skripsi</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </nav>

    <!-- User Profile Card di Footer -->
    <div class="position-absolute bottom-0 start-0 end-0 p-3">
        <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-3 text-white">
                <div class="d-flex align-items-center">
                    <div class="position-relative me-3">
                        <img src="{{ asset('img/logo.jpeg') }}" alt="Avatar" class="rounded-circle border border-white" width="40" height="40" style="object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 12px; height: 12px;"></span>
                    </div>
                    <div class="flex-grow-1 text-truncate">
                        <h6 class="mb-0 fw-semibold text-white">{{ Auth::user()->name ?? 'Mahasiswa' }}</h6>
                        <small class="text-white-50">{{ Auth::user()->email ?? 'mahasiswa@unibillfath.ac.id' }}</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay untuk Mobile -->
<div id="sidebar-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-lg-none d-none" style="z-index: 1020;"></div>

<!-- Custom CSS untuk Navigation Cards -->
<style>
.nav-card:hover .card {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.nav-card.active .card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-1px);
}

.nav-card.active .card h6,
.nav-card.active .card small {
    color: white !important;
}

.nav-card.active .card i {
    color: white !important;
}

.icon-wrapper {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    transition: all 0.2s ease;
}

.nav-card.active .icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
}

.nav-card:hover .icon-wrapper {
    background: rgba(0, 0, 0, 0.1);
}
</style>
