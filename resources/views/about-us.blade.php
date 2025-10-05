@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<section class="py-5 bg-white about-us">
    <div class="container">
        <h1 class="display-5 fw-bold mb-4 text-center">
            Welcome to Artify
        </h1>
        <p class="lead text-center mb-5">
            Artify is a vibrant online marketplace dedicated to empowering independent artists. 
            Our platform connects creators with art enthusiasts, offering a space to showcase, sell, and celebrate original artwork.
        </p>

        <hr class="my-5">

        <!-- For Artists & Buyers -->
        <div class="row mb-5">
            <div class="col-md-6">
                <h2 class="fw-semibold">
                    <i class="bi bi-palette me-2 text-artify-pink"></i>For Artists
                </h2>
                <ul class="mt-3 lead fs-5">
                    <li><strong>Create Your Profile:</strong> Share your artistic journey, inspirations, and portfolio.</li>
                    <li><strong>List Your Artworks:</strong> Upload images, set prices, and provide descriptions to reach potential buyers.</li>
                    <li><strong>Manage Sales:</strong> Track orders, communicate with customers, and handle transactions seamlessly.</li>
                    <li><strong>Shipping Made Easy:</strong> Access prepaid shipping labels for hassle-free delivery.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="fw-semibold">
                    <i class="bi bi-bag-heart me-2 text-artify-orange"></i>For Buyers
                </h2>
                <ul class="mt-3 lead fs-5">
                    <li><strong>Discover Unique Art:</strong> Explore a diverse range of original artworks from emerging and established artists.</li>
                    <li><strong>Support Creators:</strong> Purchase directly from artists, ensuring they receive full recognition and compensation.</li>
                    <li><strong>Secure Transactions:</strong> Benefit from our buyer protection policies for a safe shopping experience.</li>
                    <li><strong>Personalized Experience:</strong> Save favorites, follow artists, and receive updates on new listings.</li>
                </ul>
            </div>
        </div>

        <hr class="my-5">

        <!-- Mission -->
        <div class="mb-5">
            <h2 class="fw-semibold">
                <i class="bi bi-globe2 me-2"></i>Our Mission
            </h2>
            <p class="mt-3 lead fs-5">
                At Artify, we believe in the power of art to inspire and connect. Our mission is to:
            </p>
            <ul class="mt-2 lead fs-5">
                <li><strong>Empower Artists:</strong> Provide tools and resources to help artists thrive.</li>
                <li><strong>Foster Community:</strong> Build a supportive network where creativity flourishes.</li>
                <li><strong>Promote Accessibility:</strong> Make original art accessible to a broader audience.</li>
            </ul>
        </div>

        <hr class="my-5">

        <!-- Safety -->
        <div class="mb-5">
            <h2 class="fw-semibold">
                <i class="bi bi-shield-lock me-2"></i>Safety and Trust
            </h2>
            <ul class="mt-3 lead fs-5">
                <li><strong>Secure Payments:</strong> Utilizing trusted payment gateways for all transactions.</li>
                <li><strong>Transparent Policies:</strong> Clearly outlining guidelines for buyers and sellers.</li>
                <li><strong>Responsive Support:</strong> Offering assistance to resolve any issues promptly.</li>
            </ul>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5">
            <p class="lead fs-5">Join us at Artify and be part of a community where art comes to life.</p>
        </div>
    </div>
</section>
@endsection
{{-- <style>
    .about-us .container div i.bi {
        font-size: 30px;
    }
</style> --}}