<!-- Fixed Artify Header -->
<header class="fixed-top bg-white border-bottom shadow-sm">
    <div class="container">
        <!-- Desktop layout (Logo | Search | User) -->
        <div class="d-none d-lg-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center me-3" href="/">
                <img src="{{ asset('Artify_web-new-version.png') }}" alt="Artify Logo" class="logo" style="height: 65px;">
            </a>

            <!-- Search -->
            <form action="{{ route('paintings.search') }}" method="GET" class="d-flex flex-grow-1 mx-3 menu-search-bar" role="search" style="max-width: 600px;">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="Search for art..." value="{{ request('q') }}">
                </div>
            </form>

            <!-- Desktop buttons -->
            <div class="d-flex align-items-center">
                @auth
                    <a href="{{ route('member.favorites', Auth::id()) }}" class="btn btn-light btn-icon btn-icon-header m-1" title="Favorites"><i class="bi bi-heart"></i></a>
                    <a href="{{ route('member.messages', Auth::id()) }}" class="btn btn-light btn-icon btn-icon-header m-1" title="Messages"><i class="bi bi-chat"></i></a>

                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle me-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('member.profile', Auth::user()->id) }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('member.settings', Auth::user()->id) }}">Account Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Log out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('item.new') }}" class="btn artify-btn">Sell now</a>
                @else
                    <a href="{{ route('register') }}" class="btn artify-btn-outline me-2">Sign up</a>
                    <a href="{{ route('login') }}" class="btn artify-btn-outline me-2">Log in</a>
                    <a href="{{ route('item.new') }}" class="btn artify-btn">Sell now</a>
                @endauth
            </div>
        </div>

        <!-- Mobile layout (Logo + burger) -->
        <div class="d-flex d-lg-none align-items-center justify-content-between row-01-mobile-header">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('Artify_web-new-version.png') }}" alt="Artify Logo" class="logo">
            </a>
            <button class="btn btn-mobile-menu" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false">
                <i class="bi bi-list fs-2"></i>
            </button>
        </div>

        <!-- Mobile search bar -->
        <div class="d-lg-none mb-2">
            <form action="{{ route('paintings.search') }}" method="GET" class="menu-search-bar" role="search">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="Search for art..." value="{{ request('q') }}">
                </div>
            </form>
        </div>

        <!-- Mobile menu collapse -->
        <div class="collapse d-lg-none" id="mobileMenu">
            <div class="py-3 d-lg-none border-top mobile-menu-items">
                <a href="{{ route('item.new') }}" class="d-block text-dark">Sell now</a>
                @auth
                    <a href="{{ route('member.profile', Auth::user()->id) }}" class="d-block text-dark">My Profile</a>
                    <a href="{{ route('member.settings', Auth::user()->id) }}" class="d-block text-dark">Account Settings</a>
                    <a href="{{ route('member.messages', Auth::user()->id) }}" class="d-block text-dark">Messages</a>
                    <a href="{{ route('member.favorites', Auth::user()->id) }}" class="d-block text-dark">Favorites</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="d-block text-dark">Logout</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="d-block text-dark">Sign up</a>
                    <a href="{{ route('login') }}" class="d-block text-dark">Log in</a>
                @endauth
                <span class="d-block mt-3">Menu</span>
                <a href="{{ route('paintings.explore') }}" class="d-block text-dark">Explore</a>
                @foreach ($headerCategories as $category)
                    <a href="{{ route('paintings.list', $category->slug) }}" class="d-block text-dark">{{ $category->name }}</a>
                @endforeach
                <a href="{{ route('about-us') }}" class="d-block text-dark">About Us</a>
                <a href="{{ route('artist.index') }}" class="d-block text-dark">Artists</a>
            </div>
        </div>
    </div>

    <!-- Scrollable Categories -->
    <div class="bg-light border-top menu-category overflow-auto">
        <div class="d-none container d-lg-flex flex-nowrap overflow-auto px-3">
            <a href="{{ route('paintings.explore') }}" class="me-4 py-3 category-link">Explore</a>
            @foreach ($headerCategories as $category)
                <a href="{{ route('paintings.list', $category->slug) }}" class="me-4 py-3 category-link">{{ $category->name }}</a>
            @endforeach
            <a href="{{ route('about-us') }}" class="me-4 py-3 category-link">About Us</a>
            <a href="{{ route('artist.index') }}" class="me-4 py-3 category-link">Artists</a>
        </div>
    </div>
</header>
