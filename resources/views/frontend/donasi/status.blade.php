@extends('frontend.layouts.donasi')

@section('title', 'Status Donasi — ' . $donasi->kode_donasi)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/status-donasi.css') }}">
@endpush

@section('content')
<section class="donasi-status">
    @if (session('success'))
        <div class="donasi-status__alert donasi-status__alert--success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="donasi-status__alert donasi-status__alert--error">{{ $errors->first() }}</div>
    @endif

    <div class="donasi-status__card">
        <span class="donasi-status__kode">{{ $donasi->kode_donasi }}</span>

        @php
            $badgeInfo = match ($donasi->status) {
                'verified' => ['label' => 'Terverifikasi', 'class' => 'donasi-status__badge--verified'],
                'rejected' => ['label' => 'Ditolak', 'class' => 'donasi-status__badge--rejected'],
                default => ['label' => 'Menunggu Verifikasi', 'class' => 'donasi-status__badge--pending'],
            };
        @endphp
        <span class="donasi-status__badge {{ $badgeInfo['class'] }}">{{ $badgeInfo['label'] }}</span>

        <table class="donasi-status__table">
            <tr>
                <td>Program</td>
                <td>{{ $donasi->program->nama_program }}</td>
            </tr>
            <tr>
                <td>Nominal</td>
                <td>Rp{{ number_format($donasi->nominal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tanggal Donasi</td>
                <td>{{ $donasi->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    @if ($donasi->status !== 'verified')
        @php
            $pesanWa = "Assalamualaikum, saya sudah donasi dengan kode {$donasi->kode_donasi} untuk program {$donasi->program->nama_program}. Mohon dicek ya, terima kasih.";
            $waNumber = config('services.whatsapp.admin_number');
        @endphp
        <a
            href="https://wa.me/{{ $waNumber }}?text={{ urlencode($pesanWa) }}"
            target="_blank"
            rel="noopener"
            class="donasi-status__wa-btn"
        >
            <i class="fa-brands fa-whatsapp"></i> Konfirmasi via WhatsApp
        </a>
    @endif

    @if ($donasi->status === 'rejected')
        <div class="donasi-status__reject-box">
            <h3>Donasi Anda Ditolak</h3>
            @if ($donasi->catatan_admin)
                <p><strong>Alasan:</strong> {{ $donasi->catatan_admin }}</p>
            @endif
            <p class="donasi-status__reject-hint">
                Silakan unggah ulang bukti transfer yang sesuai. Anda tidak perlu mengisi form dari awal.
            </p>

            <form
                action="{{ route('donasi.resubmit', $donasi->kode_donasi) }}"
                method="POST"
                enctype="multipart/form-data"
                class="donasi-status__resubmit-form"
            >
                @csrf
                <label for="bukti_transfer">Bukti Transfer Baru</label>
                <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/jpeg,image/png,application/pdf" required>
                <span class="donasi-status__hint">JPG, PNG, atau PDF, maksimal 2MB.</span>
                <button type="submit">Kirim Ulang Bukti Transfer</button>
            </form>
        </div>
    @elseif ($donasi->status === 'pending')
        <p class="donasi-status__note">
            Bukti transfer Anda sedang ditinjau oleh tim kami. Silakan cek kembali beberapa saat lagi.
        </p>
    @else
        <p class="donasi-status__note donasi-status__note--success">
            Terima kasih atas donasi Anda. Semoga menjadi amal jariyah yang berkah. 🤲
        </p>
    @endif
</section>
@endsection