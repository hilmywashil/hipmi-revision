@extends('layouts.app')

@section('title', $katalog->company_name . ' - E-Katalog HIPMI Jawa Barat')

@section('content')

    <section class="page-banner-2">
        <div class="detail-katalog-info">
            <a href="{{ route('e-katalog') }}" class="fa fa-arrow-left back-button"></a>
            <h1>{{ $katalog->company_name }}</h1>
            <p>{{ $katalog->business_field }}</p>
        </div>
        <div class="detail-katalog-logo">
            <img src="{{ $katalog->logo_url }}" alt="{{ $katalog->company_name }}">
        </div>
    </section>

    <section class="detail-katalog-text">
        <p>{{ $katalog->description }}</p>
    </section>

    {{-- Hanya tampilkan gambar jika user terverifikasi --}}
    @if($canViewFullDetail && $katalog->images && count($katalog->images_url) > 0)
        <section class="detail-katalog-images">
            @foreach($katalog->images_url as $imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $katalog->company_name }}">
            @endforeach
        </section>
    @endif

    {{-- Hanya tampilkan kontak dan map jika user terverifikasi --}}
    @if($canViewFullDetail)
        <section class="detail-katalog-contact-map">
            <div class="detail-katalog-contact">
                <h1>Kontak</h1>
                <div>
                    <div class="footer-item-child">
                        <i class="fa fa-map-marker footer-social-icons"></i>
                        <p>{{ $katalog->address }}</p>
                    </div>
                    <div class="footer-item-child">
                        <i class="fa fa-phone footer-social-icons"></i>
                        <p>{{ $katalog->phone }}</p>
                    </div>
                    <div class="footer-item-child">
                        <i class="fa fa-envelope footer-social-icons"></i>
                        <p>{{ $katalog->email }}</p>
                    </div>
                </div>
            </div>

            @if($katalog->map_embed_url)
                <div class="detail-catalog-contact">
                    <iframe class="map-embed" src="{{ $katalog->map_embed_url }}" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            @endif
        </section>
    @endif

@endsection