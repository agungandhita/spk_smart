<?php

namespace App\Http\Controllers;

use App\Models\TopikSkripsi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaTopikSkripsiController extends Controller
{
    /**
     * Display a listing of topik skripsi for mahasiswa.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $query = TopikSkripsi::with('dosen.user')
            ->where('prodi', $mahasiswa->prodi)
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter berdasarkan bidang keahlian
        if ($request->filled('bidang_keahlian')) {
            $query->where('bidang_keahlian', $request->bidang_keahlian);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        $topikSkripsi = $query->paginate(12);

        // Get available bidang keahlian for filter
        $bidangKeahlian = TopikSkripsi::where('prodi', $mahasiswa->prodi)
            ->where('status', 'aktif')
            ->whereNotNull('bidang_keahlian')
            ->distinct()
            ->pluck('bidang_keahlian')
            ->sort();

        // Get available years for filter
        $tahunLulus = TopikSkripsi::where('prodi', $mahasiswa->prodi)
            ->where('status', 'aktif')
            ->distinct()
            ->orderBy('tahun_lulus', 'desc')
            ->pluck('tahun_lulus');

        return view('mahasiswa.topik-skripsi.index', compact(
            'topikSkripsi',
            'mahasiswa',
            'bidangKeahlian',
            'tahunLulus'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Check if mahasiswa can access this topik skripsi (same prodi and active)
        if ($topikSkripsi->prodi !== $mahasiswa->prodi || $topikSkripsi->status !== 'aktif') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        $topikSkripsi->load('dosen.user');

        return view('mahasiswa.topik-skripsi.show', compact('topikSkripsi', 'mahasiswa'));
    }
    /**
     * Download PDF file for mahasiswa
     */
    public function download(TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Check if mahasiswa can access this topik skripsi (same prodi and active)
        if ($topikSkripsi->prodi !== $mahasiswa->prodi || $topikSkripsi->status !== 'aktif') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        if (!Storage::disk('public')->exists($topikSkripsi->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
        return response()->download(storage_path('app/public/' . $topikSkripsi->file_path), $topikSkripsi->file_name);
    }
    
    /**
     * View PDF file in browser
     */
    public function view(TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Check if mahasiswa can access this topik skripsi (same prodi and active)
        if ($topikSkripsi->prodi !== $mahasiswa->prodi || $topikSkripsi->status !== 'aktif') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        if (!Storage::disk('public')->exists($topikSkripsi->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $topikSkripsi->file_path);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $topikSkripsi->file_name . '"'
        ]);
    }
}
