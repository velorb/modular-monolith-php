<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus\Query;

interface IQueryBus
{
    /**
     * @template T
     * @param IQuery<T> $query
     * @return T
     */
    public function ask(IQuery $query): mixed;
}
