@extends('dosen.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Buat Rekomendasi Judul Skripsi</h2>
                    <p class="text-muted mb-0">Buat rekomendasi judul skripsi menggunakan analisis SMART untuk {{ $mahasiswa->user->name }}</p>
                </div>
                <a href="{{ route('dosen.rekomendasi.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Form Rekomendasi Judul
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dosen.rekomendasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">
                        
                        <!-- Judul Skripsi -->
                        <div class="mb-3">
                            <label for="judul_skripsi" class="form-label">Judul Skripsi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul_skripsi') is-invalid @enderror" 
                                   id="judul_skripsi" name="judul_skripsi" value="{{ old('judul_skripsi') }}" 
                                   placeholder="Masukkan judul skripsi yang direkomendasikan">
                            @error('judul_skripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi Judul -->
                        <div class="mb-3">
                            <label for="deskripsi_judul" class="form-label">Deskripsi Judul <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi_judul') is-invalid @enderror" 
                                      id="deskripsi_judul" name="deskripsi_judul" rows="4" 
                                      placeholder="Jelaskan secara detail tentang judul skripsi ini">{{ old('deskripsi_judul') }}</textarea>
                            @error('deskripsi_judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Tipe Skripsi -->
                            <div class="col-md-6 mb-3">
                                <label for="tipe_skripsi" class="form-label">Tipe Skripsi <span class="text-danger">*</span></label>
                                <select class="form-select @error('tipe_skripsi') is-invalid @enderror" 
                                        id="tipe_skripsi" name="tipe_skripsi">
                                    <option value="">Pilih Tipe Skripsi</option>
                                    <option value="penelitian" {{ old('tipe_skripsi') == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                                    <option value="pengembangan" {{ old('tipe_skripsi') == 'pengembangan' ? 'selected' : '' }}>Pengembangan</option>
                                    <option value="studi_kasus" {{ old('tipe_skripsi') == 'studi_kasus' ? 'selected' : '' }}>Studi Kasus</option>
                                    <option value="eksperimen" {{ old('tipe_skripsi') == 'eksperimen' ? 'selected' : '' }}>Eksperimen</option>
                                </select>
                                @error('tipe_skripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bidang Keahlian -->
                            <div class="col-md-6 mb-3">
                                <label for="bidang_keahlian" class="form-label">Bidang Keahlian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('bidang_keahlian') is-invalid @enderror" 
                                       id="bidang_keahlian" name="bidang_keahlian" value="{{ old('bidang_keahlian', $dosen->bidang_keahlian) }}" 
                                       placeholder="Bidang keahlian yang relevan">
                                @error('bidang_keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tingkat Kesulitan -->
                            <div class="col-md-4 mb-3">
                                <label for="tingkat_kesulitan" class="form-label">Tingkat Kesulitan <span class="text-danger">*</span></label>
                                <select class="form-select @error('tingkat_kesulitan') is-invalid @enderror" 
                                        id="tingkat_kesulitan" name="tingkat_kesulitan">
                                    <option value="">Pilih Tingkat Kesulitan</option>
                                    <option value="mudah" {{ old('tingkat_kesulitan') == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                    <option value="sedang" {{ old('tingkat_kesulitan') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="sulit" {{ old('tingkat_kesulitan') == 'sulit' ? 'selected' : '' }}>Sulit</option>
                                </select>
                                @error('tingkat_kesulitan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- IPK Minimum -->
                            <div class="col-md-4 mb-3">
                                <label for="ipk_minimum" class="form-label">IPK Minimum <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="4" 
                                       class="form-control @error('ipk_minimum') is-invalid @enderror" 
                                       id="ipk_minimum" name="ipk_minimum" value="{{ old('ipk_minimum', '2.50') }}" 
                                       placeholder="2.50">
                                @error('ipk_minimum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Semester Minimum -->
                            <div class="col-md-4 mb-3">
                                <label for="semester_minimum" class="form-label">Semester Minimum <span class="text-danger">*</span></label>
                                <input type="number" min="1" max="14" 
                                       class="form-control @error('semester_minimum') is-invalid @enderror" 
                                       id="semester_minimum" name="semester_minimum" value="{{ old('semester_minimum', '5') }}" 
                                       placeholder="5">
                                @error('semester_minimum')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Prasyarat -->
                        <div class="mb-4">
                            <label for="prasyarat" class="form-label">Prasyarat (Opsional)</label>
                            <textarea class="form-control @error('prasyarat') is-invalid @enderror" 
                                      id="prasyarat" name="prasyarat" rows="3" 
                                      placeholder="Masukkan prasyarat khusus jika ada (mata kuliah, kemampuan, dll.)">{{ old('prasyarat') }}</textarea>
                            @error('prasyarat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- SMART Preview -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Analisis SMART</h6>
                            <p class="mb-0">Sistem akan menghitung skor SMART berdasarkan:</p>
                            <ul class="mb-0 mt-2">
                                <li><strong>IPK (30%):</strong> Nilai akademik mahasiswa</li>
                                <li><strong>Semester (20%):</strong> Tingkat semester mahasiswa</li>
                                <li><strong>Kesesuaian Minat (25%):</strong> Kecocokan dengan minat skripsi</li>
                                <li><strong>Keahlian Dosen (15%):</strong> Relevansi dengan bidang keahlian</li>
                                <li><strong>Tingkat Kesulitan (10%):</strong> Kompleksitas judul</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Rekomendasi
                            </button>
                            <a href="{{ route('dosen.rekomendasi.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Student Info Section -->
        <div class="col-lg-4">
            <!-- Mahasiswa Info -->
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
                        <div>{{ $mahasiswa->user->name }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>NIM:</strong>
                        <div>{{ $mahasiswa->nim }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Program Studi:</strong>
                        <div>{{ $mahasiswa->prodi }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Fakultas:</strong>
                        <div>{{ $mahasiswa->fakultas }}</div>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Semester:</strong>
                        <div>{{ $mahasiswa->semester ?? 'N/A' }}</div>
                    </div>
                    
                    @if($mahasiswa->nilai->last())
                        <div class="mb-2">
                            <strong>IPK Terbaru:</strong>
                            <div class="text-primary fw-bold">{{ $mahasiswa->nilai->last()->ipk }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Minat Skripsi -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-heart me-2"></i>Minat Skripsi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Minat:</strong>
                        <div>{{ $pengajuan->minat_skripsi }}</div>
                    </div>
                    
                    @if($pengajuan->deskripsi_minat)
                        <div class="mb-2">
                            <strong>Deskripsi:</strong>
                            <div class="text-muted">{{ $pengajuan->deskripsi_minat }}</div>
                        </div>
                    @endif
                    
                    @if($pengajuan->alasan_memilih)
                        <div class="mb-2">
                            <strong>Alasan Memilih:</strong>
                            <div class="text-muted">{{ $pengajuan->alasan_memilih }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Existing Recommendations -->
            @if($existingRecommendations->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Rekomendasi Sebelumnya
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($existingRecommendations->take(3) as $rec)
                            <div class="border-bottom pb-2 mb-2">
                                <div class="fw-medium">{{ Str::limit($rec->judul_skripsi, 40) }}</div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $rec->created_at->format('d/m/Y') }}</small>
                                    <span class="badge {{ $rec->status_badge }}">{{ $rec->status_text }}</span>
                                </div>
                                <small class="text-primary">Skor: {{ $rec->skor_smart }}/100</small>
                            </div>
                        @endforeach
                        
                        @if($existingRecommendations->count() > 3)
                            <small class="text-muted">Dan {{ $existingRecommendations->count() - 3 }} lainnya...</small>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection