<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Halaman daftar kegiatan (public)
     */
    public function index(Request $request)
    {
        $query = Kegiatan::active()->orderBy('tanggal_publish', 'desc');

        // Filter berdasarkan bidang
        if ($request->filled('bidang')) {
            $query->where('bidang', $request->bidang);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_publish', $request->tanggal);
        }

        $kegiatan = $query->paginate(12)->appends($request->except('page'));

        return view('pages.informasi-kegiatan', compact('kegiatan'));
    }

    /**
     * Halaman detail kegiatan (public)
     */
    public function show($slug)
    {
        $kegiatan = Kegiatan::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // ✅ Ambil kegiatan populer (is_populer = true, max 3)
        $kegiatanPopuler = Kegiatan::active()
            ->where('is_populer', true)
            ->where('id', '!=', $kegiatan->id)
            ->orderBy('tanggal_publish', 'desc')
            ->take(3)
            ->get();

        // ✅ Ambil kegiatan lainnya (exclude current, max 3)
        $kegiatanLainnya = Kegiatan::active()
            ->where('id', '!=', $kegiatan->id)
            ->orderBy('tanggal_publish', 'desc')
            ->take(3)
            ->get();

        return view('pages.details.kegiatan-detail', compact('kegiatan', 'kegiatanPopuler', 'kegiatanLainnya'));
    }
}