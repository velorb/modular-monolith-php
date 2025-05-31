<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\IStringVO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * @template T of IStringVO
 */
abstract class StringType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @return class-string<T>
     */
    abstract protected function getValueObjectClassName(): string;

    abstract public function getName(): string;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof IStringVO) {
            return $value->value();
        }

        throw new \InvalidArgumentException(
            sprintf('Expected instance of %s, got %s', IStringVO::class, get_debug_type($value))
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
        if ($value instanceof IStringVO) {
            return $value;
        }

        if (is_string($value)) {
            return $className::fromString($value);
        }

        throw new \InvalidArgumentException(
            sprintf('Expected instance of int, got %s', get_debug_type($value))
        );
    }
}
