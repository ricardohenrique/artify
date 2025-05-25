@guest
    <a href="#" class="btn btn-outline-primary requires-auth {{ $attributes->get('class') }}">Follow</a>
@else
    @if(auth()->id() !== $user->id)
        <form method="POST" action="{{ route('users.follow', $user) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-primary {{ $attributes->get('class') }}">
                @if(auth()->user()->following->contains($user->id))
                    Following
                @else
                    Follow
                @endif
            </button>
        </form>
    @endif
@endguest