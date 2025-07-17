@extends('mahasiswa.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Profil Akademik</h2>
                    <p class="text-muted mb-0">Informasi lengkap profil dan data akademik mahasiswa</p>
                </div>
                <a href="{{ route('mahasiswa.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto))
                            <img src="{{ Storage::disk('public')->url($mahasiswa->foto) }}" 
                                 alt="Foto Profil" 
                                 class="rounded-circle" 
                                 width="120" 
                                 height="120" 
                                 style="object-fit: cover;">
                        @else
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px;">
                                <i class="fas fa-user-graduate text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="card-title mb-1">{{ $mahasiswa->nama_lengkap }}</h5>
                    <p class="text-muted mb-2">{{ $mahasiswa->nim }}</p>
                    <span class="badge bg-success">{{ ucfirst($mahasiswa->status ?? 'Aktif') }}</span>
                </div>
            </div>

            <!-- Academic Statistics -->
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Akademik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ number_format($ipkTerbaru, 2) }}</h4>
                                <small class="text-muted">IPK Terbaru</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <h4 class="text-success mb-1">{{ $semesterAktif }}</h4>
                            <small class="text-muted">Semester</small>
                        </div>
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-info mb-1">{{ $totalSemester }}</h4>
                                <small class="text-muted">Total KHS</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-1">{{ $totalSks ?? 0 }}</h4>
                            <small class="text-muted">Total SKS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Informasi Pribadi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Nama Lengkap</label>
                            <p class="mb-0">{{ $mahasiswa->nama_lengkap }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Email</label>
                            <p class="mb-0">{{ $mahasiswa->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Tempat Lahir</label>
                            <p class="mb-0">{{ $mahasiswa->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Tanggal Lahir</label>
                            <p class="mb-0">{{ $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Jenis Kelamin</label>
                            <p class="mb-0">{{ $mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($mahasiswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">No. Telepon</label>
                            <p class="mb-0">{{ $mahasiswa->no_telepon ?? '-' }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">Alamat</label>
                            <p class="mb-0">{{ $mahasiswa->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Informasi Akademik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">NIM</label>
                            <p class="mb-0 fw-medium">{{ $mahasiswa->nim }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Program Studi</label>
                            <p class="mb-0">{{ $mahasiswa->prodi ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Fakultas</label>
                            <p class="mb-0">{{ $mahasiswa->fakultas ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Tahun Masuk</label>
                            <p class="mb-0">{{ $mahasiswa->tahun_masuk ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Semester Aktif</label>
                            <p class="mb-0">{{ $mahasiswa->semester ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">IPK</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $ipkTerbaru >= 3.5 ? 'success' : ($ipkTerbaru >= 3.0 ? 'warning' : 'danger') }}">
                                    {{ number_format($ipkTerbaru, 2) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Status</label>
                            <p class="mb-0">
                                <span class="badge bg-success">{{ ucfirst($mahasiswa->status ?? 'Aktif') }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">Pembimbing Akademik</label>
                            <p class="mb-0">{{ $mahasiswa->pembimbing_akademik ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Academic Records -->
            @if($nilaiTerbaru->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Riwayat Nilai Terbaru
                    </h6>
                    <a href="{{ route('mahasiswa.nilai.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Semester</th>
                                    <th>IPS</th>
                                    <th>IPK</th>
                                    <th>SKS</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nilaiTerbaru as $nilai)
                                <tr>
                                    <td>{{ $nilai->semester }}</td>
                                    <td>{{ number_format($nilai->ips, 2) }}</td>
                                    <td>{{ number_format($nilai->ipk, 2) }}</td>
                                    <td>{{ $nilai->sks_semester }}</td>
                                    <td>
                                        <a href="{{ route('mahasiswa.nilai.show', $nilai->id) }}" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection