@extends('dosen.layouts.main')
@section('container')
<div class="p-4">
    <!-- Header Dashboard -->
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark">Dashboard Dosen</h1>
        <p class="text-muted">Selamat datang, {{ $dosen->user->name }} - Sistem Pendukung Keputusan Akademik</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Pengajuan Pembimbing</p>
                            <p class="h3 fw-bold mb-2">{{ $totalPengajuan }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-warning text-dark">Pending: {{ $pengajuanPending }}</span>
                                <span class="badge bg-success">Disetujui: {{ $mahasiswaBimbingan }}</span>
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-user-graduate text-primary fs-4"></i>
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
                            <p class="small fw-medium text-muted mb-1">Rekomendasi Judul</p>
                            <p class="h3 fw-bold mb-2">{{ $totalRekomendasi }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-secondary">Draft: {{ $rekomendasiDraft }}</span>
                                <span class="badge bg-info">Dikirim: {{ $rekomendasiDikirim }}</span>
                            </div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-lightbulb text-success fs-4"></i>
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
                            <p class="small fw-medium text-muted mb-1">Mahasiswa Bimbingan</p>
                            <p class="h3 fw-bold mb-1">{{ $mahasiswaBimbingan }}</p>
                            <p class="small text-muted">Mahasiswa aktif</p>
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
                            <p class="small fw-medium text-muted mb-1">Skor SMART Rata-rata</p>
                            <p class="h3 fw-bold mb-2">{{ number_format($rataRataSkor, 1) }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Diterima: {{ $rekomendasiDiterima }}</span>
                                <span class="badge bg-danger">Ditolak: {{ $rekomendasiDitolak }}</span>
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

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Recent Submissions -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0">Pengajuan Pembimbing Terbaru</h5>
                        <a href="{{ route('dosen.pembimbing.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($pengajuanTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Judul Skripsi</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanTerbaru as $pengajuan)
                                <tr>
                                    <td>{{ $pengajuan->mahasiswa->user->name }}</td>
                                    <td>{{ $pengajuan->mahasiswa->nim }}</td>
                                    <td>{{ Str::limit($pengajuan->judul_skripsi, 50) }}</td>
                                    <td>
                                        @if($pengajuan->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($pengajuan->status == 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox text-muted fs-1 mb-3"></i>
                        <p class="text-muted">Belum ada pengajuan pembimbing</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Recommendations -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="fw-bold mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('dosen.rekomendasi.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Rekomendasi
                        </a>
                        <a href="{{ route('dosen.pembimbing.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-graduate me-2"></i>Kelola Pengajuan
                        </a>
                        <a href="{{ route('dosen.topik-skripsi.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-lightbulb me-2"></i>Kelola Topik
                        </a>
                        <a href="{{ route('dosen.rekomendasi.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-chart-bar me-2"></i>Lihat Rekomendasi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Recommendations -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="fw-bold mb-0">Rekomendasi Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($rekomendasiTerbaru->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($rekomendasiTerbaru as $rekomendasi)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                    <i class="fas fa-lightbulb text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ Str::limit($rekomendasi->judul, 30) }}</h6>
                                    <small class="text-muted">{{ $rekomendasi->mahasiswa->user->name }}</small>
                                </div>
                                @if($rekomendasi->status == 'dikirim')
                                    <span class="badge bg-info">Dikirim</span>
                                @elseif($rekomendasi->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($rekomendasi->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-3">
                        <i class="fas fa-lightbulb text-muted fs-3 mb-2"></i>
                        <p class="text-muted small mb-0">Belum ada rekomendasi</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
