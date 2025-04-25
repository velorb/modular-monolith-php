<?php

declare(strict_types=1);

namespace App\Shared\Domain\Id;

interface IUlidGenerator
{
    public function new(): Ulid;
}
