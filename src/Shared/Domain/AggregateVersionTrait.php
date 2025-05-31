<?php

declare(strict_types=1);

namespace App\Shared\Domain;

/**
 * This is used for optimistic locking of aggregates.
 */
trait AggregateVersionTrait
{
    private int $version = 1;
}
