<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserRole;
use App\Shared\Domain\User\UserSsoId;

readonly class RequestingUserDto
{
    /**
     * @param UserRole[] $roles
     */
    public function __construct(
        public UserSsoId $ssoId,
        public string $username,
        public Email $email,
        public array $roles
    ) {
    }
}
