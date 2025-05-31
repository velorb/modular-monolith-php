<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping\User;

use App\Shared\Domain\User\UserSsoId;
use App\Shared\Infrastructure\DAL\Mapping\DoctrineUuidType;

class UserSsoIdType extends DoctrineUuidType
{
    protected function getValueObjectClassName(): string
    {
        return UserSsoId::class;
    }

    public function getName(): string
    {
        return 's__user_sso_id';
    }
}
