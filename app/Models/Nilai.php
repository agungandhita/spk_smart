<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'ips',
        'ipk',
        'sks_semester',
        'sks_kumulatif',
        'file_khs',
        'keterangan'
    ];

    protected $casts = [
        'ips' => 'decimal:2',
        'ipk' => 'decimal:2',
        'semester' => 'integer',
        'sks_semester' => 'integer',
        'sks_kumulatif' => 'integer'
    ];

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Accessor untuk URL file KHS
     */
    public function getFileKhsUrlAttribute()
    {
        if ($this->file_khs) {
            return Storage::url($this->file_khs);
        }
        return null;
    }

    /**
     * Scope untuk filter berdasarkan mahasiswa
     */
    public function scopeByMahasiswa($query, $mahasiswaId)
    {
        return $query->where('mahasiswa_id', $mahasiswaId);
    }

    /**
     * Scope untuk filter berdasarkan semester
     */
    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Method untuk mendapatkan daftar semester yang tersedia
     */
    public static function getSemesterList()
    {
        return [
            1 => 'Semester 1',
            2 => 'Semester 2',
            3 => 'Semester 3',
            4 => 'Semester 4',
            5 => 'Semester 5',
            6 => 'Semester 6',
            7 => 'Semester 7',
            8 => 'Semester 8'
        ];
    }
}