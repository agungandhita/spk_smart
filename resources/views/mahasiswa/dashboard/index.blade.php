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
                            <p class="h3 fw-bold mb-2">{{ $totalRekomendasi }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Diterima: {{ $rekomendasiDiterima }}</span>
                                <span class="badge bg-warning text-dark">Pending: {{ $rekomendasiPending }}</span>
                                @if($rekomendasiDitolak > 0)
                                    <span class="badge bg-danger">Ditolak: {{ $rekomendasiDitolak }}</span>
                                @endif
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
                            <p class="small fw-medium text-muted mb-1">Status Pembimbing</p>
                            @if($pengajuanPembimbing)
                                @if($pengajuanPembimbing->status == 'disetujui')
                                    <p class="h6 fw-bold mb-1 text-success">{{ $pengajuanPembimbing->dosen->user->name }}</p>
                                    <p class="small text-muted">Pembimbing Aktif</p>
                                @elseif($pengajuanPembimbing->status == 'pending')
                                    <p class="h6 fw-bold mb-1 text-warning">Menunggu Persetujuan</p>
                                    <p class="small text-muted">{{ $pengajuanPembimbing->dosen->user->name }}</p>
                                @else
                                    <p class="h6 fw-bold mb-1 text-danger">Belum Ada Pembimbing</p>
                                    <p class="small text-muted">Ajukan pembimbing</p>
                                @endif
                            @else
                                <p class="h6 fw-bold mb-1 text-muted">Belum Ada Pengajuan</p>
                                <p class="small text-muted">Ajukan pembimbing</p>
                            @endif
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-chalkboard-teacher text-success fs-4"></i>
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
                            <p class="h3 fw-bold mb-1">{{ number_format($mahasiswa->ipk, 2) }}</p>
                            <p class="small text-muted">Semester {{ $mahasiswa->semester }}</p>
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
                            <p class="small fw-medium text-muted mb-1">Rata-rata Skor SMART</p>
                            <p class="h3 fw-bold mb-2">{{ number_format($rataRataSkor, 1) }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-info">Topik Tersedia: {{ $topikTersedia }}</span>
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
                    @if($rekomendasiTerbaru->count() > 0)
                        @foreach($rekomendasiTerbaru as $rekomendasi)
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                                <div>
                                    <p class="fw-medium mb-1">{{ Str::limit($rekomendasi->judul_skripsi, 30) }}</p>
                                    <p class="small text-muted mb-1">{{ Str::limit($rekomendasi->deskripsi_judul, 40) }}</p>
                                    <p class="small text-muted">Bidang: {{ $rekomendasi->bidang_keahlian }}</p>
                                    <p class="small text-muted">Dosen: {{ $rekomendasi->dosen->user->name }}</p>
                                </div>
                                <div class="text-end">
                                    @if($rekomendasi->skor_smart)
                                        <p class="fw-medium mb-1">Skor: {{ number_format($rekomendasi->skor_smart, 1) }}</p>
                                    @endif
                                    @if($rekomendasi->status == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($rekomendasi->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($rekomendasi->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($rekomendasi->status) }}</span>
                                    @endif
                                    <p class="small text-muted mt-1">{{ $rekomendasi->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-lightbulb fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada rekomendasi judul skripsi</p>
                            <small class="text-muted">Hubungi dosen pembimbing untuk mendapatkan rekomendasi</small>
                        </div>
                    @endif
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
                        <span class="fw-medium">{{ $totalRekomendasi }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Rata-rata Skor SMART</span>
                        <span class="fw-medium">{{ $rataRataSkor ? number_format($rataRataSkor, 1) : 'N/A' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Topik Tersedia</span>
                        <span class="fw-medium">{{ $topikTersedia->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Topik Tersedia -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">Topik Skripsi Tersedia</h3>
                </div>
                <div class="card-body">
                    @if($topikTersedia->count() > 0)
                        <div class="row g-3">
                            @foreach($topikTersedia as $topik)
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <h6 class="fw-bold mb-2">{{ Str::limit($topik->judul_skripsi, 40) }}</h6>
                                        <p class="small text-muted mb-2">{{ $topik->dosen->user->name }}</p>
                                        <p class="small mb-2">{{ Str::limit($topik->deskripsi_judul, 80) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary">{{ $topik->bidang_keahlian }}</span>
                                            <small class="text-muted">{{ ucfirst($topik->status) }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada topik skripsi tersedia</p>
                            <small class="text-muted">Silakan hubungi dosen pembimbing untuk informasi topik</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
@endsection
