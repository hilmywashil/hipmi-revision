@extends('admin.layouts.admin-layout')

@section('title', 'Edit E-Katalog')
@section('page-title', 'Edit E-Katalog')

@php
    $activeMenu = 'katalog';
@endphp

@push('styles')
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        max-width: 900px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.875rem;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: '*';
        color: #dc2626;
        margin-left: 0.25rem;
    }

    .form-input, .form-textarea {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.2s;
    }

    .form-input:focus, .form-textarea:focus {
        outline: none;
        border-color: #ffd700;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-file-input {
        display: block;
        width: 100%;
        padding: 0.625rem;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-file-input:hover {
        border-color: #ffd700;
        background: #fffbeb;
    }

    .current-image {
        margin-top: 0.75rem;
    }

    .current-image img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .current-images {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 0.75rem;
    }

    .current-images img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .file-preview {
        margin-top: 0.75rem;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .file-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-checkbox input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        font-family: 'Montserrat', sans-serif;
    }

    .btn-primary {
        background: #ffd700;
        color: #0a2540;
    }

    .btn-primary:hover {
        background: #e6c200;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .form-error {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .form-hint {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .image-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .map-preview-container {
        margin-top: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
    }

    .map-preview-container iframe {
        width: 100%;
        height: 400px;
        border: none;
    }

    .map-helper {
        background: #f0f9ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.75rem;
    }

    .map-helper-title {
        font-weight: 600;
        font-size: 0.875rem;
        color: #1e40af;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .map-helper-steps {
        font-size: 0.75rem;
        color: #1e3a8a;
        line-height: 1.6;
    }

    .map-helper-steps ol {
        margin: 0.5rem 0;
        padding-left: 1.5rem;
    }

    .map-helper-steps li {
        margin-bottom: 0.25rem;
    }

    .current-map-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #10b981;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .map-example {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 0.75rem;
        margin-top: 0.5rem;
        font-family: monospace;
        font-size: 0.75rem;
        color: #6b7280;
        overflow-x: auto;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <form action="{{ route('admin.katalog.update', $katalog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label required">Nama Perusahaan</label>
            <input type="text" name="company_name" class="form-input" value="{{ old('company_name', $katalog->company_name) }}" required>
            @error('company_name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label required">Bidang Perusahaan</label>
            <input type="text" name="business_field" class="form-input" value="{{ old('business_field', $katalog->business_field) }}" required>
            @error('business_field')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label required">Deskripsi Perusahaan</label>
            <textarea name="description" class="form-textarea" required>{{ old('description', $katalog->description) }}</textarea>
            @error('description')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Logo Perusahaan</label>
            @if($katalog->logo)
                <div class="image-label">Logo saat ini:</div>
                <div class="current-image">
                    <img src="{{ $katalog->logo_url }}" alt="Current Logo">
                </div>
            @endif
            <input type="file" name="logo" class="form-file-input" accept="image/*" onchange="previewLogo(event)" style="margin-top: 0.75rem;">
            <div class="form-hint">Biarkan kosong jika tidak ingin mengubah logo. Format: JPG, PNG, GIF (Max: 2MB)</div>
            <div class="file-preview" id="logoPreview"></div>
            @error('logo')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Gambar Galeri (Max 3)</label>
            @if($katalog->images && count($katalog->images_url) > 0)
                <div class="image-label">Gambar saat ini:</div>
                <div class="current-images">
                    @foreach($katalog->images_url as $imageUrl)
                        <img src="{{ $imageUrl }}" alt="Gallery Image">
                    @endforeach
                </div>
            @endif
            <input type="file" name="images[]" class="form-file-input" accept="image/*" multiple onchange="previewImages(event)" style="margin-top: 0.75rem;">
            <div class="form-hint">Biarkan kosong jika tidak ingin mengubah gambar. Upload gambar baru akan mengganti semua gambar lama. Format: JPG, PNG, GIF (Max: 2MB per file)</div>
            <div class="file-preview" id="imagesPreview"></div>
            @error('images.*')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label required">Alamat</label>
            <textarea name="address" class="form-textarea" rows="3" required>{{ old('address', $katalog->address) }}</textarea>
            @error('address')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label required">Nomor Telepon</label>
            <input type="text" name="phone" class="form-input" value="{{ old('phone', $katalog->phone) }}" required>
            @error('phone')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label required">Email</label>
            <input type="email" name="email" class="form-input" value="{{ old('email', $katalog->email) }}" required>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Embed Google Maps</label>
            
            @if($katalog->map_embed_url)
                <div class="current-map-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Map Aktif
                </div>
                <div class="map-preview-container">
                    <iframe src="{{ $katalog->map_embed_url }}" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @endif

            <textarea 
                name="map_embed_url" 
                class="form-textarea" 
                rows="4" 
                placeholder="Paste kode iframe embed dari Google Maps di sini..."
                style="margin-top: 0.75rem; font-family: monospace; font-size: 0.75rem;">{{ old('map_embed_url', $katalog->map_embed_url) }}</textarea>
            
            <div class="form-hint">Paste langsung kode iframe dari Google Maps. Biarkan kosong jika tidak ingin mengubah.</div>
            
            @error('map_embed_url')
                <div class="form-error">{{ $message }}</div>
            @enderror

            <div class="map-helper">
                <div class="map-helper-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4"/>
                        <path d="M12 8h.01"/>
                    </svg>
                    Cara mendapatkan kode embed:
                </div>
                <div class="map-helper-steps">
                    <ol>
                        <li>Buka <strong>Google Maps</strong> di browser</li>
                        <li>Cari lokasi perusahaan Anda</li>
                        <li>Klik tombol <strong>"Share"</strong> atau <strong>"Bagikan"</strong></li>
                        <li>Pilih tab <strong>"Embed a map"</strong> atau <strong>"Sematkan peta"</strong></li>
                        <li>Klik <strong>"Copy HTML"</strong></li>
                        <li>Paste kode yang di-copy ke kolom di atas</li>
                    </ol>
                </div>
                <div class="map-example">
                    Contoh kode yang benar:<br>
                    &lt;iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450"...&gt;&lt;/iframe&gt;
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-checkbox">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $katalog->is_active) ? 'checked' : '' }}>
                <span>Aktifkan katalog ini</span>
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="{{ route('admin.katalog.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewLogo(event) {
        const preview = document.getElementById('logoPreview');
        preview.innerHTML = '';
        
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    }

    function previewImages(event) {
        const preview = document.getElementById('imagesPreview');
        preview.innerHTML = '';
        
        const files = event.target.files;
        for (let i = 0; i < Math.min(files.length, 3); i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            }
            reader.readAsDataURL(files[i]);
        }
    }
</script>
@endpush
@endsection