@extends('mahasiswa.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Rekomendasi Judul Skripsi</h2>
                    <p class="text-muted mb-0">Daftar rekomendasi judul skripsi dari dosen pembimbing</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>Filter Status
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request('status') == '' ? 'active' : '' }}" 
                                   href="{{ route('mahasiswa.rekomendasi.index') }}">Semua Status</a></li>
                            <li><a class="dropdown-item {{ request('status') == 'dikirim' ? 'active' : '' }}" 
                                   href="{{ route('mahasiswa.rekomendasi.index', ['status' => 'dikirim']) }}">Menunggu Respon</a></li>
                            <li><a class="dropdown-item {{ request('status') == 'diterima' ? 'active' : '' }}" 
                                   href="{{ route('mahasiswa.rekomendasi.index', ['status' => 'diterima']) }}">Diterima</a></li>
                            <li><a class="dropdown-item {{ request('status') == 'ditolak' ? 'active' : '' }}" 
                                   href="{{ route('mahasiswa.rekomendasi.index', ['status' => 'ditolak']) }}">Ditolak</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Rekomendasi</h6>
                            <h3 class="mb-0">{{ $totalRekomendasi }}</h3>
                        </div>
                        <i class="fas fa-lightbulb fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Menunggu Respon</h6>
                            <h3 class="mb-0">{{ $menungguRespon }}</h3>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Diterima</h6>
                            <h3 class="mb-0">{{ $diterima }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Ditolak</h6>
                            <h3 class="mb-0">{{ $ditolak }}</h3>
                        </div>
                        <i class="fas fa-times-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations List -->
    <div class="row">
        <div class="col-12">
            @if($rekomendasi->count() > 0)
                <div class="row">
                    @foreach($rekomendasi as $item)
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-lightbulb text-primary me-2"></i>
                                        <h6 class="card-title mb-0">Rekomendasi #{{ $item->id }}</h6>
                                    </div>
                                    <span class="badge {{ $item->status_badge }}">{{ $item->status_text }}</span>
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title text-primary mb-3">{{ $item->judul_skripsi }}</h5>
                                    
                                    <div class="mb-3">
                                        <p class="text-muted mb-2">{{ Str::limit($item->deskripsi_judul, 120) }}</p>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Tipe Skripsi:</small>
                                            <span class="fw-medium text-capitalize">{{ str_replace('_', ' ', $item->tipe_skripsi) }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Bidang Keahlian:</small>
                                            <span class="fw-medium">{{ $item->bidang_keahlian }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Tingkat Kesulitan:</small>
                                            <span class="badge {{ $item->difficulty_badge }}">{{ $item->difficulty_text }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Skor SMART:</small>
                                            <span class="fw-bold text-success">{{ $item->skor_smart }}/100</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Dosen Pembimbing:</small>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-tie text-secondary me-2"></i>
                                            <span class="fw-medium">{{ $item->dosen->user->name }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Tanggal Dikirim:</small>
                                        <span class="fw-medium">{{ $item->tanggal_dikirim ? $item->tanggal_dikirim->format('d/m/Y H:i') : '-' }}</span>
                                    </div>
                                    
                                    @if($item->tanggal_respon)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tanggal Respon:</small>
                                            <span class="fw-medium">{{ $item->tanggal_respon->format('d/m/Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('mahasiswa.rekomendasi.show', $item->id) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        
                                        @if($item->status === 'dikirim')
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('mahasiswa.rekomendasi.respond', $item->id) }}" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-check me-1"></i>Terima
                                                </a>
                                                <a href="{{ route('mahasiswa.rekomendasi.respond', $item->id) }}" 
                                                   class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times me-1"></i>Tolak
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($rekomendasi->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $rekomendasi->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-lightbulb text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum Ada Rekomendasi</h4>
                        <p class="text-muted mb-4">
                            @if(request('status'))
                                Tidak ada rekomendasi dengan status "{{ request('status') }}" saat ini.
                            @else
                                Anda belum menerima rekomendasi judul skripsi dari dosen pembimbing.
                            @endif
                        </p>
                        
                        @if(request('status'))
                            <a href="{{ route('mahasiswa.rekomendasi.index') }}" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>Lihat Semua Rekomendasi
                            </a>
                        @else
                            <div class="alert alert-info d-inline-block">
                                <i class="fas fa-info-circle me-2"></i>
                                Pastikan Anda sudah mengajukan dosen pembimbing dan menunggu persetujuan.
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif

<script>
// Auto hide toasts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(function(toast) {
        setTimeout(function() {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 5000);
    });
});
</script>
@endsection