@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- Hero Section with Background Image and Overlay Box -->
<section class="hero-sell position-relative d-flex align-items-center">
    <div class="container">
        <div class="row">
            <!-- Callout Box -->
            <div class="col-md-6">
                <div class="bg-white p-5 rounded shadow" style="max-width: 420px;">
                    <h2 class="fw-bold mb-3">Ready to share your art with the world?</h2>
                    <a href="{{ route('item.new') }}" class="btn artify-btn w-100 mb-3">Sell now</a>
                    <div class="text-center">
                        <a href="#" class="">Learn how it works</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Most Liked -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold">Most Liked</h2>
        <div class="row g-4">
            @foreach($mostLiked as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>
    </div>
</section>

<!-- Most Recent -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold">Most Recent</h2>
        <div class="row g-4">
            @foreach($mostRecent as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Artists Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold">Featured Artists</h2>
        <div class="row g-4 text-center">
            @foreach($featuredArtists as $artist)
                <div class="col-md-3">
                    <div class="p-3 border rounded shadow-sm h-100 bg-white">
                        <img src="{{ $artist->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($artist->name) }}" class="rounded-circle mb-3" width="80" height="80" alt="{{ $artist->name }}">
                        <h6 class="fw-semibold">{{ $artist->name }}</h6>
                        <p class="text-muted small">{{ $artist->location ?? 'Unknown' }}</p>
                        <a href="{{ route('member.profile', $artist->id) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-white border-top">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold">What People Are Saying</h2>
        <div class="row g-4 text-center">
            @foreach($testimonials as $testimonial)
                <div class="col-md-4">
                    <blockquote class="border rounded p-4 bg-light position-relative h-100">
                        <p class="fst-italic mb-3">"{{ $testimonial->content }}"</p>
                        <footer class="fw-semibold text-muted">&mdash; {{ $testimonial->author }}</footer>
                    </blockquote>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-4 fw-bold">How Artify Works</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded bg-white h-100">
                    <i class="bi bi-search fs-2 text-gradient mb-3"></i>
                    <h6 class="fw-semibold">Discover</h6>
                    <p class="text-muted small">Browse unique artwork from emerging artists worldwide.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded bg-white h-100">
                    <i class="bi bi-chat-dots fs-2 text-gradient mb-3"></i>
                    <h6 class="fw-semibold">Connect</h6>
                    <p class="text-muted small">Chat with artists to ask questions or request custom work.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded bg-white h-100">
                    <i class="bi bi-cart-check fs-2 text-gradient mb-3"></i>
                    <h6 class="fw-semibold">Own It</h6>
                    <p class="text-muted small">Purchase original artwork and support independent creators.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="mb-4 text-center fw-bold">Explore by Category</h2>
        <div class="row g-3 text-center">
            @foreach($categories as $category)
                <div class="col-6 col-md-3">
                    <a href="{{ "/paintings/$category->slug" }}" class="text-decoration-none d-block p-4 border rounded bg-light h-100">
                        <div class="fw-semibold text-dark">{{ $category->name }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA for Artists -->
<section class="py-5 text-center text-white" style="background: linear-gradient(90deg, #ff6a00, #e91e63);">
    <div class="container">
        <h2 class="fw-bold mb-3">Are You an Artist?</h2>
        <p class="lead mb-4">Join Artify and showcase your work to thousands of art lovers.</p>
        <a href="{{ route('item.new') }}" class="btn btn-light btn-lg fw-semibold">Start Selling</a>
    </div>
</section>
@endsection