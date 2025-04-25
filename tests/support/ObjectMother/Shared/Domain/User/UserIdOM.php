<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Shared\Domain\User;

use App\Shared\Domain\User\UserId;
use App\Tests\Support\Faker\UlidFaker;

class UserIdOM
{
    public static function random(): UserId
    {
        return new UserId(UlidFaker::generate());
    }
}
