<?php

declare(strict_types=1);

namespace App\Tests\Support;

use App\Shared\Application\Bus\Event\IModuleIntegrationEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PHPat\Selector\Selector;
use PHPat\Selector\SelectorInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class ArchitectureTest
{
    public static function moduleIntegrationEvents(): SelectorInterface
    {
        return Selector::implements(IModuleIntegrationEvent::class);
    }

    /**
     * @return SelectorInterface[]
     */
    public static function allowedDomainDependencies(): array
    {
        return array_merge(
            self::languageClasses(),
            // doctrine collections
            [
                Selector::classname(Collection::class),
                Selector::classname(ArrayCollection::class),
                Selector::classname(AsEventListener::class),
            ]
        );
    }

    /**
     * @return SelectorInterface[]
     */
    public static function languageClasses(): array
    {
        return [
            Selector::classname(\Throwable::class),
            Selector::classname(\InvalidArgumentException::class),
            Selector::classname(\RuntimeException::class),
            Selector::classname(\DateTimeImmutable::class),
            Selector::classname(\DateTimeInterface::class),
            Selector::classname(\DomainException::class),
            Selector::classname(\Stringable::class),
            Selector::classname(\BackedEnum::class),
            Selector::classname(\Countable::class),
            Selector::classname(\IteratorAggregate::class),
            Selector::classname(\Traversable::class),
            Selector::classname(\ArrayIterator::class),
            Selector::classname(Collection::class),
            Selector::classname(ArrayCollection::class),
        ];
    }
}
