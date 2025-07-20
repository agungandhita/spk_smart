@extends('mahasiswa.layouts.main')

@section('title', 'Referensi Topik Skripsi')

@section('container')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Referensi Topik Skripsi</h1>
            <p class="text-muted mb-0"><i class="fas fa-graduation-cap me-2"></i>Program Studi: <span class="font-weight-bold">{{ $mahasiswa->prodi }}</span></p>
        </div>
        <div class="text-right">
            <div class="text-muted small">Total Referensi</div>
            <div class="h4 font-weight-bold text-primary">{{ $topikSkripsi->total() }}</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter me-2"></i>Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('mahasiswa.topik-skripsi.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label font-weight-bold">Kata Kunci</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari judul, deskripsi, nama mahasiswa...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="bidang_keahlian" class="form-label font-weight-bold">Bidang Keahlian</label>
                        <select class="form-control" id="bidang_keahlian" name="bidang_keahlian">
                            <option value="">Semua Bidang</option>
                            @foreach($bidangKeahlian as $bidang)
                                <option value="{{ $bidang }}" 
                                    {{ request('bidang_keahlian') == $bidang ? 'selected' : '' }}>
                                    {{ $bidang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tahun_lulus" class="form-label font-weight-bold">Tahun Lulus</label>
                        <select class="form-control" id="tahun_lulus" name="tahun_lulus">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunLulus as $tahun)
                                <option value="{{ $tahun }}" 
                                    {{ request('tahun_lulus') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                        </option>
                                    @endforeach
                         </select>
                     </div>
                     <div class="col-md-2">
                         <label class="form-label font-weight-bold">&nbsp;</label>
                         <div class="d-grid gap-2">
                             <button type="submit" class="btn btn-primary">
                                 <i class="fas fa-search me-1"></i>Cari
                             </button>
                         </div>
                     </div>
                 </div>
                 @if(request()->hasAny(['search', 'bidang_keahlian', 'tahun_lulus']))
                     <div class="mt-3 pt-3 border-top">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="text-muted small">
                                 <i class="fas fa-info-circle me-1"></i>Filter aktif diterapkan
                             </div>
                             <a href="{{ route('mahasiswa.topik-skripsi.index') }}" class="btn btn-outline-secondary btn-sm">
                                 <i class="fas fa-times me-1"></i>Reset Filter
                             </a>
                         </div>
                     </div>
                 @endif
             </form>
         </div>
     </div>

    <!-- Results Info -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 text-gray-800">Hasil Pencarian</h5>
            <span class="text-muted small">
                <i class="fas fa-list me-1"></i>Menampilkan {{ $topikSkripsi->count() }} dari {{ $topikSkripsi->total() }} topik skripsi
            </span>
        </div>
        <div class="text-right">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-secondary active" id="gridView">
                    <i class="fas fa-th-large"></i> Grid
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="listView">
                    <i class="fas fa-list"></i> List
                </button>
            </div>
        </div>
    </div>

    @if($topikSkripsi->count() > 0)
        <!-- Grid Layout -->
        <div class="row" id="topikGrid">
            @foreach($topikSkripsi as $topik)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow border-0 hover-shadow">
                        <div class="card-header bg-gradient-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    @if($topik->bidang_keahlian)
                                        <span class="badge badge-light text-primary">{{ $topik->bidang_keahlian }}</span>
                                    @endif
                                </div>
                                <span class="badge badge-warning">{{ $topik->tahun_lulus }}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <!-- Title -->
                            <h6 class="card-title font-weight-bold text-primary mb-2">{{ Str::limit($topik->judul, 70) }}</h6>

                            <!-- Description -->
                            @if($topik->deskripsi)
                                <p class="card-text text-muted small mb-3" style="line-height: 1.4;">
                                    {{ Str::limit($topik->deskripsi, 120) }}
                                </p>
                            @endif

                            <!-- Student Info -->
                            <div class="mb-3 p-2 bg-light rounded">
                                <div class="row no-gutters">
                                    <div class="col-auto mr-2">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                            <i class="fas fa-user-graduate text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-bold small">{{ $topik->nama_mahasiswa }}</div>
                                        <div class="text-muted small">{{ $topik->nim_mahasiswa }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dosen Info -->
                            <div class="mb-3 p-2 bg-light rounded">
                                <div class="row no-gutters">
                                    <div class="col-auto mr-2">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                            <i class="fas fa-chalkboard-teacher text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small">Pembimbing</div>
                                        <div class="font-weight-bold small">{{ $topik->dosen->user->name }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keywords -->
                            @if($topik->kata_kunci)
                                <div class="mb-3">
                                    <div class="text-muted small mb-1">Kata Kunci:</div>
                                    @foreach(array_slice(explode(',', $topik->kata_kunci), 0, 3) as $keyword)
                                        <span class="badge badge-secondary small mr-1">{{ trim($keyword) }}</span>
                                    @endforeach
                                    @if(count(explode(',', $topik->kata_kunci)) > 3)
                                        <span class="small text-muted">+{{ count(explode(',', $topik->kata_kunci)) - 3 }} lainnya</span>
                                    @endif
                                </div>
                            @endif

                            <!-- File Info -->
                            <div class="mb-3 p-2 border rounded">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2">
                                        <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-bold small">{{ Str::limit($topik->file_name, 20) }}</div>
                                        <div class="text-muted small">{{ $topik->formatted_file_size }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-auto">
                                <div class="btn-group-vertical w-100" role="group">
                                    <a href="{{ route('mahasiswa.topik-skripsi.show', $topik->id) }}" 
                                       class="btn btn-outline-primary btn-sm mb-1">
                                        <i class="fas fa-eye mr-1"></i>Lihat Detail
                                    </a>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('mahasiswa.topik-skripsi.view', $topik->id) }}" 
                                           class="btn btn-outline-info btn-sm" target="_blank">
                                            <i class="fas fa-external-link-alt mr-1"></i>Buka PDF
                                        </a>
                                        <a href="{{ route('mahasiswa.topik-skripsi.download', $topik->id) }}" 
                                           class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-download mr-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                             </div>
                         </div>
                     </div>
                 @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $topikSkripsi->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    @if(request()->hasAny(['search', 'bidang_keahlian', 'tahun_lulus']))
                        <h5 class="text-muted">Tidak ada hasil yang ditemukan</h5>
                        <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang digunakan</p>
                        <a href="{{ route('mahasiswa.topik-skripsi.index') }}" class="btn btn-primary">
                            <i class="fas fa-refresh me-2"></i>Lihat Semua Topik
                        </a>
                    @else
                        <h5 class="text-muted">Belum ada topik skripsi</h5>
                        <p class="text-muted">Belum ada topik skripsi yang tersedia untuk program studi {{ $mahasiswa->prodi }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
/* Card Styling */
.card {
    transition: all 0.3s ease;
    border: 1px solid #e3e6f0;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Card Header Gradient */
.card-header.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

/* Badge Styling */
.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.badge-primary {
    background-color: #4e73df;
}

.badge-warning {
    background-color: #f6c23e;
    color: #333;
}

.badge-secondary {
    background-color: #6c757d;
}

/* Button Styling */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}

/* Filter Card */
.card-header h6 {
    margin-bottom: 0;
}

/* Grid Layout */
.row.no-gutters {
    margin-right: 0;
    margin-left: 0;
}

.row.no-gutters > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .col-md-4 {
        margin-bottom: 1rem;
    }
    
    .btn-group-vertical .btn {
        font-size: 0.8rem;
    }
}

/* File info styling */
.border {
    border: 1px solid #e3e6f0 !important;
}

/* Background colors */
.bg-light {
    background-color: #f8f9fc !important;
}

/* Text colors */
.text-primary {
    color: #4e73df !important;
}

.text-muted {
    color: #6c757d !important;
}

/* Spacing utilities */
.mr-1 {
    margin-right: 0.25rem !important;
}

.mr-2 {
    margin-right: 0.5rem !important;
}

.mb-1 {
    margin-bottom: 0.25rem !important;
}
</style>

@push('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}

.badge {
    font-size: 0.7em;
}
</style>
@endpush