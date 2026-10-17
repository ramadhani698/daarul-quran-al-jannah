@extends('backend.layouts')

@section('title', 'Edit Kategori Donasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Kategori Donasi</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.kategori-donasi.update', $kategori) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('backend.kategori-donasi._form', ['kategori' => $kategori])

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.kategori-donasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
