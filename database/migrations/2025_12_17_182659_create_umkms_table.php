<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            
            // Data Usaha
            $table->string('nama_usaha');
            $table->string('bidang_usaha');
            $table->string('status_legalitas');
            $table->string('jenis_legalitas')->nullable();
            $table->string('tahun_berdiri');
            
            // Data Pribadi
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('nomor_hp');
            $table->string('email');
            $table->text('alamat_domisili');
            
            // Data Lainnya
            $table->enum('platform_digital', ['Ya', 'Tidak']);
            $table->json('platform')->nullable(); // Array of platforms
            $table->string('pendapatan');
            $table->enum('pembiayaan', ['Ya', 'Tidak'])->nullable();
            $table->string('sumber_pembiayaan')->nullable();
            $table->string('tujuan');
            $table->text('pelatihan');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};