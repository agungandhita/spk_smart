@extends('mahasiswa.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('mahasiswa.pembimbing.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="h4 mb-1">Pengajuan Pembimbing Akademik</h2>
                    <p class="text-muted mb-0">Pilih dosen pembimbing dan jelaskan minat skripsi Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2"></i>Form Pengajuan Pembimbing
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('mahasiswa.pembimbing.store') }}" method="POST">
                        @csrf
                        
                        <!-- Pilih Dosen -->
                        <div class="mb-4">
                            <label for="dosen_id" class="form-label fw-medium">
                                <i class="fas fa-user-tie me-2"></i>Pilih Dosen Pembimbing
                            </label>
                            <select class="form-select @error('dosen_id') is-invalid @enderror" 
                                    id="dosen_id" 
                                    name="dosen_id" 
                                    required>
                                <option value="">-- Pilih Dosen --</option>
                                @foreach($dosenTersedia as $dosen)
                                    <option value="{{ $dosen->id }}" 
                                            {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}
                                            data-bidang="{{ $dosen->bidang_keahlian }}"
                                            data-pendidikan="{{ $dosen->pendidikan_terakhir }}"
                                            data-jabatan="{{ $dosen->jabatan_akademik }}">
                                        {{ $dosen->user->name }} - {{ $dosen->nidn }}
                                        @if($dosen->bidang_keahlian)
                                            ({{ $dosen->bidang_keahlian }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('dosen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Dosen Info Display -->
                            <div id="dosen-info" class="mt-3" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-2">Informasi Dosen</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <small class="text-muted">Jabatan Akademik:</small>
                                                <div id="dosen-jabatan" class="fw-medium"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted">Bidang Keahlian:</small>
                                                <div id="dosen-bidang" class="fw-medium"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted">Pendidikan Terakhir:</small>
                                                <div id="dosen-pendidikan" class="fw-medium"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Minat Skripsi -->
                        <div class="mb-4">
                            <label for="minat_skripsi" class="form-label fw-medium">
                                <i class="fas fa-lightbulb me-2"></i>Minat Skripsi
                            </label>
                            <input type="text" 
                                   class="form-control @error('minat_skripsi') is-invalid @enderror" 
                                   id="minat_skripsi" 
                                   name="minat_skripsi" 
                                   value="{{ old('minat_skripsi') }}"
                                   placeholder="Contoh: Sistem Informasi Manajemen, Machine Learning, Web Development"
                                   required>
                            @error('minat_skripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Tuliskan bidang atau topik yang Anda minati untuk skripsi
                            </div>
                        </div>

                        <!-- Deskripsi Minat -->
                        <div class="mb-4">
                            <label for="deskripsi_minat" class="form-label fw-medium">
                                <i class="fas fa-file-alt me-2"></i>Deskripsi Minat Skripsi
                            </label>
                            <textarea class="form-control @error('deskripsi_minat') is-invalid @enderror" 
                                      id="deskripsi_minat" 
                                      name="deskripsi_minat" 
                                      rows="4"
                                      placeholder="Jelaskan secara detail minat skripsi Anda, topik yang ingin diteliti, atau masalah yang ingin diselesaikan..."
                                      required>{{ old('deskripsi_minat') }}</textarea>
                            @error('deskripsi_minat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Jelaskan secara detail tentang minat skripsi Anda (minimal 50 karakter)
                            </div>
                        </div>

                        <!-- Alasan Memilih -->
                        <div class="mb-4">
                            <label for="alasan_memilih" class="form-label fw-medium">
                                <i class="fas fa-question-circle me-2"></i>Alasan Memilih Dosen Ini
                            </label>
                            <textarea class="form-control @error('alasan_memilih') is-invalid @enderror" 
                                      id="alasan_memilih" 
                                      name="alasan_memilih" 
                                      rows="3"
                                      placeholder="Jelaskan mengapa Anda memilih dosen ini sebagai pembimbing akademik..."
                                      required>{{ old('alasan_memilih') }}</textarea>
                            @error('alasan_memilih')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Jelaskan alasan Anda memilih dosen ini (kesesuaian bidang keahlian, pengalaman, dll.)
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mahasiswa.pembimbing.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dosenSelect = document.getElementById('dosen_id');
    const dosenInfo = document.getElementById('dosen-info');
    const dosenJabatan = document.getElementById('dosen-jabatan');
    const dosenBidang = document.getElementById('dosen-bidang');
    const dosenPendidikan = document.getElementById('dosen-pendidikan');
    
    dosenSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const bidang = selectedOption.getAttribute('data-bidang') || '-';
            const pendidikan = selectedOption.getAttribute('data-pendidikan') || '-';
            const jabatan = selectedOption.getAttribute('data-jabatan') || '-';
            
            dosenJabatan.textContent = jabatan;
            dosenBidang.textContent = bidang;
            dosenPendidikan.textContent = pendidikan;
            
            dosenInfo.style.display = 'block';
        } else {
            dosenInfo.style.display = 'none';
        }
    });
    
    // Trigger change event if there's a pre-selected value
    if (dosenSelect.value) {
        dosenSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection