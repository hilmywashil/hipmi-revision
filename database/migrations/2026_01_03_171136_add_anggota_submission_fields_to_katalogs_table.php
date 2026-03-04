<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('katalogs', function (Blueprint $table) {
            $table->foreignId('anggota_id')->nullable()->after('id')->constrained('anggota')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_active');
            $table->text('rejection_reason')->nullable()->after('status');
            $table->timestamp('submitted_at')->nullable()->after('rejection_reason');
            $table->timestamp('approved_at')->nullable()->after('submitted_at');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('katalogs', function (Blueprint $table) {
            $table->dropForeign(['anggota_id']);
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'anggota_id',
                'status',
                'rejection_reason',
                'submitted_at',
                'approved_at',
                'approved_by'
            ]);
        });
    }
};