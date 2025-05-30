<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\Shared\Domain;

use App\Shared\Domain\Email;

class EmailOM
{
    public static function random(): Email
    {
        return new Email(
            sprintf(
                '%s@%s.example',
                bin2hex(random_bytes(5)),
                bin2hex(random_bytes(5))
            )
        );
    }
}
