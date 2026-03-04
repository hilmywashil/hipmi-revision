<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->string('detail_image_1')->nullable()->after('logo_perusahaan');
            $table->string('detail_image_2')->nullable()->after('detail_image_1');
            $table->string('detail_image_3')->nullable()->after('detail_image_2');
            $table->text('deskripsi_detail')->nullable()->after('detail_image_3');
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['detail_image_1', 'detail_image_2', 'detail_image_3', 'deskripsi_detail']);
        });
    }
};