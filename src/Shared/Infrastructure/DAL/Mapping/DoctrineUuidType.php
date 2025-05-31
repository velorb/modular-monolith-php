<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\Id\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class DoctrineUuidType extends Type
{
    /**
     * Returns the fully qualified class name of the value object.
     */
    abstract protected function getValueObjectClassName(): string;

    /**
     * Returns the type name used in Doctrine mapping files.
     */
    abstract public function getName(): string;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Uuid) {
            return (string)$value;
        }

        throw new \InvalidArgumentException(
            sprintf('Expected instance of %s, got %s', Uuid::class, get_debug_type($value))
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
        if ($value instanceof $className) {
            return $value;
        }

        return new $className($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
