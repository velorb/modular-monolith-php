<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Core\Event\Internal\User;

use App\Shared\Application\Bus\Event\IEvent;
use App\Shared\Application\Event\Integration\User\UserCreatedIE;
use App\Tests\Support\Mock\Shared\Application\Bus\Event\EventBusMock;
use App\Tests\Support\ObjectMother\Shared\Domain\EmailOM;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\UnitTestCase;
use App\User\Core\Event\Internal\User\UserCreatedListener;
use App\User\Core\User\Event\UserCreated;
use PHPUnit\Framework\Attributes\Test;

class UserCreatedListenerTest extends UnitTestCase
{
    private UserCreatedListener $listener;
    private EventBusMock $eventBus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventBus = new EventBusMock();
        $this->listener = new UserCreatedListener($this->eventBus);
    }

    #[Test]
    public function it_dispatches_integration_event(): void
    {
        $domainEvent = new UserCreated(
            UserIdOM::random(),
            $this->getClock()->now(),
            EmailOM::random(),
        );

        $this->listener->__invoke($domainEvent);

        $dispatched = $this->eventBus->hasDispatchedEvent(
            fn (IEvent $event) => $event instanceof UserCreatedIE
                && $event->userId->value === $domainEvent->aggregateId->value
                && $event->email->equals($domainEvent->email)
        );
        $this->assertTrue($dispatched);
    }
}
