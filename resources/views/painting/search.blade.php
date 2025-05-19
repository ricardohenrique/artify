@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
<section class="container py-5">
    <h2 class="mb-4">Search results for: <em>{{ $query }}</em></h2>

    @if ($paintings->count())
        <div class="row g-4">
            @foreach ($paintings as $painting)
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <a href="{{ route('paintings.show', [
                            'category_slug' => $painting->category->slug,
                            'painting_slug' => $painting->slug
                        ]) }}">
                            <img src="{{ asset('storage/' . optional($painting->images->first())->path ?? 'images/placeholder.jpg') }}"
                                 class="card-img-top" style="height: 300px; object-fit: contain;" alt="{{ $painting->title }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $painting->title }}</h5>
                            <p class="card-text text-muted">${{ number_format($painting->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $paintings->links() }}
        </div>
    @else
        <p>No paintings found matching your search.</p>
    @endif
</section>
@endsection