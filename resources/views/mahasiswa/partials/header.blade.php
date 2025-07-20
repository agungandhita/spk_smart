<header class="position-fixed top-0 start-0 end-0 shadow-lg" style="z-index: 1040; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between py-3">
            <!-- Brand Section -->
            <div class="d-flex align-items-center">
                <button id="sidebar-toggle" class="btn btn-outline-light me-3 d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="d-flex align-items-center text-white">
                    <div class="position-relative me-3">
                        <img src="{{ asset('img/logo.jpeg') }}" alt="Logo SPK" class="rounded-circle border border-white shadow-sm" width="45" height="45" style="object-fit: cover;">
                        <div class="position-absolute top-0 end-0 bg-warning rounded-circle" style="width: 12px; height: 12px;"></div>
                    </div>
                    <div class="d-none d-md-block">
                        <h1 class="h4 mb-0 fw-bold text-white">SPK Rekomendasi</h1>
                        <small class="text-white-50">Sistem Pendukung Keputusan Skripsi</small>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="d-flex align-items-center gap-2">
                <!-- Search Bar -->
                <div class="d-none d-lg-block me-3">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control bg-white bg-opacity-20 border-0 text-white" placeholder="Cari topik, dosen, atau judul..." style="backdrop-filter: blur(10px);">
                        <button class="btn btn-outline-light" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="d-flex align-items-center gap-1">
                    <!-- Notifications -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="width: 320px;">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Notifikasi</h6>
                                <small class="text-muted">3 baru</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item py-2">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary rounded-circle p-2">
                                            <i class="fas fa-lightbulb text-white" style="font-size: 0.75rem;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-1 small">Rekomendasi Baru</h6>
                                        <p class="mb-1 small text-muted">Ada 2 rekomendasi judul baru untuk Anda</p>
                                        <small class="text-muted">5 menit lalu</small>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-center small text-primary">Lihat semua notifikasi</a>
                        </div>
                    </div>
                    
                    <!-- Messages -->
                    <button class="btn btn-outline-light position-relative">
                        <i class="fas fa-envelope"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" style="font-size: 0.6rem;">2</span>
                    </button>
                    
                    <!-- Profile -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('img/logo.jpeg') }}" alt="Profile" class="rounded-circle me-2" width="28" height="28" style="object-fit: cover;">
                            <span class="d-none d-md-inline text-white">{{ Auth::user()->name ?? 'Mahasiswa' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('img/logo.jpeg') }}" alt="Profile" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0">{{ Auth::user()->name ?? 'Mahasiswa' }}</h6>
                                        <small class="text-muted">{{ Auth::user()->email ?? 'mahasiswa@unibillfath.ac.id' }}</small>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2 text-primary"></i>Profile Saya</a></li>
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
        </div>
    </div>
    </div>
</header>
