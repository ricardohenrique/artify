@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <section class="py-5 bg-light">
        <div class="container" style="max-width: 480px;">
            <div class="bg-white p-4 rounded shadow-sm">

                <h4 class="fw-bold mb-3 text-center">🔐 Reset Your Password</h4>
                <p class="text-muted small text-center mb-4">
                    Set a new password to regain access to your account.
                </p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Hidden Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <input id="email" type="hidden"
                           name="email"
                           value="{{ old('email', $request->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required autofocus autocomplete="username">

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required autocomplete="new-password">

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" type="password"
                               name="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               required autocomplete="new-password">

                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn artify-btn">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
