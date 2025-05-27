<div>
    @auth
        @if ($buttonType === 'icon')
        <button wire:click="toggleFavorite"
                class="position-absolute end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm btn btn-sm p-0 border-0 {{ $positionTop ? 'top-0' : 'bottom-0' }}"
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
        @elseif($buttonType === 'button')
            <button wire:click="toggleFavorite"
                class="btn btn-outline-danger w-100"
                title="Toggle favorite">
                @if ($isFavorited)
                    <i class="bi bi-heart-fill"></i> Favorited
                @else
                    <i class="bi bi-heart"></i> Add to Favorites
                @endif
            </button>
        @endif
    @else
        <a href=""
           class="text-decoration-none text-dark position-absolute top-0 end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm requires-auth {{ $positionTop ? 'top-0' : 'bottom-0' }}">
            <i class="bi bi-heart {{ $painting->favorited_by_count ? 'me-1' : '' }} text-danger"></i>
            @if ($painting->favorited_by_count > 0)
                <span class="small fw-semibold">{{ $favoriteCount }}</span>
            @endif
        </a>
    @endauth
</div>
