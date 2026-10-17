@extends('backend.layouts')

@section('title', 'Verifikasi Donasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $title }}</h5>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <ul class="nav nav-tabs mb-3">
            @foreach (['pending' => 'Pending', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak', 'semua' => 'Semua'] as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ $status === $key ? 'active' : '' }}"
                       href="{{ route($routeName, ['status' => $key]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Kode Donasi</th>
                    <th>Donatur</th>
                    <th>Program</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donasis as $donasi)
                    <tr>
                        <td><code>{{ $donasi->kode_donasi }}</code></td>
                        <td>{{ $donasi->nama_tampil }}</td>
                        <td>{{ $donasi->program->nama_program }}</td>
                        <td>Rp{{ number_format($donasi->nominal, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $donasi->metode_badge }}">
                                <i class="fas {{ $donasi->metode_icon }}"></i> {{ $donasi->metode_label }}
                            </span>
                        </td>
                        <td>
                            @php
                                $badgeClass = match ($donasi->status) {
                                    'verified' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-warning text-dark',
                                };
                                $badgeLabel = match ($donasi->status) {
                                    'verified' => 'Terverifikasi',
                                    'rejected' => 'Ditolak',
                                    default => 'Pending',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </td>
                        <td class="small text-muted">{{ $donasi->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.donasi.verifikasi', $donasi) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Tidak ada donasi pada tab ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $donasis->links() }}
    </div>
</div>
@endsection