<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\Money;
use App\Shared\Domain\VatRate;
use App\Tests\Support\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class VatRateTest extends UnitTestCase
{
    /**
     * @return array<string, array{net: Money, vatRate: VatRate, expectedVatAmount: Money}>
     */
    public static function dataProvider_it_calculates_vat_amount(): array
    {
        return [
            '0%' => [
                'net' => Money::fromCents(1000),
                'vatRate' => VatRate::fromBasisPoints(0),
                'expectedVatAmount' => Money::fromCents(0),
            ],
            '8%' => [
                'net' => Money::fromCents(1000),
                'vatRate' => VatRate::fromBasisPoints(800), // 8%
                'expectedVatAmount' => Money::fromCents(80),
            ],
            '23%' => [
                'net' => Money::fromCents(1000),
                'vatRate' => VatRate::fromBasisPoints(2300), // 23%
                'expectedVatAmount' => Money::fromCents(230),
            ],
            '7.25%' => [
                'net' => Money::fromCents(1000), // 10PLN
                'vatRate' => VatRate::fromBasisPoints(725), // 7.25%
                'expectedVatAmount' => Money::fromCents(73), // 10 * 0.0725 = 72.5gr -> round to 73
            ],
            '1gr netto (down)' => [
                'net' => Money::fromCents(1),
                'vatRate' => VatRate::fromBasisPoints(4999),
                'expectedVatAmount' => Money::fromCents(0), // 0.49 cent -> 0 cent
            ],
            '1gr netto (up)' => [
                'net' => Money::fromCents(1),
                'vatRate' => VatRate::fromBasisPoints(5000), // 50%
                'expectedVatAmount' => Money::fromCents(1), // 0.50 gr -> 1 gr
            ],
        ];
    }

    #[Test]
    #[DataProvider('dataProvider_it_calculates_vat_amount')]
    public function it_calculates_vat_amount(Money $net, VatRate $vatRate, Money $expectedVatAmount): void
    {
        $this->assertEquals($expectedVatAmount, $vatRate->vatAmount($net));
    }

    #[Test]
    public function can_not_create_negative_vat_rate(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('VAT rate cannot be negative.');
        VatRate::fromBasisPoints(-1);
    }
}
