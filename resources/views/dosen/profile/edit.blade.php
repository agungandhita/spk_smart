@extends('dosen.layouts.main')
@section('container')
<div class="p-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 fw-bold text-dark">Edit Profile</h1>
                <p class="text-muted">Perbarui informasi profile Anda</p>
            </div>
            <a href="{{ route('dosen.profile.show') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>
                Form Edit Profile
            </h5>
        </div>
        
        <form action="{{ route('dosen.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="row">
                    <!-- Personal Information -->
                    <div class="col-md-6">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="fas fa-user text-primary me-2"></i>
                            Informasi Personal
                        </h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                           id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $dosen->tempat_lahir) }}" required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $dosen->tanggal_lahir) }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                            id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin', $dosen->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $dosen->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label fw-semibold">Telepon</label>
                                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" 
                                           id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $dosen->no_telepon) }}">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $dosen->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="col-md-6">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="fas fa-graduation-cap text-primary me-2"></i>
                            Informasi Akademik
                        </h5>
                        
                        <div class="mb-3">
                            <label for="nidn" class="form-label fw-semibold">NIDN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nidn') is-invalid @enderror" 
                                   id="nidn" name="nidn" value="{{ old('nidn', $dosen->nidn) }}" required>
                            @error('nidn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fakultas" class="form-label fw-semibold">Fakultas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('fakultas') is-invalid @enderror" 
                                           id="fakultas" name="fakultas" value="{{ old('fakultas', $dosen->fakultas) }}" required>
                                    @error('fakultas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prodi" class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('prodi') is-invalid @enderror" 
                                           id="prodi" name="prodi" value="{{ old('prodi', $dosen->prodi) }}" required>
                                    @error('prodi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pendidikan_terakhir" class="form-label fw-semibold">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                    <select class="form-select @error('pendidikan_terakhir') is-invalid @enderror" 
                                            id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="S1" {{ old('pendidikan_terakhir', $dosen->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('pendidikan_terakhir', $dosen->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('pendidikan_terakhir', $dosen->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tahun_bergabung" class="form-label fw-semibold">Tahun Bergabung <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tahun_bergabung') is-invalid @enderror" 
                                           id="tahun_bergabung" name="tahun_bergabung" 
                                           value="{{ old('tahun_bergabung', $dosen->tahun_bergabung) }}" 
                                           min="1900" max="{{ date('Y') }}" required>
                                    @error('tahun_bergabung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bidang_keahlian" class="form-label fw-semibold">Bidang Keahlian</label>
                            <textarea class="form-control @error('bidang_keahlian') is-invalid @enderror" 
                                      id="bidang_keahlian" name="bidang_keahlian" rows="3">{{ old('bidang_keahlian', $dosen->bidang_keahlian) }}</textarea>
                            @error('bidang_keahlian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <hr class="my-4">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="fas fa-lock text-primary me-2"></i>
                            Ubah Password (Opsional)
                        </h5>
                        <p class="text-muted mb-3">Kosongkan jika tidak ingin mengubah password</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password Baru</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('dosen.profile.show') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection