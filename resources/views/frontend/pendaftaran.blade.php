@extends('frontend.layouts.app')

@section('title', 'Pendaftaran Santri')

@section('content')
    <section class="hero-section-pendaftaran" id="pendaftaran">
        <canvas id="hero-canvas-pendaftaran"></canvas>
        <div class="pendaftaran-blob pendaftaran-blob-1"></div>
        <div class="pendaftaran-blob pendaftaran-blob-2"></div>
        <div class="pendaftaran-blob pendaftaran-blob-3"></div>
        <div class="pendaftaran-corner pendaftaran-corner-tl"></div>
        <div class="pendaftaran-corner pendaftaran-corner-tr"></div>
        <div class="pendaftaran-corner pendaftaran-corner-bl"></div>
        <div class="pendaftaran-corner pendaftaran-corner-br"></div>
        <div class="hero-content-pendaftaran">
            <div class="hero-eyebrow-pendaftaran">
                <span class="hero-eyebrow-dot-pendaftaran"></span>
                Pendaftaran Santri Baru
            </div>
            <h1 class="hero-title-pendaftaran">
                Pondok Pesantren Daarul Qur'an Al-Jannah
            </h1>
            <p class="hero-subtitle-pendaftaran">
                Mencetak Generasi Qur'ani yang Berakhlak Mulia
            </p>
            <div class="hero-pendaftaran-ornament">
                <div class="hero-pendaftaran-ornament-line"></div>
                <div class="hero-pendaftaran-ornament-diamond"></div>
                <div class="hero-pendaftaran-ornament-line right"></div>
            </div>
        </div>
    </section>

    <section class="pendaftaran-section" id="formPendaftaran">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7" data-aos="fade-up">
                    <div class="pendaftaran-card text-center">
                        <h2>Pendaftaran Santri Baru</h2>
                        <p class="text-muted mb-4">
                            Bergabunglah dengan keluarga besar Pondok Pesantren untuk
                            membentuk generasi Qur'ani yang unggul.
                        </p>

                        <ul class="info-list-pendaftaran text-start">
                            <li><i class="fa-solid fa-user"></i> Usia: 10–18 tahun</li>
                            <li><i class="fa-solid fa-calendar"></i> Periode: Tahun Ajaran 2025/2026</li>
                            <li><i class="fa-solid fa-hand-holding-dollar"></i> Biaya: Gratis untuk santri berprestasi</li>
                            <li><i class="fa-solid fa-building"></i> Fasilitas: Asrama, Pendidikan Umum & Agama, Olahraga</li>
                        </ul>

                        <a href="https://forms.gle/SFmtHPSJuXvpVZ6N6" target="_blank" rel="noopener" class="cta-daftar">
                            Daftar Sekarang <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection