<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\Money;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class MoneyType extends Type
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof Money) {
            throw new \InvalidArgumentException(
                sprintf('Expected instance of %s, got %s', Money::class, get_debug_type($value))
            );
        }

        return $value->amount;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Money
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Money) {
            return $value;
        }

        if (is_int($value)) {
            return Money::fromCents($value);
        }

        throw new \InvalidArgumentException(
            sprintf('Expected int, got %s', get_debug_type($value))
        );
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return 's-money';
    }
}
