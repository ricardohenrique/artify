<div class="col-6 col-sm-6 col-md-4 col-lg-fifth artify-card">
    <div class="card border-0 h-100 position-relative">
        <!-- Image -->
        @php
            $image = $painting->images->first();
            $imageUrl = $image ? Storage::url($image->path) : Storage::url('default-img/placeholder.jpg');
        @endphp
        <a href="{{ route('paintings.show', [
            'category_slug' => $painting->category->slug,
            'painting_slug' => $painting->slug,
        ]) }}" class="d-block position-relative">
            <img src="{{ $imageUrl }}" class="card-img-top artify-image" alt="{{ $painting->title }}">
            <div class="artify-like-button">
                <livewire:like-button :painting="$painting" />
            </div>
        </a>

        <!-- Content -->
        <a href="{{ route('paintings.show', [
            'category_slug' => $painting->category->slug,
            'painting_slug' => $painting->slug,
        ]) }}" class="text-decoration-none">
            <div class="card-body px-3 py-3">
                <div class="fw-semibold small text-muted text-truncate">{{ $painting->title }}</div>
                <div class="text-muted small mb-1"><i class="bi bi-tag"></i> {{ $painting->category->name ?? '' }}</div>
                <div class="fw-semibold text-dark">${{ number_format($painting->price, 2) }}</div>
            </div>
        </a>
    </div>
</div>
