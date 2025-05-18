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
                    <a href="#" class="btn artify-btn w-100 mb-3">Sell now</a>
                    <div class="text-center">
                        <a href="#" class="">Learn how it works</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Grid -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">Featured Artworks</h2>
        <div class="row g-4">
            @forelse($paintings as $painting)
                <div class="col-md-4">
                    <div class="product-card p-3">
                        <img src="https://t3.ftcdn.net/jpg/02/73/22/74/360_F_273227473_N0WRQuX3uZCJJxlHKYZF44uaJAkh2xLG.jpg" class="img-fluid mb-2" alt="{{ $painting->title }}">
                        <h5 class="mb-1">{{ $painting->title }}</h5>
                        <p class="text-muted">${{ number_format($painting->price, 2) }}</p>
                    </div>
                </div>
            @empty
                <p>No artworks available at the moment.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection