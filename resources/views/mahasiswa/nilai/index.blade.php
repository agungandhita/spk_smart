@extends('mahasiswa.layouts.main')
@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Data Nilai KHS/IPK
                    </h4>
                    <a href="{{ route('mahasiswa.nilai.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Data Nilai
                    </a>
                </div>
                <div class="card-body">
                    <!-- Info Mahasiswa -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box bg-light p-3 rounded">
                                <h6 class="text-muted mb-2">Informasi Mahasiswa</h6>
                                <p class="mb-1"><strong>Nama:</strong> {{ $mahasiswa->nama_lengkap }}</p>
                                <p class="mb-1"><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
                                <p class="mb-1"><strong>Program Studi:</strong> {{ $mahasiswa->prodi }}</p>
                                <p class="mb-0"><strong>IPK Saat Ini:</strong> 
                                    <span class="badge bg-{{ $mahasiswa->ipk >= 3.5 ? 'success' : ($mahasiswa->ipk >= 3.0 ? 'warning' : 'danger') }}">
                                        {{ number_format($mahasiswa->ipk, 2) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light p-3 rounded">
                                <h6 class="text-muted mb-2">Statistik Akademik</h6>
                                <p class="mb-1"><strong>Total Semester:</strong> {{ $nilai->count() }} dari 8 semester</p>
                                <p class="mb-1"><strong>Semester Aktif:</strong> {{ $mahasiswa->semester }}</p>
                                <p class="mb-0"><strong>Status:</strong> 
                                    <span class="badge bg-{{ $mahasiswa->status == 'aktif' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($mahasiswa->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($nilai->count() > 0)
                        <!-- Tabel Data Nilai -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="10%">Semester</th>
                                        <th width="15%">IPS</th>
                                        <th width="15%">IPK</th>
                                        <th width="12%">SKS Semester</th>
                                        <th width="12%">SKS Kumulatif</th>
                                        <th width="15%">File KHS</th>
                                        <th width="21%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilai as $item)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">Semester {{ $item->semester }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $item->ips >= 3.5 ? 'success' : ($item->ips >= 3.0 ? 'warning' : 'danger') }}">
                                                {{ number_format($item->ips, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $item->ipk >= 3.5 ? 'success' : ($item->ipk >= 3.0 ? 'warning' : 'danger') }}">
                                                {{ number_format($item->ipk, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->sks_semester }} SKS</td>
                                        <td>{{ $item->sks_kumulatif }} SKS</td>
                                        <td>
                                            @if($item->file_khs)
                                                <a href="{{ route('mahasiswa.nilai.download', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-success" 
                                                   title="Download KHS">
                                                    <i class="fas fa-download"></i> PDF
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak ada file</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('mahasiswa.nilai.show', $item->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('mahasiswa.nilai.edit', $item->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('mahasiswa.nilai.destroy', $item->id) }}" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nilai semester {{ $item->semester }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Grafik Progress IPK -->
                        <div class="mt-4">
                            <h5>Grafik Perkembangan IPK</h5>
                            <canvas id="ipkChart" width="400" height="100"></canvas>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Data Nilai</h5>
                            <p class="text-muted mb-4">Anda belum menambahkan data nilai KHS/IPK. Mulai tambahkan data nilai untuk melihat perkembangan akademik Anda.</p>
                            <a href="{{ route('mahasiswa.nilai.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Tambah Data Nilai Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($nilai->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data untuk grafik IPK
const semesterData = @json($nilai->pluck('semester'));
const ipkData = @json($nilai->pluck('ipk'));

// Konfigurasi Chart.js
const ctx = document.getElementById('ipkChart').getContext('2d');
const ipkChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: semesterData.map(sem => `Semester ${sem}`),
        datasets: [{
            label: 'IPK',
            data: ipkData,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Perkembangan IPK per Semester'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 4.0,
                ticks: {
                    stepSize: 0.5
                }
            }
        }
    }
});
</script>
@endif
@endpush