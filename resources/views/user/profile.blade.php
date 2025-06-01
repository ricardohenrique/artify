@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')
<section class="bg-light py-5">
    <div class="container">
        @include('partials.profile.header')

        <div class="row">
            @include('partials.profile.sidebar')
            
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="row">
                    <!-- Favorite Artworks -->
                    <div class="col-md-6 mb-4">
                        <div class="bg-white rounded shadow-sm p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">Your favorite artworks</h5>
                                <a href="#" class="text-decoration-none small">View all</a>
                            </div>
                            <div class="row g-2">
                                @forelse($user->favorites->take(6) as $painting)
                                    <div class="col-4">
                                        <a href="{{ route('paintings.show', [$painting->category->slug, $painting->slug]) }}"
                                        class="d-block bg-light rounded overflow-hidden" style="aspect-ratio: 1 / 1;">
                                            @if($painting->images->first())
                                                <img src="{{ asset('storage/' . $painting->images->first()->path) }}"
                                                    alt="{{ $painting->title }}"
                                                    class="w-100 h-100 object-fit-cover">
                                            @endif
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small">No favorite artworks yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Followed Artists -->
                    <div class="col-md-6 mb-4">
                        <div class="bg-white rounded shadow-sm p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">Artists you follow</h5>
                                <a href="#" class="text-decoration-none small">View all</a>
                            </div>
                            <div class="row g-2">
                                @forelse($user->following->take(6) as $followed)
                                    <div class="col-4">
                                        <a href="{{ route('artist.show', $followed->slug) }}"
                                           class="d-block rounded bg-light overflow-hidden position-relative"
                                           style="aspect-ratio: 1 / 1;">
                                            <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center p-2 text-center">
                                                <div class="rounded-circle mb-2"
                                                     style="width: 50px; height: 50px; background-image: url('https://ui-avatars.com/api/?name={{ urlencode($followed->name) }}&background=999&color=fff'); background-size: cover;">
                                                </div>
                                                <small class="text-muted d-block text-truncate w-100">{{ '@' . $followed->username }}</small>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small">You’re not following anyone yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- About -->
                    <div class="col-12">
                        <div class="bg-white rounded shadow-sm p-3">
                            <h5>About</h5>
                            <p class="mb-2">{{ $user->bio ?? 'No bio provided yet.' }}</p>
                            @if ($user->website_url)
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-link-45deg me-1"></i>
                                    <a href="{{ $user->website_url }}" target="_blank">{{ $user->website_url }}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection