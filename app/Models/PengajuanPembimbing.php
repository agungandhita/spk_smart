<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PengajuanPembimbing extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pembimbing';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'minat_skripsi',
        'deskripsi_minat',
        'alasan_memilih',
        'status',
        'catatan_dosen',
        'tanggal_pengajuan',
        'tanggal_respon',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_respon' => 'datetime',
    ];

    /**
     * Relationship with Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Relationship with Dosen
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    /**
     * Scope for pending applications
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved applications
     */
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope for rejected applications
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'disetujui' => 'bg-success',
            'ditolak' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if application can be responded
     */
    public function canBeResponded()
    {
        return $this->status === 'pending';
    }

    /**
     * Approve the application
     */
    public function approve($catatan = null)
    {
        $this->update([
            'status' => 'disetujui',
            'catatan_dosen' => $catatan,
            'tanggal_respon' => now(),
        ]);

        // Update mahasiswa pembimbing akademik
        $this->mahasiswa->update([
            'pembimbing_akademik' => $this->dosen->user->name
        ]);
    }

    /**
     * Reject the application
     */
    public function reject($catatan = null)
    {
        $this->update([
            'status' => 'ditolak',
            'catatan_dosen' => $catatan,
            'tanggal_respon' => now(),
        ]);
    }
}