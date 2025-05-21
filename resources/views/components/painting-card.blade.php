@php $hasLikes = $painting->favorited_by_count > 0; @endphp
<div class="col-md-3 col-sm-6">
    <div class="card border-0 shadow-sm h-100 position-relative">
        <div class="position-relative">
            <a href="{{ route('paintings.show', [
                'category_slug' => $painting->category->slug,
                'painting_slug' => $painting->slug,
            ]) }}">
                @php
                    $image = $painting->images->first();
                    $imageUrl = $image ? asset('storage/' . $image->path) : asset('storage/placeholder.jpg');
                @endphp
                <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $painting->title }}" style="aspect-ratio: 3/4; object-fit: cover;">
            </a>

            @auth
                <form method="POST" action="{{ route('paintings.favorite', $painting) }}"
                      class="position-absolute top-0 end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm"
                      style="border: none;">
                    @csrf
                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent d-flex align-items-center" title="Toggle favorite">
                        @if(auth()->user()->favorites->contains($painting->id))
                            <i class="bi bi-heart-fill text-danger {{ $hasLikes ? 'me-1' : '' }}"></i>
                        @else
                            <i class="bi bi-heart text-danger {{ $hasLikes ? 'me-1' : '' }}"></i>
                        @endif

                        @if ($hasLikes)
                            <span class="small fw-semibold">{{ $painting->favorited_by_count }}</span>
                        @endif
                    </button>
                </form>
            @else
                <a href="#" class="text-decoration-none text-dark position-absolute top-0 end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm requires-auth">
                    <i class="bi bi-heart {{ $hasLikes ? 'me-1' : '' }} text-danger"></i>
                    @if ($painting->favorited_by_count > 0)
                        <span class="small fw-semibold">{{ $painting->favorited_by_count }}</span>
                    @endif
                </a>
            @endauth
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