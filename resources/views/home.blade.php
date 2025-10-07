@extends('layouts.app')

@section('meta')
    <meta name="robots" content="index, follow">
@endsection

@section('title', 'Artify | Buy Original Artworks from Independent Artists')
@section('description', 'Discover and collect unique artworks from independent artists around the world. Join Artify')
@section('keywords', 'artify, independent artists, original artwork marketplace, buy art online, artist community, support artists, creative platform, buy original art, online art gallery')


@section('content')

<!-- Hero Section -->
<section class="hero-sell position-relative d-flex align-items-center">
    <div class="container">
        <div class="row">
            <!-- Callout Box -->
            <div class="col-md-6">
                <div class="hero-callout-box p-5 rounded-4 shadow-lg">
                    <h2 class="fw-bold mb-4">Ready to share your art with the world?</h2>
                    <a href="{{ route('item.new') }}" class="btn hero-cta-btn w-100 mb-3">Sell now</a>
                    <div class="text-center">
                        <a href="{{ route('how-artify-works') }}" class="learn-link">Learn how it works</a>
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

<!-- How It Works Section -->
<section class="how-it-works-section py-5 position-relative">
    <div class="container text-center">
        <h2 class="mb-5 fw-bold">How Artify Works</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="how-step h-100">
                    <div class="step-number">1</div>
                    <div class="icon-wrapper">
                        <i class="bi bi-search fs-2"></i>
                    </div>
                    <h6 class="fw-semibold">Discover</h6>
                    <p class="text-muted small">Browse unique artwork from emerging artists worldwide.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="how-step h-100">
                    <div class="step-number">2</div>
                    <div class="icon-wrapper">
                        <i class="bi bi-chat-dots fs-2"></i>
                    </div>
                    <h6 class="fw-semibold">Connect</h6>
                    <p class="text-muted small">Chat with artists to ask questions or request custom work.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="how-step h-100">
                    <div class="step-number">3</div>
                    <div class="icon-wrapper">
                        <i class="bi bi-cart-check fs-2"></i>
                    </div>
                    <h6 class="fw-semibold">Own It</h6>
                    <p class="text-muted small">Purchase original artwork and support independent creators.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-5 bg-white">
    <div class="container">
        <h2 class="mb-5 text-center fw-bold">Explore by Category</h2>
        <div class="row g-3 text-center">
            @foreach($categories as $category)
                <div class="col-6 col-md-3">
                    <a href="{{ route('paintings.list', $category->slug) }}" class="category-tile d-block p-4 h-100 rounded-4">
                        <div class="fw-semibold">{{ $category->name }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Artists Section -->
<section class="featured-artists-section py-5 bg-light-subtle">
    <div class="container">
        <h2 class="mb-5 text-center fw-bold">Featured Artists</h2>
        <div class="row g-4 text-center">
            @foreach($featuredArtists as $artist)
                <div class="col-md-3">
                    <div class="artist-card bg-white p-4 rounded-4 shadow-sm h-100 position-relative">
                        <img src="{{ $artist->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($artist->name) }}" class="rounded-circle mb-3 border avatar-img" width="80" height="80" alt="{{ $artist->name }}">
                        <h6 class="fw-semibold mb-1">{{ $artist->name }}</h6>
                        <p class="text-muted small">{{ $artist->location ?? 'Unknown' }}</p>
                        <a href="{{ route('member.profile', $artist->id) }}" class="btn btn-sm gradient-outline-btn mt-2">View Profile</a>
                    </div>
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

<!-- Testimonials Section -->
<section class="testimonials-section py-5 bg-light border-top">
    <div class="container">
        <h2 class="mb-5 text-center fw-bold">What People Are Saying</h2>
        <div class="row g-4 text-center">
            @foreach($testimonials as $testimonial)
                <div class="col-md-4">
                    <blockquote class="testimonial-card p-4 bg-white shadow-sm position-relative h-100 rounded-4">
                        <p class="fst-italic mb-3">"{{ $testimonial->content }}"</p>
                        <footer class="fw-semibold text-muted">&mdash; {{ $testimonial->author }}</footer>
                        <div class="quote-deco">❝</div>
                    </blockquote>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
