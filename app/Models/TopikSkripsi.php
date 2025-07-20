<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TopikSkripsi extends Model
{
    use HasFactory;

    protected $table = 'topik_skripsi';

    protected $fillable = [
        'dosen_id',
        'judul',
        'deskripsi',
        'prodi',
        'fakultas',
        'bidang_keahlian',
        'nama_mahasiswa',
        'nim_mahasiswa',
        'tahun_lulus',
        'file_path',
        'file_name',
        'file_size',
        'status',
        'kata_kunci'
    ];

    protected $casts = [
        'tahun_lulus' => 'integer',
        'file_size' => 'integer'
    ];

    /**
     * Relasi ke Dosen
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    /**
     * Accessor untuk mendapatkan URL file
     */
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Accessor untuk format ukuran file
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope untuk filter berdasarkan prodi
     */
    public function scopeByProdi($query, $prodi)
    {
        return $query->where('prodi', $prodi);
    }

    /**
     * Scope untuk filter berdasarkan bidang keahlian
     */
    public function scopeByBidangKeahlian($query, $bidangKeahlian)
    {
        return $query->where('bidang_keahlian', $bidangKeahlian);
    }

    /**
     * Scope untuk status aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('deskripsi', 'like', "%{$search}%")
              ->orWhere('kata_kunci', 'like', "%{$search}%")
              ->orWhere('nama_mahasiswa', 'like', "%{$search}%")
              ->orWhere('nim_mahasiswa', 'like', "%{$search}%");
        });
    }

    /**
     * Method untuk menghapus file dari storage
     */
    public function deleteFile()
    {
        if ($this->file_path && Storage::exists($this->file_path)) {
            Storage::delete($this->file_path);
        }
    }

    /**
     * Boot method untuk auto delete file saat model dihapus
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($topikSkripsi) {
            $topikSkripsi->deleteFile();
        });
    }
}