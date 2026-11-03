@extends('frontend.layouts.app')

@section('title', 'Produk Pesantren')

@push('styles')
    <link href="{{ asset('css/produk.css') }}" rel="stylesheet">
@endpush

@section('content')

{{-- ══ HERO ══ --}}
<section class="prd-hero">
    <div class="prd-hero__pattern" aria-hidden="true"></div>
    <div class="prd-hero__glow"    aria-hidden="true"></div>

    <div class="prd-hero__inner">

        {{-- Kiri: copy --}}
        <div>
            <span class="prd-hero__eyebrow">Daarul Qur'an Al-Jannah</span>

            <h1 class="prd-hero__title">
                Produk <em>Halal</em> &amp;<br>Berkualitas Tinggi
            </h1>

            <p class="prd-hero__sub">
                Setiap produk yang Anda beli mendukung kemandirian ekonomi
                pesantren dan pendidikan Al-Qur'an generasi berikutnya.
            </p>

            <a href="#produk" class="prd-hero__cta">
                Lihat Produk
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>

        {{-- Kanan: stats --}}
        <div class="prd-hero__visual" aria-hidden="true">
            <div class="prd-hero__stat-row">
                <div class="prd-hero__stat">
                    <div class="prd-hero__stat-num">100%</div>
                    <div class="prd-hero__stat-label">Halal &amp; Terjamin</div>
                </div>
                <div class="prd-hero__stat">
                    <div class="prd-hero__stat-num">Asli</div>
                    <div class="prd-hero__stat-label">Produk Pesantren</div>
                </div>
            </div>

            <div class="prd-hero__badge">
                <div class="prd-hero__badge-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div class="prd-hero__badge-text">
                    <strong>Diproduksi dengan standar terbaik</strong>
                    Setiap produk melalui seleksi ketat sebelum sampai ke tangan Anda.
                </div>
            </div>

            <div class="prd-hero__badge">
                <div class="prd-hero__badge-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.47 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 5.51 5.51l.94-.94a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <div class="prd-hero__badge-text">
                    <strong>Pengiriman ke seluruh Indonesia</strong>
                    Hubungi kami via WhatsApp untuk informasi pengiriman.
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ══ TRUST STRIP ══ --}}
<div class="prd-trust">
    <div class="prd-trust__inner">

        <div class="prd-trust__item">
            <div class="prd-trust__icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <div class="prd-trust__label">Jaminan</div>
                <div class="prd-trust__val">Produk Halal &amp; Alami</div>
            </div>
        </div>

        <div class="prd-trust__item">
            <div class="prd-trust__icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </div>
            <div>
                <div class="prd-trust__label">Mendukung</div>
                <div class="prd-trust__val">Ekonomi Umat &amp; Pesantren</div>
            </div>
        </div>

        <div class="prd-trust__item">
            <div class="prd-trust__icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.47 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 5.51 5.51l.94-.94a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
            </div>
            <div>
                <div class="prd-trust__label">Pesan Langsung via</div>
                <div class="prd-trust__val">WhatsApp — Cepat &amp; Mudah</div>
            </div>
        </div>

    </div>
</div>

{{-- ══ PRODUK ══ --}}
<section class="prd-section" id="produk">

    <div class="prd-section__head">
        <p class="prd-section__eyebrow">Pilihan Terbaik Kami</p>
        <h2 class="prd-section__title">Produk Unggulan</h2>
        <p class="prd-section__sub">
            Dipilih dengan teliti, diproduksi dengan amanah — setiap produk
            membawa manfaat nyata bagi kesehatan dan kehidupan Anda.
        </p>
    </div>

    <div class="prd-grid">

        @forelse ($produks as $produk)
        <article class="prd-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 300 }}">
            <div class="prd-card__img-wrap">
                <img
                    src="{{ asset('storage/' . $produk->gambar) }}"
                    alt="{{ $produk->nama }}"
                    loading="lazy"
                >
                @if($produk->badge)
                    <span class="prd-card__badge">{{ $produk->badge }}</span>
                @endif
            </div>

            <div class="prd-card__body">
                <p class="prd-card__cat">{{ $produk->kategori }}</p>
                <h3 class="prd-card__title">{{ $produk->nama }}</h3>
                <p class="prd-card__desc">
                    {{ $produk->deskripsi }}
                </p>

                <div class="prd-card__foot">
                    <div>
                        <p class="prd-card__price-label">Harga</p>
                        <p class="prd-card__price">{{ $produk->harga_format }}</p>
                    </div>
                    
                        <a
                            href="{{ $produk->wa_link }}"
                            class="prd-card__btn"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Pesan {{ $produk->nama }} via WhatsApp"
                        >
                            Pesan
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </a>
                </div>
            </div>
        </article>

        @empty
        <p class="text-center text-muted">Belum ada produk tersedia saat ini.</p>
        @endforelse
    </div>

</section>

@endsection