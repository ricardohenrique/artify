<div>
    @guest
        <a href="#" class="btn btn-outline-primary requires-auth {{ $buttonClass }}">Follow</a>
    @else
        @if(auth()->id() !== $user->id)
            <button wire:click="toggleFollow" class="btn btn-outline-primary {{ $buttonClass }}">
                {{ $isFollowing ? 'Following' : 'Follow' }}
            </button>
        @endif
    @endguest
</div>