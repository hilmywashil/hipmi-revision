{{-- resources/views/admin/organisasi/edit.blade.php --}}
@extends('admin.layouts.admin-layout')

@section('title', 'Edit Anggota Organisasi')

@section('page-title', 'Edit Anggota Organisasi')

@push('styles')
<style>
    .form-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        max-width: 800px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: '*';
        color: #dc2626;
        margin-left: 0.25rem;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.2s;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #0a2540;
        box-shadow: 0 0 0 3px rgba(10, 37, 64, 0.1);
    }

    .form-input.error, .form-select.error {
        border-color: #dc2626;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.375rem;
    }

    .current-image {
        margin-bottom: 1rem;
        text-align: center;
    }

    .current-image img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    .current-image-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
        display: block;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input {
        display: none;
    }

    .file-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        background: #f9fafb;
    }

    .file-label:hover {
        border-color: #0a2540;
        background: #f3f4f6;
    }

    .file-label-content {
        text-align: center;
    }

    .file-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        color: #6b7280;
    }

    .image-preview {
        margin-top: 1rem;
        text-align: center;
    }

    .preview-img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f3f4f6;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Montserrat', sans-serif;
    }

    .btn-primary {
        background: #0a2540;
        color: white;
    }

    .btn-primary:hover {
        background: #164e63;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .form-helper {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.375rem;
    }

    .input-mode-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.5rem;
    }

    .tab-button {
        padding: 0.75rem 1.5rem;
        background: transparent;
        border: none;
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s;
        font-family: 'Montserrat', sans-serif;
    }

    .tab-button:hover {
        color: #0a2540;
    }

    .tab-button.active {
        color: #0a2540;
        border-bottom-color: #0a2540;
    }

    .input-section {
        display: none;
    }

    .input-section.active {
        display: block;
    }

    .anggota-preview-card {
        background: #f0f9ff;
        border: 2px solid #0284c7;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
        display: none;
    }

    .anggota-preview-card.show {
        display: block;
    }

    .anggota-preview-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .anggota-preview-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #0284c7;
    }

    .anggota-preview-info h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: #075985;
        margin: 0 0 0.25rem 0;
    }

    .anggota-preview-info p {
        font-size: 0.75rem;
        color: #0c4a6e;
        margin: 0;
    }

    .info-box {
        padding: 1rem;
        background: #f0f9ff;
        border-left: 4px solid #0284c7;
        border-radius: 6px;
        margin-top: 1rem;
    }

    .info-box-content {
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .info-box-title {
        font-weight: 600;
        color: #075985;
        margin-bottom: 0.25rem;
    }

    .info-box-desc {
        font-size: 0.875rem;
        color: #0c4a6e;
        line-height: 1.5;
    }

    .custom-kategori-wrapper {
        display: none;
        margin-top: 1rem;
        padding: 1rem;
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        border-radius: 6px;
    }

    .custom-kategori-wrapper.show {
        display: block;
    }

    .custom-kategori-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>
@endpush

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.organisasi.update', $organisasi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Tab Mode Input --}}
            <div class="input-mode-tabs">
                <button type="button" class="tab-button {{ $organisasi->anggota_id ? 'active' : '' }}" onclick="switchTab('anggota')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" style="display: inline; vertical-align: middle;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    Pilih dari Anggota
                </button>
                <button type="button" class="tab-button {{ !$organisasi->anggota_id ? 'active' : '' }}" onclick="switchTab('manual')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" style="display: inline; vertical-align: middle;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Input Manual
                </button>
            </div>

            {{-- Section: Pilih dari Anggota --}}
            <div id="anggotaSection" class="input-section {{ $organisasi->anggota_id ? 'active' : '' }}">
                <div class="form-group">
                    <label for="anggota_id" class="form-label">Pilih Anggota</label>
                    <select id="anggota_id" name="anggota_id" class="form-select @error('anggota_id') error @enderror" onchange="showAnggotaPreview(this)">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggotaList as $anggota)
                            <option value="{{ $anggota->id }}" 
                                    data-nama="{{ $anggota->nama_usaha }}"
                                    data-email="{{ $anggota->email }}"
                                    data-foto="{{ $anggota->photo_url }}"
                                    {{ old('anggota_id', $organisasi->anggota_id) == $anggota->id ? 'selected' : '' }}>
                                {{ $anggota->nama_usaha }} ({{ $anggota->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('anggota_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-helper">Pilih anggota yang sudah terdaftar dan disetujui</div>

                    {{-- Preview Card --}}
                    <div id="anggotaPreviewCard" class="anggota-preview-card {{ $organisasi->anggota_id ? 'show' : '' }}">
                        <div class="anggota-preview-content">
                            <img id="previewAnggotaFoto" class="anggota-preview-img" 
                                 src="{{ $organisasi->anggota ? $organisasi->anggota->photo_url : '' }}" alt="">
                            <div class="anggota-preview-info">
                                <h4 id="previewAnggotaNama">{{ $organisasi->anggota ? $organisasi->anggota->nama_usaha : '' }}</h4>
                                <p id="previewAnggotaEmail">{{ $organisasi->anggota ? $organisasi->anggota->email : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Input Manual --}}
            <div id="manualSection" class="input-section {{ !$organisasi->anggota_id ? 'active' : '' }}">
                <div class="form-group">
                    <label for="nama_manual" class="form-label required">Nama Lengkap</label>
                    <input type="text" id="nama_manual" name="nama" class="form-input @error('nama') error @enderror" 
                           value="{{ old('nama', $organisasi->nama) }}" placeholder="Masukkan nama lengkap">
                    @error('nama')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto" class="form-label">Foto</label>
                    
                    @if($organisasi->foto)
                        <div class="current-image">
                            <span class="current-image-label">Foto Saat Ini:</span>
                            <img src="{{ $organisasi->foto_url }}" alt="{{ $organisasi->nama }}">
                        </div>
                    @endif

                    <div class="file-input-wrapper">
                        <input type="file" id="foto" name="foto" class="file-input" accept="image/*" onchange="previewImage(event)">
                        <label for="foto" class="file-label">
                            <div class="file-label-content">
                                <svg class="file-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <div style="font-weight: 600; margin-bottom: 0.25rem;">Klik untuk upload foto baru</div>
                                <div style="font-size: 0.75rem; color: #6b7280;">JPG, PNG (Max. 2MB)</div>
                            </div>
                        </label>
                    </div>
                    <div id="imagePreview" class="image-preview" style="display: none;">
                        <img id="preview" class="preview-img" src="" alt="Preview">
                    </div>
                    @error('foto')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Jabatan (Untuk Semua Mode) --}}
            <div class="form-group">
                <label for="jabatan" class="form-label required">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="form-input @error('jabatan') error @enderror" 
                       value="{{ old('jabatan', $organisasi->jabatan) }}" placeholder="Contoh: Ketua Bidang Kewirausahaan">
                @error('jabatan')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kategori --}}
            @php
                $standardKategori = ['ketua_umum', 'wakil_ketua_umum', 'ketua_bidang', 'sekretaris_umum', 'wakil_sekretaris_umum'];
                $isCustomKategori = !in_array($organisasi->kategori, $standardKategori);
            @endphp

            <div class="form-group">
                <label for="kategori" class="form-label required">Kategori Jabatan</label>
                <select id="kategori" name="kategori" class="form-select @error('kategori') error @enderror" onchange="handleKategoriChange(this.value)">
                    <option value="">Pilih Kategori</option>
                    <option value="ketua_umum" {{ old('kategori', $organisasi->kategori) == 'ketua_umum' ? 'selected' : '' }}>Ketua Umum</option>
                    <option value="wakil_ketua_umum" {{ old('kategori', $organisasi->kategori) == 'wakil_ketua_umum' ? 'selected' : '' }}>Wakil Ketua Umum</option>
                    <option value="ketua_bidang" {{ old('kategori', $organisasi->kategori) == 'ketua_bidang' ? 'selected' : '' }}>Ketua Bidang</option>
                    <option value="sekretaris_umum" {{ old('kategori', $organisasi->kategori) == 'sekretaris_umum' ? 'selected' : '' }}>Sekretaris Umum</option>
                    <option value="wakil_sekretaris_umum" {{ old('kategori', $organisasi->kategori) == 'wakil_sekretaris_umum' ? 'selected' : '' }}>Wakil Sekretaris Umum</option>
                    <option value="lainnya" {{ $isCustomKategori || old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                {{-- Custom Kategori Input --}}
                <div id="customKategoriWrapper" class="custom-kategori-wrapper {{ $isCustomKategori ? 'show' : '' }}">
                    <label for="kategori_custom" class="custom-kategori-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Masukkan Kategori Jabatan Custom
                    </label>
                    <input type="text" id="kategori_custom" name="kategori_custom" 
                           class="form-input @error('kategori_custom') error @enderror" 
                           value="{{ old('kategori_custom', $isCustomKategori ? $organisasi->kategori : '') }}" 
                           placeholder="Contoh: Bendahara, Koordinator Acara, dll">
                    <div class="form-helper" style="color: #92400e;">
                        Kategori ini akan dibuat baru dan bisa digunakan untuk posisi yang tidak ada di pilihan standar
                    </div>
                    @error('kategori_custom')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Info Box untuk setiap kategori --}}
                <div id="kategoriInfo" class="info-box" style="display: none;">
                    <div class="info-box-content">
                        <svg style="width: 20px; height: 20px; color: #0284c7; flex-shrink: 0; margin-top: 2px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <div>
                            <div class="info-box-title" id="kategoriTitle"></div>
                            <div class="info-box-desc" id="kategoriDesc"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hidden input untuk urutan --}}
            <input type="hidden" id="urutan" name="urutan" value="{{ old('urutan', $organisasi->urutan) }}">

            {{-- Status Aktif --}}
            <div class="form-group">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="aktif" name="aktif" class="form-checkbox" value="1" {{ old('aktif', $organisasi->aktif) ? 'checked' : '' }}>
                    <label for="aktif" class="form-label" style="margin-bottom: 0;">Aktif</label>
                </div>
                <div class="form-helper">Centang jika anggota ini aktif dalam organisasi</div>
            </div>

            {{-- Action Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Update Data
                </button>
                <a href="{{ route('admin.organisasi.index') }}" class="btn btn-secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function switchTab(mode) {
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.closest('.tab-button').classList.add('active');

        document.querySelectorAll('.input-section').forEach(section => {
            section.classList.remove('active');
        });

        if (mode === 'anggota') {
            document.getElementById('anggotaSection').classList.add('active');
            document.getElementById('nama_manual').value = '';
            document.getElementById('imagePreview').style.display = 'none';
        } else {
            document.getElementById('manualSection').classList.add('active');
            const currentAnggotaId = '{{ $organisasi->anggota_id }}';
            if (!currentAnggotaId) {
                document.getElementById('anggota_id').value = '';
                document.getElementById('anggotaPreviewCard').classList.remove('show');
            }
        }
    }

    function showAnggotaPreview(select) {
        const previewCard = document.getElementById('anggotaPreviewCard');
        
        if (select.value) {
            const selectedOption = select.options[select.selectedIndex];
            const nama = selectedOption.getAttribute('data-nama');
            const email = selectedOption.getAttribute('data-email');
            const foto = selectedOption.getAttribute('data-foto');

            document.getElementById('previewAnggotaFoto').src = foto;
            document.getElementById('previewAnggotaNama').textContent = nama;
            document.getElementById('previewAnggotaEmail').textContent = email;

            previewCard.classList.add('show');
        } else {
            previewCard.classList.remove('show');
        }
    }

    function previewImage(event) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    function handleKategoriChange(kategori) {
        const customWrapper = document.getElementById('customKategoriWrapper');
        const infoBox = document.getElementById('kategoriInfo');
        
        if (kategori === 'lainnya') {
            customWrapper.classList.add('show');
            infoBox.style.display = 'none';
        } else {
            customWrapper.classList.remove('show');
            document.getElementById('kategori_custom').value = '';
            showKategoriInfo(kategori);
        }
    }

    function showKategoriInfo(kategori) {
        const infoBox = document.getElementById('kategoriInfo');
        const title = document.getElementById('kategoriTitle');
        const desc = document.getElementById('kategoriDesc');
        
        const infoData = {
            'ketua_umum': {
                title: 'Posisi: Bagian Paling Atas (Tunggal)',
                desc: 'Data akan ditampilkan di bagian paling atas halaman organisasi dengan accent hijau. Hanya ada 1 Ketua Umum yang tampil.'
            },
            'wakil_ketua_umum': {
                title: 'Posisi: Di Bawah Ketua Umum',
                desc: 'Data akan ditampilkan di bawah Ketua Umum dengan accent biru. Bisa menampilkan beberapa Wakil Ketua Umum secara vertikal.'
            },
            'ketua_bidang': {
                title: 'Posisi: Bagian Tengah (Grid 4 Kolom)',
                desc: 'Data akan ditampilkan dalam bentuk grid 4 kolom dengan accent merah. Untuk menampilkan beberapa Ketua Bidang sekaligus.'
            },
            'sekretaris_umum': {
                title: 'Posisi: Setelah Ketua Bidang (Tunggal)',
                desc: 'Data akan ditampilkan setelah bagian Ketua Bidang dengan accent hijau. Hanya ada 1 Sekretaris Umum yang tampil.'
            },
            'wakil_sekretaris_umum': {
                title: 'Posisi: Bagian Paling Bawah (Grid 4 Kolom)',
                desc: 'Data akan ditampilkan di bagian paling bawah dalam bentuk grid 4 kolom dengan accent biru. Untuk menampilkan beberapa Wakil Sekretaris Umum.'
            }
        };
        
        if (kategori && infoData[kategori]) {
            title.textContent = infoData[kategori].title;
            desc.textContent = infoData[kategori].desc;
            infoBox.style.display = 'block';
        } else {
            infoBox.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategori');
        if (kategoriSelect.value) {
            handleKategoriChange(kategoriSelect.value);
        }
    });
</script>
@endpush