# ANALISIS DAN KOREKSI IMPLEMENTASI METODE SMART
## Sistem Pendukung Keputusan Penentuan Judul Skripsi

### MASALAH YANG DITEMUKAN DALAM IMPLEMENTASI SAAT INI:

#### 1. **TIDAK ADA NORMALISASI BOBOT KRITERIA**
**Masalah:** Bobot kriteria langsung digunakan tanpa normalisasi
```php
// Implementasi saat ini (SALAH)
$criteria = [
    'ipk' => 0.30,           // 30%
    'semester' => 0.20,      // 20%
    'minat_match' => 0.25,   // 25%
    'dosen_expertise' => 0.15, // 15%
    'difficulty' => 0.10     // 10%
];
// Total = 1.00 (sudah benar, tapi tidak ada proses normalisasi eksplisit)
```

**Seharusnya:** Menggunakan rumus normalisasi bobot
```
Wj = wj / Σwj
```

#### 2. **TIDAK ADA NORMALISASI NILAI ALTERNATIF YANG BENAR**
**Masalah:** Nilai langsung dikonversi ke skala 0-100 tanpa normalisasi SMART
```php
// Implementasi saat ini (SALAH)
$ipk_score = ($mahasiswa->nilai->last()->ipk ?? 0) * 25; // 0-4 menjadi 0-100
$semester_score = min(($mahasiswa->semester ?? 1) * 12.5, 100);
```

**Seharusnya:** Menggunakan rumus normalisasi SMART
- Untuk kriteria benefit: `Uij = (Xij - Xmin) / (Xmax - Xmin)`
- Untuk kriteria cost: `Uij = (Xmax - Xij) / (Xmax - Xmin)`

#### 3. **TIDAK ADA IDENTIFIKASI JENIS KRITERIA (BENEFIT/COST)**
**Masalah:** Semua kriteria diperlakukan sama
**Seharusnya:** 
- IPK = BENEFIT (semakin tinggi semakin baik)
- Semester = BENEFIT (semakin tinggi semakin baik)
- Minat Match = BENEFIT (semakin cocok semakin baik)
- Dosen Expertise = BENEFIT (semakin ahli semakin baik)
- Difficulty = COST (semakin mudah semakin baik)

#### 4. **TIDAK ADA PERHITUNGAN MIN-MAX UNTUK NORMALISASI**
**Masalah:** Tidak ada pencarian nilai minimum dan maksimum dari semua alternatif

### IMPLEMENTASI YANG BENAR:

#### 1. **Struktur Data Kriteria yang Benar**
```php
$criteria = [
    'ipk' => ['weight' => 30, 'type' => 'benefit'],
    'semester' => ['weight' => 20, 'type' => 'benefit'],
    'minat_match' => ['weight' => 25, 'type' => 'benefit'],
    'dosen_expertise' => ['weight' => 15, 'type' => 'benefit'],
    'difficulty' => ['weight' => 10, 'type' => 'cost']
];
```

#### 2. **Normalisasi Bobot**
```php
$total_weight = array_sum(array_column($criteria, 'weight'));
foreach ($criteria as $key => $criterion) {
    $criteria[$key]['normalized_weight'] = $criterion['weight'] / $total_weight;
}
```

#### 3. **Normalisasi Nilai Alternatif**
```php
// Untuk setiap kriteria, cari min dan max dari semua alternatif
$values = [];
foreach ($alternatives as $alternative) {
    $values['ipk'][] = $alternative['ipk'];
    $values['semester'][] = $alternative['semester'];
    // dst...
}

// Normalisasi
foreach ($alternatives as &$alternative) {
    foreach ($criteria as $criterion_key => $criterion) {
        $xij = $alternative[$criterion_key];
        $xmin = min($values[$criterion_key]);
        $xmax = max($values[$criterion_key]);
        
        if ($criterion['type'] === 'benefit') {
            $uij = ($xij - $xmin) / ($xmax - $xmin);
        } else { // cost
            $uij = ($xmax - $xij) / ($xmax - $xmin);
        }
        
        $alternative['normalized'][$criterion_key] = $uij;
    }
}
```

#### 4. **Perhitungan Nilai Akhir SMART**
```php
$smart_score = 0;
foreach ($criteria as $criterion_key => $criterion) {
    $smart_score += $criterion['normalized_weight'] * $alternative['normalized'][$criterion_key];
}
```

### REKOMENDASI PERBAIKAN:

1. **Refactor method `calculateSmartScore`** untuk mengikuti rumus SMART yang benar
2. **Tambahkan method untuk normalisasi bobot** 
3. **Tambahkan method untuk normalisasi nilai alternatif**
4. **Implementasikan pencarian min-max** dari semua alternatif
5. **Definisikan jenis kriteria** (benefit/cost) dengan jelas
6. **Simpan detail perhitungan** dalam field `kriteria_smart` untuk transparansi

### DAMPAK PERBAIKAN:

1. **Akurasi perhitungan** akan meningkat sesuai standar metode SMART
2. **Konsistensi hasil** akan terjamin karena normalisasi yang benar
3. **Transparansi proses** akan meningkat dengan detail perhitungan
4. **Validitas ilmiah** sistem akan terjamin

### LANGKAH IMPLEMENTASI:

1. Backup implementasi saat ini
2. Refactor method `calculateSmartScore`
3. Tambahkan method helper untuk normalisasi
4. Update controller untuk menggunakan method baru
5. Testing dengan data sample
6. Update dokumentasi sistem