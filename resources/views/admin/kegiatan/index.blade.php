{{-- resources/views/admin/kegiatan/index.blade.php --}}
@extends('admin.layouts.admin-layout')

@section('title', 'Kelola Kegiatan')
@section('page-title', 'Kelola Kegiatan BPD')

@php
$activeMenu = 'kegiatan';
@endphp

@push('styles')
<style>
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 250px;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem;
        padding-right: 3rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9375rem;
    }

    .search-box button {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: #0a2540;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
    }

    .filter-select {
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9375rem;
        background: white;
    }

    .btn-add {
        background: #0a2540;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
    }

    .btn-add:hover {
        background: #ffd700;
        color: #0a2540;
        transform: translateY(-2px);
    }

    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f9fafb;
    }

    .data-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .data-table tr:hover {
        background: #f9fafb;
    }

    .kegiatan-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .badge-active {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-bidang {
        background: #dbeafe;
        color: #1e40af;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-edit,
    .btn-delete {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-edit {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-edit:hover {
        background: #bfdbfe;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
        border: none;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #fecaca;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        padding: 2rem 0;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }

    .empty-state svg {
        margin: 0 auto 1rem;
        opacity: 0.3;
    }

    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            flex-direction: column;
        }

        .search-box {
            min-width: 100%;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            min-width: 800px;
        }
    }
</style>
@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="action-bar">
    <div class="filter-group">
        @if($admin->isSuperAdmin())
        {{-- Super Admin bisa filter semua bidang --}}
        <form action="{{ route('admin.kegiatan.index') }}" method="GET">
            <select name="bidang" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Bidang</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="bidang_{{ $i }}" {{ request('bidang') == "bidang_$i" ? 'selected' : '' }}>
                    Bidang {{ $i }}
                    </option>
                @endfor
            </select>
        </form>
        @else
        {{-- BPD hanya lihat bidangnya --}}
        <div style="padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; background: #f3f4f6; font-size: 0.9375rem; color: #374151; font-weight: 500;">
            📌 {{ $admin->bidang_name }}
        </div>
        @endif
    </div>

    <a href="{{ route('admin.kegiatan.create') }}" class="btn-add">
        + Tambah Kegiatan
    </a>
</div>

<div class="table-container">
    @if($kegiatan->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Bidang</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatan as $item)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="kegiatan-image">
                </td>
                <td>
                    <div style="max-width: 300px;">
                        <strong>{{ $item->judul }}</strong>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">
                            {{ Str::limit($item->konten, 80) }}
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-bidang">{{ $item->bidang_name }}</span>
                </td>
                <td>{{ $item->tanggal_publish->format('d M Y') }}</td>
                <td>
                    @if($item->is_active)
                    <span class="badge badge-active">Aktif</span>
                    @else
                    <span class="badge badge-inactive">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.kegiatan.edit', $item->id) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('admin.kegiatan.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $kegiatan->links() }}
    </div>
    @else
    <div class="empty-state">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="18" height="18" rx="2" />
            <line x1="9" y1="9" x2="15" y2="15" />
            <line x1="15" y1="9" x2="9" y2="15" />
        </svg>
        <h3>Belum ada kegiatan</h3>
        <p>Tambahkan kegiatan pertama Anda</p>
    </div>
    @endif
</div>

@endsection