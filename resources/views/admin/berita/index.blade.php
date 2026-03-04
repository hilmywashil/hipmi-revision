{{-- resources/views/admin/berita/index.blade.php --}}
@extends('admin.layouts.admin-layout')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')

@php
$activeMenu = 'berita';
@endphp

@push('styles')
<style>
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .add-btn {
        background: #0a2540;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .add-btn:hover {
        background: #ffd700;
        color: #0a2540;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
    }

    .table-container {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
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
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .berita-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
    }

    .berita-title {
        font-weight: 600;
        color: #0a2540;
        margin-bottom: 0.25rem;
    }

    .berita-date {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-active {
        background: #d1fae5;
        color: #059669;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-populer {
        background: #fef3c7;
        color: #d97706;
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
        font-weight: 600;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-edit:hover {
        background: #3b82f6;
        color: white;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: #d1fae5;
        color: #059669;
        border-left: 4px solid #059669;
    }

    .pagination {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
        stroke: currentColor;
        opacity: 0.5;
    }

    @media (max-width: 1024px) {
        .data-table {
            display: block;
            overflow-x: auto;
        }

        .content-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
    }
</style>
@endpush

@section('content')
@if(session('success'))
<div class="alert alert-success">
    <svg viewBox="0 0 24 24" width="20" height="20">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
        <polyline points="22 4 12 14.01 9 11.01" />
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="content-header">
    <div>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: #0a2540; margin-bottom: 0.5rem;">Daftar Berita</h3>
        <p style="color: #6b7280;">Kelola semua berita dan artikel HIPMI Jawa Barat</p>
    </div>
    <a href="{{ route('admin.berita.create') }}" class="add-btn">
        <svg viewBox="0 0 24 24" width="20" height="20" style="stroke: currentColor; fill: none; stroke-width: 2;">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Tambah Berita
    </a>
</div>

<div class="table-container">
    @if($beritas->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Judul & Tanggal</th>
                <th>Status</th>
                <th>Views</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beritas as $berita)
            <tr>
                <td>
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="berita-image">
                </td>
                <td>
                    <div class="berita-title">{{ $berita->judul }}</div>
                    <div class="berita-date">{{ $berita->tanggal_format }}</div>
                </td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <span class="badge badge-{{ $berita->is_active ? 'active' : 'inactive' }}">
                            {{ $berita->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                        @if($berita->is_populer)
                        <span class="badge badge-populer">Populer</span>
                        @endif
                    </div>
                </td>
                <td>
                    <strong>{{ number_format($berita->views) }}</strong> views
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" style="display: inline;"
                            onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
        {{ $beritas->links() }}
    </div>
    @else
    <div class="empty-state">
        <svg viewBox="0 0 24 24">
            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" />
            <polyline points="13 2 13 9 20 9" />
        </svg>
        <h4 style="margin-bottom: 0.5rem;">Belum Ada Berita</h4>
        <p>Mulai tambahkan berita pertama Anda</p>
    </div>
    @endif
</div>
@endsection