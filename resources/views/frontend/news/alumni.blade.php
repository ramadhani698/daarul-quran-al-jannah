@extends('frontend.layouts.app')

@section('title', 'Info Alumni')

@push('styles')
    <link href="{{ asset('css/alumni.css') }}" rel="stylesheet">
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-section-alumni" id="beranda" style="margin-top: 70px;">

        <canvas id="hero-canvas-alumni"></canvas>

        <div class="alumni-blob alumni-blob-1"></div>
        <div class="alumni-blob alumni-blob-2"></div>
        <div class="alumni-blob alumni-blob-3"></div>

        <div class="alumni-corner alumni-corner-tl"></div>
        <div class="alumni-corner alumni-corner-tr"></div>
        <div class="alumni-corner alumni-corner-bl"></div>
        <div class="alumni-corner alumni-corner-br"></div>

        <div class="hero-content-alumni">

            <div class="hero-eyebrow">
                <span class="hero-eyebrow-dot"></span>
                Komunitas Alumni
            </div>

            <h2 class="hero-alumni-title">
                Bergabung dengan Jaringan Alumni Tahfidz
            </h2>

            <p class="hero-alumni-subtitle">
                Menjadi bagian dari komunitas alumni
                Pondok Pesantren Daarul Qur'an Al-Jannah
                yang tersebar di seluruh negeri.
            </p>

            <div class="hero-alumni-ornament">
                <div class="hero-alumni-ornament-line"></div>
                <div class="hero-alumni-ornament-diamond"></div>
                <div class="hero-alumni-ornament-line right"></div>
            </div>

            <div class="btn-container">
                <a href="#sebaran-alumni" class="btn-alumni-primary">Sebaran Alumni</a>
                <a href="#kiprah-alumni" class="btn-alumni-outline">Kiprah Alumni</a>
            </div>

        </div>

    </section>

    {{-- SEBARAN ALUMNI --}}
    @if($sebaran->isNotEmpty())
    <section class="alumni-prestasi" id="sebaran-alumni">
        <div class="container">

            <div class="section-header-alumni" data-aos="fade-up" data-aos-delay="100">
                <div class="section-tag-alumni">
                    <span class="tag-line-alumni"></span>
                    Sebaran Alumni
                </div>
                <h2 class="section-alumni-title">Jejak Langkah Alumni</h2>
                <p class="section-alumni-subtitle">
                    Para alumni yang telah tersebar di masyarakat
                    dan sukses dalam berbagai bidang kehidupan.
                </p>
            </div>

            <div class="alumni-container">
                @foreach($sebaran as $index => $alumni)
                    <div class="wrapper"
                         data-aos="fade-up"
                         data-aos-delay="{{ ($index + 1) * 100 }}">

                        <div class="alumni-card">

                            <div class="alumni-img">
                                <img src="{{ $alumni->foto_url }}"
                                     alt="{{ $alumni->nama }}">
                                @if($alumni->badge)
                                    <span class="alumni-badge">{{ $alumni->badge }}</span>
                                @endif
                            </div>

                            <div class="alumni-info">
                                <h3>{{ $alumni->nama }}</h3>
                                <p>Tahun Lulus: {{ $alumni->tahun_lulus }}</p>
                                <p>Profesi: {{ $alumni->profesi_atau_kampus }}</p>
                                @if($alumni->deskripsi)
                                    <p class="alumni-desc">{{ $alumni->deskripsi }}</p>
                                @endif
                                <span class="alumni-juz">
                                    &#9670; Hafal {{ $alumni->hafalan_juz }} Juz
                                </span>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION SEBARAN --}}
            @if($sebaran->hasPages())
                <div class="text-center mb-4 mt-5">
                    {{ $sebaran->fragment('sebaran-alumni')->links('frontend.partials.pagination') }}
                </div>
            @endif

        </div>
    </section>
    @endif

    {{-- KIPRAH ALUMNI --}}
    @if($kiprah->isNotEmpty())
    <section class="alumni-prestasi" id="kiprah-alumni">
        <div class="container">

            <div class="section-header-alumni" data-aos="fade-up" data-aos-delay="100">
                <div class="section-tag-alumni">
                    <span class="tag-line-alumni"></span>
                    Kiprah Alumni
                </div>
                <h2 class="section-alumni-title">Melanjutkan di Perguruan Tinggi</h2>
                <p class="section-alumni-subtitle">
                    Para alumni yang sedang melanjutkan pendidikan
                    dan mengukir prestasi di universitas terkemuka.
                </p>
            </div>

            <div class="alumni-container">
                @foreach($kiprah as $index => $alumni)
                    <div class="wrapper"
                         data-aos="fade-up"
                         data-aos-delay="{{ ($index + 1) * 100 }}">

                        <div class="alumni-card">

                            <div class="alumni-img">
                                <img src="{{ $alumni->foto_url }}"
                                     alt="{{ $alumni->nama }}">
                                @if($alumni->badge)
                                    <span class="alumni-badge">{{ $alumni->badge }}</span>
                                @endif
                            </div>

                            <div class="alumni-info">
                                <h3>{{ $alumni->nama }}</h3>
                                <p>Tahun Lulus: {{ $alumni->tahun_lulus }}</p>
                                <p>Kampus: {{ $alumni->profesi_atau_kampus }}</p>
                                @if($alumni->deskripsi)
                                    <p class="alumni-desc">{{ $alumni->deskripsi }}</p>
                                @endif
                                <span class="alumni-juz">
                                    &#9670; Hafal {{ $alumni->hafalan_juz }} Juz
                                </span>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION KIPRAH --}}
            @if($kiprah->hasPages())
                <div class="text-center mb-4 mt-5">
                    {{ $kiprah->fragment('kiprah-alumni')->links('frontend.partials.pagination') }}
                </div>
            @endif

        </div>
    </section>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/alumni.js') }}"></script>
@endpush