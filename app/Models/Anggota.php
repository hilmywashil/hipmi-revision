<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class Anggota extends Authenticatable
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'nama_usaha',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'nomor_telepon',
        'domisili',
        'alamat_domisili',
        'kode_pos',
        'email',
        'password',
        'initial_password',
        'nomor_ktp',
        'foto_ktp',
        'foto_diri',
        'nama_usaha_perusahaan',
        'legalitas_usaha',
        'jabatan_usaha',
        'alamat_kantor',
        'bidang_usaha',
        'brand_usaha',
        'jumlah_karyawan',
        'nomor_ktp_perusahaan',
        'usia_perusahaan',
        'omset_perusahaan',
        'npwp_perusahaan',
        'no_nota_pendirian',
        'profile_perusahaan',
        'logo_perusahaan',
        'detail_image_1',
        'detail_image_2',
        'detail_image_3',
        'deskripsi_detail',
        'sfc_hipmi',
        'referensi_hipmi',
        'organisasi_lain',
        'status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'approved_at' => 'datetime',
    ];

    // =====================================================
    // RELATIONSHIPS
    // =====================================================

    /**
     * Relasi ke Admin yang menyetujui
     */
    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'email', 'email');
    }

    /**
     * Relasi ke UMKM (One to Many)
     * Satu anggota bisa memiliki banyak UMKM
     */
    public function umkms()
    {
        return $this->hasMany(Umkm::class, 'anggota_id');
    }

    /**
     * Get UMKM yang sudah diapprove
     */
    public function approvedUmkms()
    {
        return $this->hasMany(Umkm::class, 'anggota_id')->where('status', 'approved');
    }

    /**
     * Get UMKM yang pending
     */
    public function pendingUmkms()
    {
        return $this->hasMany(Umkm::class, 'anggota_id')->where('status', 'pending');
    }

    /**
     * Get UMKM yang ditolak
     */
    public function rejectedUmkms()
    {
        return $this->hasMany(Umkm::class, 'anggota_id')->where('status', 'rejected');
    }

    public function katalogs()
    {
        return $this->hasMany(Katalog::class, 'anggota_id');
    }

    public function approvedKatalogs()
    {
        return $this->hasMany(Katalog::class, 'anggota_id')->where('status', 'approved');
    }

    public function pendingKatalogs()
    {
        return $this->hasMany(Katalog::class, 'anggota_id')->where('status', 'pending');
    }

    public function hasApprovedKatalog()
    {
        return $this->katalogs()->where('status', 'approved')->exists();
    }

    // ============ TAMBAHKAN INI (RELASI ORGANISASI) ============
    /**
     * Relasi ke Organisasi
     */
    public function organisasi()
    {
        return $this->hasOne(Organisasi::class, 'anggota_id');
    }

    /**
     * Check apakah anggota sudah terdaftar di organisasi
     */
    public function isInOrganisasi()
    {
        return $this->organisasi()->exists();
    }
    // ============ AKHIR TAMBAHAN ============

    // =====================================================
    // ACCESSORS (URL Attributes)
    // =====================================================

    public function getFotoKtpUrlAttribute()
    {
        return $this->foto_ktp ? Storage::url($this->foto_ktp) : null;
    }

    public function getFotoDiriUrlAttribute()
    {
        return $this->foto_diri ? Storage::url($this->foto_diri) : null;
    }

    public function getProfilePerusahaanUrlAttribute()
    {
        return $this->profile_perusahaan ? Storage::url($this->profile_perusahaan) : null;
    }

    public function getLogoPerusahaanUrlAttribute()
    {
        return $this->logo_perusahaan ? Storage::url($this->logo_perusahaan) : null;
    }

    public function getDetailImage1UrlAttribute()
    {
        return $this->detail_image_1 ? Storage::url($this->detail_image_1) : null;
    }

    public function getDetailImage2UrlAttribute()
    {
        return $this->detail_image_2 ? Storage::url($this->detail_image_2) : null;
    }

    public function getDetailImage3UrlAttribute()
    {
        return $this->detail_image_3 ? Storage::url($this->detail_image_3) : null;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->foto_diri) {
            return Storage::url($this->foto_diri);
        }
        
        return $this->jenis_kelamin === 'Perempuan' 
            ? asset('images/placeholder/female_ph.jpeg') 
            : asset('images/placeholder/male_ph.jpeg');
    }

    // =====================================================
    // SCOPES
    // =====================================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // =====================================================
    // METHODS
    // =====================================================

    public function approve($adminId)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $adminId,
            'rejection_reason' => null,
        ]);
    }

    public function reject($reason, $adminId)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_by' => $adminId,
            'approved_at' => null,
        ]);
    }

    /**
     * Check apakah anggota sudah pernah mendaftar UMKM
     */
    public function hasUmkmRegistration()
    {
        return $this->umkms()->exists();
    }

    /**
     * Check apakah anggota punya UMKM yang diapprove
     */
    public function hasApprovedUmkm()
    {
        return $this->umkms()->where('status', 'approved')->exists();
    }

    /**
     * Get jumlah UMKM yang dimiliki
     */
    public function getUmkmCountAttribute()
    {
        return $this->umkms()->count();
    }

    /**
     * Get status verifikasi anggota dengan badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Menunggu Verifikasi</span>',
            'approved' => '<span class="badge badge-success">Disetujui</span>',
            'rejected' => '<span class="badge badge-danger">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">Tidak Diketahui</span>';
    }
}