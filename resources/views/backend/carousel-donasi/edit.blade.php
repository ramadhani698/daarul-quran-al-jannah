@extends('backend.layouts')

@section('title', 'Edit Banner Carousel')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Banner Carousel</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.carousel-donasi.update', $carousel) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('backend.carousel-donasi._form')
        </form>
    </div>
</div>
@endsection