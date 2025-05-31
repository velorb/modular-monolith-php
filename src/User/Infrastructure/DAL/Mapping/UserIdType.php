<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Mapping;

use App\Shared\Infrastructure\DAL\Mapping\DoctrineUlidType;
use App\User\Core\User\UserId;

class UserIdType extends DoctrineUlidType
{
    protected function getValueObjectClassName(): string
    {
        return UserId::class;
    }

    public function getName(): string
    {
        return 'user__user_id';
    }
}
