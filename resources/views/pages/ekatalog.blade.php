@extends('layouts.app')

@section('title', 'E-Katalog - HIPMI Jawa Barat')

@section('content')

    <section class="page-banners">
        <div class="page-banner">
            <h1>E-Katalog</h1>
            <p>Anggota & Pengurus HIPMI Jawa Barat</p>
        </div>
    </section>

    <section class="search-katalogs">
        <div class="search-katalog">
            <!-- Search Box -->
            <div class="search-wrapper">
                <form action="{{ route('e-katalog') }}" method="GET" class="search-box-enhanced">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="text" name="search" placeholder="Cari nama perusahaan atau bidang usaha..."
                        value="{{ request('search') }}" class="search-input">
                    <button type="submit" class="search-button">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form action="{{ route('e-katalog') }}" method="GET" class="filter-form">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <div class="filter-grid">
                        <!-- Filter Bidang -->
                        <div class="filter-item">
                            <label class="filter-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                Bidang
                            </label>
                            <select name="bidang" class="filter-select">
                                <option value="">Semua Bidang</option>
                                @foreach($bidangList as $bidang)
                                    <option value="{{ $bidang }}" {{ request('bidang') == $bidang ? 'selected' : '' }}>
                                        {{ $bidang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tipe (Anggota atau Pengurus) -->
                        <div class="filter-item">
                            <label class="filter-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                Tipe Katalog
                            </label>
                            <select name="tipe" class="filter-select">
                                <option value="">Semua Tipe</option>
                                <option value="anggota" {{ request('tipe') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                <option value="pengurus" {{ request('tipe') == 'pengurus' ? 'selected' : '' }}>Pengurus HIPMI
                                </option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        @if(request('bidang') || request('tipe') || request('search'))
                            <div class="filter-item filter-reset">
                                <a href="{{ route('e-katalog') }}" class="reset-btn">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                        <path d="M21 3v5h-5"></path>
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                        <path d="M3 21v-5h5"></path>
                                    </svg>
                                    Reset Filter
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <script>
                const filterForm = document.querySelector('.filter-form');
                const bidangSelect = filterForm?.querySelector('select[name="bidang"]');
                const tipeSelect = filterForm?.querySelector('select[name="tipe"]');

                if (bidangSelect) {
                    bidangSelect.addEventListener('change', function () {
                        filterForm.submit();
                    });
                }

                if (tipeSelect) {
                    tipeSelect.addEventListener('change', function () {
                        filterForm.submit();
                    });
                }
            </script>
        </div>
    </section>

    <section class="e-katalog-wrapper">
        <div class="e-katalog-content">
            @forelse($katalogs as $katalog)
                <a href="{{ route('e-katalog.detail', $katalog->id) }}">
                    <div class="katalog-card">
                        <img src="{{ $katalog->logo_url }}" alt="{{ $katalog->company_name }}">
                        <div class="container">
                            <h4><b>{{ Str::limit($katalog->company_name, 25, '...') }}</b></h4>
                            <p>{{ Str::limit($katalog->business_field, 30, '...') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #6b7280;">
                    <svg viewBox="0 0 24 24" style="width: 80px; height: 80px; margin: 0 auto 1rem; stroke: #d1d5db;"
                        fill="none" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <line x1="9" y1="9" x2="15" y2="9" />
                        <line x1="9" y1="15" x2="15" y2="15" />
                    </svg>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #374151; margin-bottom: 0.5rem;">
                        {{ request('search') || request('bidang') || request('tipe') ? 'Tidak ada hasil yang ditemukan' : 'Belum ada katalog tersedia' }}
                    </h3>
                    <p style="font-size: 0.9375rem; color: #6b7280;">
                        {{ request('search') || request('bidang') || request('tipe') ? 'Coba ubah filter atau kata kunci pencarian Anda' : 'Silakan cek kembali nanti' }}
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    @if ($katalogs->hasPages())
        <div
            style="margin-top: 40px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; padding: 2rem 100px 4rem;">

            {{-- Previous --}}
            @if ($katalogs->onFirstPage())
                <span style="padding: 8px 14px; border-radius: 8px; background: #e5e7eb; color: #9ca3af;">‹</span>
            @else
                <a href="{{ $katalogs->previousPageUrl() }}"
                    style="padding: 8px 14px; border-radius: 8px; background: #04293B; color: #FFFF00; text-decoration: none;">‹</a>
            @endif

            {{-- Page Numbers --}}
            @for ($i = 1; $i <= $katalogs->lastPage(); $i++)
                @if ($i == $katalogs->currentPage())
                    <span
                        style="padding: 8px 14px; border-radius: 8px; background: #FFFF00; color: #04293B; font-weight: 600;">{{ $i }}</span>
                @else
                    <a href="{{ $katalogs->url($i) }}"
                        style="padding: 8px 14px; border-radius: 8px; border: 1px solid #04293B; color: #04293B; text-decoration: none;">{{ $i }}</a>
                @endif
            @endfor

            {{-- Next --}}
            @if ($katalogs->hasMorePages())
                <a href="{{ $katalogs->nextPageUrl() }}"
                    style="padding: 8px 14px; border-radius: 8px; background: #04293B; color: #FFFF00; text-decoration: none;">›</a>
            @else
                <span style="padding: 8px 14px; border-radius: 8px; background: #e5e7eb; color: #9ca3af;">›</span>
            @endif

        </div>
    @endif

@endsection