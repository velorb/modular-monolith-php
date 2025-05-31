<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Security\Sso;

use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserRole;
use App\Shared\Domain\User\UserSsoId;

readonly class SsoPayloadDto
{
    /**
     * @param UserRole[] $roles
     */
    public function __construct(
        public UserSsoId $userSsoId,
        public string $username,
        public Email $email,
        public array $roles,
        public string $firstName,
        public string $lastName,
    ) {
    }
}
