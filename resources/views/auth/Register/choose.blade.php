@extends('auth.layouts.main')

@section('title', 'Pilih Jenis Registrasi')

@section('container')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">{{ __('Pilih Jenis Registrasi') }}</h4>
                    <p class="text-muted mt-2">Silakan pilih jenis akun yang ingin Anda daftarkan</p>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Registrasi Mahasiswa -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <svg width="64" height="64" fill="currentColor" class="bi bi-person-badge text-primary" viewBox="0 0 16 16">
                                            <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                            <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"/>
                                        </svg>
                                    </div>
                                    <h5 class="card-title text-primary">Mahasiswa</h5>
                                    <p class="card-text">Daftar sebagai mahasiswa untuk mengakses sistem akademik dan layanan mahasiswa.</p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="bi bi-check-circle text-success"></i> Akses dashboard mahasiswa</li>
                                        <li><i class="bi bi-check-circle text-success"></i> Lihat jadwal kuliah</li>
                                        <li><i class="bi bi-check-circle text-success"></i> Akses nilai dan transkrip</li>
                                        <li><i class="bi bi-check-circle text-success"></i> Konsultasi dengan dosen</li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('mahasiswa.register.form') }}" class="btn btn-primary btn-block w-100">
                                        <i class="bi bi-person-plus"></i> Daftar sebagai Mahasiswa
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Registrasi Dosen -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <svg width="64" height="64" fill="currentColor" class="bi bi-person-workspace text-success" viewBox="0 0 16 16">
                                            <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                            <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
                                        </svg>
                                    </div>
                                    <h5 class="card-title text-success">Dosen</h5>
                                    <p class="card-text">Daftar sebagai dosen untuk mengakses sistem manajemen akademik dan pengajaran.</p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="bi bi-check-circle text-success"></i> Akses dashboard dosen</li>
                                        <li><i class="bi bi-check-circle text-success"></i> Kelola mata kuliah</li>
                                        <li><i class="bi bi-check-circle text-success"></i> Input nilai mahasiswa</li>
                                        <li><i class="bi bi-check-circle text-success"></i> Konsultasi dengan mahasiswa</li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('dosen.register.form') }}" class="btn btn-success btn-block w-100">
                                        <i class="bi bi-person-plus"></i> Daftar sebagai Dosen
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted">Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="bi bi-box-arrow-in-right"></i> Login di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.bi {
    margin-right: 5px;
}
</style>
@endpush
