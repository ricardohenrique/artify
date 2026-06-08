<?php

declare(strict_types=1);

namespace App\Exceptions;

class CannotMessageSelfException extends \DomainException
{
    public function __construct(string $message = 'You cannot message yourself.')
    {
        parent::__construct($message);
    }
}
