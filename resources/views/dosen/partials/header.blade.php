<header class="position-fixed top-0 start-0 end-0 bg-gradient-primary border-bottom shadow-lg" style="z-index: 1040; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="d-flex align-items-center justify-content-between px-3 py-3 px-lg-4">
        <!-- Logo dan Toggle Sidebar -->
        <div class="d-flex align-items-center">
            <button id="sidebar-toggle" class="btn btn-outline-light me-3 d-lg-none">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex align-items-center text-white">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="rounded-circle me-3 shadow" width="40" height="40" style="object-fit: cover;">
                <div class="d-none d-md-block">
                    <h6 class="mb-0 fw-bold">SPK Rekomendasi</h6>
                    <small class="opacity-75">Panel Dosen</small>
                </div>
            </div>
        </div>

        <!-- Menu Kanan -->
        <div class="d-flex align-items-center gap-2">
            <!-- Quick Stats -->
            <div class="d-none d-lg-flex align-items-center me-3">
                <div class="bg-white bg-opacity-20 rounded-pill px-3 py-1 me-2">
                    <small class="text-white fw-medium">
                        <i class="fas fa-users me-1"></i>
                        12 Mahasiswa
                    </small>
                </div>
                <div class="bg-white bg-opacity-20 rounded-pill px-3 py-1">
                    <small class="text-white fw-medium">
                        <i class="fas fa-clipboard-list me-1"></i>
                        8 Rekomendasi
                    </small>
                </div>
            </div>
            
            <!-- Notifikasi -->
            <div class="position-relative me-2">
                <button id="notification-toggle" class="btn btn-outline-light position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </button>
                @include('dosen.partials.norifikasi')
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <img src="{{ asset('img/logo.jpeg') }}" alt="Profile" class="rounded-circle me-2" width="28" height="28" style="object-fit: cover;">
                    <span class="d-none d-md-inline text-white">{{ Auth::user()->name ?? 'Dosen' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                    <li class="dropdown-header">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('img/logo.jpeg') }}" alt="Profile" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->name ?? 'Dosen' }}</h6>
                                <small class="text-muted">{{ Auth::user()->email ?? 'dosen@unibillfath.ac.id' }}</small>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('dosen.profile.show') }}"><i class="fas fa-user me-2 text-primary"></i>Profile Saya</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2 text-secondary"></i>Pengaturan</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-question-circle me-2 text-info"></i>Bantuan</a></li>
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
</header>
