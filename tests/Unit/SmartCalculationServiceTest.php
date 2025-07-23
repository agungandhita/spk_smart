<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\SmartCalculationService;
use App\Models\Mahasiswa;
use App\Models\PengajuanPembimbing;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Nilai;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SmartCalculationServiceTest extends TestCase
{
    use RefreshDatabase;

    private SmartCalculationService $smartService;
    private Mahasiswa $mahasiswa;
    private PengajuanPembimbing $pengajuan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->smartService = new SmartCalculationService();
        $this->createTestData();
    }

    private function createTestData()
    {
        // Create test user for mahasiswa
        $userMahasiswa = User::factory()->create([
            'name' => 'Test Mahasiswa',
            'email' => 'mahasiswa@test.com',
            'role' => 'mahasiswa'
        ]);

        // Create test mahasiswa
        $this->mahasiswa = Mahasiswa::create([
            'user_id' => $userMahasiswa->id,
            'nim' => '123456789',
            'alamat' => 'Test Address',
            'tanggal_lahir' => '2000-01-01',
            'tempat_lahir' => 'Test City',
            'jenis_kelamin' => 'L',
            'no_telepon' => '081234567890',
            'prodi' => 'Sistem Informasi',
            'fakultas' => 'Teknik',
            'semester' => 6,
            'ipk' => 3.5,
            'tahun_masuk' => 2020,
            'status' => 'aktif'
        ]);

        // Create test nilai
        Nilai::create([
            'mahasiswa_id' => $this->mahasiswa->id,
            'semester' => 6,
            'ips' => 3.5,
            'ipk' => 3.5,
            'sks_semester' => 24,
            'sks_kumulatif' => 144
        ]);

        // Create test user for dosen
        $userDosen = User::factory()->create([
            'name' => 'Test Dosen',
            'email' => 'dosen@test.com',
            'role' => 'dosen'
        ]);

        // Create test dosen
        $dosen = Dosen::create([
            'user_id' => $userDosen->id,
            'nidn' => '987654321',
            'alamat' => 'Test Dosen Address',
            'tanggal_lahir' => '1980-01-01',
            'tempat_lahir' => 'Test City',
            'jenis_kelamin' => 'L',
            'no_telepon' => '081234567891',
            'prodi' => 'Sistem Informasi',
            'fakultas' => 'Teknik',
            'pendidikan_terakhir' => 'S3',
            'tahun_bergabung' => 2010,
            'bidang_keahlian' => 'Sistem Informasi',
            'status' => 'aktif'
        ]);

        // Create test pengajuan
        $this->pengajuan = PengajuanPembimbing::create([
            'mahasiswa_id' => $this->mahasiswa->id,
            'dosen_id' => $dosen->id,
            'minat_skripsi' => 'sistem informasi',
            'alasan_memilih' => 'Test alasan',
            'status' => 'disetujui'
        ]);

        // Load relationships
        $this->pengajuan->load('dosen', 'mahasiswa.nilai');
    }

    /** @test */
    public function it_can_calculate_smart_score_for_single_alternative()
    {
        $alternative = [
            'judul_skripsi' => 'Sistem Informasi Akademik',
            'bidang_keahlian' => 'Sistem Informasi',
            'tingkat_kesulitan' => 'sedang'
        ];

        $score = $this->smartService->calculateSingleAlternative(
            $this->mahasiswa,
            $this->pengajuan,
            $alternative
        );

        $this->assertIsFloat($score);
        $this->assertGreaterThanOrEqual(0, $score);
        $this->assertLessThanOrEqual(100, $score);
    }

    /** @test */
    public function it_can_calculate_smart_score_for_multiple_alternatives()
    {
        $alternatives = [
            [
                'judul_skripsi' => 'Sistem Informasi Akademik',
                'bidang_keahlian' => 'Sistem Informasi',
                'tingkat_kesulitan' => 'mudah'
            ],
            [
                'judul_skripsi' => 'Aplikasi Mobile E-Commerce',
                'bidang_keahlian' => 'Mobile Development',
                'tingkat_kesulitan' => 'sulit'
            ],
            [
                'judul_skripsi' => 'Data Mining untuk Prediksi',
                'bidang_keahlian' => 'Data Mining',
                'tingkat_kesulitan' => 'sedang'
            ]
        ];

        $results = $this->smartService->calculateMultipleAlternatives(
            $this->mahasiswa,
            $this->pengajuan,
            $alternatives
        );

        $this->assertIsArray($results);
        $this->assertCount(3, $results);

        foreach ($results as $result) {
            $this->assertArrayHasKey('alternative', $result);
            $this->assertArrayHasKey('smart_score', $result);
            $this->assertArrayHasKey('criteria_details', $result);
            $this->assertArrayHasKey('normalized_criteria', $result);

            $this->assertIsFloat($result['smart_score']);
            $this->assertGreaterThanOrEqual(0, $result['smart_score']);
            $this->assertLessThanOrEqual(100, $result['smart_score']);
        }

        // Results should be sorted by score descending
        for ($i = 0; $i < count($results) - 1; $i++) {
            $this->assertGreaterThanOrEqual(
                $results[$i + 1]['smart_score'],
                $results[$i]['smart_score']
            );
        }
    }

    /** @test */
    public function it_normalizes_weights_correctly()
    {
        $criteria = $this->smartService->getNormalizedCriteria();

        $totalWeight = 0;
        foreach ($criteria as $criterion) {
            $this->assertArrayHasKey('normalized_weight', $criterion);
            $totalWeight += $criterion['normalized_weight'];
        }

        // Total normalized weight should be 1.0 (with small tolerance for floating point)
        $this->assertEqualsWithDelta(1.0, $totalWeight, 0.001);
    }

    /** @test */
    public function it_handles_benefit_and_cost_criteria_correctly()
    {
        $alternatives = [
            [
                'judul_skripsi' => 'Judul Mudah',
                'bidang_keahlian' => 'Sistem Informasi',
                'tingkat_kesulitan' => 'mudah' // Should get higher score (cost criterion)
            ],
            [
                'judul_skripsi' => 'Judul Sulit',
                'bidang_keahlian' => 'Sistem Informasi',
                'tingkat_kesulitan' => 'sulit' // Should get lower score (cost criterion)
            ]
        ];

        $results = $this->smartService->calculateMultipleAlternatives(
            $this->mahasiswa,
            $this->pengajuan,
            $alternatives
        );

        // For difficulty (cost criterion), 'mudah' should have higher normalized value than 'sulit'
        $mudahDifficulty = $results[0]['criteria_details']['difficulty']['normalized_value'];
        $sulitDifficulty = $results[1]['criteria_details']['difficulty']['normalized_value'];

        // Since results are sorted by total score, we need to find which is which
        $mudahResult = null;
        $sulitResult = null;

        foreach ($results as $result) {
            if ($result['alternative']['tingkat_kesulitan'] === 'mudah') {
                $mudahResult = $result;
            } elseif ($result['alternative']['tingkat_kesulitan'] === 'sulit') {
                $sulitResult = $result;
            }
        }

        $this->assertNotNull($mudahResult);
        $this->assertNotNull($sulitResult);

        // For cost criterion, easier (mudah) should have higher normalized value
        $this->assertGreaterThan(
            $sulitResult['criteria_details']['difficulty']['normalized_value'],
            $mudahResult['criteria_details']['difficulty']['normalized_value']
        );
    }

    /** @test */
    public function it_handles_edge_cases_correctly()
    {
        // Test with identical alternatives (should not cause division by zero)
        $alternatives = [
            [
                'judul_skripsi' => 'Judul Sama 1',
                'bidang_keahlian' => 'Sistem Informasi',
                'tingkat_kesulitan' => 'sedang'
            ],
            [
                'judul_skripsi' => 'Judul Sama 2',
                'bidang_keahlian' => 'Sistem Informasi',
                'tingkat_kesulitan' => 'sedang'
            ]
        ];

        $results = $this->smartService->calculateMultipleAlternatives(
            $this->mahasiswa,
            $this->pengajuan,
            $alternatives
        );

        $this->assertCount(2, $results);
        
        // Both should have the same score since they're identical
        $this->assertEquals(
            $results[0]['smart_score'],
            $results[1]['smart_score']
        );
    }

    /** @test */
    public function it_provides_detailed_criteria_breakdown()
    {
        $alternative = [
            'judul_skripsi' => 'Test Judul',
            'bidang_keahlian' => 'Sistem Informasi',
            'tingkat_kesulitan' => 'sedang'
        ];

        $results = $this->smartService->calculateMultipleAlternatives(
            $this->mahasiswa,
            $this->pengajuan,
            [$alternative]
        );

        $result = $results[0];
        $criteriaDetails = $result['criteria_details'];

        // Check that all criteria are present
        $expectedCriteria = ['ipk', 'semester', 'minat_match', 'dosen_expertise', 'difficulty'];
        foreach ($expectedCriteria as $criterion) {
            $this->assertArrayHasKey($criterion, $criteriaDetails);
            $this->assertArrayHasKey('raw_value', $criteriaDetails[$criterion]);
            $this->assertArrayHasKey('normalized_value', $criteriaDetails[$criterion]);
            $this->assertArrayHasKey('type', $criteriaDetails[$criterion]);
        }

        // Check normalized criteria weights
        $normalizedCriteria = $result['normalized_criteria'];
        foreach ($expectedCriteria as $criterion) {
            $this->assertArrayHasKey($criterion, $normalizedCriteria);
            $this->assertArrayHasKey('weight', $normalizedCriteria[$criterion]);
            $this->assertArrayHasKey('normalized_weight', $normalizedCriteria[$criterion]);
            $this->assertArrayHasKey('type', $normalizedCriteria[$criterion]);
        }
    }
}