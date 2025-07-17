<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekomendasi_judul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->string('judul_skripsi');
            $table->text('deskripsi_judul');
            $table->enum('tipe_skripsi', ['penelitian', 'pengembangan', 'studi_kasus', 'eksperimen']);
            $table->string('bidang_keahlian');
            $table->decimal('skor_smart', 5, 2)->comment('Skor hasil perhitungan SMART');
            $table->json('kriteria_smart')->comment('Detail kriteria dan bobot SMART');
            $table->enum('tingkat_kesulitan', ['mudah', 'sedang', 'sulit']);
            $table->decimal('ipk_minimum', 3, 2)->default(2.50);
            $table->integer('semester_minimum')->default(5);
            $table->text('prasyarat')->nullable();
            $table->enum('status', ['draft', 'dikirim', 'diterima', 'ditolak'])->default('draft');
            $table->text('catatan_mahasiswa')->nullable();
            $table->timestamp('tanggal_dikirim')->nullable();
            $table->timestamp('tanggal_respon')->nullable();
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['dosen_id', 'status']);
            $table->index(['mahasiswa_id', 'status']);
            $table->index('skor_smart');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_judul');
    }
};