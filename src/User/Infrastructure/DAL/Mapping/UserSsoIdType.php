<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Mapping;

use App\Shared\Infrastructure\DAL\Mapping\DoctrineUuidType;
use App\User\Core\User\UserSsoId;

class UserSsoIdType extends DoctrineUuidType
{
    protected function getValueObjectClassName(): string
    {
        return UserSsoId::class;
    }

    public function getName(): string
    {
        return 's__user__user_sso_id';
    }
}
