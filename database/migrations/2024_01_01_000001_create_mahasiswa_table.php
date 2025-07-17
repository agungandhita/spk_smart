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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim')->unique();
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_telepon', 15)->nullable();
            $table->string('prodi');
            $table->string('fakultas');
            $table->decimal('ipk', 3, 2)->nullable()->default(0.00);
            $table->integer('semester')->default(1);
            $table->year('tahun_masuk');
            $table->enum('status', ['aktif', 'cuti', 'lulus', 'drop_out'])->default('aktif');
            $table->string('pembimbing_akademik')->nullable();
            $table->text('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};