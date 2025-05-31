<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Core\Query\Internal\User\Me;

use App\Shared\Application\Exception\NotFoundException;
use App\Shared\Domain\User\UserRole;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserSsoIdOM;
use App\Tests\Support\ObjectMother\User\Core\User\UserOM;
use App\User\Core\Query\Internal\User\Me\GetMeHandler;
use App\User\Core\Query\Internal\User\Me\GetMeQuery;
use PHPUnit\Framework\Attributes\Test;

class GetMeHandlerTest extends IntegrationTestCase
{
    private GetMeHandler $getMeHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->getMeHandler = $this->getServiceByClassName(GetMeHandler::class);
    }

    #[Test]
    public function it_throws_not_found_when_user_does_not_exist(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('User');

        $this->getMeHandler->__invoke(new GetMeQuery(UserSsoIdOM::random()));
    }

    #[Test]
    public function it_returns_user_details(): void
    {
        $user = UserOM::create(UserSsoIdOM::random());
        $this->saveEntities($user);

        $userDto = $this->getMeHandler->__invoke(new GetMeQuery($user->getSsoId()));

        $this->assertEquals($user->getSsoId()->value, $userDto->ssoId);
        $this->assertEquals($user->getUsername(), $userDto->username);
        $this->assertEquals($user->getEmail()->value(), $userDto->email);
        $this->assertEquals($user->getFirstName(), $userDto->firstName);
        $this->assertEquals($user->getLastName(), $userDto->lastName);
        $this->assertEqualsCanonicalizing(
            array_map(fn (UserRole $role) => $role->value, $user->getRoles()),
            $userDto->roles
        );
    }
}
