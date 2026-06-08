<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class ConversationRepository
{
    public function getUserConversations(int $userId): Collection
    {
        return Conversation::where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->with(['painting', 'messages' => fn ($q) => $q->latest()->limit(1)])
            ->latest('updated_at')
            ->get();
    }

    public function findParticipantConversationOrFail(int $conversationId, int $userId): Conversation
    {
        return Conversation::with(['messages.sender', 'painting'])
            ->where('id', $conversationId)
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })
            ->firstOrFail();
    }

    public function findWithParticipants(int $conversationId): Conversation
    {
        return Conversation::with(['buyer', 'seller'])->findOrFail($conversationId);
    }

    public function findOrCreate(int $paintingId, int $buyerId, int $sellerId): Conversation
    {
        return Conversation::firstOrCreate([
            'painting_id' => $paintingId,
            'buyer_id'    => $buyerId,
            'seller_id'   => $sellerId,
        ]);
    }

    public function addMessage(Conversation $conversation, int $senderId, string $content): Message
    {
        $message = new Message([
            'sender_id' => $senderId,
            'content'   => $content,
        ]);

        $conversation->messages()->save($message);

        return $message;
    }
}
