<?php

declare(strict_types=1);

namespace App\Shared\Domain;

/**
 * @TODO:
 * * This is used for optimistic locking of aggregates. Add optimistic locking mechanism.
 */
trait AggregateVersionTrait
{
    private int $version = 1;
}
