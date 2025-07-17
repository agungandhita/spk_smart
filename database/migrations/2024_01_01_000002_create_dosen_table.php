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
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nidn')->unique();
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_telepon', 15)->nullable();
            $table->text('alamat');
            $table->string('prodi');
            $table->string('fakultas');
            $table->string('jabatan_akademik')->nullable(); // Asisten Ahli, Lektor, dll
            $table->string('pendidikan_terakhir');
            $table->string('bidang_keahlian')->nullable();
            $table->enum('status', ['aktif', 'non_aktif', 'pensiun'])->default('aktif');
            $table->year('tahun_bergabung');
            $table->text('foto')->nullable();
            $table->text('riwayat_pendidikan')->nullable();
            $table->text('pengalaman_mengajar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};