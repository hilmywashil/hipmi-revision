<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $query = Kegiatan::query()->orderBy('tanggal_publish', 'desc');

        // ✅ Filter berdasarkan bidang admin (kecuali Super Admin)
        if ($admin->category === 'bpd' && $admin->bidang) {
            $query->where('bidang', $admin->bidang);
        }

        if ($request->filled('bidang')) {
            $query->where('bidang', $request->bidang);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $kegiatan = $query->paginate(10);

        return view('admin.kegiatan.index', compact('kegiatan', 'admin')); // ✅ TAMBAHKAN 'admin'
    }
    public function create()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.kegiatan.create', compact('admin'));
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'gambar_dokumentasi.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal_publish' => 'required|date',
            'bidang' => $admin->isSuperAdmin() ? 'required|string' : 'nullable|string',
            'is_active' => 'boolean',
            'is_populer' => 'boolean',
        ], [
            'gambar_dokumentasi.*.image' => 'File dokumentasi harus berupa gambar',
            'gambar_dokumentasi.*.mimes' => 'Format gambar dokumentasi harus JPG, JPEG, atau PNG',
            'gambar_dokumentasi.*.max' => 'Ukuran gambar dokumentasi maksimal 2MB',
        ]);

        // ✅ Auto-set bidang untuk BPD, manual untuk Super Admin
        if ($admin->category === 'bpd') {
            $validated['bidang'] = $admin->bidang;
        }

        // Upload gambar utama
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kegiatan', $filename, 'public');
            $validated['gambar'] = $path;
        }

        // Upload gambar dokumentasi
        $dokumentasiPaths = [];
        if ($request->hasFile('gambar_dokumentasi')) {
            foreach ($request->file('gambar_dokumentasi') as $index => $file) {
                $filename = time() . '_dok_' . $index . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('kegiatan/dokumentasi', $filename, 'public');
                $dokumentasiPaths[] = $path;
            }
        }
        $validated['gambar_dokumentasi'] = $dokumentasiPaths;

        $validated['is_active'] = $request->has('is_active');
        $validated['is_populer'] = $request->has('is_populer');

        Kegiatan::create($validated);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Kegiatan $kegiatan)
    {
        $admin = Auth::guard('admin')->user();

        // ✅ Cek apakah admin BPD hanya bisa edit kegiatan bidangnya
        if ($admin->category === 'bpd' && $kegiatan->bidang !== $admin->bidang) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kegiatan bidang lain.');
        }

        return view('admin.kegiatan.edit', compact('kegiatan', 'admin'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $admin = Auth::guard('admin')->user();

        // ✅ Cek akses
        if ($admin->category === 'bpd' && $kegiatan->bidang !== $admin->bidang) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit kegiatan bidang lain.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'gambar_dokumentasi.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'hapus_dokumentasi' => 'nullable|array',
            'tanggal_publish' => 'required|date',
            'bidang' => $admin->isSuperAdmin() ? 'required|string' : 'nullable|string',
            'is_active' => 'boolean',
            'is_populer' => 'boolean',
        ]);

        // ✅ Bidang tetap untuk BPD
        if ($admin->category === 'bpd') {
            $validated['bidang'] = $admin->bidang;
        }

        // Upload gambar utama baru jika ada
        if ($request->hasFile('gambar')) {
            if ($kegiatan->gambar && Storage::disk('public')->exists($kegiatan->gambar)) {
                Storage::disk('public')->delete($kegiatan->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kegiatan', $filename, 'public');
            $validated['gambar'] = $path;
        }

        // Kelola gambar dokumentasi
        $existingDokumentasi = $kegiatan->gambar_dokumentasi ?? [];

        // Hapus gambar yang dipilih untuk dihapus
        if ($request->filled('hapus_dokumentasi')) {
            foreach ($request->hapus_dokumentasi as $pathToDelete) {
                if (Storage::disk('public')->exists($pathToDelete)) {
                    Storage::disk('public')->delete($pathToDelete);
                }
                $existingDokumentasi = array_filter($existingDokumentasi, function ($path) use ($pathToDelete) {
                    return $path !== $pathToDelete;
                });
            }
        }

        // Upload gambar dokumentasi baru
        if ($request->hasFile('gambar_dokumentasi')) {
            foreach ($request->file('gambar_dokumentasi') as $index => $file) {
                $filename = time() . '_dok_' . $index . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('kegiatan/dokumentasi', $filename, 'public');
                $existingDokumentasi[] = $path;
            }
        }

        $validated['gambar_dokumentasi'] = array_values($existingDokumentasi);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_populer'] = $request->has('is_populer');

        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $admin = Auth::guard('admin')->user();

        // ✅ Cek akses
        if ($admin->category === 'bpd' && $kegiatan->bidang !== $admin->bidang) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus kegiatan bidang lain.');
        }

        // Hapus gambar utama
        if ($kegiatan->gambar && Storage::disk('public')->exists($kegiatan->gambar)) {
            Storage::disk('public')->delete($kegiatan->gambar);
        }

        // Hapus semua gambar dokumentasi
        if ($kegiatan->gambar_dokumentasi) {
            foreach ($kegiatan->gambar_dokumentasi as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus!');
    }
}
