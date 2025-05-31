<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface IClock
{
    public function now(): \DateTimeImmutable;
}
