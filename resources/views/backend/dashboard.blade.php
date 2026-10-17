@extends('backend.layouts')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    {{-- ================= PENDAFTARAN ================= --}}
    <h5 class="mb-3"><i class="fas fa-user-plus mr-1"></i> Pendaftaran Santri</h5>

    @if($pendaftarError)
        <div class="alert alert-warning">
            Data pendaftaran belum bisa diambil dari Google Sheets. Coba
            <a href="{{ route('admin.pendaftaran.refresh') }}">refresh data</a>
            atau cek koneksi/credentials Google API.
        </div>
    @else
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $pendaftarStats['total'] }}</h3>
                        <p>Total Pendaftar</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="small-box-footer stretched-link">
                        Lihat data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $pendaftarStats['hari_ini'] }}</h3>
                        <p>Pendaftar Hari Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-clock"></i></div>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="small-box-footer stretched-link">
                        Lihat data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pendaftarStats['bulan_ini'] }}</h3>
                        <p>Pendaftar Bulan Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="small-box-footer stretched-link">
                        Lihat data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 style="font-size:1.6rem; line-height:2.3rem;">{{ $pendaftarStats['provinsi_top'] }}</h3>
                        <p>Provinsi Terbanyak ({{ $pendaftarStats['provinsi_total'] }} pendaftar)</p>
                    </div>
                    <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="small-box-footer stretched-link">
                        Lihat data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- ================= KONTEN WEBSITE ================= --}}
    <h5 class="mb-3 mt-2"><i class="fas fa-globe mr-1"></i> Konten Website</h5>

    @php
        $konten = [
            [
                'label'  => 'Berita',
                'icon'   => 'fa-newspaper',
                // kuning kalau masih ada draf yang belum dipublish
                'color'  => $stats['berita']['draf'] > 0 ? 'bg-warning' : 'bg-info',
                'number' => $stats['berita']['total'],
                'note'   => $stats['berita']['terbit'] . ' terbit · ' . $stats['berita']['draf'] . ' draf',
                'url'    => route('admin.berita.index'),
            ],
            [
                'label'  => 'Info Akademik',
                'icon'   => 'fa-graduation-cap',
                'color'  => 'bg-success',
                'number' => $stats['akademik'],
                'note'   => 'Kurikulum, jadwal, evaluasi, dll',
                'url'    => route('admin.info-akademik.index'),
            ],
            [
                'label'  => 'Prestasi Santri',
                'icon'   => 'fa-medal',
                'color'  => 'bg-teal',
                'number' => $stats['santri'],
                'note'   => 'Info Santri',
                'url'    => route('admin.info-santri.index'),
            ],
            [
                'label'  => 'Alumni',
                'icon'   => 'fa-user-graduate',
                'color'  => 'bg-primary',
                'number' => $stats['alumni']['total'],
                'note'   => $stats['alumni']['sebaran'] . ' sebaran · ' . $stats['alumni']['kiprah'] . ' kiprah',
                'url'    => route('admin.alumni.index'),
            ],
            [
                'label'  => 'Galeri',
                'icon'   => 'fa-image',
                'color'  => 'bg-maroon',
                'number' => $stats['galeri'],
                'note'   => 'Foto & album',
                'url'    => route('admin.galeri.index'),
            ],
            [
                'label'  => 'Produk',
                'icon'   => 'fa-shopping-cart',
                'color'  => 'bg-orange',
                'number' => $stats['produk'],
                'note'   => 'Produk pesantren',
                'url'    => route('admin.produk.index'),
            ],

            // Tambah menu baru (Galeri, Produk, Ekskul) cukup nambah 1 blok di sini
        ];
    @endphp

    <div class="row">
        @foreach($konten as $k)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon {{ $k['color'] }}"><i class="fas {{ $k['icon'] }}"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ $k['label'] }}</span>
                        <span class="info-box-number">{{ $k['number'] }}</span>
                        <small class="text-muted">{{ $k['note'] }}</small>
                    </div>
                    <a href="{{ $k['url'] }}" class="stretched-link" title="Kelola {{ $k['label'] }}"></a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ================= DONASI ================= --}}
    <h5 class="mb-3 mt-2"><i class="fas fa-donate mr-1"></i> Donasi</h5>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
            <div class="info-box">
                <span class="info-box-icon {{ $donasiStats['pending'] > 0 ? 'bg-danger' : 'bg-success' }}">
                    <i class="fas fa-hourglass-half"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Menunggu Verifikasi</span>
                    <span class="info-box-number">{{ $donasiStats['pending'] }}</span>
                    <small class="text-muted">
                        {{ $donasiStats['pending_program'] }} program · {{ $donasiStats['pending_umum'] }} umum
                    </small>
                </div>
                {{-- klik ke tab yang lagi ada antrian --}}
                <a href="{{ ($donasiStats['pending_program'] > 0 || $donasiStats['pending_umum'] == 0)
                            ? route('admin.donasi.program')
                            : route('admin.donasi.non-program') }}"
                   class="stretched-link"></a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Terkumpul</span>
                    <span class="info-box-number">Rp {{ number_format($donasiStats['terkumpul'], 0, ',', '.') }}</span>
                    <small class="text-muted">Terverifikasi saja</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-hands-helping"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Program Aktif</span>
                    <span class="info-box-number">{{ $donasiStats['program_aktif'] }}</span>
                </div>
                <a href="{{ route('admin.program-donasi.index') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Donasi Terverifikasi (6 Bulan Terakhir)</h3>
                </div>
                <div class="card-body"><canvas id="chartBulan" height="110"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Per Kategori</h3></div>
                <div class="card-body"><canvas id="chartKategori" height="220"></canvas></div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const rupiah = v => 'Rp ' + Number(v).toLocaleString('id-ID');

    new Chart(document.getElementById('chartBulan'), {
        type: 'bar',
        data: {
            labels: @json($chartBulan['labels']),
            datasets: [{
                label: 'Donasi',
                data: @json($chartBulan['data']),
                backgroundColor: '#4e733a',
                borderRadius: 4
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: c => rupiah(c.parsed.y) } }
            },
            scales: { y: { beginAtZero: true, ticks: { callback: rupiah } } }
        }
    });

    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: @json($chartKategori['labels']),
            datasets: [{
                data: @json($chartKategori['data']),
                backgroundColor: ['#a70e13', '#f4c430', '#4e733a', '#17a2b8', '#6c757d']
            }]
        },
        options: {
            plugins: { tooltip: { callbacks: { label: c => c.label + ': ' + rupiah(c.parsed) } } }
        }
    });
</script>
@endpush