<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

class NotFoundException extends ApplicationException
{
    /**
     * /**
     * @psalm-assert !null $entity
     * @throws NotFoundException
     */
    public static function throwIfNull(mixed $entity, string $message): void
    {
        if ($entity === null) {
            throw new NotFoundException($message);
        }
    }
}
