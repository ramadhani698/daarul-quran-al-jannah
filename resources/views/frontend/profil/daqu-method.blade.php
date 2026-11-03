@extends('frontend.layouts.app')

@section('title', 'Daqu Method')

@push('styles')
    <link href="{{ asset('css/daqu-method.css') }}" rel="stylesheet">
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-daqu" style="margin-top: 80px;">
        <div class="hero-content-daqu">
            <span class="hero-eyebrow-daqu">Daarul Qur'an Al-Jannah</span>
            <h2 class="hero-title-daqu">
                Metode Daqu
            </h2>
            <p class="hero-subtitle-daqu">
                Sistem Pembelajaran Terintegrasi
                Al-Qur'an dan Pengembangan Karakter Santri
            </p>
            <div class="hero-divider-daqu"></div>
            <p class="hero-arabic-daqu">
                رَّبِّ زِدۡنِي عِلۡمٗا
            </p>
        </div>
    </section>

    <main class="daqu-main">
        {{-- DAQU METHOD --}}
        <section id="daqu-method" class="daqu-section daqu-section--method">
            <div class="daqu-section-header" data-aos="fade-up" data-aos-delay="100">
                <h2>Daqu Method</h2>
                <div class="daqu-underline"></div>
            </div>

            <div class="daqu-grid">
                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="100">
                    <div class="daqu-card">
                        <div class="daqu-number">1</div>
                        <h3>Shalat Berjamaah & Jaga Hati, Jaga Sikap</h3>
                        <p>
                            Menjaga konsistensi ibadah shalat berjamaah
                            dan selalu memperbaiki hati serta sikap
                            dalam kehidupan sehari-hari.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <div class="daqu-card">
                        <div class="daqu-number">2</div>
                        <h3>Tahajjud, Dhuha & Qabliyah Ba'diyah</h3>
                        <p>
                            Melaksanakan shalat sunnah untuk mendekatkan
                            diri kepada Allah dan memohon berkah-Nya.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="300">
                    <div class="daqu-card">
                        <div class="daqu-number">3</div>
                        <h3>Menghafal & Tadabbur Al-Qur'an</h3>
                        <p>
                            Menghafal ayat-ayat suci Al-Qur'an dan
                            merenungkan maknanya untuk pedoman hidup.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="400">
                    <div class="daqu-card">
                        <div class="daqu-number">4</div>
                        <h3>Sedekah & Puasa Sunnah</h3>
                        <p>
                            Membiasakan bersedekah dan berpuasa sunnah
                            untuk membersihkan hati dan harta.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="500">
                    <div class="daqu-card">
                        <div class="daqu-number">5</div>
                        <h3>Belajar & Mengajar</h3>
                        <p>
                            Terus mengembangkan ilmu dan berbagi
                            pengetahuan untuk kemaslahatan umat.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="600">
                    <div class="daqu-card">
                        <div class="daqu-number">6</div>
                        <h3>Doa, Mendoakan & Minta Didoakan</h3>
                        <p>
                            Membangun budaya saling mendoakan dan
                            memohon pertolongan kepada Allah.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="700">
                    <div class="daqu-card">
                        <div class="daqu-number">7</div>
                        <h3>Ikhlas, Sabar, Syukur & Ridho</h3>
                        <p>
                            Menanamkan sifat ikhlas, sabar, syukur,
                            dan ridho dalam setiap aktivitas.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- PANCA JIWA --}}
        <section id="panca-jiwa" class="daqu-section daqu-section--panca">
            <div class="daqu-section-header" data-aos="fade-up" data-aos-delay="100">
                <h2>Panca Jiwa Pondok</h2>
                <div class="daqu-underline"></div>
            </div>
            <div class="daqu-grid">
                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="100">
                    <div class="daqu-card">
                        <div class="daqu-number">1</div>
                        <h3>Keikhlasan</h3>
                        <p>
                            Melakukan segala sesuatu dengan tulus
                            hanya karena Allah semata.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <div class="daqu-card">
                        <div class="daqu-number">2</div>
                        <h3>Kesederhanaan</h3>
                        <p>
                            Hidup sederhana dan tidak berlebih-lebihan
                            dalam segala hal.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="300">
                    <div class="daqu-card">
                        <div class="daqu-number">3</div>
                        <h3>Berdikari</h3>
                        <p>
                            Mandiri dalam memenuhi kebutuhan dan
                            tidak bergantung pada orang lain.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="400">
                    <div class="daqu-card">
                        <div class="daqu-number">4</div>
                        <h3>Ukhuwah Islamiyah</h3>
                        <p>
                            Menjalin persaudaraan yang kuat sesama muslim
                            berdasarkan iman.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="500">
                    <div class="daqu-card">
                        <div class="daqu-number">5</div>
                        <h3>Kebebasan</h3>
                        <p>
                            Bebas berpikir dan berkreasi selama berada
                            dalam koridor syariat Islam.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- MOTTO --}}
        <section id="motto" class="daqu-section daqu-section--motto">
            <div class="daqu-section-header" data-aos="fade-up" data-aos-delay="100">
                <h2>Motto Pendidikan</h2>
                <div class="daqu-underline"></div>
            </div>

            <div class="daqu-grid">
                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="100">
                    <div class="daqu-card">
                        <div class="daqu-number">1</div>
                        <h3>Berbudi Luhur</h3>
                        <p>
                            Menjunjung tinggi akhlak mulia
                            dalam setiap aspek kehidupan.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <div class="daqu-card">
                        <div class="daqu-number">2</div>
                        <h3>Berbadan Sehat</h3>
                        <p>
                            Menjaga kesehatan jasmani dan rohani
                            agar dapat beraktivitas dengan optimal
                            setiap hari.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="300">
                    <div class="daqu-card">
                        <div class="daqu-number">3</div>
                        <h3>Berpengetahuan Luas</h3>
                        <p>
                            Menguasai berbagai ilmu pengetahuan
                            untuk kemaslahatan umat.
                        </p>
                    </div>
                </div>

                <div class="daqu-card-wrapper" data-aos="fade-up" data-aos-delay="400">
                    <div class="daqu-card">
                        <div class="daqu-number">4</div>
                        <h3>Berpikiran Kritis</h3>
                        <p>
                            Mengembangkan kemampuan analitis
                            dan pemikiran yang mendalam.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection