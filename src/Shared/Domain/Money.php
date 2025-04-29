<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final readonly class Money
{
    private function __construct(
        public int $amount,
    ) {
    }

    public static function fromCents(int $amount): self
    {
        return new self($amount);
    }

    public function add(Money $toAdd): self
    {
        return new self($this->amount + $toAdd->amount);
    }
}
