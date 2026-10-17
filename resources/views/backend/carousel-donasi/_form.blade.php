@csrf

<div class="mb-3">
    <label class="form-label">Judul <small class="text-muted">(opsional, buat alt text & label admin)</small></label>
    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
           value="{{ old('judul', $carousel->judul ?? '') }}" maxlength="100">
    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Gambar Banner {{ isset($carousel) ? '' : '*' }}</label>
    @isset($carousel)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $carousel->gambar) }}" alt="" class="img-fluid rounded" style="max-height:120px">
            <div class="small text-muted">Kosongkan kalau nggak mau ganti gambar.</div>
        </div>
    @endisset
    <input type="file" name="gambar" accept="image/png,image/jpeg,image/webp"
           class="form-control @error('gambar') is-invalid @enderror">
    <small class="text-muted">jpg / png / webp, maksimal 2 MB.</small>
    @error('gambar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Link ke Program <small class="text-muted">(kosongkan kalau cuma banner promosi)</small></label>
    <select name="program_donasi_id" class="form-select @error('program_donasi_id') is-invalid @enderror">
        <option value="">Tanpa link (promosi)</option>
        @foreach ($programs as $p)
            <option value="{{ $p->id }}"
                @selected(old('program_donasi_id', $carousel->program_donasi_id ?? '') == $p->id)>
                {{ $p->nama_program }}
            </option>
        @endforeach
    </select>
    <small class="text-muted">Banner program baru tampil saat program dimulai dan hilang otomatis setelah selesai.</small>
    @error('program_donasi_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Urutan <small class="text-muted">(kosongkan = otomatis paling belakang)</small></label>
    <input type="number" name="urutan" min="0" class="form-control @error('urutan') is-invalid @enderror"
           value="{{ old('urutan', $carousel->urutan ?? '') }}">
    @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-4">
    <input type="hidden" name="is_aktif" value="0">
    <input type="checkbox" name="is_aktif" value="1" id="is_aktif" class="form-check-input"
           @checked(old('is_aktif', $carousel->is_aktif ?? true))>
    <label for="is_aktif" class="form-check-label">Aktif</label>
</div>

<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
<a href="{{ route('admin.carousel-donasi.index') }}" class="btn btn-light">Batal</a>