@extends ('layouts.app')

@section('title', $berita->judul . ' - Berita HIPMI Jawa Barat')

@section('content')

    <section class="page-banners">
        <div class="page-banner">
            <h1>{{ $berita->judul }}</h1>
            <p>{{ $berita->tanggal_format }}</p>
        </div>
    </section>

    <section class="berita-wr">
        <div class="berita">

            {{-- LEFT CONTENT --}}
            <div class="berita-left">

                <div class="detail-berita-content">
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}">
                    <p style="white-space: pre-line;">
                        {{ $berita->konten }}
                    </p>
                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="berita-right">

                {{-- Berita Populer --}}
                <h1 class="berita-badge">Berita Populer</h1>
                @forelse($beritaPopuler as $populer)
                    <div class="berita-right-item">
                        <a href="{{ route('berita-detail', $populer->slug) }}" class="berita-right-item-image">
                            <img src="{{ $populer->gambar_url }}" alt="{{ $populer->judul }}">
                        </a>
                        <div class="berita-right-item-content">
                            <h3>{{ $populer->judul }}</h3>
                            <p class="berita-home-date">{{ $populer->tanggal_format }}</p>
                            <p>{{ Str::limit(strip_tags($populer->konten), 100, '...') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="empty-text">Belum ada berita populer</p>
                @endforelse

                {{-- Berita Terbaru --}}
                <h1 class="berita-badge">Berita Terbaru</h1>
                @forelse($beritaTerbaru as $terbaru)
                    <div class="berita-right-item">
                        <a href="{{ route('berita-detail', $terbaru->slug) }}" class="berita-right-item-image">
                            <img src="{{ $terbaru->gambar_url }}" alt="{{ $terbaru->judul }}">
                        </a>
                        <div class="berita-right-item-content">
                            <h3>{{ $terbaru->judul }}</h3>
                            <p class="berita-home-date">{{ $terbaru->tanggal_format }}</p>
                            <p>{{ Str::limit(strip_tags($terbaru->konten), 100, '...') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="empty-text">Belum ada berita terbaru</p>
                @endforelse

            </div>
        </div>
    </section>

@endsection