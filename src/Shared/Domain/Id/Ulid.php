<?php

declare(strict_types=1);

namespace App\Shared\Domain\Id;

readonly class Ulid
{
    /**
     * @var non-empty-string
     */
    public string $value;

    public function __construct(
        string $value,
    ) {
        if (empty($value)) {
            throw new \DomainException('Value cannot be empty');
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $id): bool
    {
        return $this->value === $id->value;
    }
}
