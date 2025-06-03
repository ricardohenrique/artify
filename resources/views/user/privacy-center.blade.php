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

                    <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h5 class="mb-3 fw-semibold">🎨 Profile Type</h5>
                    
                        <p class="text-muted mb-3 small">
                            Choose how you want to be seen in the community. This helps us personalize your experience.
                        </p>
                    
                        <div class="d-flex flex-wrap gap-2 user-type-toggle">
                            @foreach ($userTypes as $type)
                                <input type="radio" class="btn-check" name="user_type_id" id="type-{{ $type->id }}"
                                       value="{{ $type->id }}" autocomplete="off"
                                       {{ old('user_type_id', $user->user_type_id) == $type->id ? 'checked' : '' }}>
                    
                                <label class="btn user-type-option" for="type-{{ $type->id }}">
                                    {{ ucfirst($type->name) }}
                                </label>
                            @endforeach
                        </div>
                        <ul class="user-type-description text-muted small mb-0 mt-2">
                            <li><strong>User:</strong> A regular member who enjoys browsing and engaging with art.</li>
                            <li><strong>Artist:</strong> Upload and sell your original artwork on the platform.</li>
                            <li><strong>Collector:</strong> Showcase or manage your art collection.</li>
                            <li><strong>Other:</strong> Anyone who doesn't fit the above roles exactly.</li>
                        </ul>
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

<style>
/*------------------------ User Type Toggle ------------------------*/
.user-type-toggle .user-type-option {
    background-color: #f3f3f3;
    border: 1px solid transparent;
    border-radius: var(--artify-radius-sm);
    padding: 0.5rem 1rem;
    font-weight: 500;
    color: var(--artify-dark);
    transition: all 0.2s ease;
    cursor: pointer;
}

.user-type-toggle .btn-check:checked + .user-type-option {
    background-color: var(--artify-primary);
    color: #fff;
    border-color: var(--artify-primary);
}

.user-type-toggle .user-type-option:hover {
    background-color: #ececec;
}

.user-type-description {
    list-style: disc;
    padding-left: 1.2rem;
    color: var(--artify-muted);
    line-height: 1.6;
}
/*-----------------------------------------------------------------*/
</style>
@endsection