@extends('frontend.layouts.app')

@section('title', 'Visi Misi')

@push('styles')
    <link href="{{ asset('css/visi-misi.css') }}" rel="stylesheet">
@endpush

@section('content')

    <section class="container py-5 visi-misi-section" style="margin-top: 70px;">

        {{-- Hero Image with Title Overlay --}}
        <div class="visi-misi-hero" data-aos="fade-in">
            <img src="{{ asset('images/masjid.jpg') }}" alt="Visi Misi Pesantren">
            <div class="visi-misi-hero-overlay">
                <span class="visi-misi-eyebrow">Daarul Qur'an Al-Jannah</span>
                <h2 class="visi-misi-title">Visi & Misi Pesantren</h2>
            </div>
        </div>

        {{-- Visi & Misi (lebar sejajar dengan hero) --}}
        <div class="visi-misi-grid">

            {{-- Visi --}}
            <div class="visi-misi-wrapper" data-aos="fade-up" data-aos-delay="100">
                <div class="visi-misi-card">
                    <div class="visi-misi-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4 class="visi-title">Visi</h4>
                    <p class="visi-paragraph">
                        Melahirkan generasi pemimpin bangsa dan dunia
                        yang shaleh dan berkarakter Qur'an serta
                        berjiwa entrepreneur dalam membangun
                        peradaban Islam masa depan.
                    </p>
                </div>
            </div>

            {{-- Misi --}}
            <div class="visi-misi-wrapper" data-aos="fade-up" data-aos-delay="200">
                <div class="visi-misi-card misi-card">
                    <div class="visi-misi-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h4 class="misi-title">Misi</h4>
                    <p class="misi-paragraph">
                        Mewujudkan lembaga pendidikan berbasis
                        Daqu Method (Iqoomatu Waajib wa Ihyaaussunnah)
                        yang unggul, kompetitif, global,
                        dan rahmatan lil 'alamin.
                    </p>
                </div>
            </div>

        </div>

    </section>

@endsection