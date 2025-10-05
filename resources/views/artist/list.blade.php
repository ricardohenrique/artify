@extends('layouts.app')

@section('title', 'Meet the Artists')

@section('meta')
    <meta name="robots" content="index, follow">
@endsection

@section('title', 'Artify | Independent Artists')
@section('description', 'Meet talented independent artists from around the world. Explore their profiles, discover their stories, and follow your favorite creators on Artify.')
@section('keywords', 'independent artists, artist profiles, meet artists, art creators, online artist community, emerging artists, contemporary artists, follow artists, discover art talent, artist gallery
')


@section('content')
    <section class="container py-5">
        <h2 class="artist-list-heading">Independent Artists</h2>

        <div class="row g-4">
            @forelse($artists as $artist)
                <div class="col-md-3 col-sm-6">
                    <div class="artist-card h-100">
                        <a href="{{ route('artist.show', $artist->slug) }}" class="text-decoration-none text-dark">
                            <img src="{{ $artist->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($artist->name) }}"
                                alt="{{ $artist->name }}">
                
                            <div class="artist-card-body">
                                <h5>{{ $artist->name }}</h5>
                                <div class="text-muted">{{ $artist->location ?? 'Unknown location' }}</div>
                                <div class="d-flex flex-wrap artist-meta">
                                    <div><i class="bi bi-image"></i> {{ $artist->paintings_count }} artworks</div>
                                    <div><i class="bi bi-people"></i> {{ $artist->followers_count }} followers</div>
                                </div>
                            </div>
                        </a>
                        <div class="artist-follow">
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

    <style>
        /* ---------------------- Artist List Page ---------------------- */
        .artist-card {
            border-radius: 20px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background-color: #fff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .artist-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        }

        .artist-card img {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            object-fit: cover;
            aspect-ratio: 1/1;
            width: 100%;
        }

        .artist-card-body {
            padding: 1rem 1.25rem;
        }

        .artist-card-body h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #333;
        }

        .artist-card-body .text-muted {
            font-size: 0.9rem;
        }

        .artist-meta {
            font-size: 0.85rem;
            gap: 1rem;
            color: #777;
            margin-top: 0.5rem;
        }

        .artist-follow {
            padding: 0 1.25rem 1rem;
            margin-top: auto;
        }

        /* Page heading */
        .artist-list-heading {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #333;
            border-left: 4px solid #ff4e9b66;
            padding-left: 0.75rem;
        }
    </style>
@endsection
