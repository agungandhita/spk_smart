@extends('dosen.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Rekomendasi Judul Skripsi</h2>
                    <p class="text-muted mb-0">Kelola rekomendasi judul skripsi untuk mahasiswa bimbingan menggunakan metode SMART</p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-info fs-6">{{ $mahasiswaBimbingan->count() }} Mahasiswa</span>
                    <span class="badge bg-success fs-6">{{ $rekomendasiDiterima->count() }} Diterima</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Mahasiswa Bimbingan</h6>
                            <h3 class="mb-0">{{ $mahasiswaBimbingan->count() }}</h3>
                        </div>
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Draft Rekomendasi</h6>
                            <h3 class="mb-0">{{ $rekomendasiDraft->count() }}</h3>
                        </div>
                        <i class="fas fa-edit fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Rekomendasi Dikirim</h6>
                            <h3 class="mb-0">{{ $rekomendasiDikirim->count() }}</h3>
                        </div>
                        <i class="fas fa-paper-plane fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Rekomendasi Diterima</h6>
                            <h3 class="mb-0">{{ $rekomendasiDiterima->count() }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mahasiswa Bimbingan Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Mahasiswa Bimbingan
                    </h5>
                </div>
                <div class="card-body">
                    @if($mahasiswaBimbingan->count() > 0)
                        <div class="row">
                            @foreach($mahasiswaBimbingan as $pengajuan)
                                @php
                                    $mahasiswa = $pengajuan->mahasiswa;
                                    $nilaiTerbaru = $mahasiswa->nilai->last();
                                @endphp
                                <div class="col-lg-6 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="card-title mb-1">{{ $mahasiswa->user->name }}</h6>
                                                    <small class="text-muted">{{ $mahasiswa->nim }} - {{ $mahasiswa->prodi }}</small>
                                                </div>
                                                <span class="badge bg-primary">Semester {{ $mahasiswa->semester ?? 'N/A' }}</span>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted">IPK Terbaru:</small>
                                                    <div class="fw-bold text-primary">{{ $nilaiTerbaru->ipk ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Minat Skripsi:</small>
                                                    <div class="fw-medium">{{ Str::limit($pengajuan->minat_skripsi, 30) }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('dosen.rekomendasi.create', $mahasiswa->id) }}" 
                                                   class="btn btn-primary btn-sm flex-fill">
                                                    <i class="fas fa-plus me-1"></i>Buat Rekomendasi
                                                </a>
                                                <button type="button" class="btn btn-outline-info btn-sm" 
                                                        onclick="generateRecommendations({{ $mahasiswa->id }})">
                                                    <i class="fas fa-magic me-1"></i>Auto Generate
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">Belum ada mahasiswa bimbingan</h5>
                            <p class="text-muted">Mahasiswa yang menerima pengajuan pembimbing akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs" id="rekomendasiTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft" type="button" role="tab">
                        <i class="fas fa-edit me-2"></i>Draft ({{ $rekomendasiDraft->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dikirim-tab" data-bs-toggle="tab" data-bs-target="#dikirim" type="button" role="tab">
                        <i class="fas fa-paper-plane me-2"></i>Dikirim ({{ $rekomendasiDikirim->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="diterima-tab" data-bs-toggle="tab" data-bs-target="#diterima" type="button" role="tab">
                        <i class="fas fa-check-circle me-2"></i>Diterima ({{ $rekomendasiDiterima->count() }})
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="rekomendasiTabsContent">
        <!-- Draft Tab -->
        <div class="tab-pane fade show active" id="draft" role="tabpanel">
            @if($rekomendasiDraft->count() > 0)
                <div class="row">
                    @foreach($rekomendasiDraft as $rekomendasi)
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-secondary">
                                <div class="card-header bg-secondary bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-lightbulb me-2"></i>{{ Str::limit($rekomendasi->judul_skripsi, 40) }}
                                        </h6>
                                        <span class="badge {{ $rekomendasi->status_badge }}">{{ $rekomendasi->status_text }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">Mahasiswa:</small>
                                        <div class="fw-medium">{{ $rekomendasi->mahasiswa->user->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Tipe Skripsi:</small>
                                        <div class="fw-medium text-capitalize">{{ str_replace('_', ' ', $rekomendasi->tipe_skripsi) }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Skor SMART:</small>
                                        <div class="fw-bold text-primary">{{ $rekomendasi->skor_smart }}/100</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Tingkat Kesulitan:</small>
                                        <span class="badge {{ $rekomendasi->difficulty_badge }}">{{ $rekomendasi->difficulty_text }}</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('dosen.rekomendasi.show', $rekomendasi->id) }}" 
                                           class="btn btn-outline-info btn-sm flex-fill">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <form action="{{ route('dosen.rekomendasi.send', $rekomendasi->id) }}" 
                                              method="POST" class="flex-fill">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary btn-sm w-100"
                                                    onclick="return confirm('Kirim rekomendasi ini ke mahasiswa?')">
                                                <i class="fas fa-paper-plane me-1"></i>Kirim
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-edit text-muted fa-3x mb-3"></i>
                    <h5 class="text-muted">Belum ada draft rekomendasi</h5>
                    <p class="text-muted">Buat rekomendasi baru untuk mahasiswa bimbingan Anda</p>
                </div>
            @endif
        </div>

        <!-- Dikirim Tab -->
        <div class="tab-pane fade" id="dikirim" role="tabpanel">
            @if($rekomendasiDikirim->count() > 0)
                <div class="row">
                    @foreach($rekomendasiDikirim as $rekomendasi)
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-warning">
                                <div class="card-header bg-warning bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-lightbulb me-2"></i>{{ Str::limit($rekomendasi->judul_skripsi, 40) }}
                                        </h6>
                                        <span class="badge {{ $rekomendasi->status_badge }}">{{ $rekomendasi->status_text }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">Mahasiswa:</small>
                                        <div class="fw-medium">{{ $rekomendasi->mahasiswa->user->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Dikirim:</small>
                                        <div class="fw-medium">{{ $rekomendasi->tanggal_dikirim->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Skor SMART:</small>
                                        <div class="fw-bold text-primary">{{ $rekomendasi->skor_smart }}/100</div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('dosen.rekomendasi.show', $rekomendasi->id) }}" 
                                       class="btn btn-outline-warning btn-sm w-100">
                                        <i class="fas fa-eye me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-paper-plane text-muted fa-3x mb-3"></i>
                    <h5 class="text-muted">Belum ada rekomendasi yang dikirim</h5>
                    <p class="text-muted">Rekomendasi yang telah dikirim akan muncul di sini</p>
                </div>
            @endif
        </div>

        <!-- Diterima Tab -->
        <div class="tab-pane fade" id="diterima" role="tabpanel">
            @if($rekomendasiDiterima->count() > 0)
                <div class="row">
                    @foreach($rekomendasiDiterima as $rekomendasi)
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100 border-success">
                                <div class="card-header bg-success bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-lightbulb me-2"></i>{{ Str::limit($rekomendasi->judul_skripsi, 40) }}
                                        </h6>
                                        <span class="badge {{ $rekomendasi->status_badge }}">{{ $rekomendasi->status_text }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">Mahasiswa:</small>
                                        <div class="fw-medium">{{ $rekomendasi->mahasiswa->user->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Diterima:</small>
                                        <div class="fw-medium">{{ $rekomendasi->tanggal_respon->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Skor SMART:</small>
                                        <div class="fw-bold text-primary">{{ $rekomendasi->skor_smart }}/100</div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('dosen.rekomendasi.show', $rekomendasi->id) }}" 
                                       class="btn btn-outline-success btn-sm w-100">
                                        <i class="fas fa-eye me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle text-muted fa-3x mb-3"></i>
                    <h5 class="text-muted">Belum ada rekomendasi yang diterima</h5>
                    <p class="text-muted">Rekomendasi yang diterima mahasiswa akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Auto Generate Modal -->
<div class="modal fade" id="autoGenerateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rekomendasi Otomatis SMART</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="loadingGenerate" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Menganalisis data dengan metode SMART...</p>
                </div>
                <div id="recommendationResults" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<script>
function generateRecommendations(mahasiswaId) {
    $('#autoGenerateModal').modal('show');
    $('#loadingGenerate').show();
    $('#recommendationResults').hide();
    
    fetch('/dosen/rekomendasi/auto-generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            mahasiswa_id: mahasiswaId
        })
    })
        .then(response => response.json())
        .then(data => {
            $('#loadingGenerate').hide();
            
            if (data.success) {
                let html = '<h6>Top 5 Rekomendasi Berdasarkan Analisis SMART:</h6>';
                html += '<div class="list-group">';
                
                data.recommendations.forEach((rec, index) => {
                    html += `
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">${rec.judul_skripsi}</h6>
                                    <p class="mb-1 text-muted">${rec.deskripsi_judul}</p>
                                    <small>Tipe: ${rec.tipe_skripsi.replace('_', ' ')} | Kesulitan: ${rec.tingkat_kesulitan}</small>
                                </div>
                                <span class="badge bg-primary">${rec.skor_smart.toFixed(2)}/100</span>
                            </div>
                        </div>
                    `;
                });
                
                html += '</div>';
                html += '<div class="mt-3 text-center">';
                html += `<a href="/dosen/rekomendasi/create/${mahasiswaId}" class="btn btn-primary">Buat Rekomendasi Manual</a>`;
                html += '</div>';
                
                $('#recommendationResults').html(html).show();
            } else {
                $('#recommendationResults').html('<div class="alert alert-danger">Gagal menghasilkan rekomendasi</div>').show();
            }
        })
        .catch(error => {
            $('#loadingGenerate').hide();
            $('#recommendationResults').html('<div class="alert alert-danger">Terjadi kesalahan</div>').show();
        });
}
</script>
@endsection