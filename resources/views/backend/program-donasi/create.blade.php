@extends('backend.layouts')

@section('title', 'Tambah Program Donasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Program Donasi</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.program-donasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('backend.program-donasi._form')

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.program-donasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
