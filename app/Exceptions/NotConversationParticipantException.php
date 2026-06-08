<?php

declare(strict_types=1);

namespace App\Exceptions;

class NotConversationParticipantException extends \DomainException
{
    public function __construct(string $message = 'You are not a participant of this conversation.')
    {
        parent::__construct($message);
    }
}
