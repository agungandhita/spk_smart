<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa) {
            Alert::error('Error', 'Data mahasiswa tidak ditemukan!');
            return redirect()->back();
        }

        $nilai = Nilai::where('mahasiswa_id', $mahasiswa->id)
                     ->orderBy('semester', 'asc')
                     ->get();

        $semesterList = Nilai::getSemesterList();
        
        return view('mahasiswa.nilai.index', compact('nilai', 'semesterList', 'mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa) {
            Alert::error('Error', 'Data mahasiswa tidak ditemukan!');
            return redirect()->back();
        }

        $semesterList = Nilai::getSemesterList();
        $semesterTerpakai = Nilai::where('mahasiswa_id', $mahasiswa->id)
                                ->pluck('semester')
                                ->toArray();
        
        return view('mahasiswa.nilai.create', compact('semesterList', 'semesterTerpakai', 'mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa) {
            Alert::error('Error', 'Data mahasiswa tidak ditemukan!');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'semester' => 'required|integer|min:1|max:8|unique:nilai,semester,NULL,id,mahasiswa_id,' . $mahasiswa->id,
            'ips' => 'required|numeric|min:0|max:4',
            'ipk' => 'required|numeric|min:0|max:4',
            'sks_semester' => 'required|integer|min:1|max:30',
            'sks_kumulatif' => 'required|integer|min:1',
            'file_khs' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
            'keterangan' => 'nullable|string|max:1000'
        ], [
            'semester.unique' => 'Data nilai untuk semester ini sudah ada!',
            'file_khs.mimes' => 'File KHS harus berformat PDF!',
            'file_khs.max' => 'Ukuran file KHS maksimal 5MB!'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Terjadi kesalahan validasi!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['semester', 'ips', 'ipk', 'sks_semester', 'sks_kumulatif', 'keterangan']);
        $data['mahasiswa_id'] = $mahasiswa->id;

        // Handle file upload
        if ($request->hasFile('file_khs')) {
            $file = $request->file('file_khs');
            $fileName = 'khs_' . $mahasiswa->nim . '_semester_' . $request->semester . '_' . time() . '.pdf';
            $filePath = $file->storeAs('khs', $fileName, 'public');
            $data['file_khs'] = $filePath;
        }

        Nilai::create($data);

        // Update IPK di tabel mahasiswa dengan IPK terbaru
        $mahasiswa->update(['ipk' => $request->ipk]);

        Alert::success('Berhasil', 'Data nilai berhasil ditambahkan!');
        return redirect()->route('mahasiswa.nilai.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa || $nilai->mahasiswa_id !== $mahasiswa->id) {
            Alert::error('Error', 'Data tidak ditemukan atau tidak memiliki akses!');
            return redirect()->route('mahasiswa.nilai.index');
        }

        return view('mahasiswa.nilai.show', compact('nilai', 'mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa || $nilai->mahasiswa_id !== $mahasiswa->id) {
            Alert::error('Error', 'Data tidak ditemukan atau tidak memiliki akses!');
            return redirect()->route('mahasiswa.nilai.index');
        }

        $semesterList = Nilai::getSemesterList();
        
        return view('mahasiswa.nilai.edit', compact('nilai', 'semesterList', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa || $nilai->mahasiswa_id !== $mahasiswa->id) {
            Alert::error('Error', 'Data tidak ditemukan atau tidak memiliki akses!');
            return redirect()->route('mahasiswa.nilai.index');
        }

        $validator = Validator::make($request->all(), [
            'semester' => 'required|integer|min:1|max:8|unique:nilai,semester,' . $nilai->id . ',id,mahasiswa_id,' . $mahasiswa->id,
            'ips' => 'required|numeric|min:0|max:4',
            'ipk' => 'required|numeric|min:0|max:4',
            'sks_semester' => 'required|integer|min:1|max:30',
            'sks_kumulatif' => 'required|integer|min:1',
            'file_khs' => 'nullable|file|mimes:pdf|max:5120',
            'keterangan' => 'nullable|string|max:1000'
        ], [
            'semester.unique' => 'Data nilai untuk semester ini sudah ada!',
            'file_khs.mimes' => 'File KHS harus berformat PDF!',
            'file_khs.max' => 'Ukuran file KHS maksimal 5MB!'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Terjadi kesalahan validasi!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['semester', 'ips', 'ipk', 'sks_semester', 'sks_kumulatif', 'keterangan']);

        // Handle file upload
        if ($request->hasFile('file_khs')) {
            // Delete old file if exists
            if ($nilai->file_khs && Storage::disk('public')->exists($nilai->file_khs)) {
                Storage::disk('public')->delete($nilai->file_khs);
            }

            $file = $request->file('file_khs');
            $fileName = 'khs_' . $mahasiswa->nim . '_semester_' . $request->semester . '_' . time() . '.pdf';
            $filePath = $file->storeAs('khs', $fileName, 'public');
            $data['file_khs'] = $filePath;
        }

        $nilai->update($data);

        // Update IPK di tabel mahasiswa jika ini semester terbaru
        $semesterTertinggi = Nilai::where('mahasiswa_id', $mahasiswa->id)
                                 ->orderBy('semester', 'desc')
                                 ->first();
        
        if ($semesterTertinggi && $semesterTertinggi->id === $nilai->id) {
            $mahasiswa->update(['ipk' => $request->ipk]);
        }

        Alert::success('Berhasil', 'Data nilai berhasil diperbarui!');
        return redirect()->route('mahasiswa.nilai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa || $nilai->mahasiswa_id !== $mahasiswa->id) {
            Alert::error('Error', 'Data tidak ditemukan atau tidak memiliki akses!');
            return redirect()->route('mahasiswa.nilai.index');
        }

        // Delete file if exists
        if ($nilai->file_khs && Storage::disk('public')->exists($nilai->file_khs)) {
            Storage::disk('public')->delete($nilai->file_khs);
        }

        $nilai->delete();

        // Update IPK mahasiswa dengan semester tertinggi yang tersisa
        $semesterTertinggi = Nilai::where('mahasiswa_id', $mahasiswa->id)
                                 ->orderBy('semester', 'desc')
                                 ->first();
        
        if ($semesterTertinggi) {
            $mahasiswa->update(['ipk' => $semesterTertinggi->ipk]);
        } else {
            $mahasiswa->update(['ipk' => 0.00]);
        }

        Alert::success('Berhasil', 'Data nilai berhasil dihapus!');
        return redirect()->route('mahasiswa.nilai.index');
    }

    /**
     * Download file KHS
     */
    public function downloadKhs(Nilai $nilai)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa || $nilai->mahasiswa_id !== $mahasiswa->id) {
            Alert::error('Error', 'Data tidak ditemukan atau tidak memiliki akses!');
            return redirect()->route('mahasiswa.nilai.index');
        }

        if (!$nilai->file_khs || !Storage::disk('public')->exists($nilai->file_khs)) {
            Alert::error('Error', 'File KHS tidak ditemukan!');
            return redirect()->back();
        }

        return response()->download(storage_path('app/public/' . $nilai->file_khs), 'KHS_Semester_' . $nilai->semester . '.pdf');
    }
}