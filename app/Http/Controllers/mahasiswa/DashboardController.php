<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\RekomendasiJudul;
use App\Models\PengajuanPembimbing;
use App\Models\TopikSkripsi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Statistik Rekomendasi
        $totalRekomendasi = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)->count();
        $rekomendasiDiterima = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diterima')->count();
        $rekomendasiPending = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'pending')->count();
        $rekomendasiDitolak = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'ditolak')->count();

        // Status Pembimbing
        $pengajuanPembimbing = PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('created_at', 'desc')->first();
        
        // Rekomendasi Terbaru
        $rekomendasiTerbaru = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->with('dosen.user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Rata-rata Skor SMART
        $rataRataSkor = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->whereNotNull('skor_smart')
            ->avg('skor_smart') ?? 0;

        // Topik Skripsi yang tersedia untuk prodi mahasiswa
        $topikTersedia = TopikSkripsi::where('prodi', $mahasiswa->prodi)
            ->where('status', 'aktif')
            ->with('dosen.user')
            ->limit(6)
            ->get();

        return view('mahasiswa.dashboard.index', compact(
            'mahasiswa',
            'totalRekomendasi',
            'rekomendasiDiterima', 
            'rekomendasiPending',
            'rekomendasiDitolak',
            'pengajuanPembimbing',
            'rekomendasiTerbaru',
            'rataRataSkor',
            'topikTersedia'
        ));
    }
}