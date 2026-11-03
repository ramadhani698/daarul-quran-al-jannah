@extends('frontend.layouts.app')

@section('title', 'Galeri')

@push('styles')
    <link href="{{ asset('css/galeri.css') }}" rel="stylesheet">
@endpush

@section('content')

    {{-- HERO SECTION GALERI --}}
    <section class="hero-section-gallery" id="galeri">
        <canvas id="hero-canvas-gallery"></canvas>
        <div class="gallery-blob gallery-blob-1"></div>
        <div class="gallery-blob gallery-blob-2"></div>
        <div class="gallery-blob gallery-blob-3"></div>
        <div class="gallery-corner gallery-corner-tl"></div>
        <div class="gallery-corner gallery-corner-tr"></div>
        <div class="gallery-corner gallery-corner-bl"></div>
        <div class="gallery-corner gallery-corner-br"></div>
        <div class="hero-content-gallery">
            <div class="hero-eyebrow">
                <span class="hero-eyebrow-dot"></span>
                Dokumentasi Kegiatan
            </div>
            <h2 class="hero-title-gallery">
                Galeri Pesantren Tahfidz Daarul Qur'an Al-Jannah
            </h2>
            <p class="hero-subtitle-gallery">
                Menyaksikan momen berharga dalam perjalanan menghafal
                Al-Qur'an bersama para santri.
            </p>
            <div class="hero-gallery-ornament">
                <div class="hero-gallery-ornament-line"></div>
                <div class="hero-gallery-ornament-diamond"></div>
                <div class="hero-gallery-ornament-line right"></div>
            </div>
        </div>
    </section>

    <section class="gallery-section">
        <div class="section-header-gallery" data-aos="fade-up">
            <h2 class="section-gallery-title">Momen Terindah Kami</h2>
            <p class="section-gallery-subtitle">
                Berikut adalah dokumentasi kegiatan dan keseharian para santri dalam program tahfidz Al-Qur'an
            </p>
        </div>

        <div class="gallery-grid">
            @forelse($galeris as $index => $galeri)
                <div class="gallery-item"
                    data-aos="zoom-in"
                    data-aos-delay="{{ ($index % 12 + 1) * 100 }}"
                    style="cursor: pointer;"
                    onclick="openModal(
                        '{{ asset('storage/' . $galeri->foto) }}',
                        '{{ addslashes($galeri->judul) }}',
                        '{{ addslashes($galeri->deskripsi ?? '') }}'
                    )">

                    <img
                        src="{{ asset('storage/' . $galeri->foto) }}"
                        alt="{{ $galeri->judul }}"
                        class="gallery-img"
                    />

                    <div class="gallery-overlay">
                        <div class="gallery-caption">
                            <h3>{{ $galeri->judul }}</h3>
                            @if($galeri->deskripsi)
                                <p>{{ $galeri->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada foto galeri.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($galeris->hasPages())
            <div style="text-align:center; margin-top:20px;">
                {{ $galeris->links() }}
            </div>
        @endif

    </section>

    {{-- Modal --}}
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img
                        id="modalImage"
                        src=""
                        alt=""
                        class="img-fluid mb-3"
                    />
                    <h5 id="modalTitle"></h5>
                    <p id="modalDesc"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        function openModal(image, title, desc) {
            document.getElementById('modalImage').src = image;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerText = desc;

            let galleryModal = new bootstrap.Modal(
                document.getElementById('galleryModal')
            );

            galleryModal.show();
        }
    </script>

@endsection

@push('scripts')
    <script src="{{ asset('js/galeri.js') }}"></script>
@endpush