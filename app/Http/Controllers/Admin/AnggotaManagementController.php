<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnggotaManagementController extends Controller
{
    // Method yang sudah ada untuk verifikasi (hanya untuk menu Dashboard)
    public function index(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        $status = $request->get('status', 'pending');
        $domisili = $request->get('domisili', 'all');

        $query = Anggota::query();

        // TAMBAHKAN HANDLER UNTUK SUPER_ADMIN
        if ($admin->category === 'super_admin') {
            // Super Admin bisa lihat semua anggota dengan filter domisili
            if ($domisili !== 'all') {
                $query->where('domisili', $domisili);
            }

            if ($domisili === 'all') {
                $stats = [
                    'total' => Anggota::count(),
                    'pending' => Anggota::where('status', 'pending')->count(),
                    'approved' => Anggota::where('status', 'approved')->count(),
                    'rejected' => Anggota::where('status', 'rejected')->count(),
                ];
            } else {
                $stats = [
                    'total' => Anggota::where('domisili', $domisili)->count(),
                    'pending' => Anggota::where('domisili', $domisili)->where('status', 'pending')->count(),
                    'approved' => Anggota::where('domisili', $domisili)->where('status', 'approved')->count(),
                    'rejected' => Anggota::where('domisili', $domisili)->where('status', 'rejected')->count(),
                ];
            }

            $domisiliList = \App\Models\Admin::where('category', 'bpc')
                ->whereNotNull('domisili')
                ->orderBy('domisili')
                ->pluck('domisili')
                ->unique()
                ->values();
        } elseif ($admin->category === 'bpc') {
            $query->where('domisili', $admin->domisili);

            $stats = [
                'total' => Anggota::where('domisili', $admin->domisili)->count(),
                'pending' => Anggota::where('domisili', $admin->domisili)->where('status', 'pending')->count(),
                'approved' => Anggota::where('domisili', $admin->domisili)->where('status', 'approved')->count(),
                'rejected' => Anggota::where('domisili', $admin->domisili)->where('status', 'rejected')->count(),
            ];

            $domisiliList = null;
        } elseif ($admin->category === 'bpd') {
            if ($domisili !== 'all') {
                $query->where('domisili', $domisili);
            }

            if ($domisili === 'all') {
                $stats = [
                    'total' => Anggota::count(),
                    'pending' => Anggota::where('status', 'pending')->count(),
                    'approved' => Anggota::where('status', 'approved')->count(),
                    'rejected' => Anggota::where('status', 'rejected')->count(),
                ];
            } else {
                $stats = [
                    'total' => Anggota::where('domisili', $domisili)->count(),
                    'pending' => Anggota::where('domisili', $domisili)->where('status', 'pending')->count(),
                    'approved' => Anggota::where('domisili', $domisili)->where('status', 'approved')->count(),
                    'rejected' => Anggota::where('domisili', $domisili)->where('status', 'rejected')->count(),
                ];
            }

            $domisiliList = \App\Models\Admin::where('category', 'bpc')
                ->whereNotNull('domisili')
                ->orderBy('domisili')
                ->pluck('domisili')
                ->unique()
                ->values();
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $anggota = $query->latest()->paginate(15)->appends([
            'status' => $status,
            'domisili' => $domisili
        ]);

        return view('admin.anggota.index', compact(
            'anggota',
            'stats',
            'status',
            'domisili',
            'domisiliList'
        ));
    }

    // Method baru untuk list semua anggota (read-only)
    public function listAll(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        $status = $request->get('status', 'all');
        $domisili = $request->get('domisili', 'all');

        $query = Anggota::query();

        // Filter berdasarkan kategori admin
        if ($admin->category === 'super_admin') {
            // Super Admin bisa lihat semua anggota dengan filter domisili
            if ($domisili !== 'all') {
                $query->where('domisili', $domisili);
            }

            if ($domisili === 'all') {
                $stats = [
                    'total' => Anggota::count(),
                    'pending' => Anggota::where('status', 'pending')->count(),
                    'approved' => Anggota::where('status', 'approved')->count(),
                    'rejected' => Anggota::where('status', 'rejected')->count(),
                ];
            } else {
                $stats = [
                    'total' => Anggota::where('domisili', $domisili)->count(),
                    'pending' => Anggota::where('domisili', $domisili)->where('status', 'pending')->count(),
                    'approved' => Anggota::where('domisili', $domisili)->where('status', 'approved')->count(),
                    'rejected' => Anggota::where('domisili', $domisili)->where('status', 'rejected')->count(),
                ];
            }

            // List domisili untuk dropdown
            $domisiliList = \App\Models\Admin::where('category', 'bpc')
                ->whereNotNull('domisili')
                ->orderBy('domisili')
                ->pluck('domisili')
                ->unique()
                ->values();
        } elseif ($admin->category === 'bpc') {
            // BPC hanya bisa lihat anggota di domisilinya
            $query->where('domisili', $admin->domisili);

            $stats = [
                'total' => Anggota::where('domisili', $admin->domisili)->count(),
                'pending' => Anggota::where('domisili', $admin->domisili)->where('status', 'pending')->count(),
                'approved' => Anggota::where('domisili', $admin->domisili)->where('status', 'approved')->count(),
                'rejected' => Anggota::where('domisili', $admin->domisili)->where('status', 'rejected')->count(),
            ];

            $domisiliList = null;
        } elseif ($admin->category === 'bpd') {
            // BPD bisa lihat semua anggota dengan filter domisili
            if ($domisili !== 'all') {
                $query->where('domisili', $domisili);
            }

            if ($domisili === 'all') {
                $stats = [
                    'total' => Anggota::count(),
                    'pending' => Anggota::where('status', 'pending')->count(),
                    'approved' => Anggota::where('status', 'approved')->count(),
                    'rejected' => Anggota::where('status', 'rejected')->count(),
                ];
            } else {
                $stats = [
                    'total' => Anggota::where('domisili', $domisili)->count(),
                    'pending' => Anggota::where('domisili', $domisili)->where('status', 'pending')->count(),
                    'approved' => Anggota::where('domisili', $domisili)->where('status', 'approved')->count(),
                    'rejected' => Anggota::where('domisili', $domisili)->where('status', 'rejected')->count(),
                ];
            }

            // List domisili untuk dropdown
            $domisiliList = \App\Models\Admin::where('category', 'bpc')
                ->whereNotNull('domisili')
                ->orderBy('domisili')
                ->pluck('domisili')
                ->unique()
                ->values();
        }

        // Filter berdasarkan status
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Get data dengan pagination
        $anggota = $query->latest()->paginate(15)->appends([
            'status' => $status,
            'domisili' => $domisili
        ]);

        return view('admin.anggota.list', compact(
            'anggota',
            'stats',
            'status',
            'domisili',
            'domisiliList'
        ));
    }

    // Method untuk show detail read-only
    public function showReadOnly(Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        // BPC hanya bisa lihat anggota di domisilinya
        if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
            abort(403, 'Anda tidak memiliki akses ke data anggota ini.');
        }

        return view('admin.anggota.show', compact('anggota'));
    }

    // Method yang sudah ada (untuk verifikasi)
    public function show(Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
            abort(403, 'Anda tidak memiliki akses ke data anggota ini.');
        }

        return view('admin.anggota.show', compact('anggota'));
    }

   public function approve(Anggota $anggota)
{
    $admin = auth()->guard('admin')->user();

    if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
        abort(403, 'Anda tidak memiliki akses untuk verifikasi anggota ini.');
    }

    // Approve anggota
    $anggota->approve($admin->id);

    // Auto-approve semua katalog pending milik anggota ini
    $anggota->katalogs()->where('status', 'pending')->update([
        'status'           => 'approved',
        'is_active'        => true,
        'approved_at'      => now(),
        'approved_by'      => $admin->id,
        'rejection_reason' => null,
    ]);

    return redirect()->route('admin.anggota.index')
        ->with('success', 'Anggota berhasil disetujui dan katalog perusahaan telah aktif!');
}

    public function reject(Request $request, Anggota $anggota)
{
    $admin = auth()->guard('admin')->user();

    if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
        abort(403, 'Anda tidak memiliki akses untuk verifikasi anggota ini.');
    }

    $request->validate([
        'alasan_penolakan' => 'required|string|max:500'
    ]);

    // Reject anggota
    $anggota->reject($request->alasan_penolakan, $admin->id);

    // Auto-reject semua katalog pending milik anggota ini
    $anggota->katalogs()->where('status', 'pending')->update([
        'status'           => 'rejected',
        'is_active'        => false,
        'rejection_reason' => 'Pendaftaran anggota tidak disetujui: ' . $request->alasan_penolakan,
        'approved_by'      => $admin->id,
        'approved_at'      => null,
    ]);

    return redirect()->route('admin.anggota.index')
        ->with('success', 'Anggota berhasil ditolak!');
}


    public function destroy(Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus anggota ini.');
        }

        // Hapus file-file terkait
        if ($anggota->foto_ktp) Storage::disk('public')->delete($anggota->foto_ktp);
        if ($anggota->foto_diri) Storage::disk('public')->delete($anggota->foto_diri);
        if ($anggota->profile_perusahaan) Storage::disk('public')->delete($anggota->profile_perusahaan);
        if ($anggota->logo_perusahaan) Storage::disk('public')->delete($anggota->logo_perusahaan);

        $anggota->delete();

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil dihapus!');
    }
    // NEW METHOD: Promote anggota menjadi admin (hanya Super Admin)
    public function promoteToAdmin(Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        // Hanya Super Admin yang bisa promote
        if (!$admin->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan aksi ini.');
        }

        // Anggota harus sudah approved
        if ($anggota->status !== 'approved') {
            return redirect()->back()->with('error', 'Hanya anggota yang sudah disetujui yang bisa dipromosikan menjadi admin.');
        }

        // List domisili untuk dropdown
        $domisiliList = Admin::where('category', 'bpc')
            ->whereNotNull('domisili')
            ->orderBy('domisili')
            ->pluck('domisili')
            ->unique()
            ->values();

        return view('admin.anggota.promote', compact('anggota', 'domisiliList'));
    }

    // NEW METHOD: Store promoted admin
    public function storePromotedAdmin(Request $request, Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        // Hanya Super Admin yang bisa promote
        if (!$admin->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan aksi ini.');
        }

        // Anggota harus sudah approved
        if ($anggota->status !== 'approved') {
            return redirect()->back()->with('error', 'Hanya anggota yang sudah disetujui yang bisa dipromosikan menjadi admin.');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'category' => 'required|in:bpc,bpd',
            'domisili' => 'required_if:category,bpc|nullable|string|max:255',
        ], [
            'domisili.required_if' => 'Domisili wajib diisi untuk BPC.',
        ]);

        // Create admin dari data anggota
        Admin::create([
            'name' => $anggota->nama_usaha,
            'username' => $validated['username'],
            'email' => $anggota->email,
            'password' => Hash::make($validated['password']),
            'category' => $validated['category'],
            'domisili' => $validated['category'] === 'bpc' ? $validated['domisili'] : null,
        ]);

        return redirect()->route('admin.anggota.list')
            ->with('success', "Anggota {$anggota->nama_usaha} berhasil dipromosikan menjadi admin!");
    }
    /**
     * ✨ NEW: Tampilkan form create anggota baru
     */
    public function create()
    {
        $admin = auth()->guard('admin')->user();

        // Hanya BPC dan Super Admin yang bisa create
        if ($admin->category === 'bpd') {
            abort(403, 'BPD tidak memiliki akses untuk membuat anggota baru.');
        }

        // Untuk Super Admin, tampilkan dropdown domisili
        $domisiliList = null;
        if ($admin->isSuperAdmin()) {
            $domisiliList = Admin::where('category', 'bpc')
                ->whereNotNull('domisili')
                ->orderBy('domisili')
                ->pluck('domisili')
                ->unique()
                ->values();
        }

        return view('admin.anggota.create', compact('admin', 'domisiliList'));
    }

    /**
     * ✨ NEW: Store anggota baru (dibuat oleh Admin)
     */
    public function storeByAdmin(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        // Hanya BPC dan Super Admin yang bisa create
        if ($admin->category === 'bpd') {
            abort(403, 'BPD tidak memiliki akses untuk membuat anggota baru.');
        }

        $validator = Validator::make($request->all(), [
            // Data Pribadi
            'nama_usaha' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'domisili' => 'required|string|max:255',
            'alamat_domisili' => 'required|string',
            'kode_pos' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:anggota,email',
            'nomor_ktp' => 'required|string|size:16',
            'foto_ktp' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'foto_diri' => 'required|image|mimes:jpeg,jpg,png|max:2048',

            // Profile Perusahaan
            'nama_usaha_perusahaan' => 'required|string|max:255',
            'legalitas_usaha' => 'required|in:PT,CV,PT Perorangan',
            'jabatan_usaha' => 'required|string|max:255',
            'alamat_kantor' => 'required|string',
            'bidang_usaha' => 'required|string',
            'brand_usaha' => 'required|string|max:255',
            'jumlah_karyawan' => 'required|integer|min:0',
            'nomor_ktp_perusahaan' => 'required|string|size:16',
            'usia_perusahaan' => 'required|string',
            'omset_perusahaan' => 'required|string',
            'npwp_perusahaan' => 'required|string|max:255',
            'no_nota_pendirian' => 'required|string|max:255',
            'profile_perusahaan' => 'required|mimes:pdf|max:5120',
            'logo_perusahaan' => 'required|image|mimes:jpeg,jpg,png|max:2048',

            // Organisasi
            'sfc_hipmi' => 'required|string|max:255',
            'referensi_hipmi' => 'required|in:Ya,Tidak',
            'organisasi_lain' => 'required|in:Ya,Tidak',
        ], [
            'required' => ':attribute wajib diisi.',
            'email' => 'Format email tidak valid.',
            'unique' => 'Email sudah terdaftar.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berformat :values.',
            'max' => ':attribute maksimal :max KB.',
            'size' => ':attribute harus :size karakter.',
            'integer' => ':attribute harus berupa angka.',
            'in' => ':attribute tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload files
            $fotoKtpPath = $request->file('foto_ktp')->store('anggota/ktp', 'public');
            $fotoDiriPath = $request->file('foto_diri')->store('anggota/foto', 'public');
            $profilePath = $request->file('profile_perusahaan')->store('anggota/profile', 'public');
            $logoPath = $request->file('logo_perusahaan')->store('anggota/logo', 'public');

            // Generate random password
            $randomPassword = Str::random(12);

            // Simpan data ke database
            $anggota = Anggota::create([
                // Data Pribadi
                'nama_usaha' => $request->nama_usaha,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'nomor_telepon' => $request->nomor_telepon,
                'domisili' => $request->domisili,
                'alamat_domisili' => $request->alamat_domisili,
                'kode_pos' => $request->kode_pos,
                'email' => $request->email,
                'password' => Hash::make($randomPassword),
                'initial_password' => $randomPassword,
                'nomor_ktp' => $request->nomor_ktp,
                'foto_ktp' => $fotoKtpPath,
                'foto_diri' => $fotoDiriPath,

                // Profile Perusahaan
                'nama_usaha_perusahaan' => $request->nama_usaha_perusahaan,
                'legalitas_usaha' => $request->legalitas_usaha,
                'jabatan_usaha' => $request->jabatan_usaha,
                'alamat_kantor' => $request->alamat_kantor,
                'bidang_usaha' => $request->bidang_usaha,
                'brand_usaha' => $request->brand_usaha,
                'jumlah_karyawan' => $request->jumlah_karyawan,
                'nomor_ktp_perusahaan' => $request->nomor_ktp_perusahaan,
                'usia_perusahaan' => $request->usia_perusahaan,
                'omset_perusahaan' => $request->omset_perusahaan,
                'npwp_perusahaan' => $request->npwp_perusahaan,
                'no_nota_pendirian' => $request->no_nota_pendirian,
                'profile_perusahaan' => $profilePath,
                'logo_perusahaan' => $logoPath,

                // Organisasi
                'sfc_hipmi' => $request->sfc_hipmi,
                'referensi_hipmi' => $request->referensi_hipmi,
                'organisasi_lain' => $request->organisasi_lain,

                // Status default pending
                'status' => 'pending',
            ]);

            // Redirect dengan pesan sukses
            return redirect()
                ->route('admin.anggota.index')
                ->with('success', "Anggota {$anggota->nama_usaha} berhasil ditambahkan!")
                ->with('show_password', true)
                ->with('generated_password', $randomPassword)
                ->with('user_email', $anggota->email);
        } catch (\Exception $e) {
            // Hapus file yang sudah diupload jika ada error
            if (isset($fotoKtpPath)) Storage::disk('public')->delete($fotoKtpPath);
            if (isset($fotoDiriPath)) Storage::disk('public')->delete($fotoDiriPath);
            if (isset($profilePath)) Storage::disk('public')->delete($profilePath);
            if (isset($logoPath)) Storage::disk('public')->delete($logoPath);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
/**
     * ✨ NEW: Tampilkan form edit anggota
     */
    public function edit(Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        // BPC hanya bisa edit anggota di domisilinya
        if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit anggota ini.');
        }

        // BPD tidak boleh edit
        if ($admin->category === 'bpd') {
            abort(403, 'BPD tidak memiliki akses untuk mengedit data anggota.');
        }

        // Untuk Super Admin, tampilkan dropdown domisili
        $domisiliList = null;
        if ($admin->isSuperAdmin()) {
            $domisiliList = Admin::where('category', 'bpc')
                ->whereNotNull('domisili')
                ->orderBy('domisili')
                ->pluck('domisili')
                ->unique()
                ->values();
        }

        return view('admin.anggota.edit', compact('anggota', 'admin', 'domisiliList'));
    }

    /**
     * ✨ NEW: Update data anggota
     */
    public function update(Request $request, Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        // BPC hanya bisa edit anggota di domisilinya
        if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit anggota ini.');
        }

        // BPD tidak boleh edit
        if ($admin->category === 'bpd') {
            abort(403, 'BPD tidak memiliki akses untuk mengedit data anggota.');
        }

        $validator = Validator::make($request->all(), [
            // Data Pribadi
            'nama_usaha' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'domisili' => 'required|string|max:255',
            'alamat_domisili' => 'required|string',
            'kode_pos' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:anggota,email,' . $anggota->id,
            'nomor_ktp' => 'required|string|size:16',
            'foto_ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'foto_diri' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',

            // Profile Perusahaan
            'nama_usaha_perusahaan' => 'required|string|max:255',
            'legalitas_usaha' => 'required|in:PT,CV,PT Perorangan',
            'jabatan_usaha' => 'required|string|max:255',
            'alamat_kantor' => 'required|string',
            'bidang_usaha' => 'required|string',
            'brand_usaha' => 'required|string|max:255',
            'jumlah_karyawan' => 'required|integer|min:0',
            'nomor_ktp_perusahaan' => 'required|string|size:16',
            'usia_perusahaan' => 'required|string',
            'omset_perusahaan' => 'required|string',
            'npwp_perusahaan' => 'required|string|max:255',
            'no_nota_pendirian' => 'required|string|max:255',
            'profile_perusahaan' => 'nullable|mimes:pdf|max:5120',
            'logo_perusahaan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',

            // Detail Buku
            'detail_image_1' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'detail_image_2' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'detail_image_3' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi_detail' => 'nullable|string',

            // Organisasi
            'sfc_hipmi' => 'required|string|max:255',
            'referensi_hipmi' => 'required|in:Ya,Tidak',
            'organisasi_lain' => 'required|in:Ya,Tidak',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except(['foto_ktp', 'foto_diri', 'profile_perusahaan', 'logo_perusahaan', 'detail_image_1', 'detail_image_2', 'detail_image_3']);

            // Handle foto KTP
            if ($request->hasFile('foto_ktp')) {
                if ($anggota->foto_ktp) {
                    Storage::disk('public')->delete($anggota->foto_ktp);
                }
                $data['foto_ktp'] = $request->file('foto_ktp')->store('anggota/ktp', 'public');
            }

            // Handle foto diri
            if ($request->hasFile('foto_diri')) {
                if ($anggota->foto_diri) {
                    Storage::disk('public')->delete($anggota->foto_diri);
                }
                $data['foto_diri'] = $request->file('foto_diri')->store('anggota/foto', 'public');
            }

            // Handle profile perusahaan
            if ($request->hasFile('profile_perusahaan')) {
                if ($anggota->profile_perusahaan) {
                    Storage::disk('public')->delete($anggota->profile_perusahaan);
                }
                $data['profile_perusahaan'] = $request->file('profile_perusahaan')->store('anggota/profile', 'public');
            }

            // Handle logo perusahaan
            if ($request->hasFile('logo_perusahaan')) {
                if ($anggota->logo_perusahaan) {
                    Storage::disk('public')->delete($anggota->logo_perusahaan);
                }
                $data['logo_perusahaan'] = $request->file('logo_perusahaan')->store('anggota/logo', 'public');
            }

            // Handle detail images
            if ($request->hasFile('detail_image_1')) {
                if ($anggota->detail_image_1) {
                    Storage::disk('public')->delete($anggota->detail_image_1);
                }
                $data['detail_image_1'] = $request->file('detail_image_1')->store('anggota/detail', 'public');
            }

            if ($request->hasFile('detail_image_2')) {
                if ($anggota->detail_image_2) {
                    Storage::disk('public')->delete($anggota->detail_image_2);
                }
                $data['detail_image_2'] = $request->file('detail_image_2')->store('anggota/detail', 'public');
            }

            if ($request->hasFile('detail_image_3')) {
                if ($anggota->detail_image_3) {
                    Storage::disk('public')->delete($anggota->detail_image_3);
                }
                $data['detail_image_3'] = $request->file('detail_image_3')->store('anggota/detail', 'public');
            }

            // Update data
            $anggota->update($data);

            return redirect()
                ->route('admin.anggota.show', $anggota)
                ->with('success', "Data anggota {$anggota->nama_usaha} berhasil diperbarui!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * ✨ NEW: Reset password anggota
     */
    public function resetPassword(Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        // Hanya Super Admin atau BPC yang bisa reset password
        if ($admin->category === 'bpd') {
            abort(403, 'BPD tidak memiliki akses untuk reset password.');
        }

        if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
            abort(403, 'Anda tidak memiliki akses untuk reset password anggota ini.');
        }

        // Generate password baru
        $newPassword = Str::random(12);

        $anggota->update([
            'password' => Hash::make($newPassword),
            'initial_password' => $newPassword,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Password berhasil direset!')
            ->with('show_password', true)
            ->with('generated_password', $newPassword)
            ->with('user_email', $anggota->email);
    }

    /**
     * ✨ NEW: Hapus gambar detail
     */
    public function deleteDetailImage(Request $request, Anggota $anggota)
    {
        $admin = auth()->guard('admin')->user();

        // Validasi akses
        if ($admin->category === 'bpd') {
            abort(403, 'BPD tidak memiliki akses untuk menghapus gambar.');
        }

        if ($admin->category === 'bpc' && $anggota->domisili !== $admin->domisili) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus gambar anggota ini.');
        }

        $imageField = $request->input('image_field');

        if (!in_array($imageField, ['detail_image_1', 'detail_image_2', 'detail_image_3'])) {
            return back()->with('error', 'Invalid image field.');
        }

        try {
            if ($anggota->$imageField) {
                Storage::disk('public')->delete($anggota->$imageField);
                $anggota->update([$imageField => null]);
                return back()->with('success', 'Gambar berhasil dihapus!');
            }

            return back()->with('error', 'Gambar tidak ditemukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
