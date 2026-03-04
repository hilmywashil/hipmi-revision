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
        Schema::table('umkms', function (Blueprint $table) {
            // Tambahkan kolom anggota_id setelah id
            $table->unsignedBigInteger('anggota_id')->after('id')->nullable();
            
            // Buat foreign key constraint
            $table->foreign('anggota_id')
                  ->references('id')
                  ->on('anggota')
                  ->onDelete('cascade');
                  
            // Tambahkan index untuk performa
            $table->index('anggota_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropForeign(['anggota_id']);
            $table->dropIndex(['anggota_id']);
            $table->dropColumn('anggota_id');
        });
    }
};