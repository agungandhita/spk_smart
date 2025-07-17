<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Dosen;

class DosenRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register.dosen');
    }

    public function register(Request $request)
    {
        // Validasi untuk registrasi dosen
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nidn' => 'required|string|unique:dosen,nidn|max:20',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telepon' => 'nullable|string|max:15',
            'prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'tahun_bergabung' => 'required|integer|min:1980|max:' . date('Y'),
            'bidang_keahlian' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Buat user dengan role dosen
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dosen',
            ]);

            // Buat detail dosen
            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $request->nidn,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telepon' => $request->no_telepon,
                'prodi' => $request->prodi,
                'fakultas' => $request->fakultas,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'tahun_bergabung' => $request->tahun_bergabung,
                'bidang_keahlian' => $request->bidang_keahlian,
            ]);

            DB::commit();

            // Auto login setelah register
            auth()->login($user);

            return redirect()->route('dosen.dashboard')
                ->with('success', 'Registrasi dosen berhasil! Selamat datang.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])
                ->withInput();
        }
    }
}