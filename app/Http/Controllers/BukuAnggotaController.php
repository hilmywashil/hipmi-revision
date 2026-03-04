<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class BukuAnggotaController extends Controller
{
    /**
     * Display a listing of approved members.
     * Menampilkan anggota terbaru yang sudah diapprove
     */
    public function index(Request $request)
    {
        $query = Anggota::approved(); // Hanya tampilkan anggota yang sudah diapprove
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('nama_usaha_perusahaan', 'like', "%{$search}%")
                  ->orWhere('brand_usaha', 'like', "%{$search}%")
                  ->orWhere('bidang_usaha', 'like', "%{$search}%");
            });
        }
        
        // Filter by bidang usaha jika diperlukan
        if ($request->filled('bidang_usaha')) {
            $query->where('bidang_usaha', $request->bidang_usaha);
        }
        
        // Ambil data dengan pagination - Urutkan data terbaru
        $anggotas = $query->latest()->paginate(12); // 12 items per page
        
        // Ambil list bidang usaha untuk filter (optional)
        $bidangUsahaList = Anggota::approved()
                                  ->distinct()
                                  ->pluck('bidang_usaha')
                                  ->filter()
                                  ->sort()
                                  ->values();
        
        return view('pages.buku-anggota', compact('anggotas', 'bidangUsahaList'));
    }
    
    /**
     * Display the specified member detail.
     */
    public function show(Anggota $anggota)
    {
        // Pastikan hanya anggota yang approved yang bisa dilihat
        if ($anggota->status !== 'approved') {
            abort(404);
        }
        
        return view('pages.details.buku-detail', compact('anggota'));
    }
}