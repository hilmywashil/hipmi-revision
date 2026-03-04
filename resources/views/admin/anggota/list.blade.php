@extends('admin.layouts.admin-layout')

@section('title', 'Daftar Anggota')
@section('page-title', 'Daftar Anggota')

@php
$activeMenu = 'list-anggota';
$admin = auth()->guard('admin')->user();
@endphp

@push('styles')
<style>
    .page-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .page-header h1 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .filter-row {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .filter-select {
        width: 100%;
        padding: 0.625rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        font-size: 0.875rem;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-select:focus {
        outline: none;
        border-color: #0a2540;
        box-shadow: 0 0 0 3px rgba(10, 37, 64, 0.1);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .stat-title {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 500;
    }

    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon svg {
        width: 18px;
        height: 18px;
        stroke-width: 2;
    }

    .stat-icon.total {
        background: #dbeafe;
        color: #1e40af;
    }

    .stat-icon.pending {
        background: #fef3c7;
        color: #d97706;
    }

    .stat-icon.approved {
        background: #d1fae5;
        color: #059669;
    }

    .stat-icon.rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0a2540;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .filter-tab {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #6b7280;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
        font-size: 0.875rem;
    }

    .filter-tab:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .filter-tab.active {
        background: #0a2540;
        color: white;
        border-color: #0a2540;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .table thead {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.875rem;
    }

    .table tbody tr:hover {
        background: #f9fafb;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-badge.approved {
        background: #d1fae5;
        color: #059669;
    }

    .status-badge.rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        flex-shrink: 0;
        padding: 0;
    }

    .btn-icon:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .btn-icon svg {
        width: 16px;
        height: 16px;
        stroke: #6b7280;
        fill: none;
        stroke-width: 2;
    }

    .btn-icon-promote {
        border-color: #2563eb;
    }

    .btn-icon-promote:hover {
        background: #eff6ff;
        border-color: #1e40af;
    }

    .btn-icon-promote svg {
        stroke: #2563eb;
    }

    .btn-icon-delete {
        border-color: #dc2626;
        background: white;
    }

    .btn-icon-delete:hover {
        background: #fef2f2;
        border-color: #b91c1c;
    }

    .btn-icon-delete svg {
        stroke: #dc2626;
    }

    .btn-icon-delete:hover svg {
        stroke: #b91c1c;
    }

    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: #0a2540;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
        white-space: nowrap;
    }

    .btn-create:hover {
        background: #051728;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(10, 37, 64, 0.2);
    }

    .btn-create:active {
        transform: translateY(0);
    }

    .btn-create svg {
        width: 20px;
        height: 20px;
        stroke: white;
        fill: none;
        stroke-width: 2;
    }

    .readonly-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #fef3c7;
        border: 1px solid #fbbf24;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #d97706;
        font-weight: 500;
        white-space: nowrap;
    }

    .readonly-badge svg {
        flex-shrink: 0;
    }

    .pagination-wrapper {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .pagination-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .pagination-btn {
        padding: 0.5rem 1rem;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        transition: all 0.2s;
        font-family: 'Montserrat', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
    }

    .pagination-btn:hover:not(.disabled) {
        background: #f3f4f6;
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-btn.active {
        background: #0a2540;
        color: white;
        border-color: #0a2540;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        stroke: #d1d5db;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem;
        }

        .page-header h1 {
            font-size: 1.25rem;
        }

        .filter-section {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-title {
            font-size: 0.75rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
        }

        .stat-icon svg {
            width: 16px;
            height: 16px;
        }

        .filter-tabs {
            gap: 0.375rem;
        }

        .filter-tab {
            padding: 0.5rem 0.75rem;
            font-size: 0.8125rem;
        }

        .table th,
        .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8125rem;
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
        }

        .pagination-wrapper {
            flex-direction: column;
            gap: 1rem;
            padding: 1.25rem 1rem;
            align-items: flex-start;
        }

        .pagination-info {
            font-size: 0.8125rem;
            width: 100%;
        }

        .pagination-buttons {
            width: 100%;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination-btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.8125rem;
            min-width: 36px;
        }

        .btn-create {
            padding: 0.625rem 1.25rem;
            font-size: 0.8125rem;
        }

        .readonly-badge {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        .readonly-badge svg {
            width: 14px;
            height: 14px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 0.875rem;
        }

        .page-header h1 {
            font-size: 1.125rem;
        }

        .filter-group {
            min-width: 100%;
        }

        .page-header > div > div {
            flex-wrap: wrap;
            gap: 0.5rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
        <div>
            <h1>Kelola Anggota</h1>
            <p>
                @if($admin->category === 'bpd')
                Lihat semua anggota HIPMI Jawa Barat (Read-Only)
                @else
                Kelola dan verifikasi pendaftaran anggota {{ $admin->domisili }}
                @endif
            </p>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            @if($admin->category !== 'bpd')
            <a href="{{ route('admin.anggota.create') }}" class="btn-create">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Anggota
            </a>
            @endif

            @if($admin->category === 'bpd')
            <span class="readonly-badge">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                View Only
            </span>
            @endif
        </div>
    </div>
</div>

@if($admin->category === 'bpd' && isset($domisiliList))
<div class="filter-section">
    <form method="GET" action="{{ route('admin.anggota.list') }}" id="filterForm">
        <input type="hidden" name="status" value="{{ $status }}">
        <div class="filter-row">
            <div class="filter-group">
                <label class="filter-label">Filter Domisili</label>
                <select name="domisili" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" {{ $domisili === 'all' ? 'selected' : '' }}>
                        Semua Domisili
                    </option>
                    @foreach($domisiliList as $dom)
                    <option value="{{ $dom }}" {{ $domisili === $dom ? 'selected' : '' }}>
                        {{ $dom }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Anggota</span>
            <div class="stat-icon total">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total'] }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Menunggu Verifikasi</span>
            <div class="stat-icon pending">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['pending'] }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Disetujui</span>
            <div class="stat-icon approved">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['approved'] }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Ditolak</span>
            <div class="stat-icon rejected">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $stats['rejected'] }}</div>
    </div>
</div>

<div class="filter-tabs">
    <a href="{{ route('admin.anggota.list', ['status' => 'all', 'domisili' => $domisili ?? 'all']) }}"
        class="filter-tab {{ $status === 'all' ? 'active' : '' }}">
        Semua ({{ $stats['total'] }})
    </a>
    <a href="{{ route('admin.anggota.list', ['status' => 'pending', 'domisili' => $domisili ?? 'all']) }}"
        class="filter-tab {{ $status === 'pending' ? 'active' : '' }}">
        Pending ({{ $stats['pending'] }})
    </a>
    <a href="{{ route('admin.anggota.list', ['status' => 'approved', 'domisili' => $domisili ?? 'all']) }}"
        class="filter-tab {{ $status === 'approved' ? 'active' : '' }}">
        Disetujui ({{ $stats['approved'] }})
    </a>
    <a href="{{ route('admin.anggota.list', ['status' => 'rejected', 'domisili' => $domisili ?? 'all']) }}"
        class="filter-tab {{ $status === 'rejected' ? 'active' : '' }}">
        Ditolak ({{ $stats['rejected'] }})
    </a>
</div>

<div class="table-container">
    @if($anggota->count() > 0)
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Perusahaan</th>
                    <th>Domisili</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anggota as $index => $item)
                <tr>
                    <td>{{ $anggota->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $item->nama_usaha }}</strong>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->nama_usaha_perusahaan }}</td>
                    <td>{{ $item->domisili }}</td>
                    <td>
                        <span class="status-badge {{ $item->status }}">
                            @if($item->status === 'pending')
                            <svg viewBox="0 0 8 8" width="8" height="8" fill="currentColor">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Menunggu
                            @elseif($item->status === 'approved')
                            <svg viewBox="0 0 8 8" width="8" height="8" fill="currentColor">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Disetujui
                            @else
                            <svg viewBox="0 0 8 8" width="8" height="8" fill="currentColor">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Ditolak
                            @endif
                        </span>
                    </td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.anggota.show-readonly', $item) }}"
                                class="btn-icon"
                                title="Lihat Detail">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </a>

                            @if($admin->isSuperAdmin() && $item->status === 'approved')
                            <a href="{{ route('admin.anggota.promote', $item) }}"
                                class="btn-icon btn-icon-promote"
                                title="Promosikan ke Admin">
                                <svg viewBox="0 0 24 24">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                    <polyline points="17 11 19 13 23 9" />
                                </svg>
                            </a>
                            @endif

                            @if($admin->isSuperAdmin())
                            <form action="{{ route('admin.anggota.destroy', $item) }}"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota {{ $item->nama_usaha }}?\n\nTindakan ini akan:\n- Menghapus semua data anggota\n- Menghapus semua file terkait\n- Menghapus akun admin jika ada\n\nTindakan ini TIDAK DAPAT dibatalkan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn-icon btn-icon-delete"
                                    title="Hapus Anggota">
                                    <svg viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $anggota->firstItem() }} - {{ $anggota->lastItem() }} dari {{ $anggota->total() }} anggota
        </div>
        <div class="pagination-buttons">
            @if ($anggota->onFirstPage())
            <span class="pagination-btn disabled">Previous</span>
            @else
            <a href="{{ $anggota->appends(['status' => $status, 'domisili' => $domisili ?? 'all'])->previousPageUrl() }}" class="pagination-btn">
                Previous
            </a>
            @endif

            @foreach($anggota->getUrlRange(1, $anggota->lastPage()) as $page => $url)
            @if ($page == $anggota->currentPage())
            <span class="pagination-btn active">{{ $page }}</span>
            @else
            <a href="{{ $anggota->appends(['status' => $status, 'domisili' => $domisili ?? 'all'])->url($page) }}" class="pagination-btn">
                {{ $page }}
            </a>
            @endif
            @endforeach

            @if ($anggota->hasMorePages())
            <a href="{{ $anggota->appends(['status' => $status, 'domisili' => $domisili ?? 'all'])->nextPageUrl() }}" class="pagination-btn">
                Next
            </a>
            @else
            <span class="pagination-btn disabled">Next</span>
            @endif
        </div>
    </div>
    @else
    <div class="empty-state">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        <h3>Tidak ada data</h3>
        <p>Belum ada anggota untuk kategori ini.</p>
    </div>
    @endif
</div>
@endsection