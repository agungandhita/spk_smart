# PANDUAN SISTEM SMART YANG TELAH DIPERBAIKI
## Sistem Pendukung Keputusan Penentuan Judul Skripsi

### PERUBAHAN UTAMA

#### 1. **IMPLEMENTASI RUMUS SMART YANG BENAR**

**Sebelum (SALAH):**
- Tidak ada normalisasi bobot yang eksplisit
- Nilai langsung dikonversi ke skala 0-100
- Tidak ada identifikasi jenis kriteria (benefit/cost)
- Tidak ada pencarian min-max untuk normalisasi

**Sesudah (BENAR):**
- ✅ Normalisasi bobot: `Wj = wj / Σwj`
- ✅ Normalisasi nilai alternatif:
  - Benefit: `Uij = (Xij - Xmin) / (Xmax - Xmin)`
  - Cost: `Uij = (Xmax - Xij) / (Xmax - Xmin)`
- ✅ Perhitungan final: `Si = Σ(Wj × Uij)`
- ✅ Identifikasi jenis kriteria yang jelas

#### 2. **STRUKTUR KRITERIA YANG DIPERBAIKI**

```php
// Format baru dengan jenis kriteria yang jelas
$criteria = [
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
```

#### 3. **SERVICE CLASS BARU**

**File:** `app/Services/SmartCalculationService.php`

**Fitur:**
- Perhitungan SMART yang sesuai standar ilmiah
- Normalisasi bobot dan nilai yang benar
- Support untuk multiple alternatif
- Detail breakdown perhitungan
- Transparansi proses

#### 4. **TAMPILAN YANG DIPERBAIKI**

**Fitur Baru di View:**
- Detail metodologi yang digunakan
- Breakdown per kriteria dengan:
  - Nilai asli
  - Nilai ternormalisasi
  - Jenis kriteria (benefit/cost)
  - Kontribusi ke skor final
- Timestamp perhitungan
- Fallback untuk data lama

### CARA MENGGUNAKAN SISTEM BARU

#### 1. **Untuk Dosen**

**Membuat Rekomendasi Baru:**
1. Masuk ke menu "Rekomendasi Judul Skripsi"
2. Klik "Tambah Rekomendasi"
3. Isi form dengan lengkap
4. Sistem akan otomatis menghitung skor SMART yang akurat
5. Detail perhitungan akan tersimpan dan dapat dilihat

**Menggunakan Auto-Generate:**
1. Pilih mahasiswa bimbingan
2. Klik "Generate Rekomendasi Otomatis"
3. Sistem akan menganalisis dengan metode SMART yang benar
4. Hasil akan menampilkan top 5 rekomendasi dengan detail perhitungan

#### 2. **Untuk Mahasiswa**

**Melihat Rekomendasi:**
1. Rekomendasi akan menampilkan skor SMART yang akurat
2. Detail perhitungan dapat dilihat untuk transparansi
3. Penjelasan metodologi tersedia

### VALIDASI HASIL

#### **Contoh Perhitungan Manual:**

**Data Mahasiswa:**
- IPK: 3.5
- Semester: 6
- Minat: "sistem informasi"
- Keahlian Dosen: "sistem informasi"
- Tingkat Kesulitan: "sedang"

**Step 1: Normalisasi Bobot**
```
Total bobot = 30 + 20 + 25 + 15 + 10 = 100
W_ipk = 30/100 = 0.30
W_semester = 20/100 = 0.20
W_minat = 25/100 = 0.25
W_dosen = 15/100 = 0.15
W_difficulty = 10/100 = 0.10
```

**Step 2: Normalisasi Nilai (contoh dengan min-max)**
```
Asumsi range:
- IPK: min=2.0, max=4.0
- Semester: min=1, max=8
- Minat match: min=0, max=1
- Dosen expertise: min=0, max=1
- Difficulty: min=1, max=3

Normalisasi (benefit):
U_ipk = (3.5-2.0)/(4.0-2.0) = 1.5/2.0 = 0.75
U_semester = (6-1)/(8-1) = 5/7 = 0.714
U_minat = (1.0-0)/(1.0-0) = 1.0
U_dosen = (1.0-0)/(1.0-0) = 1.0

Normalisasi (cost):
U_difficulty = (3-2)/(3-1) = 1/2 = 0.5
```

**Step 3: Perhitungan Final**
```
S = (0.30×0.75) + (0.20×0.714) + (0.25×1.0) + (0.15×1.0) + (0.10×0.5)
S = 0.225 + 0.143 + 0.25 + 0.15 + 0.05
S = 0.818

Skor final = 0.818 × 100 = 81.8
```

### KEUNGGULAN SISTEM BARU

1. **Akurasi Tinggi:** Menggunakan rumus SMART standar
2. **Transparansi:** Detail perhitungan dapat dilihat
3. **Konsistensi:** Hasil yang dapat diandalkan
4. **Validitas Ilmiah:** Sesuai dengan metodologi penelitian
5. **Fleksibilitas:** Mudah untuk dimodifikasi bobot kriteria
6. **Dokumentasi:** Setiap perhitungan tersimpan dengan timestamp

### MIGRASI DATA LAMA

**Backward Compatibility:**
- Data rekomendasi lama tetap dapat ditampilkan
- View memiliki fallback untuk format lama
- Method lama masih tersedia untuk kompatibilitas

**Rekomendasi:**
- Rekomendasi baru akan menggunakan sistem yang diperbaiki
- Data lama dapat di-recalculate jika diperlukan
- Sistem dapat berjalan dengan kedua format

### TROUBLESHOOTING

**Jika Skor Tampak Berbeda:**
1. Periksa apakah menggunakan method baru atau lama
2. Pastikan data mahasiswa lengkap (IPK, semester)
3. Verifikasi data dosen (keahlian)
4. Cek log perhitungan di detail rekomendasi

**Jika Error:**
1. Pastikan service SmartCalculationService ter-load
2. Cek data mahasiswa memiliki nilai IPK
3. Verifikasi pengajuan pembimbing sudah disetujui

### PENGEMBANGAN SELANJUTNYA

**Fitur yang Dapat Ditambahkan:**
1. Konfigurasi bobot kriteria via admin panel
2. Export hasil perhitungan ke PDF
3. Grafik visualisasi perbandingan alternatif
4. History perubahan bobot kriteria
5. Analisis sensitivitas
6. Integrasi dengan sistem akademik untuk data real-time

### REFERENSI

- Edwards, W. (1977). How to Use Multi-Attribute Utility Measurement
- Goodwin, P., & Wright, G. (2004). Decision Analysis for Management Judgment
- Triantaphyllou, E. (2000). Multi-Criteria Decision Making Methods