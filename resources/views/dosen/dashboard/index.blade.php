@extends('dosen.layouts.main')
@section('container')
<div class="p-4">
    <!-- Header Dashboard -->
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark">Dashboard</h1>
        <p class="text-muted">Selamat datang di panel admin konveksi</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Total Pesanan</p>
                            <p class="h3 fw-bold mb-2">32</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-warning text-dark">Menunggu: 7</span>
                                <span class="badge bg-primary">Diproses: 12</span>
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-shopping-cart text-primary fs-4"></i>
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
                            <p class="small fw-medium text-muted mb-1">Produk & Layanan</p>
                            <p class="h3 fw-bold mb-2">58</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Produk: 35</span>
                                <span class="badge bg-info">Layanan: 23</span>
                            </div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-box text-success fs-4"></i>
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
                            <p class="small fw-medium text-muted mb-1">Pengguna</p>
                            <p class="h3 fw-bold mb-1">185</p>
                            <p class="small text-muted">Customer terdaftar</p>
                        </div>
                        <div class="bg-secondary bg-opacity-10 rounded p-3">
                            <i class="fas fa-users text-secondary fs-4"></i>
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
                            <p class="small fw-medium text-muted mb-1">Pendapatan</p>
                            <p class="h3 fw-bold mb-2">Rp 22.450.000</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Diterima: 28</span>
                                <span class="badge bg-danger">Ditolak: 4</span>
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

    <!-- Recent Orders -->
    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                        <div>
                            <p class="fw-medium mb-1">#004</p>
                            <p class="small text-muted mb-1">Rina Sari</p>
                            <p class="small text-muted">Cetak Undangan</p>
                        </div>
                        <div class="text-end">
                            <p class="fw-medium mb-1">Rp 320.000</p>
                            <span class="badge bg-primary">Diproses</span>
                            <p class="small text-muted mt-1">16 Des 2024</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                        <div>
                            <p class="fw-medium mb-1">#005</p>
                            <p class="small text-muted mb-1">Dedi Kurniawan</p>
                            <p class="small text-muted">Sablon Jersey</p>
                        </div>
                        <div class="text-end">
                            <p class="fw-medium mb-1">Rp 680.000</p>
                            <span class="badge bg-warning text-dark">Menunggu</span>
                            <p class="small text-muted mt-1">15 Des 2024</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                        <div>
                            <p class="fw-medium mb-1">#006</p>
                            <p class="small text-muted mb-1">Maya Indira</p>
                            <p class="small text-muted">Bordir Logo</p>
                        </div>
                        <div class="text-end">
                            <p class="fw-medium mb-1">Rp 275.000</p>
                            <span class="badge bg-success">Selesai</span>
                            <p class="small text-muted mt-1">14 Des 2024</p>
                        </div>
                    </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Statistik Bulanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Pesanan Bulan Ini</span>
                        <span class="fw-medium">24</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Pendapatan Bulan Ini</span>
                        <span class="fw-medium">Rp 6.850.000</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="small text-muted">Rata-rata per Pesanan</span>
                        <span class="fw-medium">Rp 285.416</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
