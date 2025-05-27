@extends('layouts.app')

@section('title', 'Your Favorites')

@section('content')
    <section class="container py-5">
        <x-page-heading title="Your Favorite Paintings" />

        @if($favorites->count())
            <div class="row g-4">
                @foreach ($favorites as $painting)
                    @include('components.painting-card', ['painting' => $painting])
                @endforeach
            </div>

            @if ($favorites->hasPages())
                <x-pagination-custom :items="$favorites" />
            @endif
        @else
            <p class="text-muted">You haven’t favorited any paintings yet.</p>
        @endif
    </section>
@endsection
