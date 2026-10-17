@extends('backend.layouts')

@section('title', 'Info Akademik')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 fw-semibold">Info Akademik</h1>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Card dengan Tabs --}}
    <div class="card">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="info-akademik-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-kurikulum-link" data-toggle="tab" href="#tab-kurikulum" role="tab">
                        <i class="fas fa-book me-1"></i> Kurikulum
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-jadwal-link" data-toggle="tab" href="#tab-jadwal" role="tab">
                        <i class="fas fa-clock me-1"></i> Jadwal Harian
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-evaluasi-link" data-toggle="tab" href="#tab-evaluasi" role="tab">
                        <i class="fas fa-clipboard-check me-1"></i> Evaluasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-prestasi-link" data-toggle="tab" href="#tab-prestasi" role="tab">
                        <i class="fas fa-trophy me-1"></i> Prestasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-agenda-link" data-toggle="tab" href="#tab-agenda" role="tab">
                        <i class="fas fa-bullhorn me-1"></i> Agenda
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="info-akademik-tabs-content">

                {{-- TAB: KURIKULUM --}}
                <div class="tab-pane fade show active" id="tab-kurikulum" role="tabpanel">
                    @include('backend.info-akademik.kurikulum._table', [
                        'kurikulum_kiri'  => $kurikulum_kiri,
                        'kurikulum_kanan' => $kurikulum_kanan,
                    ])
                </div>

                {{-- TAB: JADWAL HARIAN — coming soon --}}
                <div class="tab-pane fade" id="tab-jadwal" role="tabpanel">
                    @include('backend.info-akademik.jadwal-harian._table', [
                        'jadwals' => $jadwals,
                    ])
                </div>

                {{-- TAB: EVALUASI --}}
                <div class="tab-pane fade" id="tab-evaluasi" role="tabpanel">
                    @include('backend.info-akademik.evaluasi._table', [
                        'evaluasi_kiri'  => $evaluasi_kiri,
                        'evaluasi_kanan' => $evaluasi_kanan,
                    ])
                </div>

                {{-- TAB: PRESTASI — coming soon --}}
                <div class="tab-pane fade" id="tab-prestasi" role="tabpanel">
                    <p class="text-muted py-2">
                        @include('backend.info-akademik.prestasi._table', [
                            'prestasis' => $prestasis,
                        ])
                    </p>
                </div>

                {{-- TAB: AGENDA — coming soon --}}
                <div class="tab-pane fade" id="tab-agenda" role="tabpanel">
                    <p class="text-muted py-2">
                        @include('backend.info-akademik.agenda._table', [
                            'agendas' => $agendas,
                        ])
                    </p>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let hash = window.location.hash;
        let hashValid = hash && $('#info-akademik-tabs a[href="' + hash + '"]').length;
        let activeTab = hashValid ? hash : localStorage.getItem('infoAkademikActiveTab');

        if (activeTab) {
            $('#info-akademik-tabs a[href="' + activeTab + '"]').tab('show');
        }

        $('#info-akademik-tabs a').on('click', function () {
            localStorage.setItem('infoAkademikActiveTab', $(this).attr('href'));
        });
    });
</script>
@endpush