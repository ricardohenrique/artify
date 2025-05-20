@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<section class="container py-5">
    <div class="row">
        <!-- Left Sidebar: Conversations -->
        <div class="col-md-4 border-end">
            <h5 class="mb-3">Inbox</h5>

            <div class="list-group">
                @foreach ($conversations as $conv)
                    <a href="{{ route('messages.index', ['conversation' => $conv->id]) }}"
                       class="list-group-item list-group-item-action {{ optional($selectedConversation)->id === $conv->id ? 'active' : '' }}">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $conv->painting->title }}</strong>
                                <div class="small text-muted">
                                    {{ $conv->messages->first()?->content ? Str::limit($conv->messages->first()->content, 40) : 'No messages yet' }}
                                </div>
                            </div>
                            <small class="text-muted">
                                {{ optional($conv->messages->first())->created_at?->diffForHumans() }}
                            </small>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Center Pane: Conversation View -->
        <div class="col-md-8">
            @if($selectedConversation)
                <h5 class="mb-3">{{ $selectedConversation->painting->title }}</h5>
                <div class="border rounded p-3 bg-light mb-3" style="max-height: 400px; overflow-y: auto;">
                    @foreach ($selectedConversation->messages->sortBy('created_at') as $message)
                        <div class="mb-2">
                            <strong>
                                {{ $message->sender?->name ?? 'System' }}:
                            </strong>
                            <div>{{ $message->content }}</div>
                            <div class="text-muted small">{{ $message->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>

                <form action="{{ route('messages.store', $selectedConversation->painting) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="Write a message..." required>
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </form>
            @else
                <div class="text-muted">Select a conversation to view messages.</div>
            @endif
        </div>
    </div>
</div>
@endsection