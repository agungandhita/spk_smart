@extends('dosen.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('dosen.pembimbing.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="flex-grow-1">
                    <h2 class="h4 mb-1">Detail Pengajuan Pembimbing</h2>
                    <p class="text-muted mb-0">Informasi lengkap pengajuan dari mahasiswa</p>
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
            <!-- Mahasiswa Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2"></i>Informasi Mahasiswa
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Nama Lengkap</label>
                            <div class="fw-medium">{{ $pengajuan->mahasiswa->user->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">NIM</label>
                            <div class="fw-medium">{{ $pengajuan->mahasiswa->nim }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Program Studi</label>
                            <div class="fw-medium">{{ $pengajuan->mahasiswa->prodi }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Fakultas</label>
                            <div class="fw-medium">{{ $pengajuan->mahasiswa->fakultas }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Semester</label>
                            <div class="fw-medium">{{ $pengajuan->mahasiswa->semester ?: '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">IPK</label>
                            <div class="fw-medium">{{ $pengajuan->mahasiswa->ipk ?: '-' }}</div>
                        </div>
                        @if($pengajuan->mahasiswa->user->email)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Email</label>
                                <div class="fw-medium">
                                    <a href="mailto:{{ $pengajuan->mahasiswa->user->email }}" class="text-decoration-none">
                                        {{ $pengajuan->mahasiswa->user->email }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($pengajuan->mahasiswa->no_telepon)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">No. Telepon</label>
                                <div class="fw-medium">{{ $pengajuan->mahasiswa->no_telepon }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pengajuan Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Detail Pengajuan
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
                        <div class="fw-medium text-primary fs-5">{{ $pengajuan->minat_skripsi }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Deskripsi Minat Skripsi</label>
                        <div class="border rounded p-3 bg-light">
                            {{ $pengajuan->deskripsi_minat }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Alasan Memilih Anda sebagai Pembimbing</label>
                        <div class="border rounded p-3 bg-light">
                            {{ $pengajuan->alasan_memilih }}
                        </div>
                    </div>
                    
                    @if($pengajuan->catatan_dosen)
                        <div class="mb-3">
                            <label class="form-label text-muted small">Catatan Anda</label>
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
                            Pengajuan ini menunggu respon dari Anda. Silakan setujui atau tolak pengajuan ini.
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('dosen.pembimbing.respond', $pengajuan->id) }}" class="btn btn-warning">
                                <i class="fas fa-reply me-2"></i>Berikan Respon
                            </a>
                            
                            <!-- Quick Actions -->
                            <form action="{{ route('dosen.pembimbing.approve', $pengajuan->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menyetujui pengajuan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-2"></i>Setujui
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times me-2"></i>Tolak
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Timeline -->
            <div class="card shadow-sm mb-4">
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
                                    <h6 class="timeline-title">Menunggu Respon Anda</h6>
                                    <p class="timeline-text text-muted small mb-0">
                                        Pengajuan menunggu persetujuan
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Compatibility Analysis -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Analisis Kesesuaian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Program Studi</small>
                        <div class="d-flex align-items-center">
                            @if($pengajuan->mahasiswa->prodi === auth()->user()->dosen->prodi)
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="text-success">Sesuai</span>
                            @else
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                <span class="text-warning">Berbeda</span>
                            @endif
                        </div>
                        <small class="text-muted">
                            Mahasiswa: {{ $pengajuan->mahasiswa->prodi }}<br>
                            Anda: {{ auth()->user()->dosen->prodi }}
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Fakultas</small>
                        <div class="d-flex align-items-center">
                            @if($pengajuan->mahasiswa->fakultas === auth()->user()->dosen->fakultas)
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="text-success">Sesuai</span>
                            @else
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                <span class="text-warning">Berbeda</span>
                            @endif
                        </div>
                        <small class="text-muted">
                            Mahasiswa: {{ $pengajuan->mahasiswa->fakultas }}<br>
                            Anda: {{ auth()->user()->dosen->fakultas }}
                        </small>
                    </div>
                    
                    @if(auth()->user()->dosen->bidang_keahlian)
                        <div class="mb-3">
                            <small class="text-muted">Bidang Keahlian Anda</small>
                            <div class="fw-medium">{{ auth()->user()->dosen->bidang_keahlian }}</div>
                        </div>
                    @endif
                    
                    <div class="alert alert-info small mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Pertimbangkan kesesuaian minat skripsi mahasiswa dengan bidang keahlian Anda sebelum memberikan respon.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dosen.pembimbing.reject', $pengajuan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="catatan_dosen" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" 
                                  id="catatan_dosen" 
                                  name="catatan_dosen" 
                                  rows="4"
                                  placeholder="Jelaskan alasan penolakan untuk memberikan feedback kepada mahasiswa..."
                                  required></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pastikan Anda memberikan alasan yang jelas untuk membantu mahasiswa memahami keputusan ini.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                </div>
            </form>
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