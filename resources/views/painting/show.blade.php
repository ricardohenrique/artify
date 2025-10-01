@extends('layouts.app')

@section('title', $painting->title)

@section('style')
<link href="{{ asset('css/painting-show.css') }}" rel="stylesheet">
@endsection

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
                    <div class="mb-3 position-relative">
                        <img
                            id="main-image"
                            src="{{ Storage::url($mainImage->path) }}"
                            alt="{{ $painting->title }}"
                            class="img-fluid rounded border"
                            style="height: 500px; width: 100%; object-fit: contain; background-color: #f8f9fa;"
                        >
                        <livewire:like-button :painting="$painting" positionTop=0 />
                    </div>

                    <!-- Thumbnails -->
                    @if ($painting->images->count() > 1)
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($painting->images as $img)
                                <img src="{{ Storage::url($img->path) }}"
                                     alt="Thumbnail"
                                     class="img-thumbnail thumb-image"
                                     style="height: 80px; width: 80px; object-fit: cover; cursor: pointer;">
                            @endforeach
                        </div>
                    @endif
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid rounded border" alt="No image">
                @endif
                @if ($painting->orientation || $painting->material || $painting->dimensions || $painting->year_created || $painting->availability || $painting->colors->count() || $painting->tags->count())
                    <div class="mt-4 p-4 bg-white border rounded shadow-sm">
                        <h5 class="fw-semibold mb-3">Artwork Details</h5>
                        <dl class="row mb-0 text-muted">
                            @if ($painting->material)
                                <dt class="col-sm-4">Material</dt>
                                <dd class="col-sm-8">{{ $painting->material }}</dd>
                            @endif
                            @if ($painting->dimensions)
                                <dt class="col-sm-4">Dimensions</dt>
                                <dd class="col-sm-8">{{ $painting->dimensions }}</dd>
                            @endif
                            @if ($painting->orientation)
                                <dt class="col-sm-4">Orientation</dt>
                                <dd class="col-sm-8 text-capitalize">{{ $painting->orientation }}</dd>
                            @endif
                            @if ($painting->year_created)
                                <dt class="col-sm-4">Year</dt>
                                <dd class="col-sm-8">{{ $painting->year_created }}</dd>
                            @endif
                            @if ($painting->availability)
                                <dt class="col-sm-4">Availability</dt>
                                <dd class="col-sm-8 text-capitalize">{{ str_replace('_', ' ', $painting->availability) }}</dd>
                            @endif
                            @if ($painting->colors->count())
                                <dt class="col-sm-4">Colors</dt>
                                <dd class="col-sm-8">
                                    @foreach ($painting->colors as $color)
                                        <span class="badge border" style="background-color: {{ $color->hex_code }};">&nbsp;</span>
                                        <span class="me-2">{{ $color->name }}</span>
                                    @endforeach
                                </dd>
                            @endif
                            @if ($painting->tags->count())
                                <dt class="col-sm-4">Tags</dt>
                                <dd class="col-sm-8">
                                    @foreach ($painting->tags as $tag)
                                        <span class="badge bg-secondary me-1">#{{ $tag->name }}</span>
                                    @endforeach
                                </dd>
                            @endif
                        </dl>
                    </div>
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

                        @guest
                            <a href="#" class="btn btn-outline-primary requires-auth">Ask Seller</a>
                            <a href="#" class="btn btn-outline-danger requires-auth">
                                <i class="bi bi-heart"></i> Add to Favorites
                            </a>
                        @else
                            <form method="POST" action="{{ route('messages.ask', $painting) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary w-100">Ask Seller</button>
                            </form>
                            <livewire:like-button :painting="$painting" buttonType="button" />
                        @endguest
                    </div>
                </div>

                <!-- Creator Info -->
                <div class="border rounded p-4 bg-white shadow-sm">
                    <a href="{{ route('artist.show', $painting->user->slug) }}" class="text-decoration-none text-dark">
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
                    </a>

                    <livewire:follow-button :user="$painting->user" buttonClass="w-100" />
                </div>
            </div>
        </div>
    </section>
    @if ($relatedPaintings->count())
        <section class="container pb-5 related-paintings-section">
            <div class="section-divider"></div>
            <h4 class="related-title mb-2">More from this artist</h4>

            <div class="row g-4">
                @foreach ($relatedPaintings as $related)
                    @include('components.painting-card', ['painting' => $related])
                @endforeach
            </div>
        </section>
    @endif
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
        });
    </script>
@endsection
