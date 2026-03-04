<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'gambar_dokumentasi', // Tambahkan ini
        'tanggal_publish',
        'bidang',
        'is_active',
        'is_populer',
    ];

    protected $casts = [
        'tanggal_publish' => 'date',
        'is_active' => 'boolean',
        'is_populer' => 'boolean',
        'gambar_dokumentasi' => 'array', // Cast ke array
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kegiatan) {
            if (empty($kegiatan->slug)) {
                $kegiatan->slug = Str::slug($kegiatan->judul);
            }
        });

        static::updating(function ($kegiatan) {
            if ($kegiatan->isDirty('judul')) {
                $kegiatan->slug = Str::slug($kegiatan->judul);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopuler($query)
    {
        return $query->where('is_populer', true);
    }

    public function scopeBidang($query, $bidang)
    {
        return $query->where('bidang', $bidang);
    }

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/hipmi-logo.png');
    }

    public function getTanggalFormatAttribute()
    {
        return $this->tanggal_publish->format('d M Y');
    }

    // Accessor untuk gambar dokumentasi dengan URL lengkap
    public function getGambarDokumentasiUrlAttribute()
    {
        if (!$this->gambar_dokumentasi) {
            return [];
        }
        
        return array_map(function($path) {
            return asset('storage/' . $path);
        }, $this->gambar_dokumentasi);
    }
    public function getBidangNameAttribute(): string
{
    // Hapus prefix 'bidang_' dan ambil angkanya
    $bidangNumber = str_replace('bidang_', '', $this->bidang);
    
    // Return dengan format "Bidang X" (title case)
    return 'Bidang ' . $bidangNumber;
}
}