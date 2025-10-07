@extends('layouts.app')

@section('title', 'How It Works')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <h1 class="text-center fw-bold mb-5">How Artify Works</h1>

            <div class="row">
                <!-- Artist Column -->
                <div class="col-md-6 mb-5">
                    <h3 class="text-center mb-4"><i class="bi bi-palette"></i> For Artists</h3>

                    <div class="how-card mb-4">
                        <div class="step-badge">1</div>
                        <div class="text-center mb-2">
                            <i class="bi bi-person-circle fs-2"></i>
                        </div>
                        <h5 class="text-center fw-semibold">Create a Profile</h5>
                        <p class="text-center small mb-0">Introduce yourself, upload a profile picture, and share your journey.</p>
                    </div>

                    <div class="how-card mb-4">
                        <div class="step-badge">2</div>
                        <div class="text-center mb-2">
                            <i class="bi bi-images fs-2"></i>
                        </div>
                        <h5 class="text-center fw-semibold">Upload Artworks</h5>
                        <p class="text-center small mb-0">Add high-quality images, details, and prices for your creations.</p>
                    </div>

                    <div class="how-card">
                        <div class="step-badge">3</div>
                        <div class="text-center mb-2">
                            <i class="bi bi-currency-dollar fs-2"></i>
                        </div>
                        <h5 class="text-center fw-semibold">Sell & Ship</h5>
                        <p class="text-center small mb-0">Receive orders, print shipping labels, and send your art to collectors.</p>
                    </div>
                </div>

                <!-- Buyer Column -->
                <div class="col-md-6 mb-5">
                    <h3 class="text-center mb-4"><i class="bi bi-bag-heart"></i> For Buyers</h3>

                    <div class="how-card mb-4">
                        <div class="step-badge">1</div>
                        <div class="text-center mb-2">
                            <i class="bi bi-search fs-2"></i>
                        </div>
                        <h5 class="text-center fw-semibold">Browse Art</h5>
                        <p class="text-center small mb-0">Explore original artworks by independent artists from around the world.</p>
                    </div>

                    <div class="how-card mb-4">
                        <div class="step-badge">2</div>
                        <div class="text-center mb-2">
                            <i class="bi bi-chat-dots fs-2"></i>
                        </div>
                        <h5 class="text-center fw-semibold">Connect</h5>
                        <p class="text-center small mb-0">Message artists directly to ask questions or request custom pieces.</p>
                    </div>

                    <div class="how-card">
                        <div class="step-badge">3</div>
                        <div class="text-center mb-2">
                            <i class="bi bi-cart-check fs-2"></i>
                        </div>
                        <h5 class="text-center fw-semibold">Purchase & Enjoy</h5>
                        <p class="text-center small mb-0">Buy securely and receive your one-of-a-kind piece at your door.</p>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <p class="lead mb-3">Ready to join the creative movement?</p>
                    <a href="{{ route('login') }}" class="btn btn-lg artify-btn px-4">Get Started</a>
                </div>
            </div>
        </div>
    </section>
    <style>
        .how-card {
            background: linear-gradient(135deg, #ff7c5c, #ff4e9b);
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            color: white;
            position: relative;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        .how-card:hover {
            transform: translateY(-5px);
        }

        .step-badge {
            background: white;
            color: #ff4e9b;
            font-weight: bold;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            text-align: center;
            line-height: 36px;
            position: absolute;
            top: -18px;
            left: -18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
