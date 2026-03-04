<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnggotaKatalogController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();
        $katalogs = $anggota->katalogs()->latest()->paginate(10);

        $stats = [
            'total'    => $anggota->katalogs()->count(),
            'pending'  => $anggota->pendingKatalogs()->count(),
            'approved' => $anggota->approvedKatalogs()->count(),
            'rejected' => $anggota->katalogs()->where('status', 'rejected')->count(),
        ];

        // Cek apakah anggota sudah punya katalog (otomatis dibuat saat daftar)
        $hasKatalog = $anggota->katalogs()->exists();

        return view('anggota.katalog.index', compact('katalogs', 'stats', 'hasKatalog'));
    }

    public function create()
    {
        $anggota = Auth::guard('anggota')->user();

        // Hanya anggota yang approved bisa submit katalog
        if ($anggota->status !== 'approved') {
            return redirect()->route('profile-anggota')
                ->with('error', 'Anda harus terverifikasi terlebih dahulu untuk menambahkan katalog.');
        }


        return view('anggota.katalog.create');
    }

    private function extractGoogleMapsEmbedUrl($input)
    {
        if (empty($input)) {
            return null;
        }

        $input = trim($input);

        if (strpos($input, '<iframe') === false && strpos($input, 'iframe') === false) {
            return null;
        }

        if (preg_match('/src=["\']([^"\']+)["\']/', $input, $matches)) {
            $url = $matches[1];
            if (strpos($url, 'google.com/maps/embed') !== false) {
                return $url;
            }
        }

        return null;
    }

    public function store(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        if ($anggota->status !== 'approved') {
            return redirect()->route('profile-anggota')
                ->with('error', 'Anda harus terverifikasi terlebih dahulu.');
        }

        // Guard: sudah punya katalog
        if ($anggota->katalogs()->exists()) {
            return redirect()->route('profile-anggota.katalog.index')
                ->with('error', 'Anda sudah memiliki katalog. Silakan edit katalog yang ada.');
        }

        $validated = $request->validate([
            'company_name'   => 'required|string|max:255',
            'business_field' => 'required|string|max:255',
            'description'    => 'required|string',
            'logo'           => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address'        => 'required|string',
            'phone'          => 'required|string|max:20',
            'email'          => 'required|email|max:255',
            'map_embed_url'  => 'nullable|string',
        ]);

        try {
            $logoPath   = $request->file('logo')->store('katalog/logos', 'public');
            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('katalog/images', 'public');
                }
            }

            $mapUrl = null;
            if ($request->filled('map_embed_url')) {
                $mapUrl = $this->extractGoogleMapsEmbedUrl($request->map_embed_url);
            }

            Katalog::create([
                'anggota_id'     => $anggota->id,
                'company_name'   => $validated['company_name'],
                'business_field' => $validated['business_field'],
                'description'    => $validated['description'],
                'logo'           => $logoPath,
                'images'         => $imagePaths,
                'address'        => $validated['address'],
                'phone'          => $validated['phone'],
                'email'          => $validated['email'],
                'map_embed_url'  => $mapUrl,
                'status'         => 'pending',
                'submitted_at'   => now(),
                'is_active'      => false,
            ]);

            return redirect()->route('profile-anggota.katalog.index')
                ->with('success', 'Katalog berhasil disubmit! Menunggu persetujuan admin.');

        } catch (\Exception $e) {
            if (isset($logoPath)) Storage::disk('public')->delete($logoPath);
            foreach ($imagePaths ?? [] as $path) {
                Storage::disk('public')->delete($path);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Katalog $katalog)
    {
        $anggota = Auth::guard('anggota')->user();

        if ($katalog->anggota_id !== $anggota->id) {
            abort(403, 'Anda tidak memiliki akses ke katalog ini.');
        }

        if (!$katalog->canBeEdited()) {
            return redirect()->route('profile-anggota.katalog.index')
                ->with('error', 'Katalog yang sudah disetujui tidak bisa diedit.');
        }

        return view('anggota.katalog.edit', compact('katalog'));
    }

    public function update(Request $request, Katalog $katalog)
    {
        $anggota = Auth::guard('anggota')->user();

        if ($katalog->anggota_id !== $anggota->id) {
            abort(403);
        }

        if (!$katalog->canBeEdited()) {
            return redirect()->route('profile-anggota.katalog.index')
                ->with('error', 'Katalog yang sudah disetujui tidak bisa diedit.');
        }

        $request->validate([
            'company_name'   => 'required|string|max:255',
            'business_field' => 'required|string|max:255',
            'description'    => 'required|string',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address'        => 'required|string',
            'phone'          => 'required|string|max:20',
            'email'          => 'required|email|max:255',
            'map_embed_url'  => 'nullable|string',
        ]);

        try {
            $data = $request->only([
                'company_name', 'business_field', 'description',
                'address', 'phone', 'email',
            ]);

            // Update logo jika ada
            if ($request->hasFile('logo')) {
                if ($katalog->logo) Storage::disk('public')->delete($katalog->logo);
                $data['logo'] = $request->file('logo')->store('katalog/logos', 'public');
            }

            // Update images jika ada
            if ($request->hasFile('images')) {
                if ($katalog->images) {
                    foreach ($katalog->images as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('katalog/images', 'public');
                }
                $data['images'] = $imagePaths;
            }

            // Handle map embed URL
            if ($request->filled('map_embed_url')) {
                $data['map_embed_url'] = $this->extractGoogleMapsEmbedUrl($request->map_embed_url);
            } elseif ($request->has('map_embed_url') && empty($request->map_embed_url)) {
                $data['map_embed_url'] = null;
            }

           if ($katalog->status === 'rejected') {
    $data['status']           = 'pending';
    $data['submitted_at']     = now();
    $data['rejection_reason'] = null;
}

            $katalog->update($data);

            return redirect()->route('profile-anggota.katalog.index')
                ->with('success', 'Katalog berhasil diperbarui dan akan direview kembali oleh admin.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Katalog $katalog)
    {
        $anggota = Auth::guard('anggota')->user();

        if ($katalog->anggota_id !== $anggota->id) {
            abort(403);
        }

        if (!$katalog->canBeEdited()) {
            return redirect()->route('profile-anggota.katalog.index')
                ->with('error', 'Katalog yang sudah disetujui tidak bisa dihapus.');
        }

        if ($katalog->logo) Storage::disk('public')->delete($katalog->logo);
        if ($katalog->images) {
            foreach ($katalog->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $katalog->delete();

        return redirect()->route('profile-anggota.katalog.index')
            ->with('success', 'Katalog berhasil dihapus.');
    }
}