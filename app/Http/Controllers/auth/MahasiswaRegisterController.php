<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mahasiswa;

class MahasiswaRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register.mahasiswa');
    }

    public function register(Request $request)
    {
        // Validasi untuk registrasi mahasiswa
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|unique:mahasiswa,nim|max:20',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telepon' => 'nullable|string|max:15',
            'prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'tahun_masuk' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        DB::beginTransaction();
        try {
            // Buat user dengan role mahasiswa
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
            ]);

            // Buat detail mahasiswa
            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telepon' => $request->no_telepon,
                'prodi' => $request->prodi,
                'fakultas' => $request->fakultas,
                'tahun_masuk' => $request->tahun_masuk,
            ]);

            DB::commit();

            return redirect()->route('login')
                ->with('success', 'Registrasi mahasiswa berhasil! Selamat datang.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])
                ->withInput();
        }
    }
}
