@extends('mahasiswa.layouts.main')
@section('container')
<div class="container-fluid px-0">
    <!-- Header Dashboard -->
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark">Dashboard SPK Rekomendasi Skripsi</h1>
        <p class="text-muted">Selamat datang di Sistem Pendukung Keputusan Rekomendasi Judul Skripsi</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Total Rekomendasi</p>
                            <p class="h3 fw-bold mb-2">12</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Sesuai: 8</span>
                                <span class="badge bg-warning text-dark">Review: 4</span>
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-lightbulb text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Minat Akademik</p>
                            <p class="h3 fw-bold mb-2">5</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Aktif: 3</span>
                                <span class="badge bg-info">Potensial: 2</span>
                            </div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-heart text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">IPK Saat Ini</p>
                            <p class="h3 fw-bold mb-1">3.75</p>
                            <p class="small text-muted">Semester 6</p>
                        </div>
                        <div class="bg-secondary bg-opacity-10 rounded p-3">
                            <i class="fas fa-graduation-cap text-secondary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Skor SMART</p>
                            <p class="h3 fw-bold mb-2">85.6</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Tinggi: 3</span>
                                <span class="badge bg-warning text-dark">Sedang: 2</span>
                            </div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="fas fa-chart-line text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Recommendations -->
    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">Rekomendasi Terbaru</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                        <div>
                            <p class="fw-medium mb-1">#REC001</p>
                            <p class="small text-muted mb-1">Sistem Informasi Manajemen</p>
                            <p class="small text-muted">Bidang: Sistem Informasi</p>
                        </div>
                        <div class="text-end">
                            <p class="fw-medium mb-1">Skor: 92.5</p>
                            <span class="badge bg-success">Sangat Sesuai</span>
                            <p class="small text-muted mt-1">15 Des 2024</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                        <div>
                            <p class="fw-medium mb-1">#REC002</p>
                            <p class="small text-muted mb-1">Aplikasi Mobile E-Commerce</p>
                            <p class="small text-muted">Bidang: Mobile Development</p>
                        </div>
                        <div class="text-end">
                            <p class="fw-medium mb-1">Skor: 87.3</p>
                            <span class="badge bg-primary">Sesuai</span>
                            <p class="small text-muted mt-1">14 Des 2024</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                        <div>
                            <p class="fw-medium mb-1">#REC003</p>
                            <p class="small text-muted mb-1">Analisis Data Mining</p>
                            <p class="small text-muted">Bidang: Data Science</p>
                        </div>
                        <div class="text-end">
                            <p class="fw-medium mb-1">Skor: 78.9</p>
                            <span class="badge bg-warning text-dark">Cukup Sesuai</span>
                            <p class="small text-muted mt-1">13 Des 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">Statistik Akademik</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Rekomendasi Bulan Ini</span>
                        <span class="fw-medium">8</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Rata-rata Skor SMART</span>
                        <span class="fw-medium">85.6</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Bidang Minat Utama</span>
                        <span class="fw-medium">Sistem Informasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
@endsection
