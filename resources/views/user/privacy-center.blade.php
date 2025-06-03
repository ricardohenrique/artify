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
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('member.updatePrivacy', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Section: Privacy Settings --}}
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="mb-3 fw-semibold">🔒 Privacy Settings</h5>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_public" name="is_public"
                                   value="1" {{ old('is_public', $user->is_public ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">Make profile public</label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="show_email" name="show_email"
                                   value="1" {{ old('show_email', $user->show_email ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_email">Show email on profile</label>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="text-end">
                        <button type="submit" class="btn artify-btn">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection