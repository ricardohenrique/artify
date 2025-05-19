@extends('layouts.app')

@section('title', $category->name . ' Paintings')

@section('content')
    <section class="container py-5">
        <h2 class="mb-4">Paintings in "{{ $category->name }}"</h2>

        <div class="row g-4">
            @forelse ($paintings as $painting)
                <div class="col-md-4">
                    <div class="card h-100">
                        @php
                            $image = $painting->images->first();
                            $imageUrl = $image ? asset('storage/' . $image->path) : asset('storage/placeholder.jpg');
                        @endphp

                        <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $painting->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $painting->title }}</h5>
                            <p class="card-text">${{ number_format($painting->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>No paintings found in this category.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $paintings->links() }}
        </div>
    </section>
@endsection
