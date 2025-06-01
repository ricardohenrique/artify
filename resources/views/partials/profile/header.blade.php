<!-- Profile Header -->
<div class="bg-white p-4 rounded shadow-sm d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <!-- Avatar -->
        <div class="me-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ff6a00&color=fff"
                    alt="Avatar" class="rounded-circle" style="width: 80px; height: 80px;">
        </div>
        <!-- Info -->
        <div>
            <h4 class="mb-0">{{ $user->name }} <small class="text-muted">{{'@' . $user->username}}</small></h4>
            <div class="text-muted small">
                <i class="bi bi-geo-alt me-1"></i>{{ $user->location ?? 'Location not set' }}<br>
                <i class="bi bi-clock me-1"></i>Last seen {{ $user->updated_at->diffForHumans() }}<br>
                <i class="bi bi-people me-1"></i>
                <a href="#" class="text-decoration-none">{{ $user->followers_count }} followers</a>,
                <a href="#" class="text-decoration-none">{{ $user->following_count }} following</a>
            </div>
        </div>
    </div>

    @auth
        @if(Auth::id() === $user->id)
            <a href="{{ route('member.edit', $user->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-pencil me-1"></i>Edit profile
            </a>
        @endif
    @endauth
</div>
<div class="bg-white border-top border-bottom py-2 mb-4">
    <div class="container d-flex gap-4 align-items-center">
        <a href="{{ route('member.profile', Auth::user()->id) }}" class="fw-semibold text-dark text-decoration-none">Profile</a>
        <a href="{{ route('member.accountSettings', Auth::user()->id) }}" class="text-muted text-decoration-none">Account settings</a>
        <a href="{{ route('member.profile', Auth::user()->id) }}" class="text-muted text-decoration-none">Privacy Center</a>
        <a href="{{ route('member.profile', Auth::user()->id) }}" class="text-muted text-decoration-none">Orders</a>
        <a href="{{ route('member.profile', Auth::user()->id) }}" class="text-muted text-decoration-none">Messages</a>
    </div>
</div>