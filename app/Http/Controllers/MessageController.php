<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Conversation;
use App\Models\Painting;
use App\Services\MessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct(private readonly MessageService $messageService) {}

    public function index(Request $request): View
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();

        $data = $this->messageService->getInboxData($authUser);

        $user          = $data['fullUser'];
        $conversations = $data['conversations'];

        $selectedConversation = null;

        if ($request->has('conversation')) {
            $selectedConversation = $this->messageService->getSelectedConversation(
                (int) $request->conversation,
                $authUser
            );
        }

        return view('user.messages', compact('conversations', 'selectedConversation', 'user'));
    }

    public function show(Conversation $conversation): View
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();

        $conversation = $this->messageService->getConversationForUser($conversation, $authUser);

        return view('messages.show', compact('conversation'));
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();

        $message = $this->messageService->sendMessage(
            (int) $request->validated('conversation_id'),
            $authUser,
            (string) $request->validated('content')
        );

        return redirect()->route('messages.index', ['conversation' => $message->conversation_id]);
    }

    public function ask(Painting $painting): RedirectResponse
    {
        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();

        $conversation = $this->messageService->startConversation($painting, $authUser);

        return redirect()->route('messages.index', ['conversation' => $conversation->id]);
    }
}
