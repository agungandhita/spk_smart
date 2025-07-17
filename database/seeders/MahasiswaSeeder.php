<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaData = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@student.univ.ac.id',
                'nim' => '2021001001',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'tanggal_lahir' => '2003-05-15',
                'tempat_lahir' => 'Jakarta',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567890',
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik',
                'ipk' => 3.75,
                'semester' => 5,
                'tahun_masuk' => 2021,
                'status' => 'aktif',
                'pembimbing_akademik' => 'Dr. Budi Santoso, M.Kom'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@student.univ.ac.id',
                'nim' => '2021001002',
                'alamat' => 'Jl. Sudirman No. 456, Bandung',
                'tanggal_lahir' => '2003-08-22',
                'tempat_lahir' => 'Bandung',
                'jenis_kelamin' => 'P',
                'no_telepon' => '081234567891',
                'prodi' => 'Sistem Informasi',
                'fakultas' => 'Fakultas Teknik',
                'ipk' => 3.85,
                'semester' => 5,
                'tahun_masuk' => 2021,
                'status' => 'aktif',
                'pembimbing_akademik' => 'Dr. Ani Wijaya, M.T'
            ],
            [
                'name' => 'Muhammad Fajar',
                'email' => 'muhammad.fajar@student.univ.ac.id',
                'nim' => '2022001003',
                'alamat' => 'Jl. Gatot Subroto No. 789, Surabaya',
                'tanggal_lahir' => '2004-02-10',
                'tempat_lahir' => 'Surabaya',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567892',
                'prodi' => 'Teknik Elektro',
                'fakultas' => 'Fakultas Teknik',
                'ipk' => 3.60,
                'semester' => 3,
                'tahun_masuk' => 2022,
                'status' => 'aktif',
                'pembimbing_akademik' => 'Prof. Dr. Ir. Slamet Riyadi, M.T'
            ],
            [
                'name' => 'Dewi Sartika',
                'email' => 'dewi.sartika@student.univ.ac.id',
                'nim' => '2020001004',
                'alamat' => 'Jl. Diponegoro No. 321, Yogyakarta',
                'tanggal_lahir' => '2002-11-05',
                'tempat_lahir' => 'Yogyakarta',
                'jenis_kelamin' => 'P',
                'no_telepon' => '081234567893',
                'prodi' => 'Manajemen',
                'fakultas' => 'Fakultas Ekonomi',
                'ipk' => 3.90,
                'semester' => 7,
                'tahun_masuk' => 2020,
                'status' => 'aktif',
                'pembimbing_akademik' => 'Dr. Eko Prasetyo, M.M'
            ],
            [
                'name' => 'Randi Pratama',
                'email' => 'randi.pratama@student.univ.ac.id',
                'nim' => '2019001005',
                'alamat' => 'Jl. Ahmad Yani No. 654, Medan',
                'tanggal_lahir' => '2001-07-18',
                'tempat_lahir' => 'Medan',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567894',
                'prodi' => 'Akuntansi',
                'fakultas' => 'Fakultas Ekonomi',
                'ipk' => 3.55,
                'semester' => 8,
                'tahun_masuk' => 2019,
                'status' => 'lulus',
                'pembimbing_akademik' => 'Dr. Sri Mulyani, M.Ak'
            ]
        ];

        foreach ($mahasiswaData as $data) {
            // Create user first
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now()
            ]);

            // Create mahasiswa record
            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $data['nim'],
                'alamat' => $data['alamat'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'tempat_lahir' => $data['tempat_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'no_telepon' => $data['no_telepon'],
                'prodi' => $data['prodi'],
                'fakultas' => $data['fakultas'],
                'ipk' => $data['ipk'],
                'semester' => $data['semester'],
                'tahun_masuk' => $data['tahun_masuk'],
                'status' => $data['status'],
                'pembimbing_akademik' => $data['pembimbing_akademik']
            ]);
        }
    }
}