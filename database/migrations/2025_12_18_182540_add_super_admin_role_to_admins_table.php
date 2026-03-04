<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Update category enum to include super_admin
            $table->enum('category', ['super_admin', 'bpc', 'bpd'])->default('bpc')->change();
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('category', ['bpc', 'bpd'])->default('bpc')->change();
        });
    }
};