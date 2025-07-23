<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiJudul extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi_judul';

    protected $fillable = [
        'dosen_id',
        'mahasiswa_id',
        'judul_skripsi',
        'deskripsi_judul',
        'tipe_skripsi',
        'bidang_keahlian',
        'skor_smart',
        'kriteria_smart',
        'tingkat_kesulitan',
        'ipk_minimum',
        'semester_minimum',
        'prasyarat',
        'status',
        'catatan_mahasiswa',
        'tanggal_dikirim',
        'tanggal_respon'
    ];

    protected $casts = [
        'kriteria_smart' => 'array',
        'skor_smart' => 'decimal:2',
        'ipk_minimum' => 'decimal:2',
        'tanggal_dikirim' => 'datetime',
        'tanggal_respon' => 'datetime'
    ];

    /**
     * Relationship with Dosen
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }

    /**
     * Relationship with Mahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'draft' => 'bg-secondary',
            'dikirim' => 'bg-warning',
            'diterima' => 'bg-success',
            'ditolak' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'dikirim' => 'Dikirim',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Draft'
        };
    }

    /**
     * Get difficulty badge class
     */
    public function getDifficultyBadgeAttribute(): string
    {
        return match($this->tingkat_kesulitan) {
            'mudah' => 'bg-success',
            'sedang' => 'bg-warning',
            'sulit' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get difficulty text
     */
    public function getDifficultyTextAttribute(): string
    {
        return match($this->tingkat_kesulitan) {
            'mudah' => 'Mudah',
            'sedang' => 'Sedang',
            'sulit' => 'Sulit',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Calculate SMART score based on criteria (DEPRECATED - Use SmartCalculationService)
     * Kept for backward compatibility
     */
    public static function calculateSmartScore($mahasiswa, $pengajuan, $judul_data): float
    {
        $smartService = new \App\Services\SmartCalculationService();
        return $smartService->calculateSingleAlternative($mahasiswa, $pengajuan, $judul_data);
    }

    /**
     * Calculate SMART score with detailed breakdown using proper SMART methodology
     */
    public static function calculateSmartScoreDetailed($mahasiswa, $pengajuan, $alternatives): array
    {
        $smartService = new \App\Services\SmartCalculationService();
        return $smartService->calculateMultipleAlternatives($mahasiswa, $pengajuan, $alternatives);
    }

    /**
     * Get SMART criteria information
     */
    public static function getSmartCriteria(): array
    {
        $smartService = new \App\Services\SmartCalculationService();
        return $smartService->getNormalizedCriteria();
    }

    /**
     * Calculate string similarity using Levenshtein distance
     */
    private static function calculateStringsimilarity($str1, $str2): float
    {
        $len1 = strlen($str1);
        $len2 = strlen($str2);
        
        if ($len1 == 0 || $len2 == 0) {
            return 0;
        }
        
        $distance = levenshtein($str1, $str2);
        $maxLen = max($len1, $len2);
        
        return 1 - ($distance / $maxLen);
    }

    /**
     * Send recommendation to student
     */
    public function kirim(): bool
    {
        $this->update([
            'status' => 'dikirim',
            'tanggal_dikirim' => now()
        ]);
        
        return true;
    }

    /**
     * Accept recommendation
     */
    public function terima($catatan = null): bool
    {
        $this->update([
            'status' => 'diterima',
            'catatan_mahasiswa' => $catatan,
            'tanggal_respon' => now()
        ]);
        
        return true;
    }

    /**
     * Reject recommendation
     */
    public function tolak($catatan = null): bool
    {
        $this->update([
            'status' => 'ditolak',
            'catatan_mahasiswa' => $catatan,
            'tanggal_respon' => now()
        ]);
        
        return true;
    }

    /**
     * Scope for recommendations by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for recommendations by dosen
     */
    public function scopeByDosen($query, $dosen_id)
    {
        return $query->where('dosen_id', $dosen_id);
    }

    /**
     * Scope for recommendations by mahasiswa
     */
    public function scopeByMahasiswa($query, $mahasiswa_id)
    {
        return $query->where('mahasiswa_id', $mahasiswa_id);
    }

}