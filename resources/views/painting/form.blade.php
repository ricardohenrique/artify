@extends('layouts.app')

@section('title', "Add New Painting")

@section('content')
<section class="bg-light py-5">
    <div class="container" style="max-width: 800px;">

        <h2 class="mb-4 fw-semibold">🎨 Sell an item</h2>

        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <!-- IMAGE UPLOAD -->
            <div class="bg-white rounded shadow-sm p-4 mb-3">
                <label for="image" class="form-label fw-semibold">Upload photos</label>
                <div class="border border-dashed rounded d-flex justify-content-center align-items-center p-5 text-muted"
                     style="min-height: 200px; cursor: pointer;" onclick="document.getElementById('image').click()">
                    <div class="text-center">
                        <i class="bi bi-upload" style="font-size: 2rem;"></i>
                        <p class="mt-2">Click or drag & drop to upload your painting</p>
                    </div>
                </div>
                <input type="file" id="image" name="image" accept="image/*" class="d-none">
                @error('image')
                    <div class="text-danger mt-2 small">{{ $message }}</div>
                @enderror
                <div class="alert alert-info mt-3 small">🎯 Catch your buyers’ eye — use quality photos. <a href="#">Learn how</a></div>
            </div>

            <!-- CATEGORY -->
            <div class="bg-white rounded shadow-sm p-4 mb-3">
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

            <!-- TITLE -->
            <div class="bg-white rounded shadow-sm p-4 mb-3">
                <label for="title" class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       placeholder="e.g. Starry Night" value="{{ old('title', $painting->title) }}">
                @error('title')
                    <div class="text-danger mt-2 small">{{ $message }}</div>
                @enderror
            </div>

            <!-- DESCRIPTION -->
            <div class="bg-white rounded shadow-sm p-4 mb-3">
                <label for="description" class="form-label fw-semibold">Describe your item</label>
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                          placeholder="e.g. Large acrylic on canvas, signed by the artist">{{ old('description', $painting->description) }}</textarea>
                @error('description')
                    <div class="text-danger mt-2 small">{{ $message }}</div>
                @enderror
            </div>

            <!-- PRICE -->
            <div class="bg-white rounded shadow-sm p-4 mb-4">
                <label for="price" class="form-label fw-semibold">Price</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $painting->price) }}">
                </div>
                @error('price')
                    <div class="text-danger mt-2 small">{{ $message }}</div>
                @enderror
            </div>

            <!-- FOOTER ACTIONS -->
            <div class="d-flex justify-content-end">
                <div class="d-flex justify-content-end">
                    <button type="submit" name="action" value="draft" class="btn btn-outline-secondary me-2">
                        {{ $isEdit ? 'Update as Draft' : 'Save Draft' }}
                    </button>
                    <button type="submit" name="action" value="publish" class="btn artify-btn">
                        {{ $isEdit ? 'Update' : 'Upload' }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</section>
@endsection
