<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Id;

use App\Shared\Domain\Id\IUlidGenerator;
use App\Shared\Domain\Id\Ulid;
use Symfony\Component\Uid\Factory\UlidFactory;

class UlidSymfonyGenerator implements IUlidGenerator
{
    public function __construct(
        private UlidFactory $ulidFactory,
    ) {
    }

    public function new(): Ulid
    {
        return new Ulid(
            $this->ulidFactory->create()->toString()
        );
    }
}
