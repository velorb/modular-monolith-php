<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Mapping\User;

use App\Shared\Domain\User\UserId;
use App\Shared\Infrastructure\Persistence\Doctrine\Mapping\DoctrineUlidType;

class UserIdType extends DoctrineUlidType
{
    protected function getValueObjectClassName(): string
    {
        return UserId::class;
    }

    public function getName(): string
    {
        return 's-user-user_id';
    }

}
