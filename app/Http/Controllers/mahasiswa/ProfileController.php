<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the student's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        // Get academic statistics
        $totalSemester = $mahasiswa->nilai()->count();
        $ipkTerbaru = $mahasiswa->ipk_terbaru;
        $totalSks = $mahasiswa->nilai()->sum('sks_kumulatif');
        $semesterAktif = $mahasiswa->semester;
        
        // Get recent academic records
        $nilaiTerbaru = $mahasiswa->nilai()
            ->orderBy('semester', 'desc')
            ->limit(3)
            ->get();

        return view('mahasiswa.profile.show', compact(
            'mahasiswa', 
            'user', 
            'totalSemester', 
            'ipkTerbaru', 
            'totalSks', 
            'semesterAktif',
            'nilaiTerbaru'
        ));
    }

    /**
     * Show the form for editing the student's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        return view('mahasiswa.profile.edit', compact('mahasiswa', 'user'));
    }

    /**
     * Update the student's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'alamat' => 'nullable|string|max:500',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date|before:today',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_telepon' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update password if provided
        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            
            $fotoPath = $request->file('foto')->store('profile_photos', 'public');
            $mahasiswa->foto = $fotoPath;
        }

        // Update mahasiswa data
        $mahasiswa->update([
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
            'foto' => $mahasiswa->foto,
        ]);

        return redirect()->route('mahasiswa.profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrl()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        
        if ($mahasiswa && $mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
            return Storage::disk('public')->url($mahasiswa->foto);
        }
        
        return asset('img/default-avatar.png');
    }
}