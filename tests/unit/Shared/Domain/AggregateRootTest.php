<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\DomainEvent;
use App\Tests\Support\UnitTestCase;
use PHPUnit\Framework\Attributes\Test;

class AggregateRootTest extends UnitTestCase
{
    #[Test]
    public function it_records_and_pulls_events(): void
    {
        $aggregate = $this->getAggregate();
        $event = $this->getEvent();
        $aggregate->record($event);

        $events = $aggregate->pullEvents();

        $this->assertCount(1, $events);
        $this->assertEquals($event, $events[0]);
        $this->assertEmpty($aggregate->pullEvents());
    }

    private function getAggregate(): AggregateRoot
    {
        return new class () extends AggregateRoot {
        };
    }

    private function getEvent(): DomainEvent
    {
        return new class () extends DomainEvent {
        };
    }
}
