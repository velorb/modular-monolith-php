<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Shared\Domain;

use App\Shared\Domain\Address;

class AddressOM
{
    public static function create(): Address
    {
        return Address::create(
            '50-300',
            'Wrocław',
            'ul. Wrocławska',
            '1',
            '2'
        );
    }
}
