<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Dosen;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        return view('dosen.profile.show', compact('user', 'dosen'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        return view('dosen.profile.edit', compact('user', 'dosen'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            
            // Dosen specific fields
            'nidn' => ['required', 'string', 'max:20', Rule::unique('dosen')->ignore($dosen->id)],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'no_telepon' => ['nullable', 'string', 'max:15'],
            'alamat' => ['required', 'string'],
            'fakultas' => ['required', 'string', 'max:100'],
            'prodi' => ['required', 'string', 'max:100'],
            'pendidikan_terakhir' => ['required', 'string', 'max:50'],
            'tahun_bergabung' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'bidang_keahlian' => ['nullable', 'string', 'max:200'],
        ]);

        // Update user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update dosen data
        $dosen->update([
            'nidn' => $request->nidn,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'tahun_bergabung' => $request->tahun_bergabung,
            'bidang_keahlian' => $request->bidang_keahlian,
        ]);

        return redirect()->route('dosen.profile.show')
            ->with('success', 'Profile berhasil diperbarui!');
    }
}