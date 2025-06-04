@extends('layouts.app')

@section('title', $artist->name . ' - Independent Artist')

@section('content')
<section class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="position-relative text-white" style="background: linear-gradient(to bottom right, #ff6a00, #ff2e63); min-height: 300px;">
        <div class="container d-flex flex-column justify-content-center align-items-start h-100 py-5">
            <h6 class="text-uppercase fw-semibold small">Artist</h6>
            <h1 class="display-4 fw-bold">{{ $artist->name }}</h1>
            <p class="lead">Born in {{ $artist->birth_year ?? '19XX' }} - {{ $artist->location ?? 'Unknown' }}</p>

            {{-- <x-follow-button :user="$artist" class="rounded-pill px-4 btn-outline-light" /> --}}
            <livewire:follow-button :user="$artist" buttonClass="rounded-pill px-4 btn-outline-light btn-artist-follow" />
        </div>
    </div>
</section>
<section class="container py-5">
    <!-- Artist Info -->
    {{-- <div class="d-flex align-items-center gap-4 mb-5">
        <img src="{{ $artist->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($artist->name) }}"
             alt="{{ $artist->name }}"
             class="rounded-circle border"
             style="width: 100px; height: 100px;">
        <div>
            <h2 class="mb-1 fw-bold">{{ $artist->name }}</h2>
            <p class="text-muted mb-1">{{ $artist->location ?? 'Location not specified' }}</p>
            <div class="d-flex gap-3 small text-muted">
                <div><i class="bi bi-heart"></i> {{ $artist->favorites_count ?? 0 }} likes</div>
                <div><i class="bi bi-image"></i> {{ $paintings->total() }} artworks</div>
            </div>
        </div>
    </div> --}}

    <!-- Filter + Sort Bar -->
    <div class="filter-bar d-flex flex-wrap align-items-center justify-content-between gap-3 py-3 border-top border-bottom mb-4">
        <!-- Sort Dropdown -->
        <div class="dropdown ms-auto">
            <button class="btn filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Sort by
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item {{ request('sort') === 'newest' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest</a></li>
                <li><a class="dropdown-item {{ request('sort') === 'cheap' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'cheap']) }}">Price: Low to High</a></li>
                <li><a class="dropdown-item {{ request('sort') === 'liked' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'liked']) }}">Most Liked</a></li>
            </ul>
        </div>
    </div>

    <!-- Paintings -->
    <div class="row g-4">
        @forelse ($paintings as $painting)
            @include('components.painting-card', ['painting' => $painting])
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-frown" style="font-size: 3rem; color: #ff6a00;"></i>
                <h5 class="fw-semibold mt-3 mb-1">No paintings yet</h5>
                <p class="text-muted">This artist hasn’t posted any artwork yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($paintings->hasPages())
        <div class="mt-5 text-center">
            <div class="text-muted mb-2">
                Showing <strong>{{ $paintings->firstItem() }}</strong> to <strong>{{ $paintings->lastItem() }}</strong> of <strong>{{ $paintings->total() }}</strong> results
            </div>
            <div class="d-inline-block">
                {{ $paintings->links() }}
            </div>
        </div>
    @endif
</section>
<style>
    /* Filter bar container */
    .filter-bar {
        border-color: #e9ecef;
        background-color: #fff;
        border-radius: 12px;
        padding: 1rem 1.5rem;
    }

    /* Filter button styling */
    .filter-btn {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        padding: 6px 16px;
        transition: background 0.2s ease;
    }

    .filter-btn:hover {
        background: #ffedf3;
        border-color: #ff4e9b;
        color: #ff4e9b;
    }

    /* Active filter badge */
    .active-filter {
        background: #e9ecef;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 13px;
        margin-left: 0.5rem;
    }

    /* Optional: custom dropdown menu spacing */
    .dropdown-menu {
        font-size: 14px;
        border-radius: 8px;
    }

    .container-fluid .container .btn-artist-follow{
        border-color: #f8f9fa;
        color: #f8f9fa;
    }
    .container-fluid .container .btn-artist-follow:hover,
    .container-fluid .container .btn-artist-follow.btn-active
    {
        background-color: #f8f9fa;
        color:#000;
    }
</style>
@endsection
