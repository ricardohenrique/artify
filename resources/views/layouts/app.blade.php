<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TDK389H6');</script>
    <!-- End Google Tag Manager -->
    <!-- Start cookieyes banner -->
    <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/13d740f9d3f0db86cc64f0eb/script.js"></script>
    <!-- End cookieyes banner -->

    <meta charset="UTF-8">
    <title>Artify - @yield('title', 'Artify | Buy Original Artworks from Independent Artists')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('artify_favicon-02.ico') }}">
    <meta name="theme-color" content="#000000">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- iOS Home Screen Support -->
    <link rel="apple-touch-icon" href="{{ asset('icon-192x192.png') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="WeArtify">

    <!-- custom meta -->
    <meta name="description" content="@yield('description', 'Discover and collect unique artworks from independent artists.')">
    <meta name="keywords" content="@yield('keywords', 'artify, independent artists, art marketplace, creative community, buy art online, art platform, curated paintings, support artists')"">
    @yield('meta')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('style')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    @livewireStyles

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DGNM03PMET"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-DGNM03PMET');
    </script>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TDK389H6"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Please log in</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p>You need to be logged in to continue.</p>
            <a href="{{ route('login') }}" class="btn btn-primary w-100">Log In</a>
            </div>
        </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Guest user protection
            const guestOnlyButtons = document.querySelectorAll('.requires-auth');

            guestOnlyButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                });
            });
        });
    </script>
    @yield('script')
    @livewireScripts
</body>
</html>
