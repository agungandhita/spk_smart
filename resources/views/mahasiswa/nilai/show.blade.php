@extends('mahasiswa.layouts.main')
@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Detail Data Nilai KHS/IPK - Semester {{ $nilai->semester }}
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Info Mahasiswa -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h6 class="alert-heading mb-2">
                                    <i class="fas fa-user me-1"></i>Informasi Mahasiswa
                                </h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Nama:</strong> {{ $mahasiswa->nama_lengkap }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>NIM:</strong> {{ $mahasiswa->nim }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Program Studi:</strong> {{ $mahasiswa->prodi }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Fakultas:</strong> {{ $mahasiswa->fakultas }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Nilai -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-line me-2"></i>Detail Nilai Semester {{ $nilai->semester }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Semester -->
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <label class="form-label text-muted mb-1">
                                                    <i class="fas fa-calendar-alt me-1"></i>Semester
                                                </label>
                                                <div class="info-value">
                                                    <span class="badge bg-primary fs-6">Semester {{ $nilai->semester }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- IPS -->
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <label class="form-label text-muted mb-1">
                                                    <i class="fas fa-star me-1"></i>IPS (Indeks Prestasi Semester)
                                                </label>
                                                <div class="info-value">
                                                    <span class="badge bg-{{ $nilai->ips >= 3.5 ? 'success' : ($nilai->ips >= 3.0 ? 'warning' : 'danger') }} fs-6">
                                                        {{ number_format($nilai->ips, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- IPK -->
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <label class="form-label text-muted mb-1">
                                                    <i class="fas fa-trophy me-1"></i>IPK (Indeks Prestasi Kumulatif)
                                                </label>
                                                <div class="info-value">
                                                    <span class="badge bg-{{ $nilai->ipk >= 3.5 ? 'success' : ($nilai->ipk >= 3.0 ? 'warning' : 'danger') }} fs-6">
                                                        {{ number_format($nilai->ipk, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SKS Semester -->
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <label class="form-label text-muted mb-1">
                                                    <i class="fas fa-book me-1"></i>SKS Semester
                                                </label>
                                                <div class="info-value">
                                                    <span class="fs-5 fw-bold text-dark">{{ $nilai->sks_semester }} SKS</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SKS Kumulatif -->
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <label class="form-label text-muted mb-1">
                                                    <i class="fas fa-books me-1"></i>SKS Kumulatif
                                                </label>
                                                <div class="info-value">
                                                    <span class="fs-5 fw-bold text-dark">{{ $nilai->sks_kumulatif }} SKS</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tanggal Input -->
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <label class="form-label text-muted mb-1">
                                                    <i class="fas fa-clock me-1"></i>Tanggal Input
                                                </label>
                                                <div class="info-value">
                                                    <span class="text-dark">{{ $nilai->created_at->format('d F Y, H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($nilai->keterangan)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="info-item">
                                                    <label class="form-label text-muted mb-1">
                                                        <i class="fas fa-comment me-1"></i>Keterangan
                                                    </label>
                                                    <div class="info-value">
                                                        <div class="alert alert-light border">
                                                            {{ $nilai->keterangan }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- File KHS & Actions -->
                        <div class="col-md-4">
                            <!-- File KHS -->
                            <div class="card border-success mb-3">
                                <div class="card-header bg-success text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-file-pdf me-2"></i>File KHS
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    @if($nilai->file_khs)
                                        <div class="mb-3">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <p class="mb-2">KHS_Semester_{{ $nilai->semester }}.pdf</p>
                                            <a href="{{ route('mahasiswa.nilai.download', $nilai->id) }}" 
                                               class="btn btn-success btn-sm" 
                                               target="_blank">
                                                <i class="fas fa-download me-1"></i>Download PDF
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-muted">
                                            <i class="fas fa-file-excel fa-3x mb-2"></i>
                                            <p>Tidak ada file KHS</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cogs me-2"></i>Aksi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('mahasiswa.nilai.edit', $nilai->id) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit me-1"></i>Edit Data
                                        </a>
                                        
                                        <form action="{{ route('mahasiswa.nilai.destroy', $nilai->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nilai semester {{ $nilai->semester }}? Data yang dihapus tidak dapat dikembalikan!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash me-1"></i>Hapus Data
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('mahasiswa.nilai.index') }}" 
                                           class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Prestasi Info -->
                            <div class="card border-info mt-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Prestasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <small class="text-muted">Kategori IPS:</small><br>
                                        @if($nilai->ips >= 3.5)
                                            <span class="badge bg-success">Sangat Baik (≥ 3.5)</span>
                                        @elseif($nilai->ips >= 3.0)
                                            <span class="badge bg-warning">Baik (3.0 - 3.49)</span>
                                        @elseif($nilai->ips >= 2.5)
                                            <span class="badge bg-info">Cukup (2.5 - 2.99)</span>
                                        @else
                                            <span class="badge bg-danger">Kurang (< 2.5)</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">Kategori IPK:</small><br>
                                        @if($nilai->ipk >= 3.5)
                                            <span class="badge bg-success">Sangat Baik (≥ 3.5)</span>
                                        @elseif($nilai->ipk >= 3.0)
                                            <span class="badge bg-warning">Baik (3.0 - 3.49)</span>
                                        @elseif($nilai->ipk >= 2.5)
                                            <span class="badge bg-info">Cukup (2.5 - 2.99)</span>
                                        @else
                                            <span class="badge bg-danger">Kurang (< 2.5)</span>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <small class="text-muted">Progress SKS:</small><br>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $progressPercentage = min(($nilai->sks_kumulatif / 144) * 100, 100);
                                            @endphp
                                            <div class="progress-bar bg-info" 
                                                 role="progressbar" 
                                                 style="width: {{ $progressPercentage }}%" 
                                                 aria-valuenow="{{ $progressPercentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ number_format($progressPercentage, 1) }}%
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $nilai->sks_kumulatif }}/144 SKS</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.info-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.info-value {
    margin-top: 5px;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.875em;
}
</style>
@endpush