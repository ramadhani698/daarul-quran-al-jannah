@extends('backend.layouts')

@section('title', 'Tambah Banner Carousel')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Banner Carousel</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.carousel-donasi.store') }}" method="POST" enctype="multipart/form-data">
            @include('backend.carousel-donasi._form')
        </form>
    </div>
</div>
@endsection