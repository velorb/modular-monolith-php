<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Core\Command\Internal\CreateUserFromSso;

use App\Shared\Application\Bus\Event\IEvent;
use App\Shared\Application\Event\Integration\User\UserCreatedIE;
use App\Shared\Application\Exception\ValidationFailedException;
use App\Shared\Domain\User\UserId;
use App\Shared\Domain\User\UserRole;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\EmailOM;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserSsoIdOM;
use App\Tests\Support\ObjectMother\User\Core\User\UserOM;
use App\User\Core\Command\Internal\CreateUserFromSso\CreateUserFromSsoCommand;
use App\User\Core\Command\Internal\CreateUserFromSso\CreateUserFromSsoHandler;
use App\User\Core\User\IUserRepository;
use PHPUnit\Framework\Attributes\Test;

class CreateUserFromSsoHandlerTest extends IntegrationTestCase
{
    private IUserRepository $userRepository;
    private CreateUserFromSsoHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = self::getServiceByClassName(CreateUserFromSsoHandler::class);
        $this->userRepository = self::getServiceByClassName(IUserRepository::class);
    }

    #[Test]
    public function cannot_create_user_with_already_existing_sso_id(): void
    {
        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('User with this SSO ID already exists.');
        $ssoId = UserSsoIdOM::random();

        $user = UserOM::create(ssoId: $ssoId);
        $this->saveEntities($user);
        $this->handler->__invoke(
            new CreateUserFromSsoCommand(
                $ssoId,
                'username',
                EmailOM::random(),
                [UserRole::CYCLIST],
                'John',
                'Doe'
            )
        );
    }

    #[Test]
    public function it_creates_user_from_sso(): void
    {
        $command = new CreateUserFromSsoCommand(
            UserSsoIdOM::random(),
            'username',
            EmailOM::random(),
            [UserRole::CYCLIST],
            'John',
            'Doe'
        );

        $this->handler->__invoke($command);
        $this->clearEntityManager();

        $user = $this->userRepository->findById(UserId::fromUuid($command->ssoId));
        $this->assertNotNull($user);
        $this->assertEquals($command->ssoId, $user->getSsoId());
        $this->assertEquals($command->ssoId->value, $user->getId()->value);
        $this->assertEquals($command->username, $user->getUsername());
        $this->assertEquals($command->email, $user->getEmail());
        $this->assertEqualsCanonicalizing($command->roles, $user->getRoles());
        $this->assertEquals($command->firstName, $user->getFirstName());
        $this->assertEquals($command->lastName, $user->getLastName());

        $dispatchedIE = $this->getEventBus()->hasDispatchedEvent(fn (IEvent $event) => $event instanceof UserCreatedIE);
        $this->assertTrue($dispatchedIE);
    }
}
