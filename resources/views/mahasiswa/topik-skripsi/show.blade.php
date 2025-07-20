@extends('mahasiswa.layouts.main')

@section('title', 'Detail Topik Skripsi')

@section('container')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('mahasiswa.partials.sidebar')

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Detail Topik Skripsi</h2>
                <a href="{{ route('mahasiswa.topik-skripsi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi Topik Skripsi</h5>
                        </div>
                        <div class="card-body">
                            <!-- Judul -->
                            <div class="mb-4">
                                <h4 class="text-primary">{{ $topikSkripsi->judul }}</h4>
                            </div>

                            <!-- Deskripsi -->
                            @if($topikSkripsi->deskripsi)
                                <div class="mb-4">
                                    <h6 class="fw-bold">Deskripsi:</h6>
                                    <p class="text-muted">{{ $topikSkripsi->deskripsi }}</p>
                                </div>
                            @endif

                            <!-- Info Grid -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="fw-bold">Program Studi:</h6>
                                        <p class="mb-0">{{ $topikSkripsi->prodi }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="fw-bold">Fakultas:</h6>
                                        <p class="mb-0">{{ $topikSkripsi->fakultas }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="fw-bold">Bidang Keahlian:</h6>
                                        <p class="mb-0">
                                            @if($topikSkripsi->bidang_keahlian)
                                                <span class="badge bg-info">{{ $topikSkripsi->bidang_keahlian }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="fw-bold">Tahun Lulus:</h6>
                                        <p class="mb-0">{{ $topikSkripsi->tahun_lulus }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Mahasiswa -->
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Data Mahasiswa yang Mengerjakan</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Nama:</strong> {{ $topikSkripsi->nama_mahasiswa }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>NIM:</strong> {{ $topikSkripsi->nim_mahasiswa }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kata Kunci -->
                            @if($topikSkripsi->kata_kunci)
                                <div class="mt-4">
                                    <h6 class="fw-bold">Kata Kunci:</h6>
                                    <div>
                                        @foreach(explode(',', $topikSkripsi->kata_kunci) as $keyword)
                                            <span class="badge bg-secondary me-1">{{ trim($keyword) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Inspirasi Section -->
                            <div class="mt-4">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Tips Menggunakan Referensi</h6>
                                    <ul class="mb-0">
                                        <li>Gunakan topik ini sebagai <strong>inspirasi</strong>, bukan untuk disalin</li>
                                        <li>Kembangkan ide dengan pendekatan atau metode yang berbeda</li>
                                        <li>Diskusikan dengan dosen pembimbing untuk pengembangan topik</li>
                                        <li>Pastikan topik yang dipilih sesuai dengan minat dan kemampuan Anda</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- File Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">File PDF Skripsi</h6>
                        </div>
                        <div class="card-body text-center">
                            <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                            <h6>{{ $topikSkripsi->file_name }}</h6>
                            <p class="text-muted">{{ $topikSkripsi->formatted_file_size }}</p>

                            <div class="d-grid gap-2">
                                <a href="{{ route('mahasiswa.topik-skripsi.view', $topikSkripsi) }}"
                                   class="btn btn-primary" target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>Buka PDF
                                </a>
                                <a href="{{ route('mahasiswa.topik-skripsi.download', $topikSkripsi) }}"
                                   class="btn btn-success">
                                    <i class="fas fa-download me-2"></i>Download PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Dosen Info -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Dosen Pembimbing</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                @if($topikSkripsi->dosen->foto)
                                    <img src="{{ Storage::url($topikSkripsi->dosen->foto) }}"
                                         alt="Foto Dosen" class="rounded-circle me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $topikSkripsi->dosen->user->name }}</h6>
                                    <small class="text-muted">{{ $topikSkripsi->dosen->nidn }}</small>
                                </div>
                            </div>

                            <div class="small">
                                <p class="mb-1"><strong>Jabatan:</strong> {{ $topikSkripsi->dosen->jabatan_akademik ?? '-' }}</p>
                                <p class="mb-1"><strong>Pendidikan:</strong> {{ $topikSkripsi->dosen->pendidikan_terakhir }}</p>
                                <p class="mb-1"><strong>Bidang Keahlian:</strong> {{ $topikSkripsi->dosen->bidang_keahlian ?? '-' }}</p>
                                <p class="mb-0"><strong>Email:</strong> {{ $topikSkripsi->dosen->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Topics -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Topik Terkait</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($topikSkripsi->bidang_keahlian)
                                    <a href="{{ route('mahasiswa.topik-skripsi.index', ['bidang_keahlian' => $topikSkripsi->bidang_keahlian]) }}"
                                       class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-tag me-1"></i>Bidang: {{ $topikSkripsi->bidang_keahlian }}
                                    </a>
                                @endif
                                <a href="{{ route('mahasiswa.topik-skripsi.index', ['tahun_lulus' => $topikSkripsi->tahun_lulus]) }}"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-calendar me-1"></i>Tahun: {{ $topikSkripsi->tahun_lulus }}
                                </a>
                                @if($topikSkripsi->kata_kunci)
                                    @php
                                        $firstKeyword = trim(explode(',', $topikSkripsi->kata_kunci)[0]);
                                    @endphp
                                    <a href="{{ route('mahasiswa.topik-skripsi.index', ['search' => $firstKeyword]) }}"
                                       class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-search me-1"></i>Kata Kunci: {{ $firstKeyword }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.alert-info {
    border-left: 4px solid #0dcaf0;
}

.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>
@endpush
