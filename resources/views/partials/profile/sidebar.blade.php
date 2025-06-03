<div class="col-md-3">
    <div class="list-group shadow-sm">
        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            Profile summary
        </a>
        <a href="{{ route('member.favorites', Auth::id()) }}" class="list-group-item list-group-item-action">Your favorite artworks ({{ $user->favorites_count }})</a>
        <a href="#" class="list-group-item list-group-item-action">Artists you follow ({{ $user->following_count }})</a>
    </div>
</div>