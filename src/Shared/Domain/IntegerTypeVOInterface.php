<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface IntegerTypeVOInterface
{
    public static function fromInt(int $value): static;

    public function toInt(): int;
}
