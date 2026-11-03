<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Brand -->
            <div class="col-lg-5 col-md-12 mb-4 footer-brand-section text-center text-lg-start">
                <img src="{{ asset('images/logo2.jpg') }}" alt="Logo 2" class="footer-logo mb-2">
                <p class="footer-text">Daarul Qur'an Al-Jannah</p>
                <div class="footer-socials">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- 3 kolom menu -->
            <div class="col-lg-7 col-md-12">
                <div class="row text-center text-md-start">
                    <div class="col-4 mb-4">
                        <h5 class="footer-title">Profil</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('sejarah') }}">Sejarah Pesantren</a></li>
                            <li><a href="{{ route('visi-misi') }}">Visi dan Misi</a></li>
                            <li><a href="{{ route('daqu-method') }}">Daqu Method</a></li>
                        </ul>
                    </div>

                    <div class="col-4 mb-4">
                        <h5 class="footer-title">News</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('berita.index') }}">Berita Pilihan</a></li>
                            <li><a href="{{ route('berita.index') }}">Artikel</a></li>
                            <li><a href="{{ route('news.info-akademik') }}">Info Akademik</a></li>
                        </ul>
                    </div>

                    <div class="col-4 mb-4">
                        <h5 class="footer-title">Tentang Santri</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('news.info-santri') }}">Info Santri</a></li>
                            <li><a href="{{ route('news.alumni') }}">Info Alumni</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr class="footer-divider">

        <p class="footer-copy text-center mt-3 mb-0">
            &copy; {{ date('Y') }} Pondok Pesantren Tahfidz Daarul Qur'an Al-Jannah
        </p>
    </div>
</footer>
