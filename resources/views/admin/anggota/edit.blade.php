@extends('admin.layouts.admin-layout')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Data Anggota')

@php
    $activeMenu = 'anggota';
    $admin = auth()->guard('admin')->user();
@endphp

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
* { box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
.form-container { max-width: 1200px; margin: 0 auto; background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.form-header { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #f3f4f6; }
.form-header h2 { font-size: 1.5rem; color: #0a2540; margin-bottom: 0.5rem; }
.form-header p { color: #6b7280; font-size: 0.875rem; }
.form-section { margin-bottom: 2.5rem; }
.section-title { font-size: 1.125rem; font-weight: 700; color: #0a2540; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem; }
.form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group.full-width { grid-column: 1 / -1; }
.form-label { display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem; }
.form-label .required { color: #ef4444; margin-left: 2px; }
.form-control { width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; transition: all 0.2s; }
.form-control:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
textarea.form-control { min-height: 100px; resize: vertical; }
.file-input-wrapper { position: relative; }
.file-input-label { display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem; border: 2px dashed #d1d5db; border-radius: 8px; cursor: pointer; transition: all 0.2s; background: #f9fafb; }
.file-input-label:hover { border-color: #2563eb; background: #eff6ff; }
.file-input { display: none; }
.current-file { margin-top: 0.5rem; padding: 0.5rem; background: #f3f4f6; border-radius: 6px; font-size: 0.75rem; color: #374151; }
.current-image { margin-top: 0.5rem; max-width: 200px; border-radius: 8px; border: 2px solid #e5e7eb; display: block; }
.image-preview-container { position: relative; display: inline-block; margin-top: 0.5rem; }
.delete-image-btn { position: absolute; top: 0.5rem; right: 0.5rem; background: #ef4444; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.delete-image-btn:hover { background: #dc2626; }
.form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #f3f4f6; }
.btn { padding: 0.75rem 1.5rem; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-size: 0.875rem; }
.btn-primary { background: #2563eb; color: white; }
.btn-primary:hover { background: #1e40af; transform: translateY(-2px); }
.btn-secondary { background: #f3f4f6; color: #374151; }
.btn-secondary:hover { background: #e5e7eb; }
.alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.875rem; }
.alert-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
.alert-danger ul { margin: 0.5rem 0 0 1.5rem; padding: 0; }
@media (max-width: 768px) {
    .form-container { padding: 1.5rem; }
    .form-grid { grid-template-columns: 1fr; }
    .form-actions { flex-direction: column; }
    .btn { width: 100%; justify-content: center; }
}
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-header">
        <h2>Edit Data Anggota</h2>
        <p>Perbarui informasi data anggota <strong>{{ $anggota->nama_usaha }}</strong></p>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <strong>Terdapat kesalahan:</strong>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.anggota.update', $anggota) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Data Pribadi --}}
        <div class="form-section">
            <div class="section-title">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Data Pribadi
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha', $anggota->nama_usaha) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tempat Lahir <span class="required">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir->format('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Agama <span class="required">*</span></label>
                    <select name="agama" class="form-control" required>
                        <option value="">Pilih Agama</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama', $anggota->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                    <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon', $anggota->nomor_telepon) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Domisili <span class="required">*</span></label>
                    @if($admin->isSuperAdmin())
                    <select name="domisili" class="form-control" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                        <optgroup label="Kabupaten">
                            <option value="Bandung" {{ old('domisili', $anggota->domisili) == 'Bandung' ? 'selected' : '' }}>Kabupaten Bandung</option>
                            <option value="Bandung Barat" {{ old('domisili', $anggota->domisili) == 'Bandung Barat' ? 'selected' : '' }}>Kabupaten Bandung Barat</option>
                            <option value="Bekasi" {{ old('domisili', $anggota->domisili) == 'Bekasi' ? 'selected' : '' }}>Kabupaten Bekasi</option>
                            <option value="Bogor" {{ old('domisili', $anggota->domisili) == 'Bogor' ? 'selected' : '' }}>Kabupaten Bogor</option>
                            <option value="Ciamis" {{ old('domisili', $anggota->domisili) == 'Ciamis' ? 'selected' : '' }}>Kabupaten Ciamis</option>
                            <option value="Cianjur" {{ old('domisili', $anggota->domisili) == 'Cianjur' ? 'selected' : '' }}>Kabupaten Cianjur</option>
                            <option value="Cirebon" {{ old('domisili', $anggota->domisili) == 'Cirebon' ? 'selected' : '' }}>Kabupaten Cirebon</option>
                            <option value="Garut" {{ old('domisili', $anggota->domisili) == 'Garut' ? 'selected' : '' }}>Kabupaten Garut</option>
                            <option value="Indramayu" {{ old('domisili', $anggota->domisili) == 'Indramayu' ? 'selected' : '' }}>Kabupaten Indramayu</option>
                            <option value="Karawang" {{ old('domisili', $anggota->domisili) == 'Karawang' ? 'selected' : '' }}>Kabupaten Karawang</option>
                            <option value="Kuningan" {{ old('domisili', $anggota->domisili) == 'Kuningan' ? 'selected' : '' }}>Kabupaten Kuningan</option>
                            <option value="Majalengka" {{ old('domisili', $anggota->domisili) == 'Majalengka' ? 'selected' : '' }}>Kabupaten Majalengka</option>
                            <option value="Pangandaran" {{ old('domisili', $anggota->domisili) == 'Pangandaran' ? 'selected' : '' }}>Kabupaten Pangandaran</option>
                            <option value="Purwakarta" {{ old('domisili', $anggota->domisili) == 'Purwakarta' ? 'selected' : '' }}>Kabupaten Purwakarta</option>
                            <option value="Subang" {{ old('domisili', $anggota->domisili) == 'Subang' ? 'selected' : '' }}>Kabupaten Subang</option>
                            <option value="Sukabumi" {{ old('domisili', $anggota->domisili) == 'Sukabumi' ? 'selected' : '' }}>Kabupaten Sukabumi</option>
                            <option value="Sumedang" {{ old('domisili', $anggota->domisili) == 'Sumedang' ? 'selected' : '' }}>Kabupaten Sumedang</option>
                            <option value="Tasikmalaya" {{ old('domisili', $anggota->domisili) == 'Tasikmalaya' ? 'selected' : '' }}>Kabupaten Tasikmalaya</option>
                        </optgroup>
                        <optgroup label="Kota">
                            <option value="Kota Bandung" {{ old('domisili', $anggota->domisili) == 'Kota Bandung' ? 'selected' : '' }}>Kota Bandung</option>
                            <option value="Kota Banjar" {{ old('domisili', $anggota->domisili) == 'Kota Banjar' ? 'selected' : '' }}>Kota Banjar</option>
                            <option value="Kota Bekasi" {{ old('domisili', $anggota->domisili) == 'Kota Bekasi' ? 'selected' : '' }}>Kota Bekasi</option>
                            <option value="Kota Bogor" {{ old('domisili', $anggota->domisili) == 'Kota Bogor' ? 'selected' : '' }}>Kota Bogor</option>
                            <option value="Kota Cimahi" {{ old('domisili', $anggota->domisili) == 'Kota Cimahi' ? 'selected' : '' }}>Kota Cimahi</option>
                            <option value="Kota Cirebon" {{ old('domisili', $anggota->domisili) == 'Kota Cirebon' ? 'selected' : '' }}>Kota Cirebon</option>
                            <option value="Kota Depok" {{ old('domisili', $anggota->domisili) == 'Kota Depok' ? 'selected' : '' }}>Kota Depok</option>
                            <option value="Kota Sukabumi" {{ old('domisili', $anggota->domisili) == 'Kota Sukabumi' ? 'selected' : '' }}>Kota Sukabumi</option>
                            <option value="Kota Tasikmalaya" {{ old('domisili', $anggota->domisili) == 'Kota Tasikmalaya' ? 'selected' : '' }}>Kota Tasikmalaya</option>
                        </optgroup>
                    </select>
                    @else
                    <input type="text" name="domisili" class="form-control" value="{{ $admin->domisili }}" readonly>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Kode Pos <span class="required">*</span></label>
                    <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $anggota->kode_pos) }}" required>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                    <textarea name="alamat_domisili" class="form-control" required>{{ old('alamat_domisili', $anggota->alamat_domisili) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $anggota->email) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor KTP <span class="required">*</span></label>
                    <input type="text" name="nomor_ktp" class="form-control" value="{{ old('nomor_ktp', $anggota->nomor_ktp) }}" maxlength="16" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Foto KTP</label>
                    <div class="file-input-wrapper">
                        <label for="foto_ktp" class="file-input-label">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            <span>Upload Foto KTP Baru</span>
                        </label>
                        <input type="file" id="foto_ktp" name="foto_ktp" class="file-input" accept="image/*">
                    </div>
                    @if($anggota->foto_ktp)
                    <div class="current-file"><strong>File saat ini:</strong> {{ basename($anggota->foto_ktp) }}</div>
                    <img src="{{ $anggota->foto_ktp_url }}" alt="Foto KTP" class="current-image">
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Diri</label>
                    <div class="file-input-wrapper">
                        <label for="foto_diri" class="file-input-label">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            <span>Upload Foto Diri Baru</span>
                        </label>
                        <input type="file" id="foto_diri" name="foto_diri" class="file-input" accept="image/*">
                    </div>
                    @if($anggota->foto_diri)
                    <div class="current-file"><strong>File saat ini:</strong> {{ basename($anggota->foto_diri) }}</div>
                    <img src="{{ $anggota->foto_diri_url }}" alt="Foto Diri" class="current-image">
                    @endif
                </div>
            </div>
        </div>

        {{-- Profil Perusahaan --}}
        <div class="form-section">
            <div class="section-title">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                </svg>
                Profil Perusahaan
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Perusahaan <span class="required">*</span></label>
                    <input type="text" name="nama_usaha_perusahaan" class="form-control" value="{{ old('nama_usaha_perusahaan', $anggota->nama_usaha_perusahaan) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Legalitas Usaha <span class="required">*</span></label>
                    <select name="legalitas_usaha" class="form-control" required>
                        <option value="">Pilih Legalitas</option>
                        @foreach(['PT', 'CV', 'PT Perorangan'] as $legal)
                        <option value="{{ $legal }}" {{ old('legalitas_usaha', $anggota->legalitas_usaha) == $legal ? 'selected' : '' }}>{{ $legal }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Jabatan <span class="required">*</span></label>
                    <input type="text" name="jabatan_usaha" class="form-control" value="{{ old('jabatan_usaha', $anggota->jabatan_usaha) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Brand Usaha <span class="required">*</span></label>
                    <input type="text" name="brand_usaha" class="form-control" value="{{ old('brand_usaha', $anggota->brand_usaha) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah Karyawan <span class="required">*</span></label>
                    <input type="number" name="jumlah_karyawan" class="form-control" value="{{ old('jumlah_karyawan', $anggota->jumlah_karyawan) }}" min="0" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor KTP Perusahaan <span class="required">*</span></label>
                    <input type="text" name="nomor_ktp_perusahaan" class="form-control" value="{{ old('nomor_ktp_perusahaan', $anggota->nomor_ktp_perusahaan) }}" maxlength="16" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Usia Perusahaan <span class="required">*</span></label>
                    <input type="text" name="usia_perusahaan" class="form-control" value="{{ old('usia_perusahaan', $anggota->usia_perusahaan) }}" placeholder="Contoh: 5 tahun" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Omset Per Tahun <span class="required">*</span></label>
                    <input type="text" name="omset_perusahaan" class="form-control" value="{{ old('omset_perusahaan', $anggota->omset_perusahaan) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">NPWP Perusahaan <span class="required">*</span></label>
                    <input type="text" name="npwp_perusahaan" class="form-control" value="{{ old('npwp_perusahaan', $anggota->npwp_perusahaan) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">No. Nota Pendirian <span class="required">*</span></label>
                    <input type="text" name="no_nota_pendirian" class="form-control" value="{{ old('no_nota_pendirian', $anggota->no_nota_pendirian) }}" required>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Alamat Kantor <span class="required">*</span></label>
                    <textarea name="alamat_kantor" class="form-control" required>{{ old('alamat_kantor', $anggota->alamat_kantor) }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Bidang Usaha <span class="required">*</span></label>
                    <textarea name="bidang_usaha" class="form-control" required>{{ old('bidang_usaha', $anggota->bidang_usaha) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Profile Perusahaan (PDF)</label>
                    <div class="file-input-wrapper">
                        <label for="profile_perusahaan" class="file-input-label">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            <span>Upload PDF Baru</span>
                        </label>
                        <input type="file" id="profile_perusahaan" name="profile_perusahaan" class="file-input" accept=".pdf">
                    </div>
                    @if($anggota->profile_perusahaan)
                    <div class="current-file"><strong>File saat ini:</strong> {{ basename($anggota->profile_perusahaan) }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Logo Perusahaan</label>
                    <div class="file-input-wrapper">
                        <label for="logo_perusahaan" class="file-input-label">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span>Upload Logo Baru</span>
                        </label>
                        <input type="file" id="logo_perusahaan" name="logo_perusahaan" class="file-input" accept="image/*">
                    </div>
                    @if($anggota->logo_perusahaan)
                    <div class="current-file"><strong>File saat ini:</strong> {{ basename($anggota->logo_perusahaan) }}</div>
                    <img src="{{ $anggota->logo_perusahaan_url }}" alt="Logo" class="current-image">
                    @endif
                </div>
            </div>
        </div>

        {{-- Detail Buku --}}
        <div class="form-section">
            <div class="section-title">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                </svg>
                Detail Buku (Opsional)
            </div>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">Deskripsi Detail Buku</label>
                    <textarea name="deskripsi_detail" class="form-control" rows="4">{{ old('deskripsi_detail', $anggota->deskripsi_detail) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Detail 1</label>
                    <div class="file-input-wrapper">
                        <label for="detail_image_1" class="file-input-label">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span>Upload Gambar 1</span>
                        </label>
                        <input type="file" id="detail_image_1" name="detail_image_1" class="file-input" accept="image/*">
                    </div>
                    @if($anggota->detail_image_1)
                    <div class="image-preview-container">
                        <img src="{{ $anggota->detail_image_1_url }}" alt="Detail 1" class="current-image">
                        <form action="{{ route('admin.anggota.delete-detail-image', $anggota) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="image_field" value="detail_image_1">
                            <button type="submit" class="delete-image-btn" onclick="return confirm('Hapus gambar ini?')">✕</button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Detail 2</label>
                    <div class="file-input-wrapper">
                        <label for="detail_image_2" class="file-input-label">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span>Upload Gambar 2</span>
                        </label>
                        <input type="file" id="detail_image_2" name="detail_image_2" class="file-input" accept="image/*">
                    </div>
                    @if($anggota->detail_image_2)
                    <div class="image-preview-container">
                        <img src="{{ $anggota->detail_image_2_url }}" alt="Detail 2" class="current-image">
                        <form action="{{ route('admin.anggota.delete-detail-image', $anggota) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="image_field" value="detail_image_2">
                            <button type="submit" class="delete-image-btn" onclick="return confirm('Hapus gambar ini?')">✕</button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Detail 3</label>
                    <div class="file-input-wrapper">
                        <label for="detail_image_3" class="file-input-label">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span>Upload Gambar 3</span>
                        </label>
                        <input type="file" id="detail_image_3" name="detail_image_3" class="file-input" accept="image/*">
                    </div>
                    @if($anggota->detail_image_3)
                    <div class="image-preview-container">
                        <img src="{{ $anggota->detail_image_3_url }}" alt="Detail 3" class="current-image">
                        <form action="{{ route('admin.anggota.delete-detail-image', $anggota) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="image_field" value="detail_image_3">
                            <button type="submit" class="delete-image-btn" onclick="return confirm('Hapus gambar ini?')">✕</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Informasi Organisasi --}}
        <div class="form-section">
            <div class="section-title">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Informasi Organisasi
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">SFC HIPMI <span class="required">*</span></label>
                    <input type="text" name="sfc_hipmi" class="form-control" value="{{ old('sfc_hipmi', $anggota->sfc_hipmi) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Referensi Anggota HIPMI <span class="required">*</span></label>
                    <select name="referensi_hipmi" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="Ya" {{ old('referensi_hipmi', $anggota->referensi_hipmi) == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('referensi_hipmi', $anggota->referensi_hipmi) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Organisasi Lain <span class="required">*</span></label>
                    <select name="organisasi_lain" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="Ya" {{ old('organisasi_lain', $anggota->organisasi_lain) == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('organisasi_lain', $anggota->organisasi_lain) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.anggota.show', $anggota) }}" class="btn btn-secondary">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" />
                </svg>
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.file-input').forEach(input => {
    input.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const span = this.previousElementSibling.querySelector('span');
            span.textContent = fileName;
        }
    });
});
</script>
@endpush