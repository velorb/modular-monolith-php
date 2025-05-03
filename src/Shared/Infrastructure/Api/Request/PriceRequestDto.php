<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Request;

use App\Shared\Domain\Money;
use App\Shared\Domain\Price;
use App\Shared\Domain\VatRate;
use Symfony\Component\Validator\Constraints as Assert;

class PriceRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 100)]
        public int $net,
        #[Assert\NotBlank]
        public int $vat,
    ) {
    }

    public function getVO(): Price
    {
        return new Price(
            Money::fromCents($this->net),
            VatRate::fromBasisPoints($this->vat)
        );
    }
}
