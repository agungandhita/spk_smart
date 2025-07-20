<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'user_id',
        'nidn',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'no_telepon',
        'alamat',
        'prodi',
        'fakultas',
        'jabatan_akademik',
        'pendidikan_terakhir',
        'bidang_keahlian',
        'status',
        'tahun_bergabung',
        'foto',
        'riwayat_pendidikan',
        'pengalaman_mengajar'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_bergabung' => 'integer'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke PengajuanPembimbing
     */
    public function pengajuanPembimbing()
    {
        return $this->hasMany(PengajuanPembimbing::class);
    }

    /**
     * Get pending pengajuan pembimbing
     */
    public function pengajuanPending()
    {
        return $this->hasMany(PengajuanPembimbing::class)->where('status', 'pending');
    }

    /**
     * Get mahasiswa bimbingan (approved)
     */
    public function mahasiswaBimbingan()
    {
        return $this->hasMany(PengajuanPembimbing::class)->where('status', 'disetujui');
    }

    /**
     * Relasi ke RekomendasiJudul
     */
    public function rekomendasiJudul()
    {
        return $this->hasMany(RekomendasiJudul::class);
    }

    /**
     * Get rekomendasi judul by status
     */
    public function rekomendasiByStatus($status)
    {
        return $this->hasMany(RekomendasiJudul::class)->where('status', $status);
    }

    /**
     * Accessor untuk nama lengkap
     */
    public function getNamaLengkapAttribute()
    {
        return $this->user->name;
    }

    /**
     * Accessor untuk email
     */
    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    /**
     * Relasi ke TopikSkripsi
     */
    public function topikSkripsi()
    {
        return $this->hasMany(TopikSkripsi::class);
    }

    /**
     * Get topik skripsi aktif
     */
    public function topikSkripsiAktif()
    {
        return $this->hasMany(TopikSkripsi::class)->where('status', 'aktif');
    }
}