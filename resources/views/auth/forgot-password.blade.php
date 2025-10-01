@extends('layouts.app') {{-- Make sure this uses your Artify guest layout --}}

@section('title', 'Forgot Password')

@section('content')
    <section class="container py-5" style="max-width: 500px;">
        <div class="bg-white shadow-sm p-4 p-md-5 rounded">

            <h2 class="mb-3 fw-bold text-center">Forgot your password?</h2>

            <p class="text-muted small text-center mb-4">
                No worries. Enter your email and we’ll send you a link to reset your password.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control mt-1 w-full" type="email" name="email"
                                  :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="d-grid mt-4">
                    <x-primary-button class="artify-btn w-100">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="footer-link small">&larr; Back to login</a>
            </div>
        </div>
    </section>
@endsection
