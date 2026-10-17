@extends('backend.layouts')

@section('title', 'Dashboard Pendaftaran Santri')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Data Pendaftaran Santri</h4>
        <div>
            <a href="{{ route('admin.pendaftaran.refresh') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-rotate mr-1"></i> Refresh Data
            </a>
            <a href="{{ route('admin.pendaftaran.export') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- Table --}}
    <div class="card">
        <div class="card-body">

            {{-- Search --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input
                        type="text"
                        id="searchPendaftaran"
                        class="form-control"
                        placeholder="Cari nama, provinsi, kabupaten..."
                    >
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" id="tabelPendaftaran">
                    <thead class="thead-light">
                        <tr>
                            <th width="40" class="text-center">No</th>
                            <th>Nama Lengkap</th>
                            <th width="140">Tanggal Lahir</th>
                            <th>Provinsi</th>
                            <th>Kabupaten</th>
                            <th width="140">Tanggal Daftar</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $row)
                            <tr>
                                <td class="text-center">{{ $row['no'] }}</td>
                                <td>{{ $row['nama_lengkap'] }}</td>
                                <td>{{ $row['tanggal_lahir'] }}</td>
                                <td>{{ $row['provinsi'] }}</td>
                                <td>{{ $row['kabupaten'] }}</td>
                                <td>{{ $row['tanggal_daftar'] }}</td>
                                <td class="text-center">
                                    <a href="https://docs.google.com/spreadsheets/d/{{ $spreadsheetId }}/edit#gid=0&range=A{{ $row['row_number'] }}"
                                       target="_blank" class="btn btn-sm btn-outline-secondary" title="Lihat detail di Google Sheets">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data pendaftaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchPendaftaran');
        const table = document.getElementById('tabelPendaftaran');

        if (!searchInput || !table) return;

        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('keyup', function () {
            const keyword = this.value.toLowerCase().trim();

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    });
</script>
@endpush