<?php

declare(strict_types=1);

namespace App\Shared\Domain\User;

use App\Shared\Domain\Id\Uuid;

final readonly class UserId extends Uuid
{
    public static function fromUuid(Uuid $ulid): self
    {
        return new self($ulid->value);
    }
}
