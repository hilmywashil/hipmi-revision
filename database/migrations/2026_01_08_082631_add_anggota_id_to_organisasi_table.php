<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_anggota_id_to_organisasi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('organisasi', function (Blueprint $table) {
            $table->foreignId('anggota_id')->nullable()->after('id')->constrained('anggota')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('organisasi', function (Blueprint $table) {
            $table->dropForeign(['anggota_id']);
            $table->dropColumn('anggota_id');
        });
    }
};