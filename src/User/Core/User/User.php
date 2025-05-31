<?php

declare(strict_types=1);

namespace App\User\Core\User;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Email;
use App\Shared\Domain\User\UserId;
use App\Shared\Domain\User\UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User extends AggregateRoot
{
    /**
     * @var Collection<int, UserRoleAssignment>
     */
    private Collection $roles;

    /**
     * @param UserRole[] $roles
     */
    private function __construct(
        private UserId $id,
        private UserSsoId $ssoId,
        private string $username,
        private Email $email,
        array $roles,
        private string $firstName,
        private string $lastName,
    ) {
        $this->roles = new ArrayCollection(
            array_map(
                fn (UserRole $role) => new UserRoleAssignment($this, $role),
                $roles
            )
        );
    }

    /**
     * @param UserRole[] $roles
     */
    public static function createFromSso(
        UserId $userId,
        UserSsoId $userSsoId,
        string $username,
        Email $email,
        array $roles,
        string $firstName,
        string $lastName
    ): self {
        return new self($userId, $userSsoId, $username, $email, $roles, $firstName, $lastName);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getSsoId(): UserSsoId
    {
        return $this->ssoId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return UserRole[]
     */
    public function getRoles(): array
    {
        return $this->roles->map(fn (UserRoleAssignment $role) => $role->getRole())->toArray();
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
