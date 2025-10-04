<div class="col-6 col-sm-6 col-md-4 col-lg-fifth">
    <div class="card border-0 shadow-sm h-100 position-relative">
        <div class="position-relative">
            <a href="{{ route('paintings.show', [
                'category_slug' => $painting->category->slug,
                'painting_slug' => $painting->slug,
            ]) }}">
                @php
                    $image = $painting->images->first();
                    $imageUrl = $image ? Storage::url($image->path) : asset('storage/placeholder.jpg');
                @endphp
                <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $painting->title }}" style="aspect-ratio: 3/4; object-fit: cover;">
            </a>

            <livewire:like-button :painting="$painting" />
        </div>

        <div class="card-body px-2 py-3">
            <div class="fw-semibold small text-muted">{{ $painting->title }}</div>
            <div class="text-muted small">{{ $painting->category->name ?? '' }}</div>

            <div class="mt-1 fw-semibold text-dark">
                ${{ number_format($painting->price, 2) }}
            </div>
        </div>
    </div>
</div>
