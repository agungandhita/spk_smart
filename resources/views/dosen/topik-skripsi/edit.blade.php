@extends('dosen.layouts.main')

@section('title', 'Edit Topik Skripsi')

@section('container')
<!-- Page Header -->
<div class="page-header bg-gradient-primary text-white py-4 mb-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-1">Edit Topik Skripsi</h1>
                <p class="mb-0 opacity-75">Perbarui informasi topik skripsi: {{ Str::limit($topikSkripsi->judul, 50) }}</p>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('dosen.topik-skripsi.show', $topikSkripsi) }}" class="btn btn-light">
                        <i class="fas fa-eye mr-2"></i>Detail
                    </a>
                    <a href="{{ route('dosen.topik-skripsi.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0">
                <i class="fas fa-edit text-primary mr-2"></i>
                Form Edit Topik Skripsi
            </h5>
        </div>
        <div class="card-body p-4">
                    <form action="{{ route('dosen.topik-skripsi.update', $topikSkripsi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Judul -->
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Skripsi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                           id="judul" name="judul" value="{{ old('judul', $topikSkripsi->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                              id="deskripsi" name="deskripsi" rows="4"
                                              placeholder="Deskripsi singkat tentang topik skripsi...">{{ old('deskripsi', $topikSkripsi->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bidang Keahlian -->
                                <div class="mb-3">
                                    <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                                    <input type="text" class="form-control @error('bidang_keahlian') is-invalid @enderror"
                                           id="bidang_keahlian" name="bidang_keahlian"
                                           value="{{ old('bidang_keahlian', $topikSkripsi->bidang_keahlian) }}"
                                           placeholder="Contoh: Sistem Informasi, Jaringan Komputer, dll">
                                    @error('bidang_keahlian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Data Mahasiswa -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror"
                                                   id="nama_mahasiswa" name="nama_mahasiswa"
                                                   value="{{ old('nama_mahasiswa', $topikSkripsi->nama_mahasiswa) }}" required>
                                            @error('nama_mahasiswa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nim_mahasiswa" class="form-label">NIM Mahasiswa <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nim_mahasiswa') is-invalid @enderror"
                                                   id="nim_mahasiswa" name="nim_mahasiswa"
                                                   value="{{ old('nim_mahasiswa', $topikSkripsi->nim_mahasiswa) }}" required>
                                            @error('nim_mahasiswa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahun Lulus -->
                                <div class="mb-3">
                                    <label for="tahun_lulus" class="form-label">Tahun Lulus <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tahun_lulus') is-invalid @enderror"
                                            id="tahun_lulus" name="tahun_lulus" required>
                                        <option value="">Pilih Tahun Lulus</option>
                                        @for($year = date('Y') + 5; $year >= 2000; $year--)
                                            <option value="{{ $year }}"
                                                {{ old('tahun_lulus', $topikSkripsi->tahun_lulus) == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('tahun_lulus')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Kata Kunci -->
                                <div class="mb-3">
                                    <label for="kata_kunci" class="form-label">Kata Kunci</label>
                                    <input type="text" class="form-control @error('kata_kunci') is-invalid @enderror"
                                           id="kata_kunci" name="kata_kunci"
                                           value="{{ old('kata_kunci', $topikSkripsi->kata_kunci) }}"
                                           placeholder="Pisahkan dengan koma, contoh: web, database, php">
                                    <div class="form-text">Kata kunci untuk memudahkan pencarian (opsional)</div>
                                    @error('kata_kunci')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="aktif" {{ old('status', $topikSkripsi->status) == 'aktif' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="non_aktif" {{ old('status', $topikSkripsi->status) == 'non_aktif' ? 'selected' : '' }}>
                                            Non Aktif
                                        </option>
                                    </select>
                                    <div class="form-text">Status "Non Aktif" akan menyembunyikan topik dari mahasiswa</div>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Info Dosen -->
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">Informasi Dosen</h6>
                                        <p class="card-text mb-1"><strong>Nama:</strong> {{ $dosen->user->name }}</p>
                                        <p class="card-text mb-1"><strong>NIDN:</strong> {{ $dosen->nidn }}</p>
                                        <p class="card-text mb-1"><strong>Prodi:</strong> {{ $dosen->prodi }}</p>
                                        <p class="card-text mb-0"><strong>Fakultas:</strong> {{ $dosen->fakultas }}</p>
                                    </div>
                                </div>

                                <!-- Current File Info -->
                                <div class="card border-info mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">File Saat Ini</h6>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                            <div>
                                                <div class="fw-bold">{{ $topikSkripsi->file_name }}</div>
                                                <div class="text-muted small">{{ $topikSkripsi->formatted_file_size }}</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('dosen.topik-skripsi.download', $topikSkripsi) }}"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>

                                <!-- Upload New File -->
                                <div class="mb-3">
                                    <label for="file_pdf" class="form-label">Ganti File PDF (Opsional)</label>
                                    <input type="file" class="form-control @error('file_pdf') is-invalid @enderror"
                                           id="file_pdf" name="file_pdf" accept=".pdf">
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i>
                                        Format: PDF, Maksimal 10MB. Kosongkan jika tidak ingin mengganti file.
                                    </div>
                                    @error('file_pdf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- New File Preview -->
                                <div id="filePreview" class="d-none">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                            <div class="fw-bold text-success">File Baru:</div>
                                            <div id="fileName" class="small"></div>
                                            <div id="fileSize" class="text-muted small"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dosen.topik-skripsi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
/* Page Header Gradient */
.page-header.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Card Styling */
.card.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card.border-0 {
    border: none;
}

/* Form Control Styling */
.form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1.1rem;
}

.form-label.font-weight-bold {
    font-weight: 600;
    color: #495057;
}

/* Button Styling */
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

/* Card Header Styling */
.card-header.bg-primary {
    background-color: #4e73df !important;
}

.card-header.bg-success {
    background-color: #1cc88a !important;
}

/* Alert Styling */
.alert.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Spacing utilities */
.mr-1 {
    margin-right: 0.25rem !important;
}

.mr-2 {
    margin-right: 0.5rem !important;
}

.mr-3 {
    margin-right: 1rem !important;
}

.my-4 {
    margin-top: 1.5rem !important;
    margin-bottom: 1.5rem !important;
}

/* Text utilities */
.opacity-75 {
    opacity: 0.75;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
    
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        border-radius: 0.25rem !important;
        margin-bottom: 0.5rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

@push('scripts')
<script>
document.getElementById('file_pdf').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    if (file) {
        // Show preview
        preview.classList.remove('d-none');
        fileName.textContent = file.name;

        // Format file size
        const size = file.size;
        const units = ['B', 'KB', 'MB', 'GB'];
        let i = 0;
        let formattedSize = size;

        while (formattedSize > 1024 && i < units.length - 1) {
            formattedSize /= 1024;
            i++;
        }

        fileSize.textContent = Math.round(formattedSize * 100) / 100 + ' ' + units[i];

        // Validate file type
        if (file.type !== 'application/pdf') {
            alert('File harus berformat PDF!');
            e.target.value = '';
            preview.classList.add('d-none');
        }

        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran file maksimal 10MB!');
            e.target.value = '';
            preview.classList.add('d-none');
        }
    } else {
        preview.classList.add('d-none');
    }
});
</script>
@endpush
