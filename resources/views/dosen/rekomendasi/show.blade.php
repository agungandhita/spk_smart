@extends('dosen.layouts.main')

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
                    @if($rekomendasi->status === 'draft')
                        <form action="{{ route('dosen.rekomendasi.send', $rekomendasi->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('Kirim rekomendasi ini ke mahasiswa?')">
                                <i class="fas fa-paper-plane me-2"></i>Kirim ke Mahasiswa
                            </button>
                        </form>
                        <form action="{{ route('dosen.rekomendasi.destroy', $rekomendasi->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Hapus rekomendasi ini?')">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('dosen.rekomendasi.index') }}" class="btn btn-outline-secondary">
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
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Skripsi:</label>
                        <div class="fs-5 text-primary fw-medium">{{ $rekomendasi->judul_skripsi }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi:</label>
                        <div class="text-muted">{{ $rekomendasi->deskripsi_judul }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tipe Skripsi:</label>
                            <div class="text-capitalize">{{ str_replace('_', ' ', $rekomendasi->tipe_skripsi) }}</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Bidang Keahlian:</label>
                            <div>{{ $rekomendasi->bidang_keahlian }}</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tingkat Kesulitan:</label>
                            <div>
                                <span class="badge {{ $rekomendasi->difficulty_badge }}">{{ $rekomendasi->difficulty_text }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">IPK Minimum:</label>
                            <div>{{ $rekomendasi->ipk_minimum }}</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Semester Minimum:</label>
                            <div>{{ $rekomendasi->semester_minimum }}</div>
                        </div>
                    </div>
                    
                    @if($rekomendasi->prasyarat)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Prasyarat:</label>
                            <div class="text-muted">{{ $rekomendasi->prasyarat }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SMART Analysis -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Analisis SMART
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="text-center">
                                <div class="display-4 text-success fw-bold">{{ $rekomendasi->skor_smart }}</div>
                                <div class="text-muted">Skor SMART (dari 100)</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $rekomendasi->skor_smart }}%" 
                                     aria-valuenow="{{ $rekomendasi->skor_smart }}" 
                                     aria-valuemin="0" aria-valuemax="100">
                                    {{ $rekomendasi->skor_smart }}%
                                </div>
                            </div>
                            <small class="text-muted">Tingkat Kesesuaian Rekomendasi</small>
                        </div>
                    </div>
                    
                    @if($rekomendasi->kriteria_smart)
                        <h6 class="mb-3">Detail Perhitungan SMART:</h6>
                        
                        @if(isset($rekomendasi->kriteria_smart['methodology']))
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Metodologi:</strong> {{ $rekomendasi->kriteria_smart['methodology'] }}
                                @if(isset($rekomendasi->kriteria_smart['calculation_date']))
                                    <br><small>Dihitung pada: {{ \Carbon\Carbon::parse($rekomendasi->kriteria_smart['calculation_date'])->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>
                        @endif
                        
                        @if(isset($rekomendasi->kriteria_smart['criteria_values']))
                            <div class="row">
                                @php
                                    $criteriaValues = $rekomendasi->kriteria_smart['criteria_values'];
                                    $criteriaWeights = $rekomendasi->kriteria_smart['criteria_weights'] ?? [];
                                    $labels = [
                                        'ipk' => ['IPK', 'fas fa-graduation-cap', 'primary'],
                                        'semester' => ['Semester', 'fas fa-calendar', 'info'],
                                        'minat_match' => ['Kesesuaian Minat', 'fas fa-heart', 'warning'],
                                        'dosen_expertise' => ['Keahlian Dosen', 'fas fa-user-tie', 'secondary'],
                                        'difficulty' => ['Tingkat Kesulitan', 'fas fa-chart-bar', 'danger']
                                    ];
                                @endphp
                                
                                @foreach($labels as $key => $label)
                                    @if(isset($criteriaValues[$key]))
                                        @php
                                            $criteriaData = $criteriaValues[$key];
                                            $weight = isset($criteriaWeights[$key]) ? $criteriaWeights[$key]['weight'] : 0;
                                            $normalizedWeight = isset($criteriaWeights[$key]) ? $criteriaWeights[$key]['normalized_weight'] : 0;
                                            $normalizedValue = $criteriaData['normalized_value'] ?? 0;
                                            $rawValue = $criteriaData['raw_value'] ?? 0;
                                            $criteriaType = $criteriaData['type'] ?? 'benefit';
                                        @endphp
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="{{ $label[1] }} text-{{ $label[2] }} me-2"></i>
                                                        <strong>{{ $label[0] }}</strong>
                                                        <span class="badge bg-{{ $label[2] }} ms-auto">{{ $weight }}%</span>
                                                    </div>
                                                    
                                                    <div class="mb-2">
                                                        <small class="text-muted">Nilai Asli:</small>
                                                        <div class="fw-medium">{{ number_format($rawValue, 2) }}</div>
                                                    </div>
                                                    
                                                    <div class="mb-2">
                                                        <small class="text-muted">Nilai Ternormalisasi ({{ ucfirst($criteriaType) }}):</small>
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar bg-{{ $label[2] }}" 
                                                                 style="width: {{ $normalizedValue * 100 }}%"></div>
                                                        </div>
                                                        <small class="text-muted">{{ number_format($normalizedValue, 3) }}</small>
                                                    </div>
                                                    
                                                    <div>
                                                        <small class="text-muted">Kontribusi ke Skor Final:</small>
                                                        <div class="fw-medium text-{{ $label[2] }}">
                                                            {{ number_format($normalizedWeight * $normalizedValue * 100, 2) }} poin
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            {{-- Fallback untuk format lama --}}
                            <div class="row">
                                @php
                                    $kriteria = $rekomendasi->kriteria_smart;
                                    $labels = [
                                        'ipk_score' => ['IPK Score (30%)', 'fas fa-graduation-cap', 'primary'],
                                        'semester_score' => ['Semester Score (20%)', 'fas fa-calendar', 'info'],
                                        'minat_match' => ['Kesesuaian Minat (25%)', 'fas fa-heart', 'warning'],
                                        'dosen_expertise' => ['Keahlian Dosen (15%)', 'fas fa-user-tie', 'secondary'],
                                        'difficulty_score' => ['Tingkat Kesulitan (10%)', 'fas fa-chart-bar', 'danger']
                                    ];
                                @endphp
                                
                                @foreach($labels as $key => $label)
                                    @if(isset($kriteria[$key]))
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="{{ $label[1] }} text-{{ $label[2] }} fa-lg"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-medium">{{ $label[0] }}</div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-{{ $label[2] }}" 
                                                             style="width: {{ $kriteria[$key] }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ number_format($kriteria[$key], 2) }}/100</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Response from Student -->
            @if($rekomendasi->status !== 'draft' && $rekomendasi->catatan_mahasiswa)
                <div class="card shadow-sm">
                    <div class="card-header {{ $rekomendasi->status === 'diterima' ? 'bg-success' : 'bg-danger' }} text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-comment me-2"></i>Respon Mahasiswa
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Status:</strong> 
                            <span class="badge {{ $rekomendasi->status_badge }}">{{ $rekomendasi->status_text }}</span>
                        </div>
                        
                        @if($rekomendasi->tanggal_respon)
                            <div class="mb-2">
                                <strong>Tanggal Respon:</strong> {{ $rekomendasi->tanggal_respon->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        
                        <div class="mb-2">
                            <strong>Catatan Mahasiswa:</strong>
                            <div class="text-muted mt-1">{{ $rekomendasi->catatan_mahasiswa }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Student Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2"></i>Informasi Mahasiswa
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user-graduate text-white fa-2x"></i>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Nama:</strong>
                        <div>{{ $rekomendasi->mahasiswa->user->name }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>NIM:</strong>
                        <div>{{ $rekomendasi->mahasiswa->nim }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Program Studi:</strong>
                        <div>{{ $rekomendasi->mahasiswa->prodi }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Fakultas:</strong>
                        <div>{{ $rekomendasi->mahasiswa->fakultas }}</div>
                    </div>
                    
                    @if($rekomendasi->mahasiswa->nilai->last())
                        <div class="mb-2">
                            <strong>IPK Terbaru:</strong>
                            <div class="text-primary fw-bold">{{ $rekomendasi->mahasiswa->nilai->last()->ipk }}</div>
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
                                    <h6 class="timeline-title">Dikirim ke Mahasiswa</h6>
                                    <p class="timeline-text">{{ $rekomendasi->tanggal_dikirim->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($rekomendasi->tanggal_respon)
                            <!-- Response -->
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $rekomendasi->status === 'diterima' ? 'bg-success' : 'bg-danger' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">{{ $rekomendasi->status === 'diterima' ? 'Diterima' : 'Ditolak' }} Mahasiswa</h6>
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