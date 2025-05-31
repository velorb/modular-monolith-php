<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\User\Core\User;

use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserRole;
use App\Tests\Support\Mock\Shared\Domain\ClockMock;
use App\Tests\Support\ObjectMother\Shared\Domain\EmailOM;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserSsoIdOM;
use App\User\Core\User\User;
use App\User\Core\User\UserSsoId;

class UserOM
{
    /**
     * @param UserRole[]|null $roles
     */
    public static function create(
        ?UserSsoId $ssoId = null,
        ?string $username = null,
        ?Email $email = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?array $roles = null,
        ?ClockMock $clock = null,
    ): User {
        return User::createFromSso(
            UserIdOM::random(),
            $ssoId ?? UserSsoIdOM::random(),
            $username ?? 'testuser',
            $email ?? EmailOM::random(),
            $roles ?? [UserRole::CYCLIST],
            $firstName ?? 'John',
            $lastName ?? 'Doe',
            $clock ?? new ClockMock()
        );
    }
}
