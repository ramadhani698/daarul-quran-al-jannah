@extends('frontend.layouts.donasi')

@section('title', 'Riwayat Donatur')

@section('content')
<div class="riwayat-wrap">
    <h2 class="riwayat-title">Riwayat Donatur</h2>
    <p class="riwayat-sub">Jazakumullahu khairan untuk para donatur yang sudah berbagi kebaikan.</p>

    @forelse ($donasis as $donasi)
        @php
            $nama = (! $donasi->is_anonim && filled($donasi->nama_donatur))
                ? $donasi->nama_donatur
                : 'Hamba Allah';
        @endphp
        <div class="riwayat-item">
            <div class="riwayat-avatar">{{ strtoupper(mb_substr($nama, 0, 1)) }}</div>
            <div class="riwayat-body">
                <div class="riwayat-top">
                    <strong>{{ $nama }}</strong>
                    <span class="riwayat-nominal">{{ $donasi->nominal_tersamar }}</span>
                </div>
                <div class="riwayat-program">{{ $donasi->program?->nama_program ?? '-' }}</div>
                @if ($donasi->pesan_doa)
                    <div class="riwayat-doa">"{{ $donasi->pesan_doa }}"</div>
                @endif
                <div class="riwayat-waktu">{{ $donasi->created_at->diffForHumans() }}</div>
            </div>
        </div>
    @empty
        <div class="riwayat-kosong">Belum ada donasi yang terverifikasi.</div>
    @endforelse

    @if ($donasis->hasPages())
        <div class="riwayat-nav">
            @unless ($donasis->onFirstPage())
                <a href="{{ $donasis->previousPageUrl() }}">← Sebelumnya</a>
            @endunless
            @if ($donasis->hasMorePages())
                <a href="{{ $donasis->nextPageUrl() }}">Berikutnya →</a>
            @endif
        </div>
    @endif
</div>
@endsection