<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\Misi;
use App\Models\Anggota;
use App\Models\Berita;
use App\Models\Umkm;
use App\Models\StrategicPlan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with all necessary data
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ==================== KATALOG SECTION ====================
        // Ambil data katalog aktif (maksimal 10 untuk carousel)
        $katalogs = Katalog::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Hitung total katalog aktif untuk info card
        $totalKatalog = Katalog::where('is_active', true)->count();

        // ==================== MISI SECTION ====================
        // Ambil data misi yang aktif dan diurutkan
        $misi = Misi::active()->ordered()->get();

        // ==================== ANGGOTA SECTION ====================
        // Hitung jumlah anggota yang sudah di-approve untuk info card
        $totalAnggota = Anggota::approved()->count();

        // Ambil data anggota yang sudah di-approve (maksimal 10 untuk carousel)
        $anggotaList = Anggota::approved()
            ->orderBy('approved_at', 'desc')
            ->take(10)
            ->get();

        // ==================== UMKM SECTION ====================
        // Hitung jumlah UMKM yang sudah di-approve untuk info card
        $totalUmkm = Umkm::where('status', 'approved')->count();

        // ==================== KEGIATAN SECTION ====================
        // Ambil 10 kegiatan terbaru untuk rotasi otomatis setiap 10 detik
        // Data ini akan di-rotate menggunakan JavaScript di frontend
        $kegiatanBerita = Kegiatan::active()
            ->orderBy('tanggal_publish', 'desc')
            ->take(10)
            ->get();

        // ==================== BERITA & DOKUMENTASI SECTION ====================
        // Ambil 7 berita terbaru untuk section "Berita & Dokumentasi"
        // Layout: 1 featured + 2 tengah + 3 bawah (jika tersedia)
        $dokumentasiBerita = Berita::active()
            ->latestPublish()
            ->take(7)
            ->get();

        // ==================== STRATEGIC PLAN SECTION ====================
        // Ambil data Strategic Plan Tata Kelola (maksimal 6 untuk grid)
        // Hanya untuk di-klik, detail ada di halaman terpisah
        $tataKelola = StrategicPlan::active()
            ->tataKelola()
            ->ordered()
            ->take(6)
            ->get();

        // Ambil data Program dan Layanan (maksimal 8 untuk grid)
        // Hanya untuk di-klik, detail ada di halaman terpisah
        $programLayanan = StrategicPlan::active()
            ->programLayanan()
            ->ordered()
            ->take(8)
            ->get();

        // ==================== RETURN VIEW ====================
        // Kirim semua data ke view home
        return view('pages.home', compact(
            'katalogs',              // E-Katalog carousel
            'totalKatalog',          // Info card: total katalog
            'misi',                  // Section Misi dengan alternating layout
            'totalAnggota',          // Info card: total anggota
            'anggotaList',           // Buku Informasi Anggota carousel
            'totalUmkm',             // Info card: total UMKM
            'kegiatanBerita',        // Informasi Kegiatan BPD (auto-rotate)
            'dokumentasiBerita',     // Berita & Dokumentasi
            'tataKelola',            // Strategic Plan - Tata Kelola
            'programLayanan'         // Strategic Plan - Program Layanan
        ));
    }
}