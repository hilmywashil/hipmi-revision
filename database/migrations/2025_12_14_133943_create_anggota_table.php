<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            
            // Data Pribadi
            $table->string('nama_usaha');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('nomor_telepon');
            $table->string('domisili');
            $table->text('alamat_domisili');
            $table->string('kode_pos');
            $table->string('email');
            $table->string('nomor_ktp', 16);
            $table->string('foto_ktp');
            $table->string('foto_diri');
            
            // Profile Perusahaan
            $table->string('nama_usaha_perusahaan');
            $table->enum('legalitas_usaha', ['PT', 'CV', 'PT Perorangan']);
            $table->string('jabatan_usaha');
            $table->text('alamat_kantor');
            $table->text('bidang_usaha');
            $table->string('brand_usaha');
            $table->integer('jumlah_karyawan');
            $table->string('nomor_ktp_perusahaan', 16);
            $table->string('usia_perusahaan');
            $table->string('omset_perusahaan');
            $table->string('npwp_perusahaan');
            $table->string('no_nota_pendirian');
            $table->string('profile_perusahaan'); // PDF
            $table->string('logo_perusahaan');
            
            // Organisasi
            $table->string('sfc_hipmi');
            $table->enum('referensi_hipmi', ['Ya', 'Tidak']);
            $table->enum('organisasi_lain', ['Ya', 'Tidak']);
            
            // Status & Approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            
            $table->timestamps();
            
            // Foreign key untuk admin yang approve
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};