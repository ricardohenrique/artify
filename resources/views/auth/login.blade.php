@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="bg-white p-4 rounded shadow-sm">

                    <h2 class="mb-4 text-center">Log in to your Artify account</h2>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" type="email" name="email" class="form-control subtle-focus @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            @if (Route::has('password.request'))
                                <a class="small text-decoration-none" href="{{ route('password.request') }}" style="float: right;">Forgot your password?</a>
                            @endif
                            <div class="input-group">
                                <input id="password" type="password" name="password"
                                    class="form-control subtle-focus @error('password') is-invalid @enderror" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

{{--                        <div class="form-check mb-3">--}}
{{--                            <input class="form-check-input" type="checkbox" name="remember" id="remember">--}}
{{--                            <label class="form-check-label" for="remember">Remember me</label>--}}
{{--                        </div>--}}

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn artify-btn w-100">Log in</button>
                        </div>
                    </form>
                    <div class="d-flex align-items-center text-muted my-4">
                        <hr class="flex-grow-1">
                        <span class="mx-3">or</span>
                        <hr class="flex-grow-1">
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('google.redirect') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2 py-2 btn-google">
                            <img src="{{ asset('web_neutral_rd_na@1x.png') }}" alt="Google logo" style="">
                            Continue with Google
                        </a>
                    </div>
{{--                    <div class="text-center mt-2">--}}
{{--                        <a href="{{ route('facebook.redirect') }}" class="btn btn-outline-primary w-100">--}}
{{--                            <i class="bi bi-facebook me-2"></i> Log in with Facebook--}}
{{--                        </a>--}}
{{--                    </div>--}}
                    <div class="text-center mt-3">
                        <p class="small fw-lighter">New on Artify? <a href="{{ route('register') }}" class=""> Create an account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .btn-google{
        background-color: #f2f2f2;
    }
    .btn-google img{
        width: 30px;
        height: 30px;
    }

    .btn-google:hover{
        background-color: #f2f2f2;
        color: #000;
        border-color: #000;
    }

    /* Subtle input focus for Artify */
    .form-control.subtle-focus:focus {
        border-color: #999 !important; /* or your accent color */
        box-shadow: none !important;   /* removes the blue glow */
        background-color: #fefefe;     /* optional: softer background */
    }
</style>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
@endsection
