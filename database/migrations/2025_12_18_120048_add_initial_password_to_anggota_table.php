<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            // Tambahkan kolom password jika belum ada
            if (!Schema::hasColumn('anggota', 'password')) {
                $table->string('password')->after('email');
            }
            
            // Tambahkan kolom initial_password
            $table->string('initial_password')->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn('initial_password');
        });
    }
};