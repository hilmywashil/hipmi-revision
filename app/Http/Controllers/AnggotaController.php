<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    public function show(Anggota $anggota)
    {
        if ($anggota->status !== 'approved') {
            abort(404, 'Anggota tidak ditemukan atau belum diverifikasi.');
        }

        return view('pages.details.buku-detail', compact('anggota'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Data Pribadi
            'nama_usaha'            => 'required|string|max:255',
            'jenis_kelamin'         => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'agama'                 => 'required|string|max:255',
            'nomor_telepon'         => 'required|string|max:20',
            'domisili'              => 'required|string|max:255',
            'alamat_domisili'       => 'required|string',
            'kode_pos'              => 'required|string|max:10',
            'email'                 => 'required|email|max:255|unique:anggota,email',
            'nomor_ktp'             => 'required|string|size:16',
            'foto_ktp'              => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'foto_diri'             => 'required|image|mimes:jpeg,jpg,png|max:2048',

            // Profile Perusahaan
            'nama_usaha_perusahaan' => 'required|string|max:255',
            'legalitas_usaha'       => 'required|in:PT,CV,PT Perorangan',
            'jabatan_usaha'         => 'required|string|max:255',
            'alamat_kantor'         => 'required|string',
            'bidang_usaha'          => 'required|string',
            'brand_usaha'           => 'required|string|max:255',
            'jumlah_karyawan'       => 'required|integer|min:0',
            'nomor_ktp_perusahaan'  => 'required|string|size:16',
            'usia_perusahaan'       => 'required|string',
            'omset_perusahaan'      => 'required|string',
            'npwp_perusahaan'       => 'required|string|max:255',
            'no_nota_pendirian'     => 'required|string|max:255',
            'profile_perusahaan'    => 'required|mimes:pdf|max:5120',
            'logo_perusahaan'       => 'required|image|mimes:jpeg,jpg,png|max:2048',

            // Organisasi
            'sfc_hipmi'             => 'required|string|max:255',
            'referensi_hipmi'       => 'required|in:Ya,Tidak',
            'organisasi_lain'       => 'required|in:Ya,Tidak',
            'pernyataan'            => 'required|accepted',
        ], [
            'required'  => ':attribute wajib diisi.',
            'email'     => 'Format email tidak valid.',
            'unique'    => 'Email sudah terdaftar.',
            'image'     => ':attribute harus berupa gambar.',
            'mimes'     => ':attribute harus berformat :values.',
            'max'       => ':attribute maksimal :max KB.',
            'size'      => ':attribute harus :size karakter.',
            'integer'   => ':attribute harus berupa angka.',
            'in'        => ':attribute tidak valid.',
            'accepted'  => 'Anda harus menyetujui pernyataan ini.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload files
            $fotoKtpPath  = $request->file('foto_ktp')->store('anggota/ktp', 'public');
            $fotoDiriPath = $request->file('foto_diri')->store('anggota/foto', 'public');
            $profilePath  = $request->file('profile_perusahaan')->store('anggota/profile', 'public');
            $logoPath     = $request->file('logo_perusahaan')->store('anggota/logo', 'public');

            // Generate random password
            $randomPassword = Str::random(12);

            // Simpan data anggota
            $anggota = Anggota::create([
                'nama_usaha'            => $request->nama_usaha,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'tempat_lahir'          => $request->tempat_lahir,
                'tanggal_lahir'         => $request->tanggal_lahir,
                'agama'                 => $request->agama,
                'nomor_telepon'         => $request->nomor_telepon,
                'domisili'              => $request->domisili,
                'alamat_domisili'       => $request->alamat_domisili,
                'kode_pos'              => $request->kode_pos,
                'email'                 => $request->email,
                'password'              => Hash::make($randomPassword),
                'initial_password'      => $randomPassword,
                'nomor_ktp'             => $request->nomor_ktp,
                'foto_ktp'              => $fotoKtpPath,
                'foto_diri'             => $fotoDiriPath,
                'nama_usaha_perusahaan' => $request->nama_usaha_perusahaan,
                'legalitas_usaha'       => $request->legalitas_usaha,
                'jabatan_usaha'         => $request->jabatan_usaha,
                'alamat_kantor'         => $request->alamat_kantor,
                'bidang_usaha'          => $request->bidang_usaha,
                'brand_usaha'           => $request->brand_usaha,
                'jumlah_karyawan'       => $request->jumlah_karyawan,
                'nomor_ktp_perusahaan'  => $request->nomor_ktp_perusahaan,
                'usia_perusahaan'       => $request->usia_perusahaan,
                'omset_perusahaan'      => $request->omset_perusahaan,
                'npwp_perusahaan'       => $request->npwp_perusahaan,
                'no_nota_pendirian'     => $request->no_nota_pendirian,
                'profile_perusahaan'    => $profilePath,
                'logo_perusahaan'       => $logoPath,
                'sfc_hipmi'             => $request->sfc_hipmi,
                'referensi_hipmi'       => $request->referensi_hipmi,
                'organisasi_lain'       => $request->organisasi_lain,
                'status'                => 'pending',
            ]);

            // =====================================================
            // AUTO-CREATE KATALOG dari data pendaftaran
            // =====================================================
            // Logo katalog pakai file yang sama dengan logo_perusahaan
            // Kita copy ke folder katalog supaya tidak bentrok saat dihapus
            $katalogLogoPath = $request->file('logo_perusahaan')->store('katalog/logos', 'public');

            Katalog::create([
                'anggota_id'     => $anggota->id,
                'company_name'   => $request->nama_usaha_perusahaan,
                'business_field' => $request->bidang_usaha,
                // Description belum ada di form daftar, isi placeholder dulu
                // Anggota bisa edit nanti lewat halaman katalog
                'description'    => 'Deskripsi perusahaan belum diisi. Silakan lengkapi melalui menu Katalog Saya.',
                'logo'           => $katalogLogoPath,
                'images'         => [],
                'address'        => $request->alamat_kantor,
                'phone'          => $request->nomor_telepon,
                'email'          => $request->email,
                'map_embed_url'  => null,
                'status'         => 'pending',
                'submitted_at'   => now(),
                'is_active'      => false,
            ]);
            // =====================================================

            // Auto login
            Auth::guard('anggota')->login($anggota);

            session()->flash('generated_password', $randomPassword);
            session()->flash('user_email', $anggota->email);

            return redirect()->route('registration-success');

        } catch (\Exception $e) {
            if (isset($fotoKtpPath))  Storage::disk('public')->delete($fotoKtpPath);
            if (isset($fotoDiriPath)) Storage::disk('public')->delete($fotoDiriPath);
            if (isset($profilePath))  Storage::disk('public')->delete($profilePath);
            if (isset($logoPath))     Storage::disk('public')->delete($logoPath);
            if (isset($katalogLogoPath)) Storage::disk('public')->delete($katalogLogoPath);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function profile()
    {
        $anggota = Auth::guard('anggota')->user();

        if (!$anggota) {
            return redirect()->route('anggota.login')
                ->with('error', 'Anda harus login terlebih dahulu.');
        }

        $anggota->load('admin');

        return view('pages.profile-anggota', compact('anggota'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.min'          => 'Password baru minimal 6 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $anggota = Auth::guard('anggota')->user();

        if (!Hash::check($request->current_password, $anggota->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $anggota->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function updateProfile(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        $validator = Validator::make($request->all(), [
            'nama_usaha'      => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'    => 'required|string|max:255',
            'tanggal_lahir'   => 'required|date',
            'agama'           => 'required|string|max:255',
            'nomor_telepon'   => 'required|string|max:20',
            'domisili'        => 'required|string|max:255',
            'alamat_domisili' => 'required|string',
            'kode_pos'        => 'required|string|max:10',
            'email'           => 'required|email|max:255|unique:anggota,email,' . $anggota->id,
            'foto_diri'       => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except(['foto_diri']);

            if ($request->hasFile('foto_diri')) {
                if ($anggota->foto_diri) {
                    Storage::disk('public')->delete($anggota->foto_diri);
                }
                $data['foto_diri'] = $request->file('foto_diri')->store('anggota/foto', 'public');
            }

            $anggota->update($data);

            return back()->with('success', 'Data pribadi berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateCompany(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        $validator = Validator::make($request->all(), [
            'nama_usaha_perusahaan' => 'required|string|max:255',
            'legalitas_usaha'       => 'required|in:PT,CV,PT Perorangan',
            'jabatan_usaha'         => 'required|string|max:255',
            'alamat_kantor'         => 'required|string',
            'bidang_usaha'          => 'required|string',
            'brand_usaha'           => 'required|string|max:255',
            'jumlah_karyawan'       => 'required|integer|min:0',
            'usia_perusahaan'       => 'required|string',
            'omset_perusahaan'      => 'required|string',
            'npwp_perusahaan'       => 'required|string|max:255',
            'no_nota_pendirian'     => 'required|string|max:255',
            'logo_perusahaan'       => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'profile_perusahaan'    => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except(['logo_perusahaan', 'profile_perusahaan']);

            if ($request->hasFile('logo_perusahaan')) {
                if ($anggota->logo_perusahaan) {
                    Storage::disk('public')->delete($anggota->logo_perusahaan);
                }
                $data['logo_perusahaan'] = $request->file('logo_perusahaan')->store('anggota/logo', 'public');
            }

            if ($request->hasFile('profile_perusahaan')) {
                if ($anggota->profile_perusahaan) {
                    Storage::disk('public')->delete($anggota->profile_perusahaan);
                }
                $data['profile_perusahaan'] = $request->file('profile_perusahaan')->store('anggota/profile', 'public');
            }

            $anggota->update($data);

            return back()->with('success', 'Data perusahaan berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function uploadDetailImages(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        $validator = Validator::make($request->all(), [
            'detail_image_1'  => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'detail_image_2'  => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'detail_image_3'  => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi_detail'=> 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $data = [];

            foreach (['detail_image_1', 'detail_image_2', 'detail_image_3'] as $field) {
                if ($request->hasFile($field)) {
                    if ($anggota->$field) {
                        Storage::disk('public')->delete($anggota->$field);
                    }
                    $data[$field] = $request->file($field)->store('anggota/detail', 'public');
                }
            }

            if ($request->filled('deskripsi_detail')) {
                $data['deskripsi_detail'] = $request->deskripsi_detail;
            }

            if (!empty($data)) {
                $anggota->update($data);
                return back()->with('success', 'Gambar detail berhasil diupload!');
            }

            return back()->with('error', 'Tidak ada perubahan yang dilakukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteDetailImage(Request $request)
    {
        $anggota    = Auth::guard('anggota')->user();
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

    public function changeAdminPassword(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        if (!$anggota->admin) {
            return back()->with('error', 'Anda tidak memiliki akun admin.');
        }

        $admin = $anggota->admin;

        if ($admin->initial_password) {
            $request->validate([
                'new_admin_password' => 'required|min:8|confirmed',
            ], [
                'new_admin_password.required'  => 'Password baru wajib diisi.',
                'new_admin_password.min'       => 'Password baru minimal 8 karakter.',
                'new_admin_password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]);

            $admin->update([
                'password'         => Hash::make($request->new_admin_password),
                'initial_password' => null,
            ]);

            return back()->with('success', 'Password admin berhasil diubah! Initial password telah dihapus untuk keamanan.');
        } else {
            $request->validate([
                'current_admin_password' => 'required',
                'new_admin_password'     => 'required|min:8|confirmed',
            ], [
                'current_admin_password.required' => 'Password lama wajib diisi.',
                'new_admin_password.required'     => 'Password baru wajib diisi.',
                'new_admin_password.min'          => 'Password baru minimal 8 karakter.',
                'new_admin_password.confirmed'    => 'Konfirmasi password tidak cocok.',
            ]);

            if (!Hash::check($request->current_admin_password, $admin->password)) {
                return back()->with('error', 'Password admin lama tidak sesuai.');
            }

            $admin->update(['password' => Hash::make($request->new_admin_password)]);

            return back()->with('success', 'Password admin berhasil diubah!');
        }
    }

    public function destroy(Anggota $anggota)
    {
        try {
            $namaAnggota = $anggota->nama_usaha;

            $fields = [
                'foto_ktp', 'foto_diri', 'logo_perusahaan',
                'profile_perusahaan', 'detail_image_1', 'detail_image_2', 'detail_image_3',
            ];

            foreach ($fields as $field) {
                if ($anggota->$field) {
                    Storage::disk('public')->delete($anggota->$field);
                }
            }

            $anggota->delete();

            return redirect()
                ->route('admin.anggota.list')
                ->with('success', "Anggota {$namaAnggota} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.anggota.list')
                ->with('error', 'Gagal menghapus anggota: ' . $e->getMessage());
        }
    }
}