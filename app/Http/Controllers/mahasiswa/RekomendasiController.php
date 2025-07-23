<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\RekomendasiJudul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    /**
     * Display list of thesis title recommendations for student
     */
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        // Get recommendations received from supervisor
        $rekomendasiDiterima = $mahasiswa->rekomendasiJudul()
            ->where('status', 'dikirim')
            ->with('dosen.user')
            ->orderBy('tanggal_dikirim', 'desc')
            ->get();

        // Get accepted recommendations
        $rekomendasiDisetujui = $mahasiswa->rekomendasiDiterima()
            ->with('dosen.user')
            ->orderBy('tanggal_respon', 'desc')
            ->get();

        // Get rejected recommendations
        $rekomendasiDitolak = $mahasiswa->rekomendasiJudul()
            ->where('status', 'ditolak')
            ->with('dosen.user')
            ->orderBy('tanggal_respon', 'desc')
            ->get();

        // Get all recommendations history
        $semuaRekomendasi = $mahasiswa->rekomendasiJudul()
            ->whereIn('status', ['dikirim', 'diterima', 'ditolak'])
            ->with('dosen.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Filter by status if requested
        $statusFilter = request('status');
        if ($statusFilter) {
            $rekomendasi = $mahasiswa->rekomendasiJudul()
                ->where('status', $statusFilter)
                ->with('dosen.user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $rekomendasi = $mahasiswa->rekomendasiJudul()
                ->whereIn('status', ['dikirim', 'diterima', 'ditolak'])
                ->with('dosen.user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        // Calculate statistics
        $totalRekomendasi = $mahasiswa->rekomendasiJudul()
            ->whereIn('status', ['dikirim', 'diterima', 'ditolak'])
            ->count();
        
        $menungguRespon = $mahasiswa->rekomendasiJudul()
            ->where('status', 'dikirim')
            ->count();
        
        $diterima = $mahasiswa->rekomendasiJudul()
            ->where('status', 'diterima')
            ->count();
        
        $ditolak = $mahasiswa->rekomendasiJudul()
            ->where('status', 'ditolak')
            ->count();

        return view('mahasiswa.rekomendasi.index', compact(
            'mahasiswa',
            'rekomendasi',
            'totalRekomendasi',
            'menungguRespon',
            'diterima',
            'ditolak'
        ));
    }

    /**
     * Show specific recommendation details
     */
    public function show($id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        $rekomendasi = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', $id)
            ->whereIn('status', ['dikirim', 'diterima', 'ditolak'])
            ->with('dosen.user')
            ->firstOrFail();

        return view('mahasiswa.rekomendasi.show', compact('rekomendasi', 'mahasiswa'));
    }

    /**
     * Accept recommendation
     */
    public function accept(Request $request, $id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        $rekomendasi = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', $id)
            ->where('status', 'dikirim')
            ->firstOrFail();

        try {
            DB::beginTransaction();

            // Accept the recommendation
            $rekomendasi->terima($request->catatan);

            DB::commit();

            return redirect()->route('mahasiswa.rekomendasi.index')
                ->with('success', 'Rekomendasi judul skripsi berhasil diterima.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menerima rekomendasi. Silakan coba lagi.');
        }
    }

    /**
     * Reject recommendation
     */
    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        $request->validate([
            'catatan' => 'required|string|max:1000',
        ]);

        $rekomendasi = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', $id)
            ->where('status', 'dikirim')
            ->firstOrFail();

        try {
            DB::beginTransaction();

            // Reject the recommendation
            $rekomendasi->tolak($request->catatan);

            DB::commit();

            return redirect()->route('mahasiswa.rekomendasi.index')
                ->with('success', 'Rekomendasi judul skripsi berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menolak rekomendasi. Silakan coba lagi.');
        }
    }

    /**
     * Show form to respond to recommendation
     */
    public function respond($id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        $rekomendasi = RekomendasiJudul::where('mahasiswa_id', $mahasiswa->id)
            ->where('id', $id)
            ->where('status', 'dikirim')
            ->with('dosen.user')
            ->firstOrFail();

        return view('mahasiswa.rekomendasi.respond', compact('rekomendasi', 'mahasiswa'));
    }
}