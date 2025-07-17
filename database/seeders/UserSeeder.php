<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample mahasiswa
        $mahasiswaUser = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad.rizki@student.univ.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $mahasiswaUser->id,
            'nim' => '2021001001',
            'alamat' => 'Jl. Merdeka No. 123, Surabaya',
            'tanggal_lahir' => '2003-05-15',
            'tempat_lahir' => 'Surabaya',
            'jenis_kelamin' => 'L',
            'no_telepon' => '081234567890',
            'prodi' => 'Teknik Informatika',
            'fakultas' => 'Fakultas Teknik',
            'ipk' => 3.75,
            'semester' => 6,
            'tahun_masuk' => 2021,
            'status' => 'aktif',
            'pembimbing_akademik' => 'Dr. Budi Santoso, M.Kom',
        ]);

        // Create sample dosen
        $dosenUser = User::create([
            'name' => 'Dr. Siti Nurhaliza, M.Kom',
            'email' => 'siti.nurhaliza@univ.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $dosenUser->id,
            'nidn' => '0015087801',
            'alamat' => 'Jl. Profesor No. 456, Surabaya',
            'tanggal_lahir' => '1978-08-20',
            'tempat_lahir' => 'Jakarta',
            'jenis_kelamin' => 'P',
            'no_telepon' => '081987654321',
            'prodi' => 'Teknik Informatika',
            'fakultas' => 'Fakultas Teknik',
            'jabatan_akademik' => 'Lektor',
            'pendidikan_terakhir' => 'S3 Ilmu Komputer',
            'bidang_keahlian' => 'Machine Learning, Data Mining',
            'status' => 'aktif',
            'tahun_bergabung' => 2005,
            'riwayat_pendidikan' => 'S1 Teknik Informatika (2000), S2 Ilmu Komputer (2002), S3 Ilmu Komputer (2005)',
            'pengalaman_mengajar' => 'Algoritma dan Pemrograman, Struktur Data, Machine Learning',
        ]);

        // Create another sample mahasiswa
        $mahasiswaUser2 = User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari.dewi@student.univ.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $mahasiswaUser2->id,
            'nim' => '2022002002',
            'alamat' => 'Jl. Diponegoro No. 789, Malang',
            'tanggal_lahir' => '2004-03-10',
            'tempat_lahir' => 'Malang',
            'jenis_kelamin' => 'P',
            'no_telepon' => '082345678901',
            'prodi' => 'Sistem Informasi',
            'fakultas' => 'Fakultas Teknik',
            'ipk' => 3.85,
            'semester' => 4,
            'tahun_masuk' => 2022,
            'status' => 'aktif',
            'pembimbing_akademik' => 'Dr. Siti Nurhaliza, M.Kom',
        ]);
    }
}