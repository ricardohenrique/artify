@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')
<section class="bg-light py-5">
    <div class="container">
        <!-- Profile Header -->
        <div class="bg-white p-4 rounded shadow-sm d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <!-- Avatar -->
                <div class="me-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ff6a00&color=fff"
                         alt="Avatar" class="rounded-circle" style="width: 80px; height: 80px;">
                </div>
                <!-- Info -->
                <div>
                    <h4 class="mb-0">{{ $user->name }} <small class="text-muted">{{'@' . $user->username}}</small></h4>
                    <div class="text-muted small">
                        <i class="bi bi-geo-alt me-1"></i>{{ $user->location ?? 'Location not set' }}<br>
                        <i class="bi bi-clock me-1"></i>Last seen {{ $user->updated_at->diffForHumans() }}<br>
                        <i class="bi bi-people me-1"></i>
                        <a href="#" class="text-decoration-none">{{ $user->followers_count }} followers</a>,
                        <a href="#" class="text-decoration-none">{{ $user->following_count }} following</a>
                    </div>
                </div>
            </div>

            @auth
                @if(Auth::id() === $user->id)
                    <a href="{{ route('member.edit', $user->id) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-pencil me-1"></i>Edit profile
                    </a>
                @endif
            @endauth
        </div>
        <!-- Profile Sub-Navigation -->
        <div class="bg-white border-top border-bottom py-2 mb-4">
            <div class="container d-flex gap-4 align-items-center">
                <a href="#" class="fw-semibold text-dark text-decoration-none">Profile</a>
                <a href="#" class="text-muted text-decoration-none">Account settings</a>
                <a href="#" class="text-muted text-decoration-none">Privacy Center</a>
                <a href="#" class="text-muted text-decoration-none">Orders</a>
                <a href="#" class="text-muted text-decoration-none">Messages</a>
            </div>
        </div>

        <!-- Profile Body -->
        <div class="row">
            <!-- Left Menu -->
            <div class="col-md-3">
                <div class="list-group shadow-sm">
                    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        Profile summary
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">Your favorite artworks ({{ $user->favorites_count }})</a>
                    <a href="#" class="list-group-item list-group-item-action">Artists you follow ({{ $user->following_count }})</a>
                </div>
            </div>

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