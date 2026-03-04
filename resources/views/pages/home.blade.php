@extends('layouts.app')

@section('title', 'HIPMI Jawa Barat')

@section('content')

    <section class="hero-wrapper">
        <div class="hero">
            <div class="hero-1">
                <h1>HIPMI Jawa Barat</h1>
                <p>Sebagai Jembatan Informasi</p>
                <h3>Hayu, kita maju babarengan!</h3>
                <div class="hero-buttons">
                    <a href="{{ route('jadi-anggota') }}" class="btn">Jadi Anggota</a>
                    <a href="https://www.instagram.com/hipmijabar/" target="_blank"
                        class="fa fa-instagram social-icons"></a>
                    <a href="https://www.facebook.com/groups/hipmijabar/" target="_blank"
                        class="fa fa-facebook social-icons"></a>
                    <a href="https://www.linkedin.com/company/hipmi-pt-himpunan-pengusaha-muda-perguruan-tinggi/?originalSubdomain=id"
                        target="_blank" class="fa fa-linkedin social-icons"></a>
                    <a href="#" class="fa fa-youtube social-icons"></a>
                </div>
            </div>
            <div class="hero-2">
                <img src="{{ asset('images/hipmi-logo.png') }}" alt="HIPMI Logo">
            </div>
        </div>
    </section>

    <section class="main-info-wrapper">
        <div class="main-info">
            <div class="info-card">
                <img src="{{ asset('images/icons/users.png') }}" alt="Anggota" class="icon">
                <h2>
                    @if($totalAnggota == 0)
                        0
                    @else
                        <span class="counter" data-target="{{ $totalAnggota }}">0</span>
                    @endif
                </h2>
                <h3>Anggota</h3>
            </div>
            <div class="info-card">
                <img src="{{ asset('images/icons/building.png') }}" alt="Perusahaan" class="icon">
                <h2>
                    @if($totalKatalog == 0)
                        0
                    @else
                        <span class="counter" data-target="{{ $totalKatalog }}">0</span>
                    @endif
                </h2>
                <h3>Perusahaan</h3>
            </div>
            <div class="info-card">
                <img src="{{ asset('images/icons/folder.png') }}" alt="Klasifikasi Usaha" class="icon">
                <h2>
                    @if($totalUmkm == 0)
                        0
                    @else
                        <span class="counter" data-target="{{ $totalUmkm }}">0</span>
                    @endif
                </h2>
                <h3>Klasifikasi Usaha</h3>
            </div>
        </div>
    </section>

    <section class="visi-wrapper">
        <div class="visi">
            <div class="visi-content">
                <h2>Visi Kami</h2>
                <p>Membantu Pengusaha Muda Naik Kelas melalui HIPMI sebagai kontribusi mewujudkan Indonesia Emas 2045</p>
                <h3>Penjelasan :</h3>
                <p>"Naik kelas" didefinisikan sebagai peningkatan kapasitas bisnis melalui beberapa indikator : </p>
                <ul>
                    <li>Peningkatan pendapatan tahunan atau omzet</li>
                    <li>Ekspansi pasar lokal dan internasional</li>
                    <li>Penambahan jumlah tenaga kerja yang diserap oleh anggota HIPMI</li>
                </ul>
            </div>
            <div class="visi-image">
                <img src="{{ asset('images/indonesia-emas-2045.png') }}" alt="Visi Image">
            </div>
        </div>
    </section>


    <section class="misi" id="misi">
        <div class="yellow-accent" style="align-self: center;"></div>
        <h2>Misi Kami</h2>

        @if($misi->count() > 0)
            @foreach($misi as $index => $item)
                @if($index % 2 === 0)
                    {{-- Misi Content (gambar di kanan) --}}
                    <div class="misi-content">
                        <div class="misi-text">
                            <h2>{{ $item->title }}</h2>
                            <p>{!! nl2br(e($item->description)) !!}</p>
                        </div>
                        <div class="misi-image">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                        </div>
                    </div>
                @else
                    {{-- Misi Content Reverse (gambar di kiri) --}}
                    <div class="misi-content-reverse">
                        <div class="misi-text">
                            <h2>{{ $item->title }}</h2>
                            <p>{!! nl2br(e($item->description)) !!}</p>
                        </div>
                        <div class="misi-image">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            {{-- Tampilkan pesan jika belum ada data --}}
            <div style="text-align: center; padding: 3rem 0; color: #6b7280;">
                <p>Belum ada data misi yang tersedia.</p>
            </div>
        @endif
    </section>
    <section class="buku-informasi-home">
        <div class="green-accent" style="align-self: center;"></div>
        <h2>Buku Informasi Pengurus HIPMI Jabar</h2>
        <div class="buku-informasi-home-content">
            <div class="owl-carousel anggota-carousel">
                @forelse($anggotaList as $anggota)
                    <a href="{{ route('detail-buku', $anggota->id) }}">
                        <div class="buku-card">
                            <img src="{{ $anggota->photo_url }}" alt="{{ $anggota->nama_usaha }}" loading="lazy">
                            <div class="container">
                                <h4><b>{{ $anggota->nama_usaha }}</b></h4>
                                <p>{{ Str::limit($anggota->nama_usaha_perusahaan ?? 'Perusahaan Tidak Disebutkan', 30, '...') }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <a href="{{ route('buku-anggota') }}">
                        <div class="buku-card">
                            <img src="{{ asset('images/hipmi-logo.png') }}" alt="HIPMI Logo">
                            <div class="container">
                                <h4><b>Belum Ada Anggota</b></h4>
                                <p>Klik untuk lihat daftar</p>
                            </div>
                        </div>
                    </a>
                @endforelse
            </div>

            <div style="text-align:center; margin-top:25px;">
                <a href="{{ route('buku-anggota') }}" class="btn-ekatalog-home">Lihat Lebih Banyak</a>
            </div>
        </div>
    </section>

    <style>
        /* ================== BUKU INFORMASI HOME SECTION ================== */
        .buku-informasi-home {
            display: flex;
            flex-direction: column;
            padding: 100px 50px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .buku-informasi-home>h2 {
            font-size: clamp(22px, 4vw, 30px);
            color: #04293B;
            margin-bottom: 50px;
            text-align: center;
        }

        .buku-informasi-home-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Owl Carousel Override untuk Konsistensi */
        .anggota-carousel {
            width: 100%;
        }

        .anggota-carousel .owl-stage-outer {
            overflow: hidden;
            padding: 5px;
            /* Prevent shadow clipping */
        }

        .anggota-carousel .owl-stage {
            display: flex !important;
            align-items: stretch !important;
        }

        .anggota-carousel .owl-item {
            display: flex !important;
            height: auto !important;
        }

        .anggota-carousel a {
            color: #04293B;
            text-decoration: none;
            width: 100%;
            display: flex;
            height: 100%;
        }

        /* Buku Card Styling - FULLY RESPONSIVE */
        .buku-card {
            padding: clamp(15px, 3vw, 30px);
            text-align: center;
            border: 1px solid #04293B;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 300px;
        }

        .buku-card:hover {
            cursor: pointer;
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 8px 20px rgba(4, 41, 59, 0.25);
        }

        /* Image dengan Aspect Ratio Fixed */
        .buku-card img {
            width: 100%;
            aspect-ratio: 1 / 1;
            /* Pastikan selalu square */
            object-fit: cover;
            object-position: center;
            margin-bottom: clamp(10px, 2vw, 20px);
            border: #04293B 1px solid;
            border-radius: 10px;
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            flex-shrink: 0;
        }

        .buku-card h4 {
            font-size: clamp(14px, 2vw, 18px);
            margin-bottom: 8px;
            color: #04293B;
            font-weight: 600;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 1.4;
            min-height: 2.8em;
            /* Reserve space for 2 lines */
        }

        .buku-card p {
            font-size: clamp(11px, 1.5vw, 14px);
            color: #666;
            margin: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 1.5;
        }

        .buku-card .container {
            padding: 0 10px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        /* Button */
        .btn-ekatalog-home {
            display: inline-block;
            padding: clamp(8px, 1.5vw, 12px) clamp(18px, 3vw, 30px);
            background: #04293B;
            border: #04293B 1px solid;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: clamp(12px, 1.5vw, 14px);
        }

        .btn-ekatalog-home:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(4, 41, 59, 0.3);
            background: #063a52;
        }

        /* Owl Navigation Buttons Styling - POSISI SAMPING */
        .buku-informasi-home-content {
            position: relative;
        }

        .anggota-carousel .owl-nav {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            pointer-events: none;
            z-index: 10;
            margin-top: 0;
        }

        .anggota-carousel .owl-nav button {
            background: #04293B !important;
            color: white !important;
            width: 45px !important;
            height: 45px !important;
            border-radius: 50% !important;
            font-size: 24px !important;
            transition: all 0.3s ease !important;
            border: none !important;
            outline: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            pointer-events: all;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .anggota-carousel .owl-nav button.owl-prev {
            margin-left: -60px;
        }

        .anggota-carousel .owl-nav button.owl-next {
            margin-right: -60px;
        }

        .anggota-carousel .owl-nav button:hover {
            background: #063a52 !important;
            transform: scale(1.15) !important;
            box-shadow: 0 4px 12px rgba(4, 41, 59, 0.3) !important;
        }

        .anggota-carousel .owl-nav button.disabled {
            opacity: 0.3 !important;
            cursor: not-allowed !important;
        }

        /* Owl Dots Styling */
        .anggota-carousel .owl-dots {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .anggota-carousel .owl-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(4, 41, 59, 0.3) !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }

        .anggota-carousel .owl-dot.active {
            width: 30px;
            border-radius: 5px;
            background: #04293B !important;
        }

        .anggota-carousel .owl-dot:hover {
            background: rgba(4, 41, 59, 0.6) !important;
        }

        /* ================== RESPONSIVE BREAKPOINTS ================== */

        /* Extra Large Desktop (1600px+) */
        @media (min-width: 1600px) {
            .buku-informasi-home {
                padding: 120px 100px;
            }

            .buku-card {
                min-height: 400px;
            }
        }

        /* Large Desktop (1200px - 1599px) */
        @media (min-width: 1200px) and (max-width: 1599px) {
            .buku-informasi-home {
                padding: 100px 80px;
            }

            .buku-card {
                min-height: 360px;
            }
        }

        /* Desktop (992px - 1199px) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .buku-informasi-home {
                padding: 80px 60px;
            }

            .buku-card {
                min-height: 340px;
                padding: 20px;
            }
        }

        /* Tablet (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .buku-informasi-home {
                padding: 60px 80px;
                /* Tambah padding kiri-kanan untuk nav button */
            }

            .buku-informasi-home>h2 {
                margin-bottom: 35px;
            }

            .buku-card {
                min-height: 320px;
                padding: 18px;
            }

            .anggota-carousel .owl-nav button {
                width: 40px !important;
                height: 40px !important;
                font-size: 20px !important;
            }

            .anggota-carousel .owl-nav button.owl-prev {
                margin-left: -50px;
            }

            .anggota-carousel .owl-nav button.owl-next {
                margin-right: -50px;
            }
        }

        /* Mobile Large (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .buku-informasi-home {
                padding: 50px 70px;
                /* Tambah padding untuk nav button */
            }

            .buku-informasi-home>h2 {
                margin-bottom: 30px;
            }

            .buku-card {
                min-height: 300px;
                padding: 15px;
            }

            .anggota-carousel .owl-nav button {
                width: 38px !important;
                height: 38px !important;
                font-size: 18px !important;
            }

            .anggota-carousel .owl-nav button.owl-prev {
                margin-left: -45px;
            }

            .anggota-carousel .owl-nav button.owl-next {
                margin-right: -45px;
            }
        }

        /* Mobile (376px - 575px) */
        @media (min-width: 376px) and (max-width: 575px) {
            .buku-informasi-home {
                padding: 40px 20px;
            }

            .buku-informasi-home>h2 {
                margin-bottom: 25px;
            }

            .buku-card {
                min-height: 280px;
                padding: 15px;
            }

            /* SEMBUNYIKAN ARROW NAVIGATION DI MOBILE */
            .anggota-carousel .owl-nav {
                display: none !important;
            }

            .anggota-carousel .owl-dots {
                margin-top: 20px;
                gap: 8px;
            }

            .anggota-carousel .owl-dot {
                width: 8px;
                height: 8px;
            }

            .anggota-carousel .owl-dot.active {
                width: 24px;
            }
        }

        /* Small Mobile (320px - 375px) */
        @media (max-width: 375px) {
            .buku-informasi-home {
                padding: 30px 15px;
            }

            .buku-informasi-home>h2 {
                margin-bottom: 20px;
            }

            .buku-card {
                min-height: 260px;
                padding: 12px;
                border-radius: 10px;
            }

            .buku-card img {
                border-radius: 8px;
            }

            /* SEMBUNYIKAN ARROW NAVIGATION DI MOBILE */
            .anggota-carousel .owl-nav {
                display: none !important;
            }
        }

        /* Smooth transitions untuk semua perubahan */
        .buku-card,
        .buku-card img,
        .buku-card h4,
        .buku-card p,
        .btn-ekatalog-home {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading state untuk gambar */
        .buku-card img:not([src]) {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Fix untuk prevent layout shift */
        .anggota-carousel .owl-stage-outer {
            will-change: transform;
        }

        .anggota-carousel .owl-item {
            backface-visibility: hidden;
        }

        /* Accessibility improvements */
        .anggota-carousel .owl-nav button:focus,
        .anggota-carousel .owl-dot:focus,
        .btn-ekatalog-home:focus {
            outline: 2px solid #6DBAED;
            outline-offset: 2px;
        }

        .anggota-carousel .owl-nav button {
            background: #04293B !important;
            color: white !important;
            width: 45px !important;
            height: 45px !important;
            border-radius: 50% !important;
            font-size: 24px !important;
            transition: all 0.3s ease !important;
            border: none !important;
            outline: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .anggota-carousel .owl-nav button:hover {
            background: #063a52 !important;
            transform: scale(1.1) !important;
            box-shadow: 0 4px 12px rgba(4, 41, 59, 0.3) !important;
        }

        .anggota-carousel .owl-nav button.disabled {
            opacity: 0.3 !important;
            cursor: not-allowed !important;
        }

        /* Owl Dots Styling */
        .anggota-carousel .owl-dots {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .anggota-carousel .owl-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(4, 41, 59, 0.3) !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }

        .anggota-carousel .owl-dot.active {
            width: 30px;
            border-radius: 5px;
            background: #04293B !important;
        }

        .anggota-carousel .owl-dot:hover {
            background: rgba(4, 41, 59, 0.6) !important;
        }

        /* ================== RESPONSIVE BREAKPOINTS ================== */

        /* Extra Large Desktop (1600px+) */
        @media (min-width: 1600px) {
            .buku-informasi-home {
                padding: 120px 100px;
            }

            .buku-card {
                min-height: 400px;
            }
        }

        /* Large Desktop (1200px - 1599px) */
        @media (min-width: 1200px) and (max-width: 1599px) {
            .buku-informasi-home {
                padding: 100px 80px;
            }

            .buku-card {
                min-height: 360px;
            }
        }

        /* Desktop (992px - 1199px) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .buku-informasi-home {
                padding: 80px 60px;
            }

            .buku-card {
                min-height: 340px;
                padding: 20px;
            }
        }

        /* Tablet (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .buku-informasi-home {
                padding: 60px 40px;
            }

            .buku-informasi-home>h2 {
                margin-bottom: 35px;
            }

            .buku-card {
                min-height: 320px;
                padding: 18px;
            }

            .anggota-carousel .owl-nav button {
                width: 40px !important;
                height: 40px !important;
                font-size: 20px !important;
            }
        }

        /* Mobile Large (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .buku-informasi-home {
                padding: 50px 30px;
            }

            .buku-informasi-home>h2 {
                margin-bottom: 30px;
            }

            .buku-card {
                min-height: 300px;
                padding: 15px;
            }

            .anggota-carousel .owl-nav {
                margin-top: 20px;
                gap: 10px;
            }

            .anggota-carousel .owl-nav button {
                width: 38px !important;
                height: 38px !important;
                font-size: 18px !important;
            }
        }

        /* Mobile (376px - 575px) */
        @media (min-width: 376px) and (max-width: 575px) {
            .buku-informasi-home {
                padding: 40px 20px;
            }

            .buku-informasi-home>h2 {
                margin-bottom: 25px;
            }

            .buku-card {
                min-height: 280px;
                padding: 15px;
            }

            .anggota-carousel .owl-nav button {
                width: 36px !important;
                height: 36px !important;
                font-size: 16px !important;
            }

            .anggota-carousel .owl-dots {
                margin-top: 20px;
                gap: 8px;
            }

            .anggota-carousel .owl-dot {
                width: 8px;
                height: 8px;
            }

            .anggota-carousel .owl-dot.active {
                width: 24px;
            }
        }

        /* Small Mobile (320px - 375px) */
        @media (max-width: 375px) {
            .buku-informasi-home {
                padding: 30px 15px;
            }

            .buku-informasi-home>h2 {
                margin-bottom: 20px;
            }

            .buku-card {
                min-height: 260px;
                padding: 12px;
                border-radius: 10px;
            }

            .buku-card img {
                border-radius: 8px;
            }

            .anggota-carousel .owl-nav {
                margin-top: 15px;
            }

            .anggota-carousel .owl-nav button {
                width: 34px !important;
                height: 34px !important;
                font-size: 14px !important;
            }
        }

        /* Smooth transitions untuk semua perubahan */
        .buku-card,
        .buku-card img,
        .buku-card h4,
        .buku-card p,
        .btn-ekatalog-home {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading state untuk gambar */
        .buku-card img:not([src]) {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Fix untuk prevent layout shift */
        .anggota-carousel .owl-stage-outer {
            will-change: transform;
        }

        .anggota-carousel .owl-item {
            backface-visibility: hidden;
        }

        /* Accessibility improvements */
        .anggota-carousel .owl-nav button:focus,
        .anggota-carousel .owl-dot:focus,
        .btn-ekatalog-home:focus {
            outline: 2px solid #6DBAED;
            outline-offset: 2px;
        }

        /* Button */
        .btn-ekatalog-home {
            display: inline-block;
            padding: 12px 30px;
            background: #04293B;
            border: #04293B 1px solid;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-ekatalog-home:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(4, 41, 59, 0.3);
        }

        /* ============ BADGE BIDANG KEGIATAN ============ */
        .kegiatan-badge-home {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, #0a2540 0%, #1a4068 100%);
            color: #ffd700;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 5;
            transition: all 0.3s ease;
        }

        .events-hover:hover .kegiatan-badge-home,
        .events-banner-card:hover .kegiatan-badge-home {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        /* Pastikan card memiliki position relative */
        .events-banner-card-lastest,
        .events-banner-card {
            position: relative;
        }

        /* ================== RESPONSIVE ================== */
        @media (max-width: 1024px) {
            .buku-informasi-home {
                padding: 50px 30px;
                justify-content: center;
            }

            .buku-informasi-home>h2 {
                font-size: 25px;
                margin-bottom: 30px;
            }

            .buku-card {
                padding: 20px;
            }

            .buku-card img {
                height: 180px;
            }

            .buku-card h4 {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .buku-card p {
                font-size: 13px;
            }

            .btn-ekatalog-home {
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .buku-informasi-home {
                padding: 40px 20px;
            }

            .buku-informasi-home>h2 {
                font-size: 22px;
            }

            .buku-card img {
                height: 150px;
            }

            .buku-card h4 {
                font-size: 15px;
            }

            .buku-card p {
                font-size: 12px;
            }

            /* Responsive untuk badge kegiatan */
            .kegiatan-badge-home {
                font-size: 0.65rem;
                padding: 0.4rem 0.8rem;
                top: 0.75rem;
                right: 0.75rem;
            }
        }
    </style>
    <section class="strategic-plan">
        <div class="strategic-plan-content">
            <div class="strategic-plan-image">
                <img src="{{ asset('images/strategic-plan1.png') }}" alt="Strategic Plan Image">
            </div>
            <div class="strategic-plan-wrapper">
                <div class="green-accent"></div>
                <h1>Strategic Plan HIPMI JABAR</h1>
                <div class="strategic-plan-cards">
                    @forelse($tataKelola as $plan)
                        <a href="{{ route('strategic-plan.detail', $plan->id) }}" class="strategic-plan-card">
                            <h2>{{ $plan->title }}</h2><i class="fa fa-arrow-right"></i>
                        </a>
                    @empty
                        <!-- Jika belum ada data, tampilkan placeholder -->
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
                            <p>Belum ada data Strategic Plan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="strategic-plan-content-reverse">
            <div class="strategic-plan-image-reverse">
                <img src="{{ asset('images/strategic-plan2.png') }}" alt="Program dan Layanan Image">
            </div>
            <div class="strategic-plan-wrapper">
                <div class="green-accent"></div>
                <h1>Program dan Layanan</h1>
                <div class="strategic-plan-cards">
                    @forelse($programLayanan as $plan)
                        <a href="{{ route('strategic-plan.detail', $plan->id) }}" class="strategic-plan-card">
                            <h2>{{ $plan->title }}</h2><i class="fa fa-arrow-right"></i>
                        </a>
                    @empty
                        <!-- Jika belum ada data, tampilkan placeholder -->
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
                            <p>Belum ada data Program dan Layanan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    {{-- SECTION INFORMASI KEGIATAN BPD - SMOOTH & ELEGANT VERSION --}}
    <section class="events">
        <div class="green-accent" style="align-self: center;"></div>
        <h2>Informasi Kegiatan BPD</h2>

        @if($kegiatanBerita->count() > 0)
            <div class="events-content" id="kegiatan-container">
                {{-- Konten akan di-render oleh JavaScript --}}
            </div>

            {{-- Indikator dots --}}
            @if($kegiatanBerita->count() > 5)
                <div style="text-align: center; margin-top: 30px;">
                    <div id="kegiatan-indicators" style="display: inline-flex; gap: 10px;"></div>
                </div>
            @endif

            {{-- Hidden Data untuk JavaScript --}}
            <script id="kegiatan-data" type="application/json">
                                        @php
                                            $kegiatanArray = $kegiatanBerita->map(function ($item) {
                                                return [
                                                    'judul' => $item->judul,
                                                    'slug' => $item->slug,
                                                    'gambar_url' => $item->gambar_url ?? asset('images/hipmi-logo.png'),
                                                    'tanggal_format' => $item->tanggal_format ?? $item->tanggal_publish->format('d M Y'),
                                                    'bidang_name' => $item->bidang_name, // ← TAMBAHKAN INI
                                                ];
                                            })->toArray();
                                        @endphp
                                        {!! json_encode($kegiatanArray) !!}
                                    </script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const dataElement = document.getElementById('kegiatan-data');
                    if (!dataElement) return;

                    let kegiatanData;
                    try {
                        kegiatanData = JSON.parse(dataElement.textContent);
                    } catch (e) {
                        console.error('Error parsing kegiatan data:', e);
                        return;
                    }

                    if (kegiatanData.length === 0) return;

                    const container = document.getElementById('kegiatan-container');
                    const indicatorsContainer = document.getElementById('kegiatan-indicators');
                    let currentIndex = 0;
                    let autoRotateInterval;
                    let isTransitioning = false;

                    // Fungsi untuk membuat HTML konten kegiatan
                    function createKegiatanHTML(startIndex) {
                        const featured = kegiatanData[startIndex];
                        const others = [];

                        // Ambil 4 kegiatan berikutnya (wrap around jika perlu)
                        for (let i = 1; i <= 4; i++) {
                            const index = (startIndex + i) % kegiatanData.length;
                            others.push(kegiatanData[index]);
                        }

                        return `
                                        <div class="events-lastest">
                                            <a class="events-hover" href="/informasi-kegiatan/${featured.slug}" style="text-decoration: none; color: white;">
                                                <div class="events-banner-card-lastest">
                                                    <img src="${featured.gambar_url}" 
                                                         class="events-banner-bg" 
                                                         alt="${escapeHtml(featured.judul)}" 
                                                         onerror="this.src='{{ asset('images/hipmi-logo.png') }}'">

                                                    <span class="kegiatan-badge-home">${escapeHtml(featured.bidang_name)}</span>

                                                    <div class="events-overlay"></div>
                                                    <div class="events-banner-content">
                                                        <h2>${truncate(escapeHtml(featured.judul), 80)}</h2>
                                                        <p class="events-date">${escapeHtml(featured.tanggal_format)}</p>
                                                        <span class="events-btn-more">Lihat Lebih Banyak</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="events-others">
                                            ${others.map(item => `
                                                <a href="/informasi-kegiatan/${item.slug}" style="text-decoration: none; color: white;">
                                                    <div class="events-banner-card">
                                                        <img src="${item.gambar_url}" 
                                                             class="events-banner-bg" 
                                                             alt="${escapeHtml(item.judul)}" 
                                                             onerror="this.src='{{ asset('images/hipmi-logo.png') }}'">

                                                        <span class="kegiatan-badge-home">${escapeHtml(item.bidang_name)}</span>

                                                        <div class="events-overlay"></div>
                                                        <div class="events-banner-content">
                                                            <h2>${truncate(escapeHtml(item.judul), 60)}</h2>
                                                            <p class="events-date">${escapeHtml(item.tanggal_format)}</p>
                                                            <span class="events-btn-more">Lihat Lebih Banyak</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            `).join('')}
                                        </div>
                                    `;
                    }

                    // Helper functions
                    function escapeHtml(text) {
                        const div = document.createElement('div');
                        div.textContent = text;
                        return div.innerHTML;
                    }

                    function truncate(str, length) {
                        return str.length > length ? str.substring(0, length) + '...' : str;
                    }

                    // Render kegiatan dengan smooth fade effect
                    function renderKegiatan(index, useFade = true) {
                        if (isTransitioning) return;

                        if (useFade) {
                            isTransitioning = true;
                            container.style.opacity = '0';
                            container.style.transform = 'translateY(10px)';
                        }

                        setTimeout(() => {
                            container.innerHTML = createKegiatanHTML(index);
                            updateIndicators(index);

                            if (useFade) {
                                requestAnimationFrame(() => {
                                    container.style.opacity = '1';
                                    container.style.transform = 'translateY(0)';
                                    setTimeout(() => {
                                        isTransitioning = false;
                                    }, 600);
                                });
                            }
                        }, useFade ? 400 : 0);
                    }

                    // Buat indicator dots
                    function createIndicators() {
                        if (kegiatanData.length <= 5 || !indicatorsContainer) return;

                        indicatorsContainer.innerHTML = kegiatanData.map((_, index) =>
                            `<span class="kegiatan-indicator ${index === 0 ? 'active' : ''}" data-index="${index}"></span>`
                        ).join('');

                        document.querySelectorAll('.kegiatan-indicator').forEach(indicator => {
                            indicator.addEventListener('click', function () {
                                if (isTransitioning) return;
                                const newIndex = parseInt(this.getAttribute('data-index'));
                                if (newIndex === currentIndex) return;
                                currentIndex = newIndex;
                                renderKegiatan(currentIndex);
                                resetAutoRotate();
                            });
                        });
                    }

                    // Update active indicator dengan smooth transition
                    function updateIndicators(activeIndex) {
                        document.querySelectorAll('.kegiatan-indicator').forEach((indicator, index) => {
                            if (index === activeIndex) {
                                indicator.classList.add('active');
                            } else {
                                indicator.classList.remove('active');
                            }
                        });
                    }

                    // Auto rotate
                    function autoRotate() {
                        currentIndex = (currentIndex + 1) % kegiatanData.length;
                        renderKegiatan(currentIndex);
                    }

                    function resetAutoRotate() {
                        clearInterval(autoRotateInterval);
                        if (kegiatanData.length > 5) {
                            autoRotateInterval = setInterval(autoRotate, 10000);
                        }
                    }

                    // Pause on hover
                    container.addEventListener('mouseenter', () => {
                        clearInterval(autoRotateInterval);
                    });

                    container.addEventListener('mouseleave', () => {
                        resetAutoRotate();
                    });

                    // Initialize
                    createIndicators();
                    renderKegiatan(0, false);

                    if (kegiatanData.length > 5) {
                        autoRotateInterval = setInterval(autoRotate, 10000);
                    }
                });
            </script>
        @else
            <div style="text-align: center; padding: 3rem 0; color: #ffffff;">
                <p>Belum ada informasi kegiatan yang tersedia.</p>
            </div>
        @endif

        <div style="text-align:center; margin-top: 50px;">
            <a href="{{ route('informasi-kegiatan') }}" class="btn">Lihat Lebih Banyak</a>
        </div>
    </section>

    <style>
        /* ============ SMOOTH TRANSITIONS ============ */
        .events-content {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ============ INDICATOR DOTS - ELEGANT STYLE ============ */
        .kegiatan-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .kegiatan-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(4, 41, 59, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .kegiatan-indicator:hover::before {
            opacity: 1;
        }

        .kegiatan-indicator.active {
            background: #04293B;
            width: 28px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(4, 41, 59, 0.3);
        }

        .kegiatan-indicator:hover {
            background: rgba(4, 41, 59, 0.6);
            transform: scale(1.1);
        }

        .kegiatan-indicator.active:hover {
            transform: scale(1);
        }

        /* ============ CARDS HOVER EFFECTS ============ */
        .events-banner-card-lastest,
        .events-banner-card {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .events-hover:hover .events-banner-card-lastest,
        .events-banner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .events-banner-bg {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .events-hover:hover .events-banner-bg,
        .events-banner-card:hover .events-banner-bg {
            transform: scale(1.05);
        }

        /* ============ OVERLAY ANIMATION ============ */
        .events-overlay {
            transition: background 0.4s ease;
        }

        .events-hover:hover .events-overlay,
        .events-banner-card:hover .events-overlay {
            background: linear-gradient(to top, rgba(4, 41, 59, 0.9), transparent);
        }

        /* ============ BUTTON EFFECTS ============ */
        .events-btn-more {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
        }

        .events-hover:hover .events-btn-more,
        .events-banner-card:hover .events-btn-more {
            transform: translateX(5px);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* ============ CONTENT FADE IN ============ */
        .events-banner-content h2,
        .events-banner-content p,
        .events-banner-content .events-btn-more {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .events-banner-content h2 {
            animation-delay: 0.1s;
        }

        .events-banner-content p {
            animation-delay: 0.2s;
        }

        .events-banner-content .events-btn-more {
            animation-delay: 0.3s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============ SMOOTH IMAGE LOADING ============ */
        .events-banner-bg {
            background: rgba(4, 41, 59, 0.1);
        }

        /* ============ RESPONSIVE ADJUSTMENTS ============ */
        @media (max-width: 768px) {
            .kegiatan-indicator {
                width: 8px;
                height: 8px;
            }

            .kegiatan-indicator.active {
                width: 24px;
            }
        }
    </style>
    <section class="ekatalog-home-wrapper">
    <div class="ekatalog-home">
        <div class="green-accent" style="align-self: center;"></div>
        <h2>E-Katalog Bisnis HIPMI Jabar</h2>
        <div class="e-katalog-content-home">
            @forelse($katalogs as $katalog)
                <a href="{{ route('e-katalog.detail', $katalog->id) }}">
                    <div class="katalog-card">
                        <img src="{{ $katalog->logo_url }}" alt="{{ $katalog->company_name }}">
                        <div class="container">
                            <h4><b>{{ Str::limit($katalog->company_name, 20, '...') }}</b></h4>
                            <p>{{ Str::limit($katalog->business_field, 25, '...') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <a href="{{ route('e-katalog') }}">
                    <div class="katalog-card">
                        <img src="{{ asset('images/hipmi-logo.png') }}">
                        <div class="container">
                            <h4><b>Belum Ada Data</b></h4>
                            <p>Klik untuk lihat katalog</p>
                        </div>
                    </div>
                </a>
            @endforelse
        </div>
        <div style="margin-top: 50px;">
            <a href="{{ route('e-katalog') }}" class="btn-ekatalog-home">Lihat Lebih Banyak</a>
        </div>
        </div>
    </section>

    <section class="daftarkan-bisnis-anda">
        <img src="{{ asset('images/maju-babarengan.png') }}" alt="">
        <h1>DAFTARKAN BISNIS ANDA</h1>
        <a href="{{ route('umkm') }}" class="btn">Daftar Bisnis</a>
    </section>

    {{-- SECTION BERITA & DOKUMENTASI --}}
    <section class="berita-home-wrapper">
    <div class="berita-home">
        <div class="green-accent" style="align-self: center;"></div>
        <h2>Berita & Dokumentasi</h2>

        @if($dokumentasiBerita->count() > 0)
            <div class="berita-home-content">
                {{-- Berita Featured (Terbesar) --}}
                <div class="berita-home-lastest">
                    <a href="{{ route('berita-detail', $dokumentasiBerita->first()->slug) }}"
                        style="text-decoration: none; color: white;">
                        <div class="berita-home-banner-card">
                            <img src="{{ $dokumentasiBerita->first()->gambar_url }}" class="berita-home-banner-bg"
                                alt="{{ $dokumentasiBerita->first()->judul }}">

                            <div class="berita-home-overlay"></div>

                            <div class="berita-home-banner-content">
                                <h2>{{ Str::limit($dokumentasiBerita->first()->judul, 80) }}</h2>
                                <p class="berita-home-date">{{ $dokumentasiBerita->first()->tanggal_format }}</p>
                                <span class="berita-home-btn-more">Lihat Lebih Banyak</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Berita Others (2 berita tengah) --}}
                <div class="berita-home-others">
                    @foreach($dokumentasiBerita->skip(1)->take(2) as $berita)
                        <a href="{{ route('berita-detail', $berita->slug) }}" style="text-decoration: none; color: #04293B;">
                            <div class="berita-home-others-card">
                                <img src="{{ $berita->gambar_url }}" class="berita-home-others-banner" alt="{{ $berita->judul }}">

                                <div class="berita-home-others-content">
                                    <h2>{{ Str::limit($berita->judul, 60) }}</h2>
                                    <p class="berita-home-date">{{ $berita->tanggal_format }}</p>
                                    <span class="berita-home-others-btn-more">Lihat Lebih Banyak</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Berita More (3 berita bawah) --}}
            @if($dokumentasiBerita->count() > 3)
                <div class="berita-home-more">
                    @foreach($dokumentasiBerita->skip(3)->take(3) as $berita)
                        <a href="{{ route('berita-detail', $berita->slug) }}" style="text-decoration: none; color: #04293B;">
                            <div class="berita-home-others-card">
                                <img src="{{ $berita->gambar_url }}" class="berita-home-others-banner" alt="{{ $berita->judul }}">

                                <div class="berita-home-others-content">
                                    <h2>{{ Str::limit($berita->judul, 60) }}</h2>
                                    <p class="berita-home-date">{{ $berita->tanggal_format }}</p>
                                    <span class="berita-home-others-btn-more">Lihat Lebih Banyak</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 3rem 0; color: #6b7280;">
                <p>Belum ada berita dan dokumentasi yang tersedia.</p>
            </div>
        @endif

        <div style="margin-top: 50px;">
            <a href="{{ route('berita') }}" class="btn-ekatalog-home">Lihat Lebih Banyak</a>
        </div>
    </div>
    </section>

@endsection

@push('scripts')
    <script>
        // Initialize Owl Carousel untuk Buku Informasi Pengurus
        // Initialize Owl Carousel untuk Buku Informasi Pengurus
        document.addEventListener('DOMContentLoaded', function () {
            const carousel = $('.anggota-carousel');

            if (carousel.length) {
                carousel.owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    smartSpeed: 800,
                    fluidSpeed: 800,
                    navSpeed: 800,
                    dotsSpeed: 800,
                    dragEndSpeed: 800,
                    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                    responsive: {
                        0: {
                            items: 1,
                            margin: 15,
                            stagePadding: 30,
                            nav: false, // Sembunyikan nav di mobile
                            dots: true
                        },
                        376: {
                            items: 1,
                            margin: 15,
                            stagePadding: 40,
                            nav: false, // Sembunyikan nav di mobile
                            dots: true
                        },
                        576: {
                            items: 2,
                            margin: 15,
                            stagePadding: 0,
                            nav: true, // Tampilkan nav di tablet keatas
                            dots: true
                        },
                        768: {
                            items: 2,
                            margin: 20,
                            stagePadding: 0,
                            nav: true,
                            dots: true
                        },
                        992: {
                            items: 3,
                            margin: 20,
                            stagePadding: 0,
                            nav: true,
                            dots: true
                        },
                        1200: {
                            items: 4,
                            margin: 20,
                            stagePadding: 0,
                            nav: true,
                            dots: true
                        }
                    },
                    onInitialized: function () {
                        // Add fade-in animation after carousel is ready
                        $('.anggota-carousel').css('opacity', '1');
                    },
                    onResized: function () {
                        // Recalculate heights after resize
                        equalizeCardHeights();
                    }
                });

                // Function to equalize card heights
                function equalizeCardHeights() {
                    const cards = $('.buku-card');
                    let maxHeight = 0;

                    // Reset heights
                    cards.css('height', 'auto');

                    // Find max height
                    cards.each(function () {
                        const height = $(this).outerHeight();
                        if (height > maxHeight) {
                            maxHeight = height;
                        }
                    });

                    // Set all cards to max height
                    if (maxHeight > 0) {
                        cards.css('height', maxHeight + 'px');
                    }
                }

                // Initial height equalization
                setTimeout(equalizeCardHeights, 100);

                // Re-equalize on window resize with debounce
                let resizeTimer;
                $(window).on('resize', function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function () {
                        carousel.trigger('refresh.owl.carousel');
                        equalizeCardHeights();
                    }, 250);
                });

                // Smooth image loading
                $('.buku-card img').on('load', function () {
                    $(this).addClass('loaded');
                });

                // Handle image errors
                $('.buku-card img').on('error', function () {
                    $(this).attr('src', '/images/hipmi-logo.png');
                });

                // Add keyboard navigation
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 37) { // Left arrow
                        carousel.trigger('prev.owl.carousel');
                    } else if (e.keyCode === 39) { // Right arrow
                        carousel.trigger('next.owl.carousel');
                    }
                });

                // Pause autoplay when user interacts
                carousel.on('dragged.owl.carousel', function () {
                    carousel.trigger('stop.owl.autoplay');
                    setTimeout(function () {
                        carousel.trigger('play.owl.autoplay');
                    }, 5000);
                });

                // Add touch swipe feedback
                let startX = 0;
                carousel.on('touchstart', function (e) {
                    startX = e.touches[0].clientX;
                });

                carousel.on('touchend', function (e) {
                    const endX = e.changedTouches[0].clientX;
                    const diff = startX - endX;

                    if (Math.abs(diff) > 50) {
                        // Haptic feedback simulation (if available)
                        if (navigator.vibrate) {
                            navigator.vibrate(10);
                        }
                    }
                });
            }

            // Add CSS transition class after page load
            setTimeout(function () {
                $('.anggota-carousel').addClass('carousel-ready');
            }, 100);
        });

        // Optional: Lazy loading untuk gambar
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('data-src');
                        if (src) {
                            img.setAttribute('src', src);
                            img.removeAttribute('data-src');
                        }
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px'
            });

            document.querySelectorAll('.buku-card img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>
@endpush