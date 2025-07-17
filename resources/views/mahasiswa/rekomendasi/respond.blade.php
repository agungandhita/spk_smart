@extends('mahasiswa.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Respon Rekomendasi Judul Skripsi</h2>
                    <p class="text-muted mb-0">Berikan respon terhadap rekomendasi dari dosen pembimbing</p>
                </div>
                <a href="{{ route('mahasiswa.rekomendasi.show', $rekomendasi->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Recommendation Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>Ringkasan Rekomendasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-primary mb-3">{{ $rekomendasi->judul_skripsi }}</h4>
                            <p class="text-muted mb-3">{{ $rekomendasi->deskripsi_judul }}</p>
                            
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Tipe Skripsi:</small>
                                    <span class="fw-medium text-capitalize">{{ str_replace('_', ' ', $rekomendasi->tipe_skripsi) }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Bidang Keahlian:</small>
                                    <span class="fw-medium">{{ $rekomendasi->bidang_keahlian }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="display-6 text-success fw-bold">{{ $rekomendasi->skor_smart }}</div>
                                <div class="text-muted">Skor SMART</div>
                                <span class="badge {{ $rekomendasi->difficulty_badge }} mt-2">{{ $rekomendasi->difficulty_text }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-comment me-2"></i>Berikan Respon Anda
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Accept Form -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white text-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-check-circle me-2"></i>Terima Rekomendasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('mahasiswa.rekomendasi.accept', $rekomendasi->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <div class="mb-3">
                                            <label for="catatan_terima" class="form-label">Catatan (Opsional)</label>
                                            <textarea class="form-control" id="catatan_terima" name="catatan" rows="4" 
                                                      placeholder="Berikan catatan atau alasan mengapa Anda menerima rekomendasi ini...">{{ old('catatan') }}</textarea>
                                            @error('catatan')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="alert alert-success">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Dengan menerima rekomendasi ini:</strong>
                                            <ul class="mb-0 mt-2">
                                                <li>Anda menyetujui untuk mengerjakan judul skripsi ini</li>
                                                <li>Dosen pembimbing akan mendapat notifikasi</li>
                                                <li>Anda dapat melanjutkan ke tahap bimbingan skripsi</li>
                                            </ul>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success w-100" 
                                                onclick="return confirm('Apakah Anda yakin ingin menerima rekomendasi ini?')">
                                            <i class="fas fa-check me-2"></i>Terima Rekomendasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card border-danger h-100">
                                <div class="card-header bg-danger text-white text-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-times-circle me-2"></i>Tolak Rekomendasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('mahasiswa.rekomendasi.reject', $rekomendasi->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <div class="mb-3">
                                            <label for="catatan_tolak" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                                      id="catatan_tolak" name="catatan" rows="4" required
                                                      placeholder="Berikan alasan mengapa Anda menolak rekomendasi ini...">{{ old('catatan') }}</textarea>
                                            @error('catatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Dengan menolak rekomendasi ini:</strong>
                                            <ul class="mb-0 mt-2">
                                                <li>Dosen akan mendapat feedback dari Anda</li>
                                                <li>Dosen dapat memberikan rekomendasi alternatif</li>
                                                <li>Anda dapat menunggu rekomendasi baru</li>
                                            </ul>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-danger w-100" 
                                                onclick="return confirm('Apakah Anda yakin ingin menolak rekomendasi ini?')">
                                            <i class="fas fa-times me-2"></i>Tolak Rekomendasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- SMART Analysis -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Analisis Kesesuaian
                    </h6>
                </div>
                <div class="card-body">
                    @if($rekomendasi->kriteria_smart)
                        @php
                            $kriteria = $rekomendasi->kriteria_smart;
                            $labels = [
                                'ipk_score' => ['IPK (30%)', 'fas fa-graduation-cap', 'primary'],
                                'semester_score' => ['Semester (20%)', 'fas fa-calendar', 'info'],
                                'minat_match' => ['Minat (25%)', 'fas fa-heart', 'warning'],
                                'dosen_expertise' => ['Keahlian Dosen (15%)', 'fas fa-user-tie', 'secondary'],
                                'difficulty_score' => ['Kesulitan (10%)', 'fas fa-chart-bar', 'danger']
                            ];
                        @endphp
                        
                        @foreach($labels as $key => $label)
                            @if(isset($kriteria[$key]))
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-medium">
                                            <i class="{{ $label[1] }} text-{{ $label[2] }} me-1"></i>
                                            {{ $label[0] }}
                                        </small>
                                        <small class="text-{{ $label[2] }} fw-bold">{{ number_format($kriteria[$key], 1) }}%</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $label[2] }}" 
                                             style="width: {{ $kriteria[$key] }}%"></div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Lecturer Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-tie me-2"></i>Dosen Pembimbing
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px;">
                            <i class="fas fa-user-tie text-white fa-lg"></i>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>{{ $rekomendasi->dosen->user->name }}</strong>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted d-block">NIDN:</small>
                        <span>{{ $rekomendasi->dosen->nidn }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted d-block">Bidang Keahlian:</small>
                        <span>{{ $rekomendasi->dosen->bidang_keahlian }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted d-block">Email:</small>
                        <span>{{ $rekomendasi->dosen->user->email }}</span>
                    </div>
                </div>
            </div>

            <!-- Requirements Check -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>Persyaratan
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $mahasiswa = auth()->user()->mahasiswa;
                        $nilaiTerbaru = $mahasiswa->nilai->last();
                        $ipkMemenuhi = $nilaiTerbaru && $nilaiTerbaru->ipk >= $rekomendasi->ipk_minimum;
                        $semesterMemenuhi = $nilaiTerbaru && $nilaiTerbaru->semester >= $rekomendasi->semester_minimum;
                    @endphp
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>IPK Minimum: {{ $rekomendasi->ipk_minimum }}</span>
                            @if($ipkMemenuhi)
                                <i class="fas fa-check-circle text-success"></i>
                            @else
                                <i class="fas fa-times-circle text-danger"></i>
                            @endif
                        </div>
                        @if($nilaiTerbaru)
                            <small class="text-muted">IPK Anda: {{ $nilaiTerbaru->ipk }}</small>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Semester Minimum: {{ $rekomendasi->semester_minimum }}</span>
                            @if($semesterMemenuhi)
                                <i class="fas fa-check-circle text-success"></i>
                            @else
                                <i class="fas fa-times-circle text-danger"></i>
                            @endif
                        </div>
                        @if($nilaiTerbaru)
                            <small class="text-muted">Semester Anda: {{ $nilaiTerbaru->semester }}</small>
                        @endif
                    </div>
                    
                    @if($rekomendasi->prasyarat)
                        <div class="mb-3">
                            <strong>Prasyarat Tambahan:</strong>
                            <div class="text-muted small mt-1">{{ $rekomendasi->prasyarat }}</div>
                        </div>
                    @endif
                    
                    @if(!$ipkMemenuhi || !$semesterMemenuhi)
                        <div class="alert alert-warning small">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Anda belum memenuhi semua persyaratan minimum.
                        </div>
                    @else
                        <div class="alert alert-success small">
                            <i class="fas fa-check-circle me-1"></i>
                            Anda memenuhi semua persyaratan.
                        </div>
                    @endif
                </div>
            </div>
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