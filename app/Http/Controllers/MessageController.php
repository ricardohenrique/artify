<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Painting;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $conversations = Conversation::where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id)
            ->with(['painting', 'messages' => fn ($q) => $q->latest()->limit(1)])
            ->latest('updated_at')
            ->get();

        $selectedConversation = null;

        if ($request->has('conversation')) {
            $selectedConversation = Conversation::with(['messages.sender', 'painting'])
                ->where('id', $request->conversation)
                ->where(function ($q) use ($user) {
                    $q->where('buyer_id', $user->id)->orWhere('seller_id', $user->id);
                })->firstOrFail();
        }

        return view('member.messages', compact('conversations', 'selectedConversation'));
    }

    public function show(Conversation $conversation)
    {
        $user = auth()->user();

        // Authorization: buyer or seller only
        if ($conversation->buyer_id !== $user->id && $conversation->seller_id !== $user->id) {
            abort(403);
        }

        $conversation->load(['messages.sender', 'painting']);

        return view('messages.show', compact('conversation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required|string|max:2000',
        ]);

        $conversation = Conversation::with(['buyer', 'seller'])->findOrFail($request->conversation_id);
        $user = auth()->user();

        // Only participants can send messages
        if (!in_array($user->id, [$conversation->buyer_id, $conversation->seller_id])) {
            abort(403);
        }

        // Save message
        $message = new Message([
            'content' => $request->input('content'),
            'sender_id' => $user->id,
        ]);

        $conversation->messages()->save($message);

        return redirect()->route('messages.index', ['conversation' => $conversation->id]);
    }

    public function ask(Painting $painting)
    {
        $user = auth()->user();
        $seller = $painting->user;

        // Prevent asking oneself
        if ($user->id === $seller->id) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        $conversation = Conversation::firstOrCreate([
            'painting_id' => $painting->id,
            'buyer_id' => $user->id,
            'seller_id' => $seller->id,
        ]);

        return redirect()->route('messages.index', ['conversation' => $conversation->id]);
    }
}
