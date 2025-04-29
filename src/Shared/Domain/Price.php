<?php

declare(strict_types=1);

namespace App\Shared\Domain;

final readonly class Price
{
    public Money $gross;

    public function __construct(
        public Money $net,
        public VatRate $vatRate
    ) {
        $this->gross = $this->calculateGross();
    }

    private function calculateGross(): Money
    {
        return $this->net->add($this->vatRate->vatAmount($this->net));
    }
}
