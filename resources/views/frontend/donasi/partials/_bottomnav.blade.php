{{--
    CATATAN: tab "Riwayat Donatur" masih nunjuk ke route donasi.riwayat yang BELUM ADA.
    Ini fitur yang sempet ketunda dari awal (Riwayat Donatur Publik) — perlu ditambahin
    route + controller method + view baru sebelum tab ini beneran berfungsi. Buat sementara
    linknya udah gue siapin, tinggal nanti disambungkan.
--}}
<nav class="donasi-bottomnav">
    <a href="{{ route('donasi.index') }}" class="donasi-bottomnav__item {{ ($activeNav ?? null) === 'beranda' ? 'is-active' : '' }}">
        <svg class="donasi-bottomnav__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 11.5 12 4l9 7.5" />
            <path d="M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9" />
        </svg>
        <span>Beranda</span>
    </a>

    <a href="{{ route('donasi.riwayat') }}" class="donasi-bottomnav__item {{ ($activeNav ?? null) === 'riwayat' ? 'is-active' : '' }}">
        <svg class="donasi-bottomnav__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12a9 9 0 1 0 3-6.7" />
            <path d="M3 4v5h5" />
            <path d="M12 8v4l3 2" />
        </svg>
        <span>Riwayat Donatur</span>
    </a>

    <a href="{{ route('donasi.cek-form') }}" class="donasi-bottomnav__item {{ ($activeNav ?? null) === 'cek-status' ? 'is-active' : '' }}">
        <svg class="donasi-bottomnav__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="10.5" cy="10.5" r="6.5" />
            <path d="m20 20-4.35-4.35" />
        </svg>
        <span>Cek Status</span>
    </a>
</nav>
