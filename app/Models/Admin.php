<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'photo',
        'password',
        'category',
        'domisili',
        'bidang',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * ✅ List semua bidang (1-12)
     */
    public static function getBidangList(): array
    {
        return [
            'bidang_1' => 'BIDANG 1',
            'bidang_2' => 'BIDANG 2',
            'bidang_3' => 'BIDANG 3',
            'bidang_4' => 'BIDANG 4',
            'bidang_5' => 'BIDANG 5',
            'bidang_6' => 'BIDANG 6',
            'bidang_7' => 'BIDANG 7',
            'bidang_8' => 'BIDANG 8',
            'bidang_9' => 'BIDANG 9',
            'bidang_10' => 'BIDANG 10',
            'bidang_11' => 'BIDANG 11',
            'bidang_12' => 'BIDANG 12',
        ];
    }

    /**
     * ✅ Get nama bidang yang readable
     * bidang_1 → BIDANG 1
     * bidang_12 → BIDANG 12
     */
    public function getBidangNameAttribute(): ?string
    {
        if (!$this->bidang) {
            return null;
        }
        
        // Hapus prefix 'bidang_' dan ambil angkanya
        $bidangNumber = str_replace('bidang_', '', $this->bidang);
        
        // Return dengan format "BIDANG X" (uppercase)
        return 'BIDANG ' . strtoupper($bidangNumber);
    }

    public function isSuperAdmin(): bool
    {
        return $this->category === 'super_admin';
    }

    public function isBPC(): bool
    {
        return $this->category === 'bpc';
    }

    public function isBPD(): bool
    {
        return $this->category === 'bpd';
    }

    public function canManageAdmins(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManageContent(): bool
    {
        return $this->isSuperAdmin() || $this->isBPD();
    }

    public function canApproveAnggota(): bool
    {
        return $this->category === 'bpc';
    }

    public function canApproveAnggotaByDomisili($domisili): bool
    {
        if ($this->category === 'bpd' || $this->category === 'super_admin') {
            return false; 
        }
        
        return $this->domisili === $domisili;
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::url($this->photo);
        }
        
        return '';
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 2));
    }

    public function approvedAnggotas()
    {
        return $this->hasMany(Anggota::class, 'approved_by');
    }
}