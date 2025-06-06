<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping\User;

use App\Shared\Domain\User\UserId;
use App\Shared\Infrastructure\DAL\Mapping\DoctrineUuidType;

class UserIdType extends DoctrineUuidType
{
    protected function getValueObjectClassName(): string
    {
        return UserId::class;
    }

    public function getName(): string
    {
        return 's__user__user_id';
    }
}
