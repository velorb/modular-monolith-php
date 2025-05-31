<?php

declare(strict_types=1);

namespace App\User\Core\Query\Internal\User\Dto;

readonly class UserDto
{
    /**
     * @param string[] $roles
     */
    public function __construct(
        public string $ssoId,
        public string $username,
        public string $email,
        public string $firstName,
        public string $lastName,
        public array $roles,
    ) {
    }
}
