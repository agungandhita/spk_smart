@extends('dosen.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('dosen.pembimbing.show', $pengajuan->id) }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="h4 mb-1">Respon Pengajuan Pembimbing</h2>
                    <p class="text-muted mb-0">Berikan respon terhadap pengajuan dari {{ $pengajuan->mahasiswa->user->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-reply me-2"></i>Form Respon
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Approve Form -->
                    <div class="mb-4">
                        <h6 class="text-success">
                            <i class="fas fa-check-circle me-2"></i>Setujui Pengajuan
                        </h6>
                        <p class="text-muted small mb-3">
                            Dengan menyetujui, Anda akan menjadi pembimbing akademik untuk mahasiswa ini.
                        </p>
                        
                        <form action="{{ route('dosen.pembimbing.approve', $pengajuan->id) }}" 
                              method="POST" 
                              id="approveForm">
                            @csrf
                            <div class="mb-3">
                                <label for="catatan_approve" class="form-label">Catatan Persetujuan (Opsional)</label>
                                <textarea class="form-control" 
                                          id="catatan_approve" 
                                          name="catatan_dosen" 
                                          rows="3"
                                          placeholder="Berikan pesan atau arahan kepada mahasiswa..."></textarea>
                            </div>
                            
                            <button type="submit" 
                                    class="btn btn-success"
                                    onclick="return confirm('Yakin ingin menyetujui pengajuan ini? Anda akan menjadi pembimbing akademik untuk mahasiswa ini.')">
                                <i class="fas fa-check me-2"></i>Setujui Pengajuan
                            </button>
                        </form>
                    </div>

                    <hr>

                    <!-- Reject Form -->
                    <div class="mb-4">
                        <h6 class="text-danger">
                            <i class="fas fa-times-circle me-2"></i>Tolak Pengajuan
                        </h6>
                        <p class="text-muted small mb-3">
                            Berikan alasan yang jelas untuk membantu mahasiswa memahami keputusan ini.
                        </p>
                        
                        <form action="{{ route('dosen.pembimbing.reject', $pengajuan->id) }}" 
                              method="POST" 
                              id="rejectForm">
                            @csrf
                            <div class="mb-3">
                                <label for="catatan_reject" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('catatan_dosen') is-invalid @enderror" 
                                          id="catatan_reject" 
                                          name="catatan_dosen" 
                                          rows="4"
                                          placeholder="Jelaskan alasan penolakan secara detail..."
                                          required>{{ old('catatan_dosen') }}</textarea>
                                @error('catatan_dosen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Berikan feedback yang konstruktif untuk membantu mahasiswa
                                </div>
                            </div>
                            
                            <button type="submit" 
                                    class="btn btn-danger"
                                    onclick="return confirm('Yakin ingin menolak pengajuan ini? Pastikan Anda telah memberikan alasan yang jelas.')">
                                <i class="fas fa-times me-2"></i>Tolak Pengajuan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Pengajuan Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2"></i>Ringkasan Pengajuan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user-graduate text-white" style="font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="mb-1">{{ $pengajuan->mahasiswa->user->name }}</h6>
                        <p class="text-muted small mb-0">{{ $pengajuan->mahasiswa->nim }}</p>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Program Studi:</small>
                        <div class="fw-medium">{{ $pengajuan->mahasiswa->prodi }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Fakultas:</small>
                        <div class="fw-medium">{{ $pengajuan->mahasiswa->fakultas }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Semester:</small>
                        <div class="fw-medium">{{ $pengajuan->mahasiswa->semester ?: '-' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">IPK:</small>
                        <div class="fw-medium">{{ $pengajuan->mahasiswa->ipk ?: '-' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Minat Skripsi:</small>
                        <div class="fw-medium text-primary">{{ $pengajuan->minat_skripsi }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Tanggal Pengajuan:</small>
                        <div class="fw-medium">{{ $pengajuan->tanggal_pengajuan->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Compatibility Check -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-check-double me-2"></i>Kesesuaian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">Program Studi</span>
                            @if($pengajuan->mahasiswa->prodi === auth()->user()->dosen->prodi)
                                <span class="badge bg-success">Sesuai</span>
                            @else
                                <span class="badge bg-warning">Berbeda</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">Fakultas</span>
                            @if($pengajuan->mahasiswa->fakultas === auth()->user()->dosen->fakultas)
                                <span class="badge bg-success">Sesuai</span>
                            @else
                                <span class="badge bg-warning">Berbeda</span>
                            @endif
                        </div>
                    </div>
                    
                    @if(auth()->user()->dosen->bidang_keahlian)
                        <div class="alert alert-info small mb-0">
                            <strong>Bidang Keahlian Anda:</strong><br>
                            {{ auth()->user()->dosen->bidang_keahlian }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Guidelines -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>Panduan Respon
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <h6 class="text-success">Pertimbangan Menyetujui:</h6>
                        <ul class="mb-3">
                            <li>Minat skripsi sesuai dengan keahlian Anda</li>
                            <li>Program studi dan fakultas yang sama</li>
                            <li>Kapasitas bimbingan masih tersedia</li>
                            <li>Mahasiswa menunjukkan motivasi yang baik</li>
                        </ul>
                        
                        <h6 class="text-danger">Alasan Menolak:</h6>
                        <ul class="mb-0">
                            <li>Minat skripsi di luar bidang keahlian</li>
                            <li>Kapasitas bimbingan sudah penuh</li>
                            <li>Program studi tidak sesuai</li>
                            <li>Alasan akademik lainnya</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6>Deskripsi Minat Skripsi:</h6>
                    <div class="border rounded p-3 bg-light">
                        {{ $pengajuan->deskripsi_minat }}
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6>Alasan Memilih Anda:</h6>
                    <div class="border rounded p-3 bg-light">
                        {{ $pengajuan->alasan_memilih }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<div class="position-fixed bottom-0 end-0 p-3">
    <button type="button" class="btn btn-info btn-lg rounded-circle" data-bs-toggle="modal" data-bs-target="#detailModal">
        <i class="fas fa-info"></i>
    </button>
</div>
@endsection