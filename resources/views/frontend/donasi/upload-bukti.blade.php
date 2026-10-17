@extends('frontend.layouts.donasi')

@php
    $backUrl = route('donasi.show', $donasi->program->slug);
    $backLabel = $donasi->program->nama_program;
    $showCekStatus = true;
    $activeNav = null;
@endphp

@section('title', 'Upload Bukti Transfer — ' . $donasi->kode_donasi)

@section('content')
<section class="donasi-upload">
    @if (session('success'))
        <div class="donasi-upload__alert donasi-upload__alert--success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="donasi-upload__alert donasi-upload__alert--error">{{ $errors->first() }}</div>
    @endif

    <div class="donasi-upload__card">
        <div class="donasi-upload__kode-row">
            <span class="donasi-upload__kode" id="donasiKodeDonasi">{{ $donasi->kode_donasi }}</span>
            <button type="button" class="donasi-upload__kode-copy" id="donasiCopyKode">Salin</button>
        </div>
        <p class="donasi-upload__kode-hint">Simpan kode ini untuk cek status donasi Anda nanti.</p>

        <span class="donasi-upload__badge">Menunggu Pembayaran</span>

        <table class="donasi-upload__table">
            <tr>
                <td>Program</td>
                <td>{{ $donasi->program->nama_program }}</td>
            </tr>
            <tr>
                <td>Nominal</td>
                <td>Rp{{ number_format($donasi->nominal, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{--
        CATATAN: rekening/QRIS di bawah masih statis, sama kayak yang ada di
        modal form show.blade.php. Kalau nanti diganti data asli, samain juga
        di sini biar konsisten.
    --}}
    <div class="donasi-upload__box">
        <h3>Selesaikan Pembayaran Anda</h3>
        <p class="donasi-upload__hint-text">
            Transfer ke rekening BSI 1234567890 a.n. Yayasan Daarul Qur'an Al-Jannah,
            atau scan QRIS yang tersedia di halaman program. Setelah transfer, unggah
            bukti transfer di bawah ini.
        </p>

        <div class="donasi-pay">
            <p class="donasi-pay__label">
                Silakan transfer <strong>Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</strong>
                via {{ $donasi->metode_pembayaran === 'qris' ? 'QRIS' : 'Transfer Bank' }},
                lalu upload buktinya di bawah.
            </p>

            @if ($donasi->metode_pembayaran === 'qris')
                @include('frontend.donasi.partials.rekening-qris')
            @else
                @include('frontend.donasi.partials.rekening-bank')
            @endif
        </div>
        <form
            action="{{ route('donasi.resubmit', $donasi->kode_donasi) }}"
            method="POST"
            enctype="multipart/form-data"
            class="donasi-upload__form"
        >
            @csrf
            <label for="bukti_transfer">Bukti Transfer</label>
            <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/jpeg,image/png,application/pdf" required>
            <span class="donasi-upload__hint">JPG, PNG, atau PDF, maksimal 2MB.</span>
            <button type="submit">Kirim Bukti Transfer</button>
        </form>
    </div>

    @php
        $pesanWa = "Assalamualaikum, saya sudah donasi dengan kode {$donasi->kode_donasi} untuk program {$donasi->program->nama_program}. Mohon dicek ya, terima kasih.";
        $waNumber = config('services.whatsapp.admin_number');
    @endphp
    <a
        href="https://wa.me/{{ $waNumber }}?text={{ urlencode($pesanWa) }}"
        target="_blank"
        rel="noopener"
        class="donasi-upload__wa-btn"
    >
        <i class="fa-brands fa-whatsapp"></i> Konfirmasi via WhatsApp
    </a>
</section>
@endsection