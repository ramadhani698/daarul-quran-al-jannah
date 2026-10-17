@php $program = $program ?? null; @endphp

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="kategori_donasi_id" class="form-label">Kategori</label>
            <select
                name="kategori_donasi_id"
                id="kategori_donasi_id"
                class="form-select @error('kategori_donasi_id') is-invalid @enderror"
            >
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('kategori_donasi_id', $program->kategori_donasi_id ?? '') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
            @error('kategori_donasi_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_program" class="form-label">Nama Program</label>
            <input
                type="text"
                name="nama_program"
                id="nama_program"
                class="form-control @error('nama_program') is-invalid @enderror"
                value="{{ old('nama_program', $program->nama_program ?? '') }}"
                placeholder="Contoh: Renovasi Asrama Putra"
            >
            @error('nama_program')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea
                name="deskripsi"
                id="deskripsi"
                rows="4"
                class="form-control @error('deskripsi') is-invalid @enderror"
            >{{ old('deskripsi', $program->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input
                    type="date"
                    name="tanggal_mulai"
                    id="tanggal_mulai"
                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                    value="{{ old('tanggal_mulai', isset($program) ? $program->tanggal_mulai->format('Y-m-d') : '') }}"
                >
                @error('tanggal_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input
                    type="date"
                    name="tanggal_selesai"
                    id="tanggal_selesai"
                    class="form-control @error('tanggal_selesai') is-invalid @enderror"
                    value="{{ old('tanggal_selesai', isset($program) && $program->tanggal_selesai ? $program->tanggal_selesai->format('Y-m-d') : '') }}"
                >
                <div class="form-text">Kosongkan jika program tanpa batas waktu.</div>
                @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="target_donasi" class="form-label">Target Donasi (Rp)</label>
            <input
                type="text"
                inputmode="numeric"
                name="target_donasi"
                id="target_donasi"
                data-rupiah
                class="form-control @error('target_donasi') is-invalid @enderror"
                value="{{ old('target_donasi', isset($program) && $program->target_donasi ? number_format($program->target_donasi, 0, ',', '.') : '') }}"
                placeholder="Contoh: 50.000.000"
            >
            <div class="form-text">Kosongkan jika program tanpa target (donasi terbuka tanpa batas).</div>
            @error('target_donasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Program</label>
            <input
                type="file"
                name="gambar"
                id="gambar"
                class="form-control @error('gambar') is-invalid @enderror"
                accept="image/jpeg,image/png"
            >
            <div class="form-text">Format JPG/PNG, maksimal 2MB.</div>
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if (isset($program) && $program->gambar)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $program->gambar) }}"
                         alt="{{ $program->nama_program }}"
                         class="img-fluid rounded">
                    <p class="text-muted small mb-0">Gambar saat ini. Unggah file baru untuk menggantinya.</p>
                </div>
            @endif
        </div>

        <div class="form-check form-switch mb-3">
            <input
                type="checkbox"
                name="is_active"
                id="is_active"
                class="form-check-input"
                value="1"
                {{ old('is_active', $program->is_active ?? true) ? 'checked' : '' }}
            >
            <label for="is_active" class="form-check-label">Aktif ditampilkan di halaman donasi publik</label>
        </div>

        @if (isset($program) && $program->is_umum)
            <div class="alert alert-info small">
                <i class="fas fa-circle-info"></i>
                Ini adalah program umum kategori <strong>{{ $program->kategori->nama }}</strong>.
                Kategori, target, dan status "umum" tidak dapat diubah lewat form ini.
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const formatRupiah = (value) => {
        const digits = value.replace(/\D/g, '');
        return digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '';
    };

    document.querySelectorAll('[data-rupiah]').forEach(function (input) {
        input.addEventListener('input', function () {
            const caretFromEnd = this.value.length - this.selectionStart;
            this.value = formatRupiah(this.value);
            const pos = Math.max(this.value.length - caretFromEnd, 0);
            this.setSelectionRange(pos, pos);
        });
        input.value = formatRupiah(input.value);
    });
});
</script>