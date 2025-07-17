@extends('dosen.layouts.main')
@section('container')
<div class="p-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 fw-bold text-dark">Profile Saya</h1>
                <p class="text-muted">Informasi lengkap profile dosen</p>
            </div>
            <a href="{{ route('dosen.profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="card border-0 shadow-sm">
        <!-- Profile Header -->
        <div class="card-header bg-primary text-white">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-chalkboard-teacher text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="mb-0 opacity-75">{{ $user->email }}</p>
                    <small class="opacity-75">NIDN: {{ $dosen->nidn ?? '-' }}</small>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="card-body">
            <div class="row">
                <!-- Personal Information -->
                <div class="col-md-6">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="fas fa-user text-primary me-2"></i>
                        Informasi Personal
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted fw-semibold">Nama Lengkap</label>
                            <p class="mb-2">{{ $user->name }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted fw-semibold">Email</label>
                            <p class="mb-2">{{ $user->email }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Tempat Lahir</label>
                            <p class="mb-2">{{ $dosen->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Tanggal Lahir</label>
                            <p class="mb-2">{{ $dosen->tanggal_lahir ? \Carbon\Carbon::parse($dosen->tanggal_lahir)->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Jenis Kelamin</label>
                            <p class="mb-2">{{ $dosen->jenis_kelamin == 'L' ? 'Laki-laki' : ($dosen->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Telepon</label>
                            <p class="mb-2">{{ $dosen->no_telepon ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted fw-semibold">Alamat</label>
                            <p class="mb-2">{{ $dosen->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="col-md-6">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                        Informasi Akademik
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted fw-semibold">NIDN</label>
                            <p class="mb-2 font-monospace">{{ $dosen->nidn ?? '-' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Fakultas</label>
                            <p class="mb-2">{{ $dosen->fakultas ?? '-' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Program Studi</label>
                            <p class="mb-2">{{ $dosen->prodi ?? '-' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Pendidikan Terakhir</label>
                            <p class="mb-2">{{ $dosen->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted fw-semibold">Tahun Bergabung</label>
                            <p class="mb-2">{{ $dosen->tahun_bergabung ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted fw-semibold">Bidang Keahlian</label>
                            <p class="mb-2">{{ $dosen->bidang_keahlian ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <hr class="my-4">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Sistem
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted fw-semibold">Terdaftar Pada</label>
                            <p class="mb-2">{{ $user->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted fw-semibold">Terakhir Diperbarui</label>
                            <p class="mb-2">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted fw-semibold">Status Email</label>
                            <p class="mb-2">
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Belum Terverifikasi
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dosen.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('dosen.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection