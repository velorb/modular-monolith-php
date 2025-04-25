<?php

declare(strict_types=1);

namespace App\Tests\Support\Faker;

class UuidFaker
{
    public static function generate(): string
    {
        $data = random_bytes(16);

        // Ustaw wersję (0100 = v4)
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Ustaw variant (10xx)
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
