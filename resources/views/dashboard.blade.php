@extends('layouts.app')

@section('meta')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('title', 'Dashboard')

@section('content')
<section class="py-5 bg-light">
    <div class="container">

        <!-- Welcome Box -->
        {{-- <div class="p-5 bg-white shadow rounded mb-4">
            <h1 class="h3 mb-3">Welcome, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">You're logged in to your dashboard.</p>
        </div> --}}

        <!-- Published Paintings -->
        <div class="bg-white p-4 rounded shadow-sm mb-4">
            <h4 class="mb-4">🎨 Your Published Paintings</h4>

            @if($paintings->isEmpty())
                <p class="text-muted">You haven't published any paintings yet.</p>
            @else
                <div class="row g-4">
                    @foreach($paintings as $painting)
                        <div class="col-md-4">
                            <a href="{{ route('item.edit', $painting->id) }}" class="text-decoration-none text-dark">
                                <div class="product-card p-3 h-100 border rounded">
                                    <h5 class="mb-1">{{ $painting->title }}</h5>
                                    <p class="text-muted mb-0">${{ number_format($painting->price, 2) }}</p>
                                    <small class="text-muted">{{ ucfirst($painting->category->name) }}</small>
                                    <span class="badge text-bg-info">Published</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Drafts -->
        <div class="bg-white p-4 rounded shadow-sm">
            <h4 class="mb-4">📝 Drafts</h4>

            @if($drafts->isEmpty())
                <p class="text-muted">No drafts saved yet.</p>
            @else
                <div class="row g-4">
                    @foreach($drafts as $draft)
                        <div class="col-md-4">
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
</section>
@endsection
