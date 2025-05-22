@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <!-- Profile Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <!-- Avatar -->
                <div class="me-3">
                    <div class="rounded-circle bg-secondary" style="width: 80px; height: 80px; background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ff6a00&color=fff'); background-size: cover;"></div>
                </div>

                <!-- User Info -->
                <div>
                    <h3 class="mb-1">
                        {{ $user->name }}
                        <small class="text-muted ms-2">@ {{ $user->username }}</small>
                    </h3>

                    <div class="mb-2 text-muted small">
                        <i class="bi bi-geo-alt-fill me-1"></i>
                        {{ $user->location ?? 'Location not set' }}
                    </div>

                    <div class="mb-1 text-muted small">
                        <i class="bi bi-clock me-1"></i>
                        Last seen {{ $user->updated_at->diffForHumans() }}
                    </div>

                    <div class="text-muted small">
                        <i class="bi bi-people me-1"></i>
                        <a href="#" class="text-decoration-none">{{ $user->followers_count }} followers</a>,
                        <a href="#" class="text-decoration-none">{{ $user->following_count }} following</a>
                    </div>
                </div>
            </div>

            @auth
                @if(Auth::id() === $user->id)
                    <!-- Edit Button -->
                    <a href="{{ route('member.edit', $user->id) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-pencil"></i> Edit profile
                    </a>
                @else
                    <!-- Follow/Unfollow Button -->
                    <form action="{{ route('users.follow', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">
                            @if(auth()->user()->following->contains($user->id))
                                <i class="bi bi-person-check"></i> Following
                            @else
                                <i class="bi bi-person-plus"></i> Follow
                            @endif
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        <!-- Profile Details -->
        <div class="row">
            <!-- About -->
            <div class="col-md-6 mb-4">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h5>About</h5>
                    <p class="mb-1">{{ $user->bio ?? 'This user hasn’t added a bio yet.' }}</p>
                    @if($user->website_url)
                        <p class="mb-0 text-muted">
                            <i class="bi bi-link-45deg me-1"></i>
                            <a href="{{ $user->website_url }}" target="_blank">{{ $user->website_url }}</a>
                        </p>
                    @endif
                </div>
            </div>

            <!-- Verified Info -->
            <div class="col-md-6 mb-4">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h5>Verified Info</h5>
                    <ul class="list-unstyled mb-0 text-muted small">
                        <li><i class="bi bi-check-circle-fill text-success me-1"></i>Email verified</li>
                        {{-- Add Google/Facebook if applicable --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
