@extends('backend.layouts')

@section('title', $title)

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $title }}</h5>
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

        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" style="width: 160px;">Kode Donasi</td>
                        <td><code class="fs-6">{{ $donasi->kode_donasi }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama Donatur</td>
                        <td>{{ $donasi->nama_donatur }} {{ $donasi->is_anonim ? '(tampil anonim di publik)' : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. HP</td>
                        <td>{{ $donasi->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Program</td>
                        <td>{{ $donasi->program->nama_program }} <span class="text-muted">({{ $donasi->program->kategori->nama }})</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nominal</td>
                        <td><strong>Rp{{ number_format($donasi->nominal, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode Bayar</td>
                        <td>
                            <span class="badge {{ $donasi->metode_badge }}">
                                <i class="fas {{ $donasi->metode_icon }}"></i> {{ $donasi->metode_label }}
                            </span>
                            <div class="form-text">
                                {{ $donasi->metode_pembayaran === 'qris'
                                    ? 'Cek di mutasi QRIS / m-banking yang terhubung ke QRIS.'
                                    : 'Cek mutasi di rekening bank yayasan.' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Pesan/Doa</td>
                        <td>{{ $donasi->pesan_doa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Masuk</td>
                        <td>{{ $donasi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status Saat Ini</td>
                        <td>
                            @php
                                $badgeClass = match ($donasi->status) {
                                    'verified' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-warning text-dark',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($donasi->status) }}</span>
                            @if ($donasi->status === 'verified' && $donasi->wa_link)
                                <a href="{{ $donasi->wa_link }}" target="_blank" rel="noopener" class="btn btn-success btn-sm ms-2">
                                    <i class="fab fa-whatsapp"></i> Kirim WA ke Donatur
                                </a>
                            @endif
                        </td>
                    </tr>
                    @if ($donasi->catatan_admin)
                        <tr>
                            <td class="text-muted">Catatan Sebelumnya</td>
                            <td>{{ $donasi->catatan_admin }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div class="col-md-6">
                <label class="form-label">Bukti Transfer</label>
                <div>
                    @if ($donasi->bukti_transfer)
                        @php $ext = pathinfo($donasi->bukti_transfer, PATHINFO_EXTENSION); @endphp
                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                            <a href="{{ asset('storage/' . $donasi->bukti_transfer) }}" target="_blank">
                                <img src="{{ asset('storage/' . $donasi->bukti_transfer) }}"
                                    alt="Bukti transfer"
                                    class="img-fluid rounded border">
                            </a>
                        @else
                            <a href="{{ asset('storage/' . $donasi->bukti_transfer) }}" target="_blank" class="btn btn-outline-secondary">
                                <i class="fas fa-file-pdf"></i> Buka File PDF
                            </a>
                        @endif
                    @else
                        <div class="text-muted fst-italic">Donatur belum upload bukti transfer.</div>
                    @endif
                </div>
            </div>
        </div>

        <hr>

        <form action="{{ route('admin.donasi.update', $donasi) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label d-block">Keputusan Verifikasi</label>

                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="status_verified" value="verified"
                           class="form-check-input @error('status') is-invalid @enderror"
                           {{ old('status', $donasi->status) === 'verified' ? 'checked' : '' }}>
                    <label for="status_verified" class="form-check-label text-success">Verifikasi (Terima)</label>
                </div>

                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="status_rejected" value="rejected"
                           class="form-check-input @error('status') is-invalid @enderror"
                           {{ old('status', $donasi->status) === 'rejected' ? 'checked' : '' }}>
                    <label for="status_rejected" class="form-check-label text-danger">Tolak</label>
                </div>

                @error('status')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="catatan_admin" class="form-label">
                    Catatan Admin <span class="text-muted small">(wajib diisi jika ditolak)</span>
                </label>
                <textarea
                    name="catatan_admin"
                    id="catatan_admin"
                    rows="3"
                    class="form-control @error('catatan_admin') is-invalid @enderror"
                >{{ old('catatan_admin', $donasi->catatan_admin) }}</textarea>
                @error('catatan_admin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection