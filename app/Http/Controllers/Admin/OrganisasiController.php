<?php
// app/Http/Controllers/Admin/OrganisasiController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganisasiController extends Controller
{
    public function index()
    {
        // Eager load anggota untuk menghindari N+1 query
        $organisasi = Organisasi::with('anggota')->ordered()->get();
        
        return view('admin.organisasi.index', [
            'activeMenu' => 'organisasi',
            'organisasi' => $organisasi
        ]);
    }

    public function create()
    {
        // Ambil anggota yang sudah approved dan belum masuk organisasi
        $anggotaList = Anggota::approved()
            ->whereDoesntHave('organisasi')
            ->orderBy('nama_usaha', 'asc')
            ->get();

        return view('admin.organisasi.create', [
            'activeMenu' => 'organisasi',
            'anggotaList' => $anggotaList
        ]);
    }

    public function store(Request $request)
    {
        // Validasi dengan nama nullable jika ada anggota_id
        $validated = $request->validate([
            'anggota_id' => 'nullable|exists:anggota,id',
            'nama' => 'required_without:anggota_id|nullable|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kategori_custom' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'urutan' => 'nullable|integer|min:0',
            'aktif' => 'nullable|boolean'
        ]);

        // Jika pilih dari anggota, ambil nama dari anggota
        if ($request->anggota_id) {
            $anggota = Anggota::find($request->anggota_id);
            $validated['nama'] = $anggota->nama_usaha;
        }

        // Handle kategori custom
        if ($request->kategori === 'lainnya' && $request->kategori_custom) {
            $validated['kategori'] = $request->kategori_custom;
        }

        // Set default aktif
        $validated['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('organisasi', 'public');
        }

        // Remove kategori_custom dari data yang disimpan
        unset($validated['kategori_custom']);

        Organisasi::create($validated);

        return redirect()->route('admin.organisasi.index')
            ->with('success', 'Data organisasi berhasil ditambahkan');
    }

    public function edit(Organisasi $organisasi)
    {   
        // Ambil anggota yang sudah approved dan belum masuk organisasi
        // ATAU anggota yang saat ini terpilih
        $anggotaList = Anggota::approved()
            ->where(function($query) use ($organisasi) {
                $query->whereDoesntHave('organisasi')
                      ->orWhere('id', $organisasi->anggota_id);
            })
            ->orderBy('nama_usaha', 'asc')
            ->get();

        return view('admin.organisasi.edit', [
            'activeMenu' => 'organisasi',
            'organisasi' => $organisasi,
            'anggotaList' => $anggotaList
        ]);
    }

    public function update(Request $request, Organisasi $organisasi)
    {
        // Validasi dengan nama nullable jika ada anggota_id
        $validated = $request->validate([
            'anggota_id' => 'nullable|exists:anggota,id',
            'nama' => 'required_without:anggota_id|nullable|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kategori_custom' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'urutan' => 'nullable|integer|min:0',
            'aktif' => 'nullable|boolean'
        ]);

        // Jika pilih dari anggota, ambil nama dari anggota
        if ($request->anggota_id) {
            $anggota = Anggota::find($request->anggota_id);
            $validated['nama'] = $anggota->nama_usaha;
        }

        // Handle kategori custom
        if ($request->kategori === 'lainnya' && $request->kategori_custom) {
            $validated['kategori'] = $request->kategori_custom;
        }

        // Set default aktif
        $validated['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($organisasi->foto) {
                Storage::disk('public')->delete($organisasi->foto);
            }
            $validated['foto'] = $request->file('foto')->store('organisasi', 'public');
        }

        // Remove kategori_custom dari data yang disimpan
        unset($validated['kategori_custom']);

        $organisasi->update($validated);

        return redirect()->route('admin.organisasi.index')
            ->with('success', 'Data organisasi berhasil diperbarui');
    }

    public function destroy(Organisasi $organisasi)
    {
        // Delete photo if exists
        if ($organisasi->foto) {
            Storage::disk('public')->delete($organisasi->foto);
        }

        $organisasi->delete();

        return redirect()->route('admin.organisasi.index')
            ->with('success', 'Data organisasi berhasil dihapus');
    }

    /**
     * Get detail organisasi untuk modal (AJAX)
     */
    public function show(Organisasi $organisasi)
    {
        $organisasi->load('anggota');
        
        return response()->json([
            'success' => true,
            'data' => [
                'nama' => $organisasi->nama,
                'jabatan' => $organisasi->jabatan,
                'kategori_label' => $organisasi->kategori_label,
                'foto_url' => $organisasi->foto_url,
                'bidang_usaha' => $organisasi->bidang_usaha,
                'detail_kegiatan' => $organisasi->detail_kegiatan,
                'profile_perusahaan_url' => $organisasi->profile_perusahaan_url,
                'anggota' => $organisasi->anggota ? [
                    'nama_usaha_perusahaan' => $organisasi->anggota->nama_usaha_perusahaan,
                    'email' => $organisasi->anggota->email,
                    'nomor_telepon' => $organisasi->anggota->nomor_telepon,
                    'alamat_kantor' => $organisasi->anggota->alamat_kantor,
                ] : null
            ]
        ]);
    }
}