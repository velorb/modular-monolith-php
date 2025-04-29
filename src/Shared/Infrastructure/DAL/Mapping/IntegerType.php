<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\IntegerTypeVOInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * @template T of IntegerTypeVOInterface
 */
abstract class IntegerType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @return class-string<T>
     */
    abstract protected function getValueObjectClassName(): string;

    abstract public function getName(): string;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof IntegerTypeVOInterface) {
            return $value->toInt();
        }

        throw new \InvalidArgumentException(
            sprintf('Expected instance of %s, got %s', IntegerTypeVOInterface::class, get_debug_type($value))
        );
    }

    /**
     * Converts database value to PHP value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        if ($value === null) {
            return null;
        }

        $className = $this->getValueObjectClassName();
        if ($value instanceof IntegerTypeVOInterface) {
            return $value;
        }

        if (is_int($value)) {
            return $className::fromInt($value);
        }

        throw new \InvalidArgumentException(
            sprintf('Expected instance of int, got %s', get_debug_type($value))
        );
    }
}
