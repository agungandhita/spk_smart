<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'nim',
        'alamat',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'no_telepon',
        'prodi',
        'fakultas',
        'ipk',
        'semester',
        'tahun_masuk',
        'status',
        'pembimbing_akademik',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'ipk' => 'decimal:2',
        'tahun_masuk' => 'integer',
        'semester' => 'integer'
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
     * Get active pengajuan pembimbing
     */
    public function pengajuanAktif()
    {
        return $this->hasOne(PengajuanPembimbing::class)->where('status', 'pending');
    }

    /**
     * Get approved pengajuan pembimbing
     */
    public function pengajuanDisetujui()
    {
        return $this->hasOne(PengajuanPembimbing::class)->where('status', 'disetujui');
    }

    /**
     * Relasi ke RekomendasiJudul
     */
    public function rekomendasiJudul()
    {
        return $this->hasMany(RekomendasiJudul::class);
    }

    /**
     * Get rekomendasi judul yang diterima
     */
    public function rekomendasiDiterima()
    {
        return $this->hasMany(RekomendasiJudul::class)->where('status', 'diterima');
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
     * Relasi ke Nilai (KHS)
     */
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    /**
     * Method untuk mendapatkan IPK terbaru
     */
    public function getIpkTerbaruAttribute()
    {
        $nilaiTerbaru = $this->nilai()->orderBy('semester', 'desc')->first();
        return $nilaiTerbaru ? $nilaiTerbaru->ipk : $this->ipk;
    }
}