@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center mb-4">
            <!-- Avatar -->
            <div class="col-auto">
                <div class="rounded-circle bg-secondary" style="width: 80px; height: 80px; background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ff6a00&color=fff'); background-size: cover;"></div>
            </div>

            <!-- User Info -->
            <div class="col">
                <h2 class="mb-0">{{ $user->name }}</h2>
                <p class="text-muted mb-1">Joined {{ $user->created_at->diffForHumans() }}</p>
                <span class="badge bg-success">Verified Member</span>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h5>About</h5>
                    <p>{{ $user->bio ?? 'This user hasn’t added a bio yet.' }}</p>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h5>Contact</h5>
                    <ul class="list-unstyled mb-0">
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        {{-- Add other contact fields if needed --}}
                    </ul>
                </div>
            </div>
        </div>

        <!-- Listings (optional section for future) -->
        {{-- <div class="mt-5">
            <h4>{{ $user->name }}'s Listings</h4>
            <p>Coming soon: display their posted artworks here.</p>
        </div> --}}
    </div>
</section>
@endsection