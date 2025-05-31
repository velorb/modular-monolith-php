<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\IIntegerVO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * @template T of IIntegerVO
 */
abstract class IntegerType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
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

        if ($value instanceof IIntegerVO) {
            return $value->toInt();
        }

        throw new \InvalidArgumentException(
            sprintf('Expected instance of %s, got %s', IIntegerVO::class, get_debug_type($value))
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
        if ($value instanceof IIntegerVO) {
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
