<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenData = [
            [
                'name' => 'Dr. Budi Santoso, M.Kom',
                'email' => 'budi.santoso@univ.ac.id',
                'nidn' => '0015057801',
                'tanggal_lahir' => '1978-05-15',
                'tempat_lahir' => 'Jakarta',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567801',
                'alamat' => 'Jl. Prof. Dr. Soepomo No. 123, Jakarta Selatan',
                'prodi' => 'Teknik Informatika',
                'fakultas' => 'Fakultas Teknik',
                'jabatan_akademik' => 'Lektor Kepala',
                'pendidikan_terakhir' => 'S3 Ilmu Komputer',
                'bidang_keahlian' => 'Artificial Intelligence, Machine Learning',
                'status' => 'aktif',
                'tahun_bergabung' => 2005,
                'riwayat_pendidikan' => 'S1 Teknik Informatika (1999), S2 Ilmu Komputer (2002), S3 Ilmu Komputer (2008)',
                'pengalaman_mengajar' => 'Algoritma dan Pemrograman, Struktur Data, Kecerdasan Buatan, Machine Learning'
            ],
            [
                'name' => 'Dr. Ani Wijaya, M.T',
                'email' => 'ani.wijaya@univ.ac.id',
                'nidn' => '0020068002',
                'tanggal_lahir' => '1980-06-20',
                'tempat_lahir' => 'Bandung',
                'jenis_kelamin' => 'P',
                'no_telepon' => '081234567802',
                'alamat' => 'Jl. Ir. H. Juanda No. 456, Bandung',
                'prodi' => 'Sistem Informasi',
                'fakultas' => 'Fakultas Teknik',
                'jabatan_akademik' => 'Lektor',
                'pendidikan_terakhir' => 'S3 Teknik Informatika',
                'bidang_keahlian' => 'Database Systems, Information Systems',
                'status' => 'aktif',
                'tahun_bergabung' => 2008,
                'riwayat_pendidikan' => 'S1 Sistem Informasi (2001), S2 Teknik Informatika (2004), S3 Teknik Informatika (2010)',
                'pengalaman_mengajar' => 'Basis Data, Sistem Informasi Manajemen, Analisis dan Perancangan Sistem'
            ],
            [
                'name' => 'Prof. Dr. Ir. Slamet Riyadi, M.T',
                'email' => 'slamet.riyadi@univ.ac.id',
                'nidn' => '0010047501',
                'tanggal_lahir' => '1975-04-10',
                'tempat_lahir' => 'Surabaya',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567803',
                'alamat' => 'Jl. Raya Darmo No. 789, Surabaya',
                'prodi' => 'Teknik Elektro',
                'fakultas' => 'Fakultas Teknik',
                'jabatan_akademik' => 'Guru Besar',
                'pendidikan_terakhir' => 'S3 Teknik Elektro',
                'bidang_keahlian' => 'Power Systems, Renewable Energy',
                'status' => 'aktif',
                'tahun_bergabung' => 2000,
                'riwayat_pendidikan' => 'S1 Teknik Elektro (1997), S2 Teknik Elektro (1999), S3 Teknik Elektro (2003)',
                'pengalaman_mengajar' => 'Sistem Tenaga Listrik, Energi Terbarukan, Elektronika Daya'
            ],
            [
                'name' => 'Dr. Eko Prasetyo, M.M',
                'email' => 'eko.prasetyo@univ.ac.id',
                'nidn' => '0025077701',
                'tanggal_lahir' => '1977-07-25',
                'tempat_lahir' => 'Yogyakarta',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567804',
                'alamat' => 'Jl. Malioboro No. 321, Yogyakarta',
                'prodi' => 'Manajemen',
                'fakultas' => 'Fakultas Ekonomi',
                'jabatan_akademik' => 'Lektor',
                'pendidikan_terakhir' => 'S3 Manajemen',
                'bidang_keahlian' => 'Strategic Management, Human Resource Management',
                'status' => 'aktif',
                'tahun_bergabung' => 2006,
                'riwayat_pendidikan' => 'S1 Manajemen (1999), S2 Manajemen (2002), S3 Manajemen (2009)',
                'pengalaman_mengajar' => 'Manajemen Strategis, Manajemen SDM, Perilaku Organisasi'
            ],
            [
                'name' => 'Dr. Sri Mulyani, M.Ak',
                'email' => 'sri.mulyani@univ.ac.id',
                'nidn' => '0030088201',
                'tanggal_lahir' => '1982-08-30',
                'tempat_lahir' => 'Medan',
                'jenis_kelamin' => 'P',
                'no_telepon' => '081234567805',
                'alamat' => 'Jl. Sisingamangaraja No. 654, Medan',
                'prodi' => 'Akuntansi',
                'fakultas' => 'Fakultas Ekonomi',
                'jabatan_akademik' => 'Asisten Ahli',
                'pendidikan_terakhir' => 'S3 Akuntansi',
                'bidang_keahlian' => 'Financial Accounting, Auditing',
                'status' => 'aktif',
                'tahun_bergabung' => 2012,
                'riwayat_pendidikan' => 'S1 Akuntansi (2004), S2 Akuntansi (2007), S3 Akuntansi (2015)',
                'pengalaman_mengajar' => 'Akuntansi Keuangan, Auditing, Perpajakan'
            ],
            [
                'name' => 'Dr. Ir. Bambang Sutrisno, M.T',
                'email' => 'bambang.sutrisno@univ.ac.id',
                'nidn' => '0012056801',
                'tanggal_lahir' => '1968-05-12',
                'tempat_lahir' => 'Semarang',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567806',
                'alamat' => 'Jl. Pandanaran No. 987, Semarang',
                'prodi' => 'Teknik Sipil',
                'fakultas' => 'Fakultas Teknik',
                'jabatan_akademik' => 'Lektor Kepala',
                'pendidikan_terakhir' => 'S3 Teknik Sipil',
                'bidang_keahlian' => 'Structural Engineering, Construction Management',
                'status' => 'aktif',
                'tahun_bergabung' => 1995,
                'riwayat_pendidikan' => 'S1 Teknik Sipil (1990), S2 Teknik Sipil (1993), S3 Teknik Sipil (1998)',
                'pengalaman_mengajar' => 'Struktur Beton, Manajemen Konstruksi, Mekanika Tanah'
            ]
        ];

        foreach ($dosenData as $data) {
            // Create user first
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'email_verified_at' => now()
            ]);

            // Create dosen record
            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $data['nidn'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'tempat_lahir' => $data['tempat_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'no_telepon' => $data['no_telepon'],
                'alamat' => $data['alamat'],
                'prodi' => $data['prodi'],
                'fakultas' => $data['fakultas'],
                'jabatan_akademik' => $data['jabatan_akademik'],
                'pendidikan_terakhir' => $data['pendidikan_terakhir'],
                'bidang_keahlian' => $data['bidang_keahlian'],
                'status' => $data['status'],
                'tahun_bergabung' => $data['tahun_bergabung'],
                'riwayat_pendidikan' => $data['riwayat_pendidikan'],
                'pengalaman_mengajar' => $data['pengalaman_mengajar']
            ]);
        }
    }
}