@extends('layouts.app')

@section('title', $painting->title)

@section('content')
    <section class="container py-5">
        <div class="row g-5">

            <!-- Images -->
            <div class="col-md-8">
                @php
                    $mainImage = $painting->images->first();
                @endphp
            
                @if ($mainImage)
                    <!-- Main image -->
                    <div class="mb-3">
                        <img 
                            id="main-image"
                            src="{{ asset('storage/' . $mainImage->path) }}"
                            alt="{{ $painting->title }}"
                            class="img-fluid rounded border"
                            style="height: 500px; width: 100%; object-fit: contain; background-color: #f8f9fa;"
                        >
                    </div>
            
                    <!-- Thumbnails -->
                    @if ($painting->images->count() > 1)
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($painting->images as $img)
                                <img src="{{ asset('storage/' . $img->path) }}"
                                     alt="Thumbnail"
                                     class="img-thumbnail thumb-image"
                                     style="height: 80px; width: 80px; object-fit: cover; cursor: pointer;">
                            @endforeach
                        </div>
                    @endif
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid rounded border" alt="No image">
                @endif
            </div>

            <!-- Details & Actions -->
            <div class="col-md-4">
                <div class="border rounded p-4 mb-4 bg-white shadow-sm">

                    <h1 class="h5 fw-bold mb-1">{{ $painting->title }}</h1>
                    <p class="text-muted mb-2">{{ $painting->category->name ?? 'Uncategorized' }}</p>
                    <h3 class="text-primary fw-bold mb-3">${{ number_format($painting->price, 2) }}</h3>

                    <p class="mb-4">{{ $painting->description }}</p>

                    <div class="d-grid gap-2 mb-3">
                        <a href="#" class="btn btn-primary">Buy Now</a>
                        <a href="#" class="btn btn-outline-primary">Make an Offer</a>
                        <a href="#" class="btn btn-outline-primary">Ask Seller</a>
                    </div>

                    {{-- <form method="POST" action="{{ route('paintings.favorite', $painting) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-heart"></i> Add to Favorites
                        </button>
                    </form> --}}

                    @guest
                        <a href="#" class="btn btn-outline-danger requires-auth w-100">
                            <i class="bi bi-heart"></i> Add to Favorites
                        </a>
                    @else
                        <form method="POST" action="{{ route('paintings.favorite', $painting) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                @if(auth()->user()->favorites->contains($painting->id))
                                    <i class="bi bi-heart-fill"></i> Favorited
                                @else
                                    <i class="bi bi-heart"></i> Add to Favorites
                                @endif
                            </button>
                        </form>
                    @endguest
                </div>

                <!-- Creator Info -->
                <div class="border rounded p-4 bg-white shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <img 
                            src="https://ui-avatars.com/api/?name={{ urlencode($painting->user->name) }}&background=ff6a00&color=fff" 
                            class="rounded-circle me-3" 
                            alt="Avatar"
                            style="width: 50px; height: 50px;"
                        >
                        <div>
                            <div class="fw-semibold">{{ $painting->user->name }}</div>
                            <div class="text-muted small">No reviews yet</div>
                        </div>
                    </div>

                    <div class="mb-2 text-muted small">
                        <i class="bi bi-geo-alt me-1"></i> {{ $painting->user->location ?? 'Unknown' }}
                    </div>

                    <div class="mb-3 text-muted small">
                        <i class="bi bi-clock me-1"></i> Last seen 3 weeks ago
                    </div>

                    @guest
                        <a href="#" class="btn btn-outline-primary requires-auth w-100">Follow</a>
                    @else
                        <form method="POST" action="{{ route('users.follow', $painting->user) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">
                                @if(auth()->user()->following->contains($painting->user->id))
                                    Following
                                @else
                                    Follow
                                @endif
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </section>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Please log in</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p>You need to be logged in to continue.</p>
            <a href="{{ route('login') }}" class="btn btn-primary w-100">Log In</a>
            </div>
        </div>
        </div>
    </div>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainImage = document.getElementById('main-image');
            const thumbnails = document.querySelectorAll('.thumb-image');
    
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function () {
                    mainImage.src = this.src;
                });
            });
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Thumbnail swapping
            const mainImage = document.getElementById('main-image');
            const thumbnails = document.querySelectorAll('.thumb-image');
    
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function () {
                    mainImage.src = this.src;
                });
            });
    
            // Guest user protection
            const guestOnlyButtons = document.querySelectorAll('.requires-auth');
    
            guestOnlyButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                });
            });
        });
    </script>
@endsection
