@extends('layouts.app')

@section('title', 'Katalog Saya - HIPMI Jawa Barat')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .katalog-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: white;
        color: #475569;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.875rem;
        border: 2px solid #e5e7eb;
        border-left: 4px solid #64748b;
        margin-bottom: 1.5rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .back-button:hover {
        background: #f8fafc;
        border-color: #64748b;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(100, 116, 139, 0.15);
    }

    .back-button:hover svg {
        transform: translateX(-4px);
    }

    .back-button svg {
        transition: transform 0.2s ease;
    }

    .page-header {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 2px solid #f3f4f6;
        border-left: 5px solid #3b82f6;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header h1 {
        font-size: 1.875rem;
        color: #0a2540;
        margin: 0 0 0.5rem 0;
        font-weight: 800;
        letter-spacing: -0.025em;
    }

    .page-header p {
        color: #6b7280;
        font-size: 0.9375rem;
        margin: 0;
        line-height: 1.6;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        justify-content: center;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }

    .btn:hover { transform: translateY(-2px); }

    .btn-primary {
        background: #2563eb;
        color: white;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        border-left: 4px solid #1e40af;
    }

    .btn-primary:hover {
        background: #1e40af;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.4);
    }

    .btn-success {
        background: #10b981;
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        border-left: 4px solid #059669;
    }

    .btn-success:hover {
        background: #059669;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        border-left: 4px solid #dc2626;
    }

    .btn-danger:hover {
        background: #dc2626;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 1.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #f3f4f6;
        border-left: 5px solid;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0;
        width: 5px; height: 100%;
        transition: width 0.3s ease;
        opacity: 0.15;
    }

    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
    .stat-card:hover::before { width: 100%; }

    .stat-card .stat-number {
        font-size: 2.75rem;
        font-weight: 800;
        color: #0a2540;
        margin: 0 0 0.5rem;
        line-height: 1;
        letter-spacing: -0.05em;
    }

    .stat-card .stat-label {
        font-size: 0.8125rem;
        color: #6b7280;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .stat-card:nth-child(1) { border-left-color: #3b82f6; color: #3b82f6; }
    .stat-card:nth-child(1)::before { background: #3b82f6; }
    .stat-card.pending { border-left-color: #f59e0b; color: #f59e0b; }
    .stat-card.pending::before { background: #f59e0b; }
    .stat-card.pending .stat-number { color: #d97706; }
    .stat-card.approved { border-left-color: #10b981; color: #10b981; }
    .stat-card.approved::before { background: #10b981; }
    .stat-card.approved .stat-number { color: #059669; }
    .stat-card.rejected { border-left-color: #ef4444; color: #ef4444; }
    .stat-card.rejected::before { background: #ef4444; }
    .stat-card.rejected .stat-number { color: #dc2626; }

    /* Info box: katalog auto-dibuat */
    .info-box {
        background: #eff6ff;
        border: 2px solid #bfdbfe;
        border-left: 5px solid #3b82f6;
        border-radius: 8px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .info-box svg { flex-shrink: 0; margin-top: 2px; stroke: #2563eb; }

    .info-box-content h4 {
        margin: 0 0 0.375rem;
        color: #1e40af;
        font-size: 0.9375rem;
        font-weight: 700;
    }

    .info-box-content p {
        margin: 0;
        color: #1e3a8a;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    /* Placeholder warning di description */
    .description-placeholder {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        background: #fef3c7;
        color: #92400e;
        font-size: 0.8125rem;
        font-weight: 600;
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        border-left: 3px solid #f59e0b;
        margin-bottom: 0.75rem;
    }

    .katalog-list { display: grid; gap: 1.5rem; }

    .katalog-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .katalog-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0;
        width: 4px; height: 100%;
        background: linear-gradient(180deg, #3b82f6 0%, #1e40af 100%);
        transform: translateY(-100%);
        transition: transform 0.3s ease;
    }

    .katalog-card:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,.12);
        transform: translateY(-4px);
        border-color: #cbd5e1;
    }

    .katalog-card:hover::before { transform: translateY(0); }

    .katalog-content {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 2rem;
        align-items: start;
    }

    .katalog-logo {
        width: 140px;
        height: 140px;
        object-fit: contain;
        background: #f9fafb;
        padding: 16px;
        border-radius: 6px;
        border: 3px solid #e5e7eb;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        transition: all 0.3s ease;
    }

    .katalog-card:hover .katalog-logo {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }

    .katalog-info { flex: 1; min-width: 0; }

    .katalog-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        gap: 1.5rem;
    }

    .katalog-title {
        margin: 0 0 0.5rem;
        font-size: 1.375rem;
        font-weight: 700;
        color: #0a2540;
        line-height: 1.3;
        letter-spacing: -0.025em;
    }

    .katalog-field {
        margin: 0;
        color: #6b7280;
        font-size: 0.9375rem;
        font-weight: 600;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.8125rem;
        white-space: nowrap;
        letter-spacing: 0.075em;
        text-transform: uppercase;
        border-left: 4px solid;
    }

    .status-badge.pending { background: #fef3c7; color: #78350f; border-left-color: #f59e0b; }
    .status-badge.approved { background: #d1fae5; color: #064e3b; border-left-color: #10b981; }
    .status-badge.rejected { background: #fee2e2; color: #7f1d1d; border-left-color: #ef4444; }

    .katalog-description {
        color: #4b5563;
        font-size: 0.9375rem;
        margin-bottom: 1.25rem;
        line-height: 1.7;
    }

    .rejection-box {
        background: #fee2e2;
        padding: 1.125rem;
        border-radius: 6px;
        margin-bottom: 1.25rem;
        border-left: 5px solid #ef4444;
        box-shadow: 0 2px 8px rgba(239,68,68,.15);
    }

    .rejection-box strong {
        color: #991b1b;
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .rejection-box p { margin: 0.5rem 0 0; color: #7f1d1d; font-size: 0.9375rem; line-height: 1.6; }

    .katalog-actions {
        display: flex;
        gap: 0.875rem;
        flex-wrap: wrap;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f3f4f6;
    }

    .alert {
        padding: 1.125rem 1.5rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-left: 5px solid;
    }

    .alert-success { background: #d1fae5; color: #065f46; border-left-color: #10b981; box-shadow: 0 2px 8px rgba(16,185,129,.15); }
    .alert-error   { background: #fee2e2; color: #991b1b; border-left-color: #ef4444; box-shadow: 0 2px 8px rgba(239,68,68,.15); }
    .alert-warning { background: #fef3c7; color: #92400e; border-left-color: #f59e0b; box-shadow: 0 2px 8px rgba(245,158,11,.15); }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,.1);
        border: 2px dashed #cbd5e1;
    }

    .empty-state svg { width: 100px; height: 100px; margin: 0 auto 1.5rem; stroke: #cbd5e1; stroke-width: 1.5; }
    .empty-state h3 { margin: 0 0 0.75rem; color: #6b7280; font-size: 1.5rem; font-weight: 700; }
    .empty-state p { margin: 0 0 2rem; color: #9ca3af; font-size: 1rem; line-height: 1.6; max-width: 500px; margin-left: auto; margin-right: auto; }

    .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 2.5rem; }

    @media (max-width: 768px) {
        .katalog-container { padding: 15px; margin: 20px auto; }
        .page-header { padding: 1.5rem; }
        .page-header h1 { font-size: 1.5rem; }
        .page-header-content { flex-direction: column; align-items: flex-start; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .katalog-content { grid-template-columns: 1fr; text-align: center; }
        .katalog-logo { width: 100%; max-width: 200px; height: 200px; margin: 0 auto; }
        .katalog-header { flex-direction: column; align-items: center; text-align: center; }
        .katalog-actions { width: 100%; flex-direction: column; }
        .btn { width: 100%; }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .stat-card .stat-number { font-size: 2.25rem; }
        .back-button { font-size: 0.75rem; padding: 0.625rem 1rem; }
    }
</style>

<div class="katalog-container">
    <!-- Back Button -->
    <a href="{{ route('profile-anggota') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Profile
    </a>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1>Katalog Perusahaan Saya</h1>
                <p>Kelola katalog perusahaan yang akan ditampilkan di E-Katalog HIPMI Jawa Barat</p>
            </div>
            {{--
                Tombol tambah HANYA muncul jika:
                1. Anggota sudah approved
                2. Belum punya katalog sama sekali (karena katalog dibuat otomatis saat daftar,
                   tombol ini praktis tidak akan pernah muncul — tapi tetap ada sebagai fallback)
            --}}
@if(Auth::guard('anggota')->user()->status === 'approved')
            <a href="{{ route('profile-anggota.katalog.create') }}" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Katalog
            </a>
            @endif
        </div>
    </div>

    <!-- Info box: katalog otomatis dibuat dari data pendaftaran -->
    @if($hasKatalog)
    <div class="info-box">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 16v-4"/>
            <path d="M12 8h.01"/>
        </svg>
        <div class="info-box-content">
            <h4>Katalog dibuat otomatis dari data pendaftaran Anda</h4>
            <p>
                Data perusahaan (nama, bidang usaha, alamat, kontak) sudah terisi dari form pendaftaran.
                Silakan klik <strong>Edit</strong> untuk melengkapi deskripsi, foto tambahan, dan embed Google Maps agar katalog Anda tampil lebih menarik.
            </p>
        </div>
    </div>
    @endif

    <!-- Warning untuk anggota belum terverifikasi -->
    @if(Auth::guard('anggota')->user()->status !== 'approved')
    <div class="alert alert-warning">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
        </svg>
        Akun Anda sedang dalam proses verifikasi. Katalog akan aktif setelah admin menyetujui pendaftaran Anda.
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Katalog</div>
        </div>
        <div class="stat-card pending">
            <div class="stat-number">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
        <div class="stat-card approved">
            <div class="stat-number">{{ $stats['approved'] }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-number">{{ $stats['rejected'] }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>

    <!-- Katalog List -->
    @if($katalogs->count() > 0)
    <div class="katalog-list">
        @foreach($katalogs as $katalog)
        <div class="katalog-card">
            <div class="katalog-content">
                <img src="{{ $katalog->logo_url }}" alt="{{ $katalog->company_name }}" class="katalog-logo">

                <div class="katalog-info">
                    <div class="katalog-header">
                        <div>
                            <h3 class="katalog-title">{{ $katalog->company_name }}</h3>
                            <p class="katalog-field">{{ $katalog->business_field }}</p>
                        </div>
                        <span class="status-badge {{ $katalog->status }}">
                            @if($katalog->status === 'pending')
                                Menunggu Verifikasi
                            @elseif($katalog->status === 'approved')
                                Disetujui
                            @else
                                Ditolak
                            @endif
                        </span>
                    </div>

                    {{-- Tampilkan warning jika deskripsi masih placeholder --}}
                    @php
                        $isPlaceholder = str_contains($katalog->description, 'Deskripsi perusahaan belum diisi');
                    @endphp

                    @if($isPlaceholder)
                    <div class="description-placeholder">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        Deskripsi belum diisi — klik Edit untuk melengkapi
                    </div>
                    @endif

                    <div class="katalog-description">
                        {{ Str::limit($katalog->description, 200) }}
                    </div>

                    @if($katalog->status === 'rejected' && $katalog->rejection_reason)
                    <div class="rejection-box">
                        <strong>Alasan Penolakan:</strong>
                        <p>{{ $katalog->rejection_reason }}</p>
                    </div>
                    @endif

                    <div class="katalog-actions">
                        @if($katalog->status === 'approved')
                            <a href="{{ route('e-katalog.detail', $katalog) }}" target="_blank" class="btn btn-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                Lihat di E-Katalog
                            </a>
                        @endif

                        @if($katalog->canBeEdited())
                            <a href="{{ route('profile-anggota.katalog.edit', $katalog) }}" class="btn btn-success">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Edit & Lengkapi
                            </a>

                            <form action="{{ route('profile-anggota.katalog.destroy', $katalog) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus katalog ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($katalogs->hasPages())
    <div class="pagination">
        {{ $katalogs->links() }}
    </div>
    @endif

    @else
    <!-- Empty State — seharusnya tidak pernah muncul karena katalog auto-dibuat -->
    <div class="empty-state">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <line x1="9" y1="9" x2="15" y2="9"/>
            <line x1="9" y1="15" x2="15" y2="15"/>
        </svg>
        <h3>Belum ada katalog</h3>
        <p>Terjadi kesalahan saat membuat katalog otomatis. Silakan hubungi admin.</p>
    </div>
    @endif
</div>
@endsection