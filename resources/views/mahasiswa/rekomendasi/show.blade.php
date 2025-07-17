@extends('mahasiswa.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Detail Rekomendasi Judul Skripsi</h2>
                    <p class="text-muted mb-0">{{ $rekomendasi->judul_skripsi }}</p>
                </div>
                <div class="d-flex gap-2">
                    @if($rekomendasi->status === 'dikirim')
                        <a href="{{ route('mahasiswa.rekomendasi.respond', $rekomendasi->id) }}" 
                           class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Terima Rekomendasi
                        </a>
                        <a href="{{ route('mahasiswa.rekomendasi.respond', $rekomendasi->id) }}" 
                           class="btn btn-danger">
                            <i class="fas fa-times me-2"></i>Tolak Rekomendasi
                        </a>
                    @endif
                    <a href="{{ route('mahasiswa.rekomendasi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Judul Skripsi -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb me-2"></i>Informasi Judul Skripsi
                        </h5>
                        <span class="badge {{ $rekomendasi->status_badge }} fs-6">{{ $rekomendasi->status_text }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Skripsi:</label>
                        <div class="fs-4 text-primary fw-medium mb-3">{{ $rekomendasi->judul_skripsi }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi:</label>
                        <div class="text-muted fs-6 lh-lg">{{ $rekomendasi->deskripsi_judul }}</div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tipe Skripsi:</label>
                            <div class="text-capitalize fs-6">{{ str_replace('_', ' ', $rekomendasi->tipe_skripsi) }}</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Bidang Keahlian:</label>
                            <div class="fs-6">{{ $rekomendasi->bidang_keahlian }}</div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tingkat Kesulitan:</label>
                            <div>
                                <span class="badge {{ $rekomendasi->difficulty_badge }} fs-6">{{ $rekomendasi->difficulty_text }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">IPK Minimum:</label>
                            <div class="fs-6">{{ $rekomendasi->ipk_minimum }}</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Semester Minimum:</label>
                            <div class="fs-6">{{ $rekomendasi->semester_minimum }}</div>
                        </div>
                    </div>
                    
                    @if($rekomendasi->prasyarat)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Prasyarat:</label>
                            <div class="text-muted fs-6">{{ $rekomendasi->prasyarat }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SMART Analysis -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Analisis Kesesuaian (SMART)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="text-center">
                                <div class="display-3 text-success fw-bold">{{ $rekomendasi->skor_smart }}</div>
                                <div class="text-muted fs-5">Skor Kesesuaian (dari 100)</div>
                                <div class="mt-2">
                                    @if($rekomendasi->skor_smart >= 80)
                                        <span class="badge bg-success fs-6">Sangat Sesuai</span>
                                    @elseif($rekomendasi->skor_smart >= 60)
                                        <span class="badge bg-warning fs-6">Cukup Sesuai</span>
                                    @else
                                        <span class="badge bg-danger fs-6">Kurang Sesuai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="progress mb-3" style="height: 30px;">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ $rekomendasi->skor_smart }}%" 
                                     aria-valuenow="{{ $rekomendasi->skor_smart }}" 
                                     aria-valuemin="0" aria-valuemax="100">
                                    {{ $rekomendasi->skor_smart }}%
                                </div>
                            </div>
                            <div class="text-center">
                                <small class="text-muted">Tingkat Kesesuaian Rekomendasi dengan Profil Anda</small>
                            </div>
                        </div>
                    </div>
                    
                    @if($rekomendasi->kriteria_smart)
                        <h6 class="mb-3">Detail Analisis Kriteria:</h6>
                        <div class="row">
                            @php
                                $kriteria = $rekomendasi->kriteria_smart;
                                $labels = [
                                    'ipk_score' => ['Nilai IPK (30%)', 'fas fa-graduation-cap', 'primary', 'Berdasarkan IPK terbaru Anda'],
                                    'semester_score' => ['Semester (20%)', 'fas fa-calendar', 'info', 'Berdasarkan semester saat ini'],
                                    'minat_match' => ['Kesesuaian Minat (25%)', 'fas fa-heart', 'warning', 'Berdasarkan minat skripsi yang Anda pilih'],
                                    'dosen_expertise' => ['Keahlian Dosen (15%)', 'fas fa-user-tie', 'secondary', 'Berdasarkan bidang keahlian dosen pembimbing'],
                                    'difficulty_score' => ['Tingkat Kesulitan (10%)', 'fas fa-chart-bar', 'danger', 'Berdasarkan kompleksitas judul skripsi']
                                ];
                            @endphp
                            
                            @foreach($labels as $key => $label)
                                @if(isset($kriteria[$key]))
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-{{ $label[2] }}">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="me-3">
                                                        <i class="{{ $label[1] }} text-{{ $label[2] }} fa-lg"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold">{{ $label[0] }}</div>
                                                        <small class="text-muted">{{ $label[3] }}</small>
                                                    </div>
                                                </div>
                                                <div class="progress mb-2" style="height: 12px;">
                                                    <div class="progress-bar bg-{{ $label[2] }}" 
                                                         style="width: {{ $kriteria[$key] }}%"></div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Skor: {{ number_format($kriteria[$key], 2) }}/100</small>
                                                    <small class="text-{{ $label[2] }} fw-bold">{{ number_format($kriteria[$key], 1) }}%</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Penjelasan SMART:</strong> Sistem menggunakan metode SMART (Simple Multi-Attribute Rating Technique) 
                            untuk menghitung kesesuaian rekomendasi berdasarkan profil akademik dan minat Anda.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Your Response -->
            @if($rekomendasi->status !== 'dikirim' && $rekomendasi->catatan_mahasiswa)
                <div class="card shadow-sm">
                    <div class="card-header {{ $rekomendasi->status === 'diterima' ? 'bg-success' : 'bg-danger' }} text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-comment me-2"></i>Respon Anda
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Status Respon:</strong> 
                            <span class="badge {{ $rekomendasi->status_badge }} fs-6">{{ $rekomendasi->status_text }}</span>
                        </div>
                        
                        @if($rekomendasi->tanggal_respon)
                            <div class="mb-3">
                                <strong>Tanggal Respon:</strong> {{ $rekomendasi->tanggal_respon->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        
                        <div class="mb-2">
                            <strong>Catatan Anda:</strong>
                            <div class="text-muted mt-2 p-3 bg-light rounded">{{ $rekomendasi->catatan_mahasiswa }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Lecturer Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-tie me-2"></i>Dosen Pembimbing
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user-tie text-white fa-2x"></i>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Nama:</strong>
                        <div>{{ $rekomendasi->dosen->user->name }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>NIDN:</strong>
                        <div>{{ $rekomendasi->dosen->nidn }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Bidang Keahlian:</strong>
                        <div>{{ $rekomendasi->dosen->bidang_keahlian }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Email:</strong>
                        <div>{{ $rekomendasi->dosen->user->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Academic Profile -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2"></i>Profil Akademik Anda
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $mahasiswa = auth()->user()->mahasiswa;
                        $nilaiTerbaru = $mahasiswa->nilai->last();
                    @endphp
                    
                    <div class="mb-2">
                        <strong>NIM:</strong>
                        <div>{{ $mahasiswa->nim }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Program Studi:</strong>
                        <div>{{ $mahasiswa->prodi }}</div>
                    </div>
                    
                    @if($nilaiTerbaru)
                        <div class="mb-2">
                            <strong>IPK Terbaru:</strong>
                            <div class="text-primary fw-bold">{{ $nilaiTerbaru->ipk }}</div>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Semester:</strong>
                            <div>{{ $nilaiTerbaru->semester }}</div>
                        </div>
                    @endif
                    
                    @php
                        $pengajuanAktif = $mahasiswa->pengajuanAktif;
                    @endphp
                    
                    @if($pengajuanAktif)
                        <div class="mb-2">
                            <strong>Minat Skripsi:</strong>
                            <div class="text-info">{{ $pengajuanAktif->minat_skripsi }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Timeline Rekomendasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Created -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Rekomendasi Dibuat</h6>
                                <p class="timeline-text">{{ $rekomendasi->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($rekomendasi->tanggal_dikirim)
                            <!-- Sent -->
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Dikirim ke Anda</h6>
                                    <p class="timeline-text">{{ $rekomendasi->tanggal_dikirim->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($rekomendasi->tanggal_respon)
                            <!-- Response -->
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $rekomendasi->status === 'diterima' ? 'bg-success' : 'bg-danger' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">{{ $rekomendasi->status === 'diterima' ? 'Anda Terima' : 'Anda Tolak' }}</h6>
                                    <p class="timeline-text">{{ $rekomendasi->tanggal_respon->format('d/m/Y H:i') }}</p>
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
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #dee2e6;
}

.timeline-title {
    margin: 0 0 5px 0;
    font-size: 14px;
    font-weight: 600;
}

.timeline-text {
    margin: 0;
    font-size: 13px;
    color: #6c757d;
}
</style>
@endsection