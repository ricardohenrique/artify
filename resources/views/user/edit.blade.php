@extends('layouts.app')

@section('title', 'Edit Painting')

@section('content')
    <section class="bg-light py-5">
        <div class="container">
            @include('partials.profile.header')

            <div class="row">
                @include('partials.profile.sidebar')

                <div class="col-md-9">
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="mb-3 fw-semibold">Edit Painting</h5>

                        <form method="POST" action="{{ route('item.update', $painting->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Title Input -->
                            <div class="mb-4">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $painting->title) }}" required>
                            </div>

                            <!-- Existing Images -->
                            <div class="row g-4 mb-4">
                                @foreach($painting->images as $img)
                                    <div class="col-md-4 text-center">
                                        <div class="border rounded p-3 bg-light position-relative">
                                            <img src="{{ Storage::url($img->path) }}" class="img-fluid rounded mb-2" style="max-height: 200px; object-fit: cover;">
                                            <form method="POST" action="{{ route('painting.image.delete', $img) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- New Image Uploads -->
                            @php
                                $remaining = 3 - $painting->images->count();
                            @endphp
                            @if($remaining > 0)
                                <div class="row g-4 mb-4">
                                    @for ($i = 1; $i <= $remaining; $i++)
                                        <div class="col-md-4 text-center">
                                            <label class="d-block border rounded p-3 bg-light position-relative upload-area" style="cursor: pointer;">
                                                <input type="file" name="images[]" accept="image/*" class="d-none image-input" data-index="{{ $i }}">
                                                <div class="image-preview d-flex justify-content-center align-items-center" style="height: 200px;">
                                                    <span class="text-muted">+ Upload Image {{ $i }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            @endif

                            <!-- Save Buttons -->
                            <div class="d-flex gap-3">
                                <button type="submit" name="save_type" value="draft" class="btn btn-outline-secondary px-4 py-2">Update as Draft</button>
                                <button type="submit" name="save_type" value="published" class="btn btn-primary px-4 py-2">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .upload-area {
            transition: border 0.3s;
        }
        .upload-area:hover {
            border-color: #0d6efd;
        }
        .image-preview img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInputs = document.querySelectorAll('.image-input');

            imageInputs.forEach(input => {
                input.addEventListener('change', function (e) {
                    const preview = this.closest('.upload-area').querySelector('.image-preview');
                    const file = this.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            preview.innerHTML = `<img src="${event.target.result}" class="img-fluid rounded">`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        });
    </script>
@endsection
