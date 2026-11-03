@extends('frontend.layouts.app')

@section('title', $berita->judul)

@push('styles')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endpush

@section('meta')
    <meta name="description" content="{{ $berita->excerpt }}">
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ $berita->excerpt }}">
    @if ($berita->gambar)
        <meta property="og:image" content="{{ Storage::url($berita->gambar) }}">
    @endif
@endsection

@section('content')

{{-- Hero gambar --}}
@if ($berita->gambar)
    <div class="berita-hero" style="margin-top: 80px;">
        <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" class="berita-hero-img">
        <div class="berita-hero-overlay"></div>
    </div>
@endif

<section class="berita-detail-section">
    <div class="container-berita-detail">

        {{-- Breadcrumb --}}
        <nav class="berita-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <span class="sep">›</span>
            <a href="{{ route('berita.index') }}">Berita</a>
            <span class="sep">›</span>
            <span>{{ Str::limit($berita->judul, 40) }}</span>
        </nav>

        <div class="berita-detail-layout">

            {{-- Konten Utama --}}
            <article class="berita-article" data-aos="fade-up">

                <header class="berita-article-header">
                    <div class="news-date">
                        <i class="ti ti-calendar-event"></i>
                        {{ $berita->tanggal_publish->translatedFormat('d F Y') }}
                    </div>
                    <h1 class="berita-detail-title">{{ $berita->judul }}</h1>
                    <p class="berita-detail-excerpt">{{ $berita->excerpt }}</p>
                    <hr class="berita-divider">
                </header>

                <div class="berita-article-body">
                    {!! nl2br(e($berita->konten)) !!}
                </div>

                {{-- Share & Navigasi --}}
                <footer class="berita-article-footer">
                    <div class="berita-share">
                        <span class="share-label">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . route('berita.show', $berita->slug)) }}"
                           target="_blank" rel="noopener" class="share-btn share-wa" aria-label="Bagikan ke WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('berita.show', $berita->slug)) }}"
                           target="_blank" rel="noopener" class="share-btn share-fb" aria-label="Bagikan ke Facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->judul) }}&url={{ urlencode(route('berita.show', $berita->slug)) }}"
                           target="_blank" rel="noopener" class="share-btn share-tw" aria-label="Bagikan ke Twitter/X">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>

                    <a href="{{ route('berita.index') }}" class="btn-kembali">
                        <i class="fas fa-arrow-left"></i> Semua Berita
                    </a>
                </footer>

            </article>

            {{-- Sidebar: Berita Lainnya --}}
            <aside class="berita-sidebar" data-aos="fade-up" data-aos-delay="200">
                <h3 class="sidebar-title">Berita Lainnya</h3>
                <div class="sidebar-list">
                    @forelse ($beritaLainnya as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" class="sidebar-item">
                            <div class="sidebar-item-img">
                                @if ($item->gambar)
                                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}">
                                @else
                                    <div class="sidebar-img-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="sidebar-item-content">
                                <div class="sidebar-item-date">{{ $item->tanggal_publish->translatedFormat('d M Y') }}</div>
                                <div class="sidebar-item-title">{{ $item->judul }}</div>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted small">Belum ada berita lainnya.</p>
                    @endforelse
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection