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

                        @php
                            $existingCount = $painting->images->count();
                            $remaining = max(0, 3 - $existingCount);
                        @endphp

                        <!-- Hidden delete forms placed outside the main form to avoid nesting -->
                        @foreach ($painting->images as $img)
                            <form id="delete-image-{{ $img->id }}" method="POST" action="{{ route('painting.image.delete', $img) }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach

                        <form method="POST" action="{{ route('item.updatePainting', $painting) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $painting->title) }}">
                                @error('title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Combined Image Row -->
                            <div class="mb-4">
                                <label class="form-label d-block">Images</label>
                                <div class="row g-4">

                                    <!-- Existing Images -->
                                    @foreach ($painting->images as $image)
                                        <div class="col-md-4">
                                            <div class="border rounded p-2 position-relative h-100 d-flex flex-column existing-img">
                                                <div class="image-preview flex-grow-1 d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <img src="{{ \Storage::disk(config('filesystems.default'))->url($image->path) }}" class="img-fluid rounded" alt="Painting image">
                                                </div>
                                                <div class="mt-2">
                                                    <button type="submit" form="delete-image-{{ $image->id }}" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Remaining Upload Slots -->
                                    @for ($i = 1; $i <= $remaining; $i++)
                                        <div class="col-md-4 text-center">
                                            <label class="d-block border rounded p-3 bg-light position-relative upload-area" style="cursor: pointer;">
                                                <input type="file" name="images[]" accept="image/*" class="d-none image-input" data-index="{{ $i }}">
                                                <div class="image-preview d-flex justify-content-center align-items-center" style="height: 200px;">
                                                    <span class="text-muted"><i class="bi bi-plus-circle-dotted"></i> Image {{ $existingCount + $i }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    @endfor

                                </div>
                                @error('images')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                                @error('images.*')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Save Buttons -->
                            <div class="d-flex gap-3">
                                <button type="submit" name="save_type" value="draft" class="btn btn-outline-secondary px-4 py-2">Save as Draft</button>
                                <button type="submit" name="save_type" value="published" class="btn btn-primary px-4 py-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <style>
    .upload-area {
        transition: 0.3s!important;
        border: 5px dashed #00d129 !important;
    }
    .upload-area div span{
        font-size: 20px;
    }
    .upload-area div span i{
        font-size: 40px;
        display: block;
    }
    .upload-area:hover {
        border-color: #28f050 !important;
    }
    .image-preview img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .existing-img {
        border: 5px dashed #00d129 !important;
    }
    .existing-img button{
        position: absolute;
        top: 3px;
        right: 3px;
        border-radius: 5px;
        border: 1px solid red;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const uploadAreas = document.querySelectorAll('.upload-area');
        const imageInputs = document.querySelectorAll('.image-input');

        imageInputs.forEach(input => {
            input.addEventListener('change', function () {
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

        uploadAreas.forEach(area => {
            area.addEventListener('dragover', function (e) {
                e.preventDefault();
                area.classList.add('bg-white');
            });
            area.addEventListener('dragleave', function () {
                area.classList.remove('bg-white');
            });
            area.addEventListener('drop', function (e) {
                e.preventDefault();
                area.classList.remove('bg-white');
                const input = area.querySelector('.image-input');
                if (!input) return;
                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    input.files = e.dataTransfer.files;
                    input.dispatchEvent(new Event('change'));
                }
            });
        });
    });
    </script>
@endsection
