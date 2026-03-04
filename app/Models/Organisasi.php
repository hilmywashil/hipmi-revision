<?php
// app/Models/Organisasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Organisasi extends Model
{
    use HasFactory;

    protected $table = 'organisasi';

    protected $fillable = [
        'anggota_id',
        'nama',
        'jabatan',
        'foto',
        'kategori',
        'urutan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // =====================================================
    // RELATIONSHIPS
    // =====================================================

    /**
     * Relasi ke Anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    // =====================================================
    // ACCESSORS
    // =====================================================

    public function getFotoUrlAttribute()
    {
        // Prioritas: foto organisasi > foto anggota > placeholder
        if ($this->foto) {
            return Storage::url($this->foto);
        }
        
        if ($this->anggota && $this->anggota->foto_diri) {
            return Storage::url($this->anggota->foto_diri);
        }
        
        return asset('images/photo.jpg');
    }

    public function getKategoriLabelAttribute()
    {
        // Standard kategori labels
        $standardLabels = [
            'ketua_umum' => 'Ketua Umum',
            'wakil_ketua_umum' => 'Wakil Ketua Umum',
            'ketua_bidang' => 'Ketua Bidang',
            'sekretaris_umum' => 'Sekretaris Umum',
            'wakil_sekretaris_umum' => 'Wakil Sekretaris Umum',
        ];

        // Jika kategori ada di standard list, return label nya
        if (isset($standardLabels[$this->kategori])) {
            return $standardLabels[$this->kategori];
        }

        // Jika kategori custom, capitalize first letter tiap kata
        return Str::title($this->kategori);
    }

    /**
     * Check apakah kategori ini adalah kategori custom (bukan standard)
     */
    public function getIsCustomKategoriAttribute()
    {
        $standardKategori = ['ketua_umum', 'wakil_ketua_umum', 'ketua_bidang', 'sekretaris_umum', 'wakil_sekretaris_umum'];
        return !in_array($this->kategori, $standardKategori);
    }

    /**
     * Get bidang usaha dari anggota
     */
    public function getBidangUsahaAttribute()
    {
        return $this->anggota ? $this->anggota->bidang_usaha : null;
    }

    /**
     * Get deskripsi detail (kegiatan) dari anggota
     */
    public function getDetailKegiatanAttribute()
    {
        return $this->anggota ? $this->anggota->deskripsi_detail : null;
    }

    /**
     * Get profile perusahaan dari anggota
     */
    public function getProfilePerusahaanAttribute()
    {
        return $this->anggota ? $this->anggota->profile_perusahaan : null;
    }

    /**
     * Get profile perusahaan URL dari anggota
     */
    public function getProfilePerusahaanUrlAttribute()
    {
        return $this->anggota && $this->anggota->profile_perusahaan 
            ? Storage::url($this->anggota->profile_perusahaan) 
            : null;
    }

    // =====================================================
    // SCOPES
    // =====================================================

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('created_at', 'asc');
    }

    /**
     * Scope untuk kategori standard saja
     */
    public function scopeStandardKategori($query)
    {
        return $query->whereIn('kategori', [
            'ketua_umum', 
            'wakil_ketua_umum', 
            'ketua_bidang', 
            'sekretaris_umum', 
            'wakil_sekretaris_umum'
        ]);
    }

    /**
     * Scope untuk kategori custom saja
     */
    public function scopeCustomKategori($query)
    {
        return $query->whereNotIn('kategori', [
            'ketua_umum', 
            'wakil_ketua_umum', 
            'ketua_bidang', 
            'sekretaris_umum', 
            'wakil_sekretaris_umum'
        ]);
    }

    // =====================================================
    // HELPER METHODS
    // =====================================================

    /**
     * Check apakah memiliki bidang usaha
     */
    public function hasBidangUsaha()
    {
        return $this->anggota && !empty($this->anggota->bidang_usaha);
    }

    /**
     * Check apakah memiliki detail kegiatan
     */
    public function hasDetailKegiatan()
    {
        return $this->anggota && !empty($this->anggota->deskripsi_detail);
    }

    /**
     * Check apakah memiliki profile perusahaan
     */
    public function hasProfilePerusahaan()
    {
        return $this->anggota && !empty($this->anggota->profile_perusahaan);
    }

    /**
     * Get warna badge berdasarkan kategori
     */
    public function getKategoriColorAttribute()
    {
        $colors = [
            'ketua_umum' => '#10b981', // green
            'wakil_ketua_umum' => '#3b82f6', // blue
            'ketua_bidang' => '#ef4444', // red
            'sekretaris_umum' => '#10b981', // green
            'wakil_sekretaris_umum' => '#3b82f6', // blue
        ];

        // Return color jika standard kategori, otherwise return purple untuk custom
        return $colors[$this->kategori] ?? '#8b5cf6'; // purple untuk custom
    }
}