<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Security;

use App\Shared\Application\RequestingUserDto;
use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserRole;
use App\Shared\Domain\User\UserSsoId;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class SecurityUser implements UserInterface
{
    /**
     * @param UserRole[] $roles
     */
    public function __construct(
        public UserSsoId $userId,
        public Email $email,
        public array $roles,
    ) {
    }

    public function getRoles(): array
    {
        return array_map(fn (UserRole $role) => $role->value, $this->roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->userId->value;
    }

    public function getRequestingUserDto(): RequestingUserDto
    {
        return new RequestingUserDto(
            $this->userId,
            $this->getUserIdentifier(),
            $this->email,
            $this->roles
        );
    }
}
