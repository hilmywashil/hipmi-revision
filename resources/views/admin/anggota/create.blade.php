@extends('admin.layouts.admin-layout')

@section('title', 'Tambah Anggota Baru')
@section('page-title', 'Tambah Anggota Baru')

@php
$activeMenu = 'anggota';
$admin = auth()->guard('admin')->user();
@endphp

@push('styles')
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .form-section {
        margin-bottom: 3rem;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0a2540;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title svg {
        width: 28px;
        height: 28px;
        stroke: #0a2540;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-grid.single {
        grid-template-columns: 1fr;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .form-label .required {
        color: #dc2626;
        margin-left: 0.25rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        font-family: 'Montserrat', sans-serif;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #0a2540;
        box-shadow: 0 0 0 3px rgba(10, 37, 64, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-file {
        display: none;
    }

    .file-upload-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-upload-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: #f3f4f6;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
        color: #6b7280;
    }

    .file-upload-label:hover {
        background: #e5e7eb;
        border-color: #9ca3af;
    }

    .file-upload-label svg {
        width: 20px;
        height: 20px;
    }

    .file-name {
        color: #6b7280;
        font-size: 0.875rem;
        font-style: italic;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: none;
        font-family: 'Montserrat', sans-serif;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0a2540 0%, #1a4068 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(10, 37, 64, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(10, 37, 64, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #6b7280;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }

    .alert-error svg {
        width: 20px;
        height: 20px;
        stroke: #dc2626;
        flex-shrink: 0;
    }

    .error-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .error-list li {
        padding: 0.25rem 0;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        text-decoration: none;
        margin-bottom: 1.5rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #0a2540;
    }

    .back-link svg {
        width: 20px;
        height: 20px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<a href="{{ route('admin.anggota.list') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"></polyline>
    </svg>
    Kembali ke Daftar Anggota
</a>

@if($errors->any())
<div class="alert alert-error">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
    <div>
        <strong>Terjadi kesalahan:</strong>
        <ul class="error-list">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- SECTION 1: Data Pribadi --}}
    <div class="form-container">
        <div class="form-section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Data Pribadi
            </h2>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_usaha" class="form-input" value="{{ old('nama_usaha') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tempat Lahir <span class="required">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-input" value="{{ old('tempat_lahir') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Agama <span class="required">*</span></label>
                    <select name="agama" class="form-select" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                    <input type="tel" name="nomor_telepon" class="form-input" value="{{ old('nomor_telepon') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor KTP <span class="required">*</span></label>
                    <input type="text" name="nomor_ktp" class="form-input" value="{{ old('nomor_ktp') }}" maxlength="16" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Domisili <span class="required">*</span></label>
                    @if($admin->isSuperAdmin())
                    {{-- Super Admin bisa pilih semua domisili --}}
                    <select name="domisili" class="form-select" required>
                        <option value="">Pilih Domisili</option>

                        {{-- KABUPATEN (18) --}}
                        <optgroup label="Kabupaten">
                            <option value="Bandung" {{ old('domisili') == 'Bandung' ? 'selected' : '' }}>Kabupaten Bandung</option>
                            <option value="Bandung Barat" {{ old('domisili') == 'Bandung Barat' ? 'selected' : '' }}>Kabupaten Bandung Barat</option>
                            <option value="Bekasi" {{ old('domisili') == 'Bekasi' ? 'selected' : '' }}>Kabupaten Bekasi</option>
                            <option value="Bogor" {{ old('domisili') == 'Bogor' ? 'selected' : '' }}>Kabupaten Bogor</option>
                            <option value="Ciamis" {{ old('domisili') == 'Ciamis' ? 'selected' : '' }}>Kabupaten Ciamis</option>
                            <option value="Cianjur" {{ old('domisili') == 'Cianjur' ? 'selected' : '' }}>Kabupaten Cianjur</option>
                            <option value="Cirebon" {{ old('domisili') == 'Cirebon' ? 'selected' : '' }}>Kabupaten Cirebon</option>
                            <option value="Garut" {{ old('domisili') == 'Garut' ? 'selected' : '' }}>Kabupaten Garut</option>
                            <option value="Indramayu" {{ old('domisili') == 'Indramayu' ? 'selected' : '' }}>Kabupaten Indramayu</option>
                            <option value="Karawang" {{ old('domisili') == 'Karawang' ? 'selected' : '' }}>Kabupaten Karawang</option>
                            <option value="Kuningan" {{ old('domisili') == 'Kuningan' ? 'selected' : '' }}>Kabupaten Kuningan</option>
                            <option value="Majalengka" {{ old('domisili') == 'Majalengka' ? 'selected' : '' }}>Kabupaten Majalengka</option>
                            <option value="Pangandaran" {{ old('domisili') == 'Pangandaran' ? 'selected' : '' }}>Kabupaten Pangandaran</option>
                            <option value="Purwakarta" {{ old('domisili') == 'Purwakarta' ? 'selected' : '' }}>Kabupaten Purwakarta</option>
                            <option value="Subang" {{ old('domisili') == 'Subang' ? 'selected' : '' }}>Kabupaten Subang</option>
                            <option value="Sukabumi" {{ old('domisili') == 'Sukabumi' ? 'selected' : '' }}>Kabupaten Sukabumi</option>
                            <option value="Sumedang" {{ old('domisili') == 'Sumedang' ? 'selected' : '' }}>Kabupaten Sumedang</option>
                            <option value="Tasikmalaya" {{ old('domisili') == 'Tasikmalaya' ? 'selected' : '' }}>Kabupaten Tasikmalaya</option>
                        </optgroup>

                        {{-- KOTA (9) --}}
                        <optgroup label="Kota">
                            <option value="Kota Bandung" {{ old('domisili') == 'Kota Bandung' ? 'selected' : '' }}>Kota Bandung</option>
                            <option value="Kota Banjar" {{ old('domisili') == 'Kota Banjar' ? 'selected' : '' }}>Kota Banjar</option>
                            <option value="Kota Bekasi" {{ old('domisili') == 'Kota Bekasi' ? 'selected' : '' }}>Kota Bekasi</option>
                            <option value="Kota Bogor" {{ old('domisili') == 'Kota Bogor' ? 'selected' : '' }}>Kota Bogor</option>
                            <option value="Kota Cimahi" {{ old('domisili') == 'Kota Cimahi' ? 'selected' : '' }}>Kota Cimahi</option>
                            <option value="Kota Cirebon" {{ old('domisili') == 'Kota Cirebon' ? 'selected' : '' }}>Kota Cirebon</option>
                            <option value="Kota Depok" {{ old('domisili') == 'Kota Depok' ? 'selected' : '' }}>Kota Depok</option>
                            <option value="Kota Sukabumi" {{ old('domisili') == 'Kota Sukabumi' ? 'selected' : '' }}>Kota Sukabumi</option>
                            <option value="Kota Tasikmalaya" {{ old('domisili') == 'Kota Tasikmalaya' ? 'selected' : '' }}>Kota Tasikmalaya</option>
                        </optgroup>
                    </select>
                    @else
                    {{-- BPC: Domisili otomatis sesuai domisili admin (readonly) --}}
                    <input type="text" name="domisili" class="form-input" value="{{ $admin->domisili }}" readonly style="background-color: #f3f4f6; cursor: not-allowed;">
                    <small style="display: block; margin-top: 0.5rem; color: #6b7280; font-size: 0.875rem;">
                        Domisili otomatis sesuai dengan wilayah Anda ({{ $admin->domisili }})
                    </small>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Pos <span class="required">*</span></label>
                    <input type="text" name="kode_pos" class="form-input" value="{{ old('kode_pos') }}" required>
                </div>
            </div>

            <div class="form-grid single" style="margin-top: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Alamat Domisili <span class="required">*</span></label>
                    <textarea name="alamat_domisili" class="form-textarea" required>{{ old('alamat_domisili') }}</textarea>
                </div>
            </div>

            <div class="form-grid" style="margin-top: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Foto KTP <span class="required">*</span></label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="foto_ktp" class="form-file" id="foto_ktp" accept="image/*" required onchange="updateFileName(this, 'ktp-name')">
                        <label for="foto_ktp" class="file-upload-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Pilih File
                        </label>
                        <span class="file-name" id="ktp-name">Belum ada file dipilih</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Diri <span class="required">*</span></label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="foto_diri" class="form-file" id="foto_diri" accept="image/*" required onchange="updateFileName(this, 'diri-name')">
                        <label for="foto_diri" class="file-upload-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Pilih File
                        </label>
                        <span class="file-name" id="diri-name">Belum ada file dipilih</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: Data Perusahaan --}}
    <div class="form-container">
        <div class="form-section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                Data Perusahaan
            </h2>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Usaha/Perusahaan <span class="required">*</span></label>
                    <input type="text" name="nama_usaha_perusahaan" class="form-input" value="{{ old('nama_usaha_perusahaan') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Legalitas Usaha <span class="required">*</span></label>
                    <select name="legalitas_usaha" class="form-select" required>
                        <option value="">Pilih Legalitas</option>
                        <option value="PT" {{ old('legalitas_usaha') == 'PT' ? 'selected' : '' }}>PT</option>
                        <option value="CV" {{ old('legalitas_usaha') == 'CV' ? 'selected' : '' }}>CV</option>
                        <option value="PT Perorangan" {{ old('legalitas_usaha') == 'PT Perorangan' ? 'selected' : '' }}>PT Perorangan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Jabatan <span class="required">*</span></label>
                    <input type="text" name="jabatan_usaha" class="form-input" value="{{ old('jabatan_usaha') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Bidang Usaha <span class="required">*</span></label>
                    <input type="text" name="bidang_usaha" class="form-input" value="{{ old('bidang_usaha') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Brand Usaha <span class="required">*</span></label>
                    <input type="text" name="brand_usaha" class="form-input" value="{{ old('brand_usaha') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah Karyawan <span class="required">*</span></label>
                    <input type="number" name="jumlah_karyawan" class="form-input" value="{{ old('jumlah_karyawan') }}" min="0" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor KTP Perusahaan <span class="required">*</span></label>
                    <input type="text" name="nomor_ktp_perusahaan" class="form-input" value="{{ old('nomor_ktp_perusahaan') }}" maxlength="16" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Usia Perusahaan <span class="required">*</span></label>
                    <input type="text" name="usia_perusahaan" class="form-input" value="{{ old('usia_perusahaan') }}" placeholder="Contoh: 5 tahun" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Omset Perusahaan <span class="required">*</span></label>
                    <input type="text" name="omset_perusahaan" class="form-input" value="{{ old('omset_perusahaan') }}" placeholder="Contoh: 500 juta/tahun" required>
                </div>

                <div class="form-group">
                    <label class="form-label">NPWP Perusahaan <span class="required">*</span></label>
                    <input type="text" name="npwp_perusahaan" class="form-input" value="{{ old('npwp_perusahaan') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">No. Nota Pendirian <span class="required">*</span></label>
                    <input type="text" name="no_nota_pendirian" class="form-input" value="{{ old('no_nota_pendirian') }}" required>
                </div>
            </div>

            <div class="form-grid single" style="margin-top: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Alamat Kantor <span class="required">*</span></label>
                    <textarea name="alamat_kantor" class="form-textarea" required>{{ old('alamat_kantor') }}</textarea>
                </div>
            </div>

            <div class="form-grid" style="margin-top: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Logo Perusahaan <span class="required">*</span></label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="logo_perusahaan" class="form-file" id="logo_perusahaan" accept="image/*" required onchange="updateFileName(this, 'logo-name')">
                        <label for="logo_perusahaan" class="file-upload-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Pilih File
                        </label>
                        <span class="file-name" id="logo-name">Belum ada file dipilih</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Profile Perusahaan (PDF) <span class="required">*</span></label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="profile_perusahaan" class="form-file" id="profile_perusahaan" accept=".pdf" required onchange="updateFileName(this, 'profile-name')">
                        <label for="profile_perusahaan" class="file-upload-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Pilih File
                        </label>
                        <span class="file-name" id="profile-name">Belum ada file dipilih</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 3: Data Organisasi --}}
    <div class="form-container">
        <div class="form-section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Data Organisasi
            </h2>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">SFC HIPMI <span class="required">*</span></label>
                    <input type="text" name="sfc_hipmi" class="form-input" value="{{ old('sfc_hipmi') }}" placeholder="Masukkan kode SFC" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Referensi HIPMI <span class="required">*</span></label>
                    <select name="referensi_hipmi" class="form-select" required>
                        <option value="">Pilih</option>
                        <option value="Ya" {{ old('referensi_hipmi') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('referensi_hipmi') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Organisasi Lain <span class="required">*</span></label>
                    <select name="organisasi_lain" class="form-select" required>
                        <option value="">Pilih</option>
                        <option value="Ya" {{ old('organisasi_lain') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('organisasi_lain') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Actions --}}
    <div class="form-actions">
        <a href="{{ route('admin.anggota.list') }}" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="11 17 6 12 11 7"></polyline>
                <polyline points="18 17 13 12 18 7"></polyline>
            </svg>
            Batal
        </a>
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            Simpan Anggota
        </button>
    </div>
</form>

<script>
    function updateFileName(input, elementId) {
        const fileName = input.files[0]?.name || 'Belum ada file dipilih';
        document.getElementById(elementId).textContent = fileName;
    }
</script>
@endsection