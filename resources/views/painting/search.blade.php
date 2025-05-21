@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
<section class="container py-5">
    <h2 class="mb-4">Search results for: <em>{{ $query }}</em></h2>

    @if ($paintings->count())
        <div class="row g-4">
            @foreach ($paintings as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>

        @if ($paintings->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $paintings->links() }}
            </div>
        @endif
    @else
        <p>No paintings found matching your search.</p>
    @endif
</section>
@endsection