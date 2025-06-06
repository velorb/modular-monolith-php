<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\Id\Ulid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class DoctrineUlidType extends Type
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

        $class = $this->getValueObjectClassName();
        if (!$value instanceof Ulid) {
            throw new \InvalidArgumentException(
                sprintf('Expected instance of %s, got %s', $class, get_debug_type($value))
            );
        }

        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        if ($value === null) {
            return null;
        }

        $className = $this->getValueObjectClassName();
        if ($value instanceof $className && $value instanceof Ulid) {
            return $value;
        }

        return new $className($value);
    }
}
