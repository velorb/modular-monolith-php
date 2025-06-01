<?php

declare(strict_types=1);

namespace App\Shared\Domain;

readonly class Address
{
    private function __construct(
        public ?string $postalCode = null,
        public ?string $city = null,
        public ?string $street = null,
        public ?string $buildingNumber = null,
        public ?string $apartmentNumber = null,
    ) {
    }

    public static function empty(): self
    {
        return new self();
    }

    public static function create(
        string $postalCode,
        string $city,
        ?string $street,
        string $buildingNumber,
        ?string $apartmentNumber,
    ): self {
        return new self(
            $postalCode,
            $city,
            $street,
            $buildingNumber,
            $apartmentNumber,
        );
    }

    public function isEmpty(): bool
    {
        return $this->postalCode === null &&
            $this->city === null &&
            $this->street === null &&
            $this->buildingNumber === null &&
            $this->apartmentNumber === null;
    }

    public function equals(Address $address): bool
    {
        return $this->postalCode === $address->postalCode &&
            $this->city === $address->city &&
            $this->street === $address->street &&
            $this->buildingNumber === $address->buildingNumber &&
            $this->apartmentNumber === $address->apartmentNumber;
    }
}
