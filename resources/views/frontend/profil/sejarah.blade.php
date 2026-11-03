@extends('frontend.layouts.app')

@section('title', 'Sejarah Pesantren')

@push('styles')
    <link href="{{ asset('css/sejarah.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
        // key data => sisi gambar. Mau nambah bagian baru (misal 'tokoh'), cukup tambah satu baris.
        $bagian = [
            'pesantren' => 'left',
            'yayasan'   => 'right',
        ];
    @endphp

    <div class="sejarah-page">

        @foreach ($bagian as $key => $posisiGambar)
            @isset($sejarahs[$key])

                @php
                    $sejarah    = $sejarahs[$key];
                    $carouselId = 'carousel' . ucfirst($key);
                @endphp

                <section class="py-5 sejarah-section">
                    <div class="container-fluid px-3 px-md-4 px-xl-5">
                        <div class="sejarah-content sejarah-wrap" data-aos="fade-up">

                            <h2 class="mb-3">{{ $sejarah->judul }}</h2>

                            {{-- Gambar mengambang ke kiri/kanan, teks mengalir di sisi lain & bawahnya --}}
                            @if ($sejarah->images->isNotEmpty())
                                <div class="sejarah-image float-{{ $posisiGambar }}-img">
                                    <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">

                                        <div class="carousel-inner">
                                            @foreach ($sejarah->images as $image)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ $image->url }}"
                                                         class="d-block w-100 rounded"
                                                         alt="{{ $sejarah->judul }} {{ $loop->iteration }}">
                                                </div>
                                            @endforeach
                                        </div>

                                        @if ($sejarah->images->count() > 1)
                                            <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                    data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        @endif

                                    </div>
                                </div>
                            @endif

                            <p>{!! nl2br(e($sejarah->konten)) !!}</p>

                        </div>
                    </div>
                </section>

            @endisset
        @endforeach

    </div>

@endsection