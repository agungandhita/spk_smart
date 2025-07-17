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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->integer('semester');
            $table->decimal('ips', 3, 2)->nullable()->comment('Indeks Prestasi Semester');
            $table->decimal('ipk', 3, 2)->nullable()->comment('Indeks Prestasi Kumulatif');
            $table->integer('sks_semester')->nullable()->comment('SKS yang diambil semester ini');
            $table->integer('sks_kumulatif')->nullable()->comment('Total SKS kumulatif');
            $table->string('file_khs')->nullable()->comment('File PDF KHS');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['mahasiswa_id', 'semester']);
            $table->unique(['mahasiswa_id', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};