<?php

declare(strict_types=1);

namespace App\User\Core\User;

use App\Shared\Domain\User\UserId;
use App\Shared\Domain\User\UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class User
{
    /**
     * @var Collection<int, UserRoleAssignment>
     */
    private Collection $roles;

    /**
     * @param UserRole[] $roles
     */
    private function __construct(
        public UserId $id,
        public UserSsoId $ssoId,
        public string $username,
        array $roles,
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
        array $roles,
    ): self {
        return new self($userId, $userSsoId, $username, $roles);
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
}
