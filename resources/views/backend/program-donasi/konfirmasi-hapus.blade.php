@extends('backend.layouts')

@section('title', 'Konfirmasi Hapus Program')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 text-danger">
            <i class="fas fa-triangle-exclamation"></i> Konfirmasi Hapus Program
        </h5>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-warning">
            Anda akan menghapus program <strong>{{ $program->nama_program }}</strong>.
            Program akan dipindahkan ke tab Arsip dan tidak akan tampil di halaman publik,
            namun data donasi tetap tersimpan dan dapat dipulihkan kembali.
        </div>

        <table class="table table-borderless w-auto mb-4">
            <tr>
                <td class="text-muted">Total Donasi Masuk</td>
                <td><strong>{{ $totalDonasi }}</strong> transaksi</td>
            </tr>
            <tr>
                <td class="text-muted">Total Dana Terverifikasi</td>
                <td><strong>Rp{{ number_format($totalVerified, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        {{-- Lapis 1: wajib unduh rekap dulu --}}
        <div class="mb-4">
            <h6>Langkah 1 — Unduh Rekap Donasi</h6>
            <p class="text-muted small">
                Rekap berisi ringkasan program dan detail seluruh transaksi donasi (termasuk data donatur).
                Simpan file ini sebelum melanjutkan penghapusan.
            </p>
            <a
                href="{{ route('admin.program-donasi.export-rekap', $program) }}"
                id="btnUnduhRekap"
                class="btn btn-outline-primary"
            >
                <i class="fas fa-file-excel"></i> Unduh Rekap Excel
            </a>
            <span id="statusUnduh" class="ms-2 small {{ $sudahUnduhRekap ? 'text-success' : 'text-muted' }}">
                @if ($sudahUnduhRekap)
                    <i class="fas fa-check-circle"></i> Rekap sudah diunduh pada sesi ini.
                @else
                    Rekap belum diunduh.
                @endif
            </span>
        </div>

        <hr>

        {{-- Lapis 2 & 3: checklist + retype nama, lalu submit destroy --}}
        <form action="{{ route('admin.program-donasi.destroy', $program) }}" method="POST">
            @csrf
            @method('DELETE')

            <h6>Langkah 2 — Konfirmasi Penghapusan</h6>

            <div class="form-check mb-3">
                <input
                    type="checkbox"
                    name="sudah_direkap"
                    id="sudah_direkap"
                    class="form-check-input @error('sudah_direkap') is-invalid @enderror"
                    value="1"
                    {{ old('sudah_direkap') ? 'checked' : '' }}
                >
                <label for="sudah_direkap" class="form-check-label">
                    Saya menyatakan data donasi program ini sudah direkap dan diunduh.
                </label>
                @error('sudah_direkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="konfirmasi_nama" class="form-label">
                    Ketik ulang nama program untuk konfirmasi: <strong>{{ $program->nama_program }}</strong>
                </label>
                <input
                    type="text"
                    name="konfirmasi_nama"
                    id="konfirmasi_nama"
                    class="form-control @error('konfirmasi_nama') is-invalid @enderror"
                    placeholder="Ketik nama program persis seperti di atas"
                >
                @error('konfirmasi_nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus Program
            </button>
            <a href="{{ route('admin.program-donasi.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Klik unduh rekap tidak memuat ulang halaman (browser langsung men-download file),
    // jadi kita refresh manual setelah jeda singkat supaya status "sudah diunduh"
    // (yang disimpan di session oleh server) ikut ter-update di halaman ini.
    document.getElementById('btnUnduhRekap').addEventListener('click', function () {
        setTimeout(function () {
            window.location.reload();
        }, 3000);
    });
</script>
@endpush
