<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\RekomendasiJudul;
use App\Models\PengajuanPembimbing;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    /**
     * Display list of thesis title recommendations
     */
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        // Get mahasiswa bimbingan yang disetujui
        $mahasiswaBimbingan = $dosen->mahasiswaBimbingan()
            ->with(['mahasiswa.user', 'mahasiswa.nilai'])
            ->get();

        // Get rekomendasi yang sudah dibuat
        $rekomendasiDraft = $dosen->rekomendasiByStatus('draft')
            ->with('mahasiswa.user')
            ->orderBy('created_at', 'desc')
            ->get();

        $rekomendasiDikirim = $dosen->rekomendasiByStatus('dikirim')
            ->with('mahasiswa.user')
            ->orderBy('tanggal_dikirim', 'desc')
            ->get();

        $rekomendasiDiterima = $dosen->rekomendasiByStatus('diterima')
            ->with('mahasiswa.user')
            ->orderBy('tanggal_respon', 'desc')
            ->get();

        return view('dosen.rekomendasi.index', compact(
            'dosen',
            'mahasiswaBimbingan',
            'rekomendasiDraft',
            'rekomendasiDikirim',
            'rekomendasiDiterima'
        ));
    }

    /**
     * Show form to create recommendation for specific student
     */
    public function create($mahasiswa_id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        // Verify mahasiswa is under this dosen's supervision
        $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('status', 'disetujui')
            ->with(['mahasiswa.user', 'mahasiswa.nilai'])
            ->firstOrFail();

        $mahasiswa = $pengajuan->mahasiswa;

        // Get existing recommendations for this student
        $existingRecommendations = RekomendasiJudul::where('dosen_id', $dosen->id)
            ->where('mahasiswa_id', $mahasiswa_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.rekomendasi.create', compact(
            'dosen',
            'mahasiswa',
            'pengajuan',
            'existingRecommendations'
        ));
    }

    /**
     * Store new recommendation
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'judul_skripsi' => 'required|string|max:255',
            'deskripsi_judul' => 'required|string',
            'tipe_skripsi' => 'required|in:penelitian,pengembangan,studi_kasus,eksperimen',
            'bidang_keahlian' => 'required|string|max:255',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
            'ipk_minimum' => 'required|numeric|min:0|max:4',
            'semester_minimum' => 'required|integer|min:1|max:14',
            'prasyarat' => 'nullable|string'
        ]);

        // Verify mahasiswa is under supervision
        $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
            ->where('mahasiswa_id', $request->mahasiswa_id)
            ->where('status', 'disetujui')
            ->with('mahasiswa.nilai')
            ->firstOrFail();

        try {
            DB::beginTransaction();

            // Calculate SMART score
            $judul_data = [
                'bidang_keahlian' => $request->bidang_keahlian,
                'tingkat_kesulitan' => $request->tingkat_kesulitan
            ];

            $smartScore = RekomendasiJudul::calculateSmartScore(
                $pengajuan->mahasiswa,
                $pengajuan,
                $judul_data
            );

            // Prepare criteria details for storage
            $kriteria_smart = [
                'ipk_score' => ($pengajuan->mahasiswa->nilai->last()->ipk ?? 0) * 25,
                'semester_score' => min(($pengajuan->mahasiswa->semester ?? 1) * 12.5, 100),
                'minat_match' => $this->calculateStringsSimilarity(
                    strtolower($pengajuan->minat_skripsi),
                    strtolower($request->bidang_keahlian)
                ) * 100,
                'dosen_expertise' => $this->calculateStringsSimilarity(
                    strtolower($dosen->bidang_keahlian ?? ''),
                    strtolower($request->bidang_keahlian)
                ) * 100,
                'difficulty_score' => match($request->tingkat_kesulitan) {
                    'mudah' => 100,
                    'sedang' => 75,
                    'sulit' => 50,
                    default => 75
                },
                'total_score' => $smartScore
            ];

            // Create recommendation
            $rekomendasi = RekomendasiJudul::create([
                'dosen_id' => $dosen->id,
                'mahasiswa_id' => $request->mahasiswa_id,
                'judul_skripsi' => $request->judul_skripsi,
                'deskripsi_judul' => $request->deskripsi_judul,
                'tipe_skripsi' => $request->tipe_skripsi,
                'bidang_keahlian' => $request->bidang_keahlian,
                'skor_smart' => $smartScore,
                'kriteria_smart' => $kriteria_smart,
                'tingkat_kesulitan' => $request->tingkat_kesulitan,
                'ipk_minimum' => $request->ipk_minimum,
                'semester_minimum' => $request->semester_minimum,
                'prasyarat' => $request->prasyarat,
                'status' => 'draft'
            ]);

            DB::commit();

            return redirect()->route('dosen.rekomendasi.show', $rekomendasi->id)
                ->with('success', 'Rekomendasi judul skripsi berhasil dibuat dengan skor SMART: ' . $smartScore);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat rekomendasi. Silakan coba lagi.');
        }
    }

    /**
     * Show specific recommendation
     */
    public function show($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $rekomendasi = RekomendasiJudul::where('dosen_id', $dosen->id)
            ->where('id', $id)
            ->with('mahasiswa.user')
            ->firstOrFail();

        return view('dosen.rekomendasi.show', compact('rekomendasi', 'dosen'));
    }

    /**
     * Send recommendation to student
     */
    public function send($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $rekomendasi = RekomendasiJudul::where('dosen_id', $dosen->id)
            ->where('id', $id)
            ->where('status', 'draft')
            ->firstOrFail();

        try {
            $rekomendasi->kirim();

            return redirect()->route('dosen.rekomendasi.index')
                ->with('success', 'Rekomendasi judul skripsi berhasil dikirim ke mahasiswa.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengirim rekomendasi.');
        }
    }

    /**
     * Delete recommendation
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        $rekomendasi = RekomendasiJudul::where('dosen_id', $dosen->id)
            ->where('id', $id)
            ->where('status', 'draft')
            ->firstOrFail();

        try {
            $rekomendasi->delete();

            return redirect()->route('dosen.rekomendasi.index')
                ->with('success', 'Rekomendasi berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus rekomendasi.');
        }
    }

    /**
     * Calculate string similarity using Levenshtein distance
     */
    private function calculateStringsSimilarity($str1, $str2): float
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
     * Auto generate recommendations via AJAX
     */
    public function autoGenerate(Request $request)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Data dosen tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id'
        ]);

        try {
            // Verify mahasiswa is under supervision
            $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
                ->where('mahasiswa_id', $request->mahasiswa_id)
                ->where('status', 'disetujui')
                ->with('mahasiswa.nilai')
                ->firstOrFail();

            // Template judul berdasarkan bidang keahlian dosen
            $templates = $this->getJudulTemplates($dosen->bidang_keahlian, $pengajuan);
            
            $recommendations = [];
            foreach ($templates as $template) {
                $smartScore = RekomendasiJudul::calculateSmartScore(
                    $pengajuan->mahasiswa,
                    $pengajuan,
                    $template
                );
                
                $template['skor_smart'] = $smartScore;
                $recommendations[] = $template;
            }

            // Sort by SMART score descending
            usort($recommendations, function($a, $b) {
                return $b['skor_smart'] <=> $a['skor_smart'];
            });

            return response()->json([
                'success' => true,
                'recommendations' => array_slice($recommendations, 0, 5) // Top 5
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate automatic recommendations based on SMART analysis
     */
    public function generateRecommendations($mahasiswa_id)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            abort(404, 'Data dosen tidak ditemukan');
        }

        // Verify mahasiswa is under supervision
        $pengajuan = PengajuanPembimbing::where('dosen_id', $dosen->id)
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('status', 'disetujui')
            ->with('mahasiswa.nilai')
            ->firstOrFail();

        // Template judul berdasarkan bidang keahlian dosen
        $templates = $this->getJudulTemplates($dosen->bidang_keahlian, $pengajuan);
        
        $recommendations = [];
        foreach ($templates as $template) {
            $smartScore = RekomendasiJudul::calculateSmartScore(
                $pengajuan->mahasiswa,
                $pengajuan,
                $template
            );
            
            $template['skor_smart'] = $smartScore;
            $recommendations[] = $template;
        }

        // Sort by SMART score descending
        usort($recommendations, function($a, $b) {
            return $b['skor_smart'] <=> $a['skor_smart'];
        });

        return response()->json([
            'success' => true,
            'recommendations' => array_slice($recommendations, 0, 5) // Top 5
        ]);
    }

    /**
     * Get thesis title templates based on expertise
     */
    private function getJudulTemplates($bidang_keahlian, $pengajuan): array
    {
        $minat = strtolower($pengajuan->minat_skripsi);
        $keahlian = strtolower($bidang_keahlian);
        
        // Template dasar berdasarkan bidang keahlian
        $templates = [];
        
        if (str_contains($keahlian, 'sistem informasi') || str_contains($keahlian, 'information system')) {
            $templates[] = [
                'judul_skripsi' => 'Sistem Informasi ' . ucfirst($minat) . ' Berbasis Web',
                'deskripsi_judul' => 'Pengembangan sistem informasi untuk mengelola ' . $minat . ' dengan teknologi web modern',
                'tipe_skripsi' => 'pengembangan',
                'bidang_keahlian' => 'Sistem Informasi',
                'tingkat_kesulitan' => 'sedang'
            ];
            
            $templates[] = [
                'judul_skripsi' => 'Analisis dan Perancangan Sistem ' . ucfirst($minat),
                'deskripsi_judul' => 'Penelitian untuk menganalisis kebutuhan dan merancang sistem ' . $minat,
                'tipe_skripsi' => 'penelitian',
                'bidang_keahlian' => 'Sistem Informasi',
                'tingkat_kesulitan' => 'mudah'
            ];
        }
        
        if (str_contains($keahlian, 'data') || str_contains($keahlian, 'mining')) {
            $templates[] = [
                'judul_skripsi' => 'Implementasi Data Mining untuk Prediksi ' . ucfirst($minat),
                'deskripsi_judul' => 'Penerapan algoritma data mining untuk memprediksi pola dalam ' . $minat,
                'tipe_skripsi' => 'penelitian',
                'bidang_keahlian' => 'Data Mining',
                'tingkat_kesulitan' => 'sulit'
            ];
        }
        
        if (str_contains($keahlian, 'mobile') || str_contains($keahlian, 'android')) {
            $templates[] = [
                'judul_skripsi' => 'Aplikasi Mobile ' . ucfirst($minat) . ' Berbasis Android',
                'deskripsi_judul' => 'Pengembangan aplikasi mobile untuk ' . $minat . ' menggunakan platform Android',
                'tipe_skripsi' => 'pengembangan',
                'bidang_keahlian' => 'Mobile Development',
                'tingkat_kesulitan' => 'sedang'
            ];
        }
        
        // Default template jika tidak ada yang cocok
        if (empty($templates)) {
            $templates[] = [
                'judul_skripsi' => 'Studi Kasus ' . ucfirst($minat) . ' di Lingkungan Akademik',
                'deskripsi_judul' => 'Penelitian studi kasus mengenai ' . $minat . ' dalam konteks akademik',
                'tipe_skripsi' => 'studi_kasus',
                'bidang_keahlian' => $bidang_keahlian,
                'tingkat_kesulitan' => 'mudah'
            ];
        }
        
        return $templates;
    }

    /**
     * Get templates via AJAX for specific bidang keahlian
     */
    public function getTemplates($bidang)
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        
        if (!$dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Data dosen tidak ditemukan'
            ], 404);
        }

        try {
            // Create dummy pengajuan for template generation
            $dummyPengajuan = (object) [
                'minat_skripsi' => 'teknologi informasi'
            ];
            
            $templates = $this->getJudulTemplates($bidang, $dummyPengajuan);
            
            return response()->json([
                'success' => true,
                'templates' => $templates
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}