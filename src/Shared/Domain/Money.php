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

    public static function zero(): self
    {
        return new self(0);
    }

    public function add(Money $toAdd): self
    {
        return new self($this->amount + $toAdd->amount);
    }

    public function sub(Money $toSubtract): self
    {
        return new self($this->amount - $toSubtract->amount);
    }

    public function isLessOrEqualThan(Money $money): bool
    {
        return $this->amount <= $money->amount;
    }

    public function isGreaterOrEqual(Money $money): bool
    {
        return $this->amount >= $money->amount;
    }
}
