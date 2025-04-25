<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Mapping;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class DoctrineUuidType extends Type
{
    private const int UUID_LENGTH = 36;

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
        return $platform->getStringTypeDeclarationSQL([
            'length' => self::UUID_LENGTH,
            'fixed' => true,
        ]);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        $class = $this->getValueObjectClassName();
        if (!$value instanceof $class) {
            throw new \InvalidArgumentException(
                sprintf('Expected instance of %s, got %s', $class, get_debug_type($value))
            );
        }

        return $value->value;
    }

    /**
     * Converts database value to PHP value.
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return object|null
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

        return new $className((string)$value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
