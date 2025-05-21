@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- Hero Section with Background Image and Overlay Box -->
<section class="hero-sell position-relative d-flex align-items-center">
    <div class="container">
        <div class="row">
            <!-- Callout Box -->
            <div class="col-md-6">
                <div class="bg-white p-5 rounded shadow" style="max-width: 420px;">
                    <h2 class="fw-bold mb-3">Ready to share your art with the world?</h2>
                    <a href="{{ route('item.new') }}" class="btn artify-btn w-100 mb-3">Sell now</a>
                    <div class="text-center">
                        <a href="#" class="">Learn how it works</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Most Liked -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="mb-4">Most Liked</h2>
        <div class="row g-4">
            @foreach($mostLiked as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>
    </div>
</section>

<!-- Most Recent -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">Most Recent</h2>
        <div class="row g-4">
            @foreach($mostRecent as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>
    </div>
</section>
@endsection