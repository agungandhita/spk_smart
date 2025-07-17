@extends('mahasiswa.layouts.main')

@section('container')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Minat & Preferensi Pembimbing</h2>
                    <p class="text-muted mb-0">Pilih pembimbing akademik sesuai minat skripsi Anda</p>
                </div>
                @if(!$pengajuanAktif && !$pengajuanDisetujui)
                    <a href="{{ route('mahasiswa.pembimbing.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajukan Pembimbing
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Current Status -->
    @if($pengajuanAktif)
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock me-3 fa-2x"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1">Pengajuan Sedang Diproses</h5>
                            <p class="mb-2">Anda telah mengajukan <strong>{{ $pengajuanAktif->dosen->user->name }}</strong> sebagai pembimbing akademik.</p>
                            <p class="mb-0"><strong>Minat Skripsi:</strong> {{ $pengajuanAktif->minat_skripsi }}</p>
                        </div>
                        <div>
                            <a href="{{ route('mahasiswa.pembimbing.show', $pengajuanAktif->id) }}" class="btn btn-outline-warning me-2">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            <form action="{{ route('mahasiswa.pembimbing.cancel', $pengajuanAktif->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan pengajuan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-1"></i>Batalkan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($pengajuanDisetujui)
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fa-2x"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1">Pembimbing Akademik Telah Ditetapkan</h5>
                            <p class="mb-2">Selamat! <strong>{{ $pengajuanDisetujui->dosen->user->name }}</strong> telah menyetujui menjadi pembimbing akademik Anda.</p>
                            <p class="mb-0"><strong>Minat Skripsi:</strong> {{ $pengajuanDisetujui->minat_skripsi }}</p>
                        </div>
                        <div>
                            <a href="{{ route('mahasiswa.pembimbing.show', $pengajuanDisetujui->id) }}" class="btn btn-outline-success">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Available Supervisors -->
    @if(!$pengajuanAktif && !$pengajuanDisetujui)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-users me-2"></i>Dosen Pembimbing Tersedia
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($dosenTersedia->count() > 0)
                            <div class="row">
                                @foreach($dosenTersedia as $dosen)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 border">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    @if($dosen->foto && Storage::disk('public')->exists($dosen->foto))
                                                        <img src="{{ Storage::disk('public')->url($dosen->foto) }}" 
                                                             alt="Foto Dosen" 
                                                             class="rounded-circle" 
                                                             width="80" 
                                                             height="80" 
                                                             style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                                             style="width: 80px; height: 80px;">
                                                            <i class="fas fa-user-tie text-white" style="font-size: 2rem;"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <h6 class="card-title mb-1">{{ $dosen->user->name }}</h6>
                                                <p class="text-muted small mb-2">{{ $dosen->nidn }}</p>
                                                <p class="text-muted small mb-2">{{ $dosen->jabatan_akademik }}</p>
                                                @if($dosen->bidang_keahlian)
                                                    <span class="badge bg-info mb-2">{{ $dosen->bidang_keahlian }}</span>
                                                @endif
                                                <p class="small text-muted mb-3">{{ $dosen->pendidikan_terakhir }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users text-muted fa-3x mb-3"></i>
                                <p class="text-muted">Tidak ada dosen pembimbing tersedia untuk program studi Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Application History -->
    @if($riwayatPengajuan->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Pengajuan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Dosen</th>
                                        <th>Minat Skripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatPengajuan as $pengajuan)
                                        <tr>
                                            <td>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        @if($pengajuan->dosen->foto && Storage::disk('public')->exists($pengajuan->dosen->foto))
                                                            <img src="{{ Storage::disk('public')->url($pengajuan->dosen->foto) }}" 
                                                                 alt="Foto Dosen" 
                                                                 class="rounded-circle" 
                                                                 width="32" 
                                                                 height="32" 
                                                                 style="object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                                 style="width: 32px; height: 32px;">
                                                                <i class="fas fa-user-tie text-white" style="font-size: 0.8rem;"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $pengajuan->dosen->user->name }}</div>
                                                        <small class="text-muted">{{ $pengajuan->dosen->nidn }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $pengajuan->minat_skripsi }}</td>
                                            <td>
                                                <span class="badge {{ $pengajuan->status_badge }}">
                                                    {{ $pengajuan->status_text }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('mahasiswa.pembimbing.show', $pengajuan->id) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($pengajuan->status === 'pending')
                                                    <form action="{{ route('mahasiswa.pembimbing.cancel', $pengajuan->id) }}" 
                                                          method="POST" 
                                                          class="d-inline ms-1" 
                                                          onsubmit="return confirm('Yakin ingin membatalkan pengajuan?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection