<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Donasi — Daarul Qur\'an Al-Jannah')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/donasi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show-donasi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/status.css') }}">
    <link rel="stylesheet" href="{{ asset('css/upload-bukti.css') }}">
    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide.min.css">

    @stack('styles')
</head>
<body class="donasi-body">

    <div class="donasi-frame">
        <div class="donasi-header">
            <img src="{{ asset('images/logo-daqu.png') }}" alt="Daarul Qur'an Al-Jannah" class="donasi-header__logo">
            <div class="donasi-header__typebox">
                <span class="donasi-header__typebox-prefix">Wujudkan kepedulian anda melalui :</span>
                <span class="donasi-header__typebox-word" id="donasiTypeWord"></span><span class="donasi-header__typebox-cursor" aria-hidden="true">|</span>
            </div>
        </div>

        @yield('content')

        @include('frontend.donasi.partials._footer')

        @include('frontend.donasi.partials._bottomnav', [
            'activeNav' => $activeNav ?? null,
        ])

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js"></script>
    <script src="{{ asset('js/donasi.js') }}" defer></script>
    <script src="{{ asset('js/show-donasi.js') }}" defer></script>
    <script src="{{ asset('js/upload-bukti.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
