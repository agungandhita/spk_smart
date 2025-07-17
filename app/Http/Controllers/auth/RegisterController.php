<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.Register.register');
    }

    public function register(Request $request)
    {
        // Validasi dasar
        $baseRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:mahasiswa,dosen',
        ];

        // Validasi tambahan berdasarkan role
        if ($request->role === 'mahasiswa') {
            $additionalRules = [
                'nim' => 'required|string|unique:mahasiswa,nim|max:20',
                'alamat' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'tempat_lahir' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'prodi' => 'required|string|max:255',
                'fakultas' => 'required|string|max:255',
                'tahun_masuk' => 'required|integer|min:2000|max:' . date('Y'),
            ];
        } else {
            $additionalRules = [
                'nidn' => 'required|string|unique:dosen,nidn|max:20',
                'alamat' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'tempat_lahir' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'prodi' => 'required|string|max:255',
                'fakultas' => 'required|string|max:255',
                'pendidikan_terakhir' => 'required|string|max:255',
                'tahun_bergabung' => 'required|integer|min:1980|max:' . date('Y'),
            ];
        }

        $request->validate(array_merge($baseRules, $additionalRules));

        DB::beginTransaction();
        try {
            // Buat user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Buat detail berdasarkan role
            if ($request->role === 'mahasiswa') {
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
            } else {
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
            }

            DB::commit();

            // Auto login setelah register
            auth()->login($user);

            // Redirect berdasarkan role
            if ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            } elseif ($user->role === 'dosen') {
                return redirect()->route('dosen.dashboard');
            }

            return redirect()->route('login');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }
}