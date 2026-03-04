<?php
// database/migrations/2025_01_08_xxxxx_modify_kategori_column_in_organisasi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah ENUM jadi VARCHAR
        DB::statement('ALTER TABLE organisasi MODIFY kategori VARCHAR(255)');
    }

    public function down(): void
    {
        // Rollback ke ENUM (opsional)
        DB::statement("ALTER TABLE organisasi MODIFY kategori ENUM('ketua_umum', 'wakil_ketua_umum', 'ketua_bidang', 'sekretaris_umum', 'wakil_sekretaris_umum')");
    }
};