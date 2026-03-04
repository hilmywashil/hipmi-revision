<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {  // GANTI umkm jadi umkms
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('pelatihan');
            $table->text('rejection_reason')->nullable()->after('status');
            $table->timestamp('verified_at')->nullable()->after('rejection_reason');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {  // GANTI umkm jadi umkms
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['status', 'rejection_reason', 'verified_at', 'verified_by']);
        });
    }
};