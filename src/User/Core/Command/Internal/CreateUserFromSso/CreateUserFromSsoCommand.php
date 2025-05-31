<?php

declare(strict_types=1);

namespace App\User\Core\Command\Internal\CreateUserFromSso;

use App\Shared\Application\Bus\Command\ICommand;
use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserRole;
use App\User\Core\User\UserSsoId;

readonly class CreateUserFromSsoCommand implements ICommand
{
    /**
     * @param UserRole[] $roles
     */
    public function __construct(
        public UserSsoId $ssoId,
        public string $username,
        public Email $email,
        public array $roles,
        public string $firstName,
        public string $lastName,
    ) {
    }
}
