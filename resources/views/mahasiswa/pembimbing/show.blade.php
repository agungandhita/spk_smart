@extends('mahasiswa.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('mahasiswa.pembimbing.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex-grow-1">
                    <h2 class="h4 mb-1">Detail Pengajuan Pembimbing</h2>
                    <p class="text-muted mb-0">Informasi lengkap pengajuan pembimbing akademik</p>
                </div>
                <div>
                    <span class="badge {{ $pengajuan->status_badge }} fs-6">
                        {{ $pengajuan->status_text }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Pengajuan Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pengajuan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Tanggal Pengajuan</label>
                            <div class="fw-medium">{{ $pengajuan->tanggal_pengajuan->format('d F Y, H:i') }} WIB</div>
                        </div>
                        @if($pengajuan->tanggal_respon)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Tanggal Respon</label>
                                <div class="fw-medium">{{ $pengajuan->tanggal_respon->format('d F Y, H:i') }} WIB</div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Minat Skripsi</label>
                        <div class="fw-medium">{{ $pengajuan->minat_skripsi }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Deskripsi Minat</label>
                        <div class="text-justify">{{ $pengajuan->deskripsi_minat }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Alasan Memilih Dosen</label>
                        <div class="text-justify">{{ $pengajuan->alasan_memilih }}</div>
                    </div>
                    
                    @if($pengajuan->catatan_dosen)
                        <div class="mb-3">
                            <label class="form-label text-muted small">Catatan dari Dosen</label>
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-comment me-2"></i>{{ $pengajuan->catatan_dosen }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($pengajuan->status === 'pending')
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>Aksi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Pengajuan Anda sedang menunggu persetujuan dari dosen. Anda dapat membatalkan pengajuan jika diperlukan.
                        </div>
                        
                        <form action="{{ route('mahasiswa.pembimbing.cancel', $pengajuan->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>Batalkan Pengajuan
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Dosen Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-tie me-2"></i>Informasi Dosen
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($pengajuan->dosen->foto && Storage::disk('public')->exists($pengajuan->dosen->foto))
                            <img src="{{ Storage::disk('public')->url($pengajuan->dosen->foto) }}" 
                                 alt="Foto Dosen" 
                                 class="rounded-circle" 
                                 width="100" 
                                 height="100" 
                                 style="object-fit: cover;">
                        @else
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-user-tie text-white" style="font-size: 2.5rem;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h5 class="card-title mb-1">{{ $pengajuan->dosen->user->name }}</h5>
                    <p class="text-muted mb-2">{{ $pengajuan->dosen->nidn }}</p>
                    
                    <div class="text-start">
                        <div class="mb-2">
                            <small class="text-muted">Jabatan Akademik:</small>
                            <div class="fw-medium">{{ $pengajuan->dosen->jabatan_akademik ?: '-' }}</div>
                        </div>
                        
                        @if($pengajuan->dosen->bidang_keahlian)
                            <div class="mb-2">
                                <small class="text-muted">Bidang Keahlian:</small>
                                <div class="fw-medium">{{ $pengajuan->dosen->bidang_keahlian }}</div>
                            </div>
                        @endif
                        
                        <div class="mb-2">
                            <small class="text-muted">Pendidikan Terakhir:</small>
                            <div class="fw-medium">{{ $pengajuan->dosen->pendidikan_terakhir ?: '-' }}</div>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted">Program Studi:</small>
                            <div class="fw-medium">{{ $pengajuan->dosen->prodi ?: '-' }}</div>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted">Fakultas:</small>
                            <div class="fw-medium">{{ $pengajuan->dosen->fakultas ?: '-' }}</div>
                        </div>
                        
                        @if($pengajuan->dosen->user->email)
                            <div class="mb-2">
                                <small class="text-muted">Email:</small>
                                <div class="fw-medium">
                                    <a href="mailto:{{ $pengajuan->dosen->user->email }}" class="text-decoration-none">
                                        {{ $pengajuan->dosen->user->email }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        @if($pengajuan->dosen->no_telepon)
                            <div class="mb-2">
                                <small class="text-muted">No. Telepon:</small>
                                <div class="fw-medium">{{ $pengajuan->dosen->no_telepon }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Timeline Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Pengajuan Dibuat -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pengajuan Dibuat</h6>
                                <p class="timeline-text text-muted small mb-0">
                                    {{ $pengajuan->tanggal_pengajuan->format('d F Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>
                        
                        @if($pengajuan->status === 'disetujui')
                            <!-- Disetujui -->
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Pengajuan Disetujui</h6>
                                    <p class="timeline-text text-muted small mb-0">
                                        {{ $pengajuan->tanggal_respon->format('d F Y, H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        @elseif($pengajuan->status === 'ditolak')
                            <!-- Ditolak -->
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Pengajuan Ditolak</h6>
                                    <p class="timeline-text text-muted small mb-0">
                                        {{ $pengajuan->tanggal_respon->format('d F Y, H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        @else
                            <!-- Menunggu -->
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Menunggu Persetujuan</h6>
                                    <p class="timeline-text text-muted small mb-0">
                                        Pengajuan sedang ditinjau oleh dosen
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 15px;
}

.timeline-title {
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.timeline-text {
    font-size: 0.8rem;
}
</style>
@endsection