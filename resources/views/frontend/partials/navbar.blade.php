<nav class="navbar navbar-expand-lg fixed-top navbar-light">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-daqu.png') }}"
                 alt="Logo Daarul Qur'an">
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileNavbar"
                aria-controls="mobileNavbar">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- DESKTOP MENU -->
        <div class="collapse navbar-collapse d-none d-lg-flex">

            <ul class="navbar-nav mx-auto align-items-lg-center">

                <li class="nav-item">
                    <a href="/" class="nav-link">Home</a>
                </li>

                <!-- PROFIL -->
                <li class="nav-item dropdown hover-dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Profil
                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="/sejarah">
                                Sejarah Pesantren
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/visi-misi">
                                Visi Misi
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/daqu-method">
                                Daqu Method
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- NEWS -->
                <li class="nav-item dropdown hover-dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        News
                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="/berita">
                                Berita Pilihan
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/info-akademik">
                                Info Akademik
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/info-santri">
                                Info Santri
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="/info-alumni">
                                Info Alumni
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/galeri" class="nav-link">Galeri</a>
                </li>

                <li class="nav-item">
                    <a href="/pendaftaran" class="nav-link">Pendaftaran</a>
                </li>

            </ul>

            <!-- BUTTON DONASI -->
            <div class="d-flex align-items-center gap-2">
                <a href="/produk" class="btn btn-keranjang" title="Produk Pesantren">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <a href="/donasi" class="btn btn-donasi" target="_blank">
                    <i class="fas fa-donate"></i>
                </a>
            </div>

        </div>

    </div>
</nav>

<!-- =========================
     MOBILE OFFCANVAS
========================= -->

<div class="offcanvas offcanvas-start mobile-sidebar"
     tabindex="-1"
     id="mobileNavbar">

    <!-- HEADER -->
    <div class="offcanvas-header">

        <img src="{{ asset('images/logo-daqu.png') }}"
             alt="Logo"
             class="mobile-logo">

        <button type="button"
                class="btn-close shadow-none"
                data-bs-dismiss="offcanvas">
        </button>

    </div>

    <!-- BODY -->
    <div class="offcanvas-body">

        <ul class="navbar-nav">

            <li class="nav-item">
                <a href="/" class="nav-link">Home</a>
            </li>

            <!-- PROFIL -->
            <li class="nav-item">

                <button class="mobile-dropdown"
                        data-bs-toggle="collapse"
                        data-bs-target="#profilMenu">

                    Profil
                    <i class="fas fa-chevron-down"></i>

                </button>

                <div class="collapse mobile-submenu" id="profilMenu">

                    <a href="/sejarah" class="submenu-link">
                        Sejarah Pesantren
                    </a>

                    <a href="/visi-misi" class="submenu-link">
                        Visi Misi
                    </a>

                    <a href="/daqu-method" class="submenu-link">
                        Daqu Method
                    </a>

                </div>

            </li>

            <!-- NEWS -->
            <li class="nav-item">

                <button class="mobile-dropdown"
                        data-bs-toggle="collapse"
                        data-bs-target="#newsMenu">

                    News
                    <i class="fas fa-chevron-down"></i>

                </button>

                <div class="collapse mobile-submenu" id="newsMenu">

                    <a href="/berita" class="submenu-link">
                        Berita Pilihan
                    </a>

                    <a href="/info-akademik" class="submenu-link">
                        Info Akademik
                    </a>

                    <a href="/info-santri" class="submenu-link">
                        Info Santri
                    </a>

                    <a href="/info-alumni" class="submenu-link">
                        Info Alumni
                    </a>

                </div>

            </li>

            <li class="nav-item">
                <a href="/galeri" class="nav-link">Galeri</a>
            </li>

            <li class="nav-item">
                <a href="/pendaftaran" class="nav-link">Pendaftaran</a>
            </li>

        </ul>

        <!-- BUTTON -->
        <div class="d-flex gap-2 mt-4">
            <a href="/produk" class="btn btn-keranjang-mobile">
                <i class="fas fa-shopping-cart"></i>
                Produk
            </a>
            <a href="#" class="btn btn-donasi-mobile">
                <i class="fas fa-donate"></i>
                Donasi
            </a>
        </div>

    </div>

</div>