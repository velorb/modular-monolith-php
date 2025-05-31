<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Shared\Domain\User;

use App\Tests\Support\Faker\UuidFaker;
use App\User\Core\User\UserSsoId;

final class UserSsoIdOM
{
    public static function random(): UserSsoId
    {
        return new UserSsoId(UuidFaker::generate());
    }
}
