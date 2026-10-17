@extends('frontend.layouts.donasi')

@section('title', 'Cek Status Donasi')

@section('content')
<section class="donasi-cek" style="margin-top: 70px;">
    <div class="donasi-cek__card">
        <h1 class="donasi-cek__title">Cek Status Donasi</h1>
        <p class="donasi-cek__subtitle">Masukkan kode donasi yang Anda terima setelah berdonasi.</p>

        @if ($errors->any())
            <div class="donasi-alert donasi-alert--error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('donasi.cek-status') }}" method="POST" class="donasi-cek__form">
            @csrf
            <input
                type="text"
                name="kode_donasi"
                value="{{ old('kode_donasi') }}"
                placeholder="Contoh: DNS-20260827-HMFPO"
                autofocus
            >
            <button type="submit">Cek Status</button>
        </form>
    </div>
</section>
@endsection

@push('styles')
<style>
    .donasi-cek {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fdf9f0;
        padding: 48px 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .donasi-cek__card {
        background: #fff;
        border-radius: 18px;
        padding: 36px;
        max-width: 440px;
        width: 100%;
        box-shadow: 0 12px 30px rgba(43, 28, 16, 0.08);
        text-align: center;
    }
    .donasi-cek__title { font-family: 'Lora', serif; color: #a70e13; font-size: 1.4rem; margin-bottom: 8px; }
    .donasi-cek__subtitle { color: #5c4a3a; font-size: 0.9rem; margin-bottom: 24px; }
    .donasi-cek__form input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e4d9c7;
        border-radius: 10px;
        font-size: 0.95rem;
        margin-bottom: 12px;
        text-align: center;
    }
    .donasi-cek__form button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 999px;
        background: #a70e13;
        color: #fdf9f0;
        font-weight: 600;
        cursor: pointer;
    }
    .donasi-cek__form button:hover { background: #6e0a0d; }
    .donasi-alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 0.85rem; text-align: left; }
    .donasi-alert--error { background: #fbe9e9; color: #a70e13; border: 1px solid #f1c6c6; }
</style>
@endpush
