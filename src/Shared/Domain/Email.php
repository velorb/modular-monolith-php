<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Exception\DomainException;

readonly class Email implements IStringVO
{
    public function __construct(private string $value)
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException(sprintf('Invalid email address: "%s".', $this->value));
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Email $other): bool
    {
        return strtolower($this->value) === strtolower($other->value);
    }

    public static function fromString(string $value): Email
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
