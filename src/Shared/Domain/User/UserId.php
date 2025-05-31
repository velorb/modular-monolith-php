<?php

declare(strict_types=1);

namespace App\Shared\Domain\User;

use App\Shared\Domain\Id\Uuid;
use App\User\Core\User\UserSsoId;

final readonly class UserId extends UserSsoId
{
    public static function fromUuid(Uuid $ulid): self
    {
        return new self($ulid->value);
    }
}
