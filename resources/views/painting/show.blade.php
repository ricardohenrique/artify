@extends('layouts.app')

@section('title', $painting->title)

@section('content')
    <section class="container py-5">
        <div class="row g-5">

            <!-- Images -->
            <div class="col-md-6">
                @if ($painting->images->count())
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $painting->images->first()->path) }}"
                             alt="{{ $painting->title }}" class="img-fluid rounded border" style="object-fit: cover; max-height: 500px; width: 100%;">
                    </div>

                    @if ($painting->images->count() > 1)
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($painting->images->slice(1) as $img)
                                <img src="{{ asset('storage/' . $img->path) }}"
                                     alt="Extra image"
                                     class="img-thumbnail"
                                     style="height: 80px; width: 80px; object-fit: cover;">
                            @endforeach
                        </div>
                    @endif
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid rounded border" alt="No image">
                @endif
            </div>

            <!-- Details -->
            <div class="col-md-6">
                <h1 class="h4 fw-bold">{{ $painting->title }}</h1>
                <p class="text-muted mb-1">{{ $painting->category->name ?? 'Uncategorized' }}</p>
                <h3 class="text-primary fw-bold">${{ number_format($painting->price, 2) }}</h3>

                <p class="mt-3">{{ $painting->description }}</p>

                <div class="mt-4 d-flex align-items-center">
                    <form method="POST" action="{{ route('paintings.favorite', $painting) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger me-2">
                            <i class="bi bi-heart"></i> Add to favorites
                        </button>
                    </form>

                    <a href="#" class="btn btn-artify">Buy Now</a>
                </div>

                <hr class="my-4">

                <div class="text-muted small">
                    Listed by <strong>{{ $painting->user->name }}</strong>
                </div>
            </div>
        </div>
    </section>
@endsection
