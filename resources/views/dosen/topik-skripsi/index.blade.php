@extends('dosen.layouts.main')

@section('title', 'Topik Skripsi')

@section('container')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Manajemen Topik Skripsi</h1>
            <p class="text-muted mb-0">Kelola dan pantau topik skripsi mahasiswa</p>
        </div>
        <a href="{{ route('dosen.topik-skripsi.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Tambah Topik Baru
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Topik</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $topikSkripsi->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Topik Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $topikSkripsi->where('status', 'aktif')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Topik Skripsi</h6>
        </div>
        <div class="card-body">
            @if($topikSkripsi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th width="25%">Judul & Deskripsi</th>
                                <th width="15%">Mahasiswa</th>
                                <th class="text-center" width="10%">Tahun</th>
                                <th class="text-center" width="12%">Bidang</th>
                                <th class="text-center" width="8%">Status</th>
                                <th width="15%">File</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topikSkripsi as $index => $topik)
                                <tr>
                                    <td class="text-center font-weight-bold">{{ $topikSkripsi->firstItem() + $index }}</td>
                                    <td>
                                        <div class="font-weight-bold text-primary mb-1">{{ Str::limit($topik->judul, 60) }}</div>
                                        @if($topik->deskripsi)
                                            <small class="text-muted">{{ Str::limit($topik->deskripsi, 100) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $topik->nama_mahasiswa }}</div>
                                        <small class="text-muted"><i class="fas fa-id-card me-1"></i>{{ $topik->nim_mahasiswa }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-light text-black">{{ $topik->tahun_lulus }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($topik->bidang_keahlian)
                                            <span class="badge badge-info text-black">{{ $topik->bidang_keahlian }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($topik->status == 'aktif')
                                            <span class="badge badge-success text-black"><i class="fas fa-check me-1"></i>Aktif</span>
                                        @else
                                            <span class="badge badge-secondary text-black"><i class="fas fa-times me-1"></i>Non Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small font-weight-bold">{{ Str::limit($topik->file_name, 20) }}</div>
                                                <div class="text-muted small">{{ $topik->formatted_file_size }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('dosen.topik-skripsi.show', $topik) }}">
                                                    <i class="fas fa-eye me-2"></i>Detail
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('dosen.topik-skripsi.download', $topik) }}">
                                                    <i class="fas fa-download me-2"></i>Download
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('dosen.topik-skripsi.edit', $topik) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $topik->id }})">
                                                    <i class="fas fa-trash me-2"></i>Hapus
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Menampilkan {{ $topikSkripsi->firstItem() }} sampai {{ $topikSkripsi->lastItem() }} dari {{ $topikSkripsi->total() }} data
                    </div>
                    <div>
                        {{ $topikSkripsi->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-book fa-4x text-gray-300"></i>
                    </div>
                    <h4 class="text-gray-600 mb-2">Belum Ada Topik Skripsi</h4>
                    <p class="text-muted mb-4">Mulai tambahkan topik skripsi untuk referensi mahasiswa dalam penelitian mereka.</p>
                    <a href="{{ route('dosen.topik-skripsi.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-plus me-2"></i>Tambah Topik Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus topik skripsi ini?</p>
                <p class="text-danger small">File PDF juga akan terhapus secara permanen.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.text-xs {
    font-size: 0.7rem;
}

.font-weight-bold {
    font-weight: 700 !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.text-gray-600 {
    color: #858796 !important;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    border: 1px solid #e3e6f0;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    color: #5a5c69;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.dropdown-menu {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border: 1px solid #e3e6f0;
}

.btn-outline-primary:hover {
    background-color: #4e73df;
    border-color: #4e73df;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(id) {
    const form = document.getElementById('deleteForm');
    form.action = `/dosen/topik-skripsi/${id}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
