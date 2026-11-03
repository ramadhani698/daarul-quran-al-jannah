@extends('frontend.layouts.app')

@section('title', 'Organisasi Santri')

@push('styles')
    <link href="{{ asset('css/organisasi.css') }}" rel="stylesheet">
@endpush


@section('content')

    <header class="header" style="margin-top: 80px;">
        <div class="container">
            <h1>Struktur Organisasi Santri</h1>
            <p>Pesantren Daarul Qur'an Al-Jannah</p>
        </div>
    </header>

    <main class="main-content">
        <div class="container">

            <!-- Organizational Structure -->
            <section class="org-structure">

                <h2>Struktur Organisasi OSTDAQU</h2>

                <div class="structure-chart">

                    <!-- Ketua OSTDAQU -->
                    @if($ketuaOstdaqu)
                    <div class="structure-level top-level">

                        <div
                            class="position-card"
                            id="ketua-ostdaqu-btn"
                            style="cursor: pointer;"
                        >
                            <div class="position-icon">{{ $ketuaOstdaqu->icon }}</div>
                            <h3>{{ $ketuaOstdaqu->jabatan }}</h3>
                            <p>{{ $ketuaOstdaqu->nama }}</p>
                        </div>

                    </div>
                    @endif

                    <!-- Anggota OSTDAQU -->
                    <div
                        class="structure-level anggota-ostdaqu animated-section"
                        id="ostdaqu-section"
                        style="display: none;"
                    >
                        @foreach($anggotaOstdaqu as $anggota)
                        <div class="position-card">
                            <div class="position-icon">{{ $anggota->icon }}</div>
                            <h3>{{ $anggota->jabatan }}</h3>
                            <p>{{ $anggota->nama }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="connector"></div>

                    <!-- Mudabbir -->
                    <div class="structure-level">
                        @forelse($mudabbir as $kamar => $items)
                        <div class="position-card">
                            <div class="position-icon">👨‍💼</div>
                            <h3>Mudabbir {{ $kamar }}</h3>
                            @foreach($items as $item)
                                <p>{{ $item->nama }}</p>
                            @endforeach
                        </div>
                        @empty
                            {{-- Tidak ada data mudabbir --}}
                        @endforelse
                    </div>

                    <div class="connector branched"></div>

                    <!-- Ketua Kelas & Asrama -->
                    <div class="structure-level bottom-level">

                        <div
                            class="position-card"
                            id="ketua-kelas-btn"
                            style="cursor: pointer;"
                        >
                            <div class="position-icon">📚</div>
                            <h3>Ketua Kelas</h3>
                            <p>Per Jenjang</p>
                        </div>

                        <div
                            class="position-card"
                            id="ketua-asrama-btn"
                            style="cursor: pointer;"
                        >
                            <div class="position-icon">🏢</div>
                            <h3>Ketua Asrama</h3>
                            <p>Per Asrama</p>
                        </div>

                    </div>

                    <!-- Ketua Kelas -->
                    <div
                        id="kelas-section"
                        class="class-section animated-section"
                        style="display:none; gap:16px; margin-top:16px;"
                    >
                        @foreach($ketuaKelas as $kelas)
                        <div class="position-card">
                            <div class="position-icon">{{ $kelas->icon }}</div>
                            <h3>Ketua Kelas {{ $kelas->nama_kelas }}</h3>
                            <p>{{ $kelas->nama_ketua }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Ketua Asrama -->
                    <div
                        id="asrama-section"
                        class="asrama-section animated-section"
                        style="display:none; gap:16px; margin-top:16px;"
                    >
                        @foreach($ketuaAsrama as $asrama)
                        <div class="position-card">
                            <div class="position-icon">{{ $asrama->icon }}</div>
                            <h3>Ketua Asrama <br>{{ $asrama->nama_asrama }}</h3>
                            <p>{{ $asrama->nama_ketua }}</p>
                        </div>
                        @endforeach
                    </div>

                </div>

            </section>

        </div>
    </main>

    <!-- Script Toggle -->
    <script>
      document.getElementById("ketua-ostdaqu-btn").onclick = function () {
        toggleAnimatedSection("ostdaqu-section");
      };
      document.getElementById("ketua-kelas-btn").onclick = function () {
        toggleAnimatedSection("kelas-section");
        document.getElementById("asrama-section").classList.remove("show");
        setTimeout(() => {
          document.getElementById("asrama-section").style.display = "none";
        }, 400);
      };
      document.getElementById("ketua-asrama-btn").onclick = function () {
        toggleAnimatedSection("asrama-section");
        document.getElementById("kelas-section").classList.remove("show");
        setTimeout(() => {
          document.getElementById("kelas-section").style.display = "none";
        }, 400);
      };
    </script>

@endsection