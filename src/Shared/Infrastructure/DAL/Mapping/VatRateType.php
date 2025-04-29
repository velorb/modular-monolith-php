<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\VatRate;

/**
 * @extends IntegerType<VatRate>
 */
class VatRateType extends IntegerType
{
    protected function getValueObjectClassName(): string
    {
        return VatRate::class;
    }

    public function getName(): string
    {
        return 's-vat_rate';
    }
}
