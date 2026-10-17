@extends('backend.layouts')

@section('title', 'Carousel Donasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Carousel Donasi</h5>
        <a href="{{ route('admin.carousel-donasi.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Banner
        </a>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:70px">Urutan</th>
                    <th style="width:160px">Gambar</th>
                    <th>Judul / Tujuan</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($carousels as $c)
                    <tr>
                        <td>{{ $c->urutan }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $c->gambar) }}" alt="{{ $c->judul }}"
                                 class="img-fluid rounded" style="max-height:70px">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $c->judul ?: '(tanpa judul)' }}</div>
                            @if ($c->isProgram())
                                <div class="small text-muted">
                                    Program: {{ $c->program?->nama_program ?? '-' }}
                                </div>
                                @if ($c->program && ($c->program->trashed() || !$c->program->is_active))
                                    <span class="badge bg-warning text-dark">Program nonaktif/arsip, tidak tampil</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Promosi (tidak bisa diklik)</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.carousel-donasi.toggle', $c) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="btn btn-sm {{ $c->is_aktif ? 'btn-success' : 'btn-outline-secondary' }}">
                                    {{ $c->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.carousel-donasi.edit', $c) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form action="{{ route('admin.carousel-donasi.destroy', $c) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus banner ini? Gambarnya ikut terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada banner.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection