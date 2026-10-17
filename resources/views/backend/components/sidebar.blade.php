<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light">
            <i class="fas fa-mosque"></i>
            Dashboard Admin
        </span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <!-- ================= HOME ================= -->
                @php
                    $homeMenu =
                        request()->routeIs('admin.carousel.*') ||
                        request()->routeIs('admin.benefit.*') ||
                        request()->routeIs('admin.benefit-image.*') ||
                        request()->routeIs('admin.curiculum-section.*') ||
                        request()->routeIs('admin.curiculum-item.*') ||
                        request()->routeIs('admin.extracurriculars.*') ||
                        request()->routeIs('admin.extracurricular-categories.*') ||
                        request()->routeIs('admin.character-section.*') ||
                        request()->routeIs('admin.character-carousel.*') ||
                        request()->routeIs('admin.stats.*') ||
                        request()->routeIs('admin.organisasi-santri.*');
                @endphp

                <li class="nav-item has-treeview {{ $homeMenu ? 'menu-open' : '' }}">

                    <a href="#"
                    class="nav-link {{ $homeMenu ? 'active' : '' }}">

                        <i class="nav-icon fas fa-home"></i>

                        <p>
                            Home
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        {{-- Carousel --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.carousel.index') }}"
                            class="nav-link {{ request()->routeIs('admin.carousel.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Carousel</p>

                            </a>

                        </li>

                        {{-- Benefit --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.benefit.index') }}"
                            class="nav-link {{
                                    request()->routeIs('admin.benefit.*') ||
                                    request()->routeIs('admin.benefit-image.*')
                                        ? 'active'
                                        : ''
                            }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Benefit</p>

                            </a>

                        </li>

                        {{-- Pendidikan --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.curiculum-section.index') }}"
                            class="nav-link {{ request()->routeIs('admin.curiculum-section.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Pendidikan</p>

                            </a>

                        </li>

                        {{-- Ekskul --}}
                        <li class="nav-item has-treeview {{ request()->routeIs('admin.extracurriculars.*') || request()->routeIs('admin.extracurricular-categories.*') ? 'menu-open' : '' }}">

                            <a href="#" class="nav-link {{ request()->routeIs('admin.extracurriculars.*') || request()->routeIs('admin.extracurricular-categories.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-running"></i>
                                <p>
                                    Ekskul
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                
                                <li class="nav-item">
                                    <a href="{{ route('admin.extracurricular-categories.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.extracurricular-categories.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori Ekskul</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.extracurriculars.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.extracurriculars.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Ekskul</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        {{-- Karakter --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.character-section.index') }}"
                            class="nav-link {{ request()->routeIs('admin.character-section.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Karakter</p>

                            </a>

                        </li>

                        {{-- Statistik --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.stats.index') }}"
                            class="nav-link {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Statistik</p>

                            </a>

                        </li>

                        {{-- Organisasi --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.organisasi-santri.index') }}"
                            class="nav-link {{ request()->routeIs('admin.organisasi-santri.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Organisasi</p>

                            </a>

                        </li>

                    </ul>

                </li>

                <!-- ================= PROFIL ================= -->
                 @php
                    $sejarahMenu =
                        request()->routeIs('admin.sejarah.*') ||
                        request()->routeIs('admin.sejarah-images.*');
                @endphp
                <li class="nav-item has-treeview
                    {{ $sejarahMenu ? 'menu-open' : '' }}">

                    <a href="#"
                       class="nav-link
                       {{ $sejarahMenu ? 'active' : '' }}">

                        <i class="nav-icon fas fa-user"></i>

                        <p>
                            Profil
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.sejarah.index') }}"
                               class="nav-link {{ request()->routeIs('admin.sejarah.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Sejarah</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- ================= NEWS ================= -->
                @php
                    $newsMenu =
                        request()->routeIs('admin.berita.*') ||
                        request()->routeIs('admin.info-akademik.*') ||
                        request()->routeIs('admin.info-santri.*') ||
                        request()->routeIs('admin.alumni.*');
                @endphp
                <li class="nav-item has-treeview {{ $newsMenu ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ $newsMenu ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            News
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        {{-- Berita --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.berita.index') }}"
                            class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Berita Pilihan</p>
                            </a>
                        </li>

                        {{-- Info Akademik (sub-treeview) --}}
                        @php
                            $infoAkademikMenu = request()->routeIs('admin.info-akademik.*');
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('admin.info-akademik.index') }}"
                            class="nav-link {{ request()->routeIs('admin.info-akademik.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Info Akademik</p>
                            </a>
                        </li>

                        {{-- Info Santri (placeholder) --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.info-santri.index') }}"
                            class="nav-link {{ request()->routeIs('admin.info-santri.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Info Santri</p>
                            </a>
                        </li>

                        {{-- Info Alumni (placeholder) --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.alumni.index') }}"
                            class="nav-link {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Info Alumni</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- ================= GALERI ================= -->
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.galeri.index') }}"
                        class="nav-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-image"></i>

                        <p>
                            Galeri
                        </p>
                    </a>
                </li>

                <!-- ================= PRODUK ================= -->
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.produk.index') }}" class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>

                        <p>
                            Produk
                        </p>
                    </a>
                </li>

                <!-- ================= PENDAFTARAN ================= -->
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>

                        <p>
                            Pendaftaran
                        </p>
                    </a>
                </li>

                <!-- ================= DONASI ================= -->
                @php
                    $donasiMenu =
                        request()->routeIs('admin.carousel-donasi.*') ||
                        request()->routeIs('admin.kategori-donasi.*') ||
                        request()->routeIs('admin.program-donasi.*') ||
                        request()->routeIs('admin.donasi.*');
                @endphp
                <li class="nav-item has-treeview {{ $donasiMenu ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ $donasiMenu ? 'active' : '' }}">

                        <i class="nav-icon fas fa-donate"></i>

                        <p>
                            Donasi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.carousel-donasi.index') }}"
                            class="nav-link {{ request()->routeIs('admin.carousel-donasi.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Carousel Donasi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.kategori-donasi.index') }}"
                            class="nav-link {{ request()->routeIs('admin.kategori-donasi.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Donasi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.program-donasi.index') }}"
                            class="nav-link {{ request()->routeIs('admin.program-donasi.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Program Donasi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.donasi.program') }}"
                            class="nav-link {{ request()->routeIs('admin.donasi.program') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Donasi Program</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.donasi.non-program') }}"
                            class="nav-link {{ request()->routeIs('admin.donasi.non-program') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>
                                <p>Donasi Umum</p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>

    </div>

</aside>