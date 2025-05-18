@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="p-5 bg-white shadow rounded">
            <h1 class="h3 mb-3">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">You're logged in to your dashboard.</p>
        </div>
    </div>
</section>
@endsection