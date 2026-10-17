@extends('frontend.layouts.donasi')

@section('title', $program->nama_program . ' — Amal Jariyah')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/show-donasi.css') }}">
@endpush

@section('content')
<section class="donasi-show">
    <div class="donasi-show__image">
        @if ($program->gambar)
            <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
        @endif
    </div>

    <div class="donasi-show__body">
        <span class="donasi-show__kategori">{{ $program->kategori->nama }}</span>
        <h1 class="donasi-show__title">{{ $program->nama_program }}</h1>
        <p class="donasi-show__desc">{{ $program->deskripsi }}</p>

        @if ($program->target_donasi)
            <div class="donasi-progress">
                <div class="donasi-progress__bar">
                    <div class="donasi-progress__fill" style="width: {{ $program->persentase }}%"></div>
                </div>
                <div class="donasi-progress__meta">
                    <span>Terkumpul Rp{{ number_format($program->terkumpul, 0, ',', '.') }}</span>
                    <span>Target Rp{{ number_format($program->target_donasi, 0, ',', '.') }}</span>
                </div>
            </div>
        @else
            <p class="donasi-show__nolimit">
                Terkumpul: <strong>Rp{{ number_format($program->terkumpul, 0, ',', '.') }}</strong>
                <span>(tanpa batas target)</span>
            </p>
        @endif
        <p class="donasi-show__donatur-count">{{ $program->jumlah_donatur }} orang telah berdonasi</p>

        <div class="donasi-show__share">
            <p class="donasi-show__share-label">Ajak orang lain ikut berdonasi</p>
            <a
                href="https://wa.me/?text={{ urlencode('Yuk ikut donasi untuk program "' . $program->nama_program . '" di Pesantren Tahfidz Daarul Qur\'an Al-Jannah: ' . route('donasi.show', $program->slug)) }}"
                target="_blank"
                rel="noopener"
                class="donasi-show__share-btn"
            >
                <i class="fa-brands fa-whatsapp"></i> Bagikan Program Ini
            </a>
        </div>
    </div>

    <div class="donasi-show__cta-wrap">
        <button type="button" id="donasiOpenFormBtn" class="donasi-show__cta-btn">
            {{ $program->kategori->nama }} Sekarang
        </button>
    </div>
</section>

@php
    $metodeOld = old('metode_pembayaran');
    $metode = in_array($metodeOld, ['bank', 'qris'], true) ? $metodeOld : 'bank';
@endphp
<div class="donasi-form-modal {{ $errors->any() ? 'is-open' : '' }}" id="donasiFormModal">
    <div class="donasi-form-modal__backdrop" id="donasiFormBackdrop"></div>
    <div class="donasi-form-modal__panel">
        <button type="button" class="donasi-form-modal__close" id="donasiFormCloseBtn" aria-label="Tutup">&times;</button>

        <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data" class="donasi-form">
            @csrf
            <input type="hidden" name="program_donasi_id" value="{{ $program->id }}">
            <input type="hidden" name="metode_pembayaran" id="metodePembayaran" value="{{ $metode }}">

            {{-- Honeypot — field ini harus tetap kosong, disembunyikan lewat CSS bukan hidden,
                 supaya bot pengisi form otomatis (yang skip field type=hidden) tetap kena jebak. --}}
            <div class="donasi-form__honeypot" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
            </div>

            <h3 class="donasi-form__title">Isi Data Donasi</h3>

            <div class="donasi-form__group">
                <label for="nama_donatur">Nama Donatur</label>
                <input type="text" name="nama_donatur" id="nama_donatur" value="{{ old('nama_donatur') }}" required>
                @error('nama_donatur') <span class="donasi-form__error">{{ $message }}</span> @enderror
            </div>

            <div class="donasi-form__group donasi-form__group--checkbox">
                <input type="checkbox" name="is_anonim" id="is_anonim" value="1" {{ old('is_anonim') ? 'checked' : '' }}>
                <label for="is_anonim">Sembunyikan nama saya (tampil sebagai "Hamba Allah")</label>
            </div>

            <div class="donasi-form__group">
                <label for="no_hp">No. HP (opsional)</label>
                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}">
                @error('no_hp') <span class="donasi-form__error">{{ $message }}</span> @enderror
            </div>

            <div class="donasi-form__group">
                <label for="nominal">Nominal Donasi (Rp)</label>
                <input type="text" inputmode="numeric" name="nominal" id="nominal" value="{{ old('nominal') }}" placeholder="Contoh: 100.000" required>
                @error('nominal') <span class="donasi-form__error">{{ $message }}</span> @enderror
            </div>

            {{--
                CATATAN: nomor rekening, nama bank, atas nama, dan gambar QRIS di bawah masih
                statis/placeholder. Ganti sesuai data asli, dan taruh file QRIS di
                public/images/donasi/qris.png (atau sesuaikan path-nya).

                Upload bukti transfer SENGAJA gak ada di sini — donatur transfer & upload
                bukti belakangan di halaman status (kode donasi didapat setelah submit ini).
            --}}
            <div class="donasi-form__rekening">
                <p class="donasi-form__rekening-label">Pilih metode pembayaran:</p>

                <div class="donasi-form__rekening-tabs">
                    <button type="button"
                            class="donasi-form__rekening-tab {{ $metode === 'bank' ? 'is-active' : '' }}"
                            data-target="donasiTabBank" data-metode="bank">Transfer Bank</button>
                    <button type="button"
                            class="donasi-form__rekening-tab {{ $metode === 'qris' ? 'is-active' : '' }}"
                            data-target="donasiTabQris" data-metode="qris">QRIS</button>
                </div>

                <div class="donasi-form__rekening-panel" id="donasiTabBank" {{ $metode === 'bank' ? '' : 'hidden' }}>
                    @include('frontend.donasi.partials.rekening-bank')
                </div>

                <div class="donasi-form__rekening-panel" id="donasiTabQris" {{ $metode === 'qris' ? '' : 'hidden' }}>
                    @include('frontend.donasi.partials.rekening-qris')
                </div>

                <p class="donasi-form__rekening-note">
                    Kode donasi &amp; instruksi lengkap akan muncul setelah Anda lanjut ke langkah berikutnya.
                </p>
            </div>

            <div class="donasi-form__group">
                <label for="pesan_doa">Pesan / Doa (opsional)</label>
                <textarea name="pesan_doa" id="pesan_doa" rows="3" maxlength="500">{{ old('pesan_doa') }}</textarea>
                @error('pesan_doa') <span class="donasi-form__error">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="donasi-form__submit">Lanjutkan ke Pembayaran</button>
        </form>
    </div>
</div>
@endsection