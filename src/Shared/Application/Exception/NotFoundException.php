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
    public static function throwIfNull(?object $entity, string $resourceName): void
    {
        if ($entity === null) {
            throw new NotFoundException(sprintf('%s not found.', $resourceName));
        }
    }
}
