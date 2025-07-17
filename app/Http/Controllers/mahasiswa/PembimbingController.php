<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\PengajuanPembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembimbingController extends Controller
{
    /**
     * Display list of available supervisors and application status
     */
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        // Get current application status
        $pengajuanAktif = $mahasiswa->pengajuanAktif;
        $pengajuanDisetujui = $mahasiswa->pengajuanDisetujui;
        
        // Get available supervisors from same faculty and program
        $dosenTersedia = Dosen::where('fakultas', $mahasiswa->fakultas)
            ->where('prodi', $mahasiswa->prodi)
            ->where('status', 'aktif')
            ->with('user')
            ->get();

        // Get application history
        $riwayatPengajuan = $mahasiswa->pengajuanPembimbing()
            ->with('dosen.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.pembimbing.index', compact(
            'mahasiswa',
            'pengajuanAktif',
            'pengajuanDisetujui',
            'dosenTersedia',
            'riwayatPengajuan'
        ));
    }

    /**
     * Show form to apply for supervisor
     */
    public function create()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        // Check if student already has pending or approved application
        $pengajuanAktif = $mahasiswa->pengajuanAktif;
        $pengajuanDisetujui = $mahasiswa->pengajuanDisetujui;
        
        if ($pengajuanAktif || $pengajuanDisetujui) {
            return redirect()->route('mahasiswa.pembimbing.index')
                ->with('error', 'Anda sudah memiliki pengajuan pembimbing akademik yang aktif atau disetujui.');
        }

        // Get available supervisors
        $dosenTersedia = Dosen::where('fakultas', $mahasiswa->fakultas)
            ->where('prodi', $mahasiswa->prodi)
            ->where('status', 'aktif')
            ->with('user')
            ->get();

        return view('mahasiswa.pembimbing.create', compact('mahasiswa', 'dosenTersedia'));
    }

    /**
     * Store supervisor application
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        // Check if student already has pending or approved application
        $pengajuanAktif = $mahasiswa->pengajuanAktif;
        $pengajuanDisetujui = $mahasiswa->pengajuanDisetujui;
        
        if ($pengajuanAktif || $pengajuanDisetujui) {
            return redirect()->route('mahasiswa.pembimbing.index')
                ->with('error', 'Anda sudah memiliki pengajuan pembimbing akademik yang aktif atau disetujui.');
        }

        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'minat_skripsi' => 'required|string|max:255',
            'deskripsi_minat' => 'required|string|max:1000',
            'alasan_memilih' => 'required|string|max:1000',
        ]);

        // Verify the selected supervisor is from same faculty and program
        $dosen = Dosen::findOrFail($request->dosen_id);
        if ($dosen->fakultas !== $mahasiswa->fakultas || $dosen->prodi !== $mahasiswa->prodi) {
            return back()->withErrors(['dosen_id' => 'Dosen yang dipilih tidak sesuai dengan fakultas dan program studi Anda.']);
        }

        try {
            DB::beginTransaction();

            PengajuanPembimbing::create([
                'mahasiswa_id' => $mahasiswa->id,
                'dosen_id' => $request->dosen_id,
                'minat_skripsi' => $request->minat_skripsi,
                'deskripsi_minat' => $request->deskripsi_minat,
                'alasan_memilih' => $request->alasan_memilih,
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
            ]);

            DB::commit();

            return redirect()->route('mahasiswa.pembimbing.index')
                ->with('success', 'Pengajuan pembimbing akademik berhasil dikirim. Menunggu persetujuan dari dosen.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat mengirim pengajuan. Silakan coba lagi.');
        }
    }

    /**
     * Show specific application details
     */
    public function show($id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        $pengajuan = PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', $id)
            ->with('dosen.user')
            ->firstOrFail();

        return view('mahasiswa.pembimbing.show', compact('pengajuan', 'mahasiswa'));
    }

    /**
     * Cancel pending application
     */
    public function cancel($id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        $pengajuan = PengajuanPembimbing::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $pengajuan->delete();

        return redirect()->route('mahasiswa.pembimbing.index')
            ->with('success', 'Pengajuan pembimbing akademik berhasil dibatalkan.');
    }
}