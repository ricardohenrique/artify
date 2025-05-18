@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <!-- Welcome Box -->
        <div class="p-5 bg-white shadow rounded mb-4">
            <h1 class="h3 mb-3">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">You're logged in to your dashboard.</p>
        </div>

        <!-- User Paintings -->
        <div class="bg-white p-4 rounded shadow-sm">
            <h4 class="mb-4">🎨 Your Paintings</h4>

            @if($paintings->isEmpty())
                <p class="text-muted">You haven't listed any paintings yet.</p>
            @else
                <div class="row g-4">
                    @foreach($paintings as $painting)
                        <div class="col-md-4">
                            <div class="product-card p-3 h-100">
                                {{-- <img src="https://t3.ftcdn.net/jpg/02/73/22/74/360_F_273227473_N0WRQuX3uZCJJxlHKYZF44uaJAkh2xLG.jpg"
                                     class="img-fluid mb-2 rounded"
                                     alt="{{ $painting->title }}"> --}}
                                <h5 class="mb-1">{{ $painting->title }}</h5>
                                <p class="text-muted mb-0">${{ number_format($painting->price, 2) }}</p>
                                <small class="text-muted">{{ ucfirst($painting->category) }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endsection