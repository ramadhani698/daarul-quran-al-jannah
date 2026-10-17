@extends('backend.layouts')

@section('title', 'Kategori Donasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Kategori Donasi</h5>
        <a href="{{ route('admin.kategori-donasi.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p class="text-muted small mb-3">
            Seret ikon <i class="fas fa-arrows-alt"></i> pada baris untuk mengubah urutan tampil di halaman donasi publik.
        </p>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width: 40px;"></th>
                    <th style="width: 60px;">Icon</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Program</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody id="kategoriSortable">
                @forelse ($kategoris as $kategori)
                    <tr data-id="{{ $kategori->id }}">
                        <td class="text-muted drag-handle" style="cursor: grab;">
                            <i class="fas fa-arrows-alt"></i>
                        </td>
                        <td>
                            @if ($kategori->icon)
                                <img src="{{ asset('storage/' . $kategori->icon) }}"
                                     alt="{{ $kategori->nama }}"
                                     style="width: 36px; height: 36px; object-fit: cover; border-radius: 8px;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $kategori->programs_count }} program</span>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input
                                    type="checkbox"
                                    class="form-check-input toggle-active"
                                    data-id="{{ $kategori->id }}"
                                    {{ $kategori->is_active ? 'checked' : '' }}
                                >
                            </div>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.kategori-donasi.edit', $kategori) }}"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.kategori-donasi.destroy', $kategori) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori {{ $kategori->nama }}? Kategori yang masih punya program tidak bisa dihapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada kategori donasi. Klik "Tambah Kategori" untuk membuat yang pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Drag-to-reorder — kirim urutan baru ke server begitu drag selesai
        const sortableBody = document.getElementById('kategoriSortable');
        if (sortableBody) {
            new Sortable(sortableBody, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function () {
                    const urutan = Array.from(sortableBody.querySelectorAll('tr[data-id]'))
                        .map(row => row.dataset.id);

                    fetch('{{ route('admin.kategori-donasi.urutan') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ urutan }),
                    }).catch(() => alert('Gagal menyimpan urutan. Silakan muat ulang halaman.'));
                },
            });
        }

        // Toggle status aktif/nonaktif tanpa reload halaman
        document.querySelectorAll('.toggle-active').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const id = this.dataset.id;
                const previousState = !this.checked;

                fetch(`/admin/kategori-donasi/${id}/toggle-active`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal update status');
                        return res.json();
                    })
                    .catch(() => {
                        this.checked = previousState; // rollback kalau gagal
                        alert('Gagal mengubah status kategori.');
                    });
            });
        });
    });
</script>
@endpush
