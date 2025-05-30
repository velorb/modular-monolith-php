<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface IIntegerVO
{
    public static function fromInt(int $value): static;

    public function toInt(): int;
}
