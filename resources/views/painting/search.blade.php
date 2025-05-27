@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
<section class="container py-5">
    <x-page-heading
        title="Search results for: :highlight"
        :highlight="$query"
        :emphasize="true"
    />

    @if ($paintings->count())
        <div class="row g-4">
            @foreach ($paintings as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>

        @if ($paintings->hasPages())
            <x-pagination-custom :items="$paintings" />
        @endif
    @else
        <p>No paintings found matching your search.</p>
    @endif
</section>
@endsection
