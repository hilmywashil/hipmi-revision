<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Katalog::with(['anggota', 'admin'])
            ->where('status', 'approved')
            ->where('is_active', true);

        // Filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('business_field', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter Bidang - langsung dari business_field
        if ($request->filled('bidang')) {
            $query->where('business_field', $request->bidang);
        }

        // Filter Tipe (Anggota atau Pengurus)
        if ($request->filled('tipe')) {
            if ($request->tipe === 'anggota') {
                $query->whereNotNull('anggota_id');
            } elseif ($request->tipe === 'pengurus') {
                $query->whereNull('anggota_id');
            }
        }

        // Ambil semua business_field unik dari semua katalog approved & aktif
        $bidangList = Katalog::where('status', 'approved')
            ->where('is_active', true)
            ->whereNotNull('business_field')
            ->distinct()
            ->orderBy('business_field')
            ->pluck('business_field');

        $katalogs = $query->latest()->paginate(12)->withQueryString();

        return view('pages.ekatalog', compact('katalogs', 'bidangList'));
    }

    public function show(Katalog $katalog)
    {
        if ($katalog->status !== 'approved' || !$katalog->is_active) {
            abort(404);
        }

        $katalog->load(['anggota', 'admin']);

        $canViewFullDetail = $this->canViewFullDetail();

        return view('pages.details.ekatalog-detail', compact('katalog', 'canViewFullDetail'));
    }

    private function canViewFullDetail()
    {
        if (Auth::guard('admin')->check()) {
            return true;
        }

        if (Auth::guard('anggota')->check()) {
            $anggota = Auth::guard('anggota')->user();
            return $anggota->status === 'approved';
        }

        return false;
    }
}