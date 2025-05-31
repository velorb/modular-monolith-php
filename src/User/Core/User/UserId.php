<?php

declare(strict_types=1);

namespace App\User\Core\User;

use App\Shared\Domain\Id\Ulid;

final readonly class UserId extends Ulid
{
    public static function fromUlid(Ulid $ulid): self
    {
        return new self($ulid->value);
    }
}
