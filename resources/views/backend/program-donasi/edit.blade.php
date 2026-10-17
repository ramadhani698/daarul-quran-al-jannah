@extends('backend.layouts')

@section('title', 'Edit Program Donasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Program Donasi</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.program-donasi.update', $program) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('backend.program-donasi._form', ['program' => $program])

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.program-donasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
