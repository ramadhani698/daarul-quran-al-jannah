@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')

    <div id="carouselExampleIndicators" class="carousel carousel-home slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-wrap="true" data-bs-pause="false">
        <div class="carousel-indicators">

            @foreach ($carousels as $carousel)

                <button
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active' : '' }}"
                    {{ $loop->first ? 'aria-current=true' : '' }}
                    aria-label="Slide {{ $loop->iteration }}"
                ></button>

            @endforeach

        </div>

        <div class="carousel-inner">

            @foreach ($carousels as $carousel)

                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

                    <img
                        src="{{ asset('storage/' . $carousel->image) }}"
                        class="d-block w-100"
                        alt="Carousel Image"
                    >

                </div>

            @endforeach

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Home Section -->
    <section class="home-section" id="home-section">
        <div class="container">
            <div class="row justify-content-center mb-3">
                <div class="home-title text-center">
                    <h4 data-aos="fade-up">Selamat Datang di</h4>
                    <h2 data-aos="zoom-in" data-aos-delay="150">
                        Daarul Qur'an <span class="d-inline-block">Al-Jannah</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefit Section -->
    <section class="daqu-benefit-section py-5">
        <div class="container">

            <div class="row align-items-center">

                {{-- Benefit Content --}}
                <div class="col-lg-6 mb-5 mb-lg-0"
                    data-aos="fade-right">

                    <div class="why-section mb-4">
                        <h3>
                            Kenapa sih, Harus Mondok Di DaQu Al-Jannah?
                        </h3>
                    </div>

                    <ul class="list-unstyled benefit-list">

                        @forelse($benefits as $index => $benefit)

                            <li
                                data-aos="fade-right"
                                data-aos-delay="{{ 100 + ($index * 150) }}"
                                data-aos-duration="1000"
                            >

                                <strong>
                                    {{ $benefit->title }}
                                </strong>

                                —

                                {{ $benefit->description }}

                            </li>

                        @empty

                            <li class="text-muted">
                                Data benefit belum tersedia.
                            </li>

                        @endforelse

                    </ul>

                </div>

                {{-- Benefit Images --}}
                <div class="col-lg-6"
                    data-aos="fade-left">

                    <div class="photo-stack-wrapper">

                        {{-- Right Image --}}
                        @if(isset($images['right']))
                            <div class="photo photo-right zoom-hover fly-floating">
                                <img
                                    src="{{ asset('storage/' . $images['right']->image) }}"
                                    alt="Benefit Right Image">
                            </div>
                        @endif

                        {{-- Left Image --}}
                        @if(isset($images['left']))
                            <div class="photo photo-left zoom-hover fly-floating">
                                <img
                                    src="{{ asset('storage/' . $images['left']->image) }}"
                                    alt="Benefit Left Image">
                            </div>
                        @endif

                        {{-- Center Image --}}
                        @if(isset($images['center']))
                            <div class="photo photo-center zoom-hover fly-floating">
                                <img
                                    src="{{ asset('storage/' . $images['center']->image) }}"
                                    alt="Benefit Center Image">
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- Pendidikan Section -->
    <section class="pendidikan-daqu" id="pendidikan-daqu">
        <div class="container">
            {{-- Section Title --}}
            <h2 class="pendidikan-title">
                {{ $curiculumSection->title ?? 'Sistem Kurikulum' }}
            </h2>
            {{-- Intro --}}
            <div class="row justify-content-center">
                <div class="text-center">
                    <p class="pendidikan-intro">
                        {{ $curiculumSection->intro ?? '' }}

                    </p>
                </div>
            </div>
            {{-- Pendidikan Cards --}}
            <div class="row pendidikan-row g-4 mt-2">

                @forelse($curiculumItems as $index => $item)
                {{-- Card 1 --}}
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index * 300) }}">
                    <div class="pendidikan-card">
                        <div class="pendidikan-header">
                            <div class="pendidikan-icon-container">
                                <i class="{{ $item->icon }}"></i>
                            </div>
                            <h4>
                                {{ $item->title }}
                            </h4>
                        </div>
                        <p>
                            {{ $item->description }}
                        </p>
                        <div class="pendidikan-cta">
                            <a href="#">
                                Lanjut baca &raquo;
                            </a>
                        </div>
                    </div>
                </div>

                @empty
                <div class="col-12 text-center">

                    <p class="text-muted">
                        Data kurikulum belum tersedia.
                    </p>

                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Ekskul Section -->
    <section class="ekskul-section py-5">
        <div class="container">

            <h2 class="mb-5 text-center">
                Kegiatan Ekstrakurikuler
            </h2>

            {{-- TABS --}}
            <ul class="nav nav-pills justify-content-center mb-5" id="ekskulTab" role="tablist">
                @foreach ($ekskulCategories as $index => $cat)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                data-bs-toggle="pill"
                                data-bs-target="#cat-{{ $cat->slug }}"
                                type="button">
                            {{ $cat->name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            {{-- TAB CONTENT --}}
            <div class="tab-content">
                @foreach ($ekskulCategories as $index => $cat)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                        id="cat-{{ $cat->slug }}">

                        <div class="row g-4">
                            @forelse ($cat->extracurriculars as $ekskul)
                                <div class="col-md-6" data-aos="flip-left" data-aos-delay="{{ $loop->index * 300 }}">
                                    <div class="ekskul-card"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-{{ $ekskul->slug }}">
                                        <i class="{{ $ekskul->icon }}"></i>
                                        <h5>{{ $ekskul->title }}</h5>
                                        <p>{{ $ekskul->short_description }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">
                                    Belum ada ekstrakurikuler di kategori ini.
                                </div>
                            @endforelse
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- MODALS --}}
    @foreach ($ekskulCategories as $cat)
        @foreach ($cat->extracurriculars as $ekskul)

            <div class="modal fade" id="modal-{{ $ekskul->slug }}" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="{{ $ekskul->icon }} me-2"></i>
                                {{ $ekskul->title }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <p>{!! nl2br(e($ekskul->description)) !!}</p>

                            @if ($ekskul->galleries->isNotEmpty())
                                <div class="text-center">
                                    @foreach ($ekskul->galleries as $gallery)
                                        <img src="{{ Storage::url($gallery->image) }}"
                                            class="img-fluid rounded shadow m-2 ekskul-gallery-img"
                                            alt="{{ $ekskul->title }}">
                                    @endforeach
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    @endforeach

    <!-- Karakter Section -->
    <section id="pendidikan-karakter" class="container py-5">

        {{-- Section Title --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="text-start">
                    {{ $section->section_title ?? 'Pendidikan Karakter' }}
                </h2>
            </div>
        </div>

        {{-- =========================
            Karakter 1
        ========================= --}}
        @if($section)
        <div class="row align-items-center mb-5">

            {{-- Carousel --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div id="carouselKarakter" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded overflow-hidden">

                        @forelse($characterCarousels as $index => $item)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $item->image) }}" class="d-block w-100" alt="{{ $item->title }}">
                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                                <p>
                                    {{ $item->title }}
                                </p>
                            </div>
                        </div>

                        @empty

                        <div class="carousel-item active">
                            <div class="d-flex align-items-center justify-content-center bg-secondary text-white" style="height: 300px;">
                                <p class="mb-0">Belum ada gambar carousel</p>
                            </div>
                        </div>

                        @endforelse
                    </div>

                    {{-- Prev --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselKarakter" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    {{-- Next --}}
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselKarakter" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="col-lg-6 karakter-text" data-aos="fade-right">
                <h3>
                    {{ $section->title }}
                </h3>
                <p>
                    {{ $section->description }}
                </p>
                <a href="/organisasi" class="btn btn-karakter mt-3">
                    Baca Selengkapnya
                </a>
            </div>
        </div>

        @else
        <div class="row">
            <div class="col-12 text-center text-muted py-5">
                <p>Konten belum tersedia.</p>
            </div>
        </div>
        @endif
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">

            @foreach($stats as $index => $stat)
            <div class="wrapper" data-aos="fade-down" data-aos-delay="{{ ($index + 1) * 300 }}">
                <div class="stat-card">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="{{ $stat->icon }}"></i>
                        </div>
                        <div class="stat-number">{{ $stat->number }}</div>
                        <p>{{ $stat->label }}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </section>

    <!-- Berita Section -->
    <section id="berita" class="news-section">
        <div class="container-berita">
            <h2 class="section-title-berita" data-aos="fade-up">
                Berita Terbaru
            </h2>
            <div class="news-grid">

                @foreach ($beritaTerbaru as $index => $berita)
                <div class="wrapper" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 200 }}">
                    <div class="news-card">
                        <div class="news-image">
                            @if ($berita->gambar)
                                <img src="{{ Storage::url($berita->gambar) }}"
                                     alt="{{ $berita->judul }}" />
                            @else
                                <img src="{{ asset('images/default-berita.jpg') }}"
                                     alt="{{ $berita->judul }}" />
                            @endif
                        </div>
                        <div class="news-content">
                            <div class="news-date">
                                {{ $berita->tanggal_publish->translatedFormat('d F Y') }}
                            </div>
                            <h3 class="news-title">
                                {{ $berita->judul }}
                            </h3>
                            <p class="news-excerpt">
                                {{ $berita->excerpt }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="read-more">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="text-center mb-4 mt-5">
                <a href="/berita" class="btn btn-karakter">
                    Berita Lainnya
                </a>
            </div>
        </div>
    </section>

    <!-- Alamat Section -->
    <section id="alamat" class="alamat-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="alamat-col">
                    <div class="alamat-text">
                        <h2>Pesantren Tahfidz Daarul Qur'an Al-Jannah</h2>
                        <p>
                            Jl. Tegal Salam, Rt/Rw 022/008<br />
                            Kecamatan Cariu Kabupaten Bogor, Jawa Barat, 16840
                        </p>
                        <a href="https://wa.me/{{ config('services.whatsapp.admin_number') }}?text=Halo%20saya%20ingin%20bertanya" target="_blank"><i class="fab fa-whatsapp"></i>
                            Chat untuk info lebih lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection
