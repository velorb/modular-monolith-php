<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Shared\Domain\User;

use App\Tests\Support\Faker\UlidFaker;
use App\User\Core\User\UserId;

class UserIdOM
{
    public static function random(): UserId
    {
        return new UserId(UlidFaker::generate());
    }
}
