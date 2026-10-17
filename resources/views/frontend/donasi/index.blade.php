@extends('frontend.layouts.donasi')

@section('title', 'Amal Jariyah — Daarul Qur\'an Al-Jannah')

@section('content')

@if ($carousels->isNotEmpty())
<section class="donasi-carousel">
    <div class="donasi-carousel__track" id="donasiCarouselTrack">
        @foreach ($carousels as $c)
            @php $alt = $c->judul ?: 'Banner donasi'; @endphp

            @if ($c->isProgram() && $c->program)
                <a href="{{ route('donasi.show', $c->program->slug) }}" class="donasi-carousel__link">
                    <img src="{{ asset('storage/' . $c->gambar) }}" alt="{{ $alt }}" class="donasi-carousel__slide">
                </a>
            @else
                <img src="{{ asset('storage/' . $c->gambar) }}" alt="{{ $alt }}" class="donasi-carousel__slide">
            @endif
        @endforeach
    </div>
    <div class="donasi-carousel__dots" id="donasiCarouselDots"></div>
</section>
@endif

<section class="donasi-cta">
    <div class="donasi-cta__wrap">
        @forelse ($kategoris as $kategori)
            @php $umum = $kategori->programUmum; @endphp
            @if ($umum)
                <a href="{{ route('donasi.show', $umum->slug) }}" class="donasi-cta__card">
                    <div class="donasi-cta__arch">
                        @if ($kategori->icon)
                            <img src="{{ asset('storage/' . $kategori->icon) }}" alt="{{ $kategori->nama }}">
                        @else
                            <span class="donasi-cta__initial">{{ mb_substr($kategori->nama, 0, 1) }}</span>
                        @endif
                    </div>
                    <h3 class="donasi-cta__name">{{ $kategori->nama }}</h3>
                </a>
            @else
                <div class="donasi-cta__card donasi-cta__card--disabled">
                    <div class="donasi-cta__arch">
                        @if ($kategori->icon)
                            <img src="{{ asset('storage/' . $kategori->icon) }}" alt="{{ $kategori->nama }}">
                        @else
                            <span class="donasi-cta__initial">{{ mb_substr($kategori->nama, 0, 1) }}</span>
                        @endif
                    </div>
                    <h3 class="donasi-cta__name">{{ $kategori->nama }}</h3>
                    <span class="donasi-cta__soon">Segera Hadir</span>
                </div>
            @endif
        @empty
            <p class="donasi-cta__empty">Kategori donasi belum tersedia saat ini.</p>
        @endforelse
    </div>
</section>

<section class="donasi-hero">
    <div class="donasi-hero__card">
        <canvas id="donasiParticles" class="donasi-hero__canvas"></canvas>
        <div class="donasi-hero__blob donasi-hero__blob-1"></div>
        <div class="donasi-hero__blob donasi-hero__blob-2"></div>
        <div class="donasi-hero__blob donasi-hero__blob-3"></div>
        <div class="donasi-hero__corner donasi-hero__corner-tl"></div>
        <div class="donasi-hero__corner donasi-hero__corner-tr"></div>
        <div class="donasi-hero__corner donasi-hero__corner-bl"></div>
        <div class="donasi-hero__corner donasi-hero__corner-br"></div>

        <div class="donasi-hero__inner">
            <p class="donasi-hero__arabic">وَمَا تُنفِقُوا مِنْ خَيْرٍ يُوَفَّ إِلَيْكُمْ</p>
            <p class="donasi-hero__latin">"Wa maa tunfiquu min khoirin yuwaffa ilaikum"</p>
            <p class="donasi-hero__translation">Apa pun kebaikan yang kalian infakkan, balasannya akan disempurnakan untuk kalian.</p>
            <h1 class="donasi-hero__title">Setiap Rupiah,<br>Jejak Amal yang Mengalir</h1>
        </div>
    </div>
</section>

<section class="donasi-programs">
    <div class="donasi-programs__head">
        <span class="donasi-programs__eyebrow">Program Berjalan</span>
        <h2 class="donasi-programs__title">Pilih Program yang Ingin Anda Dukung</h2>
    </div>

    @if ($programs->isEmpty())
        <div class="donasi-programs__empty">
            <p>Belum ada program khusus yang berjalan saat ini. Donasi umum tetap terbuka lewat kategori di atas.</p>
        </div>
    @else
        @php $programsByKategori = $programs->groupBy('kategori_donasi_id'); @endphp

        @foreach ($kategoris as $kategori)
            @php $items = $programsByKategori->get($kategori->id); @endphp
            @continue(!$items || $items->isEmpty())

            <div class="donasi-programs__row">
                <h3 class="donasi-programs__row-title">{{ $kategori->nama }}</h3>

                <div class="splide donasi-program-slider">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($items as $program)
                                <li class="splide__slide">
                                    <article class="donasi-program-card">
                                        <div class="donasi-program-card__arch">
                                            @if ($program->gambar)
                                                <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
                                            @endif
                                        </div>

                                        <div class="donasi-program-card__body">
                                            <span class="donasi-program-card__kategori">{{ $program->kategori->nama }}</span>
                                            <h3 class="donasi-program-card__title">{{ $program->nama_program }}</h3>
                                            <!-- <p class="donasi-program-card__desc">{{ Str::limit($program->deskripsi, 70) }}</p> -->

                                            @if ($program->target_donasi)
                                                <div class="donasi-progress">
                                                    <div class="donasi-progress__bar">
                                                        <div class="donasi-progress__fill" style="width: {{ $program->persentase }}%"></div>
                                                    </div>
                                                    <div class="donasi-progress__meta">
                                                        <span>Rp{{ number_format($program->terkumpul, 0, ',', '.') }}</span>
                                                        <span>{{ $program->persentase }}%</span>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="donasi-program-card__nolimit">Terkumpul: Rp{{ number_format($program->terkumpul, 0, ',', '.') }}</p>
                                            @endif

                                            <div class="donasi-program-card__footer">
                                                <span>{{ $program->jumlah_donatur }} donatur</span>
                                                <a href="{{ route('donasi.show', $program->slug) }}" class="donasi-program-card__link">
                                                    Lihat Detail &rarr;
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</section>

<section class="donasi-quote">
    <div class="donasi-quote__card">
        <span class="donasi-quote__mark" aria-hidden="true">&ldquo;</span>
        <p class="donasi-quote__text">
            Sedekah tidak akan mengurangi harta, dan Allah akan menambah kemuliaan seseorang
            yang suka memaafkan.
        </p>
        <span class="donasi-quote__source">— HR. Muslim</span>
    </div>

    <div class="donasi-quote__closing">
        <h3 class="donasi-quote__closing-title">Jangan Tunda Kebaikan Hari Ini</h3>
        <p class="donasi-quote__closing-desc">
            Setiap rupiah yang Anda salurkan adalah investasi akhirat yang tak pernah putus
            pahalanya, insyaAllah.
        </p>
    </div>
</section>
@endsection