<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Exception\DomainException;

final class VatRate implements IIntegerVO
{
    private const int HUNDRED_PERCENT_IN_BP = 10_000;

    /** in basis point (1 % = 100, 7.25 % = 725 bp) */
    private int $bp;

    private function __construct(int $bp)
    {
        if ($bp < 0) {
            throw new DomainException('VAT rate cannot be negative.');
        }

        $this->bp = $bp;
    }

    public static function fromBasisPoints(int $bp): self
    {
        return new self($bp);
    }

    public function vatAmount(Money $net): Money
    {
        $vatCents = (int)round(
            ($net->amount * $this->bp) / self::HUNDRED_PERCENT_IN_BP,
            0,
            PHP_ROUND_HALF_UP
        );

        return Money::fromCents($vatCents);
    }

    public function equals(self $other): bool
    {
        return $this->bp === $other->bp;
    }

    public static function fromInt(int $value): static
    {
        return self::fromBasisPoints($value);
    }

    public function toInt(): int
    {
        return $this->bp;
    }
}
