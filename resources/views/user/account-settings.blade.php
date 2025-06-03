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

                <form action="{{ route('member.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Section: Profile Details --}}
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="mb-3 fw-semibold">🖼️ Profile Details</h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name', $user->name) }}">
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control"
                                   value="{{ old('username', $user->username) }}">
                            @error('username') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="bio">About You</label>
                            <textarea name="bio" id="bio" rows="3" class="form-control">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="website_url">Website</label>
                            <input type="text" name="website_url" id="website_url" class="form-control"
                                   value="{{ old('website_url', $user->website_url) }}">
                            @error('website_url') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Section: Address Info --}}
                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="mb-3 fw-semibold">📍 Address Info</h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="location">Location</label>
                            <input type="text" name="location" id="location" class="form-control"
                                   value="{{ old('location', $user->location) }}">
                            @error('location') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="country">Country</label>
                            <select name="country" id="country" class="form-select">
                                <option value="">Select Country</option>
                                <option value="Germany" {{ old('country', $user->country ?? '') === 'Germany' ? 'selected' : '' }}>Germany</option>
                                <option value="Brazil" {{ old('country', $user->country ?? '') === 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                <option value="USA" {{ old('country', $user->country ?? '') === 'USA' ? 'selected' : '' }}>USA</option>
                            </select>
                        </div>
                    </div>

                    {{-- Section: Privacy Settings --}}
                    {{-- <div class="bg-white rounded shadow-sm p-4 mb-4">
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
                    </div> --}}

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