<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Infrastructure\Persistence\Doctrine\Repository;

use App\Shared\Domain\User\UserRole;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\User\Core\User\UserSsoIdOM;
use App\User\Core\User\User;
use App\User\Infrastructure\Persistence\Doctrine\Repository\UserDoctrineRepository;
use PHPUnit\Framework\Attributes\Test;

class UserDoctrineRepositoryTest extends IntegrationTestCase
{
    private UserDoctrineRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = self::getContainer()->get(UserDoctrineRepository::class);
    }

    #[Test]
    public function user_can_be_created_and_retrieved(): void
    {
        $user = User::createFromSso(
            UserIdOM::random(),
            UserSsoIdOM::random(),
            'username',
            [UserRole::ADMIN, UserRole::USER],
        );
        $this->userRepository->save($user);
        $this->clearEntityManager();

        $userFromDb = $this->userRepository->findById($user->getId());
        $this->assertNotEmpty($userFromDb);
        $this->assertEquals($user->getId(), $userFromDb->getId());
        $this->assertTrue($user->getSsoId()->equals($userFromDb->getSsoId()));
        $this->assertEquals($user->getUsername(), $userFromDb->getUsername());
        $this->assertEquals($user->getRoles(), [UserRole::ADMIN, UserRole::USER]);
    }

    public function findById_return()
    {

    }
}
