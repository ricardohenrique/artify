@extends('layouts.app')

@section('title', "Add New Painting")

@section('content')

<section class="bg-light py-5">
    <div class="container" style="max-width: 800px;">
        <h2 class="mb-4 fw-semibold">🎨 Sell an item</h2>
        @if ($isEdit && $painting->images->count())
            <div class="bg-white rounded shadow-sm p-4 mb-3">
                <div class="mt-4">
                    <label class="form-label fw-semibold">Existing Images</label>
                    <div id="existing-images-container" class="d-flex gap-3 flex-wrap">
                        <form action=""></form>
                        @foreach ($painting->images as $image)
                            <div class="position-relative existing-image-wrapper" data-image-id="{{ $image->id }}">
                                <img src="{{ Storage::url($image->path) }}" style="height: 120px; width: 120px; object-fit: cover;" class="rounded border" alt=""/>
                                <form id="delete-image-{{ $image->id }}" action="{{ route('painting.image.delete', $image) }}" method="POST" class="position-absolute top-0 end-0 m-1 delete-existing-image-form">
                                    @csrf
                                    @method('DELETE')
                                    <button form="delete-image-{{ $image->id }}" type="submit" class="btn btn-sm btn-danger btn-close" aria-label="Remove existing image" title="Delete this image permanently"></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <!-- IMAGE UPLOAD -->
            <div class="bg-white rounded shadow-sm p-4 mb-3">
                <label class="form-label fw-semibold">Upload photos (Max 5 total)</label>
                <div id="drop-zone" class="border border-dashed rounded d-flex justify-content-center align-items-center p-5 text-muted"
                     style="min-height: 200px; cursor: pointer;">
                    <div class="text-center">
                        <i class="bi bi-upload" style="font-size: 2rem;"></i>
                        <p class="mt-2">Click or drag & drop to upload your painting</p>
                    </div>
                </div>
                <input type="file" id="image_upload_input" name="images[]" accept="image/*" class="d-none" multiple>

                <!-- Preview area for NEWLY selected images -->
                <div id="new-image-preview-container" class="d-flex gap-3 flex-wrap mt-3"></div>


                @error('images') {{-- Check for 'images' or 'images.*' depending on your validation --}}
                <div class="text-danger mt-2 small">{{ $message }}</div>
                @enderror
                @error('images.*')
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const MAX_TOTAL_IMAGES = 5;
        const fileInput = document.getElementById('image_upload_input');
        const newImagePreviewContainer = document.getElementById('new-image-preview-container');
        const dropZone = document.getElementById('drop-zone');

        let newSelectedFiles = []; // Array to hold File objects for new uploads

        // Calculate initially existing images
        let existingImagesCount = document.querySelectorAll('#existing-images-container .existing-image-wrapper').length;

        // Trigger file input click
        dropZone.addEventListener('click', () => fileInput.click());

        // Drag and Drop
        dropZone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropZone.classList.add('border-primary');
        });
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-primary');
        });
        dropZone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropZone.classList.remove('border-primary');
            const files = event.dataTransfer.files;
            if (files.length) {
                handleFiles(files);
            }
        });

        fileInput.addEventListener('change', function(event) {
            handleFiles(event.target.files);
        });

        function handleFiles(files) {
            const currentNewFileCount = newSelectedFiles.length;
            const availableSlots = MAX_TOTAL_IMAGES - existingImagesCount - currentNewFileCount;

            if (files.length > availableSlots) {
                alert(`You can only upload ${availableSlots} more image(s). ${files.length - availableSlots} files were not added.`);
            }

            for (let i = 0; i < Math.min(files.length, availableSlots); i++) {
                newSelectedFiles.push(files[i]);
            }
            renderNewImagePreviews();
            updateFileInput();
        }

        function renderNewImagePreviews() {
            newImagePreviewContainer.innerHTML = ''; // Clear previous new previews

            newSelectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.classList.add('position-relative', 'new-image-preview-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.height = '120px';
                    img.style.width = '120px';
                    img.style.objectFit = 'cover';
                    img.classList.add('rounded', 'border');

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'btn-close', 'position-absolute', 'top-0', 'end-0', 'm-1');
                    removeBtn.setAttribute('aria-label', 'Remove new image');
                    removeBtn.title = 'Remove this image from selection';
                    removeBtn.onclick = function() {
                        newSelectedFiles.splice(index, 1); // Remove from our array
                        renderNewImagePreviews(); // Re-render previews
                        updateFileInput(); // Update the actual file input
                    };

                    previewWrapper.appendChild(img);
                    previewWrapper.appendChild(removeBtn);
                    newImagePreviewContainer.appendChild(previewWrapper);
                }
                reader.readAsDataURL(file);
            });
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            newSelectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
            // console.log('Updated file input:', fileInput.files);
        }

        // Handle deletion of existing images (if not using page reload)
        // This is for client-side count update if you switch to AJAX deletion.
        // For now, with form submission, page reload will recount.
        // If you want to make deletion via AJAX later:
        document.querySelectorAll('.delete-existing-image-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // If using AJAX, you would e.preventDefault() here.
                // For non-AJAX, after successful deletion and redirect, this count will be correct.
                // To make it immediate for UX before reload (if desired):
                // const wrapper = form.closest('.existing-image-wrapper');
                // if (wrapper) {
                //     wrapper.remove();
                //     existingImagesCount = document.querySelectorAll('#existing-images-container .existing-image-wrapper').length;
                //     // Potentially enable file input if slots open up
                // }
                if (!confirm('Are you sure you want to delete this image? This action is permanent.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection
