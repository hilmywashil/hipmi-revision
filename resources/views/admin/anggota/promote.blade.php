@extends('admin.layouts.admin-layout')

@section('title', 'Promosikan ke Admin')
@section('page-title', 'Promosikan Anggota ke Admin')

@php
    $activeMenu = 'list-anggota';
@endphp

@push('styles')
    <style>
        .promote-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .promote-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0a2540;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .anggota-info {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .info-value {
            color: #0a2540;
            font-weight: 500;
            font-size: 0.875rem;
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

        .form-label .required {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            font-family: 'Montserrat', sans-serif;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control:disabled {
            background: #f3f4f6;
            cursor: not-allowed;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .form-hint {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.375rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        .alert-warning {
            background: #fef3c7;
            color: #d97706;
            border: 1px solid #fbbf24;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-family: 'Montserrat', sans-serif;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1e40af;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        @media (max-width: 768px) {
            .promote-card {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="promote-container">
        <div class="promote-card">
            <h2 class="card-title">Promosikan Anggota ke Admin</h2>

            <div class="alert alert-warning">
                <strong>⚠️ Perhatian!</strong> Setelah dipromosikan, anggota ini akan memiliki akses admin sesuai dengan kategori yang dipilih. Pastikan data sudah benar sebelum melanjutkan.
            </div>

            {{-- Info Anggota --}}
            <div class="anggota-info">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: #0a2540;">
                    Informasi Anggota
                </h3>
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $anggota->nama_usaha }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $anggota->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nomor Telepon</span>
                    <span class="info-value">{{ $anggota->nomor_telepon }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Domisili Saat Ini</span>
                    <span class="info-value">{{ $anggota->domisili }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Perusahaan</span>
                    <span class="info-value">{{ $anggota->nama_usaha_perusahaan }}</span>
                </div>
            </div>

            {{-- Form Promote --}}
            <form action="{{ route('admin.anggota.promote.store', $anggota) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">
                        Nama Admin
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           value="{{ $anggota->nama_usaha }}" 
                           disabled>
                    <p class="form-hint">Nama akan diambil dari data anggota</p>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Email
                        <span class="required">*</span>
                    </label>
                    <input type="email" 
                           class="form-control" 
                           value="{{ $anggota->email }}" 
                           disabled>
                    <p class="form-hint">Email akan diambil dari data anggota</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">
                        Username
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="username"
                           name="username" 
                           class="form-control @error('username') is-invalid @enderror" 
                           value="{{ old('username') }}"
                           placeholder="Masukkan username untuk admin"
                           required>
                    <p class="form-hint">Username untuk login admin (harus unik)</p>
                    @error('username')
                        <div class="text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        Password
                        <span class="required">*</span>
                    </label>
                    <input type="password" 
                           id="password"
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 8 karakter"
                           required>
                    <p class="form-hint">Password harus minimal 8 karakter</p>
                    @error('password')
                        <div class="text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        Konfirmasi Password
                        <span class="required">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation"
                           name="password_confirmation" 
                           class="form-control"
                           placeholder="Ulangi password"
                           required>
                    <p class="form-hint">Masukkan password yang sama untuk konfirmasi</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">
                        Kategori Admin
                        <span class="required">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            class="form-control form-select @error('category') is-invalid @enderror"
                            onchange="toggleDomisili()"
                            required>
                        <option value="">Pilih Kategori</option>
                        <option value="bpc" {{ old('category') === 'bpc' ? 'selected' : '' }}>
                            BPC (Admin Kabupaten/Kota)
                        </option>
                        <option value="bpd" {{ old('category') === 'bpd' ? 'selected' : '' }}>
                            BPD (Admin Provinsi)
                        </option>
                    </select>
                    <p class="form-hint">BPC untuk admin tingkat kabupaten/kota, BPD untuk admin tingkat provinsi</p>
                    @error('category')
                        <div class="text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" id="domisili-group" style="display: none;">
                    <label class="form-label" for="domisili">
                        Domisili (Kabupaten/Kota)
                        <span class="required">*</span>
                    </label>
                    <select id="domisili" 
                            name="domisili" 
                            class="form-control form-select @error('domisili') is-invalid @enderror">
                        <option value="">Pilih Domisili</option>
                        @foreach($domisiliList as $dom)
                            <option value="{{ $dom }}" {{ old('domisili', $anggota->domisili) === $dom ? 'selected' : '' }}>
                                {{ $dom }}
                            </option>
                        @endforeach
                    </select>
                    <p class="form-hint">Domisili diperlukan untuk admin BPC</p>
                    @error('domisili')
                        <div class="text-danger" style="font-size: 0.75rem; margin-top: 0.25rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <strong>ℹ️ Info:</strong> Setelah dipromosikan, admin baru dapat login menggunakan username dan password yang Anda buat di sini. Data anggota tetap tersimpan di database.
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.anggota.list') }}" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        Promosikan ke Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleDomisili() {
            const category = document.getElementById('category').value;
            const domisiliGroup = document.getElementById('domisili-group');
            const domisiliSelect = document.getElementById('domisili');
            
            if (category === 'bpc') {
                domisiliGroup.style.display = 'block';
                domisiliSelect.required = true;
            } else {
                domisiliGroup.style.display = 'none';
                domisiliSelect.required = false;
                domisiliSelect.value = '';
            }
        }

        // Trigger on page load jika ada old value
        document.addEventListener('DOMContentLoaded', function() {
            toggleDomisili();
        });
    </script>
@endpush