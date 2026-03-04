@extends('admin.layouts.admin-layout')

@section('title', 'Kelola E-Katalog')
@section('page-title', 'E-Katalog')

@php
$activeMenu = 'katalog';
@endphp

@push('styles')
<style>
    .katalog-table-container {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0a2540;
        letter-spacing: -0.025em;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        transition: width 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
    }

    .stat-card.active {
        background: white;
        border-color: currentColor;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .stat-card.active::before {
        width: 100%;
        opacity: 0.05;
    }

    .stat-card.all {
        color: #3b82f6;
    }

    .stat-card.all::before {
        background: #3b82f6;
    }

    .stat-card.pending {
        color: #f59e0b;
    }

    .stat-card.pending::before {
        background: #f59e0b;
    }

    .stat-card.approved {
        color: #10b981;
    }

    .stat-card.approved::before {
        background: #10b981;
    }

    .stat-card.rejected {
        color: #ef4444;
    }

    .stat-card.rejected::before {
        background: #ef4444;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.1em;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: #0a2540;
        letter-spacing: -0.05em;
        line-height: 1;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ffd700 0%, #f5c400 100%);
        color: #0a2540;
        padding: 0.75rem 1.75rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        letter-spacing: 0.025em;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
    }

    .btn-primary svg {
        transition: transform 0.2s ease;
    }

    .btn-primary:hover svg {
        transform: rotate(90deg);
    }

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table th {
        background: #f8fafc;
        padding: 1rem 0.875rem;
        text-align: left;
        font-weight: 700;
        font-size: 0.75rem;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .data-table th:nth-child(1) {
        width: 80px;
    }

    .data-table th:nth-child(2) {
        width: 180px;
    }

    .data-table th:nth-child(3) {
        width: 140px;
    }

    .data-table th:nth-child(4) {
        width: 160px;
    }

    .data-table th:nth-child(5) {
        width: 180px;
    }

    .data-table th:nth-child(6) {
        width: 120px;
    }

    .data-table th:nth-child(7) {
        width: 110px;
    }

    .data-table th:nth-child(8) {
        width: 100px;
    }

    .data-table th:first-child {
        border-top-left-radius: 10px;
    }

    .data-table th:last-child {
        border-top-right-radius: 10px;
    }

    .data-table td {
        padding: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.8125rem;
        color: #334155;
        vertical-align: middle;
    }

    .data-table tbody tr {
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: #f8fafc;
    }

    .katalog-logo {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #f1f5f9;
    }

    /* Status & Source Badges */
    .status-badge {
        padding: 0.3125rem 0.75rem;
        border-radius: 6px;
        font-size: 0.6875rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        letter-spacing: 0.025em;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .status-approved {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .source-badge {
        padding: 0.1875rem 0.5rem;
        border-radius: 5px;
        font-size: 0.625rem;
        font-weight: 700;
        display: inline-block;
        margin-top: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .source-admin {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .source-anggota {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    /* Creator Info */
    .creator-info {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .creator-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6875rem;
        font-weight: 700;
        flex-shrink: 0;
        border: 2px solid;
    }

    .creator-avatar.anggota {
        background: #f3f4f6;
        color: #6b7280;
        border-color: #e5e7eb;
    }

    .creator-avatar.admin {
        background: linear-gradient(135deg, #ffd700 0%, #f5c400 100%);
        color: #0a2540;
        border-color: #ffd700;
    }

    .creator-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .creator-details {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .creator-name {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.8125rem;
        line-height: 1.2;
    }

    .creator-meta {
        color: #64748b;
        font-size: 0.6875rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        line-height: 1.2;
    }

    .creator-meta .separator {
        color: #cbd5e1;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.125rem 0.375rem;
        background: #f1f5f9;
        border-radius: 4px;
        font-size: 0.625rem;
        font-weight: 600;
        color: #475569;
    }

    /* Dropdown Action Button */
    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        background: white;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 700;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .btn-action:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .btn-action svg {
        transition: transform 0.2s ease;
    }

    .action-dropdown.active .btn-action svg {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        min-width: 180px;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        border: 2px solid #e2e8f0;
    }

    .action-dropdown.active .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: #334155;
        font-size: 0.8125rem;
        font-weight: 600;
        transition: all 0.2s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item:first-child {
        border-radius: 8px 8px 0 0;
    }

    .dropdown-item:last-child {
        border-radius: 0 0 8px 8px;
    }

    .dropdown-item:hover {
        background: #f8fafc;
    }

    .dropdown-item svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .dropdown-item.approve {
        color: #065f46;
    }

    .dropdown-item.approve:hover {
        background: #d1fae5;
    }

    .dropdown-item.reject {
        color: #991b1b;
    }

    .dropdown-item.reject:hover {
        background: #fee2e2;
    }

    .dropdown-item.view {
        color: #3730a3;
    }

    .dropdown-item.view:hover {
        background: #e0e7ff;
    }

    .dropdown-item.edit {
        color: #1e40af;
    }

    .dropdown-item.edit:hover {
        background: #dbeafe;
    }

    .dropdown-item.delete {
        color: #991b1b;
    }

    .dropdown-item.delete:hover {
        background: #fee2e2;
    }

    .dropdown-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 0.25rem 0;
    }

    /* Alert */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        stroke: #cbd5e1;
        stroke-width: 1.5;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 0.9375rem;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        gap: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="katalog-table-container">
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-grid">
        <a href="{{ route('admin.katalog.index', ['status' => 'all']) }}" style="text-decoration: none;">
            <div class="stat-card all {{ $status === 'all' ? 'active' : '' }}">
                <div class="stat-label">Total Katalog</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
        </a>
        <a href="{{ route('admin.katalog.index', ['status' => 'pending']) }}" style="text-decoration: none;">
            <div class="stat-card pending {{ $status === 'pending' ? 'active' : '' }}">
                <div class="stat-label">Menunggu Verifikasi</div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
            </div>
        </a>
        <a href="{{ route('admin.katalog.index', ['status' => 'approved']) }}" style="text-decoration: none;">
            <div class="stat-card approved {{ $status === 'approved' ? 'active' : '' }}">
                <div class="stat-label">Disetujui</div>
                <div class="stat-value">{{ $stats['approved'] }}</div>
            </div>
        </a>
        <a href="{{ route('admin.katalog.index', ['status' => 'rejected']) }}" style="text-decoration: none;">
            <div class="stat-card rejected {{ $status === 'rejected' ? 'active' : '' }}">
                <div class="stat-label">Ditolak</div>
                <div class="stat-value">{{ $stats['rejected'] }}</div>
            </div>
        </a>
    </div>

    <div class="table-header">
        <h3>Daftar E-Katalog Perusahaan</h3>
        <a href="{{ route('admin.katalog.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Katalog
        </a>
    </div>

    @if($katalogs->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Perusahaan</th>
                <th>Bidang Usaha</th>
                <th>Kontak</th>
                <th>Dibuat Oleh</th>
                <th>Bidang</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($katalogs as $katalog)
            <tr>
                <td>
                    <img src="{{ $katalog->logo_url }}" alt="{{ $katalog->company_name }}" class="katalog-logo">
                </td>
                <td>
                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.25rem; font-size: 0.8125rem;">
                        {{ $katalog->company_name }}
                    </div>
                    @if($katalog->isSubmittedByAnggota())
                    <span class="source-badge source-anggota">Anggota</span>
                    @else
                    <span class="source-badge source-admin">Admin</span>
                    @endif
                </td>
                <td>
                    <span style="font-weight: 600; color: #475569; font-size: 0.8125rem;">
                        {{ $katalog->business_field }}
                    </span>
                </td>
                <td>
                    <div style="font-weight: 600; color: #334155; margin-bottom: 0.1875rem; font-size: 0.8125rem;">
                        {{ $katalog->phone }}
                    </div>
                    <div style="font-size: 0.6875rem; color: #64748b;">
                        {{ $katalog->email }}
                    </div>
                </td>
                <td>
                    @if($katalog->isSubmittedByAnggota() && $katalog->anggota)
                    <div class="creator-info">
                        <div class="creator-avatar anggota">
                            {{ strtoupper(substr($katalog->anggota->nama_usaha, 0, 2)) }}
                        </div>
                        <div class="creator-details">
                            <div class="creator-name">{{ $katalog->anggota->nama_usaha }}</div>
                            <div class="creator-meta">{{ $katalog->anggota->domisili }}</div>
                        </div>
                    </div>
                    @elseif($katalog->admin)
                    <div class="creator-info">
                        <div class="creator-avatar admin">
                            @if($katalog->admin->photo_url)
                            <img src="{{ $katalog->admin->photo_url }}" alt="{{ $katalog->admin->username }}">
                            @else
                            {{ $katalog->admin->initials }}
                            @endif
                        </div>
                        <div class="creator-details">
                            <div class="creator-name">{{ $katalog->admin->username }}</div>
                            <div class="creator-meta">
                                @if($katalog->admin->isSuperAdmin())
                                <span class="role-badge">Super Admin</span>
                                @elseif($katalog->admin->isBPD())
                                <span class="role-badge">BPD</span>
                                @elseif($katalog->admin->isBPC())
                                <span class="role-badge">BPC</span>
                                @endif

                                @if($katalog->admin->domisili)
                                <span class="separator">•</span>
                                {{ $katalog->admin->domisili }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="creator-info">
                        <div class="creator-avatar" style="background: #e2e8f0; color: #64748b; border-color: #cbd5e1;">
                            A
                        </div>
                        <div class="creator-details">
                            <div class="creator-name" style="color: #94a3b8;">Admin</div>
                        </div>
                    </div>
                    @endif
                </td>
                <td>
                    @if($katalog->admin && $katalog->admin->bidang)
                    <div style="display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 1px solid #fbbf24; border-radius: 6px; font-weight: 700; color: #78350f; font-size: 0.75rem;">
                        {{ $katalog->admin->bidang_name }}
                    </div>
                    @else
                    <span style="color: #cbd5e1; font-size: 0.75rem;">—</span>
                    @endif
                </td>
                <td>
                    <span class="status-badge status-{{ $katalog->status }}">
                        @if($katalog->status === 'pending')
                        Pending
                        @elseif($katalog->status === 'approved')
                        Approved
                        @else
                        Rejected
                        @endif
                    </span>
                </td>
                <td>
                    @php
                    $currentAdmin = Auth::guard('admin')->user();
                    $canManage = false;

                    if ($currentAdmin->isSuperAdmin()) {
                    $canManage = true;
                    }
                    elseif (!$katalog->isSubmittedByAnggota()) {
                    if ($currentAdmin->isBPD()) {
                    if ($katalog->admin && $katalog->admin->bidang === $currentAdmin->bidang) {
                    $canManage = true;
                    }
                    }
                    }
                    @endphp

                    <div class="action-dropdown">
                        <button type="button" class="btn-action">
                            <span>Aksi</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            @if($katalog->status === 'approved')
                            <a href="{{ route('e-katalog.detail', $katalog) }}" target="_blank" class="dropdown-item view">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                Lihat Detail
                            </a>
                            @else
                            <button type="button" class="dropdown-item view" onclick='openPreviewModal({
    id: {{ $katalog->id }},
    company_name: @json($katalog->company_name),
    business_field: @json($katalog->business_field),
    email: @json($katalog->email),
    phone: @json($katalog->phone),
    address: @json($katalog->address),
    description: @json($katalog->description),
    logo_url: @json($katalog->logo_url),
    map_embed_url: @json($katalog->map_embed_url),
    status: @json($katalog->status)
})'>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                Preview
                            </button>
                            @endif

                            @if($katalog->status === 'pending' && $katalog->isSubmittedByAnggota())
                            <div class="dropdown-divider"></div>

                            <button type="button" class="dropdown-item approve" onclick='openPreviewModal({
    id: {{ $katalog->id }},
    company_name: @json($katalog->company_name),
    business_field: @json($katalog->business_field),
    email: @json($katalog->email),
    phone: @json($katalog->phone),
    address: @json($katalog->address),
    description: @json($katalog->description),
    logo_url: @json($katalog->logo_url),
    map_embed_url: @json($katalog->map_embed_url),
    status: @json($katalog->status)
}, "approve")'>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Approve
                            </button>
                            <button type="button" class="dropdown-item reject" onclick="openRejectModal({{ $katalog->id }})">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Reject
                            </button>
                            @endif

                            @if($canManage)
                            <div class="dropdown-divider"></div>

                            <a href="{{ route('admin.katalog.edit', $katalog) }}" class="dropdown-item edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Edit
                            </a>
                            @endif

                            @if($currentAdmin->isSuperAdmin())
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('admin.katalog.destroy', $katalog) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display: inline; width: 100%;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                            @elseif($currentAdmin->isBPD())
                            @if(
                            ($katalog->isSubmittedByAnggota() && $katalog->status !== 'approved') ||
                            (!$katalog->isSubmittedByAnggota() && $canManage)
                            )
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('admin.katalog.destroy', $katalog) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display: inline; width: 100%;">
                                {{-- BAGIAN LANJUTAN DARI PART 1 --}}
                                {{-- Taruh kode ini setelah baris terakhir dari Part 1 --}}

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $katalogs->appends(['status' => $status])->links() }}
    </div>
    @else
    <div class="empty-state">
        <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
            <line x1="9" y1="9" x2="15" y2="9" />
            <line x1="9" y1="15" x2="15" y2="15" />
        </svg>
        <h3>Belum ada data katalog</h3>
        <p>Klik tombol "Tambah Katalog" untuk menambahkan data pertama</p>
    </div>
    @endif
</div>

{{-- MODAL PREVIEW KATALOG --}}
<div id="previewModal" class="modal">
    <div class="modal-content large">
        <div class="modal-header">
            <h3>Preview Katalog</h3>
            <button class="modal-close" onclick="closePreviewModal()">&times;</button>
        </div>

        <div class="preview-header">
            <img id="previewLogo" src="" alt="Logo" class="preview-logo">
            <div class="preview-main">
                <div class="preview-company" id="previewCompanyName"></div>
                <div class="preview-field" id="previewBusinessField"></div>
                <span id="previewStatus" class="status-badge"></span>
            </div>
        </div>

        <div class="preview-grid">
            <div class="preview-item">
                <div class="preview-label">Email</div>
                <div class="preview-value" id="previewEmail"></div>
            </div>
            <div class="preview-item">
                <div class="preview-label">Telepon</div>
                <div class="preview-value" id="previewPhone"></div>
            </div>
            <div class="preview-item" style="grid-column: 1 / -1;">
                <div class="preview-label">Alamat</div>
                <div class="preview-value" id="previewAddress"></div>
            </div>
        </div>

        <!-- Maps dalam section terpisah agar lebih lebar -->
        <div class="preview-maps-section">
            <div class="preview-label">Lokasi Google Maps</div>
            <div id="previewMaps"></div>
        </div>
        <div class="preview-description">
            <div class="preview-label">Deskripsi Perusahaan</div>
            <div class="preview-value" id="previewDescription"></div>
        </div>

        <div class="modal-actions" id="previewActions">
            <button type="button" onclick="closePreviewModal()" class="btn-cancel">Tutup</button>
        </div>
    </div>
</div>

{{-- MODAL REJECT --}}
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tolak Katalog</h3>
            <button class="modal-close" onclick="closeRejectModal()">&times;</button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="form-group">
                <label>Alasan Penolakan</label>
                <textarea name="alasan_penolakan" required placeholder="Jelaskan alasan penolakan katalog ini..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" onclick="closeRejectModal()" class="btn-cancel">Batal</button>
                <button type="submit" class="btn-submit">Tolak Katalog</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Modal Base */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        overflow-y: auto;
        padding: 2rem 1rem;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        width: 90%;
        max-width: 500px;
        max-height: 85vh;
        /* ✅ Tambahkan max-height */
        overflow-y: auto;
        /* ✅ Tambahkan scroll jika konten panjang */
    }

    .modal-content.large {
        max-width: 1100px;
        /* ✅ Lebih lebar dari 900px */
        max-height: 90vh;
        /* ✅ Maksimal 90% tinggi layar */
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
    }

    .modal-close {
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        font-size: 1.25rem;
        cursor: pointer;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .modal-close:hover {
        background: #e2e8f0;
        color: #334155;
    }

    /* Preview Modal Styles */
    .preview-header {
        display: flex;
        gap: 1.5rem;
        align-items: start;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .preview-logo {
        width: 120px;
        height: 120px;
        object-fit: contain;
        /* ✅ Ubah dari cover ke contain */
        background: #f8fafc;
        /* ✅ Tambah background agar logo terlihat jelas */
        padding: 8px;
        /* ✅ Tambah padding */
        border-radius: 12px;
        border: 3px solid #f1f5f9;
        flex-shrink: 0;
    }

    .preview-main {
        flex: 1;
    }

    .preview-company {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }

    .preview-field {
        font-size: 1rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .preview-status {
        display: inline-block;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .preview-item {
        background: #f8fafc;
        padding: 1.25rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .preview-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .preview-value {
        font-size: 0.9375rem;
        color: #0f172a;
        font-weight: 600;
        word-break: break-word;
    }

    .preview-description {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
    }

    /* Maps Section */
    .preview-maps-section {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
    }

    .preview-maps-section .preview-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }

    .preview-maps-section iframe {
        width: 100%;
        height: 300px;
        border: 0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .preview-maps-section #previewMaps {
        margin: 0;
    }

    .preview-maps-section #previewMaps span {
        display: block;
        text-align: center;
        padding: 2rem;
        color: #94a3b8;
        font-style: italic;
    }

    .preview-description .preview-label {
        margin-bottom: 0.75rem;
    }

    .preview-description .preview-value {
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .modal-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f1f5f9;
    }

    .modal-actions button {
        flex: 1;
        padding: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .modal-actions .btn-cancel {
        background: #f1f5f9;
        color: #475569;
    }

    .modal-actions .btn-cancel:hover {
        background: #e2e8f0;
    }

    .modal-actions .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .modal-actions .btn-approve:hover {
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .modal-actions .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .modal-actions .btn-reject:hover {
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Reject Modal Form */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 0.625rem;
        font-size: 0.875rem;
        color: #334155;
    }

    .form-group textarea {
        width: 100%;
        padding: 0.875rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        resize: vertical;
        min-height: 120px;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-group textarea:focus {
        outline: none;
        border-color: #ffd700;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
    }

    .modal-actions .btn-submit {
        background: #fee2e2;
        color: #991b1b;
    }

    .modal-actions .btn-submit:hover {
        background: #fecaca;
    }
</style>
@endpush

<script>
    let currentKatalogId = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Setup dropdown toggles
        const dropdownButtons = document.querySelectorAll('.btn-action');

        dropdownButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                const dropdown = this.closest('.action-dropdown');
                const isActive = dropdown.classList.contains('active');

                // Close all dropdowns
                document.querySelectorAll('.action-dropdown').forEach(d => d.classList.remove('active'));

                // Toggle current dropdown
                if (!isActive) {
                    dropdown.classList.add('active');
                }
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.action-dropdown')) {
                document.querySelectorAll('.action-dropdown').forEach(d => d.classList.remove('active'));
            }
        });

        // Close dropdowns when clicking inside dropdown items
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.action-dropdown').forEach(d => d.classList.remove('active'));
            });
        });
    });

    function openPreviewModal(katalog, action = 'view') {
        currentKatalogId = katalog.id;

        console.log('Katalog data:', katalog); // Debug log

        // ✅ FIX: Handle Logo URL dengan benar
        let logoUrl = '';
        if (katalog.logo_url) {
            // Jika sudah ada logo_url dari accessor
            logoUrl = katalog.logo_url;
        } else if (katalog.logo) {
            // Jika hanya ada path logo
            if (katalog.logo.startsWith('http')) {
                logoUrl = katalog.logo;
            } else if (katalog.logo.startsWith('katalog/')) {
                logoUrl = '/storage/' + katalog.logo;
            } else if (!katalog.logo.startsWith('/')) {
                logoUrl = '/storage/' + katalog.logo;
            } else {
                logoUrl = katalog.logo;
            }
        } else {
            // Fallback ke logo default
            logoUrl = '/images/hipmi-logo.png';
        }

        document.getElementById('previewLogo').src = logoUrl;
        document.getElementById('previewLogo').onerror = function() {
            this.src = '/images/hipmi-logo.png';
            console.error('Failed to load logo:', logoUrl);
        };
        console.log('Logo URL:', logoUrl); // Debug log

        // Populate other data
        document.getElementById('previewCompanyName').textContent = katalog.company_name || '-';
        document.getElementById('previewBusinessField').textContent = katalog.business_field || '-';
        document.getElementById('previewEmail').textContent = katalog.email || '-';
        document.getElementById('previewPhone').textContent = katalog.phone || '-';
        document.getElementById('previewAddress').textContent = katalog.address || '-';

        // ✅ FIX: Handle Maps dengan iframe embed
        const mapsElement = document.getElementById('previewMaps');
        if (katalog.map_embed_url && katalog.map_embed_url.trim() !== '') {
            const cleanUrl = katalog.map_embed_url.trim();
            // Tampilkan iframe embed Google Maps
            mapsElement.innerHTML = `
        <iframe 
            src="${cleanUrl}" 
            width="100%" 
            height="300" 
            style="border:0; border-radius: 8px;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    `;
        } else {
            mapsElement.innerHTML = '<span style="color: #cbd5e1;">Tidak ada maps</span>';
        }

        // Description
        document.getElementById('previewDescription').textContent = katalog.description || '-';

        // Set status badge
        const statusBadge = document.getElementById('previewStatus');
        statusBadge.className = `status-badge status-${katalog.status}`;

        let statusText = 'Unknown';
        if (katalog.status === 'pending') {
            statusText = 'Pending';
        } else if (katalog.status === 'approved') {
            statusText = 'Approved';
        } else if (katalog.status === 'rejected') {
            statusText = 'Rejected';
        }
        statusBadge.textContent = statusText;

        // Set action buttons
        const actionsDiv = document.getElementById('previewActions');
        if (action === 'approve' && katalog.status === 'pending') {
            actionsDiv.innerHTML = `
            <button type="button" onclick="closePreviewModal()" class="btn-cancel">Batal</button>
            <button type="button" onclick="openRejectModal(${katalog.id})" class="btn-reject">Tolak</button>
            <form action="/admin/katalog/${katalog.id}/approve" method="POST" style="flex: 1; margin: 0;">
                @csrf
                <button type="submit" class="btn-approve" style="width: 100%;">Setujui Katalog</button>
            </form>
        `;
        } else {
            actionsDiv.innerHTML = `
            <button type="button" onclick="closePreviewModal()" class="btn-cancel">Tutup</button>
        `;
        }

        // Show modal
        document.getElementById('previewModal').classList.add('show');

        // Close all dropdowns
        document.querySelectorAll('.action-dropdown').forEach(d => d.classList.remove('active'));
    }

    function closePreviewModal() {
        document.getElementById('previewModal').classList.remove('show');
        currentKatalogId = null;
    }

    function openRejectModal(katalogId) {
        // Close preview modal if open
        closePreviewModal();

        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/admin/katalog/${katalogId}/reject`;
        modal.classList.add('show');

        // Close all dropdowns when opening modal
        document.querySelectorAll('.action-dropdown').forEach(d => d.classList.remove('active'));
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('show');
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const previewModal = document.getElementById('previewModal');
        const rejectModal = document.getElementById('rejectModal');

        if (event.target === previewModal) {
            closePreviewModal();
        }
        if (event.target === rejectModal) {
            closeRejectModal();
        }
    });
</script>
@endsection