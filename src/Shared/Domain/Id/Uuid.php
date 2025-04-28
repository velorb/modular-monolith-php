<?php

declare(strict_types=1);

namespace App\Shared\Domain\Id;

readonly class Uuid
{
    public function __construct(
        public string  $value,
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $id): bool
    {
        return $this->value === $id->value;
    }
}
