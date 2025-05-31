<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Shared\Domain\User;

use App\Shared\Domain\User\UserSsoId;
use App\Tests\Support\Faker\UuidFaker;

final class UserSsoIdOM
{
    public static function random(): UserSsoId
    {
        return new UserSsoId(UuidFaker::generate());
    }
}
