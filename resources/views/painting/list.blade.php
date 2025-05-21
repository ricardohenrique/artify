@extends('layouts.app')

@section('title', $category->name . ' Paintings')

@section('content')
    <section class="container py-5">
        <h2 class="mb-4">Paintings in "{{ $category->name }}"</h2>

        <div class="row g-4">
            @foreach ($paintings as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>

        <div class="mt-4">
            {{ $paintings->links() }}
        </div>
    </section>
@endsection
