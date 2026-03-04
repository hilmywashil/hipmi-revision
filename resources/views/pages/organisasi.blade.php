@extends('layouts.app')

@section('title', 'Organisasi - HIPMI Jawa Barat')

@section('content')

    {{-- INLINE CSS UNTUK MODAL LANDSCAPE --}}
    <style>
        /* Modal Landscape Layout - Inline Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content-landscape {
            background: white;
            border-radius: 20px;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideUp 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: row;
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .modal-close:hover {
            background: white;
            transform: rotate(90deg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .modal-close svg {
            width: 20px;
            height: 20px;
            stroke: #04293B;
        }

        .modal-left {
            flex: 0 0 380px;
            display: flex;
            flex-direction: column;
            background: #04293B;
        }

        .modal-header {
            background: #04293B;
            padding: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .modal-header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .modal-header-text {
            display: flex;
            flex-direction: column;
        }

        .modal-org-name {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            letter-spacing: 1px;
        }

        .modal-org-region {
            color: #FDB515;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 2px;
            margin-top: 0.25rem;
        }

        .modal-photo-container {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #04293B 0%, #04293B 50%, #063a52 50%, #063a52 100%);
        }

        .modal-photo-circle {
            position: relative;
            z-index: 2;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            border: 6px solid #6DBAED;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-right {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            background: white;
        }

        .modal-right-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #04293B;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 3px solid #6DBAED;
        }

        .modal-details {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .detail-section {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #6DBAED;
            transition: all 0.3s;
        }

        .detail-section:hover {
            background: #e9ecef;
            border-left-color: #04293B;
            transform: translateX(5px);
        }

        .detail-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #04293B;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-title svg {
            width: 16px;
            height: 16px;
            fill: #6DBAED;
        }

        .detail-text {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
            margin: 0;
        }

        .detail-text p {
            margin: 0.25rem 0;
        }

        .detail-text strong {
            color: #04293B;
            font-weight: 600;
        }

        .modal-right::-webkit-scrollbar {
            width: 8px;
        }

        .modal-right::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-right::-webkit-scrollbar-thumb {
            background: #6DBAED;
            border-radius: 10px;
        }

        .modal-right::-webkit-scrollbar-thumb:hover {
            background: #04293B;
        }

        @media (max-width: 768px) {
            .modal-content-landscape {
                flex-direction: column;
                max-width: 95%;
                max-height: 85vh;
            }

            .modal-left {
                flex: 0 0 auto;
            }

            .modal-header {
                padding: 1rem;
            }

            .modal-logo {
                width: 40px;
                height: 40px;
            }

            .modal-org-name {
                font-size: 1.25rem;
            }

            .modal-org-region {
                font-size: 0.75rem;
            }

            .modal-photo-container {
                height: 250px;
            }

            .modal-photo-circle {
                width: 160px;
                height: 160px;
                border-width: 5px;
            }

            .modal-right {
                padding: 1.5rem;
                max-height: 300px;
            }

            .modal-right-title {
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }

            .detail-section {
                padding: 0.75rem;
            }

            .detail-title {
                font-size: 0.75rem;
            }

            .detail-text {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .modal-content-landscape {
                margin: 0.5rem;
            }

            .modal-photo-container {
                height: 220px;
            }

            .modal-photo-circle {
                width: 140px;
                height: 140px;
            }

            .modal-right {
                padding: 1rem;
            }

            .detail-section {
                padding: 0.5rem;
            }
        }
    </style>

    <section class="page-banners">
        <div class="page-banner">
            <h1>Struktur Organisasi</h1>
            <p>Struktur Organisasi BPD HIPMI Jawa Barat</p>
        </div>
    </section>

    <section class="organisasi">

        {{-- ===================== 1. KETUA UMUM ===================== --}}
        @php
            $ketuaUmum = \App\Models\Organisasi::with('anggota')
                ->aktif()->kategori('ketua_umum')->ordered()->get();
        @endphp
        @if($ketuaUmum->count() > 0)
            <div class="organisasi-layout2">
                <div class="green-accent" style="align-self: center;"></div>
                <h2 class="org-heading">Ketua Umum</h2>
                <div class="organisasi-layout2-content {{ $ketuaUmum->count() === 1 ? 'center-single' : '' }}">
                    @foreach($ketuaUmum as $ketum)
                        <div class="organisasi-card" onclick="showModal({{ $ketum->id }})">
                            <img src="{{ $ketum->foto_url }}" alt="{{ $ketum->nama }}">
                            <div class="container">
                                <h4><b>{{ Str::limit($ketum->nama, 20, '...') }}</b></h4>
                                <p>{{ $ketum->jabatan }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif


        {{-- ===================== 2. WAKIL KETUA UMUM ===================== --}}
        @php
            $wakilKetuaUmum = \App\Models\Organisasi::with('anggota')
                ->aktif()->kategori('wakil_ketua_umum')->ordered()->first();
        @endphp
        @if($wakilKetuaUmum)
            <div class="organisasi-layout1">
                <div class="green-accent" style="align-self: center;"></div>
                <h2 class="org-heading">Wakil Ketua Umum</h2>
                <div class="organisasi-card-small" onclick="showModal({{ $wakilKetuaUmum->id }})">
                    <img src="{{ $wakilKetuaUmum->foto_url }}" alt="{{ $wakilKetuaUmum->nama }}">
                    <div class="container">
                        <h4><b>{{ Str::limit($wakilKetuaUmum->nama, 15, '...') }}</b></h4>
                        <p>{{ $wakilKetuaUmum->jabatan }}</p>
                    </div>
                </div>
            </div>
        @endif


        {{-- ===================== 3. SEKRETARIS UMUM ===================== --}}
        @php
            $sekretarisUmum = \App\Models\Organisasi::with('anggota')
                ->aktif()->kategori('sekretaris_umum')->ordered()->first();
        @endphp
        @if($sekretarisUmum)
            <div class="organisasi-layout1">
                <div class="green-accent" style="align-self: center;"></div>
                <h2 class="org-heading">Sekretaris Umum</h2>
                <div class="organisasi-card-small" onclick="showModal({{ $sekretarisUmum->id }})">
                    <img src="{{ $sekretarisUmum->foto_url }}" alt="{{ $sekretarisUmum->nama }}">
                    <div class="container">
                        <h4><b>{{ Str::limit($sekretarisUmum->nama, 15, '...') }}</b></h4>
                        <p>{{ $sekretarisUmum->jabatan }}</p>
                    </div>
                </div>
            </div>
        @endif


        {{-- ===================== 4. BENDAHARA UMUM ===================== --}}
        @php
            $bendaharaUmum = \App\Models\Organisasi::with('anggota')
                ->aktif()->kategori('bendahara_umum')->ordered()->first();
        @endphp
        @if($bendaharaUmum)
            <div class="organisasi-layout1">
                <div class="green-accent" style="align-self: center; background-color:#f59e0b;"></div>
                <h2 class="org-heading">Bendahara Umum</h2>
                <div class="organisasi-card-small" onclick="showModal({{ $bendaharaUmum->id }})">
                    <img src="{{ $bendaharaUmum->foto_url }}" alt="{{ $bendaharaUmum->nama }}">
                    <div class="container">
                        <h4><b>{{ Str::limit($bendaharaUmum->nama, 20, '...') }}</b></h4>
                        <p>{{ $bendaharaUmum->jabatan }}</p>
                    </div>
                </div>
            </div>
        @endif


        {{-- ===================== 5. KETUA BIDANG ===================== --}}
        @php
            $ketuaBidang = \App\Models\Organisasi::with('anggota')
                ->aktif()->kategori('ketua_bidang')->ordered()->get();
        @endphp
        @if($ketuaBidang->count() > 0)
            <div class="organisasi-layout2">
                <div class="green-accent" style="align-self: center; background-color: #ec1846"></div>
                <h2 class="org-heading">Ketua Bidang</h2>
                <div class="organisasi-layout2-content">
                    @foreach($ketuaBidang as $bidang)
                        <div class="organisasi-card-small" onclick="showModal({{ $bidang->id }})">
                            <img src="{{ $bidang->foto_url }}" alt="{{ $bidang->nama }}">
                            <div class="container">
                                <h4><b>{{ Str::limit($bidang->nama, 20, '...') }}</b></h4>
                                <p>{{ $bidang->jabatan }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif


        {{-- ===================== 6. CUSTOM KATEGORI ===================== --}}
        @php
            $customKategori = \App\Models\Organisasi::with('anggota')
                ->aktif()
                ->customKategori()
                ->where('kategori', '!=', 'bendahara_umum') // exclude ini
                ->ordered()
                ->get()
                ->groupBy('kategori');
        @endphp

        @foreach($customKategori as $kategoriName => $items)
            <div class="organisasi-layout2">
                <div class="green-accent" style="align-self: center; background-color: #8b5cf6"></div>
                <h2 class="org-heading">{{ Str::title($kategoriName) }}</h2>
                <div class="organisasi-layout2-content">
                    @foreach($items as $item)
                        <div class="organisasi-card-small" onclick="showModal({{ $item->id }})">
                            <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}">
                            <div class="container">
                                <h4><b>{{ Str::limit($item->nama, 20, '...') }}</b></h4>
                                <p>{{ $item->jabatan }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </section>

    {{-- Modal Popup Landscape --}}
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
        <div class="modal-content-landscape" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            {{-- Bagian Kiri: Logo + Foto --}}
            <div class="modal-left">
                <div class="modal-header">
                    <div class="modal-header-content">
                        <img src="{{ asset('images/hipmi-logo.png') }}" alt="HIPMI Logo" class="modal-logo">
                        <div class="modal-header-text">
                            <div class="modal-org-name">HIPMI</div>
                            <div class="modal-org-region">JAWA BARAT</div>
                        </div>
                    </div>
                </div>

                <div class="modal-photo-container">
                    <div class="modal-photo-circle">
                        <img id="modalPhoto" class="modal-photo" src="" alt="">
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Detail Informasi --}}
            <div class="modal-right">
                <h3 class="modal-right-title">Informasi Detail</h3>
                <div id="modalDetails" class="modal-details">
                    <div class="detail-section" id="namaSection">
                        <h3 class="detail-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                            Nama
                        </h3>
                        <p id="modalNama" class="detail-text"></p>
                    </div>

                    <div class="detail-section" id="jabatanSection">
                        <h3 class="detail-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>
                            Jabatan
                        </h3>
                        <p id="modalJabatan" class="detail-text"></p>
                    </div>

                    <div class="detail-section" id="namaPerusahaanSection" style="display: none;">
                        <h3 class="detail-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z" />
                                <path
                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z" />
                            </svg>
                            Nama Perusahaan
                        </h3>
                        <p id="modalNamaPerusahaan" class="detail-text"></p>
                    </div>

                    <div class="detail-section" id="bidangUsahaSection" style="display: none;">
                        <h3 class="detail-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z" />
                            </svg>
                            Bidang Usaha
                        </h3>
                        <p id="modalBidangUsaha" class="detail-text"></p>
                    </div>

                    <div class="detail-section" id="kontakSection" style="display: none;">
                        <h3 class="detail-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>
                            Kontak
                        </h3>
                        <div id="modalKontak" class="detail-text"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal(organisasiId) {
            document.getElementById('modalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';

            fetch(`/organisasi/${organisasiId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const org = data.data;
                        document.getElementById('modalPhoto').src = org.foto_url;
                        document.getElementById('modalNama').textContent = org.nama;
                        document.getElementById('modalJabatan').textContent = org.jabatan;

                        const perusahaanSection = document.getElementById('namaPerusahaanSection');
                        if (org.anggota && org.anggota.nama_usaha_perusahaan) {
                            document.getElementById('modalNamaPerusahaan').textContent = org.anggota.nama_usaha_perusahaan;
                            perusahaanSection.style.display = 'block';
                        } else {
                            perusahaanSection.style.display = 'none';
                        }

                        const bidangSection = document.getElementById('bidangUsahaSection');
                        if (org.bidang_usaha) {
                            document.getElementById('modalBidangUsaha').textContent = org.bidang_usaha;
                            bidangSection.style.display = 'block';
                        } else {
                            bidangSection.style.display = 'none';
                        }

                        const kontakSection = document.getElementById('kontakSection');
                        if (org.anggota && (org.anggota.email || org.anggota.nomor_telepon)) {
                            let kontakHTML = '';
                            if (org.anggota.email) {
                                kontakHTML += `<p><strong>Email:</strong> ${org.anggota.email}</p>`;
                            }
                            if (org.anggota.nomor_telepon) {
                                kontakHTML += `<p><strong>Telepon:</strong> ${org.anggota.nomor_telepon}</p>`;
                            }
                            document.getElementById('modalKontak').innerHTML = kontakHTML;
                            kontakSection.style.display = 'block';
                        } else {
                            kontakSection.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                    alert('Gagal memuat data organisasi');
                    closeModal();
                });
        }

        function closeModal(event) {
            if (event && event.target !== document.getElementById('modalOverlay')) {
                return;
            }
            document.getElementById('modalOverlay').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endsection