@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
<section class="container py-5">
    <h2 class="mb-4">Search results for: <em>{{ $query }}</em></h2>

    @if ($paintings->count())
        <div class="row g-4">
            @foreach ($paintings as $painting)
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 position-relative">
                        <div class="position-relative">
                            <a href="{{ route('paintings.show', [
                                'category_slug' => $painting->category->slug,
                                'painting_slug' => $painting->slug
                            ]) }}">
                                <img src="{{ asset('storage/' . optional($painting->images->first())->path ?? 'images/placeholder.jpg') }}"
                                    class="card-img-top" style="aspect-ratio: 3/4; object-fit: cover;" alt="{{ $painting->title }}">
                            </a>
                            @auth
                                <form method="POST" action="{{ route('paintings.favorite', $painting) }}"
                                    class="position-absolute top-0 end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm"
                                    style="border: none;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent d-flex align-items-center" title="Toggle favorite">
                                        @if(auth()->user()->favorites->contains($painting->id))
                                            <i class="bi bi-heart-fill me-1 text-danger"></i>
                                        @else
                                            <i class="bi bi-heart me-1 text-danger"></i>
                                        @endif

                                        @if ($painting->favorited_by_count > 0)
                                            <span class="small fw-semibold">{{ $painting->favorited_by_count }}</span>
                                        @endif
                                    </button>
                                </form>
                            @else
                                <a href="#" class="text-decoration-none text-dark position-absolute top-0 end-0 m-2 bg-white px-2 py-1 rounded-pill d-flex align-items-center shadow-sm requires-auth">
                                    <i class="bi bi-heart me-1 text-danger"></i>
                                    @if ($painting->favorited_by_count > 0)
                                        <span class="small fw-semibold">{{ $painting->favorited_by_count }}</span>
                                    @endif
                                </a>
                            @endauth
                        </div>

                        <div class="card-body px-2 py-3">
                            <div class="fw-semibold small text-muted">{{ $painting->title }}</div>
                            <div class="text-muted small">{{ $painting->category->name ?? '' }}</div>

                            <div class="mt-1 fw-semibold text-dark">
                                ${{ number_format($painting->price, 2) }}
                            </div>
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