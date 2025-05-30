<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface IStringVO
{
    public static function fromString(string $value): self;

    public function value(): string;
}
