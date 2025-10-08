@extends('layouts.app')

@section('title', 'Your Dashboard')

@section('content')
<section class="bg-light py-5">
    <div class="container">
        @include('partials.profile.header')

        <div class="row">
            @include('partials.profile.sidebar')

            <!-- Dashboard Content -->
            <div class="col-md-9">
                <div class="bg-white rounded shadow-sm p-4 mb-4">
                    <div class="text-center mb-5">
                        <a href="{{ route('item.new') }}" class="btn btn-primary btn-lg px-5 py-3 fs-5">
                            + Add New Painting
                        </a>
                    </div>

                    <!-- 🎨 Published Paintings -->
                    <div class="mb-5">
                        <h4 class="mb-4">🎨 Your Published Paintings</h4>

                        @if($paintings->isEmpty())
                            <p class="text-muted">You haven't published any paintings yet.</p>
                        @else
                            <div class="row g-4">
                                @foreach($paintings as $painting)
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('item.edit', $painting->id) }}" class="text-decoration-none text-dark">
                                            <div class="product-card p-3 h-100 border rounded">
                                                <h5 class="mb-1">{{ $painting->title }}</h5>
                                                <p class="text-muted mb-0">${{ number_format($painting->price, 2) }}</p>
                                                <small class="text-muted">{{ ucfirst($painting->category->name) }}</small>
                                                <span class="badge text-bg-info mt-2">Published</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- 📝 Draft Paintings -->
                    <div>
                        <h4 class="mb-4">📝 Drafts</h4>

                        @if($drafts->isEmpty())
                            <p class="text-muted">No drafts saved yet.</p>
                        @else
                            <div class="row g-4">
                                @foreach($drafts as $draft)
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('item.edit', $draft->id) }}" class="text-decoration-none text-dark">
                                            <div class="product-card p-3 h-100 border border-warning rounded">
                                                <h5 class="mb-1">{{ $draft->title ?? '(Untitled)' }}</h5>
                                                <p class="text-muted mb-0">
                                                    {{ $draft->price ? '$' . number_format($draft->price, 2) : 'No price set' }}
                                                </p>
                                                <small class="text-muted">
                                                    {{ $draft->category->name ?? 'No category' }}
                                                </small>
                                                <span class="badge bg-warning text-dark mt-2">Draft</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
