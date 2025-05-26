@extends('layouts.app')

@section('title', 'Meet the Artists')

@section('content')
    <section class="container py-5">
        <h2 class="mb-4">Independent Artists</h2>

        <div class="row g-4">
            @forelse($artists as $artist)
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <a href="{{ route('artist.show', $artist->slug) }}" class="text-decoration-none text-dark">
                            <img src="{{ $artist->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($artist->name) }}"
                                 alt="{{ $artist->name }}"
                                 class="card-img-top" style="aspect-ratio: 1/1; object-fit: cover;">

                            <div class="card-body px-3 py-3">
                                <h5 class="fw-semibold mb-1">{{ $artist->name }}</h5>
                                <div class="text-muted small mb-2">{{ $artist->location ?? 'Unknown location' }}</div>
                                <div class="d-flex flex-wrap small text-muted gap-3">
                                    <div><i class="bi bi-image"></i> {{ $artist->paintings_count }} artworks</div>
                                    <div><i class="bi bi-people"></i> {{ $artist->followers_count }} followers</div>
                                </div>
                            </div>
                        </a>
                        <div class="px-3 pb-3">
                            {{-- <x-follow-button :user="$artist" class="w-100" /> --}}
                            <livewire:follow-button :user="$artist" buttonClass="w-100" />
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-person-x" style="font-size: 3rem; color: #ff6a00;"></i>
                    <h5 class="fw-semibold mt-3 mb-1">No artists found</h5>
                    <p class="text-muted">Check back later or explore paintings directly.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-5 text-center">
            {{ $artists->links() }}
        </div>
    </section>
@endsection
