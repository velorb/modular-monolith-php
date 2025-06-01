<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Core\User;

use App\Shared\Domain\User\UserRole;
use App\Tests\Support\ObjectMother\Shared\Domain\AddressOM;
use App\Tests\Support\ObjectMother\Shared\Domain\EmailOM;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserSsoIdOM;
use App\Tests\Support\ObjectMother\User\Core\User\UserOM;
use App\Tests\Support\UnitTestCase;
use App\User\Core\User\Event\UserAddressChanged;
use App\User\Core\User\Event\UserCreated;
use App\User\Core\User\User;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends UnitTestCase
{
    #[Test]
    public function it_checks_is_cyclist(): void
    {
        // admin is not cyclist
        $user = UserOM::create(roles: [UserRole::ADMIN]);
        $this->assertFalse($user->isCyclist());
        // cyclist is cyclist
        $user = UserOM::create(roles: [UserRole::CYCLIST]);
        $this->assertTrue($user->isCyclist());
    }

    #[Test]
    public function it_records_domain_event_when_user_is_created(): void
    {
        $userId = UserIdOM::random();
        $email = EmailOM::random();
        $clock = $this->getClock('2024-06-01 12:00:00');

        $user = User::createFromSso(
            $userId,
            UserSsoIdOM::random(),
            'john',
            $email,
            [UserRole::CYCLIST],
            'John',
            'Doe',
            $clock
        );

        $events = $user->pullEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(UserCreated::class, $events[0]);
        /** @var UserCreated $event */
        $event = $events[0];
        $this->assertEquals($userId, $event->aggregateId);
        $this->assertEquals($email, $event->email);
        $this->assertEquals($clock->now(), $event->occurredAt);
    }

    #[Test]
    public function it_changes_address(): void
    {
        $user = UserOM::create();
        $address = AddressOM::create();
        $user->pullEvents();
        $user->changeAddress($address, $this->getClock());
        $this->assertTrue($user->getAddress()->equals($address));
        $events = $user->pullEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(UserAddressChanged::class, $events[0]);
    }
}
