@extends('mahasiswa.layouts.main')
@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Tambah Data Nilai KHS/IPK
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Info Mahasiswa -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h6 class="alert-heading mb-2">
                                    <i class="fas fa-info-circle me-1"></i>Informasi Mahasiswa
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Nama:</strong> {{ $mahasiswa->nama_lengkap }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>NIM:</strong> {{ $mahasiswa->nim }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Program Studi:</strong> {{ $mahasiswa->prodi }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('mahasiswa.nilai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Semester -->
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Semester <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('semester') is-invalid @enderror" 
                                        id="semester" 
                                        name="semester" 
                                        required>
                                    <option value="">Pilih Semester</option>
                                    @foreach($semesterList as $key => $value)
                                        @if(!in_array($key, $semesterTerpakai))
                                            <option value="{{ $key }}" {{ old('semester') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(count($semesterTerpakai) > 0)
                                    <small class="form-text text-muted">
                                        Semester yang sudah digunakan: {{ implode(', ', $semesterTerpakai) }}
                                    </small>
                                @endif
                            </div>

                            <!-- IPS -->
                            <div class="col-md-6 mb-3">
                                <label for="ips" class="form-label">
                                    <i class="fas fa-star me-1"></i>IPS (Indeks Prestasi Semester) <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('ips') is-invalid @enderror" 
                                       id="ips" 
                                       name="ips" 
                                       value="{{ old('ips') }}" 
                                       step="0.01" 
                                       min="0" 
                                       max="4" 
                                       placeholder="Contoh: 3.75" 
                                       required>
                                @error('ips')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Rentang nilai: 0.00 - 4.00</small>
                            </div>
                        </div>

                        <div class="row">
                            <!-- IPK -->
                            <div class="col-md-6 mb-3">
                                <label for="ipk" class="form-label">
                                    <i class="fas fa-trophy me-1"></i>IPK (Indeks Prestasi Kumulatif) <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('ipk') is-invalid @enderror" 
                                       id="ipk" 
                                       name="ipk" 
                                       value="{{ old('ipk') }}" 
                                       step="0.01" 
                                       min="0" 
                                       max="4" 
                                       placeholder="Contoh: 3.65" 
                                       required>
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Rentang nilai: 0.00 - 4.00</small>
                            </div>

                            <!-- SKS Semester -->
                            <div class="col-md-6 mb-3">
                                <label for="sks_semester" class="form-label">
                                    <i class="fas fa-book me-1"></i>SKS Semester <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('sks_semester') is-invalid @enderror" 
                                       id="sks_semester" 
                                       name="sks_semester" 
                                       value="{{ old('sks_semester') }}" 
                                       min="1" 
                                       max="30" 
                                       placeholder="Contoh: 20" 
                                       required>
                                @error('sks_semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">SKS yang diambil pada semester ini</small>
                            </div>
                        </div>

                        <div class="row">
                            <!-- SKS Kumulatif -->
                            <div class="col-md-6 mb-3">
                                <label for="sks_kumulatif" class="form-label">
                                    <i class="fas fa-books me-1"></i>SKS Kumulatif <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('sks_kumulatif') is-invalid @enderror" 
                                       id="sks_kumulatif" 
                                       name="sks_kumulatif" 
                                       value="{{ old('sks_kumulatif') }}" 
                                       min="1" 
                                       placeholder="Contoh: 120" 
                                       required>
                                @error('sks_kumulatif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Total SKS yang telah ditempuh</small>
                            </div>

                            <!-- File KHS -->
                            <div class="col-md-6 mb-3">
                                <label for="file_khs" class="form-label">
                                    <i class="fas fa-file-pdf me-1"></i>File KHS (PDF)
                                </label>
                                <input type="file" 
                                       class="form-control @error('file_khs') is-invalid @enderror" 
                                       id="file_khs" 
                                       name="file_khs" 
                                       accept=".pdf">
                                @error('file_khs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: PDF, Maksimal: 5MB (Opsional)</small>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="keterangan" class="form-label">
                                    <i class="fas fa-comment me-1"></i>Keterangan
                                </label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                          id="keterangan" 
                                          name="keterangan" 
                                          rows="3" 
                                          placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maksimal 1000 karakter</small>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('mahasiswa.nilai.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Simpan Data Nilai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto calculate SKS Kumulatif based on semester
document.getElementById('semester').addEventListener('change', function() {
    const semester = parseInt(this.value);
    const sksPerSemester = 20; // Asumsi rata-rata SKS per semester
    
    if (semester) {
        const estimatedSksKumulatif = semester * sksPerSemester;
        document.getElementById('sks_kumulatif').value = estimatedSksKumulatif;
    }
});

// Validation for IPS and IPK
document.getElementById('ips').addEventListener('input', function() {
    const value = parseFloat(this.value);
    if (value > 4) {
        this.value = 4.00;
    } else if (value < 0) {
        this.value = 0.00;
    }
});

document.getElementById('ipk').addEventListener('input', function() {
    const value = parseFloat(this.value);
    if (value > 4) {
        this.value = 4.00;
    } else if (value < 0) {
        this.value = 0.00;
    }
});

// File size validation
document.getElementById('file_khs').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const fileSize = file.size / 1024 / 1024; // Convert to MB
        if (fileSize > 5) {
            alert('Ukuran file terlalu besar! Maksimal 5MB.');
            this.value = '';
        }
    }
});
</script>
@endpush