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

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

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
                        
                            <!-- Save Buttons on Top -->
                            <div class="d-flex justify-content-end gap-3 mb-4">
                                <button type="submit" name="save_type" value="draft" class="btn btn-outline-secondary px-4 py-2">Save as Draft</button>
                                <button type="submit" name="save_type" value="published" class="btn btn-primary px-4 py-2">Save</button>
                            </div>
                        
                            <div class="accordion" id="paintingAccordion">
                                <!-- Basic Info -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBasic">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasic" aria-expanded="true">
                                            <i class="bi bi-pencil"></i> Basic Info
                                        </button>
                                    </h2>
                                    <div id="collapseBasic" class="accordion-collapse collapse show" data-bs-parent="#paintingAccordion">
                                        <div class="accordion-body">
                                            <!-- Images -->
                                            <div class="mb-4">
                                                <label class="form-label d-block">Images</label>
                                                <div class="row g-4">
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
                                            </div>
                        
                                            <!-- Title -->
                                            <div class="mb-4">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $painting->title) }}">
                                                @error('title')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                        
                                            <!-- CATEGORY -->
                                            <div class="mb-4">
                                                <label for="category_id" class="form-label fw-semibold">Category</label>
                                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                                    <option value="">Select a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('category_id', $painting->category_id) == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <div class="text-danger mt-2 small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Extra Info -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingExtra">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtra">
                                            <i class="bi bi-rocket"></i> Extra Info
                                        </button>
                                    </h2>
                                    <div id="collapseExtra" class="accordion-collapse collapse" data-bs-parent="#paintingAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-4">
                                                <label for="price" class="form-label">Price ($)</label>
                                                <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $painting->price) }}">
                                            </div>
                        
                                            <div class="mb-4">
                                                <label for="material" class="form-label">Material</label>
                                                <input type="text" name="material" class="form-control" value="{{ old('material', $painting->material) }}">
                                            </div>
                        
                                            <div class="mb-4">
                                                <label for="year" class="form-label">Year of Creation</label>
                                                <input type="number" name="year" class="form-control" value="{{ old('year', $painting->year) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Refined Info -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingRefined">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRefined">
                                            <i class="bi bi-star"></i> Refined Info
                                        </button>
                                    </h2>
                                    <div id="collapseRefined" class="accordion-collapse collapse" data-bs-parent="#paintingAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-4">
                                                <label for="dimensions" class="form-label">Dimensions</label>
                                                <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions', $painting->dimensions) }}">
                                            </div>
                        
                                            <div class="mb-4">
                                                <label for="framed" class="form-label">Framed?</label>
                                                <select name="framed" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1" {{ old('framed', $painting->framed) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('framed', $painting->framed) === 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                        
                                            <div class="mb-4">
                                                <label for="orientation" class="form-label">Orientation</label>
                                                <select name="orientation" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="portrait" {{ old('orientation', $painting->orientation) === 'portrait' ? 'selected' : '' }}>Portrait</option>
                                                    <option value="landscape" {{ old('orientation', $painting->orientation) === 'landscape' ? 'selected' : '' }}>Landscape</option>
                                                    <option value="square" {{ old('orientation', $painting->orientation) === 'square' ? 'selected' : '' }}>Square</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        border: 5px dashed #f66c6a !important;
    }
    .upload-area div span{
        font-size: 20px;
    }
    .upload-area div span i{
        font-size: 40px;
        display: block;
    }
    .upload-area:hover {
        border-color: #feaa53 !important;
        background-color: #dbdddf !important;
    }
    .image-preview img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .existing-img {
        border: 5px dashed #f66c6a !important;
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
