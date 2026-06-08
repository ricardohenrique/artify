<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\CannotMessageSelfException;
use App\Exceptions\NotConversationParticipantException;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Painting;
use App\Models\User;
use App\Repositories\ConversationRepository;
use App\Repositories\UserRepository;

class MessageService
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
        private readonly UserRepository $userRepository,
    ) {}

    /**
     * Returns the data needed to render the inbox view.
     *
     * @return array{user: User, conversations: \Illuminate\Database\Eloquent\Collection}
     */
    public function getInboxData(User $user): array
    {
        $fullUser      = $this->userRepository->getUserWithInboxRelations($user->id);
        $conversations = $this->conversationRepository->getUserConversations($user->id);

        return compact('fullUser', 'conversations');
    }

    public function getSelectedConversation(int $conversationId, User $user): Conversation
    {
        return $this->conversationRepository->findParticipantConversationOrFail($conversationId, $user->id);
    }

    public function getConversationForUser(Conversation $conversation, User $user): Conversation
    {
        if ($conversation->buyer_id !== $user->id && $conversation->seller_id !== $user->id) {
            throw new NotConversationParticipantException();
        }

        $conversation->load(['messages.sender', 'painting']);

        return $conversation;
    }

    public function sendMessage(int $conversationId, User $user, string $content): Message
    {
        $conversation = $this->conversationRepository->findWithParticipants($conversationId);

        if ($conversation->buyer_id !== $user->id && $conversation->seller_id !== $user->id) {
            throw new NotConversationParticipantException();
        }

        return $this->conversationRepository->addMessage($conversation, $user->id, $content);
    }

    public function startConversation(Painting $painting, User $user): Conversation
    {
        $seller = $painting->user;

        if ($user->id === $seller->id) {
            throw new CannotMessageSelfException();
        }

        return $this->conversationRepository->findOrCreate($painting->id, $user->id, $seller->id);
    }
}
