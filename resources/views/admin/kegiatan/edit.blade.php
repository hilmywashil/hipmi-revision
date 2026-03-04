{{-- resources/views/admin/kegiatan/edit.blade.php --}}
@extends('admin.layouts.admin-layout')

@section('title', 'Edit Kegiatan')
@section('page-title', 'Edit Kegiatan')

@php
$activeMenu = 'kegiatan';
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
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .required {
        color: #dc2626;
    }

    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        font-family: 'Montserrat', sans-serif;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: #0a2540;
        box-shadow: 0 0 0 3px rgba(10, 37, 64, 0.1);
    }

    .form-textarea {
        min-height: 200px;
        resize: vertical;
    }

    .form-help {
        font-size: 0.8125rem;
        color: #6b7280;
        margin-top: 0.375rem;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
    }

    .current-image {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .current-image img {
        max-width: 300px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    .current-image-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
        display: block;
    }

    .image-preview {
        margin-top: 1rem;
        display: none;
    }

    .image-preview img {
        max-width: 300px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    /* Multiple Images Styles */
    .dokumentasi-section {
        margin-top: 1.5rem;
    }

    .existing-images {
        margin-bottom: 1.5rem;
    }

    .dokumentasi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .dokumentasi-item {
        position: relative;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.5rem;
        background: white;
    }

    .dokumentasi-item.existing {
        border-color: #d1fae5;
        background: #f0fdf4;
    }

    .dokumentasi-item.new {
        border-color: #dbeafe;
        background: #eff6ff;
    }

    .dokumentasi-item img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 6px;
    }

    .dokumentasi-item .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        line-height: 1;
        transition: all 0.2s;
        font-weight: bold;
    }

    .dokumentasi-item .remove-btn:hover {
        background: #b91c1c;
        transform: scale(1.1);
    }

    .dokumentasi-item .image-badge {
        position: absolute;
        bottom: 0.5rem;
        left: 0.5rem;
        background: rgba(0, 0, 0, 0.75);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .file-input-wrapper {
        position: relative;
        margin-top: 1rem;
    }

    .file-input-label {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #0a2540;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.875rem;
    }

    .file-input-label:hover {
        background: #ffd700;
        color: #0a2540;
        transform: translateY(-2px);
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .images-count {
        display: inline-block;
        margin-left: 1rem;
        padding: 0.5rem 1rem;
        background: #f3f4f6;
        border-radius: 6px;
        font-size: 0.875rem;
        color: #374151;
        font-weight: 500;
    }

    .images-count.warning {
        background: #fef3c7;
        color: #92400e;
    }

    .images-count.success {
        background: #d1fae5;
        color: #065f46;
    }

    .section-divider {
        border-top: 2px dashed #e5e7eb;
        margin: 1.5rem 0;
        padding-top: 1rem;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-group label {
        cursor: pointer;
        user-select: none;
        font-weight: 500;
        color: #374151;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn-submit,
    .btn-cancel {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        font-family: 'Montserrat', sans-serif;
        border: none;
    }

    .btn-submit {
        background: #0a2540;
        color: white;
    }

    .btn-submit:hover {
        background: #ffd700;
        color: #0a2540;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
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

    @media (max-width: 1024px) {
        .form-container {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-submit,
        .btn-cancel {
            width: 100%;
        }

        .dokumentasi-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
</style>
@endpush

@section('content')
<a href="{{ route('admin.kegiatan.index') }}" class="back-link">
    <svg viewBox="0 0 24 24" width="20" height="20" style="stroke: currentColor; fill: none; stroke-width: 2;">
        <line x1="19" y1="12" x2="5" y2="12" />
        <polyline points="12 19 5 12 12 5" />
    </svg>
    Kembali ke Daftar Kegiatan
</a>

<div class="form-container">
    <form action="{{ route('admin.kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">
                Judul Kegiatan <span class="required">*</span>
            </label>
            <input type="text" name="judul" class="form-input" value="{{ old('judul', $kegiatan->judul) }}" required
                placeholder="Masukkan judul kegiatan">
            @error('judul')
            <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-help">Judul akan otomatis dijadikan URL (slug)</div>
        </div>

        <div class="form-group">
            <label class="form-label">
                Bidang <span class="required">*</span>
            </label>

            @if($admin->isSuperAdmin())
            {{-- Super Admin bisa ubah bidang --}}
            <select name="bidang" class="form-select" required>
                <option value="">Pilih Bidang</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="bidang_{{ $i }}" {{ old('bidang', $kegiatan->bidang) == "bidang_$i" ? 'selected' : '' }}>
                    Bidang {{ $i }}
                    </option>
                    @endfor
            </select>
            @else
            {{-- BPD tidak bisa ubah bidang --}}
            <input type="text" class="form-input" value="{{ $admin->bidang_name }}" disabled>
            <input type="hidden" name="bidang" value="{{ $admin->bidang }}">
            @endif

            @error('bidang')
            <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-help">
                @if($admin->isSuperAdmin())
                Ubah bidang kegiatan BPD (1-12)
                @else
                Bidang kegiatan tidak dapat diubah
                @endif
            </div>
        </div>

        <!-- Tambahkan di bagian form group konten -->
        <div class="form-group">
            <label class="form-label">
                Konten Kegiatan <span class="required">*</span>
            </label>

            <!-- Toolbar Editor -->
            <div class="editor-toolbar">
                <button type="button" class="toolbar-btn" onclick="formatText('bold')" title="Bold (Ctrl+B)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                        <path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                    </svg>
                </button>

                <button type="button" class="toolbar-btn" onclick="formatText('italic')" title="Italic (Ctrl+I)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="4" x2="10" y2="4"></line>
                        <line x1="14" y1="20" x2="5" y2="20"></line>
                        <line x1="15" y1="4" x2="9" y2="20"></line>
                    </svg>
                </button>

                <button type="button" class="toolbar-btn" onclick="formatText('underline')" title="Underline (Ctrl+U)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"></path>
                        <line x1="4" y1="21" x2="20" y2="21"></line>
                    </svg>
                </button>

                <div class="toolbar-divider"></div>

                <button type="button" class="toolbar-btn" onclick="formatText('insertUnorderedList')" title="Bullet List">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </button>

                <button type="button" class="toolbar-btn" onclick="formatText('insertOrderedList')" title="Numbered List">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="10" y1="6" x2="21" y2="6"></line>
                        <line x1="10" y1="12" x2="21" y2="12"></line>
                        <line x1="10" y1="18" x2="21" y2="18"></line>
                        <path d="M4 6h1v4"></path>
                        <path d="M4 10h2"></path>
                        <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path>
                    </svg>
                </button>

                <div class="toolbar-divider"></div>

                <select class="toolbar-select" onchange="formatHeading(this.value)">
                    <option value="">Normal</option>
                    <option value="h2">Heading 2</option>
                    <option value="h3">Heading 3</option>
                    <option value="h4">Heading 4</option>
                </select>

                <div class="toolbar-divider"></div>

                <button type="button" class="toolbar-btn" onclick="insertLink()" title="Insert Link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                </button>

                <button type="button" class="toolbar-btn" onclick="formatText('removeFormat')" title="Clear Formatting">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="4 7 4 4 20 4 20 7"></polyline>
                        <line x1="9" y1="20" x2="15" y2="20"></line>
                        <line x1="12" y1="4" x2="12" y2="20"></line>
                    </svg>
                </button>
            </div>

            <!-- Content Editable Area -->
            <div id="editor" class="form-editor" contenteditable="true"
                placeholder="Tulis konten kegiatan lengkap...">{{ old('konten') }}</div>

            <!-- Hidden textarea untuk submit (TANPA required attribute) -->
            <textarea name="konten" id="konten" style="display: none;"></textarea>

            @error('konten')
            <div class="error-message">{{ $message }}</div>
            @enderror
            <div id="kontenError" class="error-message" style="display: none;">Konten kegiatan wajib diisi!</div>
        </div>

        <style>
            .editor-toolbar {
                display: flex;
                align-items: center;
                gap: 0.25rem;
                padding: 0.5rem;
                background: #f9fafb;
                border: 1px solid #d1d5db;
                border-bottom: none;
                border-radius: 8px 8px 0 0;
                flex-wrap: wrap;
            }

            .toolbar-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                border: 1px solid transparent;
                background: white;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.2s;
                padding: 0;
            }

            .toolbar-btn:hover {
                background: #e5e7eb;
                border-color: #d1d5db;
            }

            .toolbar-btn:active,
            .toolbar-btn.active {
                background: #0a2540;
                color: white;
            }

            .toolbar-btn:active svg,
            .toolbar-btn.active svg {
                stroke: white;
            }

            .toolbar-btn svg {
                stroke: #374151;
            }

            .toolbar-divider {
                width: 1px;
                height: 24px;
                background: #d1d5db;
                margin: 0 0.25rem;
            }

            .toolbar-select {
                padding: 0.375rem 0.5rem;
                border: 1px solid #d1d5db;
                border-radius: 4px;
                background: white;
                cursor: pointer;
                font-size: 0.875rem;
                font-family: 'Montserrat', sans-serif;
            }

            .toolbar-select:focus {
                outline: none;
                border-color: #0a2540;
            }

            .form-editor {
                width: 100%;
                min-height: 300px;
                padding: 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0 0 8px 8px;
                font-size: 0.9375rem;
                line-height: 1.6;
                font-family: 'Montserrat', sans-serif;
                overflow-y: auto;
                background: white;
            }

            .form-editor:focus {
                outline: none;
                border-color: #0a2540;
                box-shadow: 0 0 0 3px rgba(10, 37, 64, 0.1);
            }

            .form-editor.error {
                border-color: #dc2626;
            }

            .form-editor[placeholder]:empty:before {
                content: attr(placeholder);
                color: #9ca3af;
            }

            /* Styling untuk konten di editor */
            .form-editor h2 {
                font-size: 1.5rem;
                font-weight: 700;
                margin: 1rem 0 0.5rem;
                color: #1f2937;
            }

            .form-editor h3 {
                font-size: 1.25rem;
                font-weight: 600;
                margin: 1rem 0 0.5rem;
                color: #1f2937;
            }

            .form-editor h4 {
                font-size: 1.125rem;
                font-weight: 600;
                margin: 1rem 0 0.5rem;
                color: #1f2937;
            }

            .form-editor ul,
            .form-editor ol {
                margin: 0.5rem 0;
                padding-left: 2rem;
            }

            .form-editor li {
                margin: 0.25rem 0;
            }

            .form-editor a {
                color: #0a2540;
                text-decoration: underline;
            }

            .form-editor strong {
                font-weight: 700;
            }

            .form-editor em {
                font-style: italic;
            }

            .form-editor u {
                text-decoration: underline;
            }

            .form-editor p {
                margin: 0.5rem 0;
            }

            @media (max-width: 768px) {
                .editor-toolbar {
                    padding: 0.375rem;
                }

                .toolbar-btn {
                    width: 28px;
                    height: 28px;
                }

                .toolbar-select {
                    font-size: 0.8125rem;
                    padding: 0.25rem 0.375rem;
                }
            }
        </style>

        <script>
            // Format text
            function formatText(command) {
                document.execCommand(command, false, null);
                document.getElementById('editor').focus();
            }

            // Format heading
            function formatHeading(tag) {
                if (tag) {
                    document.execCommand('formatBlock', false, tag);
                } else {
                    document.execCommand('formatBlock', false, 'p');
                }
                document.getElementById('editor').focus();

                // Reset select
                event.target.value = '';
            }

            // Insert link
            function insertLink() {
                const url = prompt('Masukkan URL:');
                if (url) {
                    document.execCommand('createLink', false, url);
                    document.getElementById('editor').focus();
                }
            }

            // Validate editor content
            function validateEditorContent() {
                const editor = document.getElementById('editor');
                const errorDiv = document.getElementById('kontenError');
                const content = editor.innerText.trim();

                if (content.length === 0) {
                    editor.classList.add('error');
                    errorDiv.style.display = 'block';
                    editor.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    return false;
                } else {
                    editor.classList.remove('error');
                    errorDiv.style.display = 'none';
                    return true;
                }
            }

            // Sync editor content to hidden textarea before submit
            const form = document.querySelector('form');
            const originalSubmitHandler = form.onsubmit;

            form.addEventListener('submit', function(e) {
                // Validate editor content first
                if (!validateEditorContent()) {
                    e.preventDefault();
                    return false;
                }

                // Sync content
                const editorContent = document.getElementById('editor').innerHTML;
                document.getElementById('konten').value = editorContent;

                // Continue with other validations if any
                return true;
            });

            // Clear error on typing
            document.getElementById('editor').addEventListener('input', function() {
                if (this.innerText.trim().length > 0) {
                    this.classList.remove('error');
                    document.getElementById('kontenError').style.display = 'none';
                }
            });

            // Keyboard shortcuts
            document.getElementById('editor').addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key.toLowerCase()) {
                        case 'b':
                            e.preventDefault();
                            formatText('bold');
                            break;
                        case 'i':
                            e.preventDefault();
                            formatText('italic');
                            break;
                        case 'u':
                            e.preventDefault();
                            formatText('underline');
                            break;
                    }
                }
            });

            // Update toolbar button states
            document.getElementById('editor').addEventListener('mouseup', updateToolbar);
            document.getElementById('editor').addEventListener('keyup', updateToolbar);

            function updateToolbar() {
                // Update button active states
                document.querySelectorAll('.toolbar-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
            }

            // Paste as plain text (optional - removes formatting when pasting)
            document.getElementById('editor').addEventListener('paste', function(e) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData).getData('text/plain');
                document.execCommand('insertText', false, text);
            });
        </script>

        <div class="form-group">
            <label class="form-label">
                Gambar Utama
            </label>

            <div class="current-image">
                <span class="current-image-label">Gambar saat ini:</span>
                <img src="{{ asset('storage/' . $kegiatan->gambar) }}" alt="{{ $kegiatan->judul }}">
            </div>

            <input type="file" name="gambar" class="form-input" accept="image/jpeg,image/jpg,image/png"
                onchange="previewImage(event)">
            @error('gambar')
            <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-help">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</div>

            <div class="image-preview" id="imagePreview">
                <span class="current-image-label">Preview gambar baru:</span>
                <img src="" alt="Preview" id="previewImg">
            </div>
        </div>

        <!-- Multiple Images Documentation -->
        <div class="form-group">
            <label class="form-label">
                Gambar Dokumentasi
            </label>

            <!-- Existing Images -->
            @if($kegiatan->gambar_dokumentasi && count($kegiatan->gambar_dokumentasi) > 0)
            <div class="existing-images">
                <div class="current-image-label">
                    Gambar dokumentasi saat ini ({{ count($kegiatan->gambar_dokumentasi) }} gambar):
                </div>
                <div class="dokumentasi-grid" id="existingGrid">
                    @foreach($kegiatan->gambar_dokumentasi as $index => $path)
                    <div class="dokumentasi-item existing" data-path="{{ $path }}">
                        <img src="{{ asset('storage/' . $path) }}" alt="Dokumentasi {{ $index + 1 }}">
                        <button type="button" class="remove-btn" onclick="removeExistingImage('{{ $path }}')">×</button>
                        <span class="image-badge">Existing</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="section-divider"></div>

            <!-- Add New Images -->
            <div class="form-help">Tambah gambar dokumentasi baru. Format: JPG, JPEG, PNG. Maksimal 2MB per gambar.</div>

            <div class="file-input-wrapper">
                <label for="gambar_dokumentasi" class="file-input-label">
                    <svg viewBox="0 0 24 24" width="16" height="16" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem; stroke: currentColor; fill: none; stroke-width: 2;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Tambah Gambar Baru
                </label>
                <input type="file"
                    name="gambar_dokumentasi[]"
                    id="gambar_dokumentasi"
                    accept="image/jpeg,image/jpg,image/png"
                    multiple
                    onchange="handleNewFiles(event)">
                <span class="images-count" id="imagesCount">
                    Total: <span id="totalCount">{{ count($kegiatan->gambar_dokumentasi ?? []) }}</span> gambar
                </span>
            </div>

            @error('gambar_dokumentasi.*')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="dokumentasi-section">
                <div class="dokumentasi-grid" id="newImagesGrid">
                    <!-- New preview images will be inserted here -->
                </div>
            </div>

            <!-- Hidden inputs for images to delete -->
            <div id="deleteInputs"></div>
        </div>

        <div class="form-group">
            <label class="form-label">
                Tanggal Publish <span class="required">*</span>
            </label>
            <input type="date" name="tanggal_publish" class="form-input"
                value="{{ old('tanggal_publish', $kegiatan->tanggal_publish->format('Y-m-d')) }}" required>
            @error('tanggal_publish')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Pengaturan Kegiatan</label>

            <div class="checkbox-group">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $kegiatan->is_active) ? 'checked' : '' }}>
                <label for="is_active">Aktifkan Kegiatan (tampil di halaman publik)</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" name="is_populer" id="is_populer" value="1"
                    {{ old('is_populer', $kegiatan->is_populer) ? 'checked' : '' }}>
                <label for="is_populer">Tandai sebagai Kegiatan Populer</label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Update Kegiatan</button>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Preview gambar utama
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    // Track images
    let existingImages = [];
    let imagesToDelete = [];
    let newFiles = [];

    // Initialize existing images
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.dokumentasi-item.existing').forEach(item => {
            existingImages.push(item.dataset.path);
        });
        updateTotalCount();
    });

    // Remove existing image
    function removeExistingImage(path) {
        const item = document.querySelector(`[data-path="${path}"]`);
        if (item) {
            item.remove();
            existingImages = existingImages.filter(p => p !== path);
            imagesToDelete.push(path);

            // Add hidden input for deletion
            const deleteInputs = document.getElementById('deleteInputs');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'hapus_dokumentasi[]';
            input.value = path;
            deleteInputs.appendChild(input);

            updateTotalCount();
        }
    }

    // Handle new files
    function handleNewFiles(event) {
        const files = Array.from(event.target.files);
        const grid = document.getElementById('newImagesGrid');

        files.forEach(file => {
            if (file.type.startsWith('image/')) {
                newFiles.push(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'dokumentasi-item new';
                    div.dataset.fileIndex = newFiles.length - 1;
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="New Image">
                        <button type="button" class="remove-btn" onclick="removeNewImage(${newFiles.length - 1})">×</button>
                        <span class="image-badge">New</span>
                    `;
                    grid.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });

        updateTotalCount();
        updateFileInput();
    }

    // Remove new image
    function removeNewImage(index) {
        const item = document.querySelector(`[data-file-index="${index}"]`);
        if (item) {
            item.remove();
            newFiles.splice(index, 1);

            // Re-index remaining items
            document.querySelectorAll('.dokumentasi-item.new').forEach((item, i) => {
                item.dataset.fileIndex = i;
                const btn = item.querySelector('.remove-btn');
                btn.onclick = () => removeNewImage(i);
            });

            updateTotalCount();
            updateFileInput();
        }
    }

    // Update file input
    function updateFileInput() {
        const input = document.getElementById('gambar_dokumentasi');
        const dataTransfer = new DataTransfer();

        newFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        input.files = dataTransfer.files;
    }

    // Update total count
    function updateTotalCount() {
        const total = existingImages.length + newFiles.length;
        document.getElementById('totalCount').textContent = total;

        const countSpan = document.getElementById('imagesCount');
        if (total < 6) {
            countSpan.className = 'images-count warning';
        } else {
            countSpan.className = 'images-count success';
        }
    }

    // Validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const total = existingImages.length + newFiles.length;
        if (total < 6) {
            e.preventDefault();
            alert('Total gambar dokumentasi minimal 6! Saat ini: ' + total + ' gambar');
            window.scrollTo({
                top: document.getElementById('gambar_dokumentasi').offsetTop - 100,
                behavior: 'smooth'
            });
        }
    });
</script>
@endpush
@endsection