<?php

declare(strict_types=1);

namespace App\Tests\Support;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IntegrationTestCase extends WebTestCase
{
    protected function getEntityManager(): EntityManagerInterface
    {
        return self::getServiceByClassName(EntityManagerInterface::class);
    }

    protected function clearEntityManager(): void
    {
        $this->getEntityManager()->clear();
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
}
