<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\PengajuanPembimbing;
use Illuminate\Support\Collection;

class SmartCalculationService
{
    /**
     * Kriteria SMART dengan bobot dan jenis
     */
    private array $criteria = [
        'ipk' => [
            'weight' => 30,
            'type' => 'benefit', // semakin tinggi semakin baik
            'name' => 'IPK'
        ],
        'semester' => [
            'weight' => 20,
            'type' => 'benefit', // semakin tinggi semakin baik
            'name' => 'Semester'
        ],
        'minat_match' => [
            'weight' => 25,
            'type' => 'benefit', // semakin cocok semakin baik
            'name' => 'Kesesuaian Minat'
        ],
        'dosen_expertise' => [
            'weight' => 15,
            'type' => 'benefit', // semakin ahli semakin baik
            'name' => 'Keahlian Dosen'
        ],
        'difficulty' => [
            'weight' => 10,
            'type' => 'cost', // semakin mudah semakin baik
            'name' => 'Tingkat Kesulitan'
        ]
    ];

    /**
     * Hitung skor SMART untuk multiple alternatif
     */
    public function calculateMultipleAlternatives(Mahasiswa $mahasiswa, PengajuanPembimbing $pengajuan, array $alternatives): array
    {
        // Step 1: Normalisasi bobot kriteria
        $normalizedCriteria = $this->normalizeWeights($this->criteria);

        // Step 2: Ekstrak nilai untuk setiap kriteria dari semua alternatif
        $criteriaValues = $this->extractCriteriaValues($mahasiswa, $pengajuan, $alternatives);

        // Step 3: Normalisasi nilai alternatif
        $normalizedAlternatives = $this->normalizeAlternativeValues($criteriaValues, $normalizedCriteria);

        // Step 4: Hitung nilai akhir SMART
        $results = [];
        foreach ($alternatives as $index => $alternative) {
            $smartScore = $this->calculateFinalScore($normalizedAlternatives[$index], $normalizedCriteria);
            
            $results[] = [
                'alternative' => $alternative,
                'smart_score' => round($smartScore * 100, 2), // Convert to 0-100 scale
                'criteria_details' => $normalizedAlternatives[$index],
                'normalized_criteria' => $normalizedCriteria
            ];
        }

        // Sort by SMART score descending
        usort($results, function($a, $b) {
            return $b['smart_score'] <=> $a['smart_score'];
        });

        return $results;
    }

    /**
     * Hitung skor SMART untuk satu alternatif (untuk kompatibilitas)
     */
    public function calculateSingleAlternative(Mahasiswa $mahasiswa, PengajuanPembimbing $pengajuan, array $alternative): float
    {
        $results = $this->calculateMultipleAlternatives($mahasiswa, $pengajuan, [$alternative]);
        return $results[0]['smart_score'];
    }

    /**
     * Step 1: Normalisasi Bobot Kriteria
     * Rumus: Wj = wj / Σwj
     */
    private function normalizeWeights(array $criteria): array
    {
        $totalWeight = array_sum(array_column($criteria, 'weight'));
        
        foreach ($criteria as $key => $criterion) {
            $criteria[$key]['normalized_weight'] = $criterion['weight'] / $totalWeight;
        }
        
        return $criteria;
    }

    /**
     * Step 2: Ekstrak nilai kriteria dari semua alternatif
     */
    private function extractCriteriaValues(Mahasiswa $mahasiswa, PengajuanPembimbing $pengajuan, array $alternatives): array
    {
        $criteriaValues = [];
        
        foreach ($alternatives as $index => $alternative) {
            // IPK (0-4) - Nilai tetap untuk mahasiswa ini
            $ipk = $mahasiswa->nilai->last()->ipk ?? 0;
            $criteriaValues[$index]['ipk'] = $ipk;
            
            // Semester (1-8+) - Nilai tetap untuk mahasiswa ini  
            $semester = $mahasiswa->semester ?? 1;
            $criteriaValues[$index]['semester'] = $semester;
            
            // Kesesuaian minat (0-1) - Bervariasi berdasarkan alternatif
            $minatMatch = $this->calculateStringSimilarity(
                strtolower($pengajuan->minat_skripsi),
                strtolower($alternative['bidang_keahlian'])
            );
            $criteriaValues[$index]['minat_match'] = $minatMatch;
            
            // Keahlian dosen (0-1) - Bervariasi berdasarkan alternatif
            $dosenExpertise = $this->calculateStringSimilarity(
                strtolower($pengajuan->dosen->bidang_keahlian ?? ''),
                strtolower($alternative['bidang_keahlian'])
            );
            $criteriaValues[$index]['dosen_expertise'] = $dosenExpertise;
            
            // Tingkat kesulitan (1=mudah, 2=sedang, 3=sulit) - Bervariasi berdasarkan alternatif
            $difficulty = match($alternative['tingkat_kesulitan']) {
                'mudah' => 1,
                'sedang' => 2,
                'sulit' => 3,
                default => 2
            };
            $criteriaValues[$index]['difficulty'] = $difficulty;
        }
        
        return $criteriaValues;
    }

    /**
     * Step 3: Normalisasi Nilai Alternatif
     * Benefit: Uij = (Xij - Xmin) / (Xmax - Xmin)
     * Cost: Uij = (Xmax - Xij) / (Xmax - Xmin)
     */
    private function normalizeAlternativeValues(array $criteriaValues, array $criteria): array
    {
        $normalizedValues = [];
        
        // Cari min dan max untuk setiap kriteria
        $minMax = [];
        foreach (array_keys($criteria) as $criterionKey) {
            $values = array_column($criteriaValues, $criterionKey);
            $minMax[$criterionKey] = [
                'min' => min($values),
                'max' => max($values)
            ];
        }
        
        // Normalisasi setiap alternatif
        foreach ($criteriaValues as $index => $values) {
            foreach ($criteria as $criterionKey => $criterion) {
                $xij = $values[$criterionKey];
                $xmin = $minMax[$criterionKey]['min'];
                $xmax = $minMax[$criterionKey]['max'];
                
                // Hindari pembagian dengan nol
                if ($xmax == $xmin) {
                    // Jika semua nilai sama, berikan nilai berdasarkan posisi relatif terhadap skala ideal
                    if ($criterion['type'] === 'benefit') {
                        // Untuk benefit: nilai tinggi = baik
                        $uij = $this->getRelativeScore($xij, $criterionKey, 'benefit');
                    } else {
                        // Untuk cost: nilai rendah = baik  
                        $uij = $this->getRelativeScore($xij, $criterionKey, 'cost');
                    }
                } else {
                    if ($criterion['type'] === 'benefit') {
                        $uij = ($xij - $xmin) / ($xmax - $xmin);
                    } else { // cost
                        $uij = ($xmax - $xij) / ($xmax - $xmin);
                    }
                }
                
                $normalizedValues[$index][$criterionKey] = [
                    'raw_value' => $xij,
                    'normalized_value' => $uij,
                    'min' => $xmin,
                    'max' => $xmax,
                    'type' => $criterion['type']
                ];
            }
        }
        
        return $normalizedValues;
    }

    /**
     * Step 4: Perhitungan Nilai Akhir SMART
     * Rumus: Si = Σ(Wj × Uij)
     */
    private function calculateFinalScore(array $normalizedAlternative, array $criteria): float
    {
        $smartScore = 0;
        
        foreach ($criteria as $criterionKey => $criterion) {
            $wj = $criterion['normalized_weight'];
            $uij = $normalizedAlternative[$criterionKey]['normalized_value'];
            
            $smartScore += $wj * $uij;
        }
        
        return $smartScore;
    }

    /**
     * Hitung similarity string menggunakan Levenshtein distance
     */
    private function calculateStringSimilarity(string $str1, string $str2): float
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
     * Get criteria information
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * Get normalized criteria with weights
     */
    public function getNormalizedCriteria(): array
    {
        return $this->normalizeWeights($this->criteria);
    }

    /**
     * Hitung skor relatif untuk kriteria dengan nilai yang sama
     */
    private function getRelativeScore(float $value, string $criterionKey, string $type): float
    {
        // Definisikan skala ideal untuk setiap kriteria
        $idealScales = [
            'ipk' => ['min' => 0, 'max' => 4.0, 'ideal' => 4.0],
            'semester' => ['min' => 1, 'max' => 8, 'ideal' => 8],
            'minat_match' => ['min' => 0, 'max' => 1, 'ideal' => 1],
            'dosen_expertise' => ['min' => 0, 'max' => 1, 'ideal' => 1],
            'difficulty' => ['min' => 1, 'max' => 3, 'ideal' => 1] // untuk cost, ideal adalah nilai minimum
        ];

        if (!isset($idealScales[$criterionKey])) {
            return 0.5; // Default nilai tengah jika tidak ada skala
        }

        $scale = $idealScales[$criterionKey];
        
        if ($type === 'benefit') {
            // Untuk benefit: semakin mendekati nilai maksimal semakin baik
            $normalizedValue = ($value - $scale['min']) / ($scale['max'] - $scale['min']);
            // Pastikan nilai minimum tidak 0, berikan nilai minimal 0.1 untuk fairness
            return max(0.1, $normalizedValue);
        } else {
            // Untuk cost: semakin mendekati nilai minimal semakin baik
            $normalizedValue = ($scale['max'] - $value) / ($scale['max'] - $scale['min']);
            // Pastikan nilai minimum tidak 0, berikan nilai minimal 0.1 untuk fairness
            return max(0.1, $normalizedValue);
        }
    }
}