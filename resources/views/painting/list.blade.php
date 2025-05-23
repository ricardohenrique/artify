@extends('layouts.app')

@section('title', $category->name . ' Paintings')

@section('content')
    <section class="container py-5">
        <x-page-heading
            title="Independent artists, :highlight paintings"
            :highlight="$category->name"
        />

        <!-- Filter Bar -->
        <div class="filter-bar d-flex flex-wrap align-items-center justify-content-between gap-3 py-3 border-top border-bottom mb-4">
            <!-- Filter buttons -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <!-- Category Filter -->
                <div class="filter-chip dropdown">
                    <button class="btn filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Category
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                            href="{{ route('paintings.explore') }}">All</a>
                        </li>
                        @foreach ($categories as $cat)
                            <li>
                                <a class="dropdown-item {{ $cat->id === $category->id ? 'active' : '' }}"
                                    href="{{ route('paintings.list', $cat->slug) }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="filter-chip dropdown">
                    <button class="btn filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Price
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['price' => 'between-0-100']) }}">Under $100</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['price' => 'between-100-500']) }}">$100 - $500</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['price' => 'between-500-5000']) }}">Above $500</a></li>
                    </ul>
                </div>

                <div class="filter-chip dropdown">
                    <button class="btn filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Size
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Small</a></li>
                        <li><a class="dropdown-item" href="#">Medium</a></li>
                        <li><a class="dropdown-item" href="#">Large</a></li>
                    </ul>
                </div>

                @php
                    $query = request()->query();
                @endphp

                @if($category && $categories->contains('id', $category->id))
                    <span class="active-filter">
                        {{ $category->name }}
                        <a href="{{ route('paintings.explore') }}?{{ http_build_query(Arr::except($query, ['price', 'sort'])) }}" class="ms-1 text-decoration-none">✕</a>
                    </span>
                @endif

                @if(request('price'))
                    <span class="active-filter">
                        Price: {{ ucwords(str_replace('-', ' ', request('price'))) }}
                        <a href="{{ url()->current() }}?{{ http_build_query(Arr::except($query, ['price'])) }}" class="ms-1 text-decoration-none">✕</a>
                    </span>
                @endif

                @if(request('sort'))
                    <span class="active-filter">
                        Sort: {{ ucwords(str_replace('-', ' ', request('sort'))) }}
                        <a href="{{ url()->current() }}?{{ http_build_query(Arr::except($query, ['sort'])) }}" class="ms-1 text-decoration-none">✕</a>
                    </span>
                @endif
            </div>

            <!-- Sort Dropdown -->
            <div class="dropdown ms-auto">
                <button class="btn filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Sort by
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item {{ $selectedSort === 'newest' ? 'active' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
                            Newest
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ $selectedSort === 'cheap' ? 'active' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['sort' => 'cheap']) }}">
                            Price: Low to High
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ $selectedSort === 'liked' ? 'active' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['sort' => 'liked']) }}">
                            Most Liked
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row g-4">
            @foreach ($paintings as $painting)
                @include('components.painting-card', ['painting' => $painting])
            @endforeach
        </div>

        @if ($paintings->hasPages())
            <div class="mt-5 text-center">
                <div class="text-muted mb-2">
                    Showing <strong>{{ $paintings->firstItem() }}</strong> to <strong>{{ $paintings->lastItem() }}</strong> of <strong>{{ $paintings->total() }}</strong> results
                </div>
                <div class="d-inline-block">
                    {{ $paintings->links() }}
                </div>
            </div>
        @endif
    </section>
    <style>
        /* Filter bar container */
        .filter-bar {
            border-color: #e9ecef;
            background-color: #fff;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }

        /* Filter button styling */
        .filter-btn {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 16px;
            transition: background 0.2s ease;
        }

        .filter-btn:hover {
            background: #ffedf3;
            border-color: #ff4e9b;
            color: #ff4e9b;
        }

        /* Active filter badge */
        .active-filter {
            background: #e9ecef;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 13px;
            margin-left: 0.5rem;
        }

        /* Optional: custom dropdown menu spacing */
        .dropdown-menu {
            font-size: 14px;
            border-radius: 8px;
        }
    </style>
@endsection
