<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembimbingController extends Controller
{
    /**
     * Display list of supervisor applications
     */
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        // Get pending applications
        $pengajuanPending = $dosen->pengajuanPending()
            ->with('mahasiswa.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get approved applications (current students)
        $pengajuanDisetujui = $dosen->mahasiswaBimbingan()
            ->with('mahasiswa.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get rejected applications
        $pengajuanDitolak = $dosen->pengajuanPembimbing()
            ->where('status', 'ditolak')
            ->with('mahasiswa.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all applications history
        $semuaPengajuan = $dosen->pengajuanPembimbing()
            ->with('mahasiswa.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.pembimbing.index', compact(
            'dosen',
            'pengajuanPending',
            'pengajuanDisetujui',
            'pengajuanDitolak',
            'semuaPengajuan'
        ));
    }

    /**
     * Show specific application details
     */
    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
            ->where('id', $id)
            ->with('mahasiswa.user')
            ->firstOrFail();

        return view('dosen.pembimbing.show', compact('pengajuan', 'dosen'));
    }

    /**
     * Approve supervisor application
     */
    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $request->validate([
            'catatan_dosen' => 'nullable|string|max:1000',
        ]);

        $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        try {
            DB::beginTransaction();

            // Approve the application
            $pengajuan->approve($request->catatan_dosen);

            DB::commit();

            return redirect()->route('dosen.pembimbing.index')
                ->with('success', 'Pengajuan pembimbing akademik berhasil disetujui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menyetujui pengajuan. Silakan coba lagi.');
        }
    }

    /**
     * Reject supervisor application
     */
    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $request->validate([
            'catatan_dosen' => 'required|string|max:1000',
        ]);

        $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        try {
            DB::beginTransaction();

            // Reject the application
            $pengajuan->reject($request->catatan_dosen);

            DB::commit();

            return redirect()->route('dosen.pembimbing.index')
                ->with('success', 'Pengajuan pembimbing akademik berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menolak pengajuan. Silakan coba lagi.');
        }
    }

    /**
     * Show form to respond to application
     */
    public function respond($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->with('mahasiswa.user')
            ->firstOrFail();

        return view('dosen.pembimbing.respond', compact('pengajuan', 'dosen'));
    }
}