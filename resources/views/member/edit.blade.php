@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Sidebar Menu -->
            <div class="col-md-3 mb-4">
                <h4 class="mb-4">Settings</h4>
                <ul class="nav flex-column nav-pills">
                    <li class="nav-item"><a href="#profile" class="nav-link active" data-bs-toggle="pill">Profile details</a></li>
                    <li class="nav-item"><a href="#address" class="nav-link" data-bs-toggle="pill">Address info</a></li>
                    <li class="nav-item"><a href="#privacy" class="nav-link" data-bs-toggle="pill">Privacy settings</a></li>
                </ul>
            </div>

            <!-- Tab Content -->
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

                    <div class="tab-content">

                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile">
                            <h5 class="mb-3 fw-semibold">🖼️ Profile Details</h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="name">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}">
                                @error('username') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="bio">About You</label>
                                <textarea name="bio" id="bio" rows="3" class="form-control">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="website_url">Website</label>
                                <input type="text" name="website_url" id="website_url" class="form-control" value="{{ old('website_url', $user->website_url) }}">
                                @error('website_url') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Address Tab -->
                        <div class="tab-pane fade" id="address">
                            <h5 class="mb-3 fw-semibold">📍 Address Info</h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="location">Location</label>
                                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $user->location) }}">
                                @error('location') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="country">Country</label>
                                <select name="country" id="country" class="form-select">
                                    <option value="">Select Country</option>
                                    <option value="Germany" {{ old('country', $user->country ?? '') === 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="USA" {{ old('country', $user->country ?? '') === 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                    <!-- Add more as needed -->
                                </select>
                            </div>
                        </div>

                        <!-- Privacy Tab -->
                        <div class="tab-pane fade" id="privacy">
                            <h5 class="mb-3 fw-semibold">🔒 Privacy Settings</h5>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="public_profile" name="public_profile"
                                    {{ old('public_profile', $user->public_profile ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="public_profile">Make profile public</label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="show_email" name="show_email"
                                    {{ old('show_email', $user->show_email ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_email">Show email on profile</label>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="text-end mt-4">
                        <button type="submit" class="btn artify-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Ensure Bootstrap Tabs JS is available -->
<script>
    const triggerTabList = document.querySelectorAll('[data-bs-toggle="pill"]');
    triggerTabList.forEach(triggerEl => {
        const tabTrigger = new bootstrap.Tab(triggerEl);
        triggerEl.addEventListener('click', event => {
            event.preventDefault();
            tabTrigger.show();
        });
    });
</script>
@endsection