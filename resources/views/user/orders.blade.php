@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')
<section class="bg-light py-5">
    <div class="container">
        @include('partials.profile.header')

        <div class="row">
            @include('partials.profile.sidebar')
            
            <!-- Profile Edit Form -->
            <div class="col-md-9">
                {{-- Section: Privacy Settings --}}
                <div class="bg-white rounded shadow-sm p-4 mb-4">
                    <h5 class="mb-3 fw-semibold">Orders</h5>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
</style>
@endsection