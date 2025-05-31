<?php

declare(strict_types=1);

namespace App\Tests\Support;

use App\Tests\Support\Mock\Shared\Application\Bus\Event\EventBusMock;
use App\Tests\Support\Mock\Shared\Domain\ClockMock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IntegrationTestCase extends WebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::getServiceByClassName(EntityManagerInterface::class);
    }

    protected function clearEntityManager(): void
    {
        $this->getEntityManager()->clear();
    }

    protected function saveEntities(object ...$entities): void
    {
        $entityManager = $this->getEntityManager();
        foreach ($entities as $entity) {
            $entityManager->persist($entity);
        }
        $entityManager->flush();
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    public static function getServiceByClassName(string $className)
    {
        return self::getContainer()->get($className); // @phpstan-ignore-line
    }

    protected function getEventBus(): EventBusMock
    {
        return $this->getServiceByClassName(EventBusMock::class);
    }

    protected function getClock(?string $now = null): ClockMock
    {
        return new ClockMock(new \DateTimeImmutable($now ?? 'now'));
    }
}
