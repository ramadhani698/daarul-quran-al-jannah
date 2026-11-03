@extends('frontend.layouts.app')

@section('title', 'Info Akademik')

@push('styles')
    <link href="{{ asset('css/akademik.css') }}" rel="stylesheet">
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-section-akademik" style="margin-top: 70px;">

        {{-- Canvas partikel geometris --}}
        <canvas id="hero-canvas-akademik"></canvas>

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
                Informasi Akademik
            </h1>

            <p class="hero-subtitle">
                Program Pendidikan dan Kurikulum Tahfidz Qur'an
                di Pesantren Daarul Qur'an Al-Jannah
            </p>

            {{-- Ornamen garis + berlian emas --}}
            <div class="hero-ornament">
                <div class="hero-ornament-line"></div>
                <div class="hero-ornament-diamond"></div>
                <div class="hero-ornament-line right"></div>
            </div>

            {{-- Ayat Arab --}}
            <p class="hero-ayat">
                وَمَا كَانَ الْمُؤْمِنُونَ لِيَنفِرُوا كَآفَّةً ۚ فَلَوْلَا نَفَرَ مِن كُلِّ فِرْقَةٍ مِّنْهُمْ طَآئِفَةٌ لِّيَتَفَقَّهُوا۟ فِى ٱلدِّينِ
            </p>

            {{-- Terjemahan --}}
            <p class="hero-ayat-latin">
                "Mengapa tidak pergi dari tiap golongan di antara mereka beberapa orang untuk memperdalam pengetahuan agama mereka..." — QS. At-Taubah: 122
            </p>

        </div>

    </section>

    <main class="main-content">
        {{-- TOGGLE BUTTON MOBILE --}}
        <button class="sidebar-toggle d-md-none" onclick="toggleSidebar()" aria-expanded="false" aria-controls="sidebar">
            ☰ Menu Akademik
        </button>

        <div class="akademik-content-grid">

            {{-- SIDEBAR --}}
            <aside class="sidebar fixed-sidebar" id="sidebar">
                <h3 class="sidebar-title">Menu Akademik</h3>
                <ul class="sidebar-menu">
                    <li>
                        <a href="#kurikulum" class="sidebar-menu-item">
                            Kurikulum Pendidikan
                        </a>
                    </li>
                    <li>
                        <a href="#jadwal" class="sidebar-menu-item">
                            Jadwal Harian Santri
                        </a>
                    </li>
                    <li>
                        <a href="#evaluasi" class="sidebar-menu-item">
                            Sistem Evaluasi
                        </a>
                    </li>
                    <li>
                        <a href="#prestasi" class="sidebar-menu-item">
                            Prestasi Santri
                        </a>
                    </li>
                </ul>

                {{-- PENGUMUMAN DINAMIS --}}
                @if ($agendas->isNotEmpty())
                    <div class="sidebar-announcement">
                        <h3 class="sidebar-title">Pengumuman</h3>
                        <div class="announcement-list">
                            @foreach ($agendas as $agenda)
                                <div class="announcement-item {{ $agenda->tipe }}">
                                    <p class="announcement-text">
                                        <strong>{{ $agenda->judul }}</strong>
                                    </p>
                                    <p>{{ $agenda->isi }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

            {{-- MAIN CONTENT --}}
            <div class="akademik-content-main">

                {{-- KURIKULUM --}}
                <section id="kurikulum" class="akademik-content-section">
                    <div class="section-header">
                        <div class="section-bullet"></div>
                        <h2>Kurikulum Pendidikan</h2>
                    </div>

                    @if ($kurikulum_kiri->isEmpty() && $kurikulum_kanan->isEmpty())
                        <p class="text-muted">Belum ada data kurikulum.</p>
                    @else
                        <div class="two-column-grid">

                            {{-- Kolom Kiri --}}
                            <div>
                                @foreach ($kurikulum_kiri as $item)
                                    <h3 class="subsection-title tahfidz" style="{{ $loop->first ? '' : 'margin-top: 1.5rem;' }}">
                                        {{ $item->judul }}
                                    </h3>
                                    <ul class="subsection-content">
                                        @foreach ($item->poin_poin as $poin)
                                            <li>{{ $poin }}</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>

                            {{-- Kolom Kanan --}}
                            <div>
                                @foreach ($kurikulum_kanan as $item)
                                    <h3 class="subsection-title akademik" style="{{ $loop->first ? '' : 'margin-top: 1.5rem;' }}">
                                        {{ $item->judul }}
                                    </h3>
                                    <ul class="subsection-content">
                                        @foreach ($item->poin_poin as $poin)
                                            <li>{{ $poin }}</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>

                        </div>
                    @endif
                </section>

                {{-- JADWAL HARIAN --}}
                <section id="jadwal" class="akademik-content-section">
                    <div class="section-header">
                        <div class="section-bullet"></div>
                        <h2>Daily Activity</h2>
                    </div>

                    @if ($jadwals->isEmpty())
                        <p class="text-muted">Belum ada data jadwal harian.</p>
                    @else
                        <div class="table-wrapper">
                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Kegiatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                            <td>{{ $jadwal->kegiatan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>

                {{-- EVALUASI --}}
                <section id="evaluasi" class="akademik-content-section">
                    <div class="section-header">
                        <div class="section-bullet"></div>
                        <h2>Sistem Evaluasi</h2>
                    </div>

                    @if ($evaluasi_kiri->isEmpty() && $evaluasi_kanan->isEmpty())
                        <p class="text-muted">Belum ada data evaluasi.</p>
                    @else
                        <div class="two-column-grid">

                            {{-- Kolom Kiri --}}
                            <div>
                                @forelse ($evaluasi_kiri as $item)
                                    <div class="evaluation-item tahfidz" style="{{ $loop->first ? '' : 'margin-top: 1.5rem;' }}">
                                        <h3 class="subsection-title tahfidz">{{ $item->judul }}</h3>
                                        <p class="evaluation-desc">{{ $item->deskripsi }}</p>
                                    </div>
                                @empty
                                    <p class="text-muted">Belum ada data.</p>
                                @endforelse
                            </div>

                            {{-- Kolom Kanan --}}
                            <div>
                                @forelse ($evaluasi_kanan as $item)
                                    <div class="evaluation-item akademik" style="{{ $loop->first ? '' : 'margin-top: 1.5rem;' }}">
                                        <h3 class="subsection-title akademik">{{ $item->judul }}</h3>
                                        <p class="evaluation-desc">{{ $item->deskripsi }}</p>
                                    </div>
                                @empty
                                    <p class="text-muted">Belum ada data.</p>
                                @endforelse
                            </div>

                        </div>
                    @endif
                </section>

                {{-- PRESTASI --}}
                <section id="prestasi" class="akademik-content-section">
                    <div class="section-header">
                        <div class="section-bullet"></div>
                        <h2>Prestasi Santri</h2>
                    </div>

                    @if ($prestasis->isEmpty())
                        <p class="text-muted">Belum ada data prestasi.</p>
                    @else
                        <div class="achievement-list">
                            @foreach ($prestasis as $item)
                                <div class="achievement-item">
                                    <div class="achievement-badge">{{ $loop->iteration }}</div>
                                    <div>
                                        <h3 class="achievement-title">{{ $item->judul }}</h3>
                                        <p class="achievement-desc">{{ $item->deskripsi }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

            </div>
        </div>

        {{-- OVERLAY --}}
        <div id="sidebar-overlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

    </main>

@endsection

@push('scripts')
    <script src="{{ asset('js/akademik.js') }}"></script>
@endpush