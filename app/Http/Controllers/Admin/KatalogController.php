<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KatalogController extends Controller
{
    /**
     * Cek apakah admin bisa edit katalog ini
     */
    private function canEditKatalog(Katalog $katalog)
    {
        $admin = Auth::guard('admin')->user();
        
        // Super Admin bisa edit semua
        if ($admin->isSuperAdmin()) {
            return true;
        }
        
        // Katalog dari anggota tidak bisa diedit oleh siapapun kecuali Super Admin
        if ($katalog->isSubmittedByAnggota()) {
            return false;
        }
        
        // Admin BPD hanya bisa edit katalog dari bidangnya sendiri
        if ($admin->isBPD()) {
            if ($katalog->admin && $katalog->admin->bidang === $admin->bidang) {
                return true;
            }
            return false;
        }
        
        return false;
    }

    /**
     * Cek apakah admin bisa hapus katalog ini
     */
    private function canDeleteKatalog(Katalog $katalog)
    {
        $admin = Auth::guard('admin')->user();
        
        // Super Admin bisa hapus semua katalog
        if ($admin->isSuperAdmin()) {
            return true;
        }
        
        // BPD bisa hapus:
        if ($admin->isBPD()) {
            // 1. Katalog anggota yang belum approved
            if ($katalog->isSubmittedByAnggota() && $katalog->status !== 'approved') {
                return true;
            }
            // 2. Katalog admin dari bidangnya sendiri
            if (!$katalog->isSubmittedByAnggota()) {
                if ($katalog->admin && $katalog->admin->bidang === $admin->bidang) {
                    return true;
                }
            }
            return false;
        }
        
        return false;
    }

    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $status = $request->get('status', 'all');

        $query = Katalog::with(['anggota', 'admin']);

        // Filter berdasarkan status
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Stats untuk semua katalog
        $stats = [
            'total' => Katalog::count(),
            'pending' => Katalog::where('status', 'pending')->count(),
            'approved' => Katalog::where('status', 'approved')->count(),
            'rejected' => Katalog::where('status', 'rejected')->count(),
        ];

        $katalogs = $query->latest()->paginate(15)->appends(['status' => $status]);

        return view('admin.katalog.index', compact('katalogs', 'stats', 'status'));
    }

    public function create()
    {
        return view('admin.katalog.create');
    }

    /**
     * Ekstrak URL src dari iframe Google Maps embed
     * Hanya menerima kode iframe embed lengkap
     */
    private function extractGoogleMapsEmbedUrl($input)
    {
        if (empty($input)) {
            return null;
        }

        $input = trim($input);

        // Cek apakah input mengandung iframe
        if (strpos($input, '<iframe') === false && strpos($input, 'iframe') === false) {
            return null;
        }

        // Extract src dari iframe
        if (preg_match('/src=["\']([^"\']+)["\']/', $input, $matches)) {
            $url = $matches[1];
            
            // Validasi bahwa ini adalah URL Google Maps embed
            if (strpos($url, 'google.com/maps/embed') !== false) {
                return $url;
            }
        }

        return null;
    }

    /**
     * Method helper yang sama untuk AnggotaKatalogController
     */
    public static function extractMapEmbedUrl($input)
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
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'business_field' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'map_embed_url' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        try {
            $logoPath = $request->file('logo')->store('katalog/logos', 'public');

            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('katalog/images', 'public');
                }
            }

            // Ekstrak URL embed dari iframe
            $mapUrl = null;
            if ($request->filled('map_embed_url')) {
                $mapUrl = $this->extractGoogleMapsEmbedUrl($request->map_embed_url);
            }

            $admin = Auth::guard('admin')->user();

            Katalog::create([
                'anggota_id' => null,
                'company_name' => $validated['company_name'],
                'business_field' => $validated['business_field'],
                'description' => $validated['description'],
                'logo' => $logoPath,
                'images' => $imagePaths,
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'map_embed_url' => $mapUrl,
                'status' => 'approved',
                'is_active' => $request->has('is_active') ? true : false,
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]);

            return redirect()->route('admin.katalog.index')
                ->with('success', 'Data katalog berhasil ditambahkan');
        } catch (\Exception $e) {
            if (isset($logoPath)) Storage::disk('public')->delete($logoPath);
            if (isset($imagePaths)) {
                foreach ($imagePaths as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Katalog $katalog)
    {
        // ✅ Cek permission untuk edit
        if (!$this->canEditKatalog($katalog)) {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit katalog ini.');
        }

        return view('admin.katalog.edit', compact('katalog'));
    }

    public function update(Request $request, Katalog $katalog)
    {
        // ✅ Cek permission untuk edit
        if (!$this->canEditKatalog($katalog)) {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit katalog ini.');
        }

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'business_field' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'map_embed_url' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        try {
            $data = $request->except(['logo', 'images']);

            // Update logo
            if ($request->hasFile('logo')) {
                if ($katalog->logo && Storage::disk('public')->exists($katalog->logo)) {
                    Storage::disk('public')->delete($katalog->logo);
                }
                $data['logo'] = $request->file('logo')->store('katalog/logos', 'public');
            }

            // Update images
            if ($request->hasFile('images')) {
                if ($katalog->images) {
                    foreach ($katalog->images as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage)) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                }

                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('katalog/images', 'public');
                }
                $data['images'] = $imagePaths;
            }

            // Update map embed URL
            if ($request->filled('map_embed_url')) {
                $extractedUrl = $this->extractGoogleMapsEmbedUrl($request->map_embed_url);
                $data['map_embed_url'] = $extractedUrl;
            } elseif ($request->has('map_embed_url') && empty($request->map_embed_url)) {
                // Jika field kosong, hapus map
                $data['map_embed_url'] = null;
            }

            $data['is_active'] = $request->has('is_active');

            $katalog->update($data);

            return redirect()->route('admin.katalog.index')
                ->with('success', 'Data katalog berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Katalog $katalog)
    {
        // ✅ Cek permission untuk hapus
        if (!$this->canDeleteKatalog($katalog)) {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus katalog ini.');
        }

        // Hapus file logo
        if ($katalog->logo && Storage::disk('public')->exists($katalog->logo)) {
            Storage::disk('public')->delete($katalog->logo);
        }

        // Hapus file images
        if ($katalog->images) {
            foreach ($katalog->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $katalog->delete();

        return redirect()->route('admin.katalog.index')
            ->with('success', 'Data katalog berhasil dihapus');
    }

    public function approve(Katalog $katalog)
    {
        if (!$katalog->isSubmittedByAnggota()) {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Hanya katalog dari anggota yang bisa diapprove.');
        }

        if ($katalog->status !== 'pending') {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Katalog sudah diproses sebelumnya.');
        }

        $admin = Auth::guard('admin')->user();
        $katalog->approve($admin->id);

        return redirect()->route('admin.katalog.index')
            ->with('success', "Katalog {$katalog->company_name} berhasil disetujui!");
    }

    public function reject(Request $request, Katalog $katalog)
    {
        if (!$katalog->isSubmittedByAnggota()) {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Hanya katalog dari anggota yang bisa direject.');
        }

        if ($katalog->status !== 'pending') {
            return redirect()->route('admin.katalog.index')
                ->with('error', 'Katalog sudah diproses sebelumnya.');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|max:500'
        ]);

        $admin = Auth::guard('admin')->user();
        $katalog->reject($request->alasan_penolakan, $admin->id);

        return redirect()->route('admin.katalog.index')
            ->with('success', "Katalog {$katalog->company_name} berhasil ditolak.");
    }
}