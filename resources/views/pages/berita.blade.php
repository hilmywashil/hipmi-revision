@extends ('layouts.app')

@section('title', 'Berita - HIPMI Jawa Barat')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

@push('styles')
    <style>
        /* Fix text overflow */
        .berita-item-content h3,
        .berita-item-content p,
        .berita-right-item-content h3,
        .berita-right-item-content p {
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .berita-item-content,
        .berita-right-item-content {
            max-width: 100%;
            overflow: hidden;
        }
    </style>

@endpush
@section('content')
    <section class="page-banners">
        <div class="page-banner">
            <h1>Berita & Dokumentasi</h1>
            <p>Berita & Kegiatan seputar HIPMI Jawa Barat</p>
        </div>
    </section>

    <section class="search-bars">
        <div class="search-bar">
            <form action="{{ route('berita') }}" method="GET" class="search-box">
                <input type="text" name="search" placeholder="Cari berita..." value="{{ $search ?? '' }}">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </section>

    <section class="berita-wr">
        <div class="berita">
            <div class="berita-left">
                {{-- Berita Utama --}}
                @if(isset($beritaUtama) && $beritaUtama)
                    <div class="berita-item">
                        <a href="{{ route('berita-detail', $beritaUtama->slug) }}" class="berita-item-image">
                            <img src="{{ $beritaUtama->gambar_url }}" alt="{{ $beritaUtama->judul }}">
                        </a>
                        <div class="berita-item-content">
                            <div>
                                <h3>{{ $beritaUtama->judul }}</h3>
                                <p class="berita-home-date">{{ $beritaUtama->tanggal_format }}</p>
                                <p>{{ Str::limit(strip_tags($beritaUtama->konten), 150, '...') }}</p>
                            </div>
                            <a href="{{ route('berita-detail', $beritaUtama->slug) }}" class="berita-home-others-btn-more">Baca
                                Selengkapnya</a>
                        </div>
                    </div>
                @endif

                {{-- Berita Lainnya --}}
                @forelse($beritas as $berita)
                    <div class="berita-item">
                        <a href="{{ route('berita-detail', $berita->slug) }}" class="berita-item-image">
                            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}">
                        </a>
                        <div class="berita-item-content">
                            <div>
                                <h3>{{ $berita->judul }}</h3>
                                <p class="berita-home-date">{{ $berita->tanggal_format }}</p>
                                <p>{{ Str::limit(strip_tags($berita->konten), 150, '...') }}</p>
                            </div>
                            <a href="{{ route('berita-detail', $berita->slug) }}" class="berita-home-others-btn-more">Baca
                                Selengkapnya</a>
                        </div>
                    </div>
                @empty
                    @if(!isset($beritaUtama) || !$beritaUtama)
                        <div style="text-align: center; padding: 3rem; color: #9ca3af;">
                            <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">Belum Ada Berita</p>
                            <p>Berita akan segera ditampilkan di sini</p>
                        </div>
                    @endif
                @endforelse

                {{-- Pagination --}}
                @if($beritas->hasPages())
                    <div style="margin-top: 2rem;">
                        {{ $beritas->links() }}
                    </div>
                @endif
            </div>

            <div class="berita-right">
                {{-- Berita Populer --}}
                <h1 class="berita-badge">Berita Populer</h1>
                @forelse($beritaPopuler as $populer)
                    <div class="berita-right-item">
                        <a href="{{ route('berita-detail', $populer->slug) }}" class="berita-right-item-image">
                            <img src="{{ $populer->gambar_url }}" alt="{{ $populer->judul }}">
                        </a>
                        <div class="berita-right-item-content">
                            <div>
                                <h3>{{ $populer->judul }}</h3>
                                <p class="berita-home-date">{{ $populer->tanggal_format }}</p>
                                <p>{{ Str::limit(strip_tags($populer->konten), 100, '...') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #9ca3af; font-size: 0.875rem; padding: 1rem 0;">Belum ada berita populer</p>
                @endforelse

                {{-- Berita Terbaru --}}
                <h1 class="berita-badge">Berita Terbaru</h1>
                @forelse($beritaTerbaru as $terbaru)
                    <div class="berita-right-item">
                        <a href="{{ route('berita-detail', $terbaru->slug) }}" class="berita-right-item-image">
                            <img src="{{ $terbaru->gambar_url }}" alt="{{ $terbaru->judul }}">
                        </a>
                        <div class="berita-right-item-content">
                            <div>
                                <h3>{{ $terbaru->judul }}</h3>
                                <p class="berita-home-date">{{ $terbaru->tanggal_format }}</p>
                                <p>{{ Str::limit(strip_tags($terbaru->konten), 100, '...') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="color: #9ca3af; font-size: 0.875rem; padding: 1rem 0;">Belum ada berita terbaru</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection