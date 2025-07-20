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
        Schema::create('topik_skripsi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('prodi');
            $table->string('fakultas');
            $table->string('bidang_keahlian')->nullable();
            $table->string('nama_mahasiswa'); // Nama mahasiswa yang mengerjakan skripsi
            $table->string('nim_mahasiswa'); // NIM mahasiswa yang mengerjakan skripsi
            $table->year('tahun_lulus');
            $table->string('file_path'); // Path file PDF
            $table->string('file_name'); // Nama file asli
            $table->bigInteger('file_size'); // Ukuran file dalam bytes
            $table->enum('status', ['aktif', 'non_aktif'])->default('aktif');
            $table->text('kata_kunci')->nullable(); // Keywords untuk pencarian
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['prodi', 'status']);
            $table->index(['bidang_keahlian', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik_skripsi');
    }
};