<div>
    @auth
        <button wire:click="toggleFavorite"
                class="position-absolute top-0 end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm btn btn-sm p-0 border-0"
                title="Toggle favorite">
            @if ($isFavorited)
                <i class="bi bi-heart-fill text-danger {{ $hasLikes ? 'me-1' : '' }}"></i>
            @else
                <i class="bi bi-heart text-danger {{ $hasLikes ? 'me-1' : '' }}"></i>
            @endif

            @if ($hasLikes)
                <span class="small fw-semibold">{{ $favoriteCount }}</span>
            @endif
        </button>
    @else
        <a href=""
           class="text-decoration-none text-dark position-absolute top-0 end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm requires-auth">
            <i class="bi bi-heart {{ $painting->favorited_by_count ? 'me-1' : '' }} text-danger"></i>
            @if ($painting->favorited_by_count > 0)
                <span class="small fw-semibold">{{ $favoriteCount }}</span>
            @endif
        </a>
    @endauth
</div>
