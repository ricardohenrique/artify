<!-- Fixed Artify Header -->
<header class="fixed-top bg-white border-bottom shadow-sm">
    <div class="container">
        <!-- Top Row -->
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center me-3" href="/">
                {{-- <img src="{{ asset('artify-logo-opt.png') }}" alt="Artify Logo" class="logo me-2" style="height: 40px;"> --}}
                <img src="{{ asset('artify_navbar-04.png') }}" alt="Artify Logo" class="logo me-2" style="height: 40px;">
            </a>

            <!-- Search -->
            <form action="{{ route('paintings.search') }}" method="GET" class="d-flex flex-grow-1 mx-3 menu-search-bar" role="search" style="max-width: 600px;">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="Search for art..." aria-label="Search" value="{{ request('q') }}">
                </div>
            </form>

            <!-- Buttons -->
            <div class="d-flex align-items-center">
                @auth
                    <!-- Favorites Icon (Font Awesome) -->
                    <a href="{{ route('member.favorites', Auth::id()) }}"
                    class="btn btn-light btn-icon btn-icon-header p-2 m-1 d-flex align-items-center justify-content-center"
                    title="Favorites">
                        <i class="bi bi-heart"></i>
                    </a>

                    <!-- Messages Icon (Font Awesome) -->
                    <a href="{{ route('member.messages', Auth::id()) }}"
                    class="btn btn-light btn-icon btn-icon-header p-2 m-1 d-flex align-items-center justify-content-center"
                    title="Messages">
                        <i class="bi bi-chat"></i>
                    </a>
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle me-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
{{--                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>--}}
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
    </div>

    <div class="bg-light border-top menu-category">
        <div class="container d-flex flex-wrap justify-content-start ">
            <a href="{{ route('paintings.explore') }}" class="me-4 py-3 category-link">Explore</a>
            @foreach ($headerCategories as $category)
                <a href="{{ route('paintings.list', $category->slug) }}" class="me-4 py-3 category-link">{{ $category->name }}</a>
            @endforeach
            <a href="{{ route('about-us') }}" class="me-4 py-3 category-link">About Us</a>
            <a href="{{ route('artist.index') }}" class="me-4 py-3 category-link">Artists</a>
        </div>
    </div>
</header>

<!-- Spacer for fixed header -->
{{-- <div style="height: 130px;"></div> --}}
