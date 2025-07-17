@extends('dosen.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Pengajuan Pembimbing Akademik</h2>
                    <p class="text-muted mb-0">Kelola pengajuan mahasiswa yang ingin Anda bimbing</p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-warning fs-6">{{ $pengajuanPending->count() }} Menunggu</span>
                    <span class="badge bg-success fs-6">{{ $pengajuanDisetujui->count() }} Disetujui</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Pengajuan Pending</h6>
                            <h3 class="mb-0">{{ $pengajuanPending->count() }}</h3>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Mahasiswa Bimbingan</h6>
                            <h3 class="mb-0">{{ $pengajuanDisetujui->count() }}</h3>
                        </div>
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Pengajuan Ditolak</h6>
                            <h3 class="mb-0">{{ $pengajuanDitolak->count() }}</h3>
                        </div>
                        <i class="fas fa-times-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Total Pengajuan</h6>
                            <h3 class="mb-0">{{ $semuaPengajuan->count() }}</h3>
                        </div>
                        <i class="fas fa-list fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs" id="pengajuanTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                        <i class="fas fa-clock me-2"></i>Menunggu Persetujuan ({{ $pengajuanPending->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disetujui-tab" data-bs-toggle="tab" data-bs-target="#disetujui" type="button" role="tab">
                        <i class="fas fa-check-circle me-2"></i>Mahasiswa Bimbingan ({{ $pengajuanDisetujui->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua" type="button" role="tab">
                        <i class="fas fa-list me-2"></i>Semua Pengajuan ({{ $semuaPengajuan->count() }})
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="pengajuanTabsContent">
        <!-- Pending Tab -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            @if($pengajuanPending->count() > 0)
                <div class="row">
                    @foreach($pengajuanPending as $pengajuan)
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-warning">
                                <div class="card-header bg-warning bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-user-graduate me-2"></i>{{ $pengajuan->mahasiswa->user->name }}
                                        </h6>
                                        <span class="badge bg-warning">{{ $pengajuan->status_text }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">NIM:</small>
                                        <div class="fw-medium">{{ $pengajuan->mahasiswa->nim }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Program Studi:</small>
                                        <div class="fw-medium">{{ $pengajuan->mahasiswa->prodi }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Minat Skripsi:</small>
                                        <div class="fw-medium text-primary">{{ $pengajuan->minat_skripsi }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Deskripsi:</small>
                                        <div class="text-truncate" style="max-height: 60px; overflow: hidden;">
                                            {{ Str::limit($pengajuan->deskripsi_minat, 100) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Tanggal Pengajuan:</small>
                                        <div class="fw-medium">{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('dosen.pembimbing.show', $pengajuan->id) }}" class="btn btn-outline-info btn-sm flex-fill">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <a href="{{ route('dosen.pembimbing.respond', $pengajuan->id) }}" class="btn btn-warning btn-sm flex-fill">
                                            <i class="fas fa-reply me-1"></i>Respon
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox text-muted fa-3x mb-3"></i>
                    <h5 class="text-muted">Tidak ada pengajuan yang menunggu persetujuan</h5>
                    <p class="text-muted">Pengajuan baru akan muncul di sini</p>
                </div>
            @endif
        </div>

        <!-- Disetujui Tab -->
        <div class="tab-pane fade" id="disetujui" role="tabpanel">
            @if($pengajuanDisetujui->count() > 0)
                <div class="row">
                    @foreach($pengajuanDisetujui as $pengajuan)
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-success">
                                <div class="card-header bg-success bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-user-graduate me-2"></i>{{ $pengajuan->mahasiswa->user->name }}
                                        </h6>
                                        <span class="badge bg-success">{{ $pengajuan->status_text }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">NIM:</small>
                                        <div class="fw-medium">{{ $pengajuan->mahasiswa->nim }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Program Studi:</small>
                                        <div class="fw-medium">{{ $pengajuan->mahasiswa->prodi }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Minat Skripsi:</small>
                                        <div class="fw-medium text-primary">{{ $pengajuan->minat_skripsi }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Disetujui:</small>
                                        <div class="fw-medium">{{ $pengajuan->tanggal_respon->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('dosen.pembimbing.show', $pengajuan->id) }}" class="btn btn-outline-success btn-sm w-100">
                                        <i class="fas fa-eye me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users text-muted fa-3x mb-3"></i>
                    <h5 class="text-muted">Belum ada mahasiswa bimbingan</h5>
                    <p class="text-muted">Mahasiswa yang Anda setujui akan muncul di sini</p>
                </div>
            @endif
        </div>

        <!-- Semua Tab -->
        <div class="tab-pane fade" id="semua" role="tabpanel">
            @if($semuaPengajuan->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Minat Skripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($semuaPengajuan as $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                             style="width: 32px; height: 32px;">
                                                            <i class="fas fa-user-graduate text-white" style="font-size: 0.8rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $pengajuan->mahasiswa->user->name }}</div>
                                                        <small class="text-muted">{{ $pengajuan->mahasiswa->prodi }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $pengajuan->mahasiswa->nim }}</td>
                                            <td>{{ Str::limit($pengajuan->minat_skripsi, 30) }}</td>
                                            <td>
                                                <span class="badge {{ $pengajuan->status_badge }}">
                                                    {{ $pengajuan->status_text }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('dosen.pembimbing.show', $pengajuan->id) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($pengajuan->status === 'pending')
                                                    <a href="{{ route('dosen.pembimbing.respond', $pengajuan->id) }}" 
                                                       class="btn btn-sm btn-outline-warning ms-1">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox text-muted fa-3x mb-3"></i>
                    <h5 class="text-muted">Belum ada pengajuan</h5>
                    <p class="text-muted">Pengajuan dari mahasiswa akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection