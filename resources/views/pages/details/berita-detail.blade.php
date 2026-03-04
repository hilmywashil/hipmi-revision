@extends ('layouts.app')

@section('title', $berita->judul . ' - Berita HIPMI Jawa Barat')

@push('styles')
<style>
    /* Fix text overflow */
    .detail-berita-content p,
    .page-banner h1,
    .berita-detail-right-item-content h3,
    .berita-detail-right-item-content p {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    .detail-berita-content,
    .berita-detail-right-item-content {
        max-width: 100%;
        overflow: hidden;
    }
</style>
@endpush

@section('content')

    <section class="page-banner">
        <h1>{{ $berita->judul }}</h1>
        <p>{{ $berita->tanggal_format }}</p>
    </section>

    <section class="detail-berita">
        <div class="detail-berita-content">
            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}">
            <p style="white-space: pre-line;">{{ $berita->konten }}</p>
        </div>

        <div class="berita-detail-right">
            {{-- Berita Populer --}}
            <h1 class="berita-badge">Berita Populer</h1>
            @forelse($beritaPopuler as $populer)
            <div class="berita-detail-right-item">
                <a href="{{ route('berita-detail', $populer->slug) }}" class="berita-detail-right-item-image">
                    <img src="{{ $populer->gambar_url }}" alt="{{ $populer->judul }}">
                </a>
                <div class="berita-detail-right-item-content">
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
            <div class="berita-detail-right-item">
                <a href="{{ route('berita-detail', $terbaru->slug) }}" class="berita-detail-right-item-image">
                    <img src="{{ $terbaru->gambar_url }}" alt="{{ $terbaru->judul }}">
                </a>
                <div class="berita-detail-right-item-content">
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

    </section>
@endsection