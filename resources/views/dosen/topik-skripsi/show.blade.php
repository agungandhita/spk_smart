@extends('dosen.layouts.main')

@section('title', 'Detail Topik Skripsi')

@section('container')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        {{-- @include('dosen.partials.sidebar') --}}

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <!-- Page Header -->
            <div class="page-header bg-white rounded-3 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-2">
                            <i class="fas fa-file-alt text-primary me-2"></i>
                            Detail Topik Skripsi
                        </h1>
                        <p class="text-muted mb-0 text-black">Informasi lengkap tentang topik skripsi yang dipilih</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dosen.topik-skripsi.edit', $topikSkripsi) }}"
                           class="btn btn-warning btn-sm d-flex align-items-center">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('dosen.topik-skripsi.index') }}"
                           class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-info-circle me-2 text-black"></i>
                                Informasi Topik Skripsi
                            </h5>
                            @if($topikSkripsi->status == 'aktif')
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6 px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i>Non Aktif
                                </span>
                            @endif
                        </div>
                        <div class="card-body p-4">
                            <!-- Judul -->
                            <div class="mb-4 p-3 bg-light rounded-3 border-start border-primary border-4">
                                <h4 class="text-primary fw-bold mb-0">{{ $topikSkripsi->judul }}</h4>
                            </div>

                            <!-- Deskripsi -->
                            @if($topikSkripsi->deskripsi)
                                <div class="mb-4">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-align-left text-primary me-2"></i>Deskripsi:
                                    </h6>
                                    <div class="p-3 bg-light rounded-3">
                                        <p class="text-muted mb-0">{{ $topikSkripsi->deskripsi }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Info Grid -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-item p-3 bg-light rounded-3 h-100">
                                        <h6 class="fw-bold text-dark mb-2">
                                            <i class="fas fa-graduation-cap text-primary me-2"></i>Program Studi:
                                        </h6>
                                        <p class="mb-0 text-dark">{{ $topikSkripsi->prodi }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item p-3 bg-light rounded-3 h-100">
                                        <h6 class="fw-bold text-dark mb-2">
                                            <i class="fas fa-university text-primary me-2"></i>Fakultas:
                                        </h6>
                                        <p class="mb-0 text-dark">{{ $topikSkripsi->fakultas }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item p-3 bg-light rounded-3 h-100">
                                        <h6 class="fw-bold text-dark mb-2">
                                            <i class="fas fa-cogs text-primary me-2"></i>Bidang Keahlian:
                                        </h6>
                                        <p class="mb-0">
                                            @if($topikSkripsi->bidang_keahlian)
                                                <span class="badge bg-info fs-6 px-3 py-2">{{ $topikSkripsi->bidang_keahlian }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item p-3 bg-light rounded-3 h-100">
                                        <h6 class="fw-bold text-dark mb-2">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i>Tahun Lulus:
                                        </h6>
                                        <p class="mb-0 text-dark">{{ $topikSkripsi->tahun_lulus }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Mahasiswa -->
                            <div class="mt-4">
                                <div class="card border-0 bg-gradient-light">
                                    <div class="card-body p-4">
                                        <h6 class="card-title fw-bold text-dark mb-3">
                                            <i class="fas fa-user-graduate text-primary me-2"></i>
                                            Data Mahasiswa
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user text-primary me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Nama Mahasiswa</small>
                                                        <strong class="text-dark">{{ $topikSkripsi->nama_mahasiswa }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-id-card text-primary me-3"></i>
                                                    <div>
                                                        <small class="text-muted d-block">NIM</small>
                                                        <strong class="text-dark">{{ $topikSkripsi->nim_mahasiswa }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kata Kunci -->
                            @if($topikSkripsi->kata_kunci)
                                <div class="mt-4">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-tags text-primary me-2"></i>Kata Kunci:
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach(explode(',', $topikSkripsi->kata_kunci) as $keyword)
                                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                                <i class="fas fa-tag me-1"></i>{{ trim($keyword) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Timestamps -->
                            <div class="mt-4 pt-3 border-top">
                                <div class="row text-muted small">
                                    <div class="col-md-6">
                                        <i class="fas fa-calendar-plus me-1"></i>
                                        Dibuat: {{ $topikSkripsi->created_at->format('d M Y H:i') }}
                                    </div>
                                    <div class="col-md-6">
                                        <i class="fas fa-calendar-edit me-1"></i>
                                        Diperbarui: {{ $topikSkripsi->updated_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- File Info -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-gradient-success">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-file-pdf me-2"></i>
                                File PDF Skripsi
                            </h6>
                        </div>
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold text-dark mb-2">{{ Str::limit($topikSkripsi->file_name, 25) }}</h6>
                            <p class="text-muted mb-4">
                                <i class="fas fa-weight-hanging me-1"></i>
                                {{ $topikSkripsi->formatted_file_size }}
                            </p>

                            <div class="d-grid gap-2">
                                <a href="{{ route('dosen.topik-skripsi.download', $topikSkripsi) }}"
                                   class="btn btn-success d-flex align-items-center justify-content-center">
                                    <i class="fas fa-download me-2"></i>Download PDF
                                </a>
                                <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                                        onclick="confirmDelete({{ $topikSkripsi->id }})">
                                    <i class="fas fa-trash me-2"></i>Hapus Topik
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Dosen Info -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-gradient-info">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                Informasi Dosen Pembimbing
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                @if($topikSkripsi->dosen->foto)
                                    <img src="{{ Storage::url($topikSkripsi->dosen->foto) }}"
                                         alt="Foto Dosen" class="rounded-circle me-3 border border-3 border-light shadow"
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow"
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-user fa-lg"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $topikSkripsi->dosen->user->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-id-badge me-1"></i>{{ $topikSkripsi->dosen->nidn }}
                                    </small>
                                </div>
                            </div>

                            <div class="info-details">
                                <div class="mb-3 p-2 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-briefcase text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Jabatan</small>
                                            <span class="fw-bold text-dark">{{ $topikSkripsi->dosen->jabatan_akademik ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 p-2 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Pendidikan</small>
                                            <span class="fw-bold text-dark">{{ $topikSkripsi->dosen->pendidikan_terakhir }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Email</small>
                                            <a href="mailto:{{ $topikSkripsi->dosen->user->email }}"
                                               class="fw-bold text-primary text-decoration-none">
                                                {{ $topikSkripsi->dosen->user->email }}
                                            </a>
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
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus topik skripsi ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Peringatan:</strong> File PDF juga akan terhapus secara permanen dan tidak dapat dikembalikan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    const form = document.getElementById('deleteForm');
    form.action = `/dosen/topik-skripsi/${id}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
