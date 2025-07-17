@extends('auth.layouts.main')

@section('container')
<div class="bg-primary bg-gradient" style="min-height: 100vh;">
    <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-md-4 col-lg-3">
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo.jpeg') }}" alt="logo" class='rounded-circle shadow mb-3' width="96" height="96" style="object-fit: cover;" />
                <h1 class="text-white h3 fw-bold">
                    SPK SMART SKRIPSI
                </h1>
                <p class="text-white-50">Daftar akun baru</p>
            </div>

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">


                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <!-- Field untuk Mahasiswa -->
                        <div id="mahasiswa-fields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input name="nim" type="text" value="{{ old('nim') }}"
                                           class="form-control @error('nim') is-invalid @enderror"
                                           placeholder="Masukkan NIM" />
                                </div>
                                @error('nim')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tahun Masuk</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input name="tahun_masuk" type="number" value="{{ old('tahun_masuk') }}"
                                           class="form-control @error('tahun_masuk') is-invalid @enderror"
                                           placeholder="Contoh: 2024" min="2000" max="{{ date('Y') }}" />
                                </div>
                                @error('tahun_masuk')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Field untuk Dosen -->
                        <div id="dosen-fields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">NIDN</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <input name="nidn" type="text" value="{{ old('nidn') }}"
                                           class="form-control @error('nidn') is-invalid @enderror"
                                           placeholder="Masukkan NIDN" />
                                </div>
                                @error('nidn')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    <input name="pendidikan_terakhir" type="text" value="{{ old('pendidikan_terakhir') }}"
                                           class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                           placeholder="Contoh: S3 Teknik Informatika" />
                                </div>
                                @error('pendidikan_terakhir')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tahun Bergabung</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input name="tahun_bergabung" type="number" value="{{ old('tahun_bergabung') }}"
                                           class="form-control @error('tahun_bergabung') is-invalid @enderror"
                                           placeholder="Contoh: 2020" min="1980" max="{{ date('Y') }}" />
                                </div>
                                @error('tahun_bergabung')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Bidang Keahlian (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-brain"></i></span>
                                    <input name="bidang_keahlian" type="text" value="{{ old('bidang_keahlian') }}"
                                           class="form-control @error('bidang_keahlian') is-invalid @enderror"
                                           placeholder="Contoh: Machine Learning, Database" />
                                </div>
                                @error('bidang_keahlian')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input name="name" type="text" required value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Masukkan Nama Lengkap" />
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input name="email" type="email" required value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Masukkan Email" />
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                <select name="role" id="role" required class="form-control @error('role') is-invalid @enderror">
                                    <option value="">Pilih Role</option>
                                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                </select>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Field umum untuk semua role -->
                        <div id="common-fields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                              placeholder="Masukkan alamat lengkap" rows="2">{{ old('alamat') }}</textarea>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                        <input name="tempat_lahir" type="text" value="{{ old('tempat_lahir') }}"
                                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                                               placeholder="Kota kelahiran" />
                                    </div>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                        <input name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}"
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror" />
                                    </div>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon (Opsional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input name="no_telepon" type="tel" value="{{ old('no_telepon') }}"
                                               class="form-control @error('no_telepon') is-invalid @enderror"
                                               placeholder="08xxxxxxxxxx" />
                                    </div>
                                    @error('no_telepon')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Program Studi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                                        <input name="prodi" type="text" value="{{ old('prodi') }}"
                                               class="form-control @error('prodi') is-invalid @enderror"
                                               placeholder="Contoh: Teknik Informatika" />
                                    </div>
                                    @error('prodi')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fakultas</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                                        <input name="fakultas" type="text" value="{{ old('fakultas') }}"
                                               class="form-control @error('fakultas') is-invalid @enderror"
                                               placeholder="Contoh: Fakultas Teknik" />
                                    </div>
                                    @error('fakultas')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" name="password" type="password" required
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan Password (min. 8 karakter)" />
                                <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                    <i id="eyeOpen" class="fas fa-eye"></i>
                                    <i id="eyeClosed" class="fas fa-eye-slash d-none"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Daftar Akun
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                Masuk disini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
