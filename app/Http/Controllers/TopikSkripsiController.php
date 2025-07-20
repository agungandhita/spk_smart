<?php

namespace App\Http\Controllers;

use App\Models\TopikSkripsi;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopikSkripsiController extends Controller
{
    /**
     * Display a listing of the resource for dosen.
     */
    public function index()
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $topikSkripsi = TopikSkripsi::where('dosen_id', $dosen->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dosen.topik-skripsi.index', compact('topikSkripsi', 'dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        return view('dosen.topik-skripsi.create', compact('dosen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bidang_keahlian' => 'nullable|string|max:255',
            'nama_mahasiswa' => 'required|string|max:255',
            'nim_mahasiswa' => 'required|string|max:20',
            'tahun_lulus' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'kata_kunci' => 'nullable|string',
            'file_pdf' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        try {
            // Upload file
            $file = $request->file('file_pdf');
            $fileName = time() . '_' . Str::slug($request->judul) . '.pdf';
            $filePath = $file->storeAs('topik-skripsi', $fileName, 'public');

            // Create record
            TopikSkripsi::create([
                'dosen_id' => $dosen->id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'prodi' => $dosen->prodi,
                'fakultas' => $dosen->fakultas,
                'bidang_keahlian' => $request->bidang_keahlian ?? $dosen->bidang_keahlian,
                'nama_mahasiswa' => $request->nama_mahasiswa,
                'nim_mahasiswa' => $request->nim_mahasiswa,
                'tahun_lulus' => $request->tahun_lulus,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'kata_kunci' => $request->kata_kunci,
            ]);

            return redirect()->route('dosen.topik-skripsi.index')
                ->with('success', 'Topik skripsi berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengunggah file: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        // Check if this topik skripsi belongs to the authenticated dosen
        if ($topikSkripsi->dosen_id !== $dosen->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        return view('dosen.topik-skripsi.show', compact('topikSkripsi', 'dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        // Check if this topik skripsi belongs to the authenticated dosen
        if ($topikSkripsi->dosen_id !== $dosen->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        return view('dosen.topik-skripsi.edit', compact('topikSkripsi', 'dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        // Check if this topik skripsi belongs to the authenticated dosen
        if ($topikSkripsi->dosen_id !== $dosen->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bidang_keahlian' => 'nullable|string|max:255',
            'nama_mahasiswa' => 'required|string|max:255',
            'nim_mahasiswa' => 'required|string|max:20',
            'tahun_lulus' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'kata_kunci' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
            'status' => 'required|in:aktif,non_aktif',
        ]);

        try {
            $updateData = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'bidang_keahlian' => $request->bidang_keahlian ?? $dosen->bidang_keahlian,
                'nama_mahasiswa' => $request->nama_mahasiswa,
                'nim_mahasiswa' => $request->nim_mahasiswa,
                'tahun_lulus' => $request->tahun_lulus,
                'kata_kunci' => $request->kata_kunci,
                'status' => $request->status,
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('file_pdf')) {
                // Delete old file
                if ($topikSkripsi->file_path && Storage::disk('public')->exists($topikSkripsi->file_path)) {
                    Storage::disk('public')->delete($topikSkripsi->file_path);
                }

                // Upload new file
                $file = $request->file('file_pdf');
                $fileName = time() . '_' . Str::slug($request->judul) . '.pdf';
                $filePath = $file->storeAs('topik-skripsi', $fileName, 'public');

                $updateData['file_path'] = $filePath;
                $updateData['file_name'] = $file->getClientOriginalName();
                $updateData['file_size'] = $file->getSize();
            }

            $topikSkripsi->update($updateData);

            return redirect()->route('dosen.topik-skripsi.index')
                ->with('success', 'Topik skripsi berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        // Check if this topik skripsi belongs to the authenticated dosen
        if ($topikSkripsi->dosen_id !== $dosen->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        try {
            $topikSkripsi->delete(); // File akan otomatis terhapus karena boot method di model
            
            return redirect()->route('dosen.topik-skripsi.index')
                ->with('success', 'Topik skripsi berhasil dihapus.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Download PDF file
     */
    public function download(TopikSkripsi $topikSkripsi)
    {
        $user = Auth::user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        
        // Check if this topik skripsi belongs to the authenticated dosen
        if ($topikSkripsi->dosen_id !== $dosen->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        if (!Storage::disk('public')->exists($topikSkripsi->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download(storage_path('app/public/' . $topikSkripsi->file_path), $topikSkripsi->file_name);
    }
}