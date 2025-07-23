<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanPembimbing;
use App\Models\RekomendasiJudul;
use App\Models\TopikSkripsi;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        // Statistik Pengajuan Pembimbing
        $totalPengajuan = $dosen->pengajuanPembimbing()->count();
        $pengajuanPending = $dosen->pengajuanPending()->count();
        $mahasiswaBimbingan = $dosen->mahasiswaBimbingan()->count();
        $pengajuanDitolak = $dosen->pengajuanPembimbing()->where('status', 'ditolak')->count();

        // Statistik Rekomendasi Judul
        $totalRekomendasi = $dosen->rekomendasiJudul()->count();
        $rekomendasiDraft = $dosen->rekomendasiJudul()->where('status', 'draft')->count();
        $rekomendasiDikirim = $dosen->rekomendasiJudul()->where('status', 'dikirim')->count();
        $rekomendasiDiterima = $dosen->rekomendasiJudul()->where('status', 'diterima')->count();
        $rekomendasiDitolak = $dosen->rekomendasiJudul()->where('status', 'ditolak')->count();

        // Statistik Topik Skripsi
        $totalTopikSkripsi = $dosen->topikSkripsi()->count();
        $topikAktif = $dosen->topikSkripsiAktif()->count();

        // Pengajuan Pembimbing Terbaru
        $pengajuanTerbaru = $dosen->pengajuanPembimbing()
            ->with('mahasiswa.user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Rekomendasi Terbaru
        $rekomendasiTerbaru = $dosen->rekomendasiJudul()
            ->with('mahasiswa.user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Rata-rata Skor SMART
        $rataRataSkor = $dosen->rekomendasiJudul()
            ->whereNotNull('skor_smart')
            ->avg('skor_smart') ?? 0;

        return view('dosen.dashboard.index', compact(
            'dosen',
            'totalPengajuan',
            'pengajuanPending', 
            'mahasiswaBimbingan',
            'pengajuanDitolak',
            'totalRekomendasi',
            'rekomendasiDraft',
            'rekomendasiDikirim',
            'rekomendasiDiterima',
            'rekomendasiDitolak',
            'totalTopikSkripsi',
            'topikAktif',
            'pengajuanTerbaru',
            'rekomendasiTerbaru',
            'rataRataSkor'
        ));
    }
}