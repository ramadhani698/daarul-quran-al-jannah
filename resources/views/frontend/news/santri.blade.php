@extends('frontend.layouts.app')

@section('title', 'Info Santri')

@push('styles')
    <link href="{{ asset('css/santri.css') }}" rel="stylesheet">
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-section-santri" style="margin-top: 70px;">

        {{-- Canvas partikel geometris --}}
        <canvas id="hero-canvas-santri"></canvas>

        {{-- Blob dekoratif latar --}}
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>

        {{-- Ornamen bracket sudut --}}
        <div class="hero-corner hero-corner-tl"></div>
        <div class="hero-corner hero-corner-tr"></div>
        <div class="hero-corner hero-corner-bl"></div>
        <div class="hero-corner hero-corner-br"></div>

        {{-- Konten utama --}}
        <div class="hero-content">

            {{-- Eyebrow pill --}}
            <div class="hero-eyebrow">
                <span class="hero-eyebrow-dot"></span>
                Daarul Qur'an Al-Jannah
            </div>

            <h1 class="hero-title">
                Informasi Santri Tahfidz
            </h1>

            <p class="hero-subtitle">
                Platform informasi digital santri tahfidz Qur'an
            </p>

            {{-- Ornamen garis + berlian emas --}}
            <div class="hero-ornament">
                <div class="hero-ornament-line"></div>
                <div class="hero-ornament-diamond"></div>
                <div class="hero-ornament-line right"></div>
            </div>

            {{-- Ayat Arab --}}
            <p class="hero-ayat">
                وَلَقَدْ يَسَّرْنَا الْقُرْآنَ لِلذِّكْرِ فَهَلْ مِن مُّدَّكِرٍ
            </p>

            {{-- Terjemahan --}}
            <p class="hero-ayat-latin">
                "Dan sungguh, telah Kami mudahkan Al-Qur'an untuk pelajaran..." — QS. Al-Qamar: 17
            </p>

        </div>

    </section>

    {{-- MAIN CONTENT --}}
    <main class="main-container">
        {{-- PRESTASI SECTION --}}
        <section id="prestasi" class="prestasi-section">
            <div class="prestasi-container">
                <div class="prestasi-header">
                    <h2 class="prestasi-title">
                        Prestasi Santri
                    </h2>
                    <div class="prestasi-divider"></div>
                </div>
                <div class="prestasi-grid">
                    @forelse ($infoSantris as $item)
                        <div class="wrapper" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                            <div class="prestasi-card">
                                <img src="{{ Storage::url($item->foto) }}"
                                    alt="{{ $item->judul }}"
                                    class="prestasi-image">
                                <div class="prestasi-content">
                                    <div class="prestasi-label">
                                        {{ $item->kategori }}
                                    </div>
                                    <h3 class="prestasi-heading">
                                        {{ $item->judul }}
                                    </h3>
                                    <p class="prestasi-desc">
                                        {{ $item->deskripsi }}
                                    </p>
                                    <div class="prestasi-profile">
                                        <p class="prestasi-name">
                                            {{ $item->nama }}
                                        </p>
                                        <p class="prestasi-class">
                                            {{ $item->kelas }}
                                        </p>
                                        <p class="prestasi-year">
                                            {{ $item->tahun }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada data prestasi.</p>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($infoSantris->hasPages())
                    <div class="prestasi-pagination">
                        {{ $infoSantris->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>

@endsection

@push('scripts')
    <script src="{{ asset('js/santri.js') }}"></script>
@endpush