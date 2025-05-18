<!-- Fixed Artify Header -->
<header class="fixed-top bg-white border-bottom shadow-sm">
    <div class="container">
        <!-- Top Row -->
        <div class="d-flex flex-wrap align-items-center justify-content-between py-2">
            <a class="navbar-brand d-flex align-items-center me-3" href="/">
                <img src="{{ asset('artify-logo.png') }}" alt="Artify Logo" class="logo me-2" style="height: 40px;">
            </a>

            <!-- Search -->
            <form class="d-flex flex-grow-1 mx-3 menu-search-bar" role="search" style="max-width: 600px;">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search for art" aria-label="Search">
                </div>
            </form>

            <!-- Buttons -->
            <div class="d-flex align-items-center">
                @auth
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle me-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('member.profile', Auth::user()->id) }}">My Profile</a></li>
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
        <div class="container d-flex flex-wrap justify-content-start py-2">
            <a href="#" class="me-4 category-link">Abstract</a>
            <a href="#" class="me-4 category-link">Realism</a>
            <a href="#" class="me-4 category-link">Impressionism</a>
            <a href="#" class="me-4 category-link">Surrealism</a>
            <a href="#" class="me-4 category-link">Expressionism</a>
            <a href="{{ route('about-us') }}" class="me-4 category-link">About Us</a>
        </div>
    </div>
</header>

<!-- Spacer for fixed header -->
{{-- <div style="height: 130px;"></div> --}}