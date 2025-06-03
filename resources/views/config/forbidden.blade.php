@extends('layouts.app')

@section('title', 'Forbidden')

@section('content')
<section class="py-5 bg-white text-center forbidden-page">
    <div class="container">
        <div class="emoji-display mb-4">🚫</div>
        <h1 class="fw-bold mb-3 text-danger">Access Denied</h1>
        <p class="text-muted mb-4">Oops! You’re trying to do something you’re not allowed to.</p>
        <a href="{{ route('index') }}" class="btn artify-btn">Back to Homepage</a>
    </div>
</section>
@endsection