@extends('backend.layouts')

@section('title', 'Program Donasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Program Donasi</h5>
        <a href="{{ route('admin.program-donasi.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Program
        </a>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <ul class="nav nav-tabs mb-3">
            @foreach (['aktif' => 'Aktif', 'berakhir' => 'Berakhir', 'arsip' => 'Arsip'] as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ $tab === $key ? 'active' : '' }}"
                       href="{{ route('admin.program-donasi.index', ['tab' => $key]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width: 70px;">Gambar</th>
                    <th>Nama Program</th>
                    <th>Kategori</th>
                    <th>Periode</th>
                    <th>Progress</th>
                    <th>Donasi Masuk</th>
                    @if ($tab !== 'arsip')
                        <th>Status</th>
                    @endif
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($programs as $program)
                    <tr>
                        <td>
                            @if ($program->gambar)
                                <img src="{{ asset('storage/' . $program->gambar) }}"
                                     alt="{{ $program->nama_program }}"
                                     style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            {{ $program->nama_program }}
                            @if ($program->is_umum)
                                <span class="badge bg-secondary">Umum</span>
                            @endif
                        </td>
                        <td>{{ $program->kategori->nama }}</td>
                        <td class="small text-muted">
                            {{ $program->tanggal_mulai->format('d/m/Y') }} —
                            {{ $program->tanggal_selesai ? $program->tanggal_selesai->format('d/m/Y') : 'Tanpa batas' }}
                        </td>
                        <td style="min-width: 140px;">
                            @if ($program->target_donasi)
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: {{ $program->persentase }}%"></div>
                                </div>
                                <span class="small text-muted">{{ $program->persentase }}% dari target</span>
                            @else
                                <span class="small text-muted">Tanpa target</span>
                            @endif
                        </td>
                        <td>Rp{{ number_format($program->terkumpul, 0, ',', '.') }}</td>

                        @if ($tab !== 'arsip')
                            <td>
                                <div class="form-check form-switch">
                                    <input
                                        type="checkbox"
                                        class="form-check-input toggle-active"
                                        data-id="{{ $program->id }}"
                                        {{ $program->is_active ? 'checked' : '' }}
                                    >
                                </div>
                            </td>
                        @endif

                        <td class="text-end">
                            @if ($tab === 'arsip')
                                <form action="{{ route('admin.program-donasi.restore', $program->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-trash-restore"></i> Pulihkan
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.program-donasi.edit', $program) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                @if ($program->is_umum)
                                    <button type="button" class="btn btn-sm btn-outline-danger" disabled
                                            title="Program umum tidak dapat dihapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <a href="{{ route('admin.program-donasi.confirm-hapus', $program) }}"
                                       class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Tidak ada program di tab ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $programs->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        document.querySelectorAll('.toggle-active').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const id = this.dataset.id;
                const previousState = !this.checked;

                fetch(`/admin/program-donasi/${id}/toggle-active`, {
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
                        this.checked = previousState;
                        alert('Gagal mengubah status program.');
                    });
            });
        });
    });
</script>
@endpush
