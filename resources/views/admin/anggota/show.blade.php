@extends('admin.layouts.admin-layout')

@section('title', 'Detail Anggota')
@section('page-title', 'Detail Pendaftar Anggota')

@php
$activeMenu = 'anggota';
$admin = auth()->guard('admin')->user();
@endphp

@push('styles')
<style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

    * {
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
        padding: 8px 14px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-download:hover {
        background: #1e40af;
        transform: translateY(-1px);
    }

    .detail-container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .detail-header {
        background: white;
        border-radius: 12px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .detail-header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .detail-info h2 {
        font-size: 1.5rem;
        color: #0a2540;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    .detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .detail-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.625rem 1.25rem;
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
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn svg {
        width: 18px;
        height: 18px;
        stroke-width: 2;
    }

    .btn-edit {
        background: #f59e0b;
        color: white;
    }

    .btn-edit:hover {
        background: #d97706;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-approve {
        background: #10b981;
        color: white;
    }

    .btn-approve:hover {
        background: #059669;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-promote {
        background: #2563eb;
        color: white;
    }

    .btn-promote:hover {
        background: #1e40af;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-reject {
        background: #ef4444;
        color: white;
    }

    .btn-reject:hover {
        background: #dc2626;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-back {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-back:hover {
        background: #e5e7eb;
    }

    .status-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0a2540;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .status-badge-large {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .status-badge-large.pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-badge-large.approved {
        background: #d1fae5;
        color: #059669;
    }

    .status-badge-large.rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Credentials Card */
    .credentials-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        color: white;
    }

    .credentials-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .credential-item {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }

    .credential-label {
        font-size: 0.75rem;
        opacity: 0.9;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .credential-value {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        font-family: 'Courier New', monospace;
        flex-wrap: wrap;
    }

    .password-hidden {
        letter-spacing: 3px;
    }

    .credential-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .btn-credential {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-credential:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .password-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        margin-top: 0.5rem;
    }

    .password-status.changed {
        background: rgba(16, 185, 129, 0.2);
        border: 1px solid rgba(16, 185, 129, 0.4);
    }

    .password-status.initial {
        background: rgba(251, 191, 36, 0.2);
        border: 1px solid rgba(251, 191, 36, 0.4);
    }

    /* Tabs Styling */
    .tabs-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .tabs-header {
        display: flex;
        border-bottom: 2px solid #f3f4f6;
        background: #f9fafb;
        overflow-x: auto;
    }

    .tab-button {
        flex: 1;
        min-width: fit-content;
        padding: 1rem 1.5rem;
        background: transparent;
        border: none;
        font-size: 0.9375rem;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
        white-space: nowrap;
    }

    .tab-button:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .tab-button.active {
        color: #2563eb;
        background: white;
        border-bottom-color: #2563eb;
    }

    .tabs-content {
        padding: 2rem;
    }

    .tab-panel {
        display: none;
        animation: fadeIn 0.3s ease-in;
    }

    .tab-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .field-group {
        margin-bottom: 1.25rem;
    }

    .field-group:last-child {
        margin-bottom: 0;
    }

    .field-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        margin-bottom: 0.5rem;
    }

    .field-value {
        font-size: 0.9375rem;
        color: #0a2540;
        font-weight: 500;
        word-wrap: break-word;
        word-break: break-word;
        line-height: 1.5;
    }

    .field-value-number {
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        word-break: break-all;
    }

    .image-preview {
        width: 100%;
        max-width: 400px;
        height: 280px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        margin-top: 0.5rem;
        display: block;
        object-fit: cover;
    }

    .file-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.5rem 0;
        transition: all 0.2s;
    }

    .file-link:hover {
        color: #1e40af;
        transform: translateX(4px);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
    }

    .empty-state svg {
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
        opacity: 0.5;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0a2540;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .modal-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .info-box {
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
    }

    .info-box.success {
        background: #d1fae5;
        color: #059669;
        border: 1px solid #6ee7b7;
    }

    .info-box.danger {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .detail-header {
            padding: 1.25rem;
        }

        .detail-header-content {
            flex-direction: column;
            align-items: stretch;
        }

        .detail-info h2 {
            font-size: 1.25rem;
        }

        .detail-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-actions {
            width: 100%;
        }

        .btn {
            flex: 1;
            justify-content: center;
        }

        .tabs-header {
            flex-wrap: nowrap;
        }

        .tab-button {
            font-size: 0.8125rem;
            padding: 0.875rem 1rem;
        }

        .tabs-content {
            padding: 1.25rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .detail-header {
            padding: 1rem;
        }

        .detail-info h2 {
            font-size: 1.125rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
        }

        .tabs-content {
            padding: 1rem;
        }

        .field-value {
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    {{-- Header --}}
    <div class="detail-header">
        <div class="detail-header-content">
            <div class="detail-info">
                <h2>{{ $anggota->nama_usaha }}</h2>
                <div class="detail-meta">
                    <span><b>Email:</b> {{ $anggota->email }}</span>
                    <span><b>Phone:</b> {{ $anggota->nomor_telepon }}</span>
                    <span><b>Daftar:</b> {{ $anggota->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <div class="detail-actions">
                <a href="{{ route('admin.anggota.index') }}" class="btn btn-back">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

                {{-- Tombol Edit (Super Admin & BPC) --}}
                @if($admin->isSuperAdmin() || $admin->category === 'bpc')
                <a href="{{ route('admin.anggota.edit', $anggota) }}" class="btn btn-edit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit
                </a>
                @endif

                @if($admin->isSuperAdmin() && $anggota->status === 'approved')
                <a href="{{ route('admin.anggota.promote', $anggota) }}" class="btn btn-promote">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <polyline points="17 11 19 13 23 9" />
                    </svg>
                    Promosikan ke Admin
                </a>
                @endif

                @if($admin->category === 'bpc' && $anggota->status === 'pending')
                <button onclick="showApproveModal()" class="btn btn-approve">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Setujui
                </button>
                <button onclick="showRejectModal()" class="btn btn-reject">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Tolak
                </button>
                @endif

                @if($admin->isSuperAdmin() && $anggota->status === 'pending')
                <button onclick="showApproveModal()" class="btn btn-approve">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Setujui
                </button>
                <button onclick="showRejectModal()" class="btn btn-reject">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Tolak
                </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Status Card --}}
    <div class="status-card">
        <div class="card-title">Status Pendaftaran</div>
        <span class="status-badge-large {{ $anggota->status }}">
            @if($anggota->status === 'pending')
            ⏳ Menunggu Verifikasi
            @elseif($anggota->status === 'approved')
            ✓ Disetujui
            @else
            ✗ Ditolak
            @endif
        </span>

        @if($anggota->status === 'approved')
        <div class="info-box success">
            <strong>Disetujui oleh:</strong> {{ $anggota->approvedBy->name ?? 'Admin' }}<br>
            <strong>Tanggal:</strong> {{ $anggota->approved_at ? $anggota->approved_at->format('d M Y H:i') : '-' }}
        </div>
        @endif

        @if($anggota->status === 'rejected' && $anggota->rejection_reason)
        <div class="info-box danger">
            <strong>Alasan Penolakan:</strong><br>
            {{ $anggota->rejection_reason }}
        </div>
        @endif
    </div>

    {{-- Credentials Card --}}
    <div class="credentials-card">
        <div class="credentials-title">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
            Login Credentials Anggota
        </div>

        <div class="credential-item">
            <div class="credential-label">Email / Username</div>
            <div class="credential-value">
                <span id="email-value">{{ $anggota->email }}</span>
                <button class="btn-credential" onclick="copyToClipboard('{{ $anggota->email }}', 'email')">
                    <i class="fa fa-copy"></i> Copy
                </button>
            </div>
        </div>

        <div class="credential-item">
            <div class="credential-label">Password</div>
            <div class="credential-value">
                <span id="password-value" class="password-hidden">••••••••••••</span>
                <button class="btn-credential" onclick="togglePassword()">
                    <i class="fa fa-eye" id="eye-icon"></i> <span id="toggle-text">Show</span>
                </button>
                @if($anggota->initial_password)
                <button class="btn-credential" onclick="copyToClipboard('{{ $anggota->initial_password }}', 'password')">
                    <i class="fa fa-copy"></i> Copy
                </button>
                @endif
            </div>
        </div>

        @if($admin->isSuperAdmin() || $admin->category === 'bpc')
        <div class="credential-actions">
            <form action="{{ route('admin.anggota.reset-password', $anggota) }}" method="POST" onsubmit="return confirm('Reset password anggota ini? Password baru akan digenerate secara otomatis.')">
                @csrf
                <button type="submit" class="btn-credential btn-reset">
                    <i class="fa fa-refresh"></i> Reset Password
                </button>
            </form>
        </div>
        @endif
    </div>

    <style>
        .credentials-card {
            background: #ffffff;
            border: 1px solid #e8e8e8;
            border-radius: 16px;
            padding: 28px;
            margin-top: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .credentials-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 17px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid #f0f0f0;
        }

        .credentials-title svg {
            color: #64748b;
        }

        .credential-item {
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid #f7f7f7;
        }

        .credential-item:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .credential-label {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }

        .credential-value {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .credential-value span {
            font-size: 15px;
            font-weight: 500;
            color: #334155;
            padding: 12px 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'SF Mono', 'Monaco', 'Courier New', monospace;
            flex: 1;
            min-width: 200px;
            transition: all 0.2s ease;
        }

        .credential-value span:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .password-hidden {
            letter-spacing: 4px;
            font-size: 20px !important;
        }

        .btn-credential {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 18px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-credential:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #334155;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .btn-credential:active {
            transform: translateY(0);
        }

        .btn-credential i {
            font-size: 13px;
        }

        .btn-reset {
            background: #ef4444;
            border-color: #ef4444;
            color: #ffffff;
        }

        .btn-reset:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        .password-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 14px;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
        }

        .password-status.initial {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .password-status.changed {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .credential-actions {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #f0f0f0;
        }

        .credential-actions form {
            margin: 0;
        }

        @media (max-width: 768px) {
            .credential-value {
                flex-direction: column;
                align-items: stretch;
            }

            .credential-value span {
                min-width: 100%;
            }

            .btn-credential {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    {{-- Tabs Container --}}
    <div class="tabs-container">
        <div class="tabs-header">
            <button class="tab-button active" onclick="switchTab('pribadi')">
                Data Pribadi
            </button>
            <button class="tab-button" onclick="switchTab('perusahaan')">
                Profil Perusahaan
            </button>
            <button class="tab-button" onclick="switchTab('organisasi')">
                Informasi Organisasi
            </button>
            <button class="tab-button" onclick="switchTab('detail-buku')">
                Detail Buku
            </button>
        </div>

        <div class="tabs-content">
            {{-- Tab Data Pribadi --}}
            <div class="tab-panel active" id="tab-pribadi">
                <div class="detail-grid">
                    <div class="field-group">
                        <div class="field-label">Nama Lengkap</div>
                        <div class="field-value">{{ $anggota->nama_usaha }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Jenis Kelamin</div>
                        <div class="field-value">{{ ucfirst($anggota->jenis_kelamin) }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Tempat, Tanggal Lahir</div>
                        <div class="field-value">{{ $anggota->tempat_lahir }}, {{ $anggota->tanggal_lahir->format('d M Y') }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Agama</div>
                        <div class="field-value">{{ $anggota->agama }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Domisili</div>
                        <div class="field-value">{{ $anggota->domisili }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Alamat Lengkap</div>
                        <div class="field-value">{{ $anggota->alamat_domisili }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Kode Pos</div>
                        <div class="field-value">{{ $anggota->kode_pos }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Nomor KTP</div>
                        <div class="field-value field-value-number">{{ $anggota->nomor_ktp }}</div>
                    </div>
                </div>

                <div class="images-grid">
                    <div class="field-group">
                        <div class="field-label">Foto KTP</div>
                        <img src="{{ $anggota->foto_ktp_url }}" alt="Foto KTP" class="image-preview">
                    </div>

                    <div class="field-group">
                        <div class="field-label">Foto Diri</div>
                        <img src="{{ $anggota->foto_diri_url }}" alt="Foto Diri" class="image-preview">
                    </div>
                </div>
            </div>

            {{-- Tab Profil Perusahaan --}}
            <div class="tab-panel" id="tab-perusahaan">
                <div class="detail-grid">
                    <div class="field-group">
                        <div class="field-label">Nama Perusahaan</div>
                        <div class="field-value">{{ $anggota->nama_usaha_perusahaan }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Legalitas Usaha</div>
                        <div class="field-value">{{ $anggota->legalitas_usaha }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Jabatan</div>
                        <div class="field-value">{{ $anggota->jabatan_usaha }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Alamat Kantor</div>
                        <div class="field-value">{{ $anggota->alamat_kantor }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Bidang Usaha</div>
                        <div class="field-value">{{ $anggota->bidang_usaha }}</div>
                    </div>

                    <div class="field-group">
                        <div class="field-label">Brand</div>
                        <div class="field-value">{{ $anggota->brand_usaha }}</div>
                    </div>

                    <div class="field-label">Jumlah Karyawan</div>
                    <div class="field-value">{{ $anggota->jumlah_karyawan }} orang</div>
                </div>

                <div class="field-group">
                    <div class="field-label">Usia Perusahaan</div>
                    <div class="field-value">{{ $anggota->usia_perusahaan }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">Omset Per Tahun</div>
                    <div class="field-value">{{ $anggota->omset_perusahaan }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">NPWP Perusahaan</div>
                    <div class="field-value field-value-number">{{ $anggota->npwp_perusahaan }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">No. Nota Pendirian</div>
                    <div class="field-value field-value-number">{{ $anggota->no_nota_pendirian }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">Profile Perusahaan</div>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="{{ $anggota->profile_perusahaan_url }}" target="_blank" class="file-link">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            Lihat PDF
                        </a>
                        <a href="{{ $anggota->profile_perusahaan_url }}" download class="file-link" style="background: #10b981; color: white; padding: 8px 14px; border-radius: 8px;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="images-grid">
                <div class="field-group">
                    <div class="field-label">Logo Perusahaan</div>
                    <img src="{{ $anggota->logo_perusahaan_url }}" alt="Logo" class="image-preview">
                    <a href="{{ $anggota->logo_perusahaan_url }}" download class="btn-download">
                        <i class="fa fa-download"></i> Download Logo
                    </a>
                </div>
            </div>
        </div>

        {{-- Tab Informasi Organisasi --}}
        <div class="tab-panel" id="tab-organisasi">
            <div class="detail-grid">
                <div class="field-group">
                    <div class="field-label">SFC HIPMI</div>
                    <div class="field-value">{{ $anggota->sfc_hipmi }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">Referensi Anggota HIPMI</div>
                    <div class="field-value">{{ $anggota->referensi_hipmi }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">Organisasi Lain</div>
                    <div class="field-value">{{ $anggota->organisasi_lain }}</div>
                </div>
            </div>
        </div>

        {{-- Tab Detail Buku --}}
        <div class="tab-panel" id="tab-detail-buku">
            @if($anggota->detail_image_1 || $anggota->detail_image_2 || $anggota->detail_image_3 || $anggota->deskripsi_detail)
            @if($anggota->deskripsi_detail)
            <div class="field-group" style="margin-bottom: 2rem;">
                <div class="field-label">Deskripsi Detail Buku</div>
                <div class="field-value" style="white-space: pre-line;">{{ $anggota->deskripsi_detail }}</div>
            </div>
            @endif

            <div class="images-grid">
                @if($anggota->detail_image_1)
                <div class="field-group">
                    <div class="field-label">Gambar Detail 1</div>
                    <img src="{{ $anggota->detail_image_1_url }}" alt="Detail 1" class="image-preview">
                </div>
                @endif

                @if($anggota->detail_image_2)
                <div class="field-group">
                    <div class="field-label">Gambar Detail 2</div>
                    <img src="{{ $anggota->detail_image_2_url }}" alt="Detail 2" class="image-preview">
                </div>
                @endif

                @if($anggota->detail_image_3)
                <div class="field-group">
                    <div class="field-label">Gambar Detail 3</div>
                    <img src="{{ $anggota->detail_image_3_url }}" alt="Detail 3" class="image-preview">
                </div>
                @endif
            </div>
            @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                    <circle cx="8.5" cy="8.5" r="1.5" />
                    <polyline points="21 15 16 10 5 21" />
                </svg>
                <p style="margin: 0; font-size: 1rem; font-weight: 500;">Belum ada detail buku</p>
                <p style="margin: 0.5rem 0 0; font-size: 0.875rem;">Anggota belum mengunggah gambar detail buku</p>
            </div>
            @endif
        </div>
    </div>
</div>
</div>

{{-- Approve Modal --}}
<div class="modal" id="approveModal">
    <div class="modal-content">
        <h3 class="modal-title">Konfirmasi Persetujuan</h3>
        <p>Apakah Anda yakin ingin menyetujui pendaftaran <strong>{{ $anggota->nama_usaha }}</strong>?</p>
        <form action="{{ route('admin.anggota.approve', $anggota) }}" method="POST">
            @csrf
            <div class="modal-actions">
                <button type="button" class="btn btn-back" onclick="closeModal('approveModal')">Batal</button>
                <button type="submit" class="btn btn-approve">Ya, Setujui</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <h3 class="modal-title">Tolak Pendaftaran</h3>
        <form action="{{ route('admin.anggota.reject', $anggota) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Alasan Penolakan <span style="color: #ef4444;">*</span></label>
                <textarea name="rejection_reason" class="form-control" rows="4"
                    placeholder="Jelaskan alasan penolakan..." required></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-back" onclick="closeModal('rejectModal')">Batal</button>
                <button type="submit" class="btn btn-reject">Tolak</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let passwordVisible = false;
    const actualPassword = @json($anggota->initial_password ?? null);

    function switchTab(tabName) {
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.remove('active');
        });

        event.target.classList.add('active');
        document.getElementById('tab-' + tabName).classList.add('active');
    }

    function togglePassword() {
        const passwordValue = document.getElementById('password-value');
        const eyeIcon = document.getElementById('eye-icon');
        const toggleText = document.getElementById('toggle-text');

        if (passwordValue.classList.contains('password-hidden')) {
            passwordValue.textContent = '{{ $anggota->initial_password ?? "Password sudah diubah" }}';
            passwordValue.classList.remove('password-hidden');
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
            toggleText.textContent = 'Hide';
        } else {
            passwordValue.textContent = '••••••••••••';
            passwordValue.classList.add('password-hidden');
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
            toggleText.textContent = 'Show';
        }
    }

    function copyToClipboard(text, type) {
        navigator.clipboard.writeText(text).then(() => {
            const notification = document.createElement('div');
            notification.textContent = `${type === 'email' ? 'Email' : 'Password'} copied!`;
            notification.style.cssText = `
            position: fixed;
            top: 24px;
            right: 24px;
            background: #334155;
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            z-index: 9999;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            animation: slideIn 0.3s ease;
        `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        });
    }

    function showApproveModal() {
        document.getElementById('approveModal').classList.add('active');
    }

    function showRejectModal() {
        document.getElementById('rejectModal').classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
</script>
@endpush