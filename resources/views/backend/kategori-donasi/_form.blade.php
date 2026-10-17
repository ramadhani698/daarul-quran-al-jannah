@php $kategori = $kategori ?? null; @endphp

<div class="mb-3">
    <label for="nama" class="form-label">Nama Kategori</label>
    <input
        type="text"
        name="nama"
        id="nama"
        class="form-control @error('nama') is-invalid @enderror"
        value="{{ old('nama', $kategori->nama ?? '') }}"
        placeholder="Contoh: Sedekah, Zakat, Wakaf, Infaq"
    >
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="icon" class="form-label">Icon</label>
    <input
        type="file"
        name="icon"
        id="icon"
        class="form-control @error('icon') is-invalid @enderror"
        accept="image/jpeg,image/png,image/svg+xml"
    >
    <div class="form-text">Format JPG, PNG, atau SVG, maksimal 512KB.</div>
    @error('icon')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if (isset($kategori) && $kategori->icon)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $kategori->icon) }}"
                 alt="{{ $kategori->nama }}"
                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
            <p class="text-muted small mb-0">Icon saat ini. Unggah file baru untuk menggantinya.</p>
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
        {{ old('is_active', $kategori->is_active ?? true) ? 'checked' : '' }}
    >
    <label for="is_active" class="form-check-label">Aktif ditampilkan di halaman donasi publik</label>
</div>
